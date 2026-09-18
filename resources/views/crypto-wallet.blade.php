@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Crypto Wallet</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            <!-- Wallet Overview -->
            <div class="box col-span-12 bg-n0 min-[650px]:col-span-6 xl:col-span-3">
                <div class="bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                    <span class="font-medium">Total Balance</span>
                </div>
                <div>
                    <h4 class="h4 mb-2">$52,840</h4>
                    <span class="flex items-center gap-1 text-sm text-primary"> <i class="las la-arrow-up text-lg"></i>
                        +18.5%
                        this month </span>
                </div>
            </div>

            <div class="box col-span-12 bg-n0 min-[650px]:col-span-6 xl:col-span-3">
                <div class="bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                    <span class="font-medium">Total Invested</span>
                </div>
                <div>
                    <h4 class="h4 mb-2">$45,000</h4>
                    <span class="flex items-center gap-1 text-sm text-n700">Initial Investment</span>
                </div>
            </div>

            <div class="box col-span-12 bg-n0 min-[650px]:col-span-6 xl:col-span-3">
                <div class="bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                    <span class="font-medium">Total Profit</span>
                </div>
                <div>
                    <h4 class="h4 mb-2">$7,840</h4>
                    <span class="flex items-center gap-1 text-sm text-primary"> <i class="las la-arrow-up text-lg"></i>
                        +17.4%
                        ROI </span>
                </div>
            </div>

            <div class="box col-span-12 bg-n0 min-[650px]:col-span-6 xl:col-span-3">
                <div class="bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                    <span class="font-medium">24h Change</span>
                </div>
                <div>
                    <h4 class="h4 mb-2">+$1,240</h4>
                    <span class="flex items-center gap-1 text-sm text-primary"> <i class="las la-arrow-up text-lg"></i>
                        +2.4%
                    </span>
                </div>
            </div>

            <!-- Crypto Holdings -->
            <div class="box col-span-12 lg:col-span-8">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 lg:mb-6 lg:pb-6">
                    <h4 class="h4">My Crypto Assets</h4>
                    @include('partials._horizontal-options')
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-secondary/5">
                                <th class="min-w-45 px-6 py-5 text-start">Asset</th>
                                <th class="min-w-25 px-6 py-5 text-start">Amount</th>
                                <th class="min-w-30 px-6 py-5 text-start">Price</th>
                                <th class="min-w-30 px-6 py-5 text-start">Value</th>
                                <th class="min-w-25 px-6 py-5 text-start">24h Change</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="even:bg-secondary/5">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex size-10 items-center justify-center rounded-full bg-[#F7931A]/10 text-[#F7931A]">
                                            <i class="lab la-bitcoin text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="mb-1 font-medium">Bitcoin</p>
                                            <span class="text-xs text-n700">BTC</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3">0.5842</td>
                                <td class="px-6 py-3">$42,850</td>
                                <td class="px-6 py-3 font-semibold">$25,030</td>
                                <td class="px-6 py-3">
                                    <span class="flex items-center gap-1 text-primary"> <i class="las la-arrow-up"></i>
                                        +3.2%
                                    </span>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex size-10 items-center justify-center rounded-full bg-[#627EEA]/10 text-[#627EEA]">
                                            <i class="lab la-ethereum text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="mb-1 font-medium">Ethereum</p>
                                            <span class="text-xs text-n700">ETH</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3">6.2450</td>
                                <td class="px-6 py-3">$2,240</td>
                                <td class="px-6 py-3 font-semibold">$13,989</td>
                                <td class="px-6 py-3">
                                    <span class="flex items-center gap-1 text-primary"> <i class="las la-arrow-up"></i>
                                        +2.8%
                                    </span>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex size-10 items-center justify-center rounded-full bg-[#26A17B]/10 text-[#26A17B]">
                                            <i class="las la-dollar-sign text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="mb-1 font-medium">Tether</p>
                                            <span class="text-xs text-n700">USDT</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3">8,500.00</td>
                                <td class="px-6 py-3">$1.00</td>
                                <td class="px-6 py-3 font-semibold">$8,500</td>
                                <td class="px-6 py-3">
                                    <span class="flex items-center gap-1 text-n700"> <i class="las la-minus"></i> 0.0%
                                    </span>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex size-10 items-center justify-center rounded-full bg-[#F3BA2F]/10 text-[#F3BA2F]">
                                            <i class="las la-coins text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="mb-1 font-medium">Binance Coin</p>
                                            <span class="text-xs text-n700">BNB</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3">18.5000</td>
                                <td class="px-6 py-3">$295.00</td>
                                <td class="px-6 py-3 font-semibold">$5,458</td>
                                <td class="px-6 py-3">
                                    <span class="flex items-center gap-1 text-[#EF4444]"> <i class="las la-arrow-down"></i>
                                        -1.5% </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="box col-span-12 bg-n0 lg:col-span-4">
                <div class="bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                    <h4 class="h4">Quick Actions</h4>
                </div>
                <div class="space-y-3">
                    <button
                        class="flex w-full items-center gap-3 rounded-xl border border-n30 bg-primary/5 p-4 duration-300 hover:border-primary hover:bg-primary/10">
                        <div class="flex size-12 items-center justify-center rounded-full bg-primary text-white">
                            <i class="las la-arrow-up text-2xl"></i>
                        </div>
                        <div class="text-start">
                            <p class="font-medium">Send Crypto</p>
                            <span class="text-xs text-n700">Transfer to wallet</span>
                        </div>
                    </button>
                    <button
                        class="flex w-full items-center gap-3 rounded-xl border border-n30 bg-primary/5 p-4 duration-300 hover:border-primary hover:bg-primary/10">
                        <div class="flex size-12 items-center justify-center rounded-full bg-primary text-white">
                            <i class="las la-arrow-down text-2xl"></i>
                        </div>
                        <div class="text-start">
                            <p class="font-medium">Receive Crypto</p>
                            <span class="text-xs text-n700">Get wallet address</span>
                        </div>
                    </button>
                    <button
                        class="flex w-full items-center gap-3 rounded-xl border border-n30 bg-primary/5 p-4 duration-300 hover:border-primary hover:bg-primary/10">
                        <div class="flex size-12 items-center justify-center rounded-full bg-[#FFC861] text-white">
                            <i class="las la-exchange-alt text-2xl"></i>
                        </div>
                        <div class="text-start">
                            <p class="font-medium">Swap Crypto</p>
                            <span class="text-xs text-n700">Exchange assets</span>
                        </div>
                    </button>
                    <button
                        class="flex w-full items-center gap-3 rounded-xl border border-n30 bg-primary/5 p-4 duration-300 hover:border-primary hover:bg-primary/10">
                        <div class="flex size-12 items-center justify-center rounded-full bg-[#4371E9] text-white">
                            <i class="las la-shopping-cart text-2xl"></i>
                        </div>
                        <div class="text-start">
                            <p class="font-medium">Buy Crypto</p>
                            <span class="text-xs text-n700">Purchase with card</span>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="box col-span-12">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 lg:mb-6 lg:pb-6">
                    <h4 class="h4">Recent Transactions</h4>
                    <a href="#" class="text-sm font-semibold text-primary">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-secondary/5">
                                <th class="min-w-50 px-6 py-5 text-start">Asset</th>
                                <th class="min-w-25 px-6 py-5 text-start">Type</th>
                                <th class="min-w-30 px-6 py-5 text-start">Amount</th>
                                <th class="min-w-30 px-6 py-5 text-start">Value</th>
                                <th class="min-w-30 px-6 py-5 text-start">Date</th>
                                <th class="min-w-25 px-6 py-5 text-start">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="even:bg-secondary/5">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="flex size-8 items-center justify-center rounded-full bg-[#F7931A]/10 text-[#F7931A]">
                                            <i class="lab la-bitcoin"></i>
                                        </div>
                                        <span class="font-medium">Bitcoin</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <span
                                        class="rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">Buy</span>
                                </td>
                                <td class="px-6 py-3">0.1250 BTC</td>
                                <td class="px-6 py-3">$5,356.25</td>
                                <td class="px-6 py-3">Jan 10, 2026</td>
                                <td class="px-6 py-3">
                                    <span
                                        class="rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">Completed</span>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="flex size-8 items-center justify-center rounded-full bg-[#627EEA]/10 text-[#627EEA]">
                                            <i class="lab la-ethereum"></i>
                                        </div>
                                        <span class="font-medium">Ethereum</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <span
                                        class="rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">Send</span>
                                </td>
                                <td class="px-6 py-3">2.5000 ETH</td>
                                <td class="px-6 py-3">$5,600.00</td>
                                <td class="px-6 py-3">Jan 8, 2026</td>
                                <td class="px-6 py-3">
                                    <span
                                        class="rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">Completed</span>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="flex size-8 items-center justify-center rounded-full bg-[#26A17B]/10 text-[#26A17B]">
                                            <i class="las la-dollar-sign"></i>
                                        </div>
                                        <span class="font-medium">Tether</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <span
                                        class="rounded-full bg-[#FFC861]/10 px-3 py-1 text-xs font-medium text-[#FFC861]">Receive</span>
                                </td>
                                <td class="px-6 py-3">1,000.00 USDT</td>
                                <td class="px-6 py-3">$1,000.00</td>
                                <td class="px-6 py-3">Jan 5, 2026</td>
                                <td class="px-6 py-3">
                                    <span
                                        class="rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">Completed</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection