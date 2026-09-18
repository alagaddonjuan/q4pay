@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Transaction Style 02</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <!-- Latest Transactions -->
        <div class="box col-span-12 lg:col-span-6">
            <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 3xl:">
                <h4 class="h4">Latest Transaction</h4>
                <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                    <form
                        class="bg-primary/5  border border-n30  flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                        <input type="text" id="transaction-search" placeholder="Search"
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
            <div class="overflow-x-auto pb-4 lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-primary/5 ">
                            <th class="text-start !px-6 w-14 py-5" data-sortable="false">
                                <input name="allSelect" id="selectAllCheckbox" type="checkbox" class=" accent-secondary" />
                            </th>
                            <th class="text-start py-5 px-6 min-w-[310px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Title
                                </div>
                            </th>
                            <th class="text-start py-5 min-w-[100px]" data-sortable="false">Invoice</th>
                            <th class="text-start py-5 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Medium
                                </div>
                            </th>
                            <th class="text-start py-5 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Transaction
                                </div>
                            </th>
                            <th class="text-start py-5 cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Status
                                </div>
                            </th>
                            <th class="text-center py-5" data-sortable="false">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-n30 ">
                            <td class="text-start !px-6">
                                <input type="checkbox" class=" accent-secondary" />
                            </td>
                            <td class="py-2 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                        class="rounded-full" alt="payment medium icon" />
                                    <div>
                                        <p class="font-medium mb-1">Globex Corporation INV-24398</p>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2">#521414</td>
                            <td class="py-2">Paypal</td>
                            <td class="py-2"> $8,521,212</td>
                            <td class="py-2">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-warning/10  text-warning">
                                    Pending
                                </span>
                            </td>
                            <td class="py-2">
                                <div class="flex justify-center">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-n30 ">
                            <td class="text-start !px-6">
                                <input type="checkbox" class=" accent-secondary" />
                            </td>
                            <td class="py-2 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                        class="rounded-full" alt="payment medium icon" />
                                    <div>
                                        <p class="font-medium mb-1">Hooli INV-79820</p>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2">#521414</td>
                            <td class="py-2">Paypal</td>
                            <td class="py-2"> $8,521,212</td>
                            <td class="py-2">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                    Cancelled
                                </span>
                            </td>
                            <td class="py-2">
                                <div class="flex justify-center">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-n30 ">
                            <td class="text-start !px-6">
                                <input type="checkbox" class=" accent-secondary" />
                            </td>
                            <td class="py-2 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/payoneer.png') }}" width="32" height="32"
                                        class="rounded-full" alt="payment medium icon" />
                                    <div>
                                        <p class="font-medium mb-1">Initech INV-24398</p>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2">#521414</td>
                            <td class="py-2">Paypal</td>
                            <td class="py-2"> $8,521,212</td>
                            <td class="py-2">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                    Successful
                                </span>
                            </td>
                            <td class="py-2">
                                <div class="flex justify-center">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-n30 ">
                            <td class="text-start !px-6">
                                <input type="checkbox" class=" accent-secondary" />
                            </td>
                            <td class="py-2 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/visa.png') }}" width="32" height="32"
                                        class="rounded-full" alt="payment medium icon" />
                                    <div>
                                        <p class="font-medium mb-1">Trade Corp INV-24398</p>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2">#521414</td>
                            <td class="py-2">Paypal</td>
                            <td class="py-2"> $8,521,212</td>
                            <td class="py-2">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                    Cancelled
                                </span>
                            </td>
                            <td class="py-2">
                                <div class="flex justify-center">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-n30 ">
                            <td class="text-start !px-6">
                                <input type="checkbox" class=" accent-secondary" />
                            </td>
                            <td class="py-2 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                        class="rounded-full" alt="payment medium icon" />
                                    <div>
                                        <p class="font-medium mb-1">Massive Dynamic INV-24398</p>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2">#521414</td>
                            <td class="py-2">Paypal</td>
                            <td class="py-2"> $8,521,212</td>
                            <td class="py-2">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-warning/10  text-warning">
                                    Pending
                                </span>
                            </td>
                            <td class="py-2">
                                <div class="flex justify-center">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-n30 ">
                            <td class="text-start !px-6">
                                <input type="checkbox" class=" accent-secondary" />
                            </td>
                            <td class="py-2 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                        class="rounded-full" alt="payment medium icon" />
                                    <div>
                                        <p class="font-medium mb-1">Jack Collingwood INV-24398</p>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2">#521414</td>
                            <td class="py-2">Paypal</td>
                            <td class="py-2"> $8,521,212</td>
                            <td class="py-2">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                    Cancelled
                                </span>
                            </td>
                            <td class="py-2">
                                <div class="flex justify-center">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-n30 ">
                            <td class="text-start !px-6">
                                <input type="checkbox" class=" accent-secondary" />
                            </td>
                            <td class="py-2 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                        class="rounded-full" alt="payment medium icon" />
                                    <div>
                                        <p class="font-medium mb-1">Globex Corporation INV-24398</p>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2">#521414</td>
                            <td class="py-2">Paypal</td>
                            <td class="py-2"> $8,521,212</td>
                            <td class="py-2">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-warning/10  text-warning">
                                    Pending
                                </span>
                            </td>
                            <td class="py-2">
                                <div class="flex justify-center">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-n30 ">
                            <td class="text-start !px-6">
                                <input type="checkbox" class=" accent-secondary" />
                            </td>
                            <td class="py-2 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                        class="rounded-full" alt="payment medium icon" />
                                    <div>
                                        <p class="font-medium mb-1">Hooli INV-79820</p>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2">#521414</td>
                            <td class="py-2">Paypal</td>
                            <td class="py-2"> $8,521,212</td>
                            <td class="py-2">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                    Successful
                                </span>
                            </td>
                            <td class="py-2">
                                <div class="flex justify-center">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-n30 ">
                            <td class="text-start !px-6">
                                <input type="checkbox" class=" accent-secondary" />
                            </td>
                            <td class="py-2 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                        class="rounded-full" alt="payment medium icon" />
                                    <div>
                                        <p class="font-medium mb-1">Jack Collingwood INV-24398</p>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2">#521414</td>
                            <td class="py-2">Paypal</td>
                            <td class="py-2"> $8,521,212</td>
                            <td class="py-2">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                    Cancelled
                                </span>
                            </td>
                            <td class="py-2">
                                <div class="flex justify-center">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-n30 ">
                            <td class="text-start !px-6">
                                <input type="checkbox" class=" accent-secondary" />
                            </td>
                            <td class="py-2 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                        class="rounded-full" alt="payment medium icon" />
                                    <div>
                                        <p class="font-medium mb-1">Globex Corporation INV-24398</p>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2">#521414</td>
                            <td class="py-2">Paypal</td>
                            <td class="py-2"> $8,521,212</td>
                            <td class="py-2">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-warning/10  text-warning">
                                    Pending
                                </span>
                            </td>
                            <td class="py-2">
                                <div class="flex justify-center">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-n30 ">
                            <td class="text-start !px-6">
                                <input type="checkbox" class=" accent-secondary" />
                            </td>
                            <td class="py-2 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                        class="rounded-full" alt="payment medium icon" />
                                    <div>
                                        <p class="font-medium mb-1">Hooli INV-79820</p>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2">#521414</td>
                            <td class="py-2">Paypal</td>
                            <td class="py-2"> $8,521,212</td>
                            <td class="py-2">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                    Successful
                                </span>
                            </td>
                            <td class="py-2">
                                <div class="flex justify-center">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-n30 ">
                            <td class="text-start !px-6">
                                <input type="checkbox" class=" accent-secondary" />
                            </td>
                            <td class="py-2 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                        class="rounded-full" alt="payment medium icon" />
                                    <div>
                                        <p class="font-medium mb-1">Jack Collingwood INV-24398</p>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2">#521414</td>
                            <td class="py-2">Paypal</td>
                            <td class="py-2"> $8,521,212</td>
                            <td class="py-2">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                    Cancelled
                                </span>
                            </td>
                            <td class="py-2">
                                <div class="flex justify-center">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-n30 ">
                            <td class="text-start !px-6">
                                <input type="checkbox" class=" accent-secondary" />
                            </td>
                            <td class="py-2 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                        class="rounded-full" alt="payment medium icon" />
                                    <div>
                                        <p class="font-medium mb-1">Globex Corporation INV-24398</p>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2">#521414</td>
                            <td class="py-2">Paypal</td>
                            <td class="py-2"> $8,521,212</td>
                            <td class="py-2">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-warning/10  text-warning">
                                    Pending
                                </span>
                            </td>
                            <td class="py-2">
                                <div class="flex justify-center">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b border-n30 ">
                            <td class="text-start !px-6">
                                <input type="checkbox" class=" accent-secondary" />
                            </td>
                            <td class="py-2 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('assets/images/paypal.png') }}" width="32" height="32"
                                        class="rounded-full" alt="payment medium icon" />
                                    <div>
                                        <p class="font-medium mb-1">Hooli INV-79820</p>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-2">#521414</td>
                            <td class="py-2">Paypal</td>
                            <td class="py-2"> $8,521,212</td>
                            <td class="py-2">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                    Successful
                                </span>
                            </td>
                            <td class="py-2">
                                <div class="flex justify-center">
                                    @include('partials._horizontal-options-two')
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
@endsection

