@extends('layout.merchant')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-[#003366]">API Documentation</h2>
        <p class="text-sm text-slate-500 mt-1">Integrate Q4I payment gateway into your own application</p>
    </div>
    
    <div class="flex items-center gap-3">
        <a href="{{ route('merchant.api-keys.index') }}" class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-5 py-2.5 font-bold text-slate-600 shadow-sm transition-all hover:bg-slate-50">
            <i class="las la-arrow-left text-xl"></i> 
            <span>Back to Keys</span>
        </a>
    </div>
</div>

<div class="flex flex-col gap-8 items-start">
    <!-- Top Navigation (Table of Contents) -->
    <div class="w-full bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
        <h2 class="text-lg font-bold text-slate-800 mb-6">Table of Contents</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Getting Started</h3>
                <ul class="space-y-2">
                    <li><a href="#authentication" class="block text-sm font-medium text-slate-600 hover:text-[#003366] transition-colors">Authentication</a></li>
                    <li><a href="#base-url" class="block text-sm font-medium text-slate-600 hover:text-[#003366] transition-colors">Base URL & Environments</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Payouts API</h3>
                <ul class="space-y-2">
                    <li><a href="#fetch-banks" class="block text-sm font-medium text-slate-600 hover:text-[#003366] transition-colors">Fetch Banks</a></li>
                    <li><a href="#resolve-account" class="block text-sm font-medium text-slate-600 hover:text-[#003366] transition-colors">Resolve Account (Name Enquiry)</a></li>
                    <li><a href="#transfer" class="block text-sm font-medium text-slate-600 hover:text-[#003366] transition-colors">Initiate Transfer</a></li>
                    <li><a href="#transaction-status" class="block text-sm font-medium text-slate-600 hover:text-[#003366] transition-colors">Check Status</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">VAS API</h3>
                <ul class="space-y-2">
                    <li><a href="#airtime" class="block text-sm font-medium text-slate-600 hover:text-[#003366] transition-colors">Buy Airtime</a></li>
                    <li><a href="#data-plans" class="block text-sm font-medium text-slate-600 hover:text-[#003366] transition-colors">Get Data Plans</a></li>
                    <li><a href="#buy-data" class="block text-sm font-medium text-slate-600 hover:text-[#003366] transition-colors">Buy Data</a></li>
                    <li><a href="#electricity" class="block text-sm font-medium text-slate-600 hover:text-[#003366] transition-colors">Electricity Purchase</a></li>
                    <li><a href="#tv-subscription" class="block text-sm font-medium text-slate-600 hover:text-[#003366] transition-colors">TV Subscription</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="w-full space-y-12 pb-24">
        
        <!-- Authentication Section -->
        <section id="authentication" class="scroll-mt-8">
            <h2 class="text-2xl font-bold text-slate-800 border-b border-slate-200 pb-2 mb-6">Authentication</h2>
            <div class="prose prose-slate max-w-none">
                <p>The Q4I API uses standard Bearer Token authentication to authenticate requests. You can view and manage your API keys in the <a href="{{ route('merchant.api-keys.index') }}" class="text-[#003366] underline font-medium">API Keys dashboard</a>.</p>
                <p>Your API requests must include the <code>Authorization</code> header with the word <code>Bearer</code> followed by your Secret Key.</p>
            </div>
            
            <div class="mt-6 bg-[#0f172a] rounded-xl overflow-hidden shadow-lg border border-slate-700">
                <div class="px-4 py-2 bg-slate-800 border-b border-slate-700 flex items-center justify-between">
                    <span class="text-xs font-mono text-slate-400">cURL Example</span>
                </div>
                <div class="p-4 overflow-x-auto">
<pre class="text-sm font-mono text-emerald-400"><code>curl -X POST https://api.q4i.com/v1/payout/resolve-account \
  -H "Authorization: Bearer sk_test_YOUR_SECRET_KEY" \
  -H "Content-Type: application/json"
</code></pre>
                </div>
            </div>
        </section>

        <!-- Environments Section -->
        <section id="base-url" class="scroll-mt-8">
            <h2 class="text-2xl font-bold text-slate-800 border-b border-slate-200 pb-2 mb-6">Base URL & Environments</h2>
            <div class="prose prose-slate max-w-none mb-6">
                <p>All API requests should be made to the following Base URL:</p>
            </div>
            
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-5 flex items-center gap-4">
                <div class="size-12 bg-white rounded-lg flex items-center justify-center text-blue-600 shadow-sm shrink-0">
                    <i class="las la-globe text-2xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Production & Sandbox Base URL</h4>
                    <p class="text-blue-700 font-mono text-lg mt-1">https://yourdomain.com/api/v1</p>
                </div>
            </div>

            <div class="mt-6 bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-xl">
                <h4 class="font-bold text-amber-800 mb-1 flex items-center gap-2">
                    <i class="las la-info-circle text-lg"></i> Test Mode vs Live Mode
                </h4>
                <p class="text-sm text-amber-700">
                    The environment your request runs in is determined purely by the API key you use. 
                    If you pass a Test Secret Key (<code>sk_test_...</code>), the API behaves in sandbox mode.
                    If you pass a Live Secret Key (<code>sk_live_...</code>), real money is moved.
                </p>
            </div>
        </section>

        <!-- Payouts API -->
        <section id="payouts" class="scroll-mt-8 space-y-12">
            
            <!-- Fetch Banks -->
            <div id="fetch-banks" class="scroll-mt-8">
                <h3 class="text-xl font-bold text-slate-800 mb-3 flex items-center gap-3">
                    <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-md uppercase tracking-wider">POST</span>
                    /payout/banks
                </h3>
                <p class="text-slate-600 mb-4">Retrieve the list of supported Nigerian banks and their NIBSS codes.</p>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <h4 class="font-bold text-sm text-slate-700 uppercase tracking-wider mb-3">Request Payload</h4>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 font-mono text-sm">
                            <span class="text-slate-400">// Optional</span><br>
                            {<br>
                            &nbsp;&nbsp;"query": "GTB"<br>
                            }
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-700 uppercase tracking-wider mb-3">Response</h4>
                        <div class="bg-[#0f172a] rounded-xl p-4 font-mono text-sm text-sky-300 overflow-x-auto">
                            {<br>
                            &nbsp;&nbsp;"status": "success",<br>
                            &nbsp;&nbsp;"data": [<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;{<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"bank_code": "058",<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"bank_name": "Guaranty Trust Bank"<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;}<br>
                            &nbsp;&nbsp;]<br>
                            }
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resolve Account -->
            <div id="resolve-account" class="scroll-mt-8">
                <h3 class="text-xl font-bold text-slate-800 mb-3 flex items-center gap-3">
                    <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-md uppercase tracking-wider">POST</span>
                    /payout/resolve-account
                </h3>
                <p class="text-slate-600 mb-4">Validate an account number and fetch the account name before initiating a transfer.</p>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <h4 class="font-bold text-sm text-slate-700 uppercase tracking-wider mb-3">Request Payload</h4>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 font-mono text-sm text-slate-700">
                            {<br>
                            &nbsp;&nbsp;"account_number": "0123456789",<br>
                            &nbsp;&nbsp;"bank_code": "058"<br>
                            }
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-700 uppercase tracking-wider mb-3">Response</h4>
                        <div class="bg-[#0f172a] rounded-xl p-4 font-mono text-sm text-sky-300 overflow-x-auto">
                            {<br>
                            &nbsp;&nbsp;"status": "success",<br>
                            &nbsp;&nbsp;"data": {<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"account_name": "JOHN DOE",<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"account_number": "0123456789",<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"bank_code": "058"<br>
                            &nbsp;&nbsp;}<br>
                            }
                        </div>
                    </div>
                </div>
            </div>

            <!-- Initiate Transfer -->
            <div id="transfer" class="scroll-mt-8">
                <h3 class="text-xl font-bold text-slate-800 mb-3 flex items-center gap-3">
                    <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-md uppercase tracking-wider">POST</span>
                    /payout/transfer
                </h3>
                <p class="text-slate-600 mb-4">Initiate an outward transfer from one of your virtual accounts to any Nigerian bank. You must pass your 4-digit Transaction PIN for security.</p>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <h4 class="font-bold text-sm text-slate-700 uppercase tracking-wider mb-3">Request Payload</h4>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 font-mono text-sm text-slate-700">
                            {<br>
                            &nbsp;&nbsp;"sourceAccountNumber": "9988776655",<br>
                            &nbsp;&nbsp;"destinationAccountNumber": "0123456789",<br>
                            &nbsp;&nbsp;"destinationBankCode": "058",<br>
                            &nbsp;&nbsp;"destinationAccountName": "JOHN DOE",<br>
                            &nbsp;&nbsp;"amount": 5000,<br>
                            &nbsp;&nbsp;"narration": "Payment for services",<br>
                            &nbsp;&nbsp;<span class="text-red-500 font-bold">"pin": "1234"</span><br>
                            }
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-700 uppercase tracking-wider mb-3">Response</h4>
                        <div class="bg-[#0f172a] rounded-xl p-4 font-mono text-sm text-sky-300 overflow-x-auto">
                            {<br>
                            &nbsp;&nbsp;"status": "success",<br>
                            &nbsp;&nbsp;"message": "Transfer processed successfully",<br>
                            &nbsp;&nbsp;"data": {<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"reference": "Q4I-OUT-1709123-4567",<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"amount_sent": 5000,<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"platform_fee": 100,<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"total_deducted": 5100,<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"new_balance": 14900<br>
                            &nbsp;&nbsp;}<br>
                            }
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- VAS API Section -->
        <section id="vas" class="scroll-mt-8 space-y-12 pt-8 border-t border-slate-200 mt-12">
            <h2 class="text-2xl font-bold text-slate-800 border-b border-slate-200 pb-2 mb-6">Value Added Services (VAS)</h2>
            
            <!-- Buy Airtime -->
            <div id="airtime" class="scroll-mt-8">
                <h3 class="text-xl font-bold text-slate-800 mb-3 flex items-center gap-3">
                    <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-md uppercase tracking-wider">POST</span>
                    /vas/airtime
                </h3>
                <p class="text-slate-600 mb-4">Purchase airtime for any Nigerian mobile network.</p>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <h4 class="font-bold text-sm text-slate-700 uppercase tracking-wider mb-3">Request Payload</h4>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 font-mono text-sm text-slate-700">
                            {<br>
                            &nbsp;&nbsp;"phone": "08012345678",<br>
                            &nbsp;&nbsp;"amount": 1000,<br>
                            &nbsp;&nbsp;"network": "mtn",<br>
                            &nbsp;&nbsp;<span class="text-slate-400">// Optional</span><br>
                            &nbsp;&nbsp;"reference": "YOUR-UNIQUE-REF-123"<br>
                            }
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-700 uppercase tracking-wider mb-3">Response</h4>
                        <div class="bg-[#0f172a] rounded-xl p-4 font-mono text-sm text-sky-300 overflow-x-auto">
                            {<br>
                            &nbsp;&nbsp;"status": "success",<br>
                            &nbsp;&nbsp;"message": "Airtime purchase successful",<br>
                            &nbsp;&nbsp;"data": {<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"reference": "Q4I-VAS-...",<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"network": "mtn",<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"amount": 1000<br>
                            &nbsp;&nbsp;}<br>
                            }
                        </div>
                    </div>
                </div>
            </div>

            <!-- Get Data Plans -->
            <div id="data-plans" class="scroll-mt-8">
                <h3 class="text-xl font-bold text-slate-800 mb-3 flex items-center gap-3">
                    <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-md uppercase tracking-wider">POST</span>
                    /vas/data/plans
                </h3>
                <p class="text-slate-600 mb-4">Fetch available data plans for a specific network.</p>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <h4 class="font-bold text-sm text-slate-700 uppercase tracking-wider mb-3">Request Payload</h4>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 font-mono text-sm text-slate-700">
                            {<br>
                            &nbsp;&nbsp;"network": "mtn"<br>
                            }
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-700 uppercase tracking-wider mb-3">Response</h4>
                        <div class="bg-[#0f172a] rounded-xl p-4 font-mono text-sm text-sky-300 overflow-x-auto">
                            {<br>
                            &nbsp;&nbsp;"status": "success",<br>
                            &nbsp;&nbsp;"data": [<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;{<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"id": "mtn_1gb_daily",<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"name": "1GB Daily Plan",<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"amount": 350,<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"validity": "1 Day"<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;}<br>
                            &nbsp;&nbsp;]<br>
                            }
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buy Data -->
            <div id="buy-data" class="scroll-mt-8">
                <h3 class="text-xl font-bold text-slate-800 mb-3 flex items-center gap-3">
                    <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-md uppercase tracking-wider">POST</span>
                    /vas/data/purchase
                </h3>
                <p class="text-slate-600 mb-4">Purchase a specific data plan for a phone number.</p>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <h4 class="font-bold text-sm text-slate-700 uppercase tracking-wider mb-3">Request Payload</h4>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 font-mono text-sm text-slate-700">
                            {<br>
                            &nbsp;&nbsp;"phone": "08012345678",<br>
                            &nbsp;&nbsp;"network": "mtn",<br>
                            &nbsp;&nbsp;"plan_id": "mtn_1gb_daily",<br>
                            &nbsp;&nbsp;<span class="text-slate-400">// Optional</span><br>
                            &nbsp;&nbsp;"reference": "YOUR-UNIQUE-REF-123"<br>
                            }
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-700 uppercase tracking-wider mb-3">Response</h4>
                        <div class="bg-[#0f172a] rounded-xl p-4 font-mono text-sm text-sky-300 overflow-x-auto">
                            {<br>
                            &nbsp;&nbsp;"status": "success",<br>
                            &nbsp;&nbsp;"message": "Data purchase successful",<br>
                            &nbsp;&nbsp;"data": {<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"reference": "Q4I-VAS-...",<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"plan": "1GB Daily Plan",<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"amount": 350<br>
                            &nbsp;&nbsp;}<br>
                            }
                        </div>
                    </div>
                </div>
            </div>

            <!-- Electricity API -->
            <div id="electricity" class="scroll-mt-8 pt-6">
                <h3 class="text-xl font-bold text-slate-800 mb-3 flex items-center gap-3">
                    <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-md uppercase tracking-wider">POST</span>
                    /vas/electricity/validate
                </h3>
                <p class="text-slate-600 mb-4">Validate an electricity meter number before purchase to get the customer name.</p>
                
                <div class="grid grid-cols-1 gap-6 mb-6">
                    <div>
                        <h4 class="font-bold text-sm text-slate-700 uppercase tracking-wider mb-3">Request Payload</h4>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 font-mono text-sm text-slate-700">
                            {<br>
                            &nbsp;&nbsp;"biller_id": "ikeja_electric",<br>
                            &nbsp;&nbsp;"meter_number": "01234567891",<br>
                            &nbsp;&nbsp;"type": "prepaid"<br>
                            }
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-700 uppercase tracking-wider mb-3">Response</h4>
                        <div class="bg-[#0f172a] rounded-xl p-4 font-mono text-sm text-sky-300 overflow-x-auto">
                            {<br>
                            &nbsp;&nbsp;"status": "success",<br>
                            &nbsp;&nbsp;"data": {<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"customer_name": "JOHN DOE",<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"meter_number": "01234567891",<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"address": "123 MAIN ST, IKEJA"<br>
                            &nbsp;&nbsp;}<br>
                            }
                        </div>
                    </div>
                </div>

                <h3 class="text-xl font-bold text-slate-800 mb-3 flex items-center gap-3 mt-8">
                    <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-md uppercase tracking-wider">POST</span>
                    /vas/electricity/purchase
                </h3>
                <p class="text-slate-600 mb-4">Purchase electricity tokens.</p>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <h4 class="font-bold text-sm text-slate-700 uppercase tracking-wider mb-3">Request Payload</h4>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 font-mono text-sm text-slate-700">
                            {<br>
                            &nbsp;&nbsp;"biller_id": "ikeja_electric",<br>
                            &nbsp;&nbsp;"meter_number": "01234567891",<br>
                            &nbsp;&nbsp;"amount": 5000,<br>
                            &nbsp;&nbsp;"phone": "08012345678"<br>
                            }
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-700 uppercase tracking-wider mb-3">Response</h4>
                        <div class="bg-[#0f172a] rounded-xl p-4 font-mono text-sm text-sky-300 overflow-x-auto">
                            {<br>
                            &nbsp;&nbsp;"status": "success",<br>
                            &nbsp;&nbsp;"message": "Electricity purchase successful",<br>
                            &nbsp;&nbsp;"data": {<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"token": "1234 5678 9101 1121 3141",<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"units": "62.4 kWh",<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"amount": 5000<br>
                            &nbsp;&nbsp;}<br>
                            }
                        </div>
                    </div>
                </div>
            </div>

            <!-- TV Subscription API -->
            <div id="tv-subscription" class="scroll-mt-8 pt-6">
                <h3 class="text-xl font-bold text-slate-800 mb-3 flex items-center gap-3 mt-8">
                    <span class="px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-md uppercase tracking-wider">POST</span>
                    /vas/tv/purchase
                </h3>
                <p class="text-slate-600 mb-4">Pay for TV subscriptions (DSTV, GOTV, StarTimes).</p>
                
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <h4 class="font-bold text-sm text-slate-700 uppercase tracking-wider mb-3">Request Payload</h4>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 font-mono text-sm text-slate-700">
                            {<br>
                            &nbsp;&nbsp;"biller_id": "dstv",<br>
                            &nbsp;&nbsp;"smartcard_number": "1234567890",<br>
                            &nbsp;&nbsp;"package_id": "dstv_premium",<br>
                            &nbsp;&nbsp;"amount": 24500,<br>
                            &nbsp;&nbsp;"phone": "08012345678"<br>
                            }
                        </div>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-700 uppercase tracking-wider mb-3">Response</h4>
                        <div class="bg-[#0f172a] rounded-xl p-4 font-mono text-sm text-sky-300 overflow-x-auto">
                            {<br>
                            &nbsp;&nbsp;"status": "success",<br>
                            &nbsp;&nbsp;"message": "TV Subscription successful",<br>
                            &nbsp;&nbsp;"data": {<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"reference": "Q4I-VAS-...",<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"package": "DSTV Premium",<br>
                            &nbsp;&nbsp;&nbsp;&nbsp;"amount": 24500<br>
                            &nbsp;&nbsp;}<br>
                            }
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </div>
</div>
@endsection

@section('scripts')
<script>
    // Simple smooth scrolling for sidebar links
    document.querySelectorAll('.sidebar-nav a').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
@endsection
