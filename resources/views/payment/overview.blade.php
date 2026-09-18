@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Payment Overview</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            <div class="col-span-12 md:col-span-7 xxl:col-span-8">
                <!-- Payment Actions -->
                <div class="grid grid-cols-12 gap-4 xxl:gap-6 p-4 box min-[1880px]:p-6 mb-4 xxl:mb-6">
                    <div
                        class="col-span-12 cursor-pointer border border-dashed qt-modal-btn duration-300 border-transparent hover:border-primary lg:col-span-6 3xl:col-span-4 box  bg-primary/5  flex items-center gap-4 4xl:gap-6 xl:p-3 min-[1880px]:p-6">
                        <span
                            class="bg-n0  w-10 h-10 xxl:w-16 xxl:h-16 flex items-center justify-center shrink-0 rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                            <i class="las text-2xl xxl:text-3xl la-exchange-alt"></i>
                        </span>
                        <div>
                            <h5 class="text-base xxl:text-lg 4xl:text-xl font-medium mb-1 xxl:mb-2">
                                Make Transfer
                            </h5>
                            <span class="text-xs xxl:text-sm">365 Credits</span>
                        </div>
                    </div>
                    <div
                        class="col-span-12 cursor-pointer border border-dashed qt-modal-btn duration-300 border-transparent hover:border-primary lg:col-span-6 3xl:col-span-4 box  bg-primary/5  flex items-center gap-4 4xl:gap-6 xl:p-3 min-[1880px]:p-6">
                        <span
                            class="bg-n0  w-10 h-10 xxl:w-16 xxl:h-16 flex items-center justify-center shrink-0 rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                            <i class="las text-2xl xxl:text-3xl la-qrcode"></i>
                        </span>
                        <div>
                            <h5 class="text-base xxl:text-lg 4xl:text-xl font-medium mb-1 xxl:mb-2">
                                Pay for QR Code
                            </h5>
                            <span class="text-xs xxl:text-sm">365 Credits</span>
                        </div>
                    </div>
                    <div
                        class="col-span-12 cursor-pointer border border-dashed qt-modal-btn duration-300 border-transparent hover:border-primary lg:col-span-6 3xl:col-span-4 box  bg-primary/5  flex items-center gap-4 4xl:gap-6 xl:p-3 min-[1880px]:p-6">
                        <span
                            class="bg-n0  w-10 h-10 xxl:w-16 xxl:h-16 flex items-center justify-center shrink-0 rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                            <i class="lab text-2xl xxl:text-3xl la-paypal"></i>
                        </span>
                        <div>
                            <h5 class="text-base xxl:text-lg 4xl:text-xl font-medium mb-1 xxl:mb-2">
                                Pay for Paypal
                            </h5>
                            <span class="text-xs xxl:text-sm">365 Credits</span>
                        </div>
                    </div>
                </div>
                <!-- payment Overview -->
                <div class="box overflow-x-hidden">
                    <div class="flex items-center flex-wrap justify-between gap-3 bb-dashed mb-4 pb-4 3xl:">
                        <h4 class="h4">Payment Overview</h4>
                        <div class="flex items-center gap-3">
                            <span>Sort By : </span>
                            <select name="sort" class="nc-select green">
                                <option value="day">Last 15 Days</option>
                                <option value="week">Last 1 Month</option>
                                <option value="year">Last 6 Month</option>
                            </select>
                        </div>
                    </div>
                    <div class="payment-overview"></div>
                </div>

            </div>
            <div class="col-span-12 md:col-span-5 xxl:col-span-4">
                <!-- Payment Providers -->
                <div class="box">
                    <div class="flex justify-between items-center bb-dashed border-secondary/20 pb-4 mb-4 lg:pb-6 lg:mb-6">
                        <h4 class="h4">Payment Providers</h4>
                        @include('partials._horizontal-options')

                    </div>
                    <ul class="flex flex-col gap-4 lg:gap-6">
                        <li>
                            <a href="#" class="flex justify-between items-center gap-2">
                                <div class="flex items-center gap-3 sm:gap-4 xxl:gap-6">
                                    <span
                                        class="border border-n30  bg-primary/5 w-10 h-10 flex items-center justify-center xxl:w-14 xxl:h-14 shrink-0 rounded-full">
                                        <i class="las la-gas-pump"></i>
                                    </span>
                                    <div>
                                        <p class="text-lg font-medium">Utilities</p>
                                        <span class="text-xs">Electricity, gas, water, sewage, trash disposal</span>
                                    </div>
                                </div>
                                <span
                                    class="border border-n30  bg-primary/5 w-10 h-10 flex items-center justify-center xxl:w-14 xxl:h-14 shrink-0 rounded-full">
                                    <i class="las la-arrow-right"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex justify-between items-center gap-2">
                                <div class="flex items-center gap-3 sm:gap-4 xxl:gap-6">
                                    <span
                                        class="border border-n30  bg-primary/5 w-10 h-10 flex items-center justify-center xxl:w-14 xxl:h-14 shrink-0 rounded-full">
                                        <i class="las la-tv"></i>
                                    </span>
                                    <div>
                                        <p class="text-lg font-medium">Communication</p>
                                        <span class="text-xs">Telephone, internet, cable TV</span>
                                    </div>
                                </div>
                                <span
                                    class="border border-n30  bg-primary/5 w-10 h-10 flex items-center justify-center xxl:w-14 xxl:h-14 shrink-0 rounded-full">
                                    <i class="las la-arrow-right"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex justify-between items-center gap-2">
                                <div class="flex items-center gap-3 sm:gap-4 xxl:gap-6">
                                    <span
                                        class="border border-n30  bg-primary/5 w-10 h-10 flex items-center justify-center xxl:w-14 xxl:h-14 shrink-0 rounded-full">
                                        <i class="las la-home"></i>
                                    </span>
                                    <div>
                                        <p class="text-lg font-medium">Housing</p>
                                        <span class="text-xs">Rent, mortgage, property taxes, insurance</span>
                                    </div>
                                </div>
                                <span
                                    class="border border-n30  bg-primary/5 w-10 h-10 flex items-center justify-center xxl:w-14 xxl:h-14 shrink-0 rounded-full">
                                    <i class="las la-arrow-right"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex justify-between items-center gap-2">
                                <div class="flex items-center gap-3 sm:gap-4 xxl:gap-6">
                                    <span
                                        class="border border-n30  bg-primary/5 w-10 h-10 flex items-center justify-center xxl:w-14 xxl:h-14 shrink-0 rounded-full">
                                        <i class="las la-car"></i>
                                    </span>
                                    <div>
                                        <p class="text-lg font-medium">Transportation</p>
                                        <span class="text-xs">Car loan, car insurance, gasoline</span>
                                    </div>
                                </div>
                                <span
                                    class="border border-n30  bg-primary/5 w-10 h-10 flex items-center justify-center xxl:w-14 xxl:h-14 shrink-0 rounded-full">
                                    <i class="las la-arrow-right"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex justify-between items-center gap-2">
                                <div class="flex items-center gap-3 sm:gap-4 xxl:gap-6">
                                    <span
                                        class="border border-n30  bg-primary/5 w-10 h-10 flex items-center justify-center xxl:w-14 xxl:h-14 shrink-0 rounded-full">
                                        <i class="las la-hamburger"></i>
                                    </span>
                                    <div>
                                        <p class="text-lg font-medium">Food</p>
                                        <span class="text-xs">Groceries, dining out</span>
                                    </div>
                                </div>
                                <span
                                    class="border border-n30  bg-primary/5 w-10 h-10 flex items-center justify-center xxl:w-14 xxl:h-14 shrink-0 rounded-full">
                                    <i class="las la-arrow-right"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex justify-between items-center gap-2">
                                <div class="flex items-center gap-3 sm:gap-4 xxl:gap-6">
                                    <span
                                        class="border border-n30  bg-primary/5 w-10 h-10 flex items-center justify-center xxl:w-14 xxl:h-14 shrink-0 rounded-full">
                                        <i class="las la-heartbeat"></i>
                                    </span>
                                    <div>
                                        <p class="text-lg font-medium">Healthcare</p>
                                        <span class="text-xs">Health insurance, medical bills</span>
                                    </div>
                                </div>
                                <span
                                    class="border border-n30  bg-primary/5 w-10 h-10 flex items-center justify-center xxl:w-14 xxl:h-14 shrink-0 rounded-full">
                                    <i class="las la-arrow-right"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex justify-between items-center gap-2">
                                <div class="flex items-center gap-3 sm:gap-4 xxl:gap-6">
                                    <span
                                        class="border border-n30  bg-primary/5 w-10 h-10 flex items-center justify-center xxl:w-14 xxl:h-14 shrink-0 rounded-full">
                                        <i class="las la-graduation-cap"></i>
                                    </span>
                                    <div>
                                        <p class="text-lg font-medium">Education</p>
                                        <span class="text-xs">Tuition, fees, books, supplies</span>
                                    </div>
                                </div>
                                <span
                                    class="border border-n30  bg-primary/5 w-10 h-10 flex items-center justify-center xxl:w-14 xxl:h-14 shrink-0 rounded-full">
                                    <i class="las la-arrow-right"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-span-12">
                <!-- Recent Payments -->
                <div class="box col-span-12 lg:col-span-6">
                    <div class="flex flex-wrap gap-4  justify-between items-center bb-dashed mb-4 pb-4 3xl:">
                        <h4 class="h4">Recent Payments</h4>
                        <div class="flex flex-wrap grow sm:justify-end items-center gap-4">
                            <form
                                class="bg-primary/5  border border-n30  flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                                <input type="text" placeholder="Search"
                                    class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
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
                    <div class="overflow-x-auto mb-4 lg:mb-6">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="bg-primary/5 ">
                                    <th class="text-start py-5 px-6 cursor-pointer min-w-[250px]">
                                        <div class="flex items-center gap-1">
                                            Title
                                        </div>
                                    </th>
                                    <th class="text-start py-5 min-w-[100px]">Invoice</th>
                                    <th class="text-start py-5 min-w-[120px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Medium
                                        </div>
                                    </th>
                                    <th class="text-start py-5 min-w-[130px]">Date</th>
                                    <th class="text-start py-5 min-w-[130px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Money
                                        </div>
                                    </th>
                                    <th class="text-start py-5 min-w-[130px]">Time</th>
                                    <th class="text-start py-5 cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Status
                                        </div>
                                    </th>
                                    <th class="text-center p-5 ">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                                    <td class="py-5 px-6">
                                        <div class="flex items-center gap-3">
                                            <i class="las la-file text-primary"></i>
                                            <span class="font-medium">Savings Deposit</span>
                                        </div>
                                    </td>
                                    <td class="py-5">
                                        <p class="font-medium">#5420142</p>
                                    </td>
                                    <td class="py-5">
                                        <span>Paypal</span>
                                    </td>
                                    <td class="py-5">11/05/2028</td>
                                    <td class="py-5">$7,000</td>
                                    <td>05:12 AM</td>
                                    <td class="py-5">
                                        <span
                                            class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                            Active
                                        </span>
                                    </td>
                                    <td class="py-5">
                                        <div class="flex justify-center">
                                            @include('partials._vertical-options')

                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                                    <td class="py-5 px-6">
                                        <div class="flex items-center gap-3">
                                            <i class="las la-file text-primary"></i>
                                            <span class="font-medium">Savings Deposit</span>
                                        </div>
                                    </td>
                                    <td class="py-5">
                                        <p class="font-medium">#5420142</p>
                                    </td>
                                    <td class="py-5">
                                        <span>Paypal</span>
                                    </td>
                                    <td class="py-5">11/05/2028</td>
                                    <td class="py-5">$7,000</td>
                                    <td>05:12 AM</td>
                                    <td class="py-5">
                                        <span
                                            class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-warning/10  text-warning">
                                            Paused
                                        </span>
                                    </td>
                                    <td class="py-5">
                                        <div class="flex justify-center">
                                            @include('partials._vertical-options')

                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                                    <td class="py-5 px-6">
                                        <div class="flex items-center gap-3">
                                            <i class="las la-file text-primary"></i>
                                            <span class="font-medium">Fixed Deposit</span>
                                        </div>
                                    </td>
                                    <td class="py-5">
                                        <p class="font-medium">#5420142</p>
                                    </td>
                                    <td class="py-5">
                                        <span>Paypal</span>
                                    </td>
                                    <td class="py-5">11/05/2028</td>
                                    <td class="py-5">$7,000</td>
                                    <td>05:12 AM</td>
                                    <td class="py-5">
                                        <span
                                            class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                            Cancelled
                                        </span>
                                    </td>
                                    <td class="py-5">
                                        <div class="flex justify-center">
                                            @include('partials._vertical-options')

                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                                    <td class="py-5 px-6">
                                        <div class="flex items-center gap-3">
                                            <i class="las la-file text-primary"></i>
                                            <span class="font-medium">Terms Deposit</span>
                                        </div>
                                    </td>
                                    <td class="py-5">
                                        <p class="font-medium">#5420142</p>
                                    </td>
                                    <td class="py-5">
                                        <span>Paypal</span>
                                    </td>
                                    <td class="py-5">11/05/2028</td>
                                    <td class="py-5">$7,000</td>
                                    <td>05:12 AM</td>
                                    <td class="py-5">
                                        <span
                                            class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-warning/10  text-warning">
                                            Paused
                                        </span>
                                    </td>
                                    <td class="py-5">
                                        <div class="flex justify-center">
                                            @include('partials._vertical-options')

                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                                    <td class="py-5 px-6">
                                        <div class="flex items-center gap-3">
                                            <i class="las la-file text-primary"></i>
                                            <span class="font-medium">Emergency Fund</span>
                                        </div>
                                    </td>
                                    <td class="py-5">
                                        <p class="font-medium">#5420142</p>
                                    </td>
                                    <td class="py-5">
                                        <span>Paypal</span>
                                    </td>
                                    <td class="py-5">11/05/2028</td>
                                    <td class="py-5">$7,000</td>
                                    <td>05:12 AM</td>
                                    <td class="py-5">
                                        <span
                                            class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                            Cancelled
                                        </span>
                                    </td>
                                    <td class="py-5">
                                        <div class="flex justify-center">
                                            @include('partials._vertical-options')

                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                                    <td class="py-5 px-6">
                                        <div class="flex items-center gap-3">
                                            <i class="las la-file text-primary"></i>
                                            <span class="font-medium">Holiday Savings</span>
                                        </div>
                                    </td>
                                    <td class="py-5">
                                        <p class="font-medium">#5420142</p>
                                    </td>
                                    <td class="py-5">
                                        <span>Paypal</span>
                                    </td>
                                    <td class="py-5">11/05/2028</td>
                                    <td class="py-5">$7,000</td>
                                    <td>05:12 AM</td>
                                    <td class="py-5">
                                        <span
                                            class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                            Active
                                        </span>
                                    </td>
                                    <td class="py-5">
                                        <div class="flex justify-center">
                                            @include('partials._vertical-options')

                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                                    <td class="py-5 px-6">
                                        <div class="flex items-center gap-3">
                                            <i class="las la-file text-primary"></i>
                                            <span class="font-medium">Investment Portfolio</span>
                                        </div>
                                    </td>
                                    <td class="py-5">
                                        <p class="font-medium">#5420142</p>
                                    </td>
                                    <td class="py-5">
                                        <span>Paypal</span>
                                    </td>
                                    <td class="py-5">11/05/2028</td>
                                    <td class="py-5">$7,000</td>
                                    <td>05:12 AM</td>
                                    <td class="py-5">
                                        <span
                                            class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                            Cancelled
                                        </span>
                                    </td>
                                    <td class="py-5">
                                        <div class="flex justify-center">
                                            @include('partials._vertical-options')

                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                                    <td class="py-5 px-6">
                                        <div class="flex items-center gap-3">
                                            <i class="las la-file text-primary"></i>
                                            <span class="font-medium">Education Fund</span>
                                        </div>
                                    </td>
                                    <td class="py-5">
                                        <p class="font-medium">#5420142</p>
                                    </td>
                                    <td class="py-5">
                                        <span>Paypal</span>
                                    </td>
                                    <td class="py-5">11/05/2028</td>
                                    <td class="py-5">$7,000</td>
                                    <td>05:12 AM</td>
                                    <td class="py-5">
                                        <span
                                            class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                            Active
                                        </span>
                                    </td>
                                    <td class="py-5">
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
    </div>
@endsection

@section('page-modal')
    <div class="qt-modal fixed inset-0 z-99 modalhide overflow-y-auto bg-n900/80 duration-500">
        <div class="overflow-y-auto">
            <div
                class="modal box modal-inner absolute left-1/2 -translate-y-1/2 top-1/2 max-h-[90vh] w-[95%] max-w-[496px] -translate-x-1/2 overflow-y-auto duration-300 xl:p-8">
                <div class="relative">
                    <button class="qt-modal-close-btn absolute top-0 ltr:right-0 rtl:left-0">
                        <i class="las la-times"></i>
                    </button>
                    <div class="bb-dashed mb-4 flex items-center justify-between pb-4 3xl:">
                        <h4 class="h4">Quick Transfer</h4>
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
                            Send Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection