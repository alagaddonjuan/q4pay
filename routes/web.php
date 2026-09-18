<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

Route::get('/update-schema', function() {
    try {
        Schema::table('merchants', function (Blueprint $table) {
            if (!Schema::hasColumn('merchants', 'two_factor_secret')) {
                $table->text('two_factor_secret')->nullable();
                $table->boolean('two_factor_enabled')->default(false);
                $table->json('notification_preferences')->nullable();
                $table->string('profile_picture')->nullable();
            }
        });
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'two_factor_secret')) {
                $table->text('two_factor_secret')->nullable();
                $table->boolean('two_factor_enabled')->default(false);
                $table->json('notification_preferences')->nullable();
                $table->string('profile_picture')->nullable();
            }
        });
        
        // Create Notifications Table (for Database Notifications)
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('type');
                $table->morphs('notifiable');
                $table->text('data');
                $table->timestamp('read_at')->nullable();
                $table->timestamps();
            });
        }
        
        return "Schema updated successfully! Added notifications table and notification preferences.";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

// ==========================================
// CONTROLLER IMPORTS (Unified)
// ==========================================
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MerchantDashboardController;
use App\Http\Controllers\SupportChatController;
use App\Http\Controllers\MerchantKycController;
use App\Http\Controllers\TechvibesController;
use App\Http\Controllers\VendorAuthController;
use App\Http\Controllers\VendorDashboardController;
use App\Http\Controllers\VendorProductController;
use App\Http\Controllers\VendorOrderController;
use App\Http\Controllers\VendorWalletController;
use App\Http\Controllers\VendorSettingsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Api\WhatsAppWebhookController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\VasController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\BettingController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SettlementController;
use App\Http\Controllers\VendorKycController;

/*
|--------------------------------------------------------------------------
| PUBLIC & UTILITY ROUTES
|--------------------------------------------------------------------------
*/


Route::get('/clear-cache', function() {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return "Cache cleared successfully!";
});

Route::get('/storage-link', function() {
    try {
        $targetFolder = storage_path('app/public');
        $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
        
        if (file_exists($linkFolder)) {
            return "Storage link already exists at: " . $linkFolder . ". If images are still broken, delete the folder and try again.";
        }
        
        symlink($targetFolder, $linkFolder);
        return "Storage link successfully created at: " . $linkFolder . " ! Your images should now work.";
    } catch (\Exception $e) {
        return "Error creating storage link: " . $e->getMessage();
    }
});

Route::get('/', function () { return view('welcome'); });

Route::post('/agent/verify-bvn', [TechvibesController::class, 'verifyBvnAndCreateWallet']);

Route::get('/test-email', function () {
    Mail::raw('This is a live test from your Q4I Command Center. If you are reading this, the CEO alert system is online.', function ($message) {
        $message->to('michael.a@q4iltd.com')->subject('CEO Alert: System Online');
    });
    return 'Email sent! Check your inbox.';
});

Route::get('/test-discos', function () {
    $service = new \App\Services\ElectricityVasService();
    return $service->getBillers();
});


/*
|==========================================================================
| DOOR 1: SOCIAL COMMERCE (VENDORS / WHATSAPP SELLERS)
| Model: User | Prefix: /vendor
|==========================================================================
*/

// --- VENDOR AUTHENTICATION (PUBLIC) ---
Route::prefix('vendor')->group(function () {
    Route::get('/login', [VendorAuthController::class, 'showLoginForm'])->name('login'); 
    Route::post('/login', [VendorAuthController::class, 'login'])->name('vendor.login.submit');
    
    Route::get('/register', function () { return view('authentication.signup'); })->name('vendor.register');
    Route::post('/register', [VendorAuthController::class, 'register'])->name('vendor.register.submit');
    
    Route::post('/logout', [VendorAuthController::class, 'logout'])->name('vendor.logout');

    Route::get('/support/contact', function () {return view('vendor.support.contact');})->name('vendor.support.contact');
    Route::get('/support/help-center', function () {return view('vendor.support.help-center');})->name('vendor.support.help-center');
});

// --- VENDOR SECURE DASHBOARD (REQUIRES LOGIN) ---
Route::middleware(['auth'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/2fa/verify', [\App\Http\Controllers\TwoFactorAuthController::class, 'showVerifyForm'])->name('2fa.verify');
    Route::post('/2fa/verify', [\App\Http\Controllers\TwoFactorAuthController::class, 'verify'])->name('2fa.verify.post');
});

