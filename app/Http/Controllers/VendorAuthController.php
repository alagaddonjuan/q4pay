<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Notifications\SecurityAlert;

class VendorAuthController extends Controller
{
    // 1. Show the Social Commerce Login Page
    public function showLoginForm()
    {
        return view('authentication.signin'); 
    }

    // 2. Process Vendor Web Registration
    public function register(Request $request)
    {
        // 1. Validate the exact fields our form is sending (including logistics fields)
        $request->validate([
            'name'       => 'required|string|max:255',
            'store_name' => 'required|string|max:255',
            'phone'      => 'required|string|unique:users,phone',
            'address'    => 'required|string|max:255',
            'city'       => 'required|string|max:255',
            'state'      => 'required|string|max:255',
            'password'   => 'required|string|min:6',
        ]);

        // 2. Use a DB Transaction to securely create all related profiles at once
        DB::beginTransaction();
        try {
            // A. Create the Base User Account with Logistics Data
            $user = User::create([
                'name'       => $request->name,
                'store_name' => $request->store_name,
                'phone'      => $request->phone,
                'address'    => $request->address, // 🔴 Saved to database
                'city'       => $request->city,       // 🔴 Saved to database
                'state'      => $request->state,      // 🔴 Saved to database
                'password'   => Hash::make($request->password),
                'email'      => $request->phone . '@vendor.q4i.com', // Magic key
                'kyc_status' => 'unverified' // Ensure default state is set
            ]);

            // B. Initialize a Zero-Balance Wallet 
            DB::table('wallets')->insert([
                'user_id' => $user->id,
                'balance' => 0.00,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            // 3. Log them in automatically using Door 1 (Web Guard)
            Auth::guard('web')->login($user);
            $request->session()->regenerate();

            // 4. Send them straight to the newly routed dashboard!
            return redirect()->route('vendor.dashboard')->with('success', 'Welcome to Q4I! Your store has been created.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Vendor Registration Crash: ' . $e->getMessage());
            return back()->withErrors(['error' => 'A system error occurred while setting up your store. Please try again.'])->withInput();
        }
    }

    // 3. Process the Login Request
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('web')->attempt(['phone' => $request->phone, 'password' => $request->password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::guard('web')->user();
            $user->notify(new SecurityAlert(
                'New Login Alert',
                'A new login was detected on your Vendor account at ' . now()->toDayDateTimeString(),
                'login'
            ));

            // Redirect to the Social Commerce dashboard!
            return redirect()->intended(route('vendor.dashboard'));
        }

        return back()->withErrors([
            'phone' => 'The provided phone number or password does not match our records.',
        ])->onlyInput('phone');
    }

    // 4. Log them out
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Send them back to the Vendor login page
        return redirect()->route('login');
    }
}