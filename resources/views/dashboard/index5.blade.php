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
            <!-- Statistics -->
            <div class="col-span-12 min-[680px]:col-span-6 xxl:col-span-4 box p-4 3xl:p-6 4xl:p-8 bg-n0 ">
                <div class="flex justify-between items-center mb-4 lg:mb-6 pb-4 lg:pb-6 bb-dashed">
                    <span class="font-medium">Total Income</span>
                    @include('partials._horizontal-options')

                </div>
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="h4 mb-4">$99.99 USD</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-primary">
                            <i class="las la-arrow-up text-lg"></i> 35.7%
                        </span>
                    </div>
                    <div class="shrink-0">
                        <div class="stat-chart-home5"></div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 min-[680px]:col-span-6 xxl:col-span-4 box p-4 3xl:p-6 4xl:p-8 bg-n0 ">
                <div class="flex justify-between items-center mb-4 lg:mb-6 pb-4 lg:pb-6 bb-dashed">
                    <span class="font-medium">Total Spending</span>
                    @include('partials._horizontal-options')

                </div>
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="h4 mb-4">$99.99 USD</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-secondary">
                            <i class="las la-arrow-up text-lg"></i> 35.7%
                        </span>
                    </div>
                    <div class="shrink-0">
                        <div class="stat-chart-home5"></div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 min-[680px]:col-span-6 xxl:col-span-4 box p-4 3xl:p-6 4xl:p-8 bg-n0 ">
                <div class="flex justify-between items-center mb-4 lg:mb-6 pb-4 lg:pb-6 bb-dashed">
                    <span class="font-medium">Spending Goal</span>
                    @include('partials._horizontal-options')

                </div>
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="h4 mb-4">$99.99 USD</h4>
                        <span class="flex items-center gap-1 whitespace-nowrap text-warning">
                            <i class="las la-arrow-up text-lg"></i> 35.7%
                        </span>
                    </div>
                    <div class="shrink-0">
                        <div class="stat-chart-home5"></div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-8">
                <!-- Balance overview chart -->
                <div class="col-span-12 lg:col-span-6 box overflow-x-hidden mb-4 xxl:mb-6">
                    <div class="flex flex-wrap justify-between items-center gap-3 pb-4 lg:pb-6 mb-4 lg:mb-6 bb-dashed">
                        <h4 class="h4">Balance Overview</h4>
                        <div class="flex items-center gap-2">
                            <p class="text-xs sm:text-sm md:text-base">Sort By : </p>
                            <select name="sort" class="nc-select green">
                                <option value="day">Last 15 Days</option>
                                <option value="week">Last 1 Month</option>
                                <option value="year">Last 6 Month</option>
                            </select>
                        </div>
                    </div>
                    <div class="balance-chart-home5"></div>
                </div>
                <!-- Browser Sessions -->
                <div class="box col-span-12 lg:col-span-6">
                    <div class="flex flex-wrap justify-between items-center gap-3 pb-4 lg:pb-6 mb-4 lg:mb-6 bb-dashed">
                        <h4 class="h4">Sessions by Browser</h4>
                        <div class="flex items-center gap-2">
                            <p class="text-xs sm:text-sm md:text-base">Sort By : </p>
                            <select name="sort" class="nc-select green">
                                <option value="day">Last 15 Days</option>
                                <option value="week">Last 1 Month</option>
                                <option value="year">Last 6 Month</option>
                            </select>
                        </div>
                    </div>
                    <div class="overflow-x-hidden flex justify-center flex-col sm:flex-row items-center gap-3 ">
                        <div class="grow">
                            <div class="browser-session"></div>
                        </div>
                        <div class="flex w-[25%] shrink-0 sm:flex-col max-sm:w-full flex-wrap justify-center gap-5">
                            <div class="flex items-center gap-2">
                                <img width="24" height="24" src="{{ asset('assets/images/chrome.png') }}"
                                    alt="browser icon" />
                                <p>36.87%</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <img width="24" height="24" src="{{ asset('assets/images/firefox.png') }}"
                                    alt="browser icon" />
                                <p>9.87%</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <img width="24" height="24" src="{{ asset('assets/images/edge.png') }}"
                                    alt="browser icon" />
                                <p>3.87%</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <img width="24" height="24" src="{{ asset('assets/images/opera.png') }}"
                                    alt="browser icon" />
                                <p>45.87%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-4">
                <!-- Latest Transactions -->
                <div class="box">
                    <div class="flex flex-wrap gap-4  justify-between items-center bb-dashed mb-4 pb-4 3xl:">
                        <h4 class="h4">Latest Transactions</h4>
                        @include('partials._horizontal-options')

                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="bg-secondary/5 ">
                                    <th class="text-start py-5 px-6 cursor-pointer min-w-[220px]">
                                        <div class="flex items-center gap-1">
                                            Title
                                        </div>
                                    </th>
                                    <th class="text-start py-5 cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Amount
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="even:bg-secondary/5 ">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">Bluth Company</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 pr-6">2141212.00</td>
                                </tr>
                                <tr class="even:bg-secondary/5 ">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">Bluth Company</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 pr-6">2141212.00</td>
                                </tr>
                                <tr class="even:bg-secondary/5 ">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">Bluth Company</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 pr-6">2141212.00</td>
                                </tr>
                                <tr class="even:bg-secondary/5 ">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">Bluth Company</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 pr-6">2141212.00</td>
                                </tr>
                                <tr class="even:bg-secondary/5 ">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">Bluth Company</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 pr-6">2141212.00</td>
                                </tr>
                                <tr class="even:bg-secondary/5 ">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">Bluth Company</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 pr-6">2141212.00</td>
                                </tr>
                                <tr class="even:bg-secondary/5 ">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/payoneer.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">Bluth Company</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 pr-6">2141212.00</td>
                                </tr>
                                <tr class="even:bg-secondary/5 ">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">Bluth Company</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 pr-6">2141212.00</td>
                                </tr>
                                <tr class="even:bg-secondary/5 ">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/payoneer.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">Bluth Company</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 pr-6">2141212.00</td>
                                </tr>
                                <tr class="even:bg-secondary/5 ">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">Bluth Company</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 pr-6">2141212.00</td>
                                </tr>
                                <tr class="even:bg-secondary/5 ">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/visa.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">Bluth Company</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2 pr-6">2141212.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a class="text-primary font-semibold inline-flex gap-1 items-center mt-6 group" href="#">
                        See More
                        <i class="las la-arrow-right group-hover:pl-2 duration-300"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection