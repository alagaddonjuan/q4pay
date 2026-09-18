@extends('layout.merchant') 
@section('title', 'Corporate Gateway Overview | Q4I Limited')
@section('meta_description', 'Manage your master wallet, virtual accounts, and settlements.')
@section('meta_image', asset('assets/images/q4i-social-share.jpg'))

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div>
                <h2 class="h2 text-[#003366]">Corporate Gateway</h2>
                <p class="text-sm text-slate-500 mt-1">Manage your virtual accounts, API keys, and settlements.</p>
            </div>
            <button onclick="document.getElementById('createLinkModal').classList.remove('hidden')" class="bg-[#D20103] hover:bg-red-800 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition-colors">
                <i class="las la-plus-circle text-xl"></i> New Payment Link
            </button>
        </div>

        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            
            <!-- MASTER WALLET BALANCE -->
            <div class="box col-span-12 bg-white min-[650px]:col-span-6 3xl:col-span-3" style="border-top: 4px solid #003366; box-shadow: 0 4px 20px rgba(0, 51, 102, 0.05); border-radius: 12px;">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 border-b border-slate-100">
                    <span class="font-medium text-slate-500 uppercase text-xs tracking-wider">Master Wallet Balance</span>
                    <div class="flex size-8 items-center justify-center rounded-full" style="background-color: rgba(0, 51, 102, 0.1);">
                        <i class="las la-wallet text-xl" style="color: #003366;"></i>
                    </div>
                </div>
                <div>
                    <h4 class="h4 mb-2" style="color: #003366; font-size: 28px; font-weight: 800;">₦{{ number_format($availableBalance ?? 0, 2) }}</h4>
                    <span class="flex items-center gap-2 text-sm font-medium" style="color: #003366;">
                        <div class="size-2 rounded-full bg-green-500"></div> Available for Payout
                    </span>
                </div>
            </div>

            <!-- TODAY'S COLLECTIONS -->
            <div class="box col-span-12 bg-white min-[650px]:col-span-6 3xl:col-span-3" style="border-top: 4px solid #D20103; box-shadow: 0 4px 20px rgba(210, 1, 3, 0.05); border-radius: 12px;">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 border-b border-slate-100">
                    <span class="font-medium text-slate-500 uppercase text-xs tracking-wider">Today's Collections</span>
                    <div class="flex size-8 items-center justify-center rounded-full" style="background-color: rgba(210, 1, 3, 0.1);">
                        <i class="las la-chart-bar text-xl" style="color: #D20103;"></i>
                    </div>
                </div>
                <div>
                    <h4 class="h4 mb-2" style="color: #D20103; font-size: 28px; font-weight: 800;">₦{{ number_format($todayCollections ?? 0, 2) }}</h4>
                    <span class="flex items-center gap-2 text-sm font-medium text-slate-500">
                        <i class="las la-arrow-up text-red-500"></i> Live Virtual Accounts
                    </span>
                </div>
            </div>

            <!-- ACTIVE SUB-AGENTS -->
            <div class="box col-span-12 bg-white min-[650px]:col-span-6 3xl:col-span-3" style="border-top: 4px solid #003366; box-shadow: 0 4px 20px rgba(0, 51, 102, 0.05); border-radius: 12px;">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 border-b border-slate-100">
                    <span class="font-medium text-slate-500 uppercase text-xs tracking-wider">Active Sub-Agents</span>
                    <div class="flex size-8 items-center justify-center rounded-full" style="background-color: rgba(0, 51, 102, 0.1);">
                        <i class="las la-users text-xl" style="color: #003366;"></i>
                    </div>
                </div>
                <div>
                    <h4 class="h4 mb-2" style="color: #003366; font-size: 28px; font-weight: 800;">{{ $activeAgentsCount ?? 0 }}</h4>
                    <span class="flex items-center gap-2 text-sm font-medium text-slate-500">
                        <i class="las la-check-circle" style="color: #003366;"></i> Provisioned Accounts
                    </span>
                </div>
            </div>

            <!-- 🟢 DYNAMIC GATEWAY INFRASTRUCTURE STATUS CARD -->
            <div class="relative group z-50 cursor-pointer col-span-12 min-[650px]:col-span-6 3xl:col-span-3">
                
                <!-- Main Card -->
                <div id="merchant-health-card" class="box h-full bg-white transition-all duration-500 overflow-hidden" style="border-top: 4px solid #94A3B8; box-shadow: 0 4px 20px rgba(148, 163, 184, 0.05); border-radius: 12px; position: relative;">
                    <div class="absolute -right-4 -top-4 opacity-5 pointer-events-none">
                        <i class="las la-server text-9xl"></i>
                    </div>
                    <div class="bb-dashed mb-4 flex items-center justify-between pb-4 border-b border-slate-100 relative">
                        <span class="font-medium text-slate-500 uppercase text-xs tracking-wider">Gateway Status</span>
                        <div class="relative">
                            <div id="merchant-health-icon-bg" class="flex size-8 items-center justify-center rounded-full transition-colors duration-500" style="background-color: rgba(148, 163, 184, 0.1);">
                                <i id="merchant-health-icon" class="las la-server text-xl transition-colors duration-500" style="color: #94A3B8;"></i>
                            </div>
                            <div id="merchant-health-dot" class="absolute -top-1 -right-1 size-3 bg-[#94A3B8] border-2 border-white rounded-full transition-colors duration-500"></div>
                        </div>
                    </div>
                    <div>
                        <h4 id="merchant-health-text" class="h4 mb-2 transition-colors duration-500" style="color: #64748B; font-size: 28px; font-weight: 800;">Checking...</h4>
                        <span class="flex items-center gap-2 text-sm font-medium text-slate-500 whitespace-nowrap">
                            <i id="merchant-health-sub-icon" class="las la-sync spin" style="color: #64748B;"></i> <span id="merchant-health-subtext">Verifying core connections</span>
                        </span>
                    </div>
                </div>

                <!-- The Hover Dropdown Menu -->
                <div class="absolute left-0 top-[105%] w-full min-w-[280px] bg-white border border-slate-200 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 p-4 z-50">
                    <h5 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 pb-2 border-b border-slate-100">Gateway Diagnostics</h5>
                    <ul id="merchant-services-list" class="space-y-3">
                        <li class="text-sm text-slate-500 animate-pulse font-medium">Fetching infrastructure data...</li>
                    </ul>
                </div>
                
            </div>
            
            <!-- 7-DAY INFLOW CHART -->
            <div class="box col-span-12 mt-6 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <div class="bb-dashed mb-4 pb-4 border-b border-slate-100 flex justify-between items-center">
                    <h4 class="h4 text-[#003366] font-bold">Transaction Volume (Last 7 Days)</h4>
                    <span class="px-3 py-1 bg-[#D20103]/10 text-[#D20103] rounded-full text-xs font-bold border border-[#D20103]/20">NGN Inflow</span>
                </div>
                <div class="relative h-[300px] w-full">
                    <canvas id="volumeChart"></canvas>
                </div>
            </div>
            
            <!-- GATEWAY TOOLS -->
            <div class="box col-span-12 lg:col-span-6 mt-6">
                <div class="bb-dashed mb-4 pb-4 border-b border-slate-100">
                    <h4 class="h4 text-[#003366] font-bold">Gateway Tools</h4>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <a href="{{ url('/merchant/api-keys') }}" class="group flex flex-col items-center justify-center gap-3 rounded-xl border border-slate-200 bg-white p-5 transition-all duration-300 hover:border-[#003366] hover:shadow-lg hover:-translate-y-1">
                        <i class="las la-key text-3xl text-[#003366] group-hover:scale-110 transition-transform"></i>
                        <span class="font-semibold text-sm text-slate-700 group-hover:text-[#003366]">API Keys</span>
                    </a>
                    
                    <a href="{{ url('/merchant/webhooks') }}" class="group flex flex-col items-center justify-center gap-3 rounded-xl border border-slate-200 bg-white p-5 transition-all duration-300 hover:border-[#D20103] hover:shadow-lg hover:-translate-y-1">
                        <i class="las la-plug text-3xl text-[#D20103] group-hover:scale-110 transition-transform"></i>
                        <span class="font-semibold text-sm text-slate-700 group-hover:text-[#D20103]">Webhooks</span>
                    </a>
                    
                    <a href="{{ url('/merchant/settlements') }}" class="group flex flex-col items-center justify-center gap-3 rounded-xl border border-slate-200 bg-white p-5 transition-all duration-300 hover:border-[#003366] hover:shadow-lg hover:-translate-y-1">
                        <i class="las la-money-check-alt text-3xl text-[#003366] group-hover:scale-110 transition-transform"></i>
                        <span class="font-semibold text-sm text-slate-700 group-hover:text-[#003366]">Settlements</span>
                    </a>

                    <a href="{{ url('/merchant/sub-agents') }}" class="group flex flex-col items-center justify-center gap-3 rounded-xl border border-slate-200 bg-white p-5 transition-all duration-300 hover:border-[#D20103] hover:shadow-lg hover:-translate-y-1">
                        <i class="las la-sitemap text-3xl text-[#D20103] group-hover:scale-110 transition-transform"></i>
                        <span class="font-semibold text-sm text-slate-700 group-hover:text-[#D20103]">Sub-Agents</span>
                    </a>

                    <a href="{{ url('/merchant/ledger') }}" class="group flex flex-col items-center justify-center gap-3 rounded-xl border border-slate-200 bg-white p-5 transition-all duration-300 hover:border-[#003366] hover:shadow-lg hover:-translate-y-1">
                        <i class="las la-exchange-alt text-3xl text-[#003366] group-hover:scale-110 transition-transform"></i>
                        <span class="font-semibold text-sm text-slate-700 group-hover:text-[#003366]">Ledger</span>
                    </a>

                    <a href="{{ url('/merchant/compliance') }}" class="group flex flex-col items-center justify-center gap-3 rounded-xl border border-slate-200 bg-white p-5 transition-all duration-300 hover:border-[#D20103] hover:shadow-lg hover:-translate-y-1">
                        <i class="las la-id-card text-3xl text-[#D20103] group-hover:scale-110 transition-transform"></i>
                        <span class="font-semibold text-sm text-slate-700 group-hover:text-[#D20103]">Compliance</span>
                    </a>
                </div>
            </div>

            <!-- LIVE TRANSACTIONS RECENT ACCORDION -->
            <div class="box col-span-12 lg:col-span-6 mt-6 border border-slate-200 rounded-2xl p-6 bg-white shadow-sm">
                <div class="bb-dashed mb-4 flex flex-wrap items-center justify-between gap-4 pb-4 border-b border-slate-100">
                    <h4 class="h4 text-[#003366] font-bold">Live Transactions</h4>
                    <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold animate-pulse border border-green-100 flex items-center gap-1">
                        <div class="size-1.5 rounded-full bg-green-500"></div> Live Polling Active
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="flex min-w-[200px] items-center gap-1 px-6 py-4 text-start text-xs uppercase tracking-wider text-slate-500 font-bold">Reference</th>
                                <th class="min-w-[120px] px-6 py-4 text-start text-xs uppercase tracking-wider text-slate-500 font-bold">Status</th>
                                <th class="min-w-[120px] px-6 py-4 text-end text-xs uppercase tracking-wider text-slate-500 font-bold">Amount</th>
                            </tr>
                        </thead>
                        <tbody id="bankhub-transaction-list">
                            @forelse($recentActivities as $tx)
                                <tr class="border-b border-slate-50 hover:bg-slate-50 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex size-10 items-center justify-center rounded-full bg-slate-100 text-[#003366]">
                                                <i class="las {{ $tx->type === 'credit' ? 'la-arrow-down' : 'la-arrow-up' }} text-xl"></i>
                                            </div>
                                            <div>
                                                <p class="font-bold text-[#003366] mb-0">{{ $tx->session_id ?? $tx->reference ?? 'TXN-'.Str::random(6) }}</p>
                                                <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($tx->created_at)->format('d M, Y • h:i A') }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($tx->status == 'successful')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-600 border border-green-100">
                                                <div class="size-1.5 rounded-full bg-green-500"></div> Successful
                                            </span>
                                        @elseif($tx->status == 'pending')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-yellow-50 px-3 py-1 text-xs font-bold text-yellow-600 border border-yellow-100">
                                                <div class="size-1.5 rounded-full bg-yellow-500 animate-pulse"></div> Pending
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-600 border border-red-100">
                                                <div class="size-1.5 rounded-full bg-red-500"></div> Failed
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-black text-[#003366] text-right text-lg">
                                        {{ $tx->type === 'credit' ? '+' : '-' }}₦{{ number_format($tx->amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-slate-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="size-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                                <i class="las la-inbox text-3xl text-slate-400"></i>
                                            </div>
                                            <p class="font-medium text-slate-600">No recent transactions</p>
                                            <p class="text-sm text-slate-400 mt-1">When collections arrive, they will show up here instantly.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div> 

        @php
            $paymentLinks = \Illuminate\Support\Facades\DB::table('payment_links')
                ->where('merchant_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        @endphp

        <!-- RECENT PAYMENT LINKS -->
        <div class="mt-8 box bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-[#003366]">Recent Payment Links</h3>
                    <p class="text-xs text-slate-500 mt-1">Single-use URLs for quick customer invoicing.</p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left whitespace-nowrap">
                    <thead>
                        <tr class="bg-white border-b border-slate-100 text-xs uppercase tracking-wider text-slate-400 font-bold">
                            <th class="px-6 py-4">Title & Ref</th>
                            <th class="px-6 py-4">Checkout URL</th>
                            <th class="px-6 py-4">Temporary VA</th>
                            <th class="px-6 py-4 text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($paymentLinks as $link)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="block font-bold text-slate-700">{{ $link->title }}</span>
                                    <span class="text-xs text-slate-400">{{ $link->reference }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2 bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200 w-max">
                                        <span class="font-mono text-xs text-slate-600 truncate max-w-[200px]">{{ url('/invoice/' . $link->reference) }}</span>
                                        <button onclick="navigator.clipboard.writeText('{{ url('/invoice/' . $link->reference) }}'); alert('URL Copied!');" class="text-slate-400 hover:text-[#003366]">
                                            <i class="las la-copy text-lg"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="block font-mono font-bold text-slate-400">Dynamic</span>
                                    <span class="text-xs text-slate-400">Generated at checkout</span>
                                </td>
                                <td class="px-6 py-4 text-right font-black text-[#003366]">₦{{ number_format($link->amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                    <i class="las la-link text-3xl mb-2"></i>
                                    <p>No payment links generated yet. Click "New Payment Link" to start collecting.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
    </div> 

    <!-- CREATE LINK MODAL -->
    <div id="createLinkModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                <h4 class="font-bold text-[#003366]"><i class="las la-link"></i> Generate Payment Link</h4>
                <button onclick="document.getElementById('createLinkModal').classList.add('hidden')" class="text-slate-400 hover:text-red-500 transition-colors">
                    <i class="las la-times text-2xl"></i>
                </button>
            </div>
            <form action="{{ route('merchant.payment-links.store') }}" method="POST" class="p-6">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Payment Title / Invoice Reason</label>
                    <input type="text" name="title" required placeholder="e.g. Website Hosting Fee" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Amount to Collect (₦)</label>
                    <input type="number" name="amount" required min="100" placeholder="5000" class="w-full text-sm font-bold text-[#003366] bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Customer Email (Optional)</label>
                    <input type="email" name="customer_email" placeholder="customer@example.com" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none">
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('createLinkModal').classList.add('hidden')" class="px-5 py-2.5 rounded-lg font-bold text-slate-600 hover:bg-slate-50 transition-colors border border-slate-200">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-lg font-bold text-white transition-colors hover:bg-blue-900 shadow-sm" style="background-color: #003366;">Generate Link</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 🟢 DYNAMIC HEALTH POLLING INFRASTRUCTURE -->
    <script>
        (function() {
            const card = document.getElementById('merchant-health-card');
            const dot = document.getElementById('merchant-health-dot');
            const text = document.getElementById('merchant-health-text');
            const iconBg = document.getElementById('merchant-health-icon-bg');
            const icon = document.getElementById('merchant-health-icon');
            const subIcon = document.getElementById('merchant-health-sub-icon');
            const subtext = document.getElementById('merchant-health-subtext');
            const servicesList = document.getElementById('merchant-services-list');

            function updateGatewayUI(status) {
                if (!card || !text) return; 

                if (subIcon) {
                    subIcon.classList.remove('la-spin', 'animate-spin');
                }

                if (status === 'green') {
                    card.style.borderTopColor = '#108981';
                    dot.style.backgroundColor = '#108981';
                    dot.classList.add('animate-pulse');
                    text.textContent = 'Online';
                    text.style.color = '#108981';
                    iconBg.style.backgroundColor = 'rgba(16, 137, 129, 0.1)';
                    icon.style.color = '#108981';
                    subIcon.className = 'las la-plug text-green-600';
                    subtext.textContent = 'NIBSS Core Channels Active';
                } else if (status === 'yellow') {
                    card.style.borderTopColor = '#F59E0B';
                    dot.style.backgroundColor = '#F59E0B';
                    dot.classList.add('animate-pulse');
                    text.textContent = 'Degraded';
                    text.style.color = '#F59E0B';
                    iconBg.style.backgroundColor = 'rgba(245, 158, 11, 0.1)';
                    icon.style.color = '#F59E0B';
                    subIcon.className = 'las la-exclamation-circle text-yellow-600';
                    subtext.textContent = 'Delays on background queue';
                } else {
                    card.style.borderTopColor = '#D20103';
                    dot.style.backgroundColor = '#D20103';
                    dot.classList.remove('animate-pulse');
                    text.textContent = 'Outage';
                    text.style.color = '#D20103';
                    iconBg.style.backgroundColor = 'rgba(210, 1, 3, 0.1)';
                    icon.style.color = '#D20103';
                    subIcon.className = 'las la-times-circle text-red-600';
                    subtext.textContent = 'Gateway link unreachable';
                }
            }

            function renderServicesDropdown(services) {
                if (!servicesList) return;
                
                servicesList.innerHTML = ''; 
                
                for (const [key, service] of Object.entries(services)) {
                    const isOnline = service.status === 'online';
                    const colorClass = isOnline ? 'text-[#108981]' : 'text-[#D20103]'; 
                    const iconClass = isOnline ? 'la-check-circle' : 'la-times-circle';
                    const bgClass = isOnline ? 'bg-[#108981]/10' : 'bg-[#D20103]/10';

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

            function pollGatewayHealth() {
                if (subIcon && !subIcon.classList.contains('la-spin')) {
                    subIcon.classList.add('la-spin'); 
                }

                fetch('/system/status')
                    .then(response => {
                        if (!response.ok) throw new Error("Network error");
                        return response.json();
                    })
                    .then(payload => {
                        updateGatewayUI(payload.data.status);
                        if(payload.data.services) {
                            renderServicesDropdown(payload.data.services);
                        }
                    })
                    .catch(error => {
                        console.error("Gateway Health Check Failed:", error);
                        updateGatewayUI('red');
                        if (servicesList) {
                            servicesList.innerHTML = '<li class="text-sm text-red-500 font-bold">Failed to fetch diagnostics.</li>';
                        }
                    });
            }

            pollGatewayHealth();
            setInterval(pollGatewayHealth, 60000);
        })();
    </script>

    <!-- CHART.JS INTEGRATION -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route("merchant.dashboard.chart") }}', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(res => {
                if(res.status === 'success') {
                    const ctx = document.getElementById('volumeChart').getContext('2d');
                    
                    let gradient = ctx.createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, 'rgba(210, 1, 3, 0.2)');
                    gradient.addColorStop(1, 'rgba(210, 1, 3, 0)');

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: res.data.labels,
                            datasets: [{
                                label: 'Inbound Volume (₦)',
                                data: res.data.series,
                                borderColor: '#D20103',
                                backgroundColor: gradient,
                                borderWidth: 3,
                                pointBackgroundColor: '#003366',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: '#003366',
                                    padding: 12,
                                    titleFont: { size: 13, family: "'Inter', sans-serif" },
                                    bodyFont: { size: 14, weight: 'bold', family: "'Inter', sans-serif" },
                                    callbacks: {
                                        label: function(context) {
                                            let value = context.raw;
                                            return '₦' + value.toLocaleString(undefined, {minimumFractionDigits: 2});
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: { display: false, drawBorder: false },
                                    ticks: { font: { family: "'Inter', sans-serif", size: 12 }, color: '#64748B' }
                                },
                                y: {
                                    grid: { color: '#F1F5F9', borderDash: [5, 5], drawBorder: false },
                                    ticks: {
                                        font: { family: "'Inter', sans-serif", size: 12 },
                                        color: '#64748B',
                                        callback: function(value) {
                                            if (value >= 1000000) return '₦' + (value / 1000000).toFixed(1) + 'M';
                                            if (value >= 1000) return '₦' + (value / 1000).toFixed(1) + 'k';
                                            return '₦' + value;
                                        }
                                    },
                                    beginAtZero: true
                                }
                            },
                            interaction: {
                                intersect: false,
                                mode: 'index',
                            },
                        }
                    });
                }
            });
        });
    </script>
@endsection