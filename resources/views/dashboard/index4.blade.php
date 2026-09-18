@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div>
                <h4 class="h4 mb-1">33,215.00 USD</h4>
                <p>
                    Total Balance from all accounts
                    <span class="font-semibold text-primary">USD</span>
                </p>
            </div>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>
        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            <div class="col-span-12 lg:col-span-8">
                <!-- Statistics  -->
                <div class="grid grid-cols-2 gap-4 xxl:gap-6 mb-4 xxl:mb-6">
                    <div class="col-span-2 sm:col-span-1 box bg-n0 ">
                        <div class="flex justify-between items-center mb-4 lg:mb-6 pb-4 lg:pb-6 bb-dashed">
                            <span class="font-medium">Total Income</span>
                            @include('partials._horizontal-options')

                        </div>
                        <div class="flex items-center justify-between gap-4 xl:gap-6">
                            <div>
                                <h4 class="h4 mb-4">Total Spending</h4>
                                <span class="flex items-center gap-1 whitespace-nowrap text-primary">
                                    <i class="las la-arrow-up text-lg"></i> 45.2%
                                </span>
                            </div>
                            <div class="stat-chart-home4"></div>
                        </div>
                    </div>
                    <div class="col-span-2 sm:col-span-1 box bg-n0 ">
                        <div class="flex justify-between items-center mb-4 lg:mb-6 pb-4 lg:pb-6 bb-dashed">
                            <span class="font-medium">Total Spending</span>
                            @include('partials._horizontal-options')

                        </div>
                        <div class="flex items-center justify-between gap-4 xl:gap-6">
                            <div>
                                <h4 class="h4 mb-4">Total Spending</h4>
                                <span class="flex items-center gap-1 whitespace-nowrap text-primary">
                                    <i class="las la-arrow-up text-lg"></i> 45.2%
                                </span>
                            </div>
                            <div class="stat-chart-home4"></div>
                        </div>
                    </div>
                    <div class="col-span-2 sm:col-span-1 box bg-n0 ">
                        <div class="flex justify-between items-center mb-4 lg:mb-6 pb-4 lg:pb-6 bb-dashed">
                            <span class="font-medium">Spending Goal</span>
                            @include('partials._horizontal-options')

                        </div>
                        <div class="flex items-center justify-between gap-4 xl:gap-6">
                            <div>
                                <h4 class="h4 mb-4">Total Spending</h4>
                                <span class="flex items-center gap-1 whitespace-nowrap text-primary">
                                    <i class="las la-arrow-up text-lg"></i> 45.2%
                                </span>
                            </div>
                            <div class="stat-chart-home4"></div>
                        </div>
                    </div>
                    <div class="col-span-2 sm:col-span-1 box bg-n0 ">
                        <div class="flex justify-between items-center mb-4 lg:mb-6 pb-4 lg:pb-6 bb-dashed">
                            <span class="font-medium">Total Transactions</span>
                            @include('partials._horizontal-options')

                        </div>
                        <div class="flex items-center justify-between gap-4 xl:gap-6">
                            <div>
                                <h4 class="h4 mb-4">Total Spending</h4>
                                <span class="flex items-center gap-1 whitespace-nowrap text-primary">
                                    <i class="las la-arrow-up text-lg"></i> 45.2%
                                </span>
                            </div>
                            <div class="stat-chart-home4"></div>
                        </div>
                    </div>
                </div>

                <!-- Income and expense chart -->
                <div class="box overflow-x-hidden mb-4 xxl:mb-6">
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
                    <div class="income-expense-home4"></div>
                </div>

                <div class="box">
                    <div class="bb-dashed mb-4 flex flex-wrap items-center justify-between gap-4 pb-4 3xl:">
                        <h4 class="h4">Transaction Account</h4>
                        @include('partials._vertical-options')

                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="bg-secondary/5 ">
                                    <th class="min-w-[280px] cursor-pointer px-6 py-5 text-start">
                                        <div class="flex items-center gap-1">Title</div>
                                    </th>
                                    <th class="w-[20%] cursor-pointer px-6 py-5 text-start">
                                        <div class="flex items-center gap-1">Amount</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Transactions Data -->
                                <tr key="John Snow - Metal" class="even:bg-secondary/5 ">
                                    <td class="px-6 py-2">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/card-sm-1.png') }}" width="60" height="40"
                                                class="rounded" alt="payment medium icon" />
                                            <div>
                                                <p class="mb-1 font-medium">John Snow - Metal</p>
                                                <span class="text-xs">**4291 - Exp: 12/26</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-2">
                                        <div>
                                            <p class="font-medium">$95,200.00</p>
                                            <span class="text-xs">Account Balance</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr key="John Snow - Virtual" class="even:bg-secondary/5 ">
                                    <td class="px-6 py-2">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/card-sm-2.png') }}" width="60" height="40"
                                                class="rounded" alt="payment medium icon" />
                                            <div>
                                                <p class="mb-1 font-medium">John Snow - Virtual</p>
                                                <span class="text-xs">**4291 - Exp: 12/26</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-2">
                                        <div>
                                            <p class="font-medium">€54,448.54</p>
                                            <span class="text-xs">Account Balance</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr key="Ben Abramov - Metal" class="even:bg-secondary/5 ">
                                    <td class="px-6 py-2">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/card-sm-3.png') }}" width="60" height="40"
                                                class="rounded" alt="payment medium icon" />
                                            <div>
                                                <p class="mb-1 font-medium">Ben Abramov - Metal</p>
                                                <span class="text-xs">**4291 - Exp: 12/26</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-2">
                                        <div>
                                            <p class="font-medium">£74,215.32</p>
                                            <span class="text-xs">Account Balance</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr key="John Cina - Virtual" class="even:bg-secondary/5 ">
                                    <td class="px-6 py-2">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/card-sm-8.png') }}" width="60" height="40"
                                                class="rounded" alt="payment medium icon" />
                                            <div>
                                                <p class="mb-1 font-medium">John Cina - Virtual</p>
                                                <span class="text-xs">**4291 - Exp: 12/26</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-2">
                                        <div>
                                            <p class="font-medium">د.ك 67,511.21</p>
                                            <span class="text-xs">Account Balance</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr key="Kane Methew - Metal" class="even:bg-secondary/5 ">
                                    <td class="px-6 py-2">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/card-sm-4.png') }}" width="60" height="40"
                                                class="rounded" alt="payment medium icon" />
                                            <div>
                                                <p class="mb-1 font-medium">Kane Methew - Metal</p>
                                                <span class="text-xs">**4291 - Exp: 12/26</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-2">
                                        <div>
                                            <p class="font-medium">¥36,122,54</p>
                                            <span class="text-xs">Account Balance</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr key="Jane Alam - Virtual" class="even:bg-secondary/5 ">
                                    <td class="px-6 py-2">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/card-sm-5.png') }}" width="60" height="40"
                                                class="rounded" alt="payment medium icon" />
                                            <div>
                                                <p class="mb-1 font-medium">Jane Alam - Virtual</p>
                                                <span class="text-xs">**4291 - Exp: 12/26</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-2">
                                        <div>
                                            <p class="font-medium">₹75,121,36</p>
                                            <span class="text-xs">Account Balance</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr key="Jabed Miah - Metal" class="even:bg-secondary/5 ">
                                    <td class="px-6 py-2">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/card-sm-6.png') }}" width="60" height="40"
                                                class="rounded" alt="payment medium icon" />
                                            <div>
                                                <p class="mb-1 font-medium">Jabed Miah - Metal</p>
                                                <span class="text-xs">**4291 - Exp: 12/26</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-2">
                                        <div>
                                            <p class="font-medium">₽88,125.00</p>
                                            <span class="text-xs">Account Balance</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr key="Bablu Sheikh - Virtual" class="even:bg-secondary/5 ">
                                    <td class="px-6 py-2">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/card-sm-7.png') }}" width="60" height="40"
                                                class="rounded" alt="payment medium icon" />
                                            <div>
                                                <p class="mb-1 font-medium">Bablu Sheikh - Virtual</p>
                                                <span class="text-xs">**4291 - Exp: 12/26</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-2">
                                        <div>
                                            <p class="font-medium">¢96,214.03</p>
                                            <span class="text-xs">Account Balance</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <a class="group mt-6 inline-flex items-center gap-1 font-semibold text-primary" href="#">
                        See More
                        <i class="las la-arrow-right duration-300 group-hover:pl-2"></i>
                    </a>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-4">
                <!-- Weekly Transactions -->
                <div class="box mb-4 xxl:mb-6 overflow-x-hidden">
                    <div class="flex flex-wrap justify-between items-center gap-3 pb-4 lg:pb-6 mb-4 lg:mb-6 bb-dashed">
                        <p class="font-medium">Weekly Transactions</p>
                        @include('partials._vertical-options')

                    </div>
                    <div class="weekly-transactions"></div>
                </div>
                <!-- Quick Transfer -->
                <div class="box mb-4 xxl:mb-6">
                    <div class="bb-dashed pb-4 mb-4 3xl: flex justify-between items-center">
                        <p class="font-medium">Quick Transfer</p>
                        @include('partials._vertical-options')

                    </div>
                    <div class="bb-dashed pb-4 mb-4 3xl: flex flex-col">
                        <div class="box border border-n30  bg-primary/5  xl:p-3 xxl:p-4 spend order-1">
                            <div class="flex justify-between gap-3 bb-dashed items-center text-sm mb-4 pb-4">
                                <p>Spend</p>
                                <p>Balance : 10,000 USD</p>
                            </div>
                            <div class="flex justify-between items-center text-xl gap-4 font-medium">
                                <input type="number" class="w-20 bg-transparent p-0 border-none" placeholder="0.00" />
                                <p class="shrink-0">$ USD</p>
                            </div>
                        </div>
                        <button
                            class="p-2 border order-2 border-n30  self-center -my-4 relative z-2 rounded-lg bg-n0  text-primary changeOrderBtn">
                            <i class="las la-exchange-alt rotate-90"></i>
                        </button>
                        <div class="box border border-n30  bg-primary/5  xl:p-3 xxl:p-4 receive order-3">
                            <div class="flex justify-between gap-3 bb-dashed items-center text-sm mb-4 pb-4">
                                <p>Receive</p>
                                <p>Balance : 10,000 USD</p>
                            </div>
                            <div class="flex justify-between items-center text-xl gap-4 font-medium">
                                <input type="number" class="w-20 bg-transparent p-0 border-none" placeholder="0.00" />
                                <p class="shrink-0">€ EURO</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="text-lg font-medium mb-6">Payment Method</p>
                        <div
                            class="border border-primary border-dashed bg-primary/5 rounded-lg p-3 flex items-center gap-4 mb-6 lg:mb-8">
                            <img src="{{ asset('assets/images/card-sm-1.png') }}" width="60" height="40" alt="card" />
                            <div>
                                <p class="font-medium mb-1">John Snow - Metal</p>
                                <span class="text-xs">**4291 - Exp: 12/26</span>
                            </div>
                        </div>
                        <a href="#" class="btn-primary flex justify-center w-full">
                            Sent Now
                        </a>
                    </div>
                </div>
                <!-- Transactions -->
                <div class="box">
                    <div class="flex flex-wrap gap-4  justify-between items-center bb-dashed mb-4 pb-4 3xl:">
                        <p class="font-medium">Transaction</p>
                        @include('partials._vertical-options')

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