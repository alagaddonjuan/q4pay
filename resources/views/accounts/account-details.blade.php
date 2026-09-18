@extends('layout.main')

@section('content')
  <div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
      <h2 class="h2">Account Details</h2>
      <button class="btn-primary ac-modal-btn">
        <i class="las la-plus-circle text-base md:text-lg"></i>
        Open an Account
      </button>
    </div>

    <div class="grid grid-cols-12 gap-4 xxl:gap-6">
      <!-- Payment Account -->
      <div class="box col-span-12 md:col-span-7 xxl:col-span-8">
        <div class="flex justify-between items-center gap-4 flex-wrap bb-dashed mb-4 pb-4 3xl:">
          <h4 class="h4">Payment Account</h4>
          <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
            <form
              class="bg-primary/5 datatable-search  border border-n30  flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
              <input type="text" placeholder="Search"
                class="bg-transparent text-sm ltr:pl-4 rtl:pr-4 py-1 w-full border-none" id="account-details-search" />
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
          <table class="w-full whitespace-nowrap" id="account-details">
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
                <th class="text-start py-5 min-w-[160px] cursor-pointer">
                  <div class="flex items-center gap-1">
                    Account Balance
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
                    <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32" class="rounded-full"
                      alt="payment medium icon" />
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
                    <p class="font-medium">
                      $1.121,212
                    </p>
                    <span class="text-xs">Account Balance</span>
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
              <tr class="even:bg-secondary/5 ">
                <td class="py-2 px-6">
                  <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/cn-sm.png') }}" width="32" height="32" class="rounded-full"
                      alt="payment medium icon" />
                    <div>
                      <p class="font-medium mb-1">999 *** *** 123</p>
                      <span class="text-xs">Account Number</span>
                    </div>
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
                    <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32" class="rounded-full"
                      alt="payment medium icon" />
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
                    <p class="font-medium">
                      $1.121,212
                    </p>
                    <span class="text-xs">Account Balance</span>
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
              <tr class="even:bg-secondary/5 ">
                <td class="py-2 px-6">
                  <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32" class="rounded-full"
                      alt="payment medium icon" />
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
                    <p class="font-medium">
                      $1.121,212
                    </p>
                    <span class="text-xs">Account Balance</span>
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
              <tr class="even:bg-secondary/5 ">
                <td class="py-2 px-6">
                  <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/euro-sm.png') }}" width="32" height="32" class="rounded-full"
                      alt="payment medium icon" />
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
                    <p class="font-medium">
                      $1.821,222
                    </p>
                    <span class="text-xs">Account Balance</span>
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
              <tr class="even:bg-secondary/5 ">
                <td class="py-2 px-6">
                  <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32" class="rounded-full"
                      alt="payment medium icon" />
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
                    <p class="font-medium">
                      $1.121,212
                    </p>
                    <span class="text-xs">Account Balance</span>
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
              <tr class="even:bg-secondary/5 ">
                <td class="py-2 px-6">
                  <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/jp-sm.png') }}" width="32" height="32" class="rounded-full"
                      alt="payment medium icon" />
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
                    <p class="font-medium">
                      $1.121,212
                    </p>
                    <span class="text-xs">Account Balance</span>
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
              <tr class="even:bg-secondary/5 ">
                <td class="py-2 px-6">
                  <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/uk-sm.png') }}" width="32" height="32" class="rounded-full"
                      alt="payment medium icon" />
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
                    <p class="font-medium">
                      $1.121,212
                    </p>
                    <span class="text-xs">Account Balance</span>
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
              <tr class="even:bg-secondary/5 ">
                <td class="py-2 px-6">
                  <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/usa-sm.png') }}" width="32" height="32" class="rounded-full"
                      alt="payment medium icon" />
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
                    <p class="font-medium">
                      $1.121,212
                    </p>
                    <span class="text-xs">Account Balance</span>
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
              <tr class="even:bg-secondary/5 ">
                <td class="py-2 px-6">
                  <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/euro-sm.png') }}" width="32" height="32" class="rounded-full"
                      alt="payment medium icon" />
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
                    <p class="font-medium">
                      $1.821,222
                    </p>
                    <span class="text-xs">Account Balance</span>
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
      <!-- Account Details -->
      <div class="box col-span-12 md:col-span-5 xxl:col-span-4">
        <div class="bb-dashed pb-4 mb-4 3xl: flex justify-between items-center">
          <h4 class="h4">Account Details</h4>
          <select name="sort" class="nc-select green min-w-[120px]">
            <option value="day">Visa</option>
            <option value="week">Payoneer</option>
            <option value="year">Mastercard</option>
          </select>
        </div>
        <div class="bb-dashed pb-4 mb-4 3xl: flex flex-col">
          <div
            class="bg-primary p-4 lg:px-6 lg:py-5 rounded-xl text-n0 relative overflow-hidden after:absolute after:rounded-full after:w-[300px] after:h-[300px] after:bg-[#FFC861] after:top-[40%] after:ltr:left-[65%] after:rtl:right-[65%] mb-6 lg:mb-8">
            <div class="flex justify-between items-start mb-14">
              <div>
                <p class="text-xs mb-1">Current Balance</p>
                <h4 class="h4">80,700.00 USD</h4>
              </div>
              <img src="{{ asset('assets/images/visa-sm.png') }}" width="45" height="16" alt="visa icon" />
            </div>
            <div class="flex justify-between items-end">
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
          <p class="text-lg font-medium mb-6">Active card</p>
          <div
            class="border border-primary border-dashed bg-primary/5 justify-between  rounded-lg p-3 flex items-center gap-4 mb-6 lg:mb-8">
            <div class="grow flex items-center gap-4">
              <img src="{{ asset('assets/images/card-sm-1.png') }}" width="60" height="40" alt="card" />
              <div>
                <p class="font-medium mb-1">John Snow - Metal</p>
                <span class="text-xs">**4291 - Exp: 12/26</span>
              </div>
            </div>
            <p>= 10,000 BTC</p>
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
  </div>
@endsection