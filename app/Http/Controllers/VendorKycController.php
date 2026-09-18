<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\DojahService;

class VendorKycController extends Controller
{
    protected $dojah;

    public function __construct(DojahService $dojah)
    {
        $this->dojah = $dojah;
    }

    public function verifyIdentity(Request $request)
    {
        $request->validate([
            'bvn' => 'required|string|size:11'
        ]);

        $user = Auth::user();

        // 1. Prevent re-verification if they are already locked
        if ($user->kyc_status === 'verified') {
            return back()->withErrors(['error' => 'Your identity is already verified and locked.']);
        }

        // ==========================================
        // 🟢 FORCED LOCAL BYPASS FOR TESTING
        // Uncomment the Dojah section below when going live!
        // ==========================================
        $officialName = 'JOHN DOE';
        $dob = '1990-01-01'; // Required by Techvibs
        $phone = $user->phone ?? '08012345678';
        
        // --- LIVE DOJAH CALL (Commented out for your bypass) ---
        /*
        $verification = $this->dojah->verifyBvn($request->bvn);
        if ($verification['status'] === 'error') {
            return back()->withErrors(['error' => $verification['message']]);
        }
        $officialName = $verification['official_name'];
        $dob = $verification['date_of_birth'] ?? '1990-01-01'; // Ensure Dojah returns DOB
        */
        // -------------------------------------------------------

        // Split name for Techvibs payload
        $nameParts = explode(' ', $officialName);
        $lastName = array_pop($nameParts);
        $otherNames = implode(' ', $nameParts) ?: 'Vendor';

        // ==========================================
        // 2. GENERATE 9PSB VIRTUAL ACCOUNT VIA TECHVIBS
        // ==========================================
        $payload = [
            'bvn' => $request->bvn,
            'dateOfBirth' => $dob,
            'lastName' => $lastName,
            'otherNames' => $otherNames,
            'phoneNo' => $phone,
            'gender' => 0 // Defaulting to 0 as per your previous controller
        ];

        try {
            // Using your master Fintech Token
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . env('TECHVIBES_API_TOKEN', env('TECHVIBES_LIVE_TOKEN')),
                    'Content-Type' => 'application/json'
                ])->post('https://techvibs.com/bank/api_general/bvn_verification_token_api.php', $payload);

            $responseData = $response->json();

            if (!$response->successful() || !isset($responseData['status']) || $responseData['status'] !== 'success') {
                Log::error('Techvibs Vendor VA Creation Failed', ['response' => $responseData]);
                return back()->withErrors(['error' => 'Identity verified, but banking provider failed to generate account. Please try again.']);
            }

            // Extract the new Account details from Allen's API
            $accountNumber = $responseData['api_response']['accountNumber'];
            $bankName = '9PSB';

            // ==========================================
            // 3. THE LOCK: Save everything to the database
            // ==========================================
            DB::beginTransaction();

            DB::table('users')->where('id', $user->id)->update([
                'bvn' => $request->bvn,
                'kyc_verified_name' => $officialName,
                'kyc_status' => 'verified',
                'updated_at' => now(),
            ]);

            // Assuming vendors have a 'vendors' table linked to 'users'. 
            // If they just use the 'merchants' table, change 'vendors' to 'merchants' below.
            DB::table('vendors')->where('user_id', $user->id)->update([
                'bank_name' => $bankName,
                'account_number' => $accountNumber,
                'account_name' => $officialName,
                'updated_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', "Identity verified! Your dedicated $bankName wallet ($accountNumber) is now active.");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Vendor KYC & VA Generation Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'A system error occurred while setting up your banking profile.']);
        }
    }
}