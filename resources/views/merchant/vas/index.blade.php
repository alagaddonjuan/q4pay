@extends('layout.merchant')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-3xl font-bold text-[#003366]">Utility Kiosk</h2>
        <p class="text-sm text-slate-500 mt-1">Purchase Airtime, Data, Electricity, and fund Betting wallets.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <div class="lg:col-span-4">
        <div class="box bg-white rounded-2xl shadow-sm border border-slate-200 p-4">
            <div class="flex flex-col gap-2" id="vas-tabs">
                <button onclick="switchTab('airtime')" id="tab-airtime" class="vas-tab-btn active flex items-center gap-4 p-4 rounded-xl text-left transition-all bg-[#003366] text-white shadow-md">
                    <div class="size-10 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                        <i class="las la-phone-volume text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-base">Airtime Top-Up</h4>
                        <p class="text-xs text-blue-200">MTN, Airtel, GLO, 9Mobile</p>
                    </div>
                </button>

                <button onclick="switchTab('betting')" id="tab-betting" class="vas-tab-btn flex items-center gap-4 p-4 rounded-xl text-left transition-all hover:bg-slate-50 text-slate-600 border border-transparent">
                    <div class="size-10 rounded-full bg-slate-100 flex items-center justify-center shrink-0 text-[#D20103]">
                        <i class="las la-futbol text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-base text-slate-700">Betting & Lottery</h4>
                        <p class="text-xs text-slate-400">SportyBet, Bet9ja, 1xBet</p>
                    </div>
                </button>

                <button onclick="switchTab('data')" id="tab-data" class="vas-tab-btn flex items-center gap-4 p-4 rounded-xl text-left transition-all hover:bg-slate-50 text-slate-600 border border-transparent">
                    <div class="size-10 rounded-full bg-slate-100 flex items-center justify-center shrink-0">
                        <i class="las la-globe text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-base text-slate-700">Internet Subscription</h4>
                        <p class="text-xs text-slate-400">Mobile Data & Internet</p>
                    </div>
                </button>

                <button onclick="switchTab('power')" id="tab-power" class="vas-tab-btn flex items-center gap-4 p-4 rounded-xl text-left transition-all hover:bg-slate-50 text-slate-600 border border-transparent">
                    <div class="size-10 rounded-full bg-slate-100 flex items-center justify-center shrink-0">
                        <i class="las la-bolt text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-base text-slate-700">Electricity</h4>
                        <p class="text-xs text-slate-400">Prepaid & Postpaid</p>
                    </div>
                </button>

                <button onclick="switchTab('tv')" id="tab-tv" class="vas-tab-btn flex items-center gap-4 p-4 rounded-xl text-left transition-all hover:bg-slate-50 text-slate-600 border border-transparent">
                    <div class="size-10 rounded-full bg-slate-100 flex items-center justify-center shrink-0">
                        <i class="las la-tv text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-base text-slate-700">TV Subscriptions</h4>
                        <p class="text-xs text-slate-400">DSTV, GOTV, Startimes</p>
                    </div>
                </button>



                <button onclick="switchTab('exams')" id="tab-exams" class="vas-tab-btn flex items-center gap-4 p-4 rounded-xl text-left transition-all hover:bg-slate-50 text-slate-600 border border-transparent">
                    <div class="size-10 rounded-full bg-slate-100 flex items-center justify-center shrink-0">
                        <i class="las la-graduation-cap text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-base text-slate-700">Exams</h4>
                        <p class="text-xs text-slate-400">WAEC, NECO, JAMB</p>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <div class="lg:col-span-8">
        
        <div id="form-airtime" class="vas-form box bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-[#003366] flex items-center gap-2"><i class="las la-phone-volume text-[#D20103]"></i> Buy Airtime</h3>
            </div>
            
            <form id="airtimePurchaseForm" class="p-6 space-y-5" onsubmit="handleAirtimePurchase(event)">
                @csrf
                <div id="airtime-alert" class="hidden p-4 rounded-lg text-sm font-bold mb-4"></div>

                <div>
                    <label class="block text-sm font-bold text-[#003366] mb-2">Debit From Account</label>
                    <select id="airtime_source" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
                        <option value="">Select a Virtual Account...</option>
                        @foreach($accounts as $acc)
                            <option value="{{ $acc->account_number }}">{{ $acc->account_number }} - ₦{{ number_format($acc->ledger_balance, 2) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Network</label>
                        <select id="airtime_network" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
                            <option value="MTN">MTN</option>
                            <option value="AIRTEL">Airtel</option>
                            <option value="GLO">GLO</option>
                            <option value="9MOBILE">9Mobile</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Phone Number</label>
                        <input type="text" id="airtime_phone" required maxlength="11" placeholder="08012345678" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none font-mono">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Amount (₦)</label>
                        <input type="number" id="airtime_amount" required min="50" placeholder="Min: ₦50" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none font-bold text-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#D20103] mb-2"><i class="las la-lock"></i> 4-Digit PIN</label>
                        <input type="password" id="airtime_pin" required maxlength="4" placeholder="••••" class="w-full text-sm bg-red-50 border border-red-200 rounded-lg px-4 py-3 focus:border-[#D20103] outline-none font-mono text-center tracking-widest text-xl">
                    </div>
                </div>

                <button type="submit" id="airtime_btn" class="w-full mt-4 flex items-center justify-center gap-2 px-8 py-3.5 rounded-lg font-bold text-white transition-all shadow-md hover:bg-blue-900" style="background-color: #003366;">
                    <i class="las la-bolt text-xl"></i> Purchase Airtime
                </button>
            </form>
        </div>

        <div id="form-betting" class="vas-form box bg-white rounded-2xl shadow-sm border border-slate-200 hidden overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-[#003366] flex items-center gap-2"><i class="las la-futbol text-[#D20103]"></i> Fund Betting Wallet</h3>
            </div>
            
            <div class="p-6">
                <div id="betting-alert" class="hidden p-4 rounded-lg text-sm font-bold mb-4"></div>

                <form id="bettingVerifyForm" onsubmit="verifyBettingCustomer(event)" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-[#003366] mb-2">Betting Provider</label>
                            <select id="betting_provider" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
                                <option value="sportybet">SportyBet</option>
                                <option value="bet9ja">Bet9ja</option>
                                <option value="1xbet">1xBet</option>
                                <option value="betking">BetKing</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#003366] mb-2">Customer ID</label>
                            <input type="text" id="betting_customer_id" required placeholder="Enter User ID" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none font-mono">
                        </div>
                    </div>
                    <button type="submit" id="betting_verify_btn" class="w-full flex items-center justify-center gap-2 px-8 py-3 rounded-lg font-bold text-[#003366] border border-[#003366] transition-all hover:bg-slate-50">
                        <i class="las la-search text-xl"></i> Verify Customer ID
                    </button>
                </form>

                <form id="bettingFundForm" onsubmit="handleBettingFunding(event)" class="hidden mt-6 pt-6 border-t border-slate-100 space-y-5">
                    
                    <div class="p-4 bg-green-50 border border-green-100 rounded-xl flex items-center gap-4">
                        <div class="size-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                            <i class="las la-user-check text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-xs text-green-600 font-bold uppercase tracking-wider mb-0.5">Verified Customer Name</p>
                            <p id="betting_customer_name" class="text-xl font-black text-[#003366]">---</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Debit From Account</label>
                        <select id="betting_source" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
                            <option value="">Select a Virtual Account...</option>
                            @foreach($accounts as $acc)
                                <option value="{{ $acc->account_number }}">{{ $acc->account_number }} - ₦{{ number_format($acc->ledger_balance, 2) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-[#003366] mb-2">Amount (₦)</label>
                            <input type="number" id="betting_amount" required min="100" placeholder="Min: ₦100 (+₦50 Fee)" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none font-bold text-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#D20103] mb-2"><i class="las la-lock"></i> 4-Digit PIN</label>
                            <input type="password" id="betting_pin" required maxlength="4" placeholder="••••" class="w-full text-sm bg-red-50 border border-red-200 rounded-lg px-4 py-3 focus:border-[#D20103] outline-none font-mono text-center tracking-widest text-xl">
                        </div>
                    </div>

                    <button type="submit" id="betting_fund_btn" class="w-full mt-2 flex items-center justify-center gap-2 px-8 py-3.5 rounded-lg font-bold text-white transition-all shadow-md hover:bg-blue-900" style="background-color: #003366;">
                        <i class="las la-wallet text-xl"></i> Fund Wallet & Deduct Fee
                    </button>
                    
                    <button type="button" onclick="resetBettingForm()" class="w-full text-sm font-bold text-slate-500 hover:text-red-500 transition-colors mt-2">
                        Cancel & Try Another ID
                    </button>
                </form>
            </div>
        </div>

        <div id="form-data" class="vas-form box bg-white rounded-2xl shadow-sm border border-slate-200 hidden overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-[#003366] flex items-center gap-2"><i class="las la-globe text-[#D20103]"></i> Internet Subscription</h3>
            </div>
            
            <div class="p-6">
                <div id="data-alert" class="hidden p-4 rounded-lg text-sm font-bold mb-4"></div>

                <form id="dataFetchForm" onsubmit="fetchDataPackages(event)" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-[#003366] mb-2">Network</label>
                            <select id="data_network" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
                                <option value="MTN">MTN</option>
                                <option value="AIRTEL">Airtel</option>
                                <option value="GLO">GLO</option>
                                <option value="9MOBILE">9Mobile</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#003366] mb-2">Phone Number</label>
                            <input type="text" id="data_phone" required maxlength="11" placeholder="08012345678" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none font-mono">
                        </div>
                    </div>
                    <button type="submit" id="data_fetch_btn" class="w-full flex items-center justify-center gap-2 px-8 py-3 rounded-lg font-bold text-[#003366] border border-[#003366] transition-all hover:bg-slate-50">
                        <i class="las la-sync text-xl"></i> View Available Data Plans
                    </button>
                </form>

                <form id="dataPurchaseForm" onsubmit="handleDataPurchase(event)" class="hidden mt-6 pt-6 border-t border-slate-100 space-y-5">
                    
                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Select Data Plan</label>
                        <select id="data_plan" required class="w-full text-sm bg-blue-50 border border-blue-200 text-[#003366] font-bold rounded-lg px-4 py-3 focus:border-[#003366] outline-none" onchange="updateDataAmount()">
                            <option value="">Choose a plan...</option>
                            </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Debit From Account</label>
                        <select id="data_source" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
                            <option value="">Select a Virtual Account...</option>
                            @foreach($accounts as $acc)
                                <option value="{{ $acc->account_number }}">{{ $acc->account_number }} - ₦{{ number_format($acc->ledger_balance, 2) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-[#003366] mb-2">Amount (₦)</label>
                            <input type="number" id="data_amount" required readonly class="w-full text-sm bg-slate-50 border border-slate-200 text-slate-500 rounded-lg px-4 py-3 outline-none font-bold text-lg cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#D20103] mb-2"><i class="las la-lock"></i> 4-Digit PIN</label>
                            <input type="password" id="data_pin" required maxlength="4" placeholder="••••" class="w-full text-sm bg-red-50 border border-red-200 rounded-lg px-4 py-3 focus:border-[#D20103] outline-none font-mono text-center tracking-widest text-xl">
                        </div>
                    </div>

                    <button type="submit" id="data_purchase_btn" class="w-full mt-2 flex items-center justify-center gap-2 px-8 py-3.5 rounded-lg font-bold text-white transition-all shadow-md hover:bg-blue-900" style="background-color: #003366;">
                        <i class="las la-wifi text-xl"></i> Purchase Data
                    </button>
                    
                    <button type="button" onclick="resetDataForm()" class="w-full text-sm font-bold text-slate-500 hover:text-red-500 transition-colors mt-2">
                        Cancel & Change Number
                    </button>
                </form>
            </div>
        </div>

        <div id="form-power" class="vas-form box bg-white rounded-2xl shadow-sm border border-slate-200 hidden overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-[#003366] flex items-center gap-2"><i class="las la-bolt text-[#D20103]"></i> Pay Electricity</h3>
            </div>
            
            <div class="p-6">
                <div id="power-alert" class="hidden p-4 rounded-lg text-sm font-bold mb-4"></div>

                <form id="powerVerifyForm" onsubmit="verifyMeter(event)" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-[#003366] mb-2">Distribution Company</label>
                            <select id="power_disco" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
    <option value="IKEDC">Ikeja Electric (IKEDC)</option>
    <option value="EKEDC">Eko Electric (EKEDC)</option>
    <option value="AEDC">Abuja Electric (AEDC)</option>
    <option value="IBEDC">Ibadan Electric (IBEDC)</option>
</select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#003366] mb-2">Meter Type</label>
                            <select id="power_meter_type" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
                                <!-- Changed values to UPPERCASE to match standard API ItemIds -->
                                <option value="VT01">Prepaid</option>
                                <option value="VT02">Postpaid</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-[#003366] mb-2">Meter Number</label>
                            <input type="text" id="power_meter_number" required placeholder="Enter Meter Number" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none font-mono">
                        </div>
                    </div>
                    <button type="submit" id="power_verify_btn" class="w-full flex items-center justify-center gap-2 px-8 py-3 rounded-lg font-bold text-[#003366] border border-[#003366] transition-all hover:bg-slate-50">
                        <i class="las la-search text-xl"></i> Verify Meter
                    </button>
                </form>

                <form id="powerPurchaseForm" onsubmit="handlePowerPayment(event)" class="hidden mt-6 pt-6 border-t border-slate-100 space-y-5">
                    
                    <div class="p-4 bg-green-50 border border-green-100 rounded-xl flex items-center gap-4">
                        <div class="size-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                            <i class="las la-home text-2xl"></i>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs text-green-600 font-bold uppercase tracking-wider mb-0.5">Verified Meter Owner</p>
                            <p id="power_customer_name" class="text-lg font-black text-[#003366] truncate">---</p>
                            <p id="power_address" class="text-xs text-slate-500 truncate">---</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Debit From Account</label>
                        <select id="power_source" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
                            <option value="">Select a Virtual Account...</option>
                            @foreach($accounts as $acc)
                                <option value="{{ $acc->account_number }}">{{ $acc->account_number }} - ₦{{ number_format($acc->ledger_balance, 2) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-[#003366] mb-2">Amount (₦)</label>
                            <!-- Change the min value to 1000 and update the placeholder -->
                            <input type="number" id="power_amount" required min="1000" placeholder="Min: ₦1,000" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none font-bold text-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#D20103] mb-2"><i class="las la-lock"></i> 4-Digit PIN</label>
                            <input type="password" id="power_pin" required maxlength="4" placeholder="••••" class="w-full text-sm bg-red-50 border border-red-200 rounded-lg px-4 py-3 focus:border-[#D20103] outline-none font-mono text-center tracking-widest text-xl">
                        </div>
                    </div>

                    <button type="submit" id="power_pay_btn" class="w-full mt-2 flex items-center justify-center gap-2 px-8 py-3.5 rounded-lg font-bold text-white transition-all shadow-md hover:bg-blue-900" style="background-color: #003366;">
                        <i class="las la-bolt text-xl"></i> Generate Token & Pay
                    </button>
                    
                    <button type="button" onclick="resetPowerForm()" class="w-full text-sm font-bold text-slate-500 hover:text-red-500 transition-colors mt-2">
                        Cancel & Check Another Meter
                    </button>
                </form>
            </div>
        </div>

        <div id="form-tv" class="vas-form box bg-white rounded-2xl shadow-sm border border-slate-200 hidden overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-[#003366] flex items-center gap-2"><i class="las la-tv text-[#D20103]"></i> Pay TV Subscription</h3>
            </div>
            
            <div class="p-6">
                <div id="tv-alert" class="hidden p-4 rounded-lg text-sm font-bold mb-4"></div>

                <form id="tvVerifyForm" onsubmit="verifyTv(event)" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-[#003366] mb-2">Biller</label>
                            <select id="tv_biller" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
                                <option value="">Select a Biller...</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#003366] mb-2">Package Code (Item ID)</label>
                            <select id="tv_package_code" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
                                <option value="">Select a Biller first...</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-[#003366] mb-2">Smartcard Number</label>
                            <input type="text" id="tv_smartcard_number" required placeholder="Enter Smartcard Number" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none font-mono">
                        </div>
                    </div>
                    <button type="submit" id="tv_verify_btn" class="w-full flex items-center justify-center gap-2 px-8 py-3 rounded-lg font-bold text-[#003366] border border-[#003366] transition-all hover:bg-slate-50">
                        <i class="las la-search text-xl"></i> Verify Smartcard
                    </button>
                </form>

                <form id="tvPurchaseForm" onsubmit="handleTvPayment(event)" class="hidden mt-6 pt-6 border-t border-slate-100 space-y-5">
                    
                    <div class="p-4 bg-green-50 border border-green-100 rounded-xl flex items-center gap-4">
                        <div class="size-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                            <i class="las la-user text-2xl"></i>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs text-green-600 font-bold uppercase tracking-wider mb-0.5">Verified Customer</p>
                            <p id="tv_customer_name" class="text-lg font-black text-[#003366] truncate">---</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Debit From Account</label>
                        <select id="tv_source" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
                            <option value="">Select a Virtual Account...</option>
                            @foreach($accounts as $acc)
                                <option value="{{ $acc->account_number }}">{{ $acc->account_number }} - ₦{{ number_format($acc->ledger_balance, 2) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-[#003366] mb-2">Amount (₦)</label>
                            <input type="number" id="tv_amount" required min="500" placeholder="Min: ₦500" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none font-bold text-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#D20103] mb-2"><i class="las la-lock"></i> 4-Digit PIN</label>
                            <input type="password" id="tv_pin" required maxlength="4" placeholder="••••" class="w-full text-sm bg-red-50 border border-red-200 rounded-lg px-4 py-3 focus:border-[#D20103] outline-none font-mono text-center tracking-widest text-xl">
                        </div>
                    </div>

                    <button type="submit" id="tv_pay_btn" class="w-full mt-2 flex items-center justify-center gap-2 px-8 py-3.5 rounded-lg font-bold text-white transition-all shadow-md hover:bg-blue-900" style="background-color: #003366;">
                        <i class="las la-tv text-xl"></i> Pay Subscription
                    </button>
                    
                    <button type="button" onclick="resetTvForm()" class="w-full text-sm font-bold text-slate-500 hover:text-red-500 transition-colors mt-2">
                        Cancel & Check Another Smartcard
                    </button>
                </form>
            </div>
        </div>



        <div id="form-exams" class="vas-form hidden box bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-[#003366] flex items-center gap-2"><i class="las la-graduation-cap text-[#D20103]"></i> Exams PINs</h3>
            </div>
            
            <div class="p-6">
                <div id="exams-alert" class="hidden p-4 rounded-lg text-sm font-bold mb-4"></div>

                <form id="examsVerifyForm" onsubmit="verifyExams(event)" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-[#003366] mb-2">Biller</label>
                            <select id="exams_biller" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
                                <option value="">Select a Biller...</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#003366] mb-2">Package Code (Item ID)</label>
                            <select id="exams_package_code" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
                                <option value="">Select a Biller first...</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#003366] mb-2">Candidate Name</label>
                            <input type="text" id="exams_customer_name" required placeholder="Enter Candidate Full Name" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#003366] mb-2">Candidate Phone</label>
                            <input type="text" id="exams_phone" required placeholder="Enter Candidate Phone Number" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none font-mono">
                        </div>
                    </div>
                    <button type="submit" id="exams_verify_btn" class="w-full flex items-center justify-center gap-2 px-8 py-3 rounded-lg font-bold text-[#003366] border border-[#003366] transition-all hover:bg-slate-50">
                        <i class="las la-search text-xl"></i> Verify & Check Cost
                    </button>
                </form>

                <form id="examsPurchaseForm" onsubmit="handleExamsPayment(event)" class="hidden mt-6 pt-6 border-t border-slate-100 space-y-5">
                    
                    <div class="p-4 bg-green-50 border border-green-100 rounded-xl flex items-center gap-4">
                        <div class="size-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                            <i class="las la-user text-2xl"></i>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs text-green-600 font-bold uppercase tracking-wider mb-0.5">Verified Candidate</p>
                            <p id="exams_customer_name_display" class="text-lg font-black text-[#003366] truncate">---</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Debit From Account</label>
                        <select id="exams_source" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
                            <option value="">Select a Virtual Account...</option>
                            @foreach($accounts as $acc)
                                <option value="{{ $acc->account_number }}">{{ $acc->account_number }} - ₦{{ number_format($acc->ledger_balance, 2) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-[#003366] mb-2">Total Amount (₦) + Q4I Fee</label>
                            <input type="number" id="exams_amount" required readonly class="w-full text-sm bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none font-bold text-lg text-slate-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#D20103] mb-2"><i class="las la-lock"></i> 4-Digit PIN</label>
                            <input type="password" id="exams_pin" required maxlength="4" placeholder="••••" class="w-full text-sm bg-red-50 border border-red-200 rounded-lg px-4 py-3 focus:border-[#D20103] outline-none font-mono text-center tracking-widest text-xl">
                        </div>
                    </div>

                    <button type="submit" id="exams_pay_btn" class="w-full mt-2 flex items-center justify-center gap-2 px-8 py-3.5 rounded-lg font-bold text-white transition-all shadow-md hover:bg-blue-900" style="background-color: #003366;">
                        <i class="las la-graduation-cap text-xl"></i> Purchase Exam PIN
                    </button>
                    
                    <button type="button" onclick="resetExamsForm()" class="w-full text-sm font-bold text-slate-500 hover:text-red-500 transition-colors mt-2">
                        Cancel & Try Again
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Tab Switcher
    function switchTab(tabId) {
        document.querySelectorAll('.vas-tab-btn').forEach(btn => {
            btn.classList.remove('bg-[#003366]', 'text-white', 'shadow-md');
            btn.classList.add('hover:bg-slate-50', 'text-slate-600');
            btn.querySelector('div').classList.replace('bg-white/20', 'bg-slate-100');
            btn.querySelector('h4').classList.replace('text-white', 'text-slate-700');
        });
        
        document.querySelectorAll('.vas-form').forEach(form => form.classList.add('hidden'));

        const activeBtn = document.getElementById('tab-' + tabId);
        activeBtn.classList.remove('hover:bg-slate-50', 'text-slate-600');
        activeBtn.classList.add('bg-[#003366]', 'text-white', 'shadow-md');
        activeBtn.querySelector('div').classList.replace('bg-slate-100', 'bg-white/20');
        activeBtn.querySelector('h4').classList.replace('text-slate-700', 'text-white');
        
        document.getElementById('form-' + tabId).classList.remove('hidden');
    }

    // ==========================================
    // AIRTIME LOGIC
    // ==========================================
    async function handleAirtimePurchase(e) {
        e.preventDefault();
        const btn = document.getElementById('airtime_btn');
        const alertBox = document.getElementById('airtime-alert');
        const csrfToken = document.querySelector('input[name="_token"]').value;

        btn.innerHTML = '<i class="las la-spinner animate-spin text-xl"></i> Processing...';
        btn.disabled = true;
        alertBox.classList.add('hidden');

        try {
            const response = await fetch('{{ url("/merchant/api/vas/airtime") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({
                    sourceAccountNumber: document.getElementById('airtime_source').value,
                    network: document.getElementById('airtime_network').value,
                    phone: document.getElementById('airtime_phone').value,
                    amount: document.getElementById('airtime_amount').value,
                    pin: document.getElementById('airtime_pin').value
                })
            });

            const data = await response.json();

            if (!response.ok) {
                alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
                let errorMessage = data.error || data.message || 'Transaction failed.';
                if (data.reason) errorMessage += ' - Reason: ' + data.reason;
                alertBox.innerHTML = '<i class="las la-exclamation-circle text-lg mr-1"></i> ' + errorMessage;
                alertBox.classList.remove('hidden');
            } else {
                alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-green-50 text-green-700 border border-green-200';
                alertBox.innerHTML = '<i class="las la-check-circle text-lg mr-1"></i> ' + data.message + ' Ref: ' + data.data.reference;
                alertBox.classList.remove('hidden');
                document.getElementById('airtimePurchaseForm').reset();
            }
        } catch (error) {
            alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
            alertBox.innerHTML = '<i class="las la-wifi text-lg mr-1"></i> Network error.';
            alertBox.classList.remove('hidden');
        } finally {
            btn.innerHTML = '<i class="las la-bolt text-xl"></i> Purchase Airtime';
            btn.disabled = false;
        }
    }

    // ==========================================
    // BETTING LOGIC (Step 1: Verification)
    // ==========================================
    async function verifyBettingCustomer(e) {
        e.preventDefault();
        const btn = document.getElementById('betting_verify_btn');
        const alertBox = document.getElementById('betting-alert');
        const csrfToken = document.querySelector('input[name="_token"]').value;

        btn.innerHTML = '<i class="las la-spinner animate-spin text-xl"></i> Verifying with Provider...';
        btn.disabled = true;
        alertBox.classList.add('hidden');

        try {
            const response = await fetch('{{ url("/merchant/api/betting/verify") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({
                    customer_id: document.getElementById('betting_customer_id').value,
                    provider: document.getElementById('betting_provider').value
                })
            });

            const data = await response.json();

            if (!response.ok) {
                // Check if Laravel sent standard validation/auth errors
                let exactError = data.error || data.message || 'Unknown Server Error';
                
                // If Laravel sends specific field validation errors, append them
                if (data.errors) {
                    exactError += ' - ' + JSON.stringify(data.errors);
                }

                alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200 overflow-x-auto';
                
                let errorHtml = '<i class="las la-exclamation-circle text-lg mr-1"></i> <strong>Error:</strong> ' + exactError;
                
                if (data.raw_response) {
                    errorHtml += '<br><span class="text-xs text-red-500 mt-2 block font-mono bg-red-100 p-2 rounded">Raw API: ' + JSON.stringify(data.raw_response) + '</span>';
                }
                
                alertBox.innerHTML = errorHtml;
                alertBox.classList.remove('hidden');
                
                btn.innerHTML = '<i class="las la-search text-xl"></i> Verify Customer ID';
                btn.disabled = false;
            } else {
                // Verification Success - Show Step 2
                document.getElementById('betting_customer_name').innerText = data.data.customer_name;
                window.bettingSessionHash = data.data.other_field; 
                document.getElementById('betting_provider').disabled = true;
                document.getElementById('betting_customer_id').disabled = true;
                
                btn.classList.add('hidden');
                document.getElementById('bettingFundForm').classList.remove('hidden');
            }
        } catch (error) {
            alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
            alertBox.innerHTML = '<i class="las la-wifi text-lg mr-1"></i> Network error connecting to provider.';
            alertBox.classList.remove('hidden');
            btn.innerHTML = '<i class="las la-search text-xl"></i> Verify Customer ID';
            btn.disabled = false;
        }
    }

    // ==========================================
    // BETTING LOGIC (Step 2: Funding)
    // ==========================================
    async function handleBettingFunding(e) {
        e.preventDefault();
        const btn = document.getElementById('betting_fund_btn');
        const alertBox = document.getElementById('betting-alert');
        const csrfToken = document.querySelector('input[name="_token"]').value;

        btn.innerHTML = '<i class="las la-spinner animate-spin text-xl"></i> Sending Funds...';
        btn.disabled = true;
        alertBox.classList.add('hidden');

        try {
            const response = await fetch('{{ url("/merchant/api/betting/fund") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({
                    // Re-enable temporarily to pull values, though we could just read them
                    customer_id: document.getElementById('betting_customer_id').value,
                    provider: document.getElementById('betting_provider').value,
                    sourceAccountNumber: document.getElementById('betting_source').value,
                    amount: document.getElementById('betting_amount').value,
                    pin: document.getElementById('betting_pin').value,
                    other_field: window.bettingSessionHash
                })
            });

            const data = await response.json();

            if (!response.ok) {
                alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
                alertBox.innerHTML = '<i class="las la-exclamation-circle text-lg mr-1"></i> ' + (data.error || 'Transaction failed.');
                alertBox.classList.remove('hidden');
                btn.innerHTML = '<i class="las la-wallet text-xl"></i> Fund Wallet & Deduct Fee';
                btn.disabled = false;
            } else {
                // Complete Success!
                alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-green-50 text-green-700 border border-green-200';
                alertBox.innerHTML = '<i class="las la-check-circle text-lg mr-1"></i> ' + data.message + ' Ref: ' + data.data.reference;
                alertBox.classList.remove('hidden');
                
                resetBettingForm();
            }
        } catch (error) {
            alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
            alertBox.innerHTML = '<i class="las la-wifi text-lg mr-1"></i> Network error.';
            alertBox.classList.remove('hidden');
            btn.innerHTML = '<i class="las la-wallet text-xl"></i> Fund Wallet & Deduct Fee';
            btn.disabled = false;
        }
    }

    // Reset Betting Flow back to Step 1
    function resetBettingForm() {
        document.getElementById('bettingFundForm').reset();
        document.getElementById('bettingFundForm').classList.add('hidden');
        
        document.getElementById('betting_provider').disabled = false;
        document.getElementById('betting_customer_id').disabled = false;
        
        const verifyBtn = document.getElementById('betting_verify_btn');
        verifyBtn.classList.remove('hidden');
        verifyBtn.innerHTML = '<i class="las la-search text-xl"></i> Verify Customer ID';
        verifyBtn.disabled = false;
    }

    // ==========================================
    // DATA LOGIC (Step 1: Fetch Plans)
    // ==========================================
    async function fetchDataPackages(e) {
        e.preventDefault();
        const btn = document.getElementById('data_fetch_btn');
        const alertBox = document.getElementById('data-alert');
        const csrfToken = document.querySelector('input[name="_token"]').value;

        btn.innerHTML = '<i class="las la-spinner animate-spin text-xl"></i> Fetching Plans...';
        btn.disabled = true;
        alertBox.classList.add('hidden');

        try {
            const response = await fetch('{{ url("/merchant/api/vas/data/plans") }}', { // Added /merchant
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({
            phone: document.getElementById('data_phone').value,
            network: document.getElementById('data_network').value
        })
    });

            const res = await response.json();

            if (!response.ok) {
                alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
                alertBox.innerHTML = '<i class="las la-exclamation-circle text-lg mr-1"></i> ' + (res.error || 'Could not fetch plans.');
                alertBox.classList.remove('hidden');
                btn.innerHTML = '<i class="las la-sync text-xl"></i> View Available Data Plans';
                btn.disabled = false;
            } else {
                // Populate Dropdown
                const planSelect = document.getElementById('data_plan');
                planSelect.innerHTML = '<option value="">Choose a plan...</option>';
                
                if(Array.isArray(res.data) && res.data.length > 0) {
                    res.data.forEach(plan => {
                        // Check for Allen's specific keys (productId, dataBundle, amount) or fallbacks
                        const id = plan.productId || plan.product_id || plan.id;
                        const name = plan.dataBundle || plan.name || plan.description;
                        const price = plan.amount || plan.price;
                        const validity = plan.validity ? ` (${plan.validity})` : '';

                        planSelect.innerHTML += `<option value="${id}" data-price="${price}">${name}${validity} - ₦${price}</option>`;
                    });
                } else {
                    alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
                    alertBox.innerHTML = '<i class="las la-exclamation-circle text-lg mr-1"></i> No data plans available for this number.';
                    alertBox.classList.remove('hidden');
                    btn.innerHTML = '<i class="las la-sync text-xl"></i> View Available Data Plans';
                    btn.disabled = false;
                    return;
                }

                document.getElementById('data_network').disabled = true;
                document.getElementById('data_phone').disabled = true;
                
                btn.classList.add('hidden');
                document.getElementById('dataPurchaseForm').classList.remove('hidden');
            }
        } catch (error) {
            alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
            alertBox.innerHTML = '<i class="las la-wifi text-lg mr-1"></i> Network error.';
            alertBox.classList.remove('hidden');
            btn.innerHTML = '<i class="las la-sync text-xl"></i> View Available Data Plans';
            btn.disabled = false;
        }
    }

    function updateDataAmount() {
        const select = document.getElementById('data_plan');
        const price = select.options[select.selectedIndex].getAttribute('data-price');
        document.getElementById('data_amount').value = price || '';
    }

    // ==========================================
    // DATA LOGIC (Step 2: Purchase)
    // ==========================================
    async function handleDataPurchase(e) {
        e.preventDefault();
        const btn = document.getElementById('data_purchase_btn');
        const alertBox = document.getElementById('data-alert');
        const csrfToken = document.querySelector('input[name="_token"]').value;

        btn.innerHTML = '<i class="las la-spinner animate-spin text-xl"></i> Purchasing Data...';
        btn.disabled = true;
        alertBox.classList.add('hidden');

        try {
            const response = await fetch('{{ url("/merchant/api/vas/data/purchase") }}', { // Added /merchant
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({
            phone: document.getElementById('data_phone').value,
            network: document.getElementById('data_network').value,
            product_id: document.getElementById('data_plan').value,
            sourceAccountNumber: document.getElementById('data_source').value,
            amount: document.getElementById('data_amount').value,
            pin: document.getElementById('data_pin').value
        })
    });

            const data = await response.json();

            if (!response.ok) {
                alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
                alertBox.innerHTML = '<i class="las la-exclamation-circle text-lg mr-1"></i> ' + (data.error || 'Transaction failed.');
                alertBox.classList.remove('hidden');
                btn.innerHTML = '<i class="las la-wifi text-xl"></i> Purchase Data';
                btn.disabled = false;
            } else {
                alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-green-50 text-green-700 border border-green-200';
                alertBox.innerHTML = '<i class="las la-check-circle text-lg mr-1"></i> ' + data.message + ' Ref: ' + data.data.reference;
                alertBox.classList.remove('hidden');
                resetDataForm();
            }
        } catch (error) {
            alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
            alertBox.innerHTML = '<i class="las la-wifi text-lg mr-1"></i> Network error.';
            alertBox.classList.remove('hidden');
            btn.innerHTML = '<i class="las la-wifi text-xl"></i> Purchase Data';
            btn.disabled = false;
        }
    }

    function resetDataForm() {
        document.getElementById('dataPurchaseForm').reset();
        document.getElementById('dataPurchaseForm').classList.add('hidden');
        document.getElementById('data_network').disabled = false;
        document.getElementById('data_phone').disabled = false;
        
        const verifyBtn = document.getElementById('data_fetch_btn');
        verifyBtn.classList.remove('hidden');
        verifyBtn.innerHTML = '<i class="las la-sync text-xl"></i> View Available Data Plans';
        verifyBtn.disabled = false;
    }

    // ==========================================
    // ELECTRICITY LOGIC (Step 1: Verify)
    // ==========================================
    async function verifyMeter(e) {
        e.preventDefault();
        const btn = document.getElementById('power_verify_btn');
        const alertBox = document.getElementById('power-alert');
        const csrfToken = document.querySelector('input[name="_token"]').value;

        btn.innerHTML = '<i class="las la-spinner animate-spin text-xl"></i> Verifying Meter...';
        btn.disabled = true;
        alertBox.classList.add('hidden');

        try {
            const response = await fetch('{{ url("/merchant/api/utility/meter/verify") }}', { 
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({
            meter_number: document.getElementById('power_meter_number').value,
            biller_id: document.getElementById('power_disco').value,
            meter_type: document.getElementById('power_meter_type').value
        })
    });

            const data = await response.json();

            if (!response.ok) {
                let exactError = data.error || data.message || 'Unknown Server Error';
                if (data.errors) exactError += ' - ' + JSON.stringify(data.errors);

                alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200 overflow-x-auto';
                let errorHtml = '<i class="las la-exclamation-circle text-lg mr-1"></i> <strong>Error:</strong> ' + exactError;
                
                if (data.raw_response) {
                    errorHtml += '<br><span class="text-xs text-red-500 mt-2 block font-mono bg-red-100 p-2 rounded">Raw API: ' + JSON.stringify(data.raw_response) + '</span>';
                }
                
                alertBox.innerHTML = errorHtml;
                alertBox.classList.remove('hidden');
                btn.innerHTML = '<i class="las la-search text-xl"></i> Verify Meter';
                btn.disabled = false;
            } else {
                document.getElementById('power_customer_name').innerText = data.data.customer_name;
                document.getElementById('power_address').innerText = data.data.address;
                
                document.getElementById('power_disco').disabled = true;
                document.getElementById('power_meter_type').disabled = true;
                document.getElementById('power_meter_number').disabled = true;
                
                window.powerSessionHash = data.data.other_field;
                
                btn.classList.add('hidden');
                document.getElementById('powerPurchaseForm').classList.remove('hidden');
            }
        } catch (error) {
            alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
            alertBox.innerHTML = '<i class="las la-wifi text-lg mr-1"></i> Network error.';
            alertBox.classList.remove('hidden');
            btn.innerHTML = '<i class="las la-search text-xl"></i> Verify Meter';
            btn.disabled = false;
        }
    }

    // ==========================================
    // ELECTRICITY LOGIC (Step 2: Pay)
    // ==========================================
    async function handlePowerPayment(e) {
        e.preventDefault();
        const btn = document.getElementById('power_pay_btn');
        const alertBox = document.getElementById('power-alert');
        const csrfToken = document.querySelector('input[name="_token"]').value;

        btn.innerHTML = '<i class="las la-spinner animate-spin text-xl"></i> Processing Payment...';
        btn.disabled = true;
        alertBox.classList.add('hidden');

        try {
            const response = await fetch('{{ url("/merchant/api/utility/electricity/purchase") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({
                    meter_number: document.getElementById('power_meter_number').value,
                    biller_id: document.getElementById('power_disco').value,
                    meter_type: document.getElementById('power_meter_type').value,
                    account_number: document.getElementById('power_source').value,
                    amount: document.getElementById('power_amount').value,
                    pin: document.getElementById('power_pin').value,
                    customer_name: document.getElementById('power_customer_name').innerText,
                    customer_phone: '08000000000',
                    other_field: window.powerSessionHash
                })
            });

            const data = await response.json();

            if (!response.ok) {
                alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
                alertBox.innerHTML = '<i class="las la-exclamation-circle text-lg mr-1"></i> ' + (data.error || 'Transaction failed.');
                alertBox.classList.remove('hidden');
                btn.innerHTML = '<i class="las la-bolt text-xl"></i> Generate Token & Pay';
                btn.disabled = false;
            } else {
                alertBox.className = 'p-6 rounded-lg text-sm font-bold mb-4 bg-green-50 text-green-800 border border-green-200 shadow-sm';
                // Highlight the generated token
                alertBox.innerHTML = `
                    <div class="flex items-center gap-2 mb-2">
                        <i class="las la-check-circle text-2xl text-green-600"></i>
                        <span class="text-lg">Payment Successful!</span>
                    </div>
                    <p class="text-slate-600 font-medium mb-3">Your meter token has been generated:</p>
                    <div class="bg-white border border-green-200 p-3 rounded-lg font-mono text-2xl tracking-widest text-center text-[#003366] shadow-inner mb-2">
                        ${data.data.token}
                    </div>
                    <p class="text-xs text-slate-500 text-center">Ref: ${data.data.reference} | Units: ${data.data.units}</p>
                `;
                alertBox.classList.remove('hidden');
                resetPowerForm();
            }
        } catch (error) {
            alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
            alertBox.innerHTML = '<i class="las la-wifi text-lg mr-1"></i> Network error.';
            alertBox.classList.remove('hidden');
            btn.innerHTML = '<i class="las la-bolt text-xl"></i> Generate Token & Pay';
            btn.disabled = false;
        }
    }

    function resetPowerForm() {
        document.getElementById('powerPurchaseForm').reset();
        document.getElementById('powerPurchaseForm').classList.add('hidden');
        
        document.getElementById('power_disco').disabled = false;
        document.getElementById('power_meter_type').disabled = false;
        document.getElementById('power_meter_number').disabled = false;
        
        const verifyBtn = document.getElementById('power_verify_btn');
        verifyBtn.classList.remove('hidden');
        verifyBtn.innerHTML = '<i class="las la-search text-xl"></i> Verify Meter';
        verifyBtn.disabled = false;
    }

    // ==========================================
    // TV LOGIC
    // ==========================================
    async function verifyTv(e) {
        e.preventDefault();
        const btn = document.getElementById('tv_verify_btn');
        const alertBox = document.getElementById('tv-alert');
        const csrfToken = document.querySelector('input[name="_token"]').value;

        btn.innerHTML = '<i class="las la-spinner animate-spin text-xl"></i> Verifying...';
        btn.disabled = true;
        alertBox.classList.add('hidden');

        try {
            const packageSelect = document.getElementById('tv_package_code');
            const selectedPrice = packageSelect.options[packageSelect.selectedIndex].getAttribute('data-price');
            
            const response = await fetch('{{ url("/merchant/api/tv/verify") }}', { 
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({
                    smartcard_number: document.getElementById('tv_smartcard_number').value,
                    biller_id: document.getElementById('tv_biller').value,
                    package_code: packageSelect.value,
                    amount: selectedPrice || document.getElementById('tv_amount').value
                })
            });

            const data = await response.json();

            if (!response.ok) {
                let exactError = data.error || data.message || 'Unknown Server Error';
                if (data.errors) exactError += ' - ' + JSON.stringify(data.errors);

                alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200 overflow-x-auto';
                let errorHtml = '<i class="las la-exclamation-circle text-lg mr-1"></i> <strong>Error:</strong> ' + exactError;
                
                if (data.raw_response) {
                    errorHtml += '<br><span class="text-xs text-red-500 mt-2 block font-mono bg-red-100 p-2 rounded">Raw API: ' + JSON.stringify(data.raw_response) + '</span>';
                }
                
                alertBox.innerHTML = errorHtml;
                alertBox.classList.remove('hidden');
                btn.innerHTML = '<i class="las la-search text-xl"></i> Verify Smartcard';
                btn.disabled = false;
            } else {
                document.getElementById('tv_customer_name').innerText = data.data.customer_name;
                
                document.getElementById('tv_biller').disabled = true;
                document.getElementById('tv_package_code').disabled = true;
                document.getElementById('tv_smartcard_number').disabled = true;
                
                btn.classList.add('hidden');
                document.getElementById('tvPurchaseForm').classList.remove('hidden');
            }
        } catch (error) {
            alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
            alertBox.innerHTML = '<i class="las la-wifi text-lg mr-1"></i> Network error.';
            alertBox.classList.remove('hidden');
            btn.innerHTML = '<i class="las la-search text-xl"></i> Verify Smartcard';
            btn.disabled = false;
        }
    }

    async function handleTvPayment(e) {
        e.preventDefault();
        const btn = document.getElementById('tv_pay_btn');
        const alertBox = document.getElementById('tv-alert');
        const csrfToken = document.querySelector('input[name="_token"]').value;

        btn.innerHTML = '<i class="las la-spinner animate-spin text-xl"></i> Processing...';
        btn.disabled = true;
        alertBox.classList.add('hidden');

        try {
            const response = await fetch('{{ url("/merchant/api/tv/purchase") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({
                    smartcard_number: document.getElementById('tv_smartcard_number').value,
                    biller_id: document.getElementById('tv_biller').value,
                    package_code: document.getElementById('tv_package_code').value,
                    source_account: document.getElementById('tv_source').value,
                    amount: document.getElementById('tv_amount').value,
                    pin: document.getElementById('tv_pin').value,
                    customer_name: document.getElementById('tv_customer_name').innerText,
                    customer_phone: '08000000000'
                })
            });

            const data = await response.json();

            if (!response.ok) {
                alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
                alertBox.innerHTML = '<i class="las la-exclamation-circle text-lg mr-1"></i> ' + (data.error || 'Transaction failed.');
                alertBox.classList.remove('hidden');
                btn.innerHTML = '<i class="las la-tv text-xl"></i> Pay Subscription';
                btn.disabled = false;
            } else {
                alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-green-50 text-green-700 border border-green-200';
                alertBox.innerHTML = '<i class="las la-check-circle text-lg mr-1"></i> ' + data.message + ' Ref: ' + data.data.reference;
                alertBox.classList.remove('hidden');
                
                setTimeout(() => resetTvForm(), 3000);
            }
        } catch (error) {
            alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
            alertBox.innerHTML = '<i class="las la-wifi text-lg mr-1"></i> Network error.';
            alertBox.classList.remove('hidden');
            btn.innerHTML = '<i class="las la-tv text-xl"></i> Pay Subscription';
            btn.disabled = false;
        }
    }

    function resetTvForm() {
        document.getElementById('tvPurchaseForm').reset();
        document.getElementById('tvPurchaseForm').classList.add('hidden');
        
        document.getElementById('tv_biller').disabled = false;
        document.getElementById('tv_package_code').disabled = false;
        document.getElementById('tv_smartcard_number').disabled = false;
        
        const verifyBtn = document.getElementById('tv_verify_btn');
        verifyBtn.classList.remove('hidden');
        verifyBtn.innerHTML = '<i class="las la-search text-xl"></i> Verify Smartcard';
        verifyBtn.disabled = false;
    }

    // Auto-fetch Betting Providers when the page loads
    window.addEventListener('DOMContentLoaded', async () => {
        try {
            const response = await fetch('{{ url("/merchant/api/betting/providers") }}', {
                method: 'GET',
                headers: { 'Accept': 'application/json' }
            });
            const res = await response.json();
            
            if ((res.success || res.status === 'success') && Array.isArray(res.data)) {
                const providerSelect = document.getElementById('betting_provider');
                providerSelect.innerHTML = '<option value="">Select a Provider...</option>';
                
                // Loops through the live providers and adds them to the dropdown
                res.data.forEach(biller => {
                    // Adjust 'billerId' or 'name' based on the exact keys Allen's API returns
                    providerSelect.innerHTML += `<option value="${biller.biller_id || biller.id}">${biller.biller_name || biller.name}</option>`;
                });
            }
        } catch (error) {
            console.error("Could not load live betting providers.");
        }
    });

    // Auto-fetch Electricity Discos when the page loads
    window.addEventListener('DOMContentLoaded', async () => {
        try {
            const response = await fetch('{{ url("/merchant/api/utility/providers") }}', {
                method: 'GET',
                headers: { 'Accept': 'application/json' }
            });
            const res = await response.json();
            
            if ((res.success || res.status === 'success') && Array.isArray(res.data)) {
                const discoSelect = document.getElementById('power_disco');
                discoSelect.innerHTML = '<option value="">Select a DISCO...</option>';
                
                res.data.forEach(biller => {
                    discoSelect.innerHTML += `<option value="${biller.biller_id || biller.id}">${biller.biller_name || biller.name}</option>`;
                });
            }
        } catch (error) {
            console.error("Could not load live electricity providers.");
        }
    });

    // Dynamic Meter Type fetching
    document.getElementById('power_disco').addEventListener('change', async function() {
        const billerId = this.value;
        const typeSelect = document.getElementById('power_meter_type');
        
        if (!billerId) {
            typeSelect.innerHTML = '<option value="VT01">Prepaid</option><option value="VT02">Postpaid</option>';
            return;
        }

        typeSelect.innerHTML = '<option value="">Loading...</option>';
        typeSelect.disabled = true;

        try {
            const response = await fetch('{{ url("/merchant/api/utility/electricity/billers") }}/' + billerId + '/items', {
                method: 'GET',
                headers: { 'Accept': 'application/json' }
            });
            const res = await response.json();
            
            typeSelect.innerHTML = '<option value="">Select Meter Type...</option>';
            if ((res.success || res.status === 'success') && Array.isArray(res.data)) {
                res.data.forEach(item => {
                    typeSelect.innerHTML += `<option value="${item.itemId || item.item_id || item.id}">${item.itemName || item.item_name || item.name}</option>`;
                });
            } else {
                typeSelect.innerHTML = '<option value="VT01">Prepaid</option><option value="VT02">Postpaid</option>';
            }
        } catch (error) {
            console.error("Could not load biller items.");
            typeSelect.innerHTML = '<option value="VT01">Prepaid</option><option value="VT02">Postpaid</option>';
        } finally {
            typeSelect.disabled = false;
        }
    });
    // Auto-fetch TV Providers when the page loads
    window.addEventListener('DOMContentLoaded', async () => {
        try {
            const response = await fetch('{{ url("/merchant/api/tv/providers") }}', {
                method: 'GET',
                headers: { 'Accept': 'application/json' }
            });
            const res = await response.json();
            
            if ((res.success || res.status === 'success') && Array.isArray(res.data)) {
                const tvBillerSelect = document.getElementById('tv_biller');
                tvBillerSelect.innerHTML = '<option value="">Select a Biller...</option>';
                
                res.data.forEach(biller => {
                    tvBillerSelect.innerHTML += `<option value="${biller.biller_id || biller.id}">${biller.biller_name || biller.name}</option>`;
                });
            }
        } catch (error) {
            console.error("Could not load live TV providers.");
        }
    });

    // Dynamic TV Package fetching
    document.getElementById('tv_biller').addEventListener('change', async function() {
        const billerId = this.value;
        const packageSelect = document.getElementById('tv_package_code');
        
        if (!billerId) {
            packageSelect.innerHTML = '<option value="">Select a Biller first...</option>';
            return;
        }

        packageSelect.innerHTML = '<option value="">Loading...</option>';
        packageSelect.disabled = true;

        try {
            const response = await fetch('{{ url("/merchant/api/tv/billers") }}/' + billerId + '/items', {
                method: 'GET',
                headers: { 'Accept': 'application/json' }
            });
            const res = await response.json();
            
            packageSelect.innerHTML = '<option value="">Select Package...</option>';
            if ((res.success || res.status === 'success') && Array.isArray(res.data)) {
                res.data.forEach(item => {
                    const price = item.amount || item.price || '';
                    const priceLabel = price ? ` - ₦${price}` : '';
                    packageSelect.innerHTML += `<option value="${item.itemId || item.item_id || item.id}" data-price="${price}">${item.itemName || item.item_name || item.name}${priceLabel}</option>`;
                });
            } else {
                packageSelect.innerHTML = '<option value="">No packages found.</option>';
            }
        } catch (error) {
            console.error("Could not load TV packages.");
            packageSelect.innerHTML = '<option value="">Error loading packages.</option>';
        } finally {
            packageSelect.disabled = false;
        }
    });

    // Auto-fill amount when a TV package is selected
    document.getElementById('tv_package_code').addEventListener('change', function() {
        const price = this.options[this.selectedIndex].getAttribute('data-price');
        if (price) {
            const amountInput = document.getElementById('tv_amount');
            amountInput.value = price;
            // amountInput.readOnly = true; // Optional: lock the amount
        }
    });

    // ==========================================
    // EXAMS LOGIC
    // ==========================================
    async function verifyExams(e) {
        e.preventDefault();
        const btn = document.getElementById('exams_verify_btn');
        const alertBox = document.getElementById('exams-alert');
        const csrfToken = document.querySelector('input[name="_token"]').value;

        btn.innerHTML = '<i class="las la-spinner animate-spin text-xl"></i> Verifying...';
        btn.disabled = true;
        alertBox.classList.add('hidden');

        try {
            const packageSelect = document.getElementById('exams_package_code');
            const selectedPrice = packageSelect.options[packageSelect.selectedIndex].getAttribute('data-price');
            const amount = selectedPrice || 0;
            
            const response = await fetch('{{ url("/merchant/api/exams/verify") }}', { 
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({
                    customer_name: document.getElementById('exams_customer_name').value,
                    phone: document.getElementById('exams_phone').value,
                    biller_id: document.getElementById('exams_biller').value,
                    package_code: packageSelect.value,
                    amount: amount
                })
            });

            const data = await response.json();

            if (!response.ok || (data.status !== 'success')) {
                let exactError = data.error || data.message || 'Unknown Server Error';
                if (data.errors) exactError += ' - ' + JSON.stringify(data.errors);

                alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200 overflow-x-auto';
                let errorHtml = '<i class="las la-exclamation-circle text-lg mr-1"></i> <strong>Error:</strong> ' + exactError;
                alertBox.innerHTML = errorHtml;
                alertBox.classList.remove('hidden');
                btn.innerHTML = '<i class="las la-search text-xl"></i> Verify & Check Cost';
                btn.disabled = false;
            } else {
                document.getElementById('exams_customer_name_display').innerText = document.getElementById('exams_customer_name').value;
                document.getElementById('exams_amount').value = data.total_cost || amount;
                
                document.getElementById('exams_biller').disabled = true;
                document.getElementById('exams_package_code').disabled = true;
                document.getElementById('exams_customer_name').disabled = true;
                document.getElementById('exams_phone').disabled = true;
                
                btn.classList.add('hidden');
                document.getElementById('examsPurchaseForm').classList.remove('hidden');
            }
        } catch (error) {
            alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
            alertBox.innerHTML = '<i class="las la-wifi text-lg mr-1"></i> Network error.';
            alertBox.classList.remove('hidden');
            btn.innerHTML = '<i class="las la-search text-xl"></i> Verify & Check Cost';
            btn.disabled = false;
        }
    }

    async function handleExamsPayment(e) {
        e.preventDefault();
        const btn = document.getElementById('exams_pay_btn');
        const alertBox = document.getElementById('exams-alert');
        const csrfToken = document.querySelector('input[name="_token"]').value;

        btn.innerHTML = '<i class="las la-spinner animate-spin text-xl"></i> Processing...';
        btn.disabled = true;
        alertBox.classList.add('hidden');

        try {
            const packageSelect = document.getElementById('exams_package_code');
            const selectedPrice = packageSelect.options[packageSelect.selectedIndex].getAttribute('data-price');
            
            const response = await fetch('{{ url("/merchant/api/exams/purchase") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({
                    phone: document.getElementById('exams_phone').value,
                    biller_id: document.getElementById('exams_biller').value,
                    package_code: document.getElementById('exams_package_code').value,
                    source_account: document.getElementById('exams_source').value,
                    amount: selectedPrice, // Base price before fee
                    pin: document.getElementById('exams_pin').value,
                    customer_name: document.getElementById('exams_customer_name').value
                })
            });

            const data = await response.json();

            if (!response.ok) {
                alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
                alertBox.innerHTML = '<i class="las la-exclamation-circle text-lg mr-1"></i> ' + (data.error || 'Transaction failed.');
                alertBox.classList.remove('hidden');
                btn.innerHTML = '<i class="las la-graduation-cap text-xl"></i> Purchase Exam PIN';
                btn.disabled = false;
            } else {
                alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-green-50 text-green-700 border border-green-200';
                
                // Show PIN returned in provider data if any
                let successMsg = '<i class="las la-check-circle text-lg mr-1"></i> ' + data.message + '<br>Ref: ' + data.data.reference;
                if(data.data.provider_data && data.data.provider_data.pin) {
                    successMsg += '<br><strong class="text-lg text-green-900 mt-2 block">PIN: ' + data.data.provider_data.pin + '</strong>';
                }
                
                alertBox.innerHTML = successMsg;
                alertBox.classList.remove('hidden');
                
                setTimeout(() => resetExamsForm(), 10000); // 10 seconds to allow reading the pin
            }
        } catch (error) {
            alertBox.className = 'p-4 rounded-lg text-sm font-bold mb-4 bg-red-50 text-red-700 border border-red-200';
            alertBox.innerHTML = '<i class="las la-wifi text-lg mr-1"></i> Network error.';
            alertBox.classList.remove('hidden');
            btn.innerHTML = '<i class="las la-graduation-cap text-xl"></i> Purchase Exam PIN';
            btn.disabled = false;
        }
    }

    function resetExamsForm() {
        document.getElementById('examsPurchaseForm').reset();
        document.getElementById('examsVerifyForm').reset();
        document.getElementById('examsPurchaseForm').classList.add('hidden');
        
        document.getElementById('exams_biller').disabled = false;
        document.getElementById('exams_package_code').disabled = false;
        document.getElementById('exams_customer_name').disabled = false;
        document.getElementById('exams_phone').disabled = false;
        
        const verifyBtn = document.getElementById('exams_verify_btn');
        verifyBtn.classList.remove('hidden');
        verifyBtn.innerHTML = '<i class="las la-search text-xl"></i> Verify & Check Cost';
        verifyBtn.disabled = false;
        
        document.getElementById('exams-alert').classList.add('hidden');
    }

    // Auto-fetch Exams Providers when the page loads
    window.addEventListener('DOMContentLoaded', async () => {
        try {
            const response = await fetch('{{ url("/merchant/api/exams/providers") }}', {
                method: 'GET',
                headers: { 'Accept': 'application/json' }
            });
            const res = await response.json();
            
            if ((res.success || res.status === 'success') && Array.isArray(res.data)) {
                const examsBillerSelect = document.getElementById('exams_biller');
                examsBillerSelect.innerHTML = '<option value="">Select a Biller...</option>';
                
                res.data.forEach(biller => {
                    examsBillerSelect.innerHTML += `<option value="${biller.biller_id || biller.id}">${biller.biller_name || biller.name}</option>`;
                });
            }
        } catch (error) {
            console.error("Could not load live Exams providers.");
        }
    });

    // Dynamic Exams Package fetching
    document.getElementById('exams_biller').addEventListener('change', async function() {
        const billerId = this.value;
        const packageSelect = document.getElementById('exams_package_code');
        
        if (!billerId) {
            packageSelect.innerHTML = '<option value="">Select a Biller first...</option>';
            return;
        }

        packageSelect.innerHTML = '<option value="">Loading...</option>';
        packageSelect.disabled = true;

        try {
            const response = await fetch('{{ url("/merchant/api/exams/billers") }}/' + billerId + '/items', {
                method: 'GET',
                headers: { 'Accept': 'application/json' }
            });
            const res = await response.json();
            
            packageSelect.innerHTML = '<option value="">Select Package...</option>';
            if ((res.success || res.status === 'success') && Array.isArray(res.data)) {
                res.data.forEach(item => {
                    const price = item.amount || item.price || '';
                    const priceLabel = price ? ` - ₦${price}` : '';
                    packageSelect.innerHTML += `<option value="${item.itemId || item.item_id || item.id}" data-price="${price}">${item.itemName || item.item_name || item.name}${priceLabel}</option>`;
                });
            } else {
                packageSelect.innerHTML = '<option value="">No packages found.</option>';
            }
        } catch (error) {
            console.error("Could not load Exams packages.");
            packageSelect.innerHTML = '<option value="">Error loading packages.</option>';
        } finally {
            packageSelect.disabled = false;
        }
    });

</script>
@endsection