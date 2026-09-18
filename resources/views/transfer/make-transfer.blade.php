@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Make Transfer</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            <!-- recent trasfer chart -->
            <div class="col-span-12 md:col-span-7 xxl:col-span-8">
                <div class="col-span-12 box overflow-x-hidden">
                    <div class="flex justify-between flex-wrap gap-5 items-center bb-dashed mb-4 pb-4">
                        <h4 class="h4">Recent transfer</h4>
                        <div class="flex items-center gap-3 whitespace-nowrap">
                            <span>Sort By : </span>
                            <select name="sort" class="nc-select green ">
                                <option value="day">Last 15 Days</option>
                                <option value="week">Last 1 Month</option>
                                <option value="year">Last 6 Month</option>
                            </select>
                        </div>
                    </div>
                    <div class="recent-transfer"></div>
                </div>
            </div>
            <!-- My wallets -->
            <div class="col-span-12 md:col-span-5 xxl:col-span-4">
                <div class="box">
                    <h4 class="h4 bb-dashed mb-4 pb-4 3xl:">My Wallet</h4>
                    <div class="mb-6 gap-3 flex justify-center lg:mb-8 xxl:gap-4">
                        <img src="{{ asset('assets/images/my-wallet-3.png') }}" width="296" class="rounded-xl" height="200"
                            alt="card img" />
                    </div>
                    <h5 class="mb-6 text-lg font-medium md:text-xl">
                        Quick Transfer
                    </h5>
                    <form>
                        <div class="mb-5 flex items-center rounded-[32px] border border-n30 bg-primary/5 p-1  ">
                            <select name="card" id="card" class="card nc-select ">
                                <option value="visa">Visa</option>
                                <option value="mastercard">MasterCard</option>
                                <option value="payonneer">Payoneer</option>
                            </select>
                            <input type="text"
                                class="w-full border-none bg-transparent pr-5 focus:border-none focus:outline-none"
                                placeholder="Account Number..." name="card" />
                        </div>
                        <div class="mb-6 flex items-center rounded-[32px] border border-n30 bg-primary/5 p-1   lg:mb-8">
                            <select name="card" id="currency" class="card nc-select ">
                                <option value="dollar">$</option>
                                <option value="frack">€</option>
                                <option value="yen">¥</option>
                                <option value="gbp">£</option>
                            </select>
                            <input type="number" class="w-full border-none bg-transparent pr-5"
                                placeholder="Enter Amount..." name="amount" />
                        </div>
                        <button type="submit" class="btn-primary flex w-full justify-center">
                            Send Money
                        </button>
                    </form>
                </div>
            </div>
            <!-- Recent Payment -->
            <div class="col-span-12">
                <div class="box col-span-12 lg:col-span-6">
                    <div class="flex justify-between items-center gap-4 flex-wrap bb-dashed mb-4 pb-4 3xl:">
                        <h4 class="h4">Recent Payments</h4>
                        <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                            <form
                                class="bg-primary/5  border border-n30  flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                                <input type="text" placeholder="Search"
                                    class="bg-transparent text-sm border-none ltr:pl-4 rtl:pr-4 py-1 w-full" />
                                <button
                                    class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                                    <i class="las la-search text-lg"></i>
                                </button>
                            </form>
                            <div class="flex items-center gap-3 whitespace-nowrap">
                                <span>Sort By : </span>
                                <select name="sort" class="nc-select green rounded-3xl!">
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
                                <tr class="bg-secondary/5 ">
                                    <th class="text-start py-5 px-6 cursor-pointer min-w-[230px]">
                                        <div class="flex items-center gap-1">
                                            Account Number
                                        </div>
                                    </th>
                                    <th class="text-start py-5 min-w-[170px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Transfer Account
                                        </div>
                                    </th>
                                    <th class="text-start py-5 min-w-[120px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Money
                                        </div>
                                    </th>
                                    <th class="text-start py-5 min-w-[130px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Medium
                                        </div>
                                    </th>
                                    <th class="text-start py-5 min-w-[130px]">Date</th>
                                    <th class="text-start py-5 min-w-[100px]">Time</th>
                                    <th class="text-start py-5 min-w-[130px] cursor-pointer">
                                        <div class="flex items-center gap-1">
                                            Status
                                        </div>
                                    </th>
                                    <th class="text-center p-5 ">PDF</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-primary/5  duration-300 border-b border-n30  first:border-t">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">123 *** *** 456</p>
                                                <span class="text-xs">Account Number</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">789 *** *** 012</td>
                                    <td class="py-3">$21,542,145</td>
                                    <td class="py-3">Paypal</td>
                                    <td class="py-3">04/15/2029</td>
                                    <td class="py-3">11:30 AM</td>
                                    <td class="py-3">
                                        <span
                                            class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                            Successful
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="flex justify-center">
                                            <button>
                                                <i class="las la-download"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-primary/5  duration-300 border-b border-n30  first:border-t">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/rs-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">123 *** *** 456</p>
                                                <span class="text-xs">Account Number</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">789 *** *** 012</td>
                                    <td class="py-3">$21,542,145</td>
                                    <td class="py-3">Paypal</td>
                                    <td class="py-3">04/15/2029</td>
                                    <td class="py-3">11:30 AM</td>
                                    <td class="py-3">
                                        <span
                                            class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                            Cancelled
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="flex justify-center">
                                            <button>
                                                <i class="las la-download"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-primary/5  duration-300 border-b border-n30  first:border-t">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/jp-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">123 *** *** 456</p>
                                                <span class="text-xs">Account Number</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">789 *** *** 012</td>
                                    <td class="py-3">$21,542,145</td>
                                    <td class="py-3">Paypal</td>
                                    <td class="py-3">04/15/2029</td>
                                    <td class="py-3">11:30 AM</td>
                                    <td class="py-3">
                                        <span
                                            class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                            Cancelled
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="flex justify-center">
                                            <button>
                                                <i class="las la-download"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-primary/5  duration-300 border-b border-n30  first:border-t">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/uk-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">123 *** *** 456</p>
                                                <span class="text-xs">Account Number</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">789 *** *** 012</td>
                                    <td class="py-3">$21,542,145</td>
                                    <td class="py-3">Paypal</td>
                                    <td class="py-3">04/15/2029</td>
                                    <td class="py-3">11:30 AM</td>
                                    <td class="py-3">
                                        <span
                                            class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                            Successful
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="flex justify-center">
                                            <button>
                                                <i class="las la-download"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-primary/5  duration-300 border-b border-n30  first:border-t">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/cn-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">123 *** *** 456</p>
                                                <span class="text-xs">Account Number</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">789 *** *** 012</td>
                                    <td class="py-3">$21,542,145</td>
                                    <td class="py-3">Paypal</td>
                                    <td class="py-3">04/15/2029</td>
                                    <td class="py-3">11:30 AM</td>
                                    <td class="py-3">
                                        <span
                                            class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                            Cancelled
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="flex justify-center">
                                            <button>
                                                <i class="las la-download"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-primary/5  duration-300 border-b border-n30  first:border-t">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/uk-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">123 *** *** 456</p>
                                                <span class="text-xs">Account Number</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">789 *** *** 012</td>
                                    <td class="py-3">$21,542,145</td>
                                    <td class="py-3">Paypal</td>
                                    <td class="py-3">04/15/2029</td>
                                    <td class="py-3">11:30 AM</td>
                                    <td class="py-3">
                                        <span
                                            class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                            Successful
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="flex justify-center">
                                            <button>
                                                <i class="las la-download"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-primary/5  duration-300 border-b border-n30  first:border-t">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/rs-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">123 *** *** 456</p>
                                                <span class="text-xs">Account Number</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">789 *** *** 012</td>
                                    <td class="py-3">$21,542,145</td>
                                    <td class="py-3">Paypal</td>
                                    <td class="py-3">04/15/2029</td>
                                    <td class="py-3">11:30 AM</td>
                                    <td class="py-3">
                                        <span
                                            class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                            Cancelled
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="flex justify-center">
                                            <button>
                                                <i class="las la-download"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-primary/5  duration-300 border-b border-n30  first:border-t">
                                    <td class="py-2 px-6">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32"
                                                class="rounded-full" alt="payment medium icon" />
                                            <div>
                                                <p class="font-medium mb-1">123 *** *** 456</p>
                                                <span class="text-xs">Account Number</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">789 *** *** 012</td>
                                    <td class="py-3">$21,542,145</td>
                                    <td class="py-3">Paypal</td>
                                    <td class="py-3">04/15/2029</td>
                                    <td class="py-3">11:30 AM</td>
                                    <td class="py-3">
                                        <span
                                            class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                            Successful
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="flex justify-center">
                                            <button>
                                                <i class="las la-download"></i>
                                            </button>
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