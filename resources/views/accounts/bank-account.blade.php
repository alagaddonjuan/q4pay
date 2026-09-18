@extends('layout.main')

@push('page-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap/dist/css/jsvectormap.min.css" />
@endpush

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Bank Account</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="grid grid-cols-1 gap-4 xxl:gap-6">
            <!-- Payment account -->
            <div class="box col-span-12 lg:col-span-6">
                <div class="flex justify-between items-center gap-4 flex-wrap bb-dashed mb-4 pb-4 3xl:">
                    <h4 class="h4">Payment Account</h4>
                    <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                        <button class="btn-primary shrink-0 add-account-btn">
                            Add Account
                        </button>
                        <form
                            class="bg-primary/5 datatable-search  border border-n30  flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                            <input type="text" placeholder="Search"
                                class="bg-transparent text-sm ltr:pl-4 rtl:pr-4 py-1 w-full border-none"
                                id="payment-account-search" />
                            <button
                                class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                                <i class="las la-search text-lg"></i>
                            </button>
                        </form>
                        <div class="flex items-center gap-3 whitespace-nowrap">
                            <span>Sort By : </span>
                            <select name="sort" class="nc-select green">
                                <option value="day">Last 15 Days</option>
                                <option value="week">Last 1 Month</option>
                                <option value="year">Last 6 Month</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto pb-4 lg:pb-6">
                    <table class="w-full whitespace-nowrap" id="payment-account">
                        <thead>
                            <tr class="bg-secondary/5 ">
                                <th class="text-start py-5 px-6 min-w-[230px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Account Number
                                    </div>
                                </th>
                                <th class="text-start py-5 min-w-[130px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Currency
                                    </div>
                                </th>
                                <th class="text-start py-5 min-w-[200px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Bank Name
                                    </div>
                                </th>
                                <th class="text-start py-5 min-w-[160px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Account Balance
                                    </div>
                                </th>
                                <th class="text-start py-5 min-w-[140px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Expiry Date
                                    </div>
                                </th>
                                <th class="text-start py-5 min-w-[130px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Status
                                    </div>
                                </th>
                                <th class="text-center py-5" data-sortable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="even:bg-secondary/5 ">
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="font-medium mb-1">999 *** *** 123</p>
                                            <span class="text-xs">Account Number</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">USD</p>
                                        <span class="text-xs">US Dollar</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">Bank Of America</p>
                                        <span class="text-xs">US</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">
                                            $1.121,212
                                        </p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td>11/05/2027</td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                        Successful
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5 ">
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/cn-sm.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="font-medium mb-1">999 *** *** 123</p>
                                            <span class="text-xs">Account Number</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">RUB</p>
                                        <span class="text-xs">Russian Rubble</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">VTB Bank</p>
                                        <span class="text-xs">RS</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">
                                            $1.121,212
                                        </p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td>11/05/2027</td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                        Cancelled
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5 ">
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="font-medium mb-1">999 *** *** 123</p>
                                            <span class="text-xs">Account Number</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">USD</p>
                                        <span class="text-xs">US Dollar</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">Bank Of America</p>
                                        <span class="text-xs">US</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">
                                            $1.121,212
                                        </p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td>11/05/2027</td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                        Successful
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5 ">
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="font-medium mb-1">999 *** *** 123</p>
                                            <span class="text-xs">Account Number</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">USD</p>
                                        <span class="text-xs">US Dollar</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">Bank Of America</p>
                                        <span class="text-xs">US</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">
                                            $1.121,212
                                        </p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td>11/05/2027</td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                        Successful
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5 ">
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/euro-sm.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="font-medium mb-1">919 *** *** 123</p>
                                            <span class="text-xs">Account Number</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">EUR</p>
                                        <span class="text-xs">EURo</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">UniCredit</p>
                                        <span class="text-xs">Italy</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">
                                            $1.821,222
                                        </p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td>11/05/2028</td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                        Cancelled
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5 ">
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="font-medium mb-1">999 *** *** 123</p>
                                            <span class="text-xs">Account Number</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">USD</p>
                                        <span class="text-xs">US Dollar</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">Bank Of America</p>
                                        <span class="text-xs">US</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">
                                            $1.121,212
                                        </p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td>11/05/2027</td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                        Cancelled
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5 ">
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/jp-sm.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="font-medium mb-1">999 *** *** 123</p>
                                            <span class="text-xs">Account Number</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">JPY</p>
                                        <span class="text-xs">Japanese Yen</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">Shinsei Bank</p>
                                        <span class="text-xs">Japan</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">
                                            $1.121,212
                                        </p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td>11/05/2027</td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                        Cancelled
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="even:bg-secondary/5 ">
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/uk-sm.png') }}" width="32" height="32"
                                            class="rounded-full" alt="payment medium icon" />
                                        <div>
                                            <p class="font-medium mb-1">988 *** *** 123</p>
                                            <span class="text-xs">Account Number</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">GBP</p>
                                        <span class="text-xs">British Pound</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">Barclys Bank</p>
                                        <span class="text-xs">UK</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">
                                            $1.121,212
                                        </p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td>11/05/2027</td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                        Cancelled
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex col-span-12 gap-4 sm:justify-between justify-center items-center flex-wrap">
                    <p>
                        Showing 1 to 8 of 18 entries
                    </p>

                    <ul class="flex gap-2 md:gap-3 flex-wrap md:font-semibold items-center">
                        <li>
                            <button
                                class="hover:bg-primary text-primary rtl:rotate-180 hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                <i class="las la-angle-left text-lg"></i>
                            </button>
                        </li>
                        <li>
                            <button
                                class="hover:bg-primary text-white bg-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                1
                            </button>
                        </li>
                        <li>
                            <button
                                class="hover:bg-primary text-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                2
                            </button>
                        </li>
                        <li>
                            <button
                                class="hover:bg-primary text-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                3
                            </button>
                        </li>
                        <li>
                            <button
                                class="hover:bg-primary text-primary hover:text-n0 rtl:rotate-180 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                <i class="las la-angle-right text-lg"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Total Deposits -->
            <div class="box col-span-12 lg:col-span-6">
                <div class="flex flex-wrap gap-4  justify-between items-center bb-dashed mb-4 pb-4 3xl:">
                    <h4 class="h4">Total Deposits</h4>
                    <div class="flex grow sm:justify-end items-center flex-wrap gap-4">
                        <button class="btn-primary shrink-0 total-deposit-btn">
                            Add Deposit
                        </button>
                        <form
                            class="bg-primary/5 datatable-search  border border-n30  flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                            <input type="text" placeholder="Search"
                                class="bg-transparent text-sm ltr:pl-4 rtl:pr-4 py-1 w-full border-none"
                                id="deposit-search" />
                            <button
                                class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                                <i class="las la-search text-lg"></i>
                            </button>
                        </form>
                        <div class="flex items-center gap-3 whitespace-nowrap">
                            <span>Sort By : </span>
                            <select name="sort" class="nc-select green">
                                <option value="day">Last 15 Days</option>
                                <option value="week">Last 1 Month</option>
                                <option value="year">Last 6 Month</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto pb-4 lg:pb-6">
                    <table class="w-full whitespace-nowrap" id="deposit-table">
                        <thead>
                            <tr class="bg-secondary/5 ">
                                <th class="text-start py-5 px-6 min-w-[230px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Title
                                    </div>
                                </th>
                                <th class="text-start py-5 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Rate
                                    </div>
                                </th>
                                <th class="text-start py-5 min-w-[200px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Account Balance
                                    </div>
                                </th>
                                <th class="text-start py-5 min-w-[200px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Account Interest
                                    </div>
                                </th>
                                <th class="text-start py-5 min-w-[130px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Expiry Date
                                    </div>
                                </th>
                                <th class="text-start py-5 cursor-pointer min-w-[100px]">
                                    <div class="flex items-center gap-1">
                                        Status
                                    </div>
                                </th>
                                <th class="text-center py-5 " data-sortable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover:bg-primary/5  border-b border-n30  first:border-t">
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <i class="las la-wallet text-primary"></i>
                                        <span class="font-medium">Fixed Deposit</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">14%</p>
                                        <span class="text-xs">Rate</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">$52,584,854</p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">$254.21</p>
                                        <span class="text-xs">Account Interest</span>
                                    </div>
                                </td>
                                <td>11/12/2028</td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                        Successful
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-primary/5  border-b border-n30  first:border-t">
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <i class="las la-wallet text-primary"></i>
                                        <span class="font-medium">Savings Deposit</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">14%</p>
                                        <span class="text-xs">Rate</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">$52,584,854</p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">$254.21</p>
                                        <span class="text-xs">Account Interest</span>
                                    </div>
                                </td>
                                <td>11/12/2028</td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-warning/10  text-warning">
                                        Pending
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-primary/5  border-b border-n30  first:border-t">
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <i class="las la-wallet text-primary"></i>
                                        <span class="font-medium">Fixed Deposit</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">14%</p>
                                        <span class="text-xs">Rate</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">$52,584,854</p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">$254.21</p>
                                        <span class="text-xs">Account Interest</span>
                                    </div>
                                </td>
                                <td>11/12/2028</td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-warning/10  text-warning">
                                        Pending
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-primary/5  border-b border-n30  first:border-t">
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <i class="las la-wallet text-primary"></i>
                                        <span class="font-medium">Savings Deposit</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">14%</p>
                                        <span class="text-xs">Rate</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">$52,584,854</p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <div>
                                        <p class="font-medium">$254.21</p>
                                        <span class="text-xs">Account Interest</span>
                                    </div>
                                </td>
                                <td>11/12/2028</td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                        Cancelled
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex col-span-12 gap-4 sm:justify-between justify-center items-center flex-wrap">
                    <p>
                        Showing 1 to 4 of 18 entries
                    </p>

                    <ul class="flex gap-2 md:gap-3 flex-wrap md:font-semibold items-center">
                        <li>
                            <button
                                class="hover:bg-primary text-primary rtl:rotate-180 hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                <i class="las la-angle-left text-lg"></i>
                            </button>
                        </li>
                        <li>
                            <button
                                class="hover:bg-primary text-white bg-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                1
                            </button>
                        </li>
                        <li>
                            <button
                                class="hover:bg-primary text-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                2
                            </button>
                        </li>
                        <li>
                            <button
                                class="hover:bg-primary text-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                3
                            </button>
                        </li>
                        <li>
                            <button
                                class="hover:bg-primary text-primary hover:text-n0 rtl:rotate-180 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                <i class="las la-angle-right text-lg"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Your Credits -->
            <div class="box col-span-12 lg:col-span-6">
                <div class="flex flex-wrap gap-4  justify-between items-center bb-dashed mb-4 pb-4 3xl:">
                    <h4 class="h4">Your Credits</h4>
                    <div class="flex flex-wrap items-center gap-4 grow sm:justify-end">
                        <form
                            class="bg-primary/5 datatable-search  border border-n30  flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                            <input type="text" placeholder="Search"
                                class="bg-transparent text-sm ltr:pl-4 rtl:pr-4 py-1 w-full border-none"
                                id="credit-search" />
                            <button
                                class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                                <i class="las la-search text-lg"></i>
                            </button>
                        </form>
                        <div class="flex items-center gap-3 whitespace-nowrap">
                            <span>Sort By : </span>
                            <select name="sort" class="nc-select green">
                                <option value="day">Last 15 Days</option>
                                <option value="week">Last 1 Month</option>
                                <option value="year">Last 6 Month</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto pb-4 lg:pb-6">
                    <table class="w-full whitespace-nowrap select-all-table" id="transactionTable">
                        <thead>
                            <tr class="bg-secondary/5 ">
                                <th class="text-start w-16 px-6 py-5" data-sortable="false">
                                    <input name="select-all" type="checkbox" id="selectAllCheckbox"
                                        class="accent-secondary focus:border-none focus:shadow-none focus:outline-none" />
                                </th>
                                <th class="text-start py-5 px-6 cursor-pointer min-w-[330px]">
                                    <div class="flex items-center gap-1">
                                        Title
                                    </div>
                                </th>
                                <th class="text-start py-5 min-w-[80px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Rate
                                    </div>
                                </th>
                                <th class="text-start py-5 min-w-[200px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Account Balance
                                    </div>
                                </th>
                                <th class="text-start py-5 min-w-[200px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Account Interest
                                    </div>
                                </th>
                                <th class="text-start py-5 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        Status
                                    </div>
                                </th>
                                <th class="text-center py-5" data-sortable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-t border-n30 ">
                                <td class="text-start px-6">
                                    <input type="checkbox" class="accent-bg3" />
                                </td>
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/card-sm-4.png') }}" width="60" height="40"
                                            class="rounded-sm" alt="payment medium icon" />
                                        <div>
                                            <p class="font-medium mb-1">Daniel Trate - Metal</p>
                                            <span class="text-xs">**4291 - Exp: 12/26</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">19%</p>
                                        <span class="text-xs">Rate</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">
                                            $234,234,232
                                        </p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">
                                            $4,231
                                        </p>
                                        <span class="text-xs">Account Interest</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                        Successful
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-n30 ">
                                <td class="text-start px-6">
                                    <input type="checkbox" class="accent-bg3" />
                                </td>
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/card-sm-1.png') }}" width="60" height="40"
                                            class="rounded-sm" alt="payment medium icon" />
                                        <div>
                                            <p class="font-medium mb-1">Babul Beg - Metal</p>
                                            <span class="text-xs">**4291 - Exp: 12/26</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">19%</p>
                                        <span class="text-xs">Rate</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">
                                            $234,234,232
                                        </p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">
                                            $4,231
                                        </p>
                                        <span class="text-xs">Account Interest</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                        Successful
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-n30 ">
                                <td class="text-start px-6">
                                    <input type="checkbox" class="accent-bg3" />
                                </td>
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/card-sm-2.png') }}" width="60" height="40"
                                            class="rounded-sm" alt="payment medium icon" />
                                        <div>
                                            <p class="font-medium mb-1">Daniel Trate - Metal</p>
                                            <span class="text-xs">**4291 - Exp: 12/26</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">14%</p>
                                        <span class="text-xs">Rate</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">
                                            $234,234,232
                                        </p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">
                                            $4,231
                                        </p>
                                        <span class="text-xs">Account Interest</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-warning/10  text-warning">
                                        Pending
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-n30 ">
                                <td class="text-start px-6">
                                    <input type="checkbox" class="accent-bg3" />
                                </td>
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/card-sm-4.png') }}" width="60" height="40"
                                            class="rounded-sm" alt="payment medium icon" />
                                        <div>
                                            <p class="font-medium mb-1">Daniel Trate - Metal</p>
                                            <span class="text-xs">**4291 - Exp: 12/26</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">12%</p>
                                        <span class="text-xs">Rate</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">
                                            $234,234,232
                                        </p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">
                                            $4,231
                                        </p>
                                        <span class="text-xs">Account Interest</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-warning/10  text-warning">
                                        Pending
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-n30 ">
                                <td class="text-start px-6">
                                    <input type="checkbox" class="accent-bg3" />
                                </td>
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/card-sm-5.png') }}" width="60" height="40"
                                            class="rounded-sm" alt="payment medium icon" />
                                        <div>
                                            <p class="font-medium mb-1">Daniel Trate - Metal</p>
                                            <span class="text-xs">**4291 - Exp: 12/26</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">39%</p>
                                        <span class="text-xs">Rate</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">
                                            $234,234,232
                                        </p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">
                                            $4,231
                                        </p>
                                        <span class="text-xs">Account Interest</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                        Cancelled
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-n30 ">
                                <td class="text-start px-6">
                                    <input type="checkbox" class="accent-bg3" />
                                </td>
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/card-sm-6.png') }}" width="60" height="40"
                                            class="rounded-sm" alt="payment medium icon" />
                                        <div>
                                            <p class="font-medium mb-1">Daniel Trate - Metal</p>
                                            <span class="text-xs">**4291 - Exp: 12/26</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">24%</p>
                                        <span class="text-xs">Rate</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">
                                            $234,234,232
                                        </p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">
                                            $4,231
                                        </p>
                                        <span class="text-xs">Account Interest</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                        Successful
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-n30 ">
                                <td class="text-start px-6">
                                    <input type="checkbox" class="accent-bg3" />
                                </td>
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/card-sm-8.png') }}" width="60" height="40"
                                            class="rounded-sm" alt="payment medium icon" />
                                        <div>
                                            <p class="font-medium mb-1">Daniel Trate - Metal</p>
                                            <span class="text-xs">**4291 - Exp: 12/26</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">49%</p>
                                        <span class="text-xs">Rate</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">
                                            $234,234,232
                                        </p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">
                                            $4,231
                                        </p>
                                        <span class="text-xs">Account Interest</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                        Cancelled
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b border-n30 ">
                                <td class="text-start px-6">
                                    <input type="checkbox" class="accent-bg3" />
                                </td>
                                <td class="py-2 px-6">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('assets/images/card-sm-7.png') }}" width="60" height="40"
                                            class="rounded-sm" alt="payment medium icon" />
                                        <div>
                                            <p class="font-medium mb-1">Daniel Trate - Metal</p>
                                            <span class="text-xs">**4291 - Exp: 12/26</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">19%</p>
                                        <span class="text-xs">Rate</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">
                                            $234,234,232
                                        </p>
                                        <span class="text-xs">Account Balance</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium mb-1">
                                            $4,231
                                        </p>
                                        <span class="text-xs">Account Interest</span>
                                    </div>
                                </td>
                                <td class="py-2">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                        Successful
                                    </span>
                                </td>
                                <td class="py-2">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options')

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex col-span-12 gap-4 sm:justify-between justify-center items-center flex-wrap">
                    <p>
                        Showing 1 to 8 of 18 entries
                    </p>

                    <ul class="flex gap-2 md:gap-3 flex-wrap md:font-semibold items-center">
                        <li>
                            <button
                                class="hover:bg-primary text-primary rtl:rotate-180 hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                <i class="las la-angle-left text-lg"></i>
                            </button>
                        </li>
                        <li>
                            <button
                                class="hover:bg-primary text-white bg-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                1
                            </button>
                        </li>
                        <li>
                            <button
                                class="hover:bg-primary text-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                2
                            </button>
                        </li>
                        <li>
                            <button
                                class="hover:bg-primary text-primary hover:text-n0 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                3
                            </button>
                        </li>
                        <li>
                            <button
                                class="hover:bg-primary text-primary hover:text-n0 rtl:rotate-180 border md:w-10 duration-300 md:h-10 w-8 h-8 flex items-center rounded-full justify-center border-primary">
                                <i class="las la-angle-right text-lg"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-modal')
    <div class="modal-two-overlay fixed inset-0 z-99 modalhide overflow-y-auto bg-n900/80 duration-500">
        <div class="overflow-y-auto">
            <div
                class="modal box modal-inner absolute left-1/2 my-10 max-h-[90vh] w-[95%] max-w-[710px] -translate-x-1/2 overflow-y-auto duration-300 xl:p-8">
                <!-- { "translate-y-0 scale-100 opacity-100 my-10": open } -->
                <div class="relative">
                    <button class="modal-two-close-btn absolute top-0 ltr:right-0 rtl:left-0">
                        <i class="las la-times"></i>
                    </button>
                    <div class="bb-dashed mb-4 flex items-center justify-between pb-4 3xl:">
                        <h4 class="h4">Add Account</h4>
                    </div>
                    <form>
                        <div class="mt-6 grid grid-cols-2 gap-4 xl:mt-8 3xl:gap-6">
                            <div class="col-span-2">
                                <label for="name" class="mb-4 block font-medium md:text-lg">
                                    Account Holder Name
                                </label>
                                <input type="text"
                                    class="w-full rounded-3xl border border-n30 bg-secondary/5 px-6 py-2.5   md:py-3"
                                    placeholder="Enter Name" id="name" required />
                            </div>
                            <div class="col-span-2">
                                <label for="number" class="mb-4 block font-medium md:text-lg">
                                    Phone Number
                                </label>
                                <input type="number"
                                    class="w-full rounded-3xl border border-n30 bg-secondary/5 px-6 py-2.5   md:py-3"
                                    placeholder="Enter Number" id="number" required />
                            </div>
                            <div class="col-span-2">
                                <label for="currency" class="mb-4 block font-medium md:text-lg">
                                    Select Currency
                                </label>
                                <select name="currency" class="nc-select full ">
                                    <option value="usd">USD</option>
                                    <option value="gbp">GBP</option>
                                    <option value="yen">YEN</option>
                                    <option value="jpn">JPN</option>
                                </select>
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label for="rate" class="mb-4 block font-medium md:text-lg">
                                    Interest Rate
                                </label>
                                <input type="number"
                                    class="w-full rounded-3xl border border-n30 bg-secondary/5 px-6 py-2.5   md:py-3"
                                    placeholder="Interest Rate %" id="rate" required />
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label for="expire" class="mb-4 block font-medium md:text-lg">
                                    Expiry Date
                                </label>
                                <div class="relative bg-secondary/5 py-3  border border-n30  rounded-3xl">
                                    <input type="date" class="border-none w-full px-4" placeholder="Select Date"
                                        autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-span-2">
                                <label for="amount" class="mb-4 block font-medium md:text-lg">
                                    Amount
                                </label>
                                <input type="number"
                                    class="w-full rounded-3xl border border-n30 bg-secondary/5 px-6 py-2.5   md:py-3"
                                    placeholder="Enter Amount" id="amount" required />
                            </div>
                            <div class="col-span-2">
                                <label for="status" class="mb-4 block font-medium md:text-lg">
                                    Select Status
                                </label>
                                <select name="currency" class="nc-select full ">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-span-2 mt-4">
                                <button class="btn-primary flex w-full justify-center" type="submit">
                                    Create Account
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection