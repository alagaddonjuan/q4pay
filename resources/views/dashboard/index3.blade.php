@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            <!-- Statistics -->
            <div class="box col-span-12 bg-n0 p-4  sm:col-span-6 3xl:col-span-3 4xl:px-8 4xl:py-6">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 3xl:">
                    <span class="font-medium">Total Income</span>
                    @include('partials._horizontal-options')
                </div>
                <div class="flex items-center gap-4 xl:gap-6">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-xl border border-n30 bg-primary/5 text-primary  xl:h-[72px] xl:w-[72px]">
                        <i class="las la-chart-bar text-3xl xl:text-5xl"></i>
                    </div>
                    <div>
                        <h4 class="h4 mb-2 xxl:mb-4">$8500 USD</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-primary">
                            <i class="las la-arrow-up text-lg"></i> 50.8%
                        </span>
                    </div>
                </div>
            </div>
            <div class="box col-span-12 bg-n0 p-4  sm:col-span-6 3xl:col-span-3 4xl:px-8 4xl:py-6">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 3xl:">
                    <span class="font-medium">Total Spending</span>
                    @include('partials._horizontal-options')
                </div>
                <div class="flex items-center gap-4 xl:gap-6">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-xl border border-n30 bg-primary/5 text-primary  xl:h-[72px] xl:w-[72px]">
                        <i class="las la-coins text-3xl xl:text-5xl"></i>
                    </div>
                    <div>
                        <h4 class="h4 mb-2 xxl:mb-4">$3500 USD</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-secondary">
                            <i class="las la-arrow-up text-lg"></i> 50.8%
                        </span>
                    </div>
                </div>
            </div>
            <div class="box col-span-12 bg-n0 p-4  sm:col-span-6 3xl:col-span-3 4xl:px-8 4xl:py-6">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 3xl:">
                    <span class="font-medium">Spending Goal</span>
                    @include('partials._horizontal-options')
                </div>
                <div class="flex items-center gap-4 xl:gap-6">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-xl border border-n30 bg-primary/5 text-primary  xl:h-[72px] xl:w-[72px]">
                        <i class="las la-chart-pie text-3xl xl:text-5xl"></i>
                    </div>
                    <div>
                        <h4 class="h4 mb-2 xxl:mb-4">$8500 USD</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-error">
                            <i class="las la-arrow-up text-lg"></i> 50.8%
                        </span>
                    </div>
                </div>
            </div>
            <div class="box col-span-12 bg-n0 p-4  sm:col-span-6 3xl:col-span-3 4xl:px-8 4xl:py-6">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 3xl:">
                    <span class="font-medium">Total Transactions</span>
                    @include('partials._horizontal-options')
                </div>
                <div class="flex items-center gap-4 xl:gap-6">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-xl border border-n30 bg-primary/5 text-primary  xl:h-[72px] xl:w-[72px]">
                        <i class="las la-chart-line text-3xl xl:text-5xl"></i>
                    </div>
                    <div>
                        <h4 class="h4 mb-2 xxl:mb-4">$8500 USD</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-warning">
                            <i class="las la-arrow-up text-lg"></i> 50.8%
                        </span>
                    </div>
                </div>
            </div>

            <!-- Transactions -->
            <div class="col-span-12 lg:col-span-6 box overflow-x-hidden">
                <div class="flex flex-wrap justify-between items-center gap-3 pb-4 lg:pb-6 mb-4 lg:mb-6 bb-dashed">
                    <p class="font-medium">Transaction Overview</p>
                    <div class="flex items-center gap-2">
                        <p class="text-xs sm:text-sm md:text-base">Sort By : </p>
                        <select name="sort" class="nc-select green">
                            <option value="day">Last 15 Days</option>
                            <option value="week">Last 1 Month</option>
                            <option value="year">Last 6 Month</option>
                        </select>
                    </div>
                </div>
                <div class="transaction-overview-home3"></div>
            </div>

            <!-- Income expense chart -->
            <div class="col-span-12 lg:col-span-6 box overflow-x-hidden">
                <div class="flex flex-wrap justify-between items-center gap-3 pb-4 lg:pb-6 mb-4 lg:mb-6 bb-dashed">
                    <p class="font-medium">Income and Expenses</p>
                    <div class="flex items-center gap-2">
                        <p class="text-xs sm:text-sm md:text-base">Sort By : </p>
                        <select name="sort" class="nc-select green">
                            <option value="day">Last 15 Days</option>
                            <option value="week">Last 1 Month</option>
                            <option value="year">Last 6 Month</option>
                        </select>
                    </div>
                </div>
                <div class="income-chart-home3"></div>
            </div>

            <!-- Latest Transactions -->
            <div class="box col-span-12 lg:col-span-6">
                <div class="bb-dashed mb-4 flex flex-wrap items-center justify-between gap-4 pb-4 3xl:">
                    <h4 class="h4">Latest Transaction</h4>
                    @include('partials._horizontal-options')
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-secondary/5 ">
                                <th class="flex min-w-[300px] cursor-pointer items-center gap-1 px-6 py-5 text-start">
                                    Title
                                </th>
                                <th class="min-w-[120px] cursor-pointer px-6 py-5 text-start">
                                    <div class="flex items-center gap-1">Medium</div>
                                </th>
                                <th class="min-w-[120px] cursor-pointer px-6 py-5 text-start">
                                    <div class="flex items-center gap-1">Amount</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="even:bg-secondary/5 ">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">
                                                Bluth Company INV-84732
                                            </p>
                                            <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">Paypal</td>
                                <td class="px-6 py-2">$2,141,212</td>
                            </tr>
                            <tr class="even:bg-secondary/5 ">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">Salaries</p>
                                            <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">Paypal</td>
                                <td class="px-6 py-2">$2,521,212</td>
                            </tr>
                            <tr class="even:bg-secondary/5 ">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/visa.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">
                                                Massive Dynamic INV-90874
                                            </p>
                                            <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">Visa</td>
                                <td class="px-6 py-2">$554,100</td>
                            </tr>
                            <tr class="even:bg-secondary/5 ">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/payoneer.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">
                                                Jack Collingwood Card reload
                                            </p>
                                            <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">Payoneer</td>
                                <td class="px-6 py-2">$1,420,012</td>
                            </tr>
                            <tr class="even:bg-secondary/5 ">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/payoneer.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">
                                                DOGE Yearly Return Invest.
                                            </p>
                                            <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">Payoneer</td>
                                <td class="px-6 py-2">$782,332</td>
                            </tr>
                            <tr class="even:bg-secondary/5 ">
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="mb-1 font-medium">
                                                Globex Corporation INV-24398
                                            </p>
                                            <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-2">Paypal</td>
                                <td class="px-6 py-2">$8,521,212</td>
                            </tr>
                            <!-- Add more rows for the remaining data items -->
                        </tbody>
                    </table>
                </div>
                <a class="group mt-6 inline-flex items-center gap-1 font-semibold text-primary" href="#">
                    See More
                    <i class="las la-arrow-right duration-300 group-hover:pl-2"></i>
                </a>
            </div>

            <!-- Live users -->
            <div class="col-span-12 lg:col-span-6 box">
                <div class="flex items-center justify-between pb-6 bb-dashed">
                    <h4 class="h4">Live Users By Country</h4>
                    @include('partials._horizontal-options')
                </div>
                <div id="live-users" class="max-lg:py-5 max-md:max-h-[400px] max-sm:max-h-[300px]"></div>
            </div>
        </div>
    </div>
@endsection

@push('page-js')
    @vite('resources/js/page-cdn.js')
@endpush