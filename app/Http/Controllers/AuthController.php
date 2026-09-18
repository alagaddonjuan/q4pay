<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Facades\Auth;
use App\Models\Merchant;
use App\Notifications\SecurityAlert;
use Illuminate\Support\Str;
use App\Traits\AuditLogger;

class AuthController extends Controller
{
    use AuditLogger;
    // ========================================================================
    // 1. WEB: Show the Gateway Login Page
    // ========================================================================
    public function showLoginForm()
    {
        return view('authentication.merchant-signin'); 
    }

    // ========================================================================
    // 2. WEB: Show the Gateway Registration Page
    // ========================================================================
    public function showRegistrationForm()
    {
        return view('authentication.merchant-signup');
    }

    // ========================================================================
    // 3. WEB: Process the Gateway Registration
    // ========================================================================
    public function register(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:merchants',
            'password' => 'required|string|min:8',
        ]);

        DB::beginTransaction();

        try {
            // A. Create the core merchant (Satisfies the API Key Not-Null constraint)
            $merchant = Merchant::create([
                'business_name' => $request->business_name,
                'email'         => $request->email,
                'contact_email' => $request->email,
                'password'      => Hash::make($request->password),
                'business_type' => $request->business_type ?? 'corporate',
                'is_active'     => true,
                'q4i_api_key'   => 'q4i_' . \Illuminate\Support\Str::random(40),
                'kyc_status'    => 'pending', // 🟢 Using the strict database-approved word
                'wallet_balance'=> 0.00,
            ]);

            // B. Do NOT insert into merchant_kycs here!
            // The merchant_kycs table is where the actual documents go. 
            // That row should ONLY be created when they submit the actual Compliance Form later!

            // C. Map Keys Instantly To The Isolated api_keys Ledger Table
            DB::table('api_keys')->insert([
                'merchant_id' => $merchant->id,
                'test_public_key' => 'pk_test_' . bin2hex(random_bytes(16)),
                'test_secret_key' => 'sk_test_' . bin2hex(random_bytes(16)),
                'live_public_key' => 'pk_live_' . bin2hex(random_bytes(16)),
                'live_secret_key' => 'sk_live_' . bin2hex(random_bytes(16)),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return redirect()->route('merchant.login')->with('success', 'Registration successful! Please login to complete your KYC.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration Error: ' . $e->getMessage());
            return back()->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }

    // ========================================================================
    // 4. OMNICHANNEL: Process the Corporate Login
    // ========================================================================
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $merchant = Merchant::where('email', $request->email)->first();

        // ---------------------------------------------------------
        // A. API REQUEST LOGIC 
        // ---------------------------------------------------------
        if ($request->wantsJson() || $request->is('api/*')) {
            
            if (!$merchant || !Hash::check($request->password, $merchant->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid email or password.'
                ], 401);
            }

            if (!$merchant->is_active) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Your account is currently inactive. Please contact support.'
                ], 403);
            }

            $token = $merchant->createToken('merchant-dashboard-session')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'data' => [
                    'token' => $token,
                    'merchant' => [
                        'business_name' => $merchant->business_name,
                        'email' => $merchant->email,
                        'wallet_balance' => $merchant->wallet_balance
                    ]
                ]
            ], 200);
        }

        // ---------------------------------------------------------
        // B. WEB BROWSER LOGIN LOGIC
        // ---------------------------------------------------------
        $merchant = Merchant::where('email', $request->email)->first();
        $teamMember = \App\Models\MerchantTeamMember::where('email', $request->email)->first();

        // 1. If it's a team member trying to log in
        if ($teamMember) {
            if ($teamMember->status !== 'active') {
                return back()->withErrors([
                    'email' => 'Your team member account is ' . $teamMember->status . '. Please contact your administrator.'
                ])->onlyInput('email');
            }

            if (Auth::guard('team_member')->attempt(['email' => $request->email, 'password' => $request->password], $request->boolean('remember'))) {
                $request->session()->regenerate();
                
                if ($teamMember->merchant) {
                    $teamMember->merchant->notify(new SecurityAlert(
                        'Team Member Login Alert',
                        'Team member ' . $teamMember->first_name . ' (' . $teamMember->role . ') logged in at ' . now()->toDayDateTimeString(),
                        'login'
                    ));
                }
                
                $this->logAuditAction('login', 'security', 'Successful team member login.');

                return redirect()->intended(route('merchant.dashboard'));
            }
        }

        // 2. If it's a merchant owner trying to log in
        if ($merchant) {
            if (!$merchant->is_active) {
                return back()->withErrors([
                    'email' => 'Your account is currently inactive. Please contact support.'
                ])->onlyInput('email');
            }

            if (Auth::guard('merchant')->attempt(['email' => $request->email, 'password' => $request->password], $request->boolean('remember'))) {
                $request->session()->regenerate();
                
                $merchantUser = \App\Models\Merchant::current();
                $merchantUser->notify(new SecurityAlert(
                    'New Login Alert',
                    'A new login was detected on your Merchant Owner account at ' . now()->toDayDateTimeString(),
                    'login'
                ));
                
                $this->logAuditAction('login', 'security', 'Successful merchant login.');

                return redirect()->intended(route('merchant.dashboard'));
            }
        }

        // 3. If neither worked, return a generic error
        return back()->withErrors([
            'email' => 'These corporate credentials do not match our records.'
        ])->onlyInput('email');
    }

    // ========================================================================
    // 5. SECURE LOGOUT 
    // ========================================================================
    public function logout(Request $request)
    {
        if ($request->wantsJson() || $request->is('api/*')) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out successfully']);
        }

        Auth::guard('merchant')->logout();
        Auth::guard('team_member')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('merchant.login');
    }

    // ========================================================================
    // 6. API UTILITIES (Profile & Password Reset)
    // ========================================================================
    
    public function me(Request $request)
    {
        $merchant = $request->user();

        return response()->json([
            'status' => 'success',
            'data' => [
                'merchant_id' => $merchant->id,
                'business_name' => $merchant->business_name,
                'email' => $merchant->email,
                'wallet_balance' => $merchant->wallet_balance,
                'is_active' => $merchant->is_active,
                'joined_date' => $merchant->created_at->format('M d, Y')
            ]
        ], 200);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $merchant = Merchant::where('email', $request->email)->first();

        // 🟢 ALWAYS return the same success message to prevent user enumeration attacks
        $genericResponse = response()->json([
            'status' => 'success',
            'message' => 'If an account with that email exists, a reset code has been sent.'
        ], 200);

        if (!$merchant) {
            return $genericResponse;
        }

        $otp = random_int(100000, 999999);

        DB::table('merchant_password_reset_tokens')->updateOrInsert(
            ['email' => $merchant->email],
            [
                'token' => Hash::make($otp), 
                'created_at' => now()
            ]
        );

        try {
            Mail::raw("Hello {$merchant->business_name},\n\nYour Q4I Merchant Dashboard password reset code is: {$otp}\n\nThis code will expire in 15 minutes.\n\nIf you did not request this, please ignore this email.", function ($message) use ($merchant) {
                $message->to($merchant->email)
                        ->subject('Q4I Dashboard - Password Reset Code');
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send reset email: ' . $e->getMessage());
            // 🟢 FIXED: Do NOT expose the 500 error to the client, as it leaks user existence.
            // Let it fail silently, only logging the error for the sysadmin.
        }

        return $genericResponse;
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
            'password' => 'required|min:8|confirmed' 
        ]);

        $resetRecord = DB::table('merchant_password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired password reset code.'
            ], 400);
        }

        $createdAt = \Carbon\Carbon::parse($resetRecord->created_at);
        if (now()->diffInMinutes($createdAt) > 15) {
            DB::table('merchant_password_reset_tokens')->where('email', $request->email)->delete();
            
            return response()->json([
                'status' => 'error',
                'message' => 'The reset code has expired. Please request a new one.'
            ], 400);
        }

        if (!Hash::check($request->otp, $resetRecord->token)) {
            return response()->json([
                'status' => 'error',
                'message' => 'The reset code is incorrect.'
            ], 400);
        }

        $merchant = Merchant::where('email', $request->email)->first();
        $merchant->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('merchant_password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Your password has been successfully reset. You can now log in.'
        ], 200);
    }
}