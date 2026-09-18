<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Models\MerchantKyc;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OnboardingController extends Controller
{
    public function register(Request $request)
    {
        // 1. Dynamic Validation Threshold Checklist
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:merchants,email',
            'password' => 'required|string|min:8',
            'business_type' => 'required|in:individual,corporate',
            
            // Globally Required Compliance Attributes
            'bvn' => 'required|string|size:11',
            'utility_bill' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            
            // Conditional Domain Validations
            'nin' => 'required_if:business_type,individual|string|size:11|nullable',
            'cac_number' => 'required_if:business_type,corporate|string|nullable',
            'tin_number' => 'required_if:business_type,corporate|string|nullable',
            'cac_document' => 'required_if:business_type,corporate|file|mimes:pdf,jpg,jpeg,png|max:5120',
            
            // Functional Flags
            'request_vas' => 'nullable|boolean'
        ]);

        // 2. SECURE LOCAL ISOLATION (PII Protection Fix)
        $utilityBillPath = $request->file('utility_bill')->store('kyc_documents', 'local');
        
        $cacDocumentPath = null;
        if ($request->hasFile('cac_document')) {
            $cacDocumentPath = $request->file('cac_document')->store('kyc_documents', 'local');
        }

        // 3. Automated Sandbox Keys Structure Generator
        $testPublicKey  = 'pk_test_' . bin2hex(random_bytes(16));
        $testSecretKey  = 'sk_test_' . bin2hex(random_bytes(16));
        $livePublicKey  = 'pk_live_' . bin2hex(random_bytes(16));
        $liveSecretKey  = 'sk_live_' . bin2hex(random_bytes(16));

        // 4. Inbound VAS Router Logic Engine
        $vasRequested = false;
        if ($validated['business_type'] === 'individual') {
            $vasRequested = true; 
        } else {
            $vasRequested = $request->boolean('request_vas');
        }

        // 5. ACID TRANSACTION ENFORCEMENT ENGINE
        DB::beginTransaction();
        try {
            // A. Create Core Merchant Authentication Anchor
            $merchant = Merchant::create([
                'business_name' => $validated['business_name'],
                'email' => $validated['email'],
                'contact_email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'business_type' => $validated['business_type'],
                'vas_requested' => $vasRequested,
                'kyc_status' => 'unverified', // 🟢 FIXED: Force core table status to unverified on creation
                'is_active' => false 
            ]);

            // B. SCHEMA FIX: Inject Records Into The Separate merchant_kycs Ledger Table
            DB::table('merchant_kycs')->insert([
                'user_id' => $merchant->id,
                'business_name' => $validated['business_name'],
                'business_type' => $validated['business_type'],
                'registration_number' => $validated['cac_number'] ?? null,
                'tax_id' => $validated['tin_number'] ?? null,
                'industrial_sector' => 'Unassigned',
                'business_address' => 'Pending Complete Setup',
                'rep_first_name' => $validated['business_name'],
                'rep_last_name' => 'Representative',
                'rep_bvn' => $validated['bvn'],
                'rep_nin' => $validated['nin'] ?? null,
                'rep_dob' => now()->subYears(18)->format('Y-m-d'), 
                'status' => 'unverified', // 🟢 FIXED: Changed from 'pending' to 'unverified'
                'cac_certificate_path' => $cacDocumentPath,
                'utility_bill_path' => $utilityBillPath,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // C. SCHEMA FIX: Map Keys Instantly To The Isolated api_keys Ledger Table
            DB::table('api_keys')->insert([
                'merchant_id' => $merchant->id,
                'test_public_key' => $testPublicKey,
                'test_secret_key' => $testSecretKey,
                'live_public_key' => $livePublicKey,
                'live_secret_key' => $liveSecretKey,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            // 6. Generate Sanctioned Sanctum Access Session Token
            $token = $merchant->createToken('merchant_dashboard_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Registration completed successfully. Core gateway nodes are now undergoing compliance auditing.',
                'data' => [
                    'merchant_id' => $merchant->id,
                    'business_name' => $merchant->business_name,
                    'business_type' => $merchant->business_type,
                    'kyc_status' => 'unverified', // 🟢 FIXED (Line 120): Changed from 'pending' to 'unverified'
                    'vas_requested' => $merchant->vas_requested,
                    'dashboard_token' => $token,
                    'sandbox_api_keys' => [
                        'public_key' => $testPublicKey,
                        'secret_key' => $testSecretKey
                    ]
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical("Onboarding Sequence Failure: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'System interface failure during profile provisioning. Execution safely aborted.'
            ], 500);
        }
    }
}