<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\EscrowTransaction;

class VendorSettingsController extends Controller
{
    public function index()
    {
        // Fetch the currently logged-in vendor
        $user = Auth::user();
        
        $google2fa = app(\PragmaRX\Google2FALaravel\Google2FA::class);
        $QR_Image = null;
        $secret = null;

        if (!$user->two_factor_enabled) {
            if (!$user->two_factor_secret) {
                $secret = $google2fa->generateSecretKey();
                $user->two_factor_secret = $secret;
                $user->save();
            } else {
                $secret = $user->two_factor_secret;
            }
            
            $QR_Image = $google2fa->getQRCodeInline(
                'Q4I Vendor Platform',
                $user->email,
                $secret
            );
        }

        return view('dashboard.settings.index', compact('user', 'QR_Image', 'secret'));
    }

    /**
     * Update the Business Profile (Name, Phone, Logo)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // 🔴 SECURITY LOCK: We intentionally DO NOT validate or accept 'address', 'city', 
        // or 'state' here. This ensures logistics coordinates remain strictly read-only 
        // for the vendor, preventing mid-transaction Shipbubble dispatch crashes.
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'store_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;

        // Handle the Logo Upload
        if ($request->hasFile('store_logo')) {
            // Delete the old logo from storage if it exists
            if ($user->store_logo) {
                Storage::disk('public')->delete($user->store_logo);
            }
            // Save the new logo
            $path = $request->file('store_logo')->store('store_logos', 'public');
            $user->store_logo = $path;
        }

        // Handle the Profile Picture Upload
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
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

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * 🟢 Update the Account Login Password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // Standard password security
        ]);

        $user = Auth::user();

        // Verify the old password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password you entered is incorrect.']);
        }

        // Hash and save the new password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Login password updated successfully!');
    }

    /**
     * 🟢 Set or Update the 4-Digit Transaction PIN (The "PIN Shield")
     */
    public function updateTransactionPin(Request $request)
    {
        $request->validate([
            'transaction_pin' => 'required|digits:4', // Strictly enforces a 4-digit number
            'password' => 'required' // Require login password to change the PIN for extra security
        ]);

        $user = Auth::user();

        // Require their normal password to authorize changing the financial PIN
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Invalid account password. Cannot update PIN.']);
        }

        // Save the new PIN to the dedicated transaction_pin column
        $user->transaction_pin = Hash::make($request->transaction_pin);
        $user->save();

        return back()->with('success', 'Your 4-Digit Security PIN has been updated and your wallet is secured!');
    }

    public function verify2FA(Request $request)
    {
        $user = Auth::user();
        $request->validate(['one_time_password' => 'required']);

        $google2fa = app(\PragmaRX\Google2FALaravel\Google2FA::class);
        $valid = $google2fa->verifyKey($user->two_factor_secret, $request->one_time_password);

        if ($valid) {
            $user->two_factor_enabled = true;
            $user->save();
            
            // Mark as verified for current session
            $request->session()->put('2fa_verified', true);
            
            return back()->with('success', '2FA has been successfully enabled.');
        }

        return back()->withErrors(['one_time_password' => 'Invalid authentication code. Please try again.']);
    }

    public function disable2FA(Request $request)
    {
        $user = Auth::user();
        
        $request->validate(['password' => 'required|string']);
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Invalid account password.']);
        }

        $user->two_factor_enabled = false;
        $user->two_factor_secret = null;
        $user->save();

        return back()->with('success', '2FA has been disabled.');
    }

    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        
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
        $user = Auth::user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }
        return response()->json(['status' => 'success']);
    }

    public function paymentLinks()
    {
        // Adjust the view path if your blade file is named differently!
        return view('vendor.payment-links.index'); 
    }

    /**
     * View Vendor Escrow Disputes
     */
    public function disputes()
    {
        // Fetch all escrows for this vendor that have the 'disputed' status
        $disputes = EscrowTransaction::where('vendor_id', Auth::id())
                                     ->where('status', 'disputed')
                                     ->latest()
                                     ->get();

        return view('dashboard.disputes.index', compact('disputes'));
    }
}