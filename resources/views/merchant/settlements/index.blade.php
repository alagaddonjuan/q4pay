@extends('layout.merchant')

@section('content')
@php
    $userRole = auth('team_member')->check() ? auth('team_member')->user()->role : 'merchant';
    $canRequest = in_array($userRole, ['merchant', 'admin', 'finance']);
    $canApprove = in_array($userRole, ['merchant', 'admin']);
    
    $pendingApprovalsCount = $payouts->where('status', 'pending_approval')->count();
@endphp

<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-[#003366]">Settlements & Payouts</h2>
        <p class="text-sm text-slate-500 mt-1">Withdraw your collected funds to your corporate bank account.</p>
    </div>
</div>


@if($errors->any())
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
        <div class="flex items-center gap-3 text-red-700 mb-2">
            <i class="las la-exclamation-triangle text-xl"></i>
            <p class="text-sm font-bold">Oops! Something went wrong:</p>
        </div>
        <ul class="list-disc list-inside text-sm text-red-600 ml-8">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(!$merchant->transaction_pin)
    <div class="mb-6 bg-orange-50 border-l-4 border-orange-500 p-4 rounded-r-xl shadow-sm flex items-center justify-between">
        <div class="flex items-center gap-3 text-orange-700">
            <i class="las la-lock text-3xl"></i>
            <div>
                <p class="font-bold text-sm">Transaction PIN Required</p>
                <p class="text-xs">You must set up a secure 4-digit PIN before you can withdraw funds.</p>
            </div>
        </div>
        <button onclick="document.getElementById('setupPinModal').classList.remove('hidden')" class="px-5 py-2 bg-orange-600 text-white text-sm font-bold rounded-lg hover:bg-orange-700 transition-colors shadow-sm">
            Setup PIN Now
        </button>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="box col-span-1 lg:col-span-2 bg-white rounded-2xl shadow-sm border-t-4 border-t-[#003366] border-x border-b border-slate-200 p-8 flex flex-col justify-center relative overflow-hidden">
        <i class="las la-wallet absolute -right-6 -bottom-6 text-9xl text-slate-50 opacity-50 pointer-events-none"></i>
        
        <div class="relative z-10">
            <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Available for Settlement</p>
            <h3 class="text-5xl font-black text-[#003366] mb-6">₦{{ number_format($availableBalance, 2) }}</h3>
            
            <div class="flex gap-4">
                @if($canRequest)
                    <button onclick="document.getElementById('payoutModal').classList.remove('hidden')" class="flex items-center gap-2 rounded-xl px-6 py-3 font-bold shadow-sm transition-all hover:-translate-y-1 hover:shadow-md" style="background-color: #D20103; color: white;">
                        <i class="las la-money-bill-wave text-xl"></i> 
                        <span>Request Payout</span>
                    </button>
                @else
                    <button disabled class="flex items-center gap-2 rounded-xl px-6 py-3 font-bold bg-slate-300 text-slate-500 cursor-not-allowed">
                        <i class="las la-lock text-xl"></i> 
                        <span>Not Authorized to Request</span>
                    </button>
                @endif
            </div>
        </div>
    </div>

    <div class="box col-span-1 bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col">
        <div class="flex items-center justify-between mb-6">
            <h4 class="font-bold text-[#003366]">Settlement Accounts</h4>
            <button class="text-[#D20103] hover:bg-red-50 p-1.5 rounded text-sm font-bold transition-colors" onclick="document.getElementById('addBankModal').classList.remove('hidden')">
                <i class="las la-plus"></i> Add
            </button>
        </div>

        <div class="flex-1 flex flex-col gap-3">
            @forelse($savedBanks as $bank)
                <div class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 bg-slate-50">
                    <div class="flex size-10 items-center justify-center rounded-full bg-white shadow-sm text-[#003366]">
                        <i class="las la-university text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-slate-700 text-sm truncate">{{ $bank->account_name }}</p>
                        <p class="text-xs text-slate-500">{{ $bank->bank_name }} • {{ substr($bank->account_number, -4) }}</p>
                    </div>
                    @if($bank->is_default ?? false)
                        <span class="text-xs font-bold text-green-600 bg-green-100 px-2 py-0.5 rounded">Default</span>
                    @endif
                </div>
            @empty
                <div class="flex-1 flex flex-col items-center justify-center text-center p-4 border-2 border-dashed border-slate-200 rounded-xl">
                    <i class="las la-university text-3xl text-slate-300 mb-2"></i>
                    <p class="text-sm font-bold text-slate-500">No accounts linked</p>
                    <p class="text-xs text-slate-400 mt-1">Add a bank account to receive payouts.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<div class="box bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-8">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h4 class="font-bold text-[#003366]">Automated Sweeps</h4>
            <p class="text-xs text-slate-500 mt-1">Configure auto-withdrawal rules for your master wallet.</p>
        </div>
        <button onclick="document.getElementById('autoSweepModal').classList.remove('hidden')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-[#003366] text-sm font-bold rounded-lg transition-colors">
            Configure
        </button>
    </div>
    <div class="p-6">
        @if($merchant->auto_sweep_enabled)
            <div class="flex items-center justify-between p-4 bg-green-50 border border-green-200 rounded-xl">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                        <i class="las la-sync la-spin text-xl"></i>
                    </div>
                    <div>
                        <p class="font-bold text-green-800 text-sm">Auto-Sweep is Active</p>
                        <p class="text-xs text-green-700 mt-1">
                            Frequency: <strong class="uppercase">{{ $merchant->auto_sweep_frequency }}</strong> 
                            @if($merchant->auto_sweep_frequency === 'threshold')
                                (Threshold: ₦{{ number_format($merchant->auto_sweep_threshold, 2) }})
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-200 rounded-xl">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-full bg-white shadow-sm text-slate-400 flex items-center justify-center">
                        <i class="las la-power-off text-xl"></i>
                    </div>
                    <div>
                        <p class="font-bold text-slate-700 text-sm">Auto-Sweep is Disabled</p>
                        <p class="text-xs text-slate-500 mt-1">Enable auto-sweep to automatically withdraw funds without manual intervention.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="box bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-8">
    <div class="border-b border-slate-100 bg-slate-50">
        <ul class="flex flex-wrap -mb-px text-sm font-bold text-center text-slate-500">
            <li class="me-2">
                <button onclick="switchTab('history')" id="tab-btn-history" class="inline-flex items-center gap-2 px-6 py-4 border-b-2 text-[#003366] border-[#003366] rounded-t-lg active group">
                    <i class="las la-history text-lg"></i>
                    Settlement History
                </button>
            </li>
            @if($canApprove)
                <li class="me-2">
                    <button onclick="switchTab('approvals')" id="tab-btn-approvals" class="inline-flex items-center gap-2 px-6 py-4 border-b-2 border-transparent hover:text-slate-600 hover:border-slate-300 rounded-t-lg group relative">
                        <i class="las la-clipboard-check text-lg"></i>
                        Pending Approvals
                        @if($pendingApprovalsCount > 0)
                            <span class="inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-red-500 rounded-full">{{ $pendingApprovalsCount }}</span>
                        @endif
                    </button>
                </li>
            @endif
        </ul>
    </div>

    <!-- HISTORY TAB -->
    <div id="tab-content-history" class="overflow-x-auto tab-content block">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="bg-white border-b border-slate-200">
                    <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">Reference</th>
                    <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">Destination Account</th>
                    <th class="px-6 py-4 text-end text-xs font-bold uppercase tracking-wider text-slate-500">Amount</th>
                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                    <th class="px-6 py-4 text-end text-xs font-bold uppercase tracking-wider text-slate-500">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payouts->where('status', '!=', 'pending_approval') as $payout)
                    <tr class="border-b border-slate-50 hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-bold text-[#003366]">{{ $payout->session_id }}</td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-700 text-sm">{{ str_replace('Payout to ', '', $payout->remarks) }}</p>
                        </td>
                        <td class="px-6 py-4 text-end font-black text-[#003366]">₦{{ number_format($payout->amount, 2) }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($payout->status === 'pending')
                                <span class="inline-flex items-center gap-1 rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-bold text-yellow-700">
                                    <div class="size-1.5 rounded-full bg-yellow-500 animate-pulse"></div> Pending
                                </span>
                            @elseif($payout->status === 'successful')
                                <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-bold text-green-700">
                                    <div class="size-1.5 rounded-full bg-green-500"></div> Success
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-bold text-red-700">
                                    <div class="size-1.5 rounded-full bg-red-500"></div> Failed
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-end text-xs text-slate-500">
                            {{ \Carbon\Carbon::parse($payout->created_at)->format('d M, Y • h:i A') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            <i class="las la-money-check-alt text-4xl mb-2 text-slate-300"></i>
                            <p>No settlement history found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- APPROVALS TAB -->
    @if($canApprove)
        <div id="tab-content-approvals" class="overflow-x-auto tab-content hidden">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-white border-b border-slate-200">
                        <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">Reference</th>
                        <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">Destination Account</th>
                        <th class="px-6 py-4 text-end text-xs font-bold uppercase tracking-wider text-slate-500">Amount</th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">Action Needed</th>
                        <th class="px-6 py-4 text-end text-xs font-bold uppercase tracking-wider text-slate-500">Date Requested</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payouts->where('status', 'pending_approval') as $payout)
                        <tr class="border-b border-slate-50 hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-[#003366]">{{ $payout->session_id }}</td>
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-700 text-sm">{{ str_replace('Payout to ', '', $payout->remarks) }}</p>
                            </td>
                            <td class="px-6 py-4 text-end font-black text-[#003366]">₦{{ number_format($payout->amount, 2) }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <form action="{{ route('merchant.settlements.approve', $payout->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg font-bold shadow-sm transition-colors flex items-center gap-1">
                                            <i class="las la-check"></i> Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('merchant.settlements.reject', $payout->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-xs bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg font-bold shadow-sm transition-colors flex items-center gap-1">
                                            <i class="las la-times"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-end text-xs text-slate-500">
                                {{ \Carbon\Carbon::parse($payout->created_at)->format('d M, Y • h:i A') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <i class="las la-clipboard-check text-4xl mb-2 text-slate-300"></i>
                                <p>No pending approvals.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    @if(method_exists($payouts, 'hasPages') && $payouts->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $payouts->links() }}
        </div>
    @endif
</div>

<script>
    function switchTab(tabId) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('block'));
        
        // Reset button styles
        document.querySelectorAll('button[id^="tab-btn-"]').forEach(el => {
            el.classList.remove('text-[#003366]', 'border-[#003366]');
            el.classList.add('border-transparent', 'hover:text-slate-600', 'hover:border-slate-300');
        });

        // Show target tab
        document.getElementById('tab-content-' + tabId).classList.remove('hidden');
        document.getElementById('tab-content-' + tabId).classList.add('block');
        
        // Active target button
        const btn = document.getElementById('tab-btn-' + tabId);
        btn.classList.add('text-[#003366]', 'border-[#003366]');
        btn.classList.remove('border-transparent', 'hover:text-slate-600', 'hover:border-slate-300');
    }
</script>

<!-- ADD BANK MODAL -->
<div id="addBankModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h4 class="font-bold text-[#003366]">Add Settlement Account</h4>
            <button onclick="document.getElementById('addBankModal').classList.add('hidden')" class="text-slate-400 hover:text-red-500 transition-colors">
                <i class="las la-times text-2xl"></i>
            </button>
        </div>
        
        <div class="p-6">
            <form action="{{ url('/merchant/settlements/bank/add') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Select Bank</label>
                    <div class="relative">
                        <select name="bank_code" required class="w-full text-sm bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none appearance-none">
                            <option value="" disabled selected>Choose a bank...</option>
                            <option value="120001">9PSB</option>
                            <option value="50515">Moniepoint Microfinance Bank</option>
                            <option value="058">Guaranty Trust Bank</option>
                            <option value="044">Access Bank</option>
                            <option value="057">Zenith Bank</option>
                            <option value="033">United Bank for Africa</option>
                            <option value="090405">Opay</option>
                        </select>
                        <i class="las la-angle-down absolute right-4 top-3.5 text-slate-400 pointer-events-none"></i>
                    </div>
                    <input type="hidden" name="bank_name" id="hiddenBankName">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Account Number</label>
                    <div class="relative">
                        <input type="text" id="accountNumberInput" name="account_number" required maxlength="10" placeholder="10-digit NUBAN account number" class="w-full text-sm bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none">
                        <div id="verifyLoading" class="hidden absolute right-4 top-3.5">
                            <i class="las la-spinner la-spin text-xl text-[#003366]"></i>
                        </div>
                    </div>
                    <p id="verifyError" class="text-xs font-bold text-red-500 mt-1 hidden"></p>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Account Name</label>
                    <input type="text" id="accountNameInput" name="account_name" required readonly placeholder="Account name will appear here" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none text-slate-500">
                </div>
                
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('addBankModal').classList.add('hidden')" class="px-5 py-2.5 rounded-lg font-bold text-slate-600 hover:bg-slate-50 transition-colors border border-slate-200">Cancel</button>
                    <button type="submit" id="saveAccountBtn" disabled class="px-5 py-2.5 rounded-lg font-bold text-white transition-colors hover:bg-blue-900 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed" style="background-color: #003366;">Save Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- PAYOUT MODAL -->
<div id="payoutModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h4 class="font-bold text-[#003366]">Request Payout</h4>
            <button onclick="document.getElementById('payoutModal').classList.add('hidden')" class="text-slate-400 hover:text-red-500 transition-colors">
                <i class="las la-times text-2xl"></i>
            </button>
        </div>
        
        <div class="p-6">
            <form action="{{ url('/merchant/settlements/request') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Destination Account</label>
                    <div class="relative">
                        <select name="bank_account_id" required class="w-full text-sm bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none appearance-none">
                            @if(isset($savedBanks) && $savedBanks->isEmpty())
                                <option value="" disabled selected>No accounts linked. Please add one first.</option>
                            @else
                                <option value="" disabled selected>Select saved account...</option>
                                @foreach($savedBanks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->bank_name }} - {{ substr($bank->account_number, -4) }}</option>
                                @endforeach
                            @endif
                        </select>
                        <i class="las la-angle-down absolute right-4 top-3.5 text-slate-400 pointer-events-none"></i>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Withdrawal Amount (₦)</label>
                    <input type="number" name="amount" required min="100" max="{{ $availableBalance ?? 0 }}" placeholder="e.g. 50000" class="w-full text-sm font-bold text-[#003366] bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none">
                    <div class="flex justify-between items-center mt-2 text-xs">
                        <span class="text-slate-500">Max available: <strong class="text-[#003366]">₦{{ number_format($availableBalance ?? 0, 2) }}</strong></span>
                    </div>
                </div>
                
                <!-- NEW SECURE PIN SHIELD -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-[#D20103] mb-2"><i class="las la-lock"></i> 4-Digit PIN</label>
                    <input type="password" name="pin" required maxlength="4" placeholder="••••" class="w-full text-sm bg-red-50 border border-red-200 rounded-xl px-4 py-3 focus:border-[#D20103] outline-none font-mono text-center tracking-widest text-xl">
                </div>
                
                @if($merchant->two_factor_enabled)
                <div class="mb-6">
                    <label class="block text-sm font-bold text-[#003366] mb-2"><i class="las la-shield-alt"></i> 2FA OTP Code</label>
                    <input type="text" name="totp_code" required maxlength="6" placeholder="000000" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:border-[#003366] outline-none font-mono text-center tracking-widest text-xl">
                    <p class="text-xs text-slate-500 mt-2 text-center">Open your Authenticator app to get the 6-digit code.</p>
                </div>
                @endif
                
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('payoutModal').classList.add('hidden')" class="px-5 py-2.5 rounded-lg font-bold text-slate-600 hover:bg-slate-50 transition-colors border border-slate-200">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-lg font-bold text-white transition-colors hover:bg-red-700 shadow-sm" style="background-color: #D20103;">Withdraw Funds</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="setupPinModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h4 class="font-bold text-[#003366]"><i class="las la-shield-alt"></i> Create Secure PIN</h4>
            <button onclick="document.getElementById('setupPinModal').classList.add('hidden')" class="text-slate-400 hover:text-red-500 transition-colors">
                <i class="las la-times text-2xl"></i>
            </button>
        </div>
        
        <form action="{{ url('/merchant/settings/pin/setup') }}" method="POST" class="p-6">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-bold text-slate-700 mb-2">Enter 4-Digit PIN</label>
                <input type="password" name="pin" required maxlength="4" pattern="\d{4}" placeholder="••••" class="w-full text-center tracking-[1em] text-2xl bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none">
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Confirm 4-Digit PIN</label>
                <input type="password" name="pin_confirmation" required maxlength="4" pattern="\d{4}" placeholder="••••" class="w-full text-center tracking-[1em] text-2xl bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none">
            </div>
            
            <button type="submit" class="w-full py-3 rounded-lg font-bold text-white transition-colors shadow-sm hover:bg-blue-900" style="background-color: #003366;">
                Save Security PIN
            </button>
        </form>
    </div>
</div>

<!-- AUTO SWEEP MODAL -->
<div id="autoSweepModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h4 class="font-bold text-[#003366]"><i class="las la-sync"></i> Configure Auto-Sweep</h4>
            <button onclick="document.getElementById('autoSweepModal').classList.add('hidden')" class="text-slate-400 hover:text-red-500 transition-colors">
                <i class="las la-times text-2xl"></i>
            </button>
        </div>
        
        <div class="p-6">
            <form action="{{ route('merchant.settlements.autosweep') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="auto_sweep_enabled" value="1" {{ $merchant->auto_sweep_enabled ? 'checked' : '' }} class="w-4 h-4 text-[#003366] bg-slate-100 border-slate-300 rounded focus:ring-[#003366]">
                        <span class="text-sm font-bold text-slate-700">Enable Automated Sweeps</span>
                    </label>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Destination Account</label>
                    <div class="relative">
                        <select name="auto_sweep_bank_account_id" class="w-full text-sm bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-[#003366] outline-none appearance-none">
                            <option value="">Select a saved account</option>
                            @foreach($savedBanks as $bank)
                                <option value="{{ $bank->id }}" {{ $merchant->auto_sweep_bank_account_id == $bank->id ? 'selected' : '' }}>
                                    {{ $bank->bank_name }} - {{ substr($bank->account_number, -4) }}
                                </option>
                            @endforeach
                        </select>
                        <i class="las la-angle-down absolute right-4 top-3.5 text-slate-400 pointer-events-none"></i>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Sweep Frequency</label>
                    <div class="relative">
                        <select name="auto_sweep_frequency" id="sweepFrequencySelect" class="w-full text-sm bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-[#003366] outline-none appearance-none">
                            <option value="daily" {{ $merchant->auto_sweep_frequency == 'daily' ? 'selected' : '' }}>Daily (Midnight)</option>
                            <option value="weekly" {{ $merchant->auto_sweep_frequency == 'weekly' ? 'selected' : '' }}>Weekly (Friday)</option>
                            <option value="threshold" {{ $merchant->auto_sweep_frequency == 'threshold' ? 'selected' : '' }}>When Threshold Reached</option>
                        </select>
                        <i class="las la-angle-down absolute right-4 top-3.5 text-slate-400 pointer-events-none"></i>
                    </div>
                </div>

                <div class="mb-6 {{ $merchant->auto_sweep_frequency == 'threshold' ? '' : 'hidden' }}" id="thresholdInputGroup">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Target Threshold (₦)</label>
                    <input type="number" name="auto_sweep_threshold" min="1000" value="{{ $merchant->auto_sweep_threshold ?? 50000 }}" class="w-full text-sm font-bold text-[#003366] bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-[#003366] outline-none">
                </div>
                
                <!-- REQUIRED SECURE PIN SHIELD -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-[#D20103] mb-2"><i class="las la-lock"></i> 4-Digit PIN</label>
                    <input type="password" name="pin" required maxlength="4" placeholder="••••" class="w-full text-sm bg-red-50 border border-red-200 rounded-xl px-4 py-3 focus:border-[#D20103] outline-none font-mono text-center tracking-widest text-xl">
                </div>
                
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('autoSweepModal').classList.add('hidden')" class="px-5 py-2.5 rounded-lg font-bold text-slate-600 hover:bg-slate-50 transition-colors border border-slate-200">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-lg font-bold text-white transition-colors hover:bg-blue-900 shadow-sm" style="background-color: #003366;">Save Rules</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('sweepFrequencySelect').addEventListener('change', function(e) {
        if(e.target.value === 'threshold') {
            document.getElementById('thresholdInputGroup').classList.remove('hidden');
        } else {
            document.getElementById('thresholdInputGroup').classList.add('hidden');
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const accountNumberInput = document.getElementById('accountNumberInput');
        const accountNameInput = document.getElementById('accountNameInput');
        const bankNameSelect = document.querySelector('select[name="bank_code"]');
        const hiddenBankName = document.getElementById('hiddenBankName');
        const saveAccountBtn = document.getElementById('saveAccountBtn');
        const verifyLoading = document.getElementById('verifyLoading');
        const verifyError = document.getElementById('verifyError');

        let verifyTimeout;

        function verifyAccount() {
            const accountNumber = accountNumberInput.value;
            const bankCode = bankNameSelect.value;
            const bankNameText = bankNameSelect.options[bankNameSelect.selectedIndex]?.text;

            // Update hidden bank name for form submission
            hiddenBankName.value = bankNameText || '';

            if (accountNumber.length === 10 && bankCode) {
                // Start Verification
                verifyLoading.classList.remove('hidden');
                verifyError.classList.add('hidden');
                accountNameInput.value = '';
                saveAccountBtn.disabled = true;

                fetch('{{ route('merchant.settlements.bank.verify') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        account_number: accountNumber,
                        bank_code: bankCode
                    })
                })
                .then(response => response.json())
                .then(data => {
                    verifyLoading.classList.add('hidden');
                    if (data.status === 'success') {
                        accountNameInput.value = data.data.account_name;
                        saveAccountBtn.disabled = false;
                    } else {
                        verifyError.textContent = data.message || 'Could not verify account details.';
                        verifyError.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    verifyLoading.classList.add('hidden');
                    verifyError.textContent = 'Verification service unavailable.';
                    verifyError.classList.remove('hidden');
                });
            } else {
                accountNameInput.value = '';
                saveAccountBtn.disabled = true;
                verifyError.classList.add('hidden');
            }
        }

        accountNumberInput.addEventListener('input', function() {
            clearTimeout(verifyTimeout);
            // Remove non-digits
            this.value = this.value.replace(/\D/g, '');
            verifyTimeout = setTimeout(verifyAccount, 500);
        });

        bankNameSelect.addEventListener('change', verifyAccount);
    });
</script>
@endsection