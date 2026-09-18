<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Standard Controllers
use App\Http\Controllers\SystemHealthController;
use App\Http\Controllers\TechvibesController;
use App\Http\Controllers\Auth\OnboardingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MerchantDashboardController;
use App\Http\Controllers\VasController;
use App\Http\Controllers\BulkImportController;
use App\Http\Controllers\MerchantSettingsController;
use App\Http\Controllers\PayoutController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ReportController;

// API Namespace Controllers (The Engines We Built Today)
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\TvSubscriptionController;
use App\Http\Controllers\Api\ElectricityController;
use App\Http\Controllers\Api\LogisticsWebhookController;
use App\Http\Controllers\Api\WhatsAppWebhookController;
use App\Http\Controllers\Api\AdminEscrowController;
use App\Http\Controllers\Api\NinePsbWebhookController;

/*
|--------------------------------------------------------------------------
| ZONE 1: PUBLIC & WEBHOOKS (No Authentication)
|--------------------------------------------------------------------------
*/


// 🟢 Unified Webhook Receivers
Route::prefix('webhooks')->group(function () {
    Route::post('/techvibes', [TechvibesController::class, 'handleWebhook']);
    
    // 9PSB Webhook for static VA inflows
    Route::post('/9psb-inflow', [NinePsbWebhookController::class, 'handleWebhook']);
    
    // Logistics (Shipbubble)
    Route::post('/shipbubble', [WhatsAppWebhookController::class, 'handleShipbubbleWebhook']);
    
    // RexPay DVA Payments
    Route::post('/rexpay-dva', [WhatsAppWebhookController::class, 'handleRexpayDvaWebhook']);
    
    // Meta / WhatsApp Social Commerce Engine
    Route::get('/whatsapp', [WhatsAppWebhookController::class, 'verifyWebhook']);
    Route::post('/whatsapp', [WhatsAppWebhookController::class, 'handleIncomingMessage']);
});

// Ghost Testing Routes (For Development Only)
Route::get('/test/deliver/{reference}', [WhatsAppWebhookController::class, 'mockDeliveryWebhook']);
Route::get('/test/mock-payment/{escrow_id}', [WhatsAppWebhookController::class, 'mockPaymentWebhook']);

/*
|--------------------------------------------------------------------------
| ZONE 2: MERCHANT ONBOARDING & AUTH (Public)
|--------------------------------------------------------------------------
*/
Route::prefix('merchant')->group(function () {
    Route::post('/register', [OnboardingController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']); 
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);   
    
    // Techvibes Provisioning
    Route::post('/verify-bvn', [TechvibesController::class, 'verifyBvnAndCreateWallet']);
    Route::post('/corporate-wallet', [TechvibesController::class, 'registerCorporateWallet']);
    Route::post('/corporate-kyc', [TechvibesController::class, 'processCorporateKyc']);
});

/*
|--------------------------------------------------------------------------
| ZONE 3: CORPORATE DASHBOARD (Sanctum JWT/Cookie)
|--------------------------------------------------------------------------
| Strictly for the React/Vue frontend UI used by merchants.
*/
// 🟢 FIXED: Explicitly telling Sanctum to use the 'merchant' guard!
Route::middleware(['auth:sanctum', 'type.merchant'])->prefix('merchant')->group(function () {
    
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Dashboard Data
    Route::get('/overview', [MerchantDashboardController::class, 'getOverview']);
    Route::get('/agents', [MerchantDashboardController::class, 'getAgents']);
    Route::get('/transactions', [MerchantDashboardController::class, 'getTransactions']);
    Route::get('/chart', [MerchantDashboardController::class, 'getChartData']);
    
    // Internal P2P & CSV
    Route::post('/transfers/internal', [PayoutController::class, 'processInternalTransfer'])->middleware('idempotent');
    Route::post('/agents/bulk-import', [BulkImportController::class, 'uploadAgentsCsv']);
    
    // Developer Settings
    Route::get('/developer/settings', [MerchantSettingsController::class, 'getDeveloperSettings']);
    Route::post('/developer/pin/set', [MerchantSettingsController::class, 'setTransactionPin']);
    Route::post('/developer/webhook/update', [MerchantSettingsController::class, 'updateWebhookSettings']);

    // Reporting
    Route::get('/reports/transactions/csv', [ReportController::class, 'exportTransactionsCsv']);
});

/*
|--------------------------------------------------------------------------
| ZONE 4: SHIELDED B2B API (Server-to-Server)
|--------------------------------------------------------------------------
| Rate limited and protected by the Q4I API Key middleware.
*/
// 🟢 FIXED: Added 'auth.apikey' to protect these routes!
Route::middleware(['throttle:q4i-merchant', 'auth.apikey'])->prefix('v1')->group(function () {
    
    Route::prefix('payout')->group(function () {
        Route::post('/banks', [PayoutController::class, 'getBanks']);
        Route::post('/resolve-account', [PayoutController::class, 'resolveAccount']);
        Route::post('/transfer', [PayoutController::class, 'processPayout'])->middleware('idempotent');
        Route::get('/status/{session_id}', [PayoutController::class, 'getTransactionStatus']);
    });

    Route::prefix('kyc')->group(function () {
        Route::post('/upgrade', [KycController::class, 'upgradeTier']);
    });

    Route::prefix('vas')->group(function () {
        // Airtime & Data
        Route::post('/airtime', [VasController::class, 'purchaseAirtime'])->middleware('idempotent');
        Route::post('/data/plans', [VasController::class, 'fetchDataPlans']);
        Route::post('/data/purchase', [VasController::class, 'purchaseData'])->middleware('idempotent');
        
        // Electricity (Using the Engine we built)
        Route::get('/electricity/billers', [ElectricityController::class, 'getBillers']);
        Route::get('/electricity/billers/{billerId}/items', [ElectricityController::class, 'getBillerItems']);
        Route::post('/electricity/validate', [ElectricityController::class, 'validateMeter']);
        Route::post('/electricity/purchase', [ElectricityController::class, 'purchase'])->middleware('idempotent');
        
        // TV (Using the Engine we built)
        Route::post('/tv/purchase', [TvSubscriptionController::class, 'purchase'])->middleware('idempotent');
    });
});

/*
|--------------------------------------------------------------------------
| ZONE 5: MASTER ADMIN (Highest Clearance Level)
|--------------------------------------------------------------------------
*/
// 🟢 FIXED: Locked down Escrow refunds and Payouts to Admin only!
Route::middleware(['auth:sanctum', 'type.admin'])->prefix('admin')->group(function () {
    
    Route::get('/dashboard/overview', [AdminController::class, 'getPlatformOverview']);
    Route::get('/overview', [AdminDashboardController::class, 'getSystemOverview']);
    
    // Merchant Management
    Route::get('/merchants', [AdminDashboardController::class, 'getMerchantsList']);
    Route::get('/merchants/pending', [AdminController::class, 'getPendingMerchants']);
    Route::post('/merchants/kyc/approve', [AdminController::class, 'approveMerchantKyc']);
    
    // Escrow Resolutions (The Fixed Backdoor)
    Route::post('/escrow/{id}/refund', [AdminEscrowController::class, 'refundBuyer']);
    Route::post('/escrow/{id}/force-payout', [AdminEscrowController::class, 'forcePayout']);
});

// System Health Traffic Light
Route::get('/system/health', [SystemHealthController::class, 'getStatus']);