@section('page-modal')
    <div class="tn-modal fixed inset-0 z-99 modalhide overflow-y-auto bg-n900/80 duration-500">
        <div class="overflow-y-auto">
            <div
                class="modal box modal-inner absolute left-1/2 my-10 max-h-[90vh] w-[95%] max-w-[496px] -translate-x-1/2 overflow-y-auto duration-300 xl:p-8">
                <div class="relative">
                    <button class="tn-modal-close-btn absolute top-0 ltr:right-0 rtl:left-0">
                        <i class="las la-times"></i>
                    </button>
                    <div class="bb-dashed mb-4 flex items-center justify-between pb-4 3xl:">
                        <h4 class="h4">Transaction Details</h4>
                    </div>
                    <div class="py-3 px-6 bg-secondary/5 flex items-center gap-4 mb-6 lg:mb-8">
                        <img src="{{ asset('assets/images/paypal-big.png') }}" width="56" height="56" alt="paypal icon" />
                        <div>
                            <p class="xm:text-xl font-medium mb-2">Deposit Cash</p>
                            <span class="text-sm">Payment Successful</span>
                        </div>
                    </div>
                    <ul class="flex flex-col gap-4 bb-dashed border-secondary/20 pb-4 mb-4 3xl:">
                        <li class="flex justify-between">
                            <span>Transfer:</span> <span class="font-medium">#555443223</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Send To:</span> <span class="font-medium">Felecia Brown</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Bank Account:</span> <span class="font-medium">Wadk6265dlkd565</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Date:</span> <span class="font-medium">11 August 2024</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Time:</span> <span class="font-medium">10:36 AM</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Card Number:</span> <span class="font-medium">325 *** *** ***</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Amount:</span> <span class="font-medium">25,211.00 USD</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Fee:</span> <span class="font-medium">98 USD</span>
                        </li>
                    </ul>
                    <div class=" bb-dashed border-secondary/20 pb-4 mb-4 3xl:">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d2141.544710579929!2d90.39140680797202!3d23.87599993653183!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1702184930477!5m2!1sen!2sbd"
                            width="100%" height="200" style="border: 0" allowFullScreen={true} loading="lazy"
                            referrerPolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="flex justify-center gap-4 flex-wrap lg:gap-6">
                        <button class="flex items-center gap-2">
                            <i class="las la-download border border-n30  rounded-full bg-primary/5 p-2"></i>
                            <span>Download PDF </span>
                        </button>
                        <button class="flex items-center gap-2">
                            <i class="las la-print border border-n30  rounded-full bg-primary/5 p-2"></i>
                            <span>Print PDF </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection