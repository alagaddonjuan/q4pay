<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorAuthController extends Controller
{
    public function showVerifyForm(Request $request)
    {
        // Detect if they are a vendor or merchant
        $isMerchant = $request->is('merchant/*') || $request->is('merchant');
        
        $layout = $isMerchant ? 'merchant.layouts.app' : 'layouts.app';
        $title = $isMerchant ? 'Merchant 2FA Verification' : 'Vendor 2FA Verification';
        $postRoute = $isMerchant ? route('merchant.2fa.verify.post') : route('vendor.2fa.verify.post');

        return view('auth.2fa_verify', compact('layout', 'title', 'postRoute'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required|numeric'
        ]);

        $isMerchant = $request->is('merchant/*') || $request->is('merchant');
        $guard = $isMerchant ? 'merchant' : 'web';
        
        $user = Auth::guard($guard)->user();
        
        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($user->two_factor_secret, $request->one_time_password);

        if ($valid) {
            $request->session()->put('2fa_verified', true);
            $redirectRoute = $isMerchant ? 'merchant.dashboard' : 'vendor.dashboard';
            return redirect()->route($redirectRoute)->with('success', 'Two-Factor Authentication successful.');
        }

        return back()->withErrors(['one_time_password' => 'The provided Two-Factor Authentication code is invalid or has expired.']);
    }
}
