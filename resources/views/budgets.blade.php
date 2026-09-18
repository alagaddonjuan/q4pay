@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Budgets</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            <!-- Enhanced Budget Summary Cards -->
            <div
                class="box col-span-12 bg-linear-to-br from-primary to-primary/80 text-white min-[650px]:col-span-6 xl:col-span-3">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex size-12 items-center justify-center rounded-full bg-white/20">
                        <i class="las la-wallet text-2xl"></i>
                    </div>
                    @include('partials._horizontal-options')
                </div>
                <div>
                    <p class="mb-2 text-sm opacity-90">Monthly Budget</p>
                    <h4 class="h4 mb-2">$5,000</h4>
                    <span class="text-sm opacity-90">Total Allocated</span>
                </div>
            </div>

            <div class="box col-span-12 bg-n0 min-[650px]:col-span-6 xl:col-span-3">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex size-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                        <i class="las la-check-circle text-2xl"></i>
                    </div>
                    @include('partials._horizontal-options')
                </div>
                <div>
                    <p class="mb-2 text-sm text-n700">Total Spent</p>
                    <h4 class="h4 mb-2">$3,750</h4>
                    <span class="flex items-center gap-1 text-sm text-primary"> <i class="las la-check-circle text-lg"></i>
                        Within Budget </span>
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
                    <p class="mb-2 text-sm text-n700">Remaining</p>
                    <h4 class="h4 mb-2">$1,250</h4>
                    <div class="flex items-center gap-2">
                        <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-n30">
                            <div class="h-full bg-[#FFC861]" style="width: 25%"></div>
                        </div>
                        <span class="text-sm font-medium text-[#FFC861]">25%</span>
                    </div>
                </div>
            </div>

            <div class="box col-span-12 bg-n0 min-[650px]:col-span-6 xl:col-span-3">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex size-12 items-center justify-center rounded-full bg-[#4371E9]/10 text-[#4371E9]">
                        <i class="las la-piggy-bank text-2xl"></i>
                    </div>
                    @include('partials._horizontal-options')
                </div>
                <div>
                    <p class="mb-2 text-sm text-n700">Savings Rate</p>
                    <h4 class="h4 mb-2">32%</h4>
                    <span class="flex items-center gap-1 text-sm text-primary"> <i class="las la-arrow-up text-lg"></i>
                        +5%
                        this month </span>
                </div>
            </div>

            <!-- Spending Trend Chart -->
            <div class="box col-span-12 lg:col-span-8">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4">
                    <h4 class="h4">Monthly Spending Trend</h4>
                    <div class="flex items-center gap-2">
                        <button class="rounded-lg border border-n30 bg-primary/5 px-3 py-1 text-sm font-medium">6M</button>
                        <button class="rounded-lg border border-n30 px-3 py-1 text-sm font-medium">1Y</button>
                    </div>
                </div>
                <div id="spending-trend-chart" class="h-80"></div>
            </div>

            <!-- Category Distribution Chart -->
            <div class="box col-span-12 bg-n0 lg:col-span-4">
                <div class="bb-dashed mb-4 pb-4">
                    <h5 class="h5">Category Distribution</h5>
                </div>
                <div id="category-distribution-chart" class="h-64"></div>
                <div class="mt-4 space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <div class="size-3 rounded-full bg-primary"></div>
                            <span>Housing</span>
                        </div>
                        <span class="font-semibold">30%</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <div class="size-3 rounded-full bg-primary"></div>
                            <span>Food</span>
                        </div>
                        <span class="font-semibold">12%</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <div class="size-3 rounded-full bg-[#FFC861]"></div>
                            <span>Transport</span>
                        </div>
                        <span class="font-semibold">8%</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <div class="size-3 rounded-full bg-[#4371E9]"></div>
                            <span>Shopping</span>
                        </div>
                        <span class="font-semibold">10%</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <div class="size-3 rounded-full bg-[#8B5CF6]"></div>
                            <span>Entertainment</span>
                        </div>
                        <span class="font-semibold">6%</span>
                    </div>
                </div>
            </div>

            <!-- Budget Categories with Enhanced Design -->
            <div class="box col-span-12 lg:col-span-8">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 lg:mb-6 lg:pb-6">
                    <h4 class="h4">Budget Categories</h4>
                    @include('partials._horizontal-options')
                </div>
                <div class="space-y-4">
                    <div
                        class="group rounded-xl border-2 border-primary/20 bg-primary/5 p-4 duration-300 hover:border-primary hover:shadow-lg">
                        <div class="mb-3 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex size-12 items-center justify-center rounded-full bg-primary/20 text-primary">
                                    <i class="las la-home text-2xl"></i>
                                </div>
                                <div>
                                    <p class="mb-1 font-semibold">Housing</p>
                                    <span class="text-sm text-n700">$1,500 of $1,500</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-primary">100%</span>
                                <p class="text-xs text-n700">At Limit</p>
                            </div>
                        </div>
                        <div class="h-2.5 w-full overflow-hidden rounded-full bg-n30">
                            <div class="h-full bg-primary transition-all duration-500" style="width: 100%"></div>
                        </div>
                    </div>

                    <div
                        class="group rounded-xl border-2 border-primary/20 bg-primary/5 p-4 duration-300 hover:border-primary hover:shadow-lg">
                        <div class="mb-3 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex size-12 items-center justify-center rounded-full bg-primary/20 text-primary">
                                    <i class="las la-utensils text-2xl"></i>
                                </div>
                                <div>
                                    <p class="mb-1 font-semibold">Food & Dining</p>
                                    <span class="text-sm text-n700">$450 of $600</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-primary">75%</span>
                                <p class="text-xs text-n700">On Track</p>
                            </div>
                        </div>
                        <div class="h-2.5 w-full overflow-hidden rounded-full bg-n30">
                            <div class="h-full bg-primary transition-all duration-500" style="width: 75%"></div>
                        </div>
                    </div>

                    <div
                        class="group rounded-xl border-2 border-[#FFC861]/20 bg-[#FFC861]/5 p-4 duration-300 hover:border-[#FFC861] hover:shadow-lg">
                        <div class="mb-3 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex size-12 items-center justify-center rounded-full bg-[#FFC861]/20 text-[#FFC861]">
                                    <i class="las la-car text-2xl"></i>
                                </div>
                                <div>
                                    <p class="mb-1 font-semibold">Transportation</p>
                                    <span class="text-sm text-n700">$280 of $400</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-[#FFC861]">70%</span>
                                <p class="text-xs text-n700">Good</p>
                            </div>
                        </div>
                        <div class="h-2.5 w-full overflow-hidden rounded-full bg-n30">
                            <div class="h-full bg-[#FFC861] transition-all duration-500" style="width: 70%"></div>
                        </div>
                    </div>

                    <div
                        class="group rounded-xl border-2 border-[#4371E9]/20 bg-[#4371E9]/5 p-4 duration-300 hover:border-[#4371E9] hover:shadow-lg">
                        <div class="mb-3 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex size-12 items-center justify-center rounded-full bg-[#4371E9]/20 text-[#4371E9]">
                                    <i class="las la-shopping-bag text-2xl"></i>
                                </div>
                                <div>
                                    <p class="mb-1 font-semibold">Shopping</p>
                                    <span class="text-sm text-n700">$320 of $500</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-[#4371E9]">64%</span>
                                <p class="text-xs text-n700">Good</p>
                            </div>
                        </div>
                        <div class="h-2.5 w-full overflow-hidden rounded-full bg-n30">
                            <div class="h-full bg-[#4371E9] transition-all duration-500" style="width: 64%"></div>
                        </div>
                    </div>

                    <div
                        class="group rounded-xl border-2 border-[#8B5CF6]/20 bg-[#8B5CF6]/5 p-4 duration-300 hover:border-[#8B5CF6] hover:shadow-lg">
                        <div class="mb-3 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex size-12 items-center justify-center rounded-full bg-[#8B5CF6]/20 text-[#8B5CF6]">
                                    <i class="las la-film text-2xl"></i>
                                </div>
                                <div>
                                    <p class="mb-1 font-semibold">Entertainment</p>
                                    <span class="text-sm text-n700">$200 of $300</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-[#8B5CF6]">67%</span>
                                <p class="text-xs text-n700">Watch</p>
                            </div>
                        </div>
                        <div class="h-2.5 w-full overflow-hidden rounded-full bg-n30">
                            <div class="h-full bg-[#8B5CF6] transition-all duration-500" style="width: 67%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Spending Insights -->
            <div class="box col-span-12 bg-n0 lg:col-span-4">
                <div class="bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                    <h4 class="h4">Spending Insights</h4>
                </div>
                <div class="space-y-4">
                    <div class="rounded-xl bg-linear-to-br from-primary/10 to-primary/5 p-4">
                        <div class="mb-2 flex items-center gap-2">
                            <i class="las la-lightbulb text-xl text-primary"></i>
                            <span class="font-semibold">Smart Tip</span>
                        </div>
                        <p class="text-sm text-n700">You're spending 30% on housing, which is within the recommended 25-35%
                            range.</p>
                    </div>

                    <div class="rounded-xl bg-linear-to-br from-[#FFC861]/10 to-[#FFC861]/5 p-4">
                        <div class="mb-2 flex items-center gap-2">
                            <i class="las la-exclamation-triangle text-xl text-[#FFC861]"></i>
                            <span class="font-semibold">Warning</span>
                        </div>
                        <p class="text-sm text-n700">Your entertainment spending is 67% of budget. Consider reducing
                            expenses by
                            $100.</p>
                    </div>

                    <div class="rounded-xl bg-linear-to-br from-primary/10 to-primary/5 p-4">
                        <div class="mb-2 flex items-center gap-2">
                            <i class="las la-trophy text-xl text-primary"></i>
                            <span class="font-semibold">Great Job!</span>
                        </div>
                        <p class="text-sm text-n700">You're saving 32% of your income this month. You're on track to save
                            $15,000 this year!</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-xl border border-n30 bg-white p-3 text-center">
                            <i class="las la-chart-pie mb-1 text-2xl text-primary"></i>
                            <p class="mb-1 text-lg font-bold">Housing</p>
                            <p class="text-xs text-n700">Top Category</p>
                        </div>
                        <div class="rounded-xl border border-n30 bg-white p-3 text-center">
                            <i class="las la-calendar-day mb-1 text-2xl text-primary"></i>
                            <p class="mb-1 text-lg font-bold">$125</p>
                            <p class="text-xs text-n700">Daily Avg</p>
                        </div>
                    </div>
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
                                <th class="px-6 py-5 text-start">Description</th>
                                <th class="px-6 py-5 text-start">Category</th>
                                <th class="px-6 py-5 text-start">Date</th>
                                <th class="px-6 py-5 text-start">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="even:bg-secondary/5">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex size-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                                            <i class="las la-home"></i>
                                        </div>
                                        <span class="font-medium">Rent Payment</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3">Housing</td>
                                <td class="px-6 py-3">Jan 1, 2026</td>
                                <td class="px-6 py-3 font-semibold text-primary">$1,500</td>
                            </tr>
                            <tr class="even:bg-secondary/5">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex size-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                                            <i class="las la-utensils"></i>
                                        </div>
                                        <span class="font-medium">Grocery Shopping</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3">Food & Dining</td>
                                <td class="px-6 py-3">Jan 8, 2026</td>
                                <td class="px-6 py-3 font-semibold text-primary">$125</td>
                            </tr>
                            <tr class="even:bg-secondary/5">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex size-10 items-center justify-center rounded-full bg-[#FFC861]/10 text-[#FFC861]">
                                            <i class="las la-gas-pump"></i>
                                        </div>
                                        <span class="font-medium">Gas Station</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3">Transportation</td>
                                <td class="px-6 py-3">Jan 9, 2026</td>
                                <td class="px-6 py-3 font-semibold text-[#FFC861]">$45</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection