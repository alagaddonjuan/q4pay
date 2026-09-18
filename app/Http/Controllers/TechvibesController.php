<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Merchant;
use App\Models\Agent;
use App\Models\VirtualAccount;
use Exception;

class TechvibesController extends Controller
{

    /**
     * Generate an Agent Virtual Account via 9psb (Static)
     */
    public function verifyBvnAndCreateWallet(Request $request)
    {
        // 1. Authenticate the Merchant via API Key in Headers
        $apiKey = $request->header('X-Q4I-API-Key');
        
        if (!$apiKey) {
            return response()->json(['error' => 'Missing Q4I API Key in headers.'], 401);
        }

        $merchant = Merchant::where('q4i_api_key', $apiKey)->where('is_active', true)->first();

        if (!$merchant) {
            return response()->json(['error' => 'Invalid or inactive Merchant API Key.'], 401);
        }

        // 2. Validate the incoming payload from the Merchant
        $validated = $request->validate([
            'merchant_reference' => 'required|string|max:255', 
            'bvn' => 'required|string|size:11',
            'dateOfBirth' => 'required|string', 
            'lastName' => 'required|string',
            'otherNames' => 'required|string',
            'phoneNo' => 'required|string|size:11',
            'gender' => 'nullable|integer|in:0,1', 
            'address' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        $firstName = explode(' ', $validated['otherNames'])[0];
        $fullName = trim($firstName . ' ' . $validated['lastName']);

        // Check if this merchant has already registered this BVN
        $existingAgent = Agent::where('merchant_id', $merchant->id)
                              ->where('bvn', $validated['bvn'])
                              ->first();

        if ($existingAgent && $existingAgent->virtualAccount) {
            return response()->json([
                'message' => 'Account already exists for this agent under this merchant.',
                'merchant_reference' => $existingAgent->merchant_reference,
                'account_number' => $existingAgent->virtualAccount->account_number
            ]);
        }

        // --- Dojah BVN Verification (Soft Check during Sandbox) ---
        $dojahService = new \App\Services\DojahService();
        $dojahResponse = $dojahService->verifyBvn($validated['bvn']);

        if ($dojahResponse['status'] !== 'success') {
            Log::warning('Dojah Verification bypassed due to error: ' . $dojahResponse['message']);
            // We do not block here so you can test 9psb while waiting for Dojah compliance
        }

        // Use the official name from Dojah if available, otherwise fallback to provided name
        $officialName = $dojahResponse['official_name'] ?? $fullName;

        $uniqueRef = 'Q4I_' . time() . '_' . Str::random(6);
        $payload = [
            'transaction' => ['reference' => $uniqueRef],
            'order' => [
                'amount' => 0,
                'currency' => 'NGN',
                'description' => 'Agent Virtual Account Creation',
                'country' => 'NGA',
                'amounttype' => 'ANY'
            ],
            'customer' => [
                'account' => [
                    'name' => substr($officialName, 0, 30), // Max length might apply
                    'type' => 'STATIC'
                ]
            ]
        ];

        // --- X-RAY LOG: OUTGOING ---
        Log::channel('single')->info('9PSB VA OUTGOING', [
            'payload' => $payload,
        ]);

        try {
            $virtualAccountService = new \App\Services\NinePsbVirtualAccountService();
            $responseData = $virtualAccountService->createVirtualAccount($payload);

            // --- X-RAY LOG: INCOMING ---
            Log::channel('single')->info('9PSB VA INCOMING', [
                'response_body' => $responseData
            ]);

            if (isset($responseData['code']) && $responseData['code'] === '00') {
                
                DB::beginTransaction();
                try {
                    // 5. Save Agent to Database (Linked to the Merchant)
                    $agent = Agent::create([
                        'merchant_id' => $merchant->id,
                        'merchant_reference' => $validated['merchant_reference'],
                        'first_name' => $firstName,
                        'last_name' => $validated['lastName'],
                        'phone_number' => $validated['phoneNo'],
                        'email' => $validated['email'] ?? null,
                        'bvn' => $validated['bvn'], // We still store the BVN provided
                        'date_of_birth' => $validated['dateOfBirth'],
                        'gender' => $validated['gender'] ?? 0,
                        'address' => $validated['address'] ?? null,
                    ]);

                    VirtualAccount::create([
                        'agent_id' => $agent->id,
                        'account_number' => $responseData['customer']['account']['number'],
                        'bank_name' => $responseData['customer']['account']['bank'],
                        'customer_id' => '9PSB_CUST_' . $agent->id, // Placeholder since 9psb doesn't use it
                        'order_ref' => $responseData['transaction']['reference'],
                    ]);

                    DB::commit();

                    // 7. Return the standardized Q4I Gateway Response back to the Merchant
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Virtual account generated successfully.',
                        'data' => [
                            'merchant_reference' => $agent->merchant_reference,
                            'account_number' => $responseData['customer']['account']['number'],
                            'bank_name' => $responseData['customer']['account']['bank'],
                            'account_name' => $responseData['customer']['account']['name'] ?? $fullName
                        ]
                    ], 201);

                } catch (Exception $e) {
                    DB::rollBack();
                    return response()->json(['error' => 'Q4I System Error: ' . $e->getMessage()], 500);
                }
            }

            // 8. Handle 9psb Errors Gracefully
            return response()->json([
                'status' => 'failed',
                'error' => 'Virtual Account Creation Failed',
                'details' => $responseData['message'] ?? 'Unknown banking error'
            ], 400);

        } catch (\Exception $e) {
            Log::error('9PSB VA Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Virtual Account service unavailable.'], 500);
        }
    }

    /**
     * Register a Corporate Business and generate a Virtual Account
     */
    public function registerCorporateWallet(Request $request)
    {
        // 1. Authenticate the Q4I Merchant
        $apiKey = $request->header('X-Q4I-API-Key');
        if (!$apiKey) {
            return response()->json(['error' => 'Missing Q4I API Key in headers.'], 401);
        }

        $merchant = Merchant::where('q4i_api_key', $apiKey)->where('is_active', true)->first();
        if (!$merchant) {
            return response()->json(['error' => 'Invalid or inactive Merchant API Key.'], 401);
        }

        // 2. Validate the massive Corporate Payload (Text + Files)
        $validated = $request->validate([
            'merchant_reference' => 'required|string|max:255',
            // Business Info
            'taxIDNo' => 'required|string',
            'businessName' => 'required|string',
            'email' => 'required|email',
            'phoneNo' => 'required|string|size:11',
            'address' => 'required|string',
            'industrialSector' => 'required|string',
            'businessType' => 'required|string',
            'companyRegDate' => 'required|date_format:Y-m-d',
            'registrationNumber' => 'required|string',
            'contactPersonFirstName' => 'required|string',
            'contactPersonLastName' => 'required|string',
            
            // Director Info (Assuming 1 director for now based on API docs)
            'director_firstName' => 'required|string',
            'director_lastName' => 'required|string',
            'director_email' => 'required|email',
            'director_phoneNo' => 'required|string|size:11',
            'director_bvn' => 'required|string|size:11',
            'director_nin' => 'required|string|size:11',
            'director_dateOfBirth' => 'required|date_format:Y-m-d',
            'director_gender' => 'required|string',
            'director_address' => 'required|string',
            'director_nationality' => 'required|string',
            'director_nextOfKinName' => 'required|string',
            'director_nextOfKinPhoneNumber' => 'required|string',
            'director_pep' => 'required|string|in:YES,NO',

            // Files (Max 5MB)
            'cacCertificate' => 'required|file|max:5120',
            'scumlCertificate' => 'required|file|max:5120',
            'utilityBill' => 'required|file|max:5120',
            'proofOfAddressVerification' => 'required|file|max:5120',
            'memart' => 'required|file|max:5120',
            'tinCertificate' => 'required|file|max:5120',
            'cacOrStatusReport' => 'required|file|max:5120',
            'letterOfBoardResolution' => 'required|file|max:5120',
            'director_passportPhoto' => 'required|file|mimes:jpg,jpeg,png|max:5120',
            'director_idCardFront' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // --- Dojah BVN Verification for Director (Soft Check) ---
        $dojahService = new \App\Services\DojahService();
        $dojahResponse = $dojahService->verifyBvn($validated['director_bvn']);

        if ($dojahResponse['status'] !== 'success') {
            Log::warning('Dojah Director Verification bypassed due to error: ' . $dojahResponse['message']);
        }

        // 3. For 9psb, we don't need to send the files to them to just open a virtual account.
        // We will store the files locally (omitted here as it was a TODO in original code)
        // and create the virtual account using the business name.

        $uniqueRef = 'Q4I_CORP_' . time() . '_' . Str::random(6);
        $payload = [
            'transaction' => ['reference' => $uniqueRef],
            'order' => [
                'amount' => 0,
                'currency' => 'NGN',
                'description' => 'Corporate Virtual Account Creation',
                'country' => 'NGA',
                'amounttype' => 'ANY'
            ],
            'customer' => [
                'account' => [
                    'name' => substr($validated['businessName'], 0, 30), // 9psb likely has a length limit
                    'type' => 'STATIC'
                ]
            ]
        ];

        // --- X-RAY LOG: OUTGOING ---
        Log::channel('single')->info('9PSB CORPORATE VA OUTGOING', [
            'businessName' => $validated['businessName'],
            'payload' => $payload
        ]);

        try {
            $virtualAccountService = new \App\Services\NinePsbVirtualAccountService();
            $responseData = $virtualAccountService->createVirtualAccount($payload);

            // --- X-RAY LOG: INCOMING ---
            Log::channel('single')->info('9PSB CORPORATE VA INCOMING', [
                'response_body' => $responseData
            ]);

            // 7. Handle Success
            if (isset($responseData['code']) && $responseData['code'] === '00') {
                
                DB::beginTransaction();
                try {
                    // TODO: Save to your database here. 
                    // We likely need a new `CorporateBusiness` model instead of `Agent`.

                    DB::commit();

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Corporate account generated successfully.',
                        'data' => [
                            'merchant_reference' => $validated['merchant_reference'],
                            'account_number' => $responseData['customer']['account']['number'],
                            'bank_name' => $responseData['customer']['account']['bank'],
                            'business_name' => $responseData['customer']['account']['name'] ?? $validated['businessName'],
                            'customer_id' => null, // Not applicable for 9psb
                        ]
                    ], 201);

                } catch (Exception $e) {
                    DB::rollBack();
                    return response()->json(['error' => 'Q4I System Error: ' . $e->getMessage()], 500);
                }
            }

            // 8. Handle Failure
            return response()->json([
                'status' => 'failed',
                'error' => 'Corporate Registration Failed',
                'details' => $responseData['message'] ?? 'Unknown banking error'
            ], 400);
        } catch (\Exception $e) {
            Log::error('9PSB Corporate VA Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Virtual Account service unavailable.'], 500);
        }
    }

    /**
     * Process Corporate KYC, ping 9psb (Static VA), and update Merchant database
     * 🟢 ADJUSTMENTS MADE HERE: Added rep_phone, rep_gender, rep_other_names for strict NIBSS validation.
     */
    public function processCorporateKyc(Request $request)
    {
        // 1. STRICT PRODUCTION VALIDATION (Matching your exact Blade UI)
        $validated = $request->validate([
            'business_name'       => 'required|string|max:255',
            'business_type'       => 'required|string|max:255',
            'registration_number' => 'required|string|max:255',
            'tax_id'              => 'required|string|max:255',
            'industrial_sector'   => 'required|string|max:255',
            'business_address'    => 'required|string|max:500',
            
            // 🟢 NEW: Added NIBSS validation fields
            'rep_first_name'      => 'required|string|max:255',
            'rep_last_name'       => 'required|string|max:255',
            'rep_other_names'     => 'nullable|string|max:255', 
            'rep_gender'          => 'required|string|in:0,1',
            'rep_phone'           => 'required|string|max:15',
            'rep_bvn'             => 'required|string|size:11',
            'rep_nin'             => 'required|string|size:11',
            'rep_dob'             => 'required|date',
            
            // Production File Validation
            'cac_certificate'     => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'utility_bill'        => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'rep_id_card'         => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $merchant = \Illuminate\Support\Facades\\App\Models\Merchant::current();

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            // --- Dojah BVN Verification for Corporate Rep (Soft Check) ---
            $dojahService = new \App\Services\DojahService();
            $dojahResponse = $dojahService->verifyBvn($validated['rep_bvn']);

            if ($dojahResponse['status'] !== 'success') {
                \Illuminate\Support\Facades\Log::warning('Dojah KYC Verification bypassed: ' . $dojahResponse['message']);
            }

            // 2. SECURE FILE STORAGE
            $cacPath     = $request->file('cac_certificate')->store('kyc_documents', 'local');
            $utilityPath = $request->file('utility_bill')->store('kyc_documents', 'local');
            $idCardPath  = $request->file('rep_id_card')->store('kyc_documents', 'local');

            // 3. STORE FULL CORPORATE DATA IN DB
            \Illuminate\Support\Facades\DB::table('merchant_kycs')->insert([
                'user_id'              => $merchant->id,
                'business_name'        => $validated['business_name'],
                'business_type'        => $validated['business_type'],
                'registration_number'  => $validated['registration_number'],
                'tax_id'               => $validated['tax_id'],
                'industrial_sector'    => $validated['industrial_sector'],
                'business_address'     => $validated['business_address'],
                
                'rep_first_name'       => $validated['rep_first_name'],
                'rep_last_name'        => $validated['rep_last_name'],
                'rep_phone'            => $validated['rep_phone'], // 🟢 Added to DB
                'rep_bvn'              => $validated['rep_bvn'],
                'rep_nin'              => $validated['rep_nin'],
                'rep_dob'              => $validated['rep_dob'],
                
                'cac_certificate_path' => $cacPath,
                'utility_bill_path'    => $utilityPath,
                'rep_id_card_path'     => $idCardPath,
                'status'               => 'pending',
                'created_at'           => now(),
                'updated_at'           => now(),
            ]);

            // 4. 9PSB VIRTUAL ACCOUNT PAYLOAD
            $uniqueRef = 'Q4I_KYC_' . $merchant->id . '_' . time();
            $ninepsbPayload = [
                'transaction' => ['reference' => $uniqueRef],
                'order' => [
                    'amount' => 0,
                    'currency' => 'NGN',
                    'description' => 'Corporate Virtual Account for ' . $validated['business_name'],
                    'country' => 'NGA',
                    'amounttype' => 'ANY'
                ],
                'customer' => [
                    'account' => [
                        'name' => substr($validated['business_name'], 0, 30),
                        'type' => 'STATIC'
                    ]
                ]
            ];

            // 5. FIRE API REQUEST
            $virtualAccountService = new \App\Services\NinePsbVirtualAccountService();
            $responseData = $virtualAccountService->createVirtualAccount($ninepsbPayload);
            
            \Illuminate\Support\Facades\Log::info('9PSB Response: ', $responseData);

           // 6. HANDLE SUCCESS OR FAIL
            if (isset($responseData['code']) && $responseData['code'] === '00') {
                
                $agent0 = \App\Models\Agent::create([
                    'merchant_id'        => $merchant->id,
                    'merchant_reference' => 'MASTER_AGENT_' . time(),
                    'first_name'         => $validated['rep_first_name'],
                    'last_name'          => $validated['rep_last_name'] . ' - ' . $validated['business_name'], 
                    'phone_number'       => $validated['rep_phone'], // Enforces your DB constraint
                    'email'              => $merchant->email,
                    'bvn'                => $validated['rep_bvn'],
                    'date_of_birth'      => $validated['rep_dob'],
                    'address'            => $validated['business_address'],
                    'is_master'          => true 
                ]);

                \App\Models\VirtualAccount::create([
                    'agent_id'       => $agent0->id,
                    'user_id'        => \Illuminate\Support\Facades\DB::table('users')->value('id') ?? 1,
                    
                    'customer_id'    => '9PSB_CUST_' . $agent0->id, 
                    'order_ref'      => $responseData['transaction']['reference'] ?? $uniqueRef,
                    
                    'account_number' => $responseData['customer']['account']['number'],
                    'bank_name'      => $responseData['customer']['account']['bank'] ?? '9PSB',
                    'is_active'      => true,
                ]);

                // 🟢 FIXED: Auto-Unlock the Dashboard! 
                // 1. Mark the KYC documents as approved
                \Illuminate\Support\Facades\DB::table('merchant_kycs')
                    ->where('user_id', $merchant->id)
                    ->update(['status' => 'approved', 'updated_at' => now()]);

                // 2. Mark the main merchant profile as approved to unseal the API Keys and sync Admin data
                \Illuminate\Support\Facades\DB::table('merchants')
                    ->where('id', $merchant->id)
                    ->update([
                        'kyc_status'        => 'approved',
                        'bvn'               => $validated['rep_bvn'],
                        'nin'               => $validated['rep_nin'] ?? null,
                        'cac_number'        => $validated['registration_number'],
                        'tin_number'        => $validated['tax_id'],
                        'cac_document_path' => $cacPath,
                        'utility_bill_path' => $utilityPath
                    ]);

                \Illuminate\Support\Facades\DB::commit();

                return redirect()->route('merchant.compliance.index')
                    ->with('success', 'Corporate profile verified. Virtual Account Provisioned Successfully!');
            }

            // 7. WHITE-LABEL ERROR HANDLING (If it actually failed)
            $errorMessage = $responseData['message'] ?? $responseData['error'] ?? '';
            
            $cleanError = str_ireplace(
                ['9PSB', 'Gateway Error:'], 
                'Q4I Banking Partner', 
                $errorMessage
            );

            if (empty($cleanError)) {
                $cleanError = "Unable to verify corporate identity at this time. Please try again later.";
            }

            throw new \Exception($cleanError);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Q4I KYC Error (Real): ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['api_error' => $e->getMessage()]);
        }
    }

   /**
     * Universal Webhook Listener for Incoming Payments & Commission Engine
     */
    public function handleWebhook(Request $request)
    {
        // 1. Log the exact payload from Techvibes
        Log::info('Techvibes Webhook Received:', $request->all());

        // 2. Extract the data
        $status = $request->input('status'); 
        $orderRef = $request->input('orderReference'); 
        $amountPaid = $request->input('amount');
        $sessionID = $request->input('sessionId') ?? 'Q4I_TXN_' . strtoupper(Str::random(12));

        // 3. Ignore pending/failed notifications
        if (strtolower($status) !== 'successful') {
            return response()->json(['message' => 'Ignored non-success status'], 200);
        }

        // --- Q4I COMMISSION RULES (INFLOW) ---
        $q4iFee = 50.00; // Flat ₦50 fee on all incoming transactions
        
        // Prevent negative balances if someone deposits less than ₦50
        if ($amountPaid <= $q4iFee) {
            $q4iFee = $amountPaid; // Q4I takes the whole amount to cover the fee
            $merchantNet = 0;
        } else {
            $merchantNet = $amountPaid - $q4iFee;
        }

        // 4. Secure the Database update
        DB::beginTransaction();

        try {
            // ==========================================
            // PATH A: PAYMENT LINK / ESCROW CHECKOUT
            // ==========================================
            $order = DB::table('orders')
                ->where('order_ref', $orderRef)
                ->where('status', 'pending') 
                ->lockForUpdate() 
                ->first();

            if ($order) {
                $merchant = DB::table('merchants')->where('user_id', $order->user_id)->first();
                
                if (!$merchant) {
                    DB::rollBack();
                    Log::error('Webhook Error: Order user_id ' . $order->user_id . ' has no corresponding merchant profile.');
                    return response()->json(['message' => 'Merchant profile not found'], 400);
                }

                // Recalculate based on order amount (just in case it differs from webhook amountPaid)
                $orderFee = ($order->amount <= 50) ? $order->amount : 50.00;
                $orderNet = $order->amount - $orderFee;

                $balanceBefore = $merchant->wallet_balance ?? 0;
                $balanceAfter = $balanceBefore + $orderNet; // ADD ONLY THE NET AMOUNT

                // Update Order Status
                DB::table('orders')->where('id', $order->id)->update(['status' => 'paid', 'updated_at' => now()]);

                // Insert into Transactions Ledger
                DB::table('transactions')->insert([
                    'merchant_id' => $merchant->id, 
                    'payment_link_id' => $order->product_id,
                    'virtual_account_id' => null, 
                    'type' => 'credit',
                    'amount' => $orderNet,          // What the merchant gets
                    'fee_charged' => $orderFee,     // What Q4I takes
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceAfter,
                    'session_id' => $sessionID,
                    'status' => 'successful',
                    'remarks' => 'Payment Link Settlement (Net of ₦50 Fee)',
                    'is_swept' => false, 
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Top up Merchant's Wallet Balance
                DB::table('merchants')->where('id', $merchant->id)->update(['wallet_balance' => $balanceAfter]);

                // 🟢 LOG Q4I PROFIT
                if ($orderFee > 0) {
                    DB::table('system_earnings')->insert([
                        'transaction_ref' => $orderRef,
                        'merchant_id' => $merchant->id,
                        'type' => 'inflow_fee',
                        'amount' => $orderFee,
                        'created_at' => now()
                    ]);
                }

                DB::commit();
                return response()->json(['message' => 'Payment Link Webhook processed successfully'], 200);
            }

            // ==========================================
            // PATH B: DIRECT VIRTUAL ACCOUNT DEPOSIT
            // ==========================================
            $virtualAccount = VirtualAccount::where('order_ref', $orderRef)->first();
            
            if ($virtualAccount) {
                $agent = Agent::find($virtualAccount->agent_id);
                $merchant = DB::table('merchants')->where('id', $agent->merchant_id)->first();
                
                $balanceBefore = $merchant->wallet_balance ?? 0;
                $balanceAfter = $balanceBefore + $merchantNet; // ADD ONLY THE NET AMOUNT

                // Insert into Transactions Ledger
                DB::table('transactions')->insert([
                    'merchant_id' => $agent->merchant_id,
                    'virtual_account_id' => $virtualAccount->id, 
                    'agent_id' => $agent->id,
                    'type' => 'credit',
                    'amount' => $merchantNet,       // What the merchant gets
                    'fee_charged' => $q4iFee,       // What Q4I takes
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceAfter,
                    'session_id' => $sessionID,
                    'status' => 'successful',
                    'remarks' => 'VA Deposit (Net of ₦50 Fee)',
                    'is_swept' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Top up Merchant's Balance and Virtual Account Ledger
                DB::table('merchants')->where('id', $agent->merchant_id)->update(['wallet_balance' => $balanceAfter]);
                DB::table('virtual_accounts')->where('id', $virtualAccount->id)->increment('ledger_balance', $merchantNet);

                // 🟢 LOG Q4I PROFIT
                if ($q4iFee > 0) {
                    DB::table('system_earnings')->insert([
                        'transaction_ref' => $orderRef,
                        'merchant_id' => $agent->merchant_id,
                        'type' => 'inflow_fee',
                        'amount' => $q4iFee,
                        'created_at' => now()
                    ]);
                }

                DB::commit();
                return response()->json(['message' => 'Virtual Account Webhook processed successfully'], 200);
            }

            // ==========================================
            // PATH C: DIRECT DEPOSIT TO STATIC CORPORATE ACCOUNT (AGENT 0 FALLBACK)
            // ==========================================
            $destAccountNumber = $request->input('accountNumber') ?? $request->input('destinationAccountNumber'); 

            if ($destAccountNumber) {
                // Find the Merchant who owns this Agent 0 account
                $staticMerchant = clone DB::table('merchants')
                    ->where('techvibes_account_number', $destAccountNumber)
                    ->first(); // Note: adjust column name if you store Agent 0 differently!
                
                if ($staticMerchant) {
                    
                    // 🟢 THE MAGIC RECONCILIATION: Try to find a pending Escrow order 
                    // that matches this EXACT amount for this specific merchant.
                    $pendingOrder = DB::table('escrow_transactions')
                        ->where('vendor_id', $staticMerchant->id)
                        ->where('status', 'awaiting_funds')
                        ->whereRaw('(amount + shipping_fee) = ?', [$amountPaid]) // Matches the unique kobo/naira!
                        ->first();

                    $balanceBefore = $staticMerchant->wallet_balance ?? 0;
                    $balanceAfter = $balanceBefore + $merchantNet; 

                    if ($pendingOrder) {
                        // SCENARIO 1: We found the exact order! Lock the funds in Escrow.
                        
                        // 🟢 THIS IS THE BRIDGE: 
                        // Call the EscrowService to handle the DB updates, Shipbubble, and WhatsApp alerts!
                        $escrowModel = \App\Models\EscrowTransaction::find($pendingOrder->id);
                        if ($escrowModel) {
                            $escrowService = new \App\Services\EscrowService();
                            $escrowService->lockEscrowFunds($escrowModel, $amountPaid);
                        }
                        
                        $remarks = 'Order Paid via Agent 0 (Ref: ' . $pendingOrder->reference . ')';
                    } else {
                        // SCENARIO 2: Someone transferred money, but it doesn't match any pending order.
                        // We still credit the merchant's wallet so the money isn't lost.
                        $remarks = 'General Agent 0 Deposit (No exact order matched)';
                    }

                    // Insert into Transactions Ledger
                    DB::table('transactions')->insert([
                        'merchant_id' => $staticMerchant->id,
                        'virtual_account_id' => null, 
                        'type' => 'credit',
                        'amount' => $merchantNet,       
                        'fee_charged' => $q4iFee,       
                        'balance_before' => $balanceBefore,
                        'balance_after' => $balanceAfter,
                        'session_id' => $sessionID,
                        'status' => 'successful',
                        'remarks' => $remarks, // Tells the dashboard if it was an order or general deposit
                        'is_swept' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Top up Merchant's Master Balance
                    DB::table('merchants')->where('id', $staticMerchant->id)->update(['wallet_balance' => $balanceAfter]);
                    // If this was an Agent 0 deposit, we should credit the ledger for the master agent account
                    $masterVirtualAccount = \App\Models\VirtualAccount::whereHas('agent', function($q) use ($staticMerchant) {
                        $q->where('merchant_id', $staticMerchant->id)->where('is_master', true);
                    })->first();
                    if ($masterVirtualAccount) {
                        DB::table('virtual_accounts')->where('id', $masterVirtualAccount->id)->increment('ledger_balance', $merchantNet);
                    }

                    // 🟢 LOG Q4I PROFIT
                    if ($q4iFee > 0) {
                        DB::table('system_earnings')->insert([
                            'transaction_ref' => $sessionID, // Use SessionID since orderRef might be empty from bank
                            'merchant_id' => $staticMerchant->id,
                            'type' => 'inflow_fee',
                            'amount' => $q4iFee,
                            'created_at' => now()
                        ]);
                    }

                    DB::commit();
                    return response()->json(['message' => 'Agent 0 Webhook processed successfully'], 200);
                }
            }

            // Reference does not exist inside system
            DB::rollBack();
            return response()->json(['message' => 'Transaction Reference not found in Q4I DB'], 200); 

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Q4I Webhook Processing Failed: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error processing webhook'], 500);
        }
    }

    /**
     * Process Merchant Withdrawals / Payouts via Techvibes WAAS9
     */
    public function processPayout(Request $request)
    {
        // 1. Validate the withdrawal request
        $validated = $request->validate([
            'amount' => 'required|numeric|min:100',
            'destination_account' => 'required|string|max:20',
            'destination_bank_code' => 'required|string|max:10',
            'destination_account_name' => 'required|string|max:255',
            'narration' => 'nullable|string|max:100',
        ]);

        $merchant = \Illuminate\Support\Facades\\App\Models\Merchant::current();
        
        // 2. Fetch the Master Source Account
        // We need the Virtual Account linked to this merchant's Master Agent (Agent 0)
        $masterAgent = \App\Models\Agent::where('merchant_id', $merchant->id)->where('is_master', true)->first();
        $sourceAccount = \App\Models\VirtualAccount::where('agent_id', $masterAgent->id)->first();

        if (!$masterAgent || !$sourceAccount) {
            return response()->json(['error' => 'Master Virtual Account not found for this merchant. Please complete KYC.'], 400);
        }

        // 3. Calculate Fees & Check Balance
        $withdrawalAmount = (float) $validated['amount'];
        $q4iOutboundFee = (float) ($merchant->outbound_flat_fee ?? 18.00); 
        $totalDeduction = $withdrawalAmount + $q4iOutboundFee;

        if ($merchant->wallet_balance < $totalDeduction) {
            return response()->json([
                'error' => 'Insufficient funds. Your balance is ₦' . number_format($merchant->wallet_balance, 2) . 
                           ' but you need ₦' . number_format($totalDeduction, 2) . ' (including the ₦' . $q4iOutboundFee . ' transfer fee).'
            ], 400);
        }

        // 4. Generate Unique Transaction Reference
        $txnReference = 'Q4I_OUT_' . time() . rand(100, 999);

        // 5. Prepare 9PSB Transfer Payload
        $payload = [
            'bank_code' => $validated['destination_bank_code'],
            'account_number' => $validated['destination_account'],
            'account_name' => $validated['destination_account_name'],
            'amount' => $withdrawalAmount,
            'reference' => $txnReference,
            'narration' => $validated['narration'] ?? "Q4I Settlement"
        ];

        \Illuminate\Support\Facades\Log::info('Initiating 9PSB Payout:', $payload);

        // 6. Lock the transaction to prevent race conditions (Double-spending)
        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            // 7. Fire the API Call
            $transferService = new \App\Services\NinePsbTransferService();
            $responseData = $transferService->transferToOtherBank($payload);

            \Illuminate\Support\Facades\Log::info('9PSB Payout Response:', $responseData);

            // 8. Handle API Response
            if (isset($responseData['status']) && strtolower($responseData['status']) === 'success') {
                
                $balanceBefore = $merchant->wallet_balance;
                $balanceAfter = $balanceBefore - $totalDeduction;

                // A. Deduct Merchant Balance
                \Illuminate\Support\Facades\DB::table('merchants')
                    ->where('id', $merchant->id)
                    ->update(['wallet_balance' => $balanceAfter]);

                // B. Record in Transactions Ledger (As a DEBIT)
                \Illuminate\Support\Facades\DB::table('transactions')->insert([
                    'merchant_id' => $merchant->id,
                    'virtual_account_id' => $sourceAccount->id,
                    'type' => 'debit',
                    'amount' => $withdrawalAmount,
                    'fee_charged' => $q4iOutboundFee,
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceAfter,
                    'session_id' => $txnReference,
                    'status' => 'successful',
                    'remarks' => 'Withdrawal to ' . $validated['destination_account_name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // C. Log Q4I Profit (The ₦18 Transfer Fee)
                if ($q4iOutboundFee > 0) {
                    \Illuminate\Support\Facades\DB::table('system_earnings')->insert([
                        'transaction_ref' => $txnReference,
                        'merchant_id' => $merchant->id,
                        'type' => 'outflow_fee',
                        'amount' => $q4iOutboundFee,
                        'created_at' => now()
                    ]);
                }

                \Illuminate\Support\Facades\DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Transfer successful.',
                    'data' => [
                        'reference' => $txnReference,
                        'amount' => $withdrawalAmount,
                        'fee' => $q4iOutboundFee,
                        'balance_remaining' => $balanceAfter
                    ]
                ], 200);

            } else {
                // If API fails, rollback so the merchant doesn't lose their money
                \Illuminate\Support\Facades\DB::rollBack();
                return response()->json([
                    'status' => 'failed',
                    'error' => 'Transfer failed at the banking partner.',
                    'details' => $responseData['message'] ?? 'Unknown error'
                ], 400);
            }

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Payout Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error during payout.'], 500);
        }
    }

    /**
     * Handle Asynchronous Auto-Reversals for Failed Withdrawals
     * Techvibes triggers this when a previously "successful" outbound transfer fails at the destination bank.
     */
    public function handleReversalWebhook(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Techvibes Reversal Webhook Received:', $request->all());

        // 1. Extract data from the Techvibes Reversal Payload
        // Note: Check Techvibes documentation to confirm their exact parameter names for reversals
        $status = $request->input('status') ?? $request->input('responseCode');
        $txnReference = $request->input('transactionReference') ?? $request->input('orderRef');

        // Only process if it's explicitly a reversal/failed notification
        $failedStatuses = ['reversed', 'failed', 'declined', 'returned'];
        if (!in_array(strtolower($status), $failedStatuses)) {
            return response()->json(['message' => 'Ignored: Not a reversal status.'], 200);
        }

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            // 2. Find the original successful debit transaction in your ledger
            $transaction = \Illuminate\Support\Facades\DB::table('transactions')
                ->where('session_id', $txnReference)
                ->where('type', 'debit')
                ->where('status', 'successful') // Only reverse it if we actually deducted it
                ->lockForUpdate() // Prevent race conditions
                ->first();

            if (!$transaction) {
                \Illuminate\Support\Facades\DB::rollBack();
                return response()->json(['message' => 'Transaction not found or already reversed.'], 200);
            }

            // 3. Find the Merchant
            $merchant = \Illuminate\Support\Facades\DB::table('merchants')->where('id', $transaction->merchant_id)->first();
            
            if (!$merchant) {
                \Illuminate\Support\Facades\DB::rollBack();
                return response()->json(['error' => 'Merchant not found.'], 400);
            }

            // 4. Calculate the Refund (Principal Amount + The Q4I Transfer Fee)
            $refundTotal = $transaction->amount + $transaction->fee_charged;
            
            $balanceBefore = $merchant->wallet_balance;
            $balanceAfter = $balanceBefore + $refundTotal;

            // 5. Refund the Merchant's Wallet
            \Illuminate\Support\Facades\DB::table('merchants')
                ->where('id', $merchant->id)
                ->update(['wallet_balance' => $balanceAfter]);

            // 6. Mark Original Transaction as Reversed
            \Illuminate\Support\Facades\DB::table('transactions')
                ->where('id', $transaction->id)
                ->update([
                    'status' => 'reversed',
                    'updated_at' => now(),
                    'remarks' => $transaction->remarks . ' [REVERSED BY BANK]'
                ]);

            // 7. Create a Reversal Credit Entry in the Ledger (for accounting clarity)
            \Illuminate\Support\Facades\DB::table('transactions')->insert([
                'merchant_id' => $merchant->id,
                'virtual_account_id' => $transaction->virtual_account_id,
                'type' => 'credit', // Crediting it back
                'amount' => $transaction->amount,
                'fee_charged' => 0, // No fee on refunds
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'session_id' => $txnReference . '_REV', // Append _REV to keep it unique
                'status' => 'successful',
                'remarks' => 'Auto-Reversal Refund for failed transfer',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 8. Deduct the previously recorded Q4I Profit (since the transfer didn't happen)
            if ($transaction->fee_charged > 0) {
                \Illuminate\Support\Facades\DB::table('system_earnings')->insert([
                    'transaction_ref' => $txnReference . '_REV',
                    'merchant_id' => $merchant->id,
                    'type' => 'outflow_reversal',
                    'amount' => -abs($transaction->fee_charged), // Negative amount to balance the books
                    'created_at' => now()
                ]);
            }

            \Illuminate\Support\Facades\DB::commit();
            return response()->json(['message' => 'Auto-reversal processed successfully and merchant refunded.'], 200);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Q4I Reversal Webhook Failed: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error processing reversal'], 500);
        }
    }
}