@extends('layout.main')

@section('content')
  <div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
      <h2 class="h2">Exchange</h2>
      <button class="btn-primary ac-modal-btn">
        <i class="las la-plus-circle text-base md:text-lg"></i>
        Open an Account
      </button>
    </div>

    <div class="grid grid-cols-12 gap-4 xxl:gap-6">
      <div class="col-span-12 md:col-span-7 xxl:col-span-8">
        <div class="col-span-12 box overflow-x-hidden">
          <div class="flex justify-between flex-wrap gap-3 items-center bb-dashed mb-4 pb-4">
            <h4 class="h4">USD to EUR Chart</h4>
            <div class="rounded-lg border border-n30 bg-primary/5 ">
              <button id="one_month" class="asset-btn px-4 py-2 text-xs font-medium first:rounded-s-lg last:rounded-e-lg">
                1M
              </button>
              <button id="six_months"
                class="asset-btn px-4 py-2 text-xs font-medium first:rounded-s-lg last:rounded-e-lg">
                6M
              </button>
              <button id="one_year"
                class="asset-btn active px-4 py-2 text-xs font-medium first:rounded-s-lg last:rounded-e-lg">
                1Y
              </button>
              <button id="ytd" class="asset-btn px-4 py-2 text-xs font-medium first:rounded-s-lg last:rounded-e-lg">
                YTD
              </button>
              <button id="all" class="asset-btn px-4 py-2 text-xs font-medium first:rounded-s-lg last:rounded-e-lg">
                all
              </button>
            </div>
          </div>
          <div class="mb-6 lg:mb-8">
            <p class="mb-3 date-time"></p>
            <h2 class="h2">1 USD = 2.93 EUR</h2>
          </div>
          <div class="usdeuro-chart"></div>
        </div>
      </div>
      <div class="col-span-12 md:col-span-5 xxl:col-span-4">
        <div class="box">
          <div class="bb-dashed pb-4 mb-4 3xl: flex justify-between items-center">
            <p class="font-medium">Quick Exchange</p>
            @include('partials._horizontal-options')

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
              Exchange Now
            </a>
          </div>
        </div>
      </div>
      <div class="col-span-12">
        <div class="box col-span-12 lg:col-span-6">
          <div class="flex flex-wrap gap-4  justify-between items-center bb-dashed mb-4 pb-4 3xl:">
            <h4 class="h4">Total Exchange</h4>
            <div class="flex items-center gap-4">
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
                <tr class="bg-secondary/5 ">
                  <th class="text-start py-5 px-6 min-w-[180px] cursor-pointer">
                    <div class="flex items-center gap-1">
                      Currency
                    </div>
                  </th>
                  <th class="text-start py-5 min-w-[130px] cursor-pointer">
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
                      <span class="font-medium">USD</span>
                      <i class="las la-arrow-right"></i>
                      <span class="font-medium">EUR</span>
                    </div>
                  </td>
                  <td class="py-5">$7000.00</td>
                  <td class="py-5">
                    <span>Paypal</span>
                  </td>
                  <td class="py-5">12/05/2025</td>
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
                      <span class="font-medium">USD</span>
                      <i class="las la-arrow-right"></i>
                      <span class="font-medium">EUR</span>
                    </div>
                  </td>
                  <td class="py-5">$7000.00</td>
                  <td class="py-5">
                    <span>Bank Transfer</span>
                  </td>
                  <td class="py-5">12/05/2025</td>
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
                      <span class="font-medium">USD</span>
                      <i class="las la-arrow-right"></i>
                      <span class="font-medium">EUR</span>
                    </div>
                  </td>
                  <td class="py-5">$7000.00</td>
                  <td class="py-5">
                    <span>Venmo</span>
                  </td>
                  <td class="py-5">12/05/2025</td>
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
                      <span class="font-medium">USD</span>
                      <i class="las la-arrow-right"></i>
                      <span class="font-medium">EUR</span>
                    </div>
                  </td>
                  <td class="py-5">$7000.00</td>
                  <td class="py-5">
                    <span>Credit Card</span>
                  </td>
                  <td class="py-5">12/05/2025</td>
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
                      <span class="font-medium">USD</span>
                      <i class="las la-arrow-right"></i>
                      <span class="font-medium">EUR</span>
                    </div>
                  </td>
                  <td class="py-5">$7000.00</td>
                  <td class="py-5">
                    <span>Wire Transfer</span>
                  </td>
                  <td class="py-5">12/05/2025</td>
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
                      <span class="font-medium">USD</span>
                      <i class="las la-arrow-right"></i>
                      <span class="font-medium">EUR</span>
                    </div>
                  </td>
                  <td class="py-5">$7000.00</td>
                  <td class="py-5">
                    <span>Google Pay</span>
                  </td>
                  <td class="py-5">12/05/2025</td>
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
                      <span class="font-medium">USD</span>
                      <i class="las la-arrow-right"></i>
                      <span class="font-medium">EUR</span>
                    </div>
                  </td>
                  <td class="py-5">$7000.00</td>
                  <td class="py-5">
                    <span>Direct Deposit</span>
                  </td>
                  <td class="py-5">12/05/2025</td>
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
                      <span class="font-medium">USD</span>
                      <i class="las la-arrow-right"></i>
                      <span class="font-medium">EUR</span>
                    </div>
                  </td>
                  <td class="py-5">$7000.00</td>
                  <td class="py-5">
                    <span>Paypal</span>
                  </td>
                  <td class="py-5">12/05/2025</td>
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