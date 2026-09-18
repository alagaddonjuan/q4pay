@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Card Details</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            <div class="col-span-12 md:col-span-5 xxl:col-span-4">
                <!-- Card Details -->
                <div class="box mb-4 xxl:mb-6">
                    <div class="bb-dashed pb-4 mb-4 3xl: flex justify-between items-center">
                        <h4 class="h4">Details</h4>
                        <select name="sort" class="nc-select green min-w-[120px]">
                            <option value="day">Visa</option>
                            <option value="week">Payoneer</option>
                            <option value="year">Mastercard</option>
                        </select>
                    </div>
                    <div class="bb-dashed pb-4 mb-4 3xl: flex flex-col">
                        <div
                            class="bg-secondary p-4 lg:px-6 lg:py-5 rounded-xl text-n0 relative overflow-hidden after:absolute after:rounded-full after:w-[300px] after:h-[300px] after:bg-[#FFC861] after:top-[45%] after:ltr:left-[65%] after:rtl:right-[65%] mb-6 lg:mb-8">
                            <div class="flex justify-between items-start mb-3 sm:mb-4 lg:mb-8 3xl:mb-14">
                                <div>
                                    <p class="text-xs mb-1">Current Balance</p>
                                    <h4 class="h4">80,700.00 USD</h4>
                                </div>
                                <img src="{{ asset('assets/images/visa-sm.png') }}" width="45" height="16"
                                    alt="visa icon" />
                            </div>
                            <img src="{{ asset('assets/images/mastercard.png') }}" width="45" height="45" alt="visa icon" />
                            <div class="flex justify-between items-end lg:mt-2">
                                <div>
                                    <p class="mb-1">Felecia Brown</p>
                                    <p class="text-xs">•••• •••• •••• 8854</p>
                                </div>
                                <p class="text-n700 relative z-1">12/27</p>
                            </div>
                        </div>
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
                    <div>
                        <ul class="list-disc accent-primary flex flex-col gap-4">
                            <li class="flex justify-between items-center">
                                <span class="flex gap-2 items-center">
                                    <span class="text-primary">•</span>
                                    <span class="font-semibold">Download Statement</span>
                                </span>
                                <button class="w-9 h-9 rounded-full bg-primary text-white">
                                    <i class="text-lg las la-download"></i>
                                </button>
                            </li>
                            <li class="flex justify-between items-center">
                                <span class="flex gap-2 items-center">
                                    <span class="text-primary">•</span>
                                    <span class="font-semibold">Change Password</span>
                                </span>
                                <button class="w-9 h-9 rounded-full bg-primary/5 border border-n30  ">
                                    <i class="text-lg las la-edit"></i>
                                </button>
                            </li>
                            <li class="flex justify-between items-center">
                                <span class="flex gap-2 items-center">
                                    <span class="text-primary">•</span>
                                    <span class="font-semibold">Download Statement</span>
                                </span>
                                <button class="w-9 h-9 rounded-full bg-primary/5 border border-n30  ">
                                    <i class="text-lg las la-ban"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Card History -->
                <div class="box overflow-x-hidden">
                    <div class="flex flex-wrap justify-between items-center gap-3 pb-4 lg:pb-6 mb-4 lg:mb-6 bb-dashed">
                        <h4 class="h4">History</h4>
                        <div class="flex items-center gap-2">
                            <h4 class="text-xs sm:text-sm md:text-base">Sort By : </h4>
                            <select name="sort" class="nc-select green">
                                <option value="day">Last 15 Days</option>
                                <option value="week">Last 1 Month</option>
                                <option value="year">Last 6 Month</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-history-chart"></div>
                </div>

            </div>
            <div class="col-span-12 md:col-span-7 xxl:col-span-8">
                <!-- Card Transactions -->
                <div class="box overflow-x-hidden mb-4 xxl:mb-6">
                    <div class="flex flex-wrap justify-between items-center gap-3 pb-4 lg:pb-6 mb-4 lg:mb-6 bb-dashed">
                        <h4 class="h4">Card Transactions</h4>
                        <div class="flex items-center gap-2">
                            <p class="text-xs sm:text-sm md:text-base">Sort By : </p>
                            <select name="sort" class="nc-select green">
                                <option value="day">Last 15 Days</option>
                                <option value="week">Last 1 Month</option>
                                <option value="year">Last 6 Month</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-transaction-chart"></div>
                </div>
                <!-- Card documentation -->
                <div class="box">
                    <div class="flex flex-wrap gap-4  justify-between items-center bb-dashed mb-4 pb-4 3xl:">
                        <h4 class="h4">Card Documentations</h4>
                        <div class="flex items-center flex-wrap grow sm:justify-end gap-4">
                            <form
                                class="bg-primary/5  border border-n30  flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                                <input type="text" placeholder="Search" id="card-doc-search"
                                    class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
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
                    <div class="overflow-y-auto">
                        <table class="w-full whitespace-nowrap mb-6" id="card-doc-table">
                            <thead>
                                <tr class="bg-secondary/5">
                                    <th class="p-5 text-start w-[45%]">Document Type</th>
                                    <th class="p-5 text-start w-[45%]">
                                        Additional Titles/Sections
                                    </th>
                                    <th class="p-5 text-start" data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-secondary/5  duration-500 border-b border-n30 ">
                                    <td class="p-5">Credit Card Agreement</td>
                                    <td class="p-5">Interest Rates</td>
                                    <td class="p-5">
                                        <button>
                                            <i class="las la-download"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-secondary/5  duration-500 border-b border-n30 ">
                                    <td class="p-5">Cardholder Agreement</td>
                                    <td class="p-5">Transaction Details</td>
                                    <td class="p-5">
                                        <button>
                                            <i class="las la-download"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-secondary/5  duration-500 border-b border-n30 ">
                                    <td class="p-5">Credit Card Agreement</td>
                                    <td class="p-5">Interest Rates</td>
                                    <td class="p-5">
                                        <button>
                                            <i class="las la-download"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-secondary/5  duration-500 border-b border-n30 ">
                                    <td class="p-5">Terms and Conditions</td>
                                    <td class="p-5">Annual Fees</td>
                                    <td class="p-5">
                                        <button>
                                            <i class="las la-download"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-secondary/5  duration-500 border-b border-n30 ">
                                    <td class="p-5">Terms and Conditions</td>
                                    <td class="p-5">Annual Fees</td>
                                    <td class="p-5">
                                        <button>
                                            <i class="las la-download"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-secondary/5  duration-500 border-b border-n30 ">
                                    <td class="p-5">Billing and Payment</td>
                                    <td class="p-5">Interest Rates</td>
                                    <td class="p-5">
                                        <button>
                                            <i class="las la-download"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-secondary/5  duration-500 border-b border-n30 ">
                                    <td class="p-5">Billing and Payment</td>
                                    <td class="p-5">Interest Rates</td>
                                    <td class="p-5">
                                        <button>
                                            <i class="las la-download"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr class="hover:bg-secondary/5  duration-500 border-b border-n30 ">
                                    <td class="p-5">Terms and Conditions</td>
                                    <td class="p-5">Annual Fees</td>
                                    <td class="p-5">
                                        <button>
                                            <i class="las la-download"></i>
                                        </button>
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
    </div>
@endsection