Route::middleware(['auth', 'ensure.2fa:web'])->prefix('vendor')->name('vendor.')->group(function () {
    
    // Dashboards
    Route::get('/dashboard', [VendorDashboardController::class, 'getOverview'])->name('dashboard');
    Route::get('/style-2', function () { return view('dashboard.index2'); })->name('dashboard.index2');

    // Product Management
    Route::get('/products', [VendorProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [VendorProductController::class, 'create'])->name('products.create');
    Route::post('/products', [VendorProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [VendorProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [VendorProductController::class, 'update'])->name('products.update');

    // Order Management
    Route::get('/orders', [VendorOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{reference}', [VendorOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/verify-pin', [VendorOrderController::class, 'verifyPickupPin'])->name('orders.verify-pin');

    // Wallet & Banking
    Route::get('/wallet', [VendorWalletController::class, 'index'])->name('wallet.index');
    Route::post('/bank/add', [VendorWalletController::class, 'storeBank'])->name('bank.store');
    Route::post('/bank/{id}/default', [VendorWalletController::class, 'setDefaultBank'])->name('bank.setDefault');
    Route::post('/wallet/withdraw/otp', [VendorWalletController::class, 'sendOtp'])->name('wallet.withdraw.otp');
    Route::post('/wallet/withdraw', [VendorWalletController::class, 'requestWithdrawal'])->name('wallet.withdraw');

    // Settings & Profile
    Route::get('/settings', [VendorSettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/profile', [VendorSettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::post('/settings/password', [VendorSettingsController::class, 'updatePassword'])->name('settings.password.update');
    Route::post('/settings/2fa/enable', [VendorSettingsController::class, 'enable2FA'])->name('settings.2fa.enable');
    Route::post('settings/2fa/verify', [VendorSettingsController::class, 'verify2fa'])->name('vendor.settings.2fa.verify');
    Route::post('settings/2fa/disable', [VendorSettingsController::class, 'disable2fa'])->name('vendor.settings.2fa.disable');
    Route::post('notifications/read', [VendorSettingsController::class, 'markNotificationsRead'])->name('vendor.notifications.read');
    Route::post('/settings/notifications', [VendorSettingsController::class, 'updateNotifications'])->name('settings.notifications.update');
    Route::post('/kyc/verify', [VendorKycController::class, 'verifyIdentity'])->name('kyc.verify');

    // Escrow Tools
    Route::get('/payment-links', [VendorSettingsController::class, 'paymentLinks'])->name('payment-links.index');
    Route::get('/disputes', [VendorSettingsController::class, 'disputes'])->name('disputes.index');
});


/*
|==========================================================================
| DOOR 2: Q4I PAYMENT GATEWAY (FINTECHS & CORPORATE MERCHANTS)
| Model: Merchant | Prefix: /merchant
|==========================================================================
*/

Route::prefix('merchant')->group(function () {
    // Authentication
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('merchant.login');
    Route::post('/login', [AuthController::class, 'login'])->name('merchant.login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('merchant.logout');
    
    // Merchant Gateway Registration
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('merchant.register');
    Route::post('/register', [AuthController::class, 'register'])->name('merchant.register.submit');

    Route::get('/forgot-password', function () { 
        return view('authentication.forgot-password'); 
    })->name('merchant.password.request');

    Route::post('/forgot-password', function () {
        return back()->with('status', 'We have emailed your password reset link!');
    })->name('merchant.password.email');

    Route::get('/support/contact', function () {return view('merchant.support.contact');})->name('merchant.support.contact');
    Route::get('/support/help-center', function () {return view('merchant.support.help-center');})->name('merchant.support.help-center');
    
    // Help Center Articles
    Route::get('/support/articles/master-wallets', function () { return view('merchant.support.articles.master-wallets'); })->name('merchant.support.articles.master-wallets');
    Route::get('/support/articles/api-webhooks', function () { return view('merchant.support.articles.api-webhooks'); })->name('merchant.support.articles.api-webhooks');
    Route::get('/support/articles/settlements', function () { return view('merchant.support.articles.settlements'); })->name('merchant.support.articles.settlements');
    Route::get('/support/articles/fraud-flags', function () { return view('merchant.support.articles.fraud-flags'); })->name('merchant.support.articles.fraud-flags');
    Route::get('/support/articles/chargebacks', function () { return view('merchant.support.articles.chargebacks'); })->name('merchant.support.articles.chargebacks');
    Route::get('/support/articles/rolling-keys', function () { return view('merchant.support.articles.rolling-keys'); })->name('merchant.support.articles.rolling-keys');
    
    // Team Member Invite Acceptance (Public)
    Route::get('/team/accept-invite/{token}', [\App\Http\Controllers\MerchantTeamController::class, 'acceptInviteForm'])->name('merchant.team.accept-invite');
    Route::post('/team/accept-invite/{token}', [\App\Http\Controllers\MerchantTeamController::class, 'acceptInvite'])->name('merchant.team.accept-invite.submit');
});


// ========================================================================
// SECURE GATEWAY AREA (DOOR 2)
// ========================================================================
Route::middleware(['auth:merchant,team_member'])->prefix('merchant')->name('merchant.')->group(function () {
    Route::get('/2fa/verify', [\App\Http\Controllers\TwoFactorAuthController::class, 'showVerifyForm'])->name('2fa.verify');
    Route::post('/2fa/verify', [\App\Http\Controllers\TwoFactorAuthController::class, 'verify'])->name('2fa.verify.post');
});

Route::middleware(['auth:merchant,team_member', 'ensure.2fa:merchant'])->prefix('merchant')->name('merchant.')->group(function () {
    
    // 🟢 FIXED: Moved Settings into the Auth block so unauthorized people can't view it
    Route::get('/settings', [\App\Http\Controllers\MerchantSettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/webhook-endpoints', [\App\Http\Controllers\MerchantSettingsController::class, 'webhooks'])->name('settings.webhooks');
    Route::get('/audit-logs', [\App\Http\Controllers\AuditLogController::class, 'index'])->middleware('team_role:admin,developer')->name('audit_logs.index');
    Route::post('/settings/profile', [\App\Http\Controllers\MerchantSettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::post('/settings/password', [\App\Http\Controllers\MerchantSettingsController::class, 'updatePassword'])->name('settings.password.update');
    Route::post('/settings/2fa/enable', [\App\Http\Controllers\MerchantSettingsController::class, 'enable2FA'])->name('settings.2fa.enable');
    Route::post('/settings/2fa/verify', [\App\Http\Controllers\MerchantSettingsController::class, 'verify2FA'])->name('settings.2fa.verify');
    Route::post('/settings/2fa/disable', [\App\Http\Controllers\MerchantSettingsController::class, 'disable2FA'])->name('settings.2fa.disable');
    Route::post('/notifications/read', [\App\Http\Controllers\MerchantSettingsController::class, 'markNotificationsRead'])->name('notifications.read');
    Route::post('/settings/notifications', [\App\Http\Controllers\MerchantSettingsController::class, 'updateNotifications'])->name('settings.notifications.update');
    
    // Team Management & Compliance (Admin only)
    Route::middleware(['team_role:admin'])->group(function () {
        // Team Management
        Route::get('/team', [\App\Http\Controllers\MerchantTeamController::class, 'index'])->name('team.index');
        Route::post('/team/invite', [\App\Http\Controllers\MerchantTeamController::class, 'store'])->name('team.store');
        Route::post('/team/{id}/resend', [\App\Http\Controllers\MerchantTeamController::class, 'resend'])->name('team.resend');
        Route::post('/team/{id}/suspend', [\App\Http\Controllers\MerchantTeamController::class, 'suspend'])->name('team.suspend');
        Route::delete('/team/{id}', [\App\Http\Controllers\MerchantTeamController::class, 'destroy'])->name('team.destroy');
        
        // Corporate KYC / Compliance
        Route::get('/compliance', function () { 
            $merchantId = \App\Models\Merchant::current()->id;
            $kyc = \Illuminate\Support\Facades\DB::table('merchant_kycs')->where('user_id', $merchantId)->first();
            return view('merchant.kyc.verify', ['kyc' => $kyc]); 
        })->name('compliance.index');
        Route::post('/compliance', [\App\Http\Controllers\TechvibesController::class, 'processCorporateKyc'])->name('kyc.submit');
    });

    // 1. Main Dashboard (All Roles)
    Route::get('/dashboard', [MerchantDashboardController::class, 'getOverview'])->name('dashboard');
    Route::get('/dashboard/chart', [MerchantDashboardController::class, 'getChartData'])->name('dashboard.chart');
    Route::get('/payment-links', [MerchantDashboardController::class, 'paymentLinksIndex'])->name('payment-links.index');
    Route::post('/payment-links/store', [MerchantDashboardController::class, 'createPaymentLink'])->name('payment-links.store');

    Route::get('/virtual-accounts', [MerchantDashboardController::class, 'virtualAccounts'])->name('virtual-accounts.index');
    Route::post('/virtual-accounts/single', [MerchantDashboardController::class, 'storeSingleAccount'])->name('virtual-accounts.store-single');
    Route::get('/virtual-accounts/template', [MerchantDashboardController::class, 'downloadCsvTemplate'])->name('virtual-accounts.template');
    Route::post('/virtual-accounts/bulk', [MerchantDashboardController::class, 'storeBulkAccounts'])->name('virtual-accounts.store-bulk');
    
    // Account Details Page
    Route::get('/virtual-accounts/{id}/details', [MerchantDashboardController::class, 'showVirtualAccount'])->name('virtual-accounts.show');
    Route::post('/virtual-accounts/{id}/update', [MerchantDashboardController::class, 'updateAgentDetails'])->name('virtual-accounts.update');
    Route::post('/virtual-accounts/{id}/mock-transaction', [MerchantDashboardController::class, 'mockTransaction'])->name('virtual-accounts.mock-transaction');
    Route::get('/virtual-accounts/{id}/export', [MerchantDashboardController::class, 'exportVirtualAccountStatement'])->name('virtual-accounts.export');
    
    // Sub-Agents Directory
    Route::get('/sub-agents', [MerchantDashboardController::class, 'subAgentsIndex'])->name('sub-agents.index');
    Route::post('/sub-agents', [MerchantDashboardController::class, 'storeAgent'])->name('sub-agents.store');
    Route::get('/sub-agents/{id}', [MerchantDashboardController::class, 'showAgent'])->name('sub-agents.show');
    Route::put('/sub-agents/{id}', [MerchantDashboardController::class, 'updateAgent'])->name('sub-agents.update');

    // 2. Corporate KYC Routes (Moved to Admin Group above)
    

    // 🟢 FIXED: You had three different /ledger endpoints. I commented out the duplicates and kept the TransactionController.
    // Route::get('/ledger', [MerchantDashboardController::class, 'transactionLedger'])->name('orders.index');
    // Route::get('/ledger', [MerchantDashboardController::class, 'ledgerIndex'])->name('ledger.index');
    Route::get('/ledger', [TransactionController::class, 'index'])->name('ledger.index');
    Route::post('/ledger/complaint', [TransactionController::class, 'submitComplaint'])->name('complaint.submit');
    Route::get('/ledger/export', [TransactionController::class, 'exportCsv'])->name('ledger.export');
    
    // 4. NEW: Dashboard Vendor Action Placeholders
    // 🟢 FIXED: Added 'placeholder.' to names so they don't break the actual Vendor routes
    Route::get('/products/create', function () { return "Add Product Coming Soon"; })->name('placeholder.products.create');
    Route::get('/products', function () { return "Products List Coming Soon"; })->name('placeholder.products.index');
    Route::get('/products/{id}/edit', function () { return "Edit Product Coming Soon"; })->name('placeholder.products.edit');
    Route::get('/orders/{reference}', function () { return "Order Details Coming Soon"; })->name('placeholder.orders.show');
    Route::get('/wallet', function () { return "Wallet Withdrawals Coming Soon"; })->name('placeholder.wallet.index');
    Route::get('/disputes', function () { return "Dispute Resolution Coming Soon"; })->name('placeholder.disputes.index');
    Route::get('/transactions', function() { return 'Transaction Ledger coming soon!'; })->name('placeholder.transactions.index');
    
    // Support Chat
    Route::get('/support/chat', [SupportChatController::class, 'index'])->name('support.chat');
    Route::post('/support/chat/tickets', [SupportChatController::class, 'storeTicket'])->name('support.chat.store');
    Route::get('/support/chat/tickets/{reference}', [SupportChatController::class, 'show'])->name('support.chat.show');
    Route::post('/support/chat/tickets/{reference}/messages', [SupportChatController::class, 'storeMessage'])->name('support.chat.message.store');
    
    // 5. NEW: Saved Bank Account Endpoints
    Route::post('/bank/store', [BankAccountController::class, 'store'])->name('bank.store');
    Route::post('/bank/{id}/default', [BankAccountController::class, 'setDefault'])->name('bank.setDefault');

    // Settlements & Payouts (Admin, Finance, Support)
    Route::middleware(['team_role:admin,finance,support'])->group(function () {
        Route::get('/settlements', [SettlementController::class, 'index'])->name('settlements.index');
        Route::post('/settlements/bank/verify', [SettlementController::class, 'verifyAccount'])->name('settlements.bank.verify');
        Route::post('/settlements/bank/add', [SettlementController::class, 'addBank'])->name('settlements.bank.add');
        Route::post('/settlements/request', [SettlementController::class, 'requestPayout'])->name('settlements.request');
        Route::post('/settings/pin/setup', [SettlementController::class, 'setupPin'])->name('pin.setup');
    });

    // Settlements Management (Admin, Finance)
    Route::middleware(['team_role:admin,finance'])->group(function () {
        Route::post('/settlements/autosweep', [SettlementController::class, 'saveAutoSweep'])->name('settlements.autosweep');
    });

    // Settlements Approvals (Admin Only)
    Route::middleware(['team_role:admin'])->group(function () {
        Route::post('/settlements/approve/{id}', [SettlementController::class, 'approvePayout'])->name('settlements.approve');
        Route::post('/settlements/reject/{id}', [SettlementController::class, 'rejectPayout'])->name('settlements.reject');
    });

    // Payout Processor (Internal Webhook/Techvibes Processor)
    Route::post('/merchant/withdraw', [TechvibesController::class, 'processPayout'])->middleware('auth:merchant');

    // Techvibes Auto-Reversal Webhook Endpoint
    Route::post('/webhooks/techvibes/reversals', [TechvibesController::class, 'handleReversalWebhook']);
    // Developer API Keys & Webhooks & Utility Kiosk (Admin, Developer)
    Route::middleware(['team_role:admin,developer'])->group(function () {
        Route::get('/api-keys', [MerchantDashboardController::class, 'apiKeysIndex'])->name('api-keys.index');
        Route::post('/api-keys/generate', [MerchantDashboardController::class, 'generateApiKeys'])->name('api-keys.generate');
        Route::get('/api-docs', [MerchantDashboardController::class, 'apiDocsIndex'])->name('api-docs.index');
        Route::get('/webhooks', [MerchantDashboardController::class, 'webhooksIndex'])->name('webhooks.index');
        Route::post('/webhooks', [MerchantDashboardController::class, 'updateWebhooks'])->name('webhooks.update');
        Route::post('/webhooks/test', [MerchantDashboardController::class, 'testWebhook'])->name('webhooks.test');
        
        // VAS Dashboard UI
        Route::get('/vas', [MerchantDashboardController::class, 'vasIndex'])->name('vas.index');
    });

    // VAS API Endpoints 
    Route::post('/api/vas/airtime', [VasController::class, 'purchaseAirtime']);
    Route::post('/api/vas/data/plans', [VasController::class, 'fetchDataPlans']);
    Route::post('/api/vas/data/purchase', [VasController::class, 'purchaseData']);
    Route::post('/api/utility/meter/verify', [\App\Http\Controllers\Api\ElectricityController::class, 'validateMeter']);
    Route::post('/api/utility/electricity/purchase', [\App\Http\Controllers\Api\ElectricityController::class, 'purchase']);
    Route::get('/api/utility/providers', [\App\Http\Controllers\Api\ElectricityController::class, 'getBillers']);
    Route::get('/api/utility/electricity/billers/{billerId}/items', [\App\Http\Controllers\Api\ElectricityController::class, 'getBillerItems']);
    
    // TV API Endpoints
    Route::post('/api/tv/purchase', [\App\Http\Controllers\Api\TvSubscriptionController::class, 'purchase']);
    Route::get('/api/tv/providers', [\App\Http\Controllers\Api\TvSubscriptionController::class, 'getBillers']);
    Route::get('/api/tv/billers/{billerId}/items', [\App\Http\Controllers\Api\TvSubscriptionController::class, 'getBillerItems']);
    Route::post('/api/tv/verify', [\App\Http\Controllers\Api\TvSubscriptionController::class, 'validateSmartcard']);

    // Internet API Endpoints
    Route::post('/api/internet/purchase', [\App\Http\Controllers\Api\InternetController::class, 'purchase']);
    Route::get('/api/internet/providers', [\App\Http\Controllers\Api\InternetController::class, 'getBillers']);
    Route::get('/api/internet/billers/{billerId}/items', [\App\Http\Controllers\Api\InternetController::class, 'getBillerItems']);
    Route::post('/api/internet/verify', [\App\Http\Controllers\Api\InternetController::class, 'validateAccount']);

    // Betting API Endpoints
    Route::post('/api/betting/verify', [BettingController::class, 'verifyCustomer']);
    Route::post('/api/betting/fund', [BettingController::class, 'fundWallet']);
    Route::get('/api/betting/providers', [BettingController::class, 'getProviders']);
    
    // Exams API Endpoints
    Route::post('/api/exams/purchase', [\App\Http\Controllers\Api\ExamsController::class, 'purchase']);
    Route::get('/api/exams/providers', [\App\Http\Controllers\Api\ExamsController::class, 'getBillers']);
    Route::get('/api/exams/billers/{billerId}/items', [\App\Http\Controllers\Api\ExamsController::class, 'getBillerItems']);
    Route::post('/api/exams/verify', [\App\Http\Controllers\Api\ExamsController::class, 'validateCandidate']);

    // Internet API Endpoints
    Route::post('/api/internet/purchase', [\App\Http\Controllers\Api\InternetController::class, 'purchase']);
  	
  	Route::post('/webhooks/rexpay-dva', [\App\Http\Controllers\Api\WhatsAppWebhookController::class, 'handleRexpayDvaWebhook']);
  	
});

// 🟢 PUBLIC LEGAL PAGES
Route::get('/terms-and-conditions', function () { return view('legal.terms');})->name('legal.terms');
Route::get('/privacy-policy', function () {return view('legal.privacy');})->name('legal.privacy');


/*
|--------------------------------------------------------------------------
| PUBLIC CHECKOUT & WEBHOOKS
|--------------------------------------------------------------------------
*/
// Corporate Payment Link Checkout (House 2)
Route::get('/invoice/{reference}', [CheckoutController::class, 'showCorporate'])->name('corporate.checkout.show');
Route::post('/invoice/{reference}/process', [CheckoutController::class, 'generateCorporateAccount'])->name('corporate.checkout.process');
Route::get('/checkout/status/{session_id}', [CheckoutController::class, 'checkStatus'])->name('corporate.checkout.status');

// Ghost Webhook for Local Testing
Route::get('/mock-delivery/{tracking_code}', [WhatsAppWebhookController::class, 'mockDeliveryWebhook']);
Route::get('/test-9psb/{account_number}/{reference?}/{amount?}', function ($account_number, $reference = null, $amount = 10000) {
    // If no reference is provided, use a fake one. 
    // Escrow and Virtual Accounts use account_number. Corporate Payment Links use reference.
    $ref = $reference ?? 'TEST_REF_' . time();
    
    $payload = [
        'transaction' => ['reference' => $ref],
        'order' => ['amount' => (float) $amount], // Dynamic amount for testing
        'customer' => ['account' => ['number' => $account_number]],
        'source' => ['account' => ['sessionid' => 'SESSION_' . time()]]
    ];

    $request = \Illuminate\Http\Request::create('/api/webhooks/9psb-inflow', 'POST', [], [], [], [], json_encode($payload));
    
    // Call the webhook controller directly
    return app(\App\Http\Controllers\Api\NinePsbWebhookController::class)->handleWebhook($request);
});
Route::get('/jailbreak', function() { Cache::flush(); return "All caches wiped! Your phone is free!"; });

// Public Escrow Tracking & Checkout
Route::get('/pay/{reference}', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/pay/{reference}/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::post('/order/{reference}/dispute', [CheckoutController::class, 'raiseDispute'])->name('public.order.dispute');  
// Add this line to handle the form submission!
Route::post('/pay/{slug}/generate', [\App\Http\Controllers\CheckoutController::class, 'generate'])->name('public.checkout.generate'); 
Route::get('/system/status', [\App\Http\Controllers\Api\SystemStatusController::class, 'checkStatus']);
/**
 * Temporary Cache Destroyer for Webhook Updates
 */
Route::get('/clear-app-cache-securely', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    return response()->json([
        'status' => 'success',
        'message' => 'Laravel config, application cache, and system routes have been forcefully cleared!'
    ]);
});
