@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Loans</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>
        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            <!-- Enhanced Loan Overview Cards -->
            <div
                class="box col-span-12 bg-linear-to-br from-primary to-primary/80 text-white min-[650px]:col-span-6 xl:col-span-3">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex size-12 items-center justify-center rounded-full bg-white/20">
                        <i class="las la-wallet text-2xl"></i>
                    </div>
                    @include('partials._horizontal-options')
                </div>
                <div>
                    <p class="mb-2 text-sm opacity-90">Total Loans</p>
                    <h4 class="h4 mb-2">$125,000</h4>
                    <div class="flex items-center gap-2 text-sm">
                        <span class="rounded-full bg-white/20 px-2 py-0.5">3 Active</span>
                        <span class="opacity-75">•</span>
                        <span class="opacity-90">2 Pending</span>
                    </div>
                </div>
            </div>

            <div class="box col-span-12 bg-n0 min-[650px]:col-span-6 xl:col-span-3">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex size-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                        <i class="las la-calendar-check text-2xl"></i>
                    </div>
                    @include('partials._horizontal-options')
                </div>
                <div>
                    <p class="mb-2 text-sm text-n700">Monthly Payment</p>
                    <h4 class="h4 mb-2">$3,250</h4>
                    <span class="flex items-center gap-1 text-sm text-primary"> <i class="las la-arrow-down text-lg"></i>
                        5%
                        from last month </span>
                </div>
            </div>

            <div class="box col-span-12 bg-n0 min-[650px]:col-span-6 xl:col-span-3">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex size-12 items-center justify-center rounded-full bg-[#FFC861]/10 text-[#FFC861]">
                        <i class="las la-check-circle text-2xl"></i>
                    </div>
                    @include('partials._horizontal-options')
                </div>
                <div>
                    <p class="mb-2 text-sm text-n700">Total Paid</p>
                    <h4 class="h4 mb-2">$45,600</h4>
                    <div class="flex items-center gap-2">
                        <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-n30">
                            <div class="h-full bg-primary" style="width: 36%"></div>
                        </div>
                        <span class="text-sm font-medium text-primary">36%</span>
                    </div>
                </div>
            </div>

            <div class="box col-span-12 bg-n0 min-[650px]:col-span-6 xl:col-span-3">
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex size-12 items-center justify-center rounded-full bg-[#4371E9]/10 text-[#4371E9]">
                        <i class="las la-hourglass-half text-2xl"></i>
                    </div>
                    @include('partials._horizontal-options')
                </div>
                <div>
                    <p class="mb-2 text-sm text-n700">Remaining Balance</p>
                    <h4 class="h4 mb-2">$79,400</h4>
                    <span class="flex items-center gap-1 text-sm text-n700"> <i class="las la-clock"></i> 36 months left
                    </span>
                </div>
            </div>

            <!-- Loan Health Score -->
            <div class="box col-span-12 bg-linear-to-br from-primary to-primary/80 text-white lg:col-span-4">
                <div class="mb-4">
                    <h5 class="h5 mb-1">Loan Health Score</h5>
                    <p class="text-sm opacity-90">Based on payment history & credit utilization</p>
                </div>
                <div class="flex items-center gap-6">
                    <div class="relative">
                        <svg class="size-24" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="8">
                            </circle>
                            <circle cx="50" cy="50" r="40" fill="none" stroke="white" stroke-width="8"
                                stroke-dasharray="251.2" stroke-dashoffset="62.8" stroke-linecap="round"
                                transform="rotate(-90 50 50)"></circle>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-2xl font-bold">85</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="mb-2 text-lg font-semibold">Excellent</p>
                        <ul class="space-y-1 text-sm opacity-90">
                            <li class="flex items-center gap-2"><i class="las la-check-circle"></i> On-time payments</li>
                            <li class="flex items-center gap-2"><i class="las la-check-circle"></i> Low debt ratio</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Interest Rate Comparison -->
            <div class="box col-span-12 bg-n0 lg:col-span-4">
                <div class="bb-dashed mb-4 pb-4">
                    <h5 class="h5">Interest Rate Comparison</h5>
                </div>
                <div class="space-y-4">
                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-sm font-medium">Home Mortgage</span>
                            <span class="text-sm font-semibold text-primary">3.5%</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="h-2 flex-1 overflow-hidden rounded-full bg-n30">
                                <div class="h-full bg-primary" style="width: 35%"></div>
                            </div>
                            <span class="text-xs text-primary">Great</span>
                        </div>
                    </div>
                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-sm font-medium">Car Loan</span>
                            <span class="text-sm font-semibold text-[#FFC861]">4.2%</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="h-2 flex-1 overflow-hidden rounded-full bg-n30">
                                <div class="h-full bg-[#FFC861]" style="width: 42%"></div>
                            </div>
                            <span class="text-xs text-[#FFC861]">Good</span>
                        </div>
                    </div>
                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-sm font-medium">Personal Loan</span>
                            <span class="text-sm font-semibold text-[#EF4444]">5.8%</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="h-2 flex-1 overflow-hidden rounded-full bg-n30">
                                <div class="h-full bg-[#EF4444]" style="width: 58%"></div>
                            </div>
                            <span class="text-xs text-[#EF4444]">High</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 rounded-xl bg-primary/5 p-3">
                    <p class="text-xs text-n700">
                        <i class="las la-lightbulb text-primary"></i>
                        Consider refinancing your personal loan to save $1,200/year
                    </p>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="box col-span-12 bg-n0 lg:col-span-4">
                <div class="bb-dashed mb-4 pb-4">
                    <h5 class="h5">Quick Stats</h5>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="rounded-xl bg-primary/5 p-4 text-center">
                        <i class="las la-percentage mb-2 text-3xl text-primary"></i>
                        <p class="mb-1 text-2xl font-bold">4.2%</p>
                        <p class="text-xs text-n700">Avg Interest</p>
                    </div>
                    <div class="rounded-xl bg-primary/5 p-4 text-center">
                        <i class="las la-calendar mb-2 text-3xl text-primary"></i>
                        <p class="mb-1 text-2xl font-bold">28</p>
                        <p class="text-xs text-n700">Months Left</p>
                    </div>
                    <div class="rounded-xl bg-[#FFC861]/5 p-4 text-center">
                        <i class="las la-coins mb-2 text-3xl text-[#FFC861]"></i>
                        <p class="mb-1 text-2xl font-bold">$8.2K</p>
                        <p class="text-xs text-n700">Interest Paid</p>
                    </div>
                    <div class="rounded-xl bg-[#4371E9]/5 p-4 text-center">
                        <i class="las la-chart-line mb-2 text-3xl text-[#4371E9]"></i>
                        <p class="mb-1 text-2xl font-bold">92%</p>
                        <p class="text-xs text-n700">Payment Rate</p>
                    </div>
                </div>
            </div>

            <!-- Loan Amortization Chart -->
            <div class="box col-span-12 lg:col-span-8">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4">
                    <h4 class="h4">Loan Amortization Overview</h4>
                    <div class="flex items-center gap-2">
                        <button
                            class="rounded-lg border border-n30 bg-primary/5 px-3 py-1 text-sm font-medium">Principal</button>
                        <button class="rounded-lg border border-n30 px-3 py-1 text-sm font-medium">Interest</button>
                    </div>
                </div>
                <div id="loan-amortization-chart" class="h-104"></div>
            </div>

            <!-- Payment History Timeline -->
            <div class="box col-span-12 bg-n0 lg:col-span-4">
                <div class="bb-dashed mb-4 pb-4">
                    <h5 class="h5">Payment History</h5>
                </div>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <div class="flex size-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                                <i class="las la-check"></i>
                            </div>
                            <div class="my-2 h-12 w-0.5 bg-n30"></div>
                        </div>
                        <div class="flex-1">
                            <p class="mb-1 font-medium">Payment Successful</p>
                            <p class="mb-1 text-sm text-n700">Home Mortgage - $2,100</p>
                            <span class="text-xs text-n700">Jan 5, 2026</span>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <div class="flex size-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                                <i class="las la-check"></i>
                            </div>
                            <div class="my-2 h-12 w-0.5 bg-n30"></div>
                        </div>
                        <div class="flex-1">
                            <p class="mb-1 font-medium">Payment Successful</p>
                            <p class="mb-1 text-sm text-n700">Car Loan - $750</p>
                            <span class="text-xs text-n700">Jan 5, 2026</span>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <div
                                class="flex size-10 items-center justify-center rounded-full bg-[#FFC861]/10 text-[#FFC861]">
                                <i class="las la-clock"></i>
                            </div>
                            <div class="my-2 h-12 w-0.5 bg-n30"></div>
                        </div>
                        <div class="flex-1">
                            <p class="mb-1 font-medium">Payment Scheduled</p>
                            <p class="mb-1 text-sm text-n700">Personal Loan - $400</p>
                            <span class="text-xs text-n700">Jan 20, 2026</span>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center">
                            <div class="flex size-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                                <i class="las la-info"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="mb-1 font-medium">Refinance Approved</p>
                            <p class="mb-1 text-sm text-n700">Home Mortgage</p>
                            <span class="text-xs text-n700">Dec 28, 2025</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Loans Table -->
            <div class="box col-span-12">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 lg:mb-6 lg:pb-6">
                    <h4 class="h4">Active Loans Details</h4>
                    @include('partials._horizontal-options')
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-secondary/5">
                                <th class="px-6 py-5 text-start">Loan Type</th>
                                <th class="px-6 py-5 text-start">Principal</th>
                                <th class="px-6 py-5 text-start">Interest</th>
                                <th class="px-6 py-5 text-start">Monthly</th>
                                <th class="px-6 py-5 text-start">Progress</th>
                                <th class="px-6 py-5 text-start">Status</th>
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
                                        <div>
                                            <p class="mb-1 font-medium">Home Mortgage</p>
                                            <span class="text-xs text-n700">Started: Jan 2023 • 30 years</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3 font-semibold">$85,000</td>
                                <td class="px-6 py-3">3.5%</td>
                                <td class="px-6 py-3 font-semibold text-primary">$2,100</td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="h-2 w-20 overflow-hidden rounded-full bg-n30">
                                            <div class="h-full bg-primary" style="width: 35%"></div>
                                        </div>
                                        <span class="text-xs font-medium">35%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <span
                                        class="rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">Active</span>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex size-10 items-center justify-center rounded-full bg-[#FFC861]/10 text-[#FFC861]">
                                            <i class="las la-car"></i>
                                        </div>
                                        <div>
                                            <p class="mb-1 font-medium">Car Loan</p>
                                            <span class="text-xs text-n700">Started: Jun 2023 • 5 years</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3 font-semibold">$25,000</td>
                                <td class="px-6 py-3">4.2%</td>
                                <td class="px-6 py-3 font-semibold text-[#FFC861]">$750</td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="h-2 w-20 overflow-hidden rounded-full bg-n30">
                                            <div class="h-full bg-[#FFC861]" style="width: 45%"></div>
                                        </div>
                                        <span class="text-xs font-medium">45%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <span
                                        class="rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">Active</span>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex size-10 items-center justify-center rounded-full bg-[#4371E9]/10 text-[#4371E9]">
                                            <i class="las la-hand-holding-usd"></i>
                                        </div>
                                        <div>
                                            <p class="mb-1 font-medium">Personal Loan</p>
                                            <span class="text-xs text-n700">Started: Mar 2024 • 3 years</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3 font-semibold">$15,000</td>
                                <td class="px-6 py-3">5.8%</td>
                                <td class="px-6 py-3 font-semibold text-[#4371E9]">$400</td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="h-2 w-20 overflow-hidden rounded-full bg-n30">
                                            <div class="h-full bg-[#4371E9]" style="width: 25%"></div>
                                        </div>
                                        <span class="text-xs font-medium">25%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <span
                                        class="rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">Active</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Enhanced Loan Calculator -->
            <div class="box col-span-12 bg-linear-to-br from-primary/5 to-primary/5 lg:col-span-5">
                <div class="mb-6">
                    <h4 class="h4 mb-2">Advanced Loan Calculator</h4>
                    <p class="text-sm text-n700">Calculate your monthly payments and total interest</p>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="mb-2 flex items-center justify-between text-sm font-medium">
                            <span>Loan Amount</span>
                            <span class="text-primary">$50,000</span>
                        </label>
                        <input type="range" min="1000" max="500000" value="50000" class="w-full" />
                    </div>
                    <div>
                        <label class="mb-2 flex items-center justify-between text-sm font-medium">
                            <span>Interest Rate (%)</span>
                            <span class="text-primary">4.5%</span>
                        </label>
                        <input type="range" min="1" max="20" step="0.1" value="4.5" class="w-full" />
                    </div>
                    <div>
                        <label class="mb-2 flex items-center justify-between text-sm font-medium">
                            <span>Loan Term (years)</span>
                            <span class="text-primary">5 years</span>
                        </label>
                        <input type="range" min="1" max="30" value="5" class="w-full" />
                    </div>
                    <button class="btn-primary justify-center w-full">
                        <i class="las la-calculator"></i>
                        Calculate Payment
                    </button>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-xl bg-white p-4">
                            <p class="mb-1 text-xs text-n700">Monthly Payment</p>
                            <h5 class="h5 text-primary">$932.00</h5>
                        </div>
                        <div class="rounded-xl bg-white p-4">
                            <p class="mb-1 text-xs text-n700">Total Interest</p>
                            <h5 class="h5 text-[#FFC861]">$5,920</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Payments -->
            <div class="box col-span-12 bg-n0 lg:col-span-7">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 lg:mb-6 lg:pb-6">
                    <h4 class="h4">Upcoming Payments</h4>
                    <a href="#" class="text-sm font-semibold text-primary">View All</a>
                </div>
                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    <div class="group rounded-xl border-2 border-[#FFC861] bg-[#FFC861]/5 p-4 duration-300 hover:shadow-lg">
                        <div class="mb-3 flex items-center justify-between">
                            <div
                                class="flex size-10 items-center justify-center rounded-full bg-[#FFC861]/20 text-[#FFC861]">
                                <i class="las la-home text-xl"></i>
                            </div>
                            <span class="rounded-full bg-[#FFC861] px-2 py-1 text-xs font-medium text-white">Due in 4
                                days</span>
                        </div>
                        <p class="mb-1 text-sm font-medium text-n700">Home Mortgage</p>
                        <h5 class="h5 mb-2 text-[#FFC861]">$2,100.00</h5>
                        <p class="mb-3 text-xs text-n700">Due: Jan 15, 2026</p>
                        <button
                            class="w-full rounded-lg bg-[#FFC861] py-2 text-sm font-medium text-white duration-300 hover:bg-[#FFC861]/90">Pay
                            Now</button>
                    </div>
                    <div class="group rounded-xl border-2 border-primary bg-primary/5 p-4 duration-300 hover:shadow-lg">
                        <div class="mb-3 flex items-center justify-between">
                            <div class="flex size-10 items-center justify-center rounded-full bg-primary/20 text-primary">
                                <i class="las la-car text-xl"></i>
                            </div>
                            <span class="rounded-full bg-primary px-2 py-1 text-xs font-medium text-white">Paid</span>
                        </div>
                        <p class="mb-1 text-sm font-medium text-n700">Car Loan</p>
                        <h5 class="h5 mb-2 text-primary">$750.00</h5>
                        <p class="mb-3 text-xs text-n700">Paid: Jan 5, 2026</p>
                        <button
                            class="w-full rounded-lg border-2 border-primary bg-white py-2 text-sm font-medium text-primary"
                            disabled>Completed</button>
                    </div>
                    <div class="group rounded-xl border-2 border-primary bg-primary/5 p-4 duration-300 hover:shadow-lg">
                        <div class="mb-3 flex items-center justify-between">
                            <div class="flex size-10 items-center justify-center rounded-full bg-primary/20 text-primary">
                                <i class="las la-hand-holding-usd text-xl"></i>
                            </div>
                            <span class="rounded-full bg-primary px-2 py-1 text-xs font-medium text-white">Due in 9
                                days</span>
                        </div>
                        <p class="mb-1 text-sm font-medium text-n700">Personal Loan</p>
                        <h5 class="h5 mb-2 text-primary">$400.00</h5>
                        <p class="mb-3 text-xs text-n700">Due: Jan 20, 2026</p>
                        <button
                            class="w-full rounded-lg bg-primary py-2 text-sm font-medium text-white duration-300 hover:bg-primary/90">Schedule
                            Payment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection