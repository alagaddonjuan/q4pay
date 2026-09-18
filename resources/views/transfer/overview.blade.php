@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Transfer Overview</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            <div class="col-span-12 md:col-span-7 lg:col-span-8">
                <div class="col-span-12 box overflow-x-hidden">
                    <div class="flex justify-between gap-4 flex-wrap items-center bb-dashed mb-4 pb-4">
                        <h4 class="h4">Total Transfer</h4>
                        <div class="flex items-center gap-3 whitespace-nowrap">
                            <span>Sort By : </span>
                            <select name="sort" class="nc-select green">
                                <option value="day">Last 15 Days</option>
                                <option value="week">Last 1 Month</option>
                                <option value="year">Last 6 Month</option>
                            </select>
                        </div>
                    </div>
                    <div class="total-transfer"></div>
                </div>
            </div>
            <div class="col-span-12 md:col-span-5 lg:col-span-4">
                <div class="box">
                    <div class="flex flex-wrap gap-4  justify-between items-center bb-dashed mb-4 pb-4 3xl:">
                        <h4 class="h4">Your Receipt</h4>
                        @include('partials._horizontal-options')
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="bg-primary/5 ">
                                    <th class="text-start py-5 px-6 min-w-[230px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Title
                                        </div>
                                    </th>
                                    <th class="text-start py-5 min-w-[130px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Transaction
                                        </div>
                                    </th>
                                    <th class="text-start py-5 min-w-[50px]"></th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="even:bg-primary/5 ">
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
                                    <td class="py-2">$2,552,254</td>
                                    <td class="py-2">
                                        <i class="las la-download"></i>
                                    </td>
                                </tr>
                                <tr class="even:bg-primary/5 ">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">Salaries</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2">$2,552,254</td>
                                    <td class="py-2">
                                        <i class="las la-download"></i>
                                    </td>
                                </tr>
                                <tr class="even:bg-primary/5 ">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/payoneer.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">Massive Dynamic</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2">$2,552,254</td>
                                    <td class="py-2">
                                        <i class="las la-download"></i>
                                    </td>
                                </tr>
                                <tr class="even:bg-primary/5 ">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/visa.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">Collingwood</p>
                                                <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-2">$2,552,254</td>
                                    <td class="py-2">
                                        <i class="las la-download"></i>
                                    </td>
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
            <!-- Payment Account -->
            <div class="col-span-12">
                <div class="box col-span-12 lg:col-span-6">
                    <div class="flex justify-between items-center gap-4 flex-wrap bb-dashed mb-4 pb-4 3xl:">
                        <h4 class="h4">Payment Account</h4>
                        <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                            <form
                                class="bg-primary/5 datatable-search  border border-n30  flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                                <input type="text" placeholder="Search"
                                    class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full"
                                    id="payment-account-search" />
                                <button
                                    class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                                    <i class="las la-search text-lg"></i>
                                </button>
                            </form>
                            <div class="flex items-center gap-3 whitespace-nowrap">
                                <span>Sort By : </span>
                                <select name="sort" class="nc-select green !rounded-3xl">
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
                            Showing 1 to 12 of 18 entries
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
    </div>
@endsection