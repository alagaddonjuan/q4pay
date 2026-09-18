@extends('layout.vendor')

@section('content')

    <style>
        .box { background-color: #FFFFFF !important; border: 1px solid #D1D5DB !important; border-radius: 1rem; padding: 1.5rem; }
        .bb-dashed { border-bottom: 1px dashed #D1D5DB !important; }
        .text-n700 { color: #64748B !important; }
        .h2, .h4 { color: #0B3A75 !important; font-weight: 700 !important; }
        
        /* Smooth Custom Q4I Button */
        .btn-q4i-primary { 
            background-color: #0878F8 !important; 
            color: #FFFFFF !important; 
            transition: all 0.3s ease; 
            box-shadow: 0 4px 6px -1px rgba(8, 120, 248, 0.3); 
            border-radius: 0.75rem;
            padding: 0.625rem 1.25rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }
        .btn-q4i-primary:hover { 
            background-color: #0B3A75 !important; 
            transform: translateY(-1px); 
            box-shadow: 0 6px 8px -1px rgba(11, 58, 117, 0.3);
        }
    </style>

    <div class="main-inner bg-[#F8FAFC] min-h-screen p-4 lg:p-6">
        
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-center gap-4">
            <h2 class="h2 text-3xl mb-0">Dashboard</h2>
            
            <div class="relative group z-50 cursor-pointer hidden sm:block">
                
                <div id="system-health-badge" class="flex items-center gap-2 rounded-full border border-[#D1D5DB] bg-white px-3 py-1.5 shadow-sm transition-all hover:bg-[#F8FAFC]">
                    <span class="relative flex size-2.5">
                        <span id="health-ping" class="absolute inline-flex h-full w-full rounded-full bg-[#94A3B8] opacity-75"></span>
                        <span id="health-dot" class="relative inline-flex size-2.5 rounded-full bg-[#94A3B8]"></span>
                    </span>
                    <span id="health-text" class="text-xs font-bold text-[#64748B]">Connecting...</span>
                </div>

                <div class="absolute left-0 mt-2 w-64 bg-white border border-slate-200 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 p-4">
                    <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 pb-2 border-b border-slate-100">System Diagnostics</h5>
                    <ul id="health-services-list" class="space-y-3">
                        <li class="text-sm text-slate-500 animate-pulse font-medium">Running diagnostics...</li>
                    </ul>
                </div>
            </div>
            </div>

        <button onclick="document.getElementById('addBankModal').classList.remove('hidden')" class="btn-q4i-primary">
            <i class="las la-plus-circle text-base md:text-lg"></i>
            Add Bank Account
        </button>
    </div>

        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            
            <div class="box col-span-12 min-[650px]:col-span-6 3xl:col-span-3 transition-all duration-300 hover:border-[#108981] hover:shadow-lg hover:shadow-[#108981]/10">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4">
                    <span class="font-medium text-[#64748B]">Available Balance</span>
                    <i class="las la-wallet text-xl text-[#108981]/50"></i>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="h4 mb-2 text-[#108981] text-3xl">₦{{ number_format($availableBalance ?? 0, 2) }}</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-sm text-[#64748B]">
                            <i class="las la-check-circle text-[#108981]"></i> Ready for Withdrawal
                        </span>
                    </div>
                </div>
            </div>

            <div class="box col-span-12 min-[650px]:col-span-6 3xl:col-span-3 transition-all duration-300 hover:border-[#F59E0B] hover:shadow-lg hover:shadow-[#F59E0B]/10">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4">
                    <span class="font-medium text-[#64748B]">Pending Settlements</span>
                    <i class="las la-hourglass-half text-xl text-[#F59E0B]/50"></i>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="h4 mb-2 text-[#F59E0B] text-3xl">₦{{ number_format($pendingEscrow ?? 0, 2) }}</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-sm text-[#64748B]">
                            <i class="las la-clock text-[#F59E0B]"></i> Awaiting Buyer Approval
                        </span>
                    </div>
                </div>
            </div>

            <div class="box col-span-12 min-[650px]:col-span-6 3xl:col-span-3 transition-all duration-300 hover:border-[#0878F8] hover:shadow-lg hover:shadow-[#0878F8]/10">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4">
                    <span class="font-medium text-[#64748B]">Total Sales Volume</span>
                    <i class="las la-chart-bar text-xl text-[#0878F8]/50"></i>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="h4 mb-2 text-[#0878F8] text-3xl">₦{{ number_format($totalSales ?? 0, 2) }}</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-sm text-[#64748B]">
                            <i class="las la-chart-line text-[#0878F8]"></i> Lifetime Earnings
                        </span>
                    </div>
                </div>
            </div>

            <div class="box col-span-12 min-[650px]:col-span-6 3xl:col-span-3 transition-all duration-300 hover:border-[#6D5EF7] hover:shadow-lg hover:shadow-[#6D5EF7]/10">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4">
                    <span class="font-medium text-[#64748B]">Active Orders</span>
                    <i class="las la-box-open text-xl text-[#6D5EF7]/50"></i>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="h4 mb-2 text-[#6D5EF7] text-3xl">{{ $activeOrdersCount ?? 0 }}</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-sm text-[#64748B]">
                            <i class="las la-truck text-[#6D5EF7]"></i> Currently processing
                        </span>
                    </div>
                </div>
            </div>

            <div class="box col-span-12 lg:col-span-6">
                <div class="bb-dashed mb-4 pb-4">
                    <h4 class="h4">Vendor Actions</h4>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <a href="{{ route('vendor.payment-links.index') }}" class="flex flex-col items-center gap-3 rounded-xl border border-[#D1D5DB] bg-white p-4 duration-300 hover:border-[#108981] hover:bg-[#108981]/5 group">
                        <div class="flex size-12 items-center justify-center rounded-full bg-[#108981]/10 text-[#108981] group-hover:bg-[#108981] group-hover:text-white transition-colors">
                            <i class="las la-link text-2xl"></i>
                        </div>
                        <span class="font-medium text-center text-sm text-[#1F2937]">Payment Link</span>
                    </a>
                    <a href="{{ route('vendor.products.create') }}" class="flex flex-col items-center gap-3 rounded-xl border border-[#D1D5DB] bg-white p-4 duration-300 hover:border-[#0878F8] hover:bg-[#0878F8]/5 group">
                        <div class="flex size-12 items-center justify-center rounded-full bg-[#0878F8]/10 text-[#0878F8] group-hover:bg-[#0878F8] group-hover:text-white transition-colors">
                            <i class="las la-box text-2xl"></i>
                        </div>
                        <span class="font-medium text-center text-sm text-[#1F2937]">Add Product</span>
                    </a>
                    <a href="{{ route('vendor.wallet.index') }}" class="flex flex-col items-center gap-3 rounded-xl border border-[#D1D5DB] bg-white p-4 duration-300 hover:border-[#F59E0B] hover:bg-[#F59E0B]/5 group">
                        <div class="flex size-12 items-center justify-center rounded-full bg-[#F59E0B]/10 text-[#F59E0B] group-hover:bg-[#F59E0B] group-hover:text-white transition-colors">
                            <i class="las la-wallet text-2xl"></i>
                        </div>
                        <span class="font-medium text-center text-sm text-[#1F2937]">Withdraw</span>
                    </a>
                    <a href="{{ route('vendor.orders.index') }}" class="flex flex-col items-center gap-3 rounded-xl border border-[#D1D5DB] bg-white p-4 duration-300 hover:border-[#22C7F8] hover:bg-[#22C7F8]/5 group">
                        <div class="flex size-12 items-center justify-center rounded-full bg-[#22C7F8]/10 text-[#22C7F8] group-hover:bg-[#22C7F8] group-hover:text-white transition-colors">
                            <i class="las la-history text-2xl"></i>
                        </div>
                        <span class="font-medium text-center text-sm text-[#1F2937]">Transactions</span>
                    </a>
                    <a href="{{ route('vendor.settings.index') }}" class="flex flex-col items-center gap-3 rounded-xl border border-[#D1D5DB] bg-white p-4 duration-300 hover:border-[#6D5EF7] hover:bg-[#6D5EF7]/5 group">
                        <div class="flex size-12 items-center justify-center rounded-full bg-[#6D5EF7]/10 text-[#6D5EF7] group-hover:bg-[#6D5EF7] group-hover:text-white transition-colors">
                            <i class="las la-store text-2xl"></i>
                        </div>
                        <span class="font-medium text-center text-sm text-[#1F2937]">Store Profile</span>
                    </a>
                    <a href="{{ route('vendor.disputes.index') }}" class="flex flex-col items-center gap-3 rounded-xl border border-[#D1D5DB] bg-white p-4 duration-300 hover:border-[#EF4444] hover:bg-[#EF4444]/5 group">
                        <div class="flex size-12 items-center justify-center rounded-full bg-[#EF4444]/10 text-[#EF4444] group-hover:bg-[#EF4444] group-hover:text-white transition-colors">
                            <i class="las la-gavel text-2xl"></i>
                        </div>
                        <span class="font-medium text-center text-sm text-[#1F2937]">Disputes</span>
                    </a>
                </div>
            </div>

            <div class="box col-span-12 lg:col-span-6 flex flex-col">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4">
                    <h4 class="h4">Recent Activity</h4>
                </div>
                <div class="space-y-4 flex-1">
                    @if(isset($recentActivities) && count($recentActivities) > 0)
                        @foreach($recentActivities as $activity)
                            <div class="flex gap-3 items-start">
                                
                                @if($activity->status == 'released')
                                    <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-[#108981]/10 text-[#108981]">
                                        <i class="las la-check-circle text-xl"></i>
                                    </div>
                                @elseif($activity->status == 'awaiting_funds')
                                    <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-[#F59E0B]/10 text-[#F59E0B]">
                                        <i class="las la-clock text-xl"></i>
                                    </div>
                                @else
                                    <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-[#0878F8]/10 text-[#0878F8]">
                                        <i class="las la-lock text-xl"></i>
                                    </div>
                                @endif

                                <div class="flex-1 pb-4 border-b border-dashed border-[#D1D5DB] last:border-0 last:pb-0">
                                    <p class="mb-1 font-bold text-[#1F2937]">
                                        @if($activity->status == 'released') Escrow Released
                                        @elseif($activity->status == 'awaiting_funds') Awaiting Buyer Payment
                                        @else Escrow Locked
                                        @endif
                                    </p>
                                    <p class="mb-1 text-sm text-[#64748B]">Trx: {{ $activity->reference ?? 'N/A' }} - <span class="font-semibold text-[#1F2937]">₦{{ number_format($activity->amount, 2) }}</span></p>
                                    <span class="text-xs text-[#94A3B8]"><i class="las la-calendar-alt"></i> {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-10 text-[#64748B] flex flex-col items-center justify-center h-full">
                            <i class="las la-inbox text-5xl mb-3 text-[#94A3B8]"></i>
                            <p class="font-medium text-[#1F2937]">No recent activity yet.</p>
                            <p class="text-sm mt-1">Your timeline will populate as sales come in.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="box col-span-12 lg:col-span-6">
                <div class="bb-dashed mb-4 flex flex-wrap items-center justify-between gap-4 pb-4">
                    <h4 class="h4">Latest Transactions</h4>
                </div>
                <div class="overflow-x-auto rounded-xl border border-[#D1D5DB]">
                    <table class="w-full whitespace-nowrap text-sm">
                        <thead class="bg-[#F8FAFC] border-b border-[#D1D5DB] text-[#64748B]">
                            <tr>
                                <th class="px-5 py-4 text-start font-semibold">Transaction Ref</th>
                                <th class="px-5 py-4 text-start font-semibold">Status</th>
                                <th class="px-5 py-4 text-start font-semibold">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#D1D5DB]">
                            @if(isset($recentActivities) && count($recentActivities) > 0)
                                @foreach($recentActivities as $tx)
                                    <tr class="hover:bg-[#F8FAFC] transition-colors">
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex size-9 items-center justify-center rounded-full bg-[#0878F8]/10 text-[#0878F8]">
                                                    <i class="las la-receipt text-lg"></i>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-[#1F2937]">{{ $tx->reference ?? 'Unknown Ref' }}</p>
                                                    <span class="text-xs text-[#94A3B8]">{{ \Carbon\Carbon::parse($tx->created_at)->format('d M, Y • h:i a') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4">
                                            @if($tx->status == 'released')
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#108981]/10 px-2.5 py-1 text-xs font-semibold text-[#108981]"><span class="h-1.5 w-1.5 rounded-full bg-[#108981]"></span> Released</span>
                                            @elseif($tx->status == 'awaiting_funds')
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#F59E0B]/10 px-2.5 py-1 text-xs font-semibold text-[#F59E0B]"><span class="h-1.5 w-1.5 rounded-full bg-[#F59E0B]"></span> Awaiting Funds</span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#0878F8]/10 px-2.5 py-1 text-xs font-semibold text-[#0878F8]"><span class="h-1.5 w-1.5 rounded-full bg-[#0878F8]"></span> Locked in Escrow</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4 font-bold text-[#1F2937]">
                                            ₦{{ number_format($tx->amount, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="px-5 py-8 text-center text-[#64748B]">
                                        No recent transactions available.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <a class="group mt-5 inline-flex items-center gap-1 font-semibold text-[#0878F8] hover:text-[#0B3A75] transition-colors" href="{{ route('vendor.orders.index') }}">
                    View All Transactions
                    <i class="las la-arrow-right duration-300 group-hover:translate-x-1"></i>
                </a>
            </div>

            <div class="box col-span-12 lg:col-span-6">
                <div class="bb-dashed mb-4 flex flex-wrap items-center justify-between gap-4 pb-4">
                    <h4 class="h4">Saved Bank Accounts</h4>
                    <button type="button" onclick="document.getElementById('addBankModal').classList.remove('hidden')" class="flex items-center gap-1 text-sm font-bold text-[#0878F8] hover:text-[#0B3A75] bg-[#0878F8]/10 hover:bg-[#0878F8]/20 px-3 py-1.5 rounded-lg transition-colors">
                        <i class="las la-plus"></i> Add Bank
                    </button>
                </div>
                <div class="overflow-x-auto rounded-xl border border-[#D1D5DB]">
                    <table class="w-full whitespace-nowrap text-sm">
                        <thead class="bg-[#F8FAFC] border-b border-[#D1D5DB] text-[#64748B]">
                            <tr>
                                <th class="px-5 py-4 text-start font-semibold">Bank Details</th>
                                <th class="w-[20%] px-5 py-4 text-start font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#D1D5DB]">
                            @php
                                $bankAccounts = \App\Models\BankAccount::where('user_id', Auth::id())
                                    ->orderByDesc('is_active')
                                    ->latest()
                                    ->get();
                            @endphp

                            @forelse($bankAccounts as $bank)
                                <tr class="hover:bg-[#F8FAFC] transition-colors">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex size-10 items-center justify-center rounded-xl {{ $bank->is_active ? 'bg-[#108981]/10 text-[#108981]' : 'bg-[#F8FAFC] text-[#94A3B8] border border-[#D1D5DB]' }}">
                                                <i class="las la-university text-2xl"></i>
                                            </div>
                                            <div>
                                                <p class="font-bold text-[#1F2937] mb-0.5">{{ $bank->bank_name }}</p>
                                                <span class="text-xs text-[#64748B] font-medium">{{ $bank->account_number }} • {{ $bank->account_name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        @if($bank->is_active)
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#108981]/10 px-2.5 py-1 text-xs font-bold text-[#108981] ring-1 ring-inset ring-[#108981]/20">
                                                <span class="size-1.5 rounded-full bg-[#108981] animate-pulse"></span> Default
                                            </span>
                                        @else
                                            <form action="{{ route('vendor.bank.setDefault', $bank->id) }}" method="POST" class="m-0 p-0">
                                                @csrf
                                                <button type="submit" class="text-xs font-semibold text-[#64748B] hover:text-[#0878F8] transition-colors border border-[#D1D5DB] rounded-lg px-3 py-1.5 hover:bg-[#0878F8]/5 hover:border-[#0878F8]/30">
                                                    Make Default
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-5 py-10 text-center text-[#64748B]">
                                        <i class="las la-wallet text-4xl mb-2 text-[#94A3B8]"></i>
                                        <p class="font-medium">No bank accounts saved yet.</p>
                                        <p class="text-xs mt-1">Add an account to receive your payouts.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div id="addBankModal" class="fixed inset-0 hidden" style="z-index: 9999;">
        <div class="absolute inset-0 flex items-center justify-center p-4 bg-[#1F2937]/60 backdrop-blur-sm" onclick="document.getElementById('addBankModal').classList.add('hidden')">

            <div class="w-full relative cursor-auto bg-white rounded-2xl p-8 shadow-2xl" onclick="event.stopPropagation()" style="max-width: 450px;">
                <button type="button" onclick="document.getElementById('addBankModal').classList.add('hidden')" class="absolute top-5 right-5 bg-[#F8FAFC] hover:bg-[#EF4444]/10 hover:text-[#EF4444] text-[#64748B] rounded-full h-8 w-8 flex items-center justify-center transition-colors">
                    <i class="las la-times text-xl"></i>
                </button>

                <div class="border-b border-dashed border-[#D1D5DB] pb-4 mb-6">
                    <h3 class="text-xl font-black text-[#0B3A75] mb-1">Wallet Withdrawals</h3>
                    <p class="text-sm text-[#64748B]">Where should we route your gateway settlements?</p>
                </div>

                <form action="{{ route('vendor.bank.store') }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-[#1F2937] mb-2">Select Bank <span class="text-[#EF4444]">*</span></label>
                        <select name="bank_name" required class="w-full text-sm bg-[#F8FAFC] border border-[#D1D5DB] rounded-xl px-4 py-3 focus:border-[#0878F8] focus:bg-white focus:ring-1 focus:ring-[#0878F8] outline-none transition-all cursor-pointer font-medium text-[#1F2937]">
                            <option value="">Choose a bank...</option>
                            <option value="Moniepoint">Moniepoint MFB</option>
                            <option value="Opay">OPay</option>
                            <option value="Palmpay">PalmPay</option>
                            <option value="GTB">Guaranty Trust Bank</option>
                            <option value="Zenith">Zenith Bank</option>
                            <option value="Access">Access Bank</option>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-[#1F2937] mb-2">Account Number <span class="text-[#EF4444]">*</span></label>
                        <input type="text" name="account_number" required maxlength="10" placeholder="e.g. 8012345678" class="w-full text-sm bg-[#F8FAFC] border border-[#D1D5DB] rounded-xl px-4 py-3 focus:border-[#0878F8] focus:bg-white focus:ring-1 focus:ring-[#0878F8] outline-none transition-all font-medium text-[#1F2937]">
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-bold text-[#1F2937] mb-2">Account Name <span class="text-[#EF4444]">*</span></label>
                        <input type="text" name="account_name" required placeholder="e.g. Bussy Sneaks" class="w-full text-sm bg-[#F8FAFC] border border-[#D1D5DB] rounded-xl px-4 py-3 focus:border-[#0878F8] focus:bg-white focus:ring-1 focus:ring-[#0878F8] outline-none transition-all font-medium text-[#1F2937]">
                    </div>

                    <button type="submit" class="w-full bg-[#0878F8] hover:bg-[#0B3A75] text-white font-bold py-3.5 rounded-xl shadow-lg shadow-[#0878F8]/30 hover:shadow-none hover:-translate-y-0.5 transition-all duration-300 flex justify-center items-center gap-2">
                        <i class="las la-save text-xl"></i> Save Bank Details
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const ping = document.getElementById('health-ping');
    const dot = document.getElementById('health-dot');
    const text = document.getElementById('health-text');
    const badge = document.getElementById('system-health-badge');
    const servicesList = document.getElementById('health-services-list');

    function updateHealthUI(status, message) {
        if (!ping || !dot || !text) return; // Prevent crashes if HTML is missing

        ping.className = 'absolute inline-flex h-full w-full rounded-full opacity-75';
        dot.className = 'relative inline-flex size-2.5 rounded-full';
        text.textContent = message; 

        if (status === 'green') {
            ping.classList.add('bg-[#108981]', 'animate-ping');
            dot.classList.add('bg-[#108981]');
            text.className = 'text-xs font-bold text-[#108981]';
        } 
        else if (status === 'yellow') {
            ping.classList.add('bg-[#F59E0B]', 'animate-ping');
            dot.classList.add('bg-[#F59E0B]');
            text.className = 'text-xs font-bold text-[#F59E0B]';
        } 
        else {
            ping.classList.add('bg-[#EF4444]'); 
            dot.classList.add('bg-[#EF4444]');
            text.className = 'text-xs font-bold text-[#EF4444]';
        }
    }

    function renderServicesDropdown(services) {
        if (!servicesList) return;
        
        servicesList.innerHTML = ''; 
        
        for (const [key, service] of Object.entries(services)) {
            const isOnline = service.status === 'online';
            const colorClass = isOnline ? 'text-[#108981]' : 'text-[#EF4444]';
            const iconClass = isOnline ? 'la-check-circle' : 'la-times-circle';
            const bgClass = isOnline ? 'bg-[#108981]/10' : 'bg-[#EF4444]/10';

            servicesList.innerHTML += `
                <li class="flex items-center justify-between">
                    <span class="text-sm font-medium text-slate-700">${service.name}</span>
                    <div class="flex items-center gap-1.5 ${bgClass} ${colorClass} px-2 py-1 rounded-md">
                        <i class="las ${iconClass} text-base"></i>
                        <span class="text-xs font-bold uppercase">${service.status}</span>
                    </div>
                </li>
            `;
        }
    }

    function pollSystemHealth() {
        fetch('/system/status')
            .then(response => {
                if (!response.ok) throw new Error("Network error");
                return response.json();
            })
            .then(payload => {
                updateHealthUI(payload.data.status, payload.data.message);
                if(payload.data.services) {
                    renderServicesDropdown(payload.data.services);
                }
            })
            .catch(error => {
                updateHealthUI('red', 'System Outage'); 
                if (servicesList) {
                    servicesList.innerHTML = '<li class="text-sm text-red-500 font-bold">Failed to fetch diagnostics.</li>';
                }
            });
    }

    pollSystemHealth();
    setInterval(pollSystemHealth, 60000); 
});
</script>
@endsection