<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Traits\AuditLogger;

class MerchantSettingsController extends Controller
{
    use AuditLogger;
    private function getActiveUser()
    {
        if (Auth::guard('team_member')->check()) {
            return Auth::guard('team_member')->user();
        }
        return Auth::guard('merchant')->user();
    }

    public function index()
    {
        $user = $this->getActiveUser();
        
        $google2fa = app(\PragmaRX\Google2FALaravel\Google2FA::class);
        $QR_Image = null;
        $secret = null;

        if (!$user->two_factor_enabled) {
            $secret = $google2fa->generateSecretKey();
            $user->two_factor_secret = $secret;
            $user->save();
            
            $QR_Image = $google2fa->getQRCodeInline(
                'Q4I Gateway Platform',
                $user->email,
                $secret
            );
        }

        return view('merchant.settings.index', compact('user', 'QR_Image', 'secret'));
    }

    public function updateProfile(Request $request)
    {
        $user = $this->getActiveUser();

        $request->validate([
            'business_name' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($user instanceof \App\Models\Merchant) {
            $user->business_name = $request->business_name;
        } else {
            // It's a team member, just silently ignore the business_name field for now
            // Or update first_name/last_name if those were provided
        }

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_picture);
            }
            $user->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user->save();

        // Send a notification about the profile update
        $user->notify(new \App\Notifications\SecurityAlert(
            'Profile Updated',
            'Your business profile has been successfully updated.',
            'login' // Using login as a generic alert type for now, or could just use a default
        ));

        $this->logAuditAction('updated_profile', 'settings', 'Updated business profile information.');

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = $this->getActiveUser();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password you entered is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        $this->logAuditAction('updated_password', 'settings', 'Updated login password.');

        return back()->with('success', 'Login password updated successfully!');
    }

    public function verify2FA(Request $request)
    {
        $user = $this->getActiveUser();
        $request->validate(['one_time_password' => 'required']);

        $google2fa = app(\PragmaRX\Google2FALaravel\Google2FA::class);
        $valid = $google2fa->verifyKey($user->two_factor_secret, $request->one_time_password);

        if ($valid) {
            $user->two_factor_enabled = true;
            $user->save();
            
            // Mark as verified for current session
            $request->session()->put('2fa_verified', true);
            
            $this->logAuditAction('enabled_2fa', 'security', 'Enabled Two-Factor Authentication.');

            return back()->with('success', '2FA has been successfully enabled.');
        }

        return back()->withErrors(['one_time_password' => 'Invalid authentication code. Please try again.']);
    }

    public function disable2FA(Request $request)
    {
        $user = $this->getActiveUser();
        
        $request->validate(['password' => 'required|string']);
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Invalid account password.']);
        }

        $user->two_factor_enabled = false;
        $user->two_factor_secret = null;
        $user->save();

        $this->logAuditAction('disabled_2fa', 'security', 'Disabled Two-Factor Authentication.');

        return back()->with('success', '2FA has been disabled.');
    }

    public function updateNotifications(Request $request)
    {
        $user = $this->getActiveUser();
        
        $preferences = [
            'login' => $request->has('notify_login'),
            'inflow' => $request->has('notify_inflow'),
            'outflow' => $request->has('notify_outflow'),
            'channel_email' => $request->has('channel_email'),
            'channel_sms' => $request->has('channel_sms'),
            'channel_dashboard' => $request->has('channel_dashboard'),
        ];
        
        $user->notification_preferences = json_encode($preferences);
        $user->save();
        
        return back()->with('success', 'Notification preferences updated successfully!');
    }

    public function markNotificationsRead(Request $request)
    {
        $user = $this->getActiveUser();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }
        return response()->json(['status' => 'success']);
    }

    /**
     * Get current developer settings (API Keys & Webhook URL)
     */
    public function getDeveloperSettings(Request $request)
    {
        $merchant = \App\Models\Merchant::current();

        return response()->json([
            'status' => 'success',
            'data' => [
                'webhook_url' => $merchant->webhook_url,
                // We only show the first few characters of the secret for security
                'webhook_secret_preview' => $merchant->webhook_secret ? substr($merchant->webhook_secret, 0, 8) . '...' : null,
                'q4i_api_key' => $merchant->q4i_api_key,
            ]
        ], 200);
    }

    /**
     * Update the Webhook URL ONLY (Does not expose secret)
     */
    public function updateWebhookSettings(Request $request)
    {
        $merchant = \App\Models\Merchant::current();

        $validated = $request->validate([
            'webhook_url' => 'required|url',
        ]);

        // If they don't have a cryptographic secret yet, generate one automatically
        $secret = $merchant->webhook_secret;
        if (!$secret) {
            $secret = 'q4i_wh_' . bin2hex(random_bytes(16));
            $merchant->webhook_secret = $secret;
        }

        $merchant->webhook_url = $validated['webhook_url'];
        $merchant->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Webhook URL updated successfully.',
            'data' => [
                'webhook_url' => $merchant->webhook_url,
                // Only reveal the full secret if it was newly generated
                'webhook_secret' => $secret === $merchant->webhook_secret ? 'Hidden for security. Rotate to view new secret.' : $secret
            ]
        ], 200);
    }

    /**
     * 🟢 NEW: Emergency Webhook Secret Rotation
     */
    public function rotateWebhookSecret(Request $request)
    {
        $merchant = \App\Models\Merchant::current();

        $validated = $request->validate([
            'password' => 'required|string'
        ]);

        if (!Hash::check($validated['password'], $merchant->password)) {
            return response()->json(['error' => 'Invalid account password.'], 403);
        }

        $newSecret = 'q4i_wh_' . bin2hex(random_bytes(16));
        $merchant->update(['webhook_secret' => $newSecret]);

        $this->logAuditAction('rotated_webhook_secret', 'api_keys', 'Rotated Webhook Secret.');

        return response()->json([
            'status' => 'success',
            'message' => 'Webhook Secret successfully rotated.',
            'data' => [
                'webhook_secret' => $newSecret // Shown once!
            ]
        ], 200);
    }

    /**
     * 🟢 NEW: Emergency API Key Rotation
     */
    public function rotateApiKey(Request $request)
    {
        $merchant = \App\Models\Merchant::current();

        $validated = $request->validate([
            'password' => 'required|string'
        ]);

        if (!Hash::check($validated['password'], $merchant->password)) {
            return response()->json(['error' => 'Invalid account password.'], 403);
        }

        // Generate a new secure API Key format
        $newApiKey = 'q4i_live_' . Str::random(32);
        $merchant->update(['q4i_api_key' => $newApiKey]);

        $this->logAuditAction('rotated_api_key', 'api_keys', 'Rotated API Key.');

        return response()->json([
            'status' => 'success',
            'message' => 'API Key successfully rotated. All traffic using the old key will instantly fail.',
            'data' => [
                'q4i_api_key' => $newApiKey
            ]
        ], 200);
    }

    /**
     * Create or Update the 4-Digit Transaction PIN
     */
    public function setTransactionPin(Request $request)
    {
        $user = $this->getActiveUser();

        $validated = $request->validate([
            'pin' => 'required|digits:4',
            'password' => 'required|string' // Require their account password for security!
        ]);

        // 1. Verify they know their actual login password before letting them change the PIN
        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json(['error' => 'Invalid account password.'], 403);
        }

        // 2. Hash and save the new PIN
        $user->update([
            'transaction_pin' => Hash::make($validated['pin'])
        ]);

        $this->logAuditAction('set_transaction_pin', 'security', 'Set or updated transaction PIN.');

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction PIN has been set successfully.'
        ], 200);
    }
}