@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Investments</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            <!-- Enhanced Portfolio Summary -->
            <div
                class="box col-span-12 bg-linear-to-br from-primary to-primary/80 text-white min-[650px]:col-span-6 xl:col-span-3">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex size-12 items-center justify-center rounded-full bg-white/20">
                        <i class="las la-chart-line text-2xl"></i>
                    </div>
                    @include('partials._horizontal-options')
                </div>
                <div>
                    <p class="mb-2 text-sm opacity-90">Total Portfolio Value</p>
                    <h4 class="h4 mb-2">$245,680</h4>
                    <span class="flex items-center gap-1 text-sm"> <i class="las la-arrow-up text-lg"></i> +12.5% this year
                    </span>
                </div>
            </div>

            <div class="box col-span-12 bg-n0 min-[650px]:col-span-6 xl:col-span-3">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex size-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                        <i class="las la-dollar-sign text-2xl"></i>
                    </div>
                    @include('partials._horizontal-options')
                </div>
                <div>
                    <p class="mb-2 text-sm text-n700">Total Invested</p>
                    <h4 class="h4 mb-2">$200,000</h4>
                    <span class="text-sm text-n700">Initial Capital</span>
                </div>
            </div>

            <div class="box col-span-12 bg-n0 min-[650px]:col-span-6 xl:col-span-3">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex size-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                        <i class="las la-chart-area text-2xl"></i>
                    </div>
                    @include('partials._horizontal-options')
                </div>
                <div>
                    <p class="mb-2 text-sm text-n700">Total Gains</p>
                    <h4 class="h4 mb-2">$45,680</h4>
                    <div class="flex items-center gap-2">
                        <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-n30">
                            <div class="h-full bg-primary" style="width: 22.8%"></div>
                        </div>
                        <span class="text-sm font-medium text-primary">+22.8%</span>
                    </div>
                </div>
            </div>

            <div class="box col-span-12 bg-n0 min-[650px]:col-span-6 xl:col-span-3">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex size-12 items-center justify-center rounded-full bg-[#FFC861]/10 text-[#FFC861]">
                        <i class="las la-coins text-2xl"></i>
                    </div>
                    @include('partials._horizontal-options')
                </div>
                <div>
                    <p class="mb-2 text-sm text-n700">Dividend Income</p>
                    <h4 class="h4 mb-2">$8,420</h4>
                    <span class="flex items-center gap-1 text-sm text-[#FFC861]"> <i class="las la-calendar"></i> This Year
                    </span>
                </div>
            </div>

            <!-- Portfolio Performance Chart -->
            <div class="box col-span-12 lg:col-span-8">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4">
                    <h4 class="h4">Portfolio Performance</h4>
                    <div class="flex items-center gap-2">
                        <button class="rounded-lg border border-n30 bg-primary/5 px-3 py-1 text-sm font-medium">1M</button>
                        <button class="rounded-lg border border-n30 px-3 py-1 text-sm font-medium">6M</button>
                        <button class="rounded-lg border border-n30 px-3 py-1 text-sm font-medium">1Y</button>
                        <button class="rounded-lg border border-n30 px-3 py-1 text-sm font-medium">All</button>
                    </div>
                </div>
                <div id="portfolio-performance-chart" class="h-80"></div>
            </div>

            <!-- Asset Allocation Chart -->
            <div class="box col-span-12 bg-n0 lg:col-span-4">
                <div class="bb-dashed mb-4 pb-4">
                    <h5 class="h5">Asset Allocation</h5>
                </div>
                <div id="asset-allocation-chart" class="h-64"></div>
            </div>

            <!-- Performance Metrics -->
            <div class="box col-span-12 bg-linear-to-br from-primary/5 to-primary/5 lg:col-span-4">
                <div class="mb-4">
                    <h5 class="h5 mb-2">Performance Metrics</h5>
                    <p class="text-sm text-n700">Key indicators for your portfolio</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-xl bg-white p-4 text-center">
                        <i class="las la-percentage mb-2 text-3xl text-primary"></i>
                        <p class="mb-1 text-2xl font-bold">22.8%</p>
                        <p class="text-xs text-n700">Total ROI</p>
                    </div>
                    <div class="rounded-xl bg-white p-4 text-center">
                        <i class="las la-chart-line mb-2 text-3xl text-primary"></i>
                        <p class="mb-1 text-2xl font-bold">+12.5%</p>
                        <p class="text-xs text-n700">YTD Return</p>
                    </div>
                    <div class="rounded-xl bg-white p-4 text-center">
                        <i class="las la-coins mb-2 text-3xl text-[#FFC861]"></i>
                        <p class="mb-1 text-2xl font-bold">3.4%</p>
                        <p class="text-xs text-n700">Dividend Yield</p>
                    </div>
                    <div class="rounded-xl bg-white p-4 text-center">
                        <i class="las la-balance-scale mb-2 text-3xl text-[#4371E9]"></i>
                        <p class="mb-1 text-2xl font-bold">0.85</p>
                        <p class="text-xs text-n700">Beta</p>
                    </div>
                </div>
            </div>

            <!-- Top Holdings -->
            <div class="box col-span-12 lg:col-span-8">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 lg:mb-6 lg:pb-6">
                    <h4 class="h4">Top Holdings</h4>
                    @include('partials._horizontal-options')
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-secondary/5">
                                <th class="px-6 py-5 text-start">Asset</th>
                                <th class="px-6 py-5 text-start">Shares</th>
                                <th class="px-6 py-5 text-start">Avg Price</th>
                                <th class="px-6 py-5 text-start">Current Value</th>
                                <th class="px-6 py-5 text-start">Change</th>
                                <th class="px-6 py-5 text-start">Allocation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="even:bg-secondary/5">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex size-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                                            <i class="lab la-apple text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="mb-1 font-medium">Apple Inc.</p>
                                            <span class="text-xs text-n700">AAPL</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3 font-semibold">250</td>
                                <td class="px-6 py-3">$165.00</td>
                                <td class="px-6 py-3 font-semibold text-primary">$42,500</td>
                                <td class="px-6 py-3">
                                    <span class="flex items-center gap-1 text-primary"> <i class="las la-arrow-up"></i>
                                        +8.5%
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="h-2 w-16 overflow-hidden rounded-full bg-n30">
                                            <div class="h-full bg-primary" style="width: 17%"></div>
                                        </div>
                                        <span class="text-xs">17%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex size-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                                            <i class="lab la-microsoft text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="mb-1 font-medium">Microsoft Corp.</p>
                                            <span class="text-xs text-n700">MSFT</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3 font-semibold">180</td>
                                <td class="px-6 py-3">$205.00</td>
                                <td class="px-6 py-3 font-semibold text-primary">$38,700</td>
                                <td class="px-6 py-3">
                                    <span class="flex items-center gap-1 text-primary"> <i class="las la-arrow-up"></i>
                                        +12.3%
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="h-2 w-16 overflow-hidden rounded-full bg-n30">
                                            <div class="h-full bg-primary" style="width: 15%"></div>
                                        </div>
                                        <span class="text-xs">15%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex size-10 items-center justify-center rounded-full bg-[#EF4444]/10 text-[#EF4444]">
                                            <i class="las la-car text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="mb-1 font-medium">Tesla Inc.</p>
                                            <span class="text-xs text-n700">TSLA</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3 font-semibold">120</td>
                                <td class="px-6 py-3">$240.00</td>
                                <td class="px-6 py-3 font-semibold text-[#EF4444]">$29,400</td>
                                <td class="px-6 py-3">
                                    <span class="flex items-center gap-1 text-[#EF4444]"> <i class="las la-arrow-down"></i>
                                        -3.2% </span>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="h-2 w-16 overflow-hidden rounded-full bg-n30">
                                            <div class="h-full bg-[#EF4444]" style="width: 12%"></div>
                                        </div>
                                        <span class="text-xs">12%</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="box col-span-12">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 lg:mb-6 lg:pb-6">
                    <h4 class="h4">Recent Transactions</h4>
                    <a href="#" class="text-sm font-semibold text-primary">View All</a>
                </div>
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        class="group rounded-xl border-2 border-primary/20 bg-primary/5 p-4 duration-300 hover:border-primary hover:shadow-lg">
                        <div class="mb-3 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div
                                    class="flex size-10 items-center justify-center rounded-full bg-primary/20 text-primary">
                                    <i class="lab la-apple text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Apple Inc.</p>
                                    <span class="text-xs text-n700">AAPL</span>
                                </div>
                            </div>
                            <span class="rounded-full bg-primary px-2 py-1 text-xs font-medium text-white">Buy</span>
                        </div>
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-sm text-n700">50 shares</span>
                            <span class="font-semibold text-primary">$8,500</span>
                        </div>
                        <p class="text-xs text-n700">Jan 5, 2026</p>
                    </div>

                    <div
                        class="group rounded-xl border-2 border-[#EF4444]/20 bg-[#EF4444]/5 p-4 duration-300 hover:border-[#EF4444] hover:shadow-lg">
                        <div class="mb-3 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div
                                    class="flex size-10 items-center justify-center rounded-full bg-[#EF4444]/20 text-[#EF4444]">
                                    <i class="las la-shopping-cart text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Amazon.com</p>
                                    <span class="text-xs text-n700">AMZN</span>
                                </div>
                            </div>
                            <span class="rounded-full bg-[#EF4444] px-2 py-1 text-xs font-medium text-white">Sell</span>
                        </div>
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-sm text-n700">25 shares</span>
                            <span class="font-semibold text-[#EF4444]">$3,638</span>
                        </div>
                        <p class="text-xs text-n700">Jan 3, 2026</p>
                    </div>

                    <div
                        class="group rounded-xl border-2 border-primary/20 bg-primary/5 p-4 duration-300 hover:border-primary hover:shadow-lg">
                        <div class="mb-3 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div
                                    class="flex size-10 items-center justify-center rounded-full bg-primary/20 text-primary">
                                    <i class="las la-chart-area text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-medium">Vanguard S&P 500</p>
                                    <span class="text-xs text-n700">VOO</span>
                                </div>
                            </div>
                            <span class="rounded-full bg-primary px-2 py-1 text-xs font-medium text-white">Buy</span>
                        </div>
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-sm text-n700">100 shares</span>
                            <span class="font-semibold text-primary">$42,000</span>
                        </div>
                        <p class="text-xs text-n700">Dec 28, 2025</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection