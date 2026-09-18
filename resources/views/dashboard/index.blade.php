@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Dashboard</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            
            <div class="box col-span-12 bg-n0  min-[650px]:col-span-6 3xl:col-span-3">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 3xl:">
                    <span class="font-medium text-n700">Available Balance</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="h4 mb-4 text-green-600">₦{{ number_format($availableBalance ?? 0, 2) }}</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-sm text-n700">
                            Ready for Withdrawal
                        </span>
                    </div>
                </div>
            </div>

            <div class="box col-span-12 bg-n0  min-[650px]:col-span-6 3xl:col-span-3">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 3xl:">
                    <span class="font-medium text-n700">Pending Settlements</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="h4 mb-4 text-[#FFC861]">₦{{ number_format($pendingEscrow ?? 0, 2) }}</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-sm text-n700">
                            Awaiting Buyer Approval
                        </span>
                    </div>
                </div>
            </div>

            <div class="box col-span-12 bg-n0  min-[650px]:col-span-6 3xl:col-span-3">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 3xl:">
                    <span class="font-medium text-n700">Total Sales Volume</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="h4 mb-4 text-primary">₦{{ number_format($totalSales ?? 0, 2) }}</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-sm text-n700">
                            Lifetime Earnings
                        </span>
                    </div>
                </div>
            </div>

            <div class="box col-span-12 bg-n0  min-[650px]:col-span-6 3xl:col-span-3">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 3xl:">
                    <span class="font-medium text-n700">Active Orders</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="h4 mb-4 text-[#8B5CF6]">{{ $activeOrdersCount ?? 0 }}</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-sm text-n700">
                            Currently processing
                        </span>
                    </div>
                </div>
            </div>

            <div class="box col-span-12 bg-n0 lg:col-span-6">
                <div class="bb-dashed mb-4 pb-4">
                    <h4 class="h4">Vendor Actions</h4>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <a href="{{ route('merchant.payment-links.index') }}" class="flex flex-col items-center gap-3 rounded-xl border border-n30 bg-primary/5 p-4 duration-300 hover:border-primary hover:bg-primary/10">
                        <div class="flex size-12 items-center justify-center rounded-full bg-primary text-white">
                            <i class="las la-link text-2xl"></i>
                        </div>
                        <span class="font-medium text-center text-sm">Payment Link</span>
                    </a>
                    <a href="{{ route('merchant.products.create') }}" class="flex flex-col items-center gap-3 rounded-xl border border-n30 bg-primary/5 p-4 duration-300 hover:border-primary hover:bg-primary/10">
                        <div class="flex size-12 items-center justify-center rounded-full bg-primary text-white">
                            <i class="las la-box text-2xl"></i>
                        </div>
                        <span class="font-medium text-center text-sm">Add Product</span>
                    </a>
                    <a href="{{ route('merchant.wallet.index') }}" class="flex flex-col items-center gap-3 rounded-xl border border-n30 bg-primary/5 p-4 duration-300 hover:border-primary hover:bg-primary/10">
                        <div class="flex size-12 items-center justify-center rounded-full bg-[#FFC861] text-white">
                            <i class="las la-wallet text-2xl"></i>
                        </div>
                        <span class="font-medium text-center text-sm">Withdraw</span>
                    </a>
                    <a href="{{ route('merchant.orders.index') }}" class="flex flex-col items-center gap-3 rounded-xl border border-n30 bg-primary/5 p-4 duration-300 hover:border-primary hover:bg-primary/10">
                        <div class="flex size-12 items-center justify-center rounded-full bg-[#4371E9] text-white">
                            <i class="las la-history text-2xl"></i>
                        </div>
                        <span class="font-medium text-center text-sm">Transactions</span>
                    </a>
                    <a href="{{ route('merchant.settings.index') }}" class="flex flex-col items-center gap-3 rounded-xl border border-n30 bg-primary/5 p-4 duration-300 hover:border-primary hover:bg-primary/10">
                        <div class="flex size-12 items-center justify-center rounded-full bg-[#8B5CF6] text-white">
                            <i class="las la-store text-2xl"></i>
                        </div>
                        <span class="font-medium text-center text-sm">Store Profile</span>
                    </a>
                    <a href="{{ route('merchant.disputes.index') }}" class="flex flex-col items-center gap-3 rounded-xl border border-n30 bg-primary/5 p-4 duration-300 hover:border-primary hover:bg-primary/10">
                        <div class="flex size-12 items-center justify-center rounded-full bg-[#EF4444] text-white">
                            <i class="las la-gavel text-2xl"></i>
                        </div>
                        <span class="font-medium text-center text-sm">Disputes</span>
                    </a>
                </div>
            </div>

            <div class="box col-span-12 bg-n0 lg:col-span-6">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4">
                    <h4 class="h4">Recent Activity</h4>
                </div>
                <div class="space-y-4">
                    @if(isset($recentActivities) && count($recentActivities) > 0)
                        @foreach($recentActivities as $activity)
                            <div class="flex gap-3">
                                
                                @if($activity->status == 'released')
                                    <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-green-100 text-green-600">
                                        <i class="las la-check-circle text-xl"></i>
                                    </div>
                                @elseif($activity->status == 'awaiting_funds')
                                    <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-[#FFC861]/10 text-[#FFC861]">
                                        <i class="las la-clock text-xl"></i>
                                    </div>
                                @else
                                    <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-primary/10 text-primary">
                                        <i class="las la-lock text-xl"></i>
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <p class="mb-1 font-medium">
                                        @if($activity->status == 'released') Escrow Released
                                        @elseif($activity->status == 'awaiting_funds') Awaiting Buyer Payment
                                        @else Escrow Locked
                                        @endif
                                    </p>
                                    <p class="mb-1 text-sm text-n700">Trx: {{ $activity->reference ?? 'N/A' }} - ₦{{ number_format($activity->amount, 2) }}</p>
                                    <span class="text-xs text-n700">{{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-6 text-n700">
                            <i class="las la-inbox text-4xl mb-2"></i>
                            <p>No recent activity yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="box col-span-12 lg:col-span-6">
                <div class="bb-dashed mb-4 flex flex-wrap items-center justify-between gap-4 pb-4 3xl:">
                    <h4 class="h4">Latest Transactions</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-secondary/5 ">
                                <th class="flex min-w-[200px] cursor-pointer items-center gap-1 px-6 py-5 text-start">
                                    Transaction Ref
                                </th>
                                <th class="min-w-[120px] cursor-pointer px-6 py-5 text-start">
                                    <div class="flex items-center gap-1">Status</div>
                                </th>
                                <th class="min-w-[120px] cursor-pointer px-6 py-5 text-start">
                                    <div class="flex items-center gap-1">Amount</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($recentActivities) && count($recentActivities) > 0)
                                @foreach($recentActivities as $tx)
                                    <tr class="even:bg-secondary/5 ">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex size-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                                                    <i class="las la-receipt text-xl"></i>
                                                </div>
                                                <div>
                                                    <p class="mb-1 font-medium">{{ $tx->reference ?? 'Unknown Ref' }}</p>
                                                    <span class="text-xs text-n700">{{ \Carbon\Carbon::parse($tx->created_at)->format('d M, Y. h:i a') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($tx->status == 'released')
                                                <span class="text-green-600 font-medium">Released</span>
                                            @elseif($tx->status == 'awaiting_funds')
                                                <span class="text-[#FFC861] font-medium">Awaiting Funds</span>
                                            @else
                                                <span class="text-primary font-medium">Locked in Escrow</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 font-semibold">
                                            ₦{{ number_format($tx->amount, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-n700">
                                        No recent transactions available.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <a class="group mt-6 inline-flex items-center gap-1 font-semibold text-primary" href="{{ route('merchant.orders.index') }}">
                    View All Transactions
                    <i class="las la-arrow-right duration-300 group-hover:pl-2"></i>
                </a>
            </div>

            <div class="box col-span-12 lg:col-span-6">
                <div class="bb-dashed mb-4 flex flex-wrap items-center justify-between gap-4 pb-4 3xl:">
                    <h4 class="h4">Saved Bank Accounts</h4>
                    <button type="button" onclick="document.getElementById('addBankModal').classList.remove('hidden')" class="flex items-center gap-2 text-sm font-medium text-primary hover:underline">
                        <i class="las la-plus"></i> Add Bank
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-secondary/5 ">
                                <th class="min-w-[200px] cursor-pointer px-6 py-5 text-start">
                                    <div class="flex items-center gap-1">Bank Details</div>
                                </th>
                                <th class="w-[20%] cursor-pointer px-6 py-5 text-start">
                                    <div class="flex items-center gap-1">Status</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Fetch the vendor's banks, putting the default (active) one at the top
                                $bankAccounts = \App\Models\BankAccount::where('user_id', Auth::id())
                                    ->orderByDesc('is_active')
                                    ->latest()
                                    ->get();
                            @endphp

                            @forelse($bankAccounts as $bank)
                                <tr class="even:bg-secondary/5 border-b border-n30/50 last:border-0">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex size-10 items-center justify-center rounded-xl {{ $bank->is_active ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-500' }}">
                                                <i class="las la-university text-2xl"></i>
                                            </div>
                                            <div>
                                                <p class="mb-1 font-medium text-slate-800">{{ $bank->bank_name }}</p>
                                                <span class="text-xs text-slate-500">{{ $bank->account_number }} • {{ $bank->account_name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($bank->is_active)
                                            <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700 shadow-sm">
                                                <div class="size-1.5 rounded-full bg-green-600 animate-pulse"></div> Default
                                            </span>
                                        @else
                                            <form action="{{ route('merchant.bank.setDefault', $bank->id) }}" method="POST" class="m-0 p-0">
                                                @csrf
                                                <button type="submit" class="text-xs font-medium text-slate-400 hover:text-primary transition-colors border border-slate-200 rounded-lg px-3 py-1 hover:bg-primary/5 hover:border-primary/30">
                                                    Make Default
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-10 text-center text-slate-500">
                                        <i class="las la-wallet text-4xl mb-2 text-slate-300"></i>
                                        <p class="text-sm">No bank accounts saved yet.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- 🔴 NEW READ-ONLY LOGISTICS BLOCK -->
            <div class="box col-span-12 lg:col-span-12">
                <div class="bb-dashed mb-4 flex flex-wrap items-center justify-between gap-4 pb-4">
                    <h4 class="h4">Logistics Pickup Location</h4>
                    <span class="inline-flex items-center gap-1 rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">
                        <i class="las la-lock"></i> Secured
                    </span>
                </div>
                <div class="mb-2">
                    <p class="text-sm text-slate-500 mb-6">To protect active escrow transactions and Shipbubble dispatch calculations, your pickup coordinates are locked. Please contact Q4I Admin support to request a location change.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Street Address</label>
                            <input type="text" value="{{ auth()->user()->address ?? 'Not Configured' }}" disabled 
                                class="w-full text-sm bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-slate-500 cursor-not-allowed">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-slate-700 mb-1">City</label>
                            <input type="text" value="{{ auth()->user()->city ?? 'Not Configured' }}" disabled 
                                class="w-full text-sm bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-slate-500 cursor-not-allowed">
                        </div>
                        <div class="col-span-1">
                            <label class="block text-sm font-medium text-slate-700 mb-1">State</label>
                            <input type="text" value="{{ auth()->user()->state ?? 'Not Configured' }}" disabled 
                                class="w-full text-sm bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-slate-500 cursor-not-allowed">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="addBankModal" class="fixed inset-0 hidden" style="z-index: 9999;">
    
    <div class="absolute inset-0 flex items-center justify-center p-4" 
         style="background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px);"
         onclick="document.getElementById('addBankModal').classList.add('hidden')">

        <div class="w-full relative cursor-auto" 
             onclick="event.stopPropagation()"
             style="max-width: 450px; background-color: #ffffff; border-radius: 24px; padding: 32px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">

            <button type="button" onclick="document.getElementById('addBankModal').classList.add('hidden')" 
                    style="position: absolute; top: 20px; right: 20px; background: #f1f5f9; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; color: #64748b; transition: all 0.2s;" 
                    onmouseover="this.style.background='#e2e8f0'; this.style.color='#0f172a'" 
                    onmouseout="this.style.background='#f1f5f9'; this.style.color='#64748b'">
                <i class="las la-times text-xl"></i>
            </button>

            <div style="border-bottom: 1px dashed #cbd5e1; padding-bottom: 16px; margin-bottom: 24px;">
                <h3 class="text-xl font-bold text-slate-900 mb-1">Wallet Withdrawals</h3>
                <p class="text-sm text-slate-500">Where should we route your gateway settlements?</p>
            </div>

            <form action="{{ route('merchant.bank.store') }}" method="POST">
                @csrf

                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Select Bank</label>
                    <select name="bank_name" required 
                            class="w-full text-sm bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-[#10b981] focus:ring-1 focus:ring-[#10b981] outline-none transition-all cursor-pointer">
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
                    <label class="block text-sm font-medium text-slate-700 mb-2">Account Number</label>
                    <input type="text" name="account_number" required maxlength="10" placeholder="e.g. 8012345678" 
                           class="w-full text-sm bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-[#10b981] focus:ring-1 focus:ring-[#10b981] outline-none transition-all">
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Account Name</label>
                    <input type="text" name="account_name" required placeholder="e.g. Bussy Sneaks" 
                           class="w-full text-sm bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-[#10b981] focus:ring-1 focus:ring-[#10b981] outline-none transition-all">
                </div>

                <button type="submit" 
                        style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #ffffff; font-weight: 600; font-size: 1rem; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25); border: none; display: flex; justify-content: center; align-items: center; width: 100%; padding: 14px; border-radius: 12px; cursor: pointer; transition: all 0.3s ease;" 
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(16, 185, 129, 0.4)'" 
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(16, 185, 129, 0.25)'">
                    Save Bank Details
                </button>
            </form>
        </div>
    </div>
</div>
@endsection