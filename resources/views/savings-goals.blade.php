@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Savings Goals</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>
        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            <!-- Savings Overview -->
            <div class="box col-span-12 bg-n0 min-[650px]:col-span-6 xl:col-span-3">
                <div class="bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                    <span class="font-medium">Total Saved</span>
                </div>
                <div>
                    <h4 class="h4 mb-2">$42,500</h4>
                    <span class="flex items-center gap-1 text-sm text-primary"> <i class="las la-arrow-up text-lg"></i>
                        +$2,500 this month </span>
                </div>
            </div>

            <div class="box col-span-12 bg-n0 min-[650px]:col-span-6 xl:col-span-3">
                <div class="bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                    <span class="font-medium">Total Goals</span>
                </div>
                <div>
                    <h4 class="h4 mb-2">$75,000</h4>
                    <span class="flex items-center gap-1 text-sm text-n700">5 Active Goals</span>
                </div>
            </div>

            <div class="box col-span-12 bg-n0 min-[650px]:col-span-6 xl:col-span-3">
                <div class="bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                    <span class="font-medium">Progress</span>
                </div>
                <div>
                    <h4 class="h4 mb-2">57%</h4>
                    <span class="flex items-center gap-1 text-sm text-primary">Overall Completion</span>
                </div>
            </div>

            <div class="box col-span-12 bg-n0 min-[650px]:col-span-6 xl:col-span-3">
                <div class="bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                    <span class="font-medium">Monthly Contribution</span>
                </div>
                <div>
                    <h4 class="h4 mb-2">$2,500</h4>
                    <span class="flex items-center gap-1 text-sm text-primary">On Track</span>
                </div>
            </div>

            <!-- Active Goals -->
            <div class="box col-span-12 lg:col-span-8">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 lg:mb-6 lg:pb-6">
                    <h4 class="h4">Active Savings Goals</h4>
                    @include('partials._horizontal-options')
                </div>
                <div class="space-y-4">
                    <!-- Goal 1 -->
                    <div class="rounded-xl border border-n30 p-4">
                        <div class="mb-4 flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex size-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                                    <i class="las la-home text-2xl"></i>
                                </div>
                                <div>
                                    <p class="mb-1 font-medium">Dream House Down Payment</p>
                                    <span class="text-sm text-n700">Target: Dec 2026</span>
                                </div>
                            </div>
                            <button class="text-n700 hover:text-primary">
                                <i class="las la-ellipsis-v text-xl"></i>
                            </button>
                        </div>
                        <div class="mb-3 flex items-center justify-between">
                            <span class="text-sm font-medium text-n700">$25,000 of $50,000</span>
                            <span class="font-semibold text-primary">50%</span>
                        </div>
                        <div class="mb-3 h-2 w-full overflow-hidden rounded-full bg-n30">
                            <div class="h-full bg-primary" style="width: 50%"></div>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-n700">Monthly: $1,200</span>
                            <span class="font-medium text-primary">12 months left</span>
                        </div>
                    </div>

                    <!-- Goal 2 -->
                    <div class="rounded-xl border border-n30 p-4">
                        <div class="mb-4 flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex size-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                                    <i class="las la-plane text-2xl"></i>
                                </div>
                                <div>
                                    <p class="mb-1 font-medium">Europe Vacation</p>
                                    <span class="text-sm text-n700">Target: Jun 2026</span>
                                </div>
                            </div>
                            <button class="text-n700 hover:text-primary">
                                <i class="las la-ellipsis-v text-xl"></i>
                            </button>
                        </div>
                        <div class="mb-3 flex items-center justify-between">
                            <span class="text-sm font-medium text-n700">$6,800 of $8,000</span>
                            <span class="font-semibold text-primary">85%</span>
                        </div>
                        <div class="mb-3 h-2 w-full overflow-hidden rounded-full bg-n30">
                            <div class="h-full bg-primary" style="width: 85%"></div>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-n700">Monthly: $400</span>
                            <span class="font-medium text-primary">3 months left</span>
                        </div>
                    </div>

                    <!-- Goal 3 -->
                    <div class="rounded-xl border border-n30 p-4">
                        <div class="mb-4 flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex size-12 items-center justify-center rounded-full bg-[#FFC861]/10 text-[#FFC861]">
                                    <i class="las la-car text-2xl"></i>
                                </div>
                                <div>
                                    <p class="mb-1 font-medium">New Car</p>
                                    <span class="text-sm text-n700">Target: Mar 2027</span>
                                </div>
                            </div>
                            <button class="text-n700 hover:text-primary">
                                <i class="las la-ellipsis-v text-xl"></i>
                            </button>
                        </div>
                        <div class="mb-3 flex items-center justify-between">
                            <span class="text-sm font-medium text-n700">$8,200 of $25,000</span>
                            <span class="font-semibold text-[#FFC861]">33%</span>
                        </div>
                        <div class="mb-3 h-2 w-full overflow-hidden rounded-full bg-n30">
                            <div class="h-full bg-[#FFC861]" style="width: 33%"></div>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-n700">Monthly: $600</span>
                            <span class="font-medium text-[#FFC861]">28 months left</span>
                        </div>
                    </div>

                    <!-- Goal 4 -->
                    <div class="rounded-xl border border-n30 p-4">
                        <div class="mb-4 flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex size-12 items-center justify-center rounded-full bg-[#4371E9]/10 text-[#4371E9]">
                                    <i class="las la-graduation-cap text-2xl"></i>
                                </div>
                                <div>
                                    <p class="mb-1 font-medium">Education Fund</p>
                                    <span class="text-sm text-n700">Target: Sep 2026</span>
                                </div>
                            </div>
                            <button class="text-n700 hover:text-primary">
                                <i class="las la-ellipsis-v text-xl"></i>
                            </button>
                        </div>
                        <div class="mb-3 flex items-center justify-between">
                            <span class="text-sm font-medium text-n700">$2,500 of $10,000</span>
                            <span class="font-semibold text-[#4371E9]">25%</span>
                        </div>
                        <div class="mb-3 h-2 w-full overflow-hidden rounded-full bg-n30">
                            <div class="h-full bg-[#4371E9]" style="width: 25%"></div>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-n700">Monthly: $300</span>
                            <span class="font-medium text-[#4371E9]">8 months left</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Savings Tips & Insights -->
            <div class="box col-span-12 bg-n0 lg:col-span-4">
                <div class="bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                    <h4 class="h4">Savings Insights</h4>
                </div>
                <div class="space-y-4">
                    <div class="rounded-xl bg-primary/5 p-4">
                        <div class="mb-2 flex items-center gap-2">
                            <i class="las la-check-circle text-xl text-primary"></i>
                            <span class="font-medium">Great Progress!</span>
                        </div>
                        <p class="text-sm text-n700">You're ahead of schedule on your Europe Vacation goal. Keep it up!</p>
                    </div>

                    <div class="rounded-xl bg-[#FFC861]/5 p-4">
                        <div class="mb-2 flex items-center gap-2">
                            <i class="las la-lightbulb text-xl text-[#FFC861]"></i>
                            <span class="font-medium">Tip</span>
                        </div>
                        <p class="text-sm text-n700">Consider increasing your monthly contribution by $200 to reach your car
                            goal faster.</p>
                    </div>

                    <div class="rounded-xl bg-primary/5 p-4">
                        <div class="mb-2 flex items-center gap-2">
                            <i class="las la-chart-line text-xl text-primary"></i>
                            <span class="font-medium">Projection</span>
                        </div>
                        <p class="text-sm text-n700">At your current rate, you'll reach all goals by Q4 2027.</p>
                    </div>

                    <div class="rounded-xl border border-n30 p-4">
                        <p class="mb-2 text-sm font-medium text-n700">Highest Priority</p>
                        <div class="flex items-center justify-between">
                            <span class="font-semibold">Europe Vacation</span>
                            <span class="text-primary">85%</span>
                        </div>
                    </div>

                    <div class="rounded-xl border border-n30 p-4">
                        <p class="mb-2 text-sm font-medium text-n700">Total Saved This Year</p>
                        <div class="flex items-center justify-between">
                            <span class="font-semibold">2026</span>
                            <span class="text-primary">$12,500</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contribution History -->
            <div class="box col-span-12">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 lg:mb-6 lg:pb-6">
                    <h4 class="h4">Recent Contributions</h4>
                    <a href="#" class="text-sm font-semibold text-primary">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-secondary/5">
                                <th class="px-6 py-5 text-start">Goal</th>
                                <th class="px-6 py-5 text-start">Amount</th>
                                <th class="px-6 py-5 text-start">Date</th>
                                <th class="px-6 py-5 text-start">Type</th>
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
                                        <span class="font-medium">Dream House Down Payment</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3 font-semibold text-primary">$1,200</td>
                                <td class="px-6 py-3">Jan 10, 2026</td>
                                <td class="px-6 py-3">
                                    <span
                                        class="rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">Auto</span>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex size-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                                            <i class="las la-plane"></i>
                                        </div>
                                        <span class="font-medium">Europe Vacation</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3 font-semibold text-primary">$400</td>
                                <td class="px-6 py-3">Jan 10, 2026</td>
                                <td class="px-6 py-3">
                                    <span
                                        class="rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">Auto</span>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex size-10 items-center justify-center rounded-full bg-[#FFC861]/10 text-[#FFC861]">
                                            <i class="las la-car"></i>
                                        </div>
                                        <span class="font-medium">New Car</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3 font-semibold text-[#FFC861]">$600</td>
                                <td class="px-6 py-3">Jan 10, 2026</td>
                                <td class="px-6 py-3">
                                    <span
                                        class="rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">Auto</span>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex size-10 items-center justify-center rounded-full bg-primary/10 text-primary">
                                            <i class="las la-plane"></i>
                                        </div>
                                        <span class="font-medium">Europe Vacation</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3 font-semibold text-primary">$500</td>
                                <td class="px-6 py-3">Jan 5, 2026</td>
                                <td class="px-6 py-3">
                                    <span
                                        class="rounded-full bg-primary/10 px-3 py-1 text-xs font-medium text-primary">Manual</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection