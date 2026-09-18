@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Card Overview</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="flex flex-col gap-4 xxl:gap-6">
            <!-- popular cards -->
            <div class="box">
                <div class="bb-dashed border-secondary/20 flex justify-between items-center mb-6 pb-6">
                    <h4 class="h4">Popular Cards</h4>
                    @include('partials._horizontal-options')

                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 4xl:grid-cols-12 gap-4 xxl:gap-6">
                    <a href="{{ route('cards.details') }}" class="bank-card bg-primary">
                        <div class="mb-3 sm:mb-6 flex justify-between items-center">
                            <div>
                                <p class="text-xs mb-1">Deposits Balance</p>
                                <h4 class="h4">80,700</h4>
                            </div>
                            <img src="{{ asset('assets/images/visa-sm.png') }}" width="36" height="13" class="mb-1"
                                alt="visa" />
                        </div>
                        <div>
                            <img src="{{ asset('assets/images/mastercard.png') }}" width="45" height="45" class="mb-1"
                                alt="visa" />
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-semibold mb-1">Felicia Brown</p>
                                    <p class="text-xs">•••• •••• •••• 8854</p>
                                </div>
                                <span class="text-n700 relative z-1">12/27</span>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('cards.details') }}" class="bank-card bg-primary">
                        <div class="mb-3 sm:mb-6 flex justify-between items-center">
                            <div>
                                <p class="text-xs mb-1">Deposits Balance</p>
                                <h4 class="h4">80,700</h4>
                            </div>
                            <img src="{{ asset('assets/images/visa-sm.png') }}" width="36" height="13" class="mb-1"
                                alt="visa" />
                        </div>
                        <div>
                            <img src="{{ asset('assets/images/mastercard.png') }}" width="45" height="45" class="mb-1"
                                alt="visa" />
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-semibold mb-1">Felicia Brown</p>
                                    <p class="text-xs">•••• •••• •••• 8854</p>
                                </div>
                                <span class="text-n700 relative z-1">12/27</span>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('cards.details') }}" class="bank-card bg-[#47264C]">
                        <div class="mb-3 sm:mb-6 flex justify-between items-center">
                            <div>
                                <p class="text-xs mb-1">Deposits Balance</p>
                                <h4 class="h4">80,700</h4>
                            </div>
                            <img src="{{ asset('assets/images/visa-sm.png') }}" width="36" height="13" class="mb-1"
                                alt="visa" />
                        </div>
                        <div>
                            <img src="{{ asset('assets/images/mastercard.png') }}" width="45" height="45" class="mb-1"
                                alt="visa" />
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-semibold mb-1">Felicia Brown</p>
                                    <p class="text-xs">•••• •••• •••• 8854</p>
                                </div>
                                <span class="text-n700 relative z-1">12/27</span>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('cards.details') }}" class="bank-card bg-[#0E777E]">
                        <div class="mb-3 sm:mb-6 flex justify-between items-center">
                            <div>
                                <p class="text-xs mb-1">Deposits Balance</p>
                                <h4 class="h4">80,700</h4>
                            </div>
                            <img src="{{ asset('assets/images/visa-sm.png') }}" width="36" height="13" class="mb-1"
                                alt="visa" />
                        </div>
                        <div>
                            <img src="{{ asset('assets/images/mastercard.png') }}" width="45" height="45" class="mb-1"
                                alt="visa" />
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-semibold mb-1">Felicia Brown</p>
                                    <p class="text-xs">•••• •••• •••• 8854</p>
                                </div>
                                <span class="text-n700 relative z-1">12/27</span>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('cards.details') }}" class="bank-card bg-[#5F4607]">
                        <div class="mb-3 sm:mb-6 flex justify-between items-center">
                            <div>
                                <p class="text-xs mb-1">Deposits Balance</p>
                                <h4 class="h4">80,700</h4>
                            </div>
                            <img src="{{ asset('assets/images/visa-sm.png') }}" width="36" height="13" class="mb-1"
                                alt="visa" />
                        </div>
                        <div>
                            <img src="{{ asset('assets/images/mastercard.png') }}" width="45" height="45" class="mb-1"
                                alt="visa" />
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-semibold mb-1">Felicia Brown</p>
                                    <p class="text-xs">•••• •••• •••• 8854</p>
                                </div>
                                <span class="text-n700 relative z-1">12/27</span>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('cards.details') }}" class="bank-card bg-[#205CB7]">
                        <div class="mb-3 sm:mb-6 flex justify-between items-center">
                            <div>
                                <p class="text-xs mb-1">Deposits Balance</p>
                                <h4 class="h4">80,700</h4>
                            </div>
                            <img src="{{ asset('assets/images/visa-sm.png') }}" width="36" height="13" class="mb-1"
                                alt="visa" />
                        </div>
                        <div>
                            <img src="{{ asset('assets/images/mastercard.png') }}" width="45" height="45" class="mb-1"
                                alt="visa" />
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-semibold mb-1">Felicia Brown</p>
                                    <p class="text-xs">•••• •••• •••• 8854</p>
                                </div>
                                <span class="text-n700 relative z-1">12/27</span>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('cards.details') }}" class="bank-card bg-[#343436]">
                        <div class="mb-3 sm:mb-6 flex justify-between items-center">
                            <div>
                                <p class="text-xs mb-1">Deposits Balance</p>
                                <h4 class="h4">80,700</h4>
                            </div>
                            <img src="{{ asset('assets/images/visa-sm.png') }}" width="36" height="13" class="mb-1"
                                alt="visa" />
                        </div>
                        <div>
                            <img src="{{ asset('assets/images/mastercard.png') }}" width="45" height="45" class="mb-1"
                                alt="visa" />
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-semibold mb-1">Felicia Brown</p>
                                    <p class="text-xs">•••• •••• •••• 8854</p>
                                </div>
                                <span class="text-n700 relative z-1">12/27</span>
                            </div>
                        </div>
                    </a>

                    <div class="col-span-12 bank-card">
                        <button class="bg-primary text-white p-2 rounded-full mb-3">
                            <i class="las la-plus"></i>
                        </button>
                        <p class="font-medium mb-2">Add New Credit Card</p>
                        <button class="text-sm text-primary add-card-btn">
                            Add Now
                        </button>
                    </div>
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
                                    <input type="checkbox" class="accent-secondary" />
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
                                    <input type="checkbox" class="accent-secondary" />
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
                                    <input type="checkbox" class="accent-secondary" />
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
                                    <input type="checkbox" class="accent-secondary" />
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
                                    <input type="checkbox" class="accent-secondary" />
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
                                    <input type="checkbox" class="accent-secondary" />
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
                                    <input type="checkbox" class="accent-secondary" />
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
                                    <input type="checkbox" class="accent-secondary" />
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
    <div class="add-card-modal fixed inset-0 z-99 modalhide overflow-y-auto bg-n900/80 duration-500">
        <div class="overflow-y-auto">
            <div
                class="modal box modal-inner absolute left-1/2 -translate-y-1/2 top-1/2 max-h-[90vh] w-[95%] max-w-[496px] -translate-x-1/2 overflow-y-auto duration-300 xl:p-8">
                <!-- { "translate-y-0 scale-100 opacity-100 my-10": open } -->
                <div class="relative">
                    <button class="add-card-modal-close-btn absolute top-0 ltr:right-0 rtl:left-0">
                        <i class="las la-times"></i>
                    </button>
                    <div class="bb-dashed mb-4 flex items-center justify-between pb-4 3xl:">
                        <h4 class="h4">Create Bank Account</h4>
                    </div>
                    <form>
                        <div class="mt-6 xl:mt-8 grid grid-cols-2 gap-4 3xl:gap-6">
                            <div class="col-span-2">
                                <label for="card-number" class="md:text-lg font-medium block mb-4">
                                    Card Number
                                </label>
                                <div class="bg-secondary/5  border border-n30  rounded-3xl relative">
                                    <input type="number"
                                        class="text-sm w-full px-6 py-2.5 md:py-3 bg-transparent rounded-3xl"
                                        placeholder="5890 - 6858 - 6332 - 9843" id="card-number" required />
                                    <img src="{{ asset('assets/images/mastercard.png') }}"
                                        class="absolute top-1/2 -translate-y-1/2 ltr:right-4 rtl:left-4" width="20"
                                        height="20" alt="mastercard" />
                                </div>
                            </div>
                            <div class="col-span-2">
                                <label for="holder" class="md:text-lg font-medium block mb-4">
                                    Card Holder
                                </label>
                                <input type="text"
                                    class="w-full text-sm bg-secondary/5  border border-n30  rounded-3xl px-6 py-2.5 md:py-3"
                                    placeholder="Enter Name" id="holder" required />
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="month" class="md:text-lg font-medium block mb-4">
                                    Month
                                </label>
                                <input type="number"
                                    class="w-full text-sm bg-secondary/5  border border-n30  rounded-3xl px-6 py-2.5 md:py-3"
                                    placeholder="12" id="month" required />
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label for="year" class="md:text-lg font-medium block mb-4">
                                    Year
                                </label>
                                <input type="number"
                                    class="w-full text-sm bg-secondary/5  border border-n30  rounded-3xl px-6 py-2.5 md:py-3"
                                    placeholder="2027" id="year" required />
                            </div>
                            <div class="col-span-2 mt-4">
                                <button class="btn-primary flex w-full justify-center" type="submit">
                                    Add Card
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection