@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Deposit Details</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="flex flex-col gap-4 xxl:gap-6">
            <!-- Deposit Details -->
            <div class="box col-span-12 md:col-span-5 lg:col-span-4">
                <div class="bb-dashed border-secondary/30 pb-4 mb-4 3xl: flex justify-between items-center">
                    <h4 class="h4">Account Details</h4>
                    <select name="sort" class="nc-select green min-w-[120px]">
                        <option value="day">Visa</option>
                        <option value="week">Payoneer</option>
                        <option value="year">Mastercard</option>
                    </select>
                </div>

                <div
                    class="grid grid-cols-12 xxl:divide-x rtl:divide-x-reverse divide-secondary/30 divide-dashed items-center gap-y-6">
                    <div
                        class="col-span-12 md:col-span-6 xxl:col-span-4 md:ltr:pr-6 3xl:ltr:pr-10 md:rtl:pl-6 3xl:rtl:pl-10">
                        <div
                            class="bg-secondary p-4 lg:px-6 lg:py-5 rounded-xl text-n0 relative overflow-hidden after:absolute after:rounded-full after:w-[300px] after:h-[300px] after:bg-[#FFC861] after:top-[50%] after:ltr:left-[55%] sm:ltr:after:left-[65%] after:rtl:right-[55%] sm:rtl:after:right-[65%]">
                            <div class="flex justify-between items-start mb-4 md:mb-8 lg:mb-10 3xl:mb-14">
                                <div>
                                    <p class="text-xs mb-1">Current Balance</p>
                                    <h4 class="h4">80,700.00 USD</h4>
                                </div>
                                <img src="{{ asset('assets/images/visa-sm.png') }}" width="45" height="16"
                                    alt="visa icon" />
                            </div>
                            <div class="flex justify-between items-end">
                                <div>
                                    <img width="45" height="45" src="{{ asset('assets/images/mastercard.png') }}"
                                        alt="card icon" />
                                    <p class="mb-1 mt-1 md:mt-3">Felecia Brown</p>
                                    <p class="text-xs">•••• •••• •••• 8854</p>
                                </div>
                                <p class="text-n700 relative z-1">12/27</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 xxl:col-span-4 md:pl-6 xxl:px-6 3xl:px-10">
                        <ul class="flex flex-col gap-4">
                            <li class="flex justify-between">
                                <span>Card Type:</span> <span class="font-medium">Visa</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Card Holder:</span> <span class="font-medium">Felecia Brown</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Expires:</span> <span class="font-medium">12/27</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Card Number:</span> <span class="font-medium">325 541 565 546</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Total Balance:</span> <span class="font-medium">99,225.54 USD</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Total Debt:</span> <span class="font-medium">9,545.22 USD</span>
                            </li>
                        </ul>
                    </div>
                    <div
                        class="col-span-12 md:col-span-6 xxl:col-span-4 xxl:ltr:pl-6 3xl:ltr:pl-10 xxl:rtl:pr-6 3xl:rtl:pr-10">
                        <p class="text-lg font-medium mb-6">Active card</p>
                        <div
                            class="border border-primary border-dashed bg-primary/5 rounded-lg p-3 flex items-center gap-4 mb-6 lg:mb-8">
                            <img src="{{ asset('assets/images/card-sm-1.png') }}" width="60" height="40" alt="card" />
                            <div>
                                <p class="font-medium mb-1">John Snow - Metal</p>
                                <span class="text-xs">**4291 - Exp: 12/26</span>
                            </div>
                        </div>
                        <a href="#" class="text-primary font-semibold flex items-center gap-2  mb-6 lg:mb-8 bb-dashed pb-6">
                            More Card <i class="las la-arrow-right"></i>
                        </a>
                        <div class="flex gap-4 lg:gap-6">
                            <a href="#" class="btn-primary flex justify-center w-full lg:py-2.5">
                                Pay Debt
                            </a>
                            <a href="#" class="btn-outline flex justify-center w-full lg:py-2.5">
                                Cancel
                            </a>
                        </div>
                    </div>
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
                        <h4 class="h4">Add Deposit</h4>
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