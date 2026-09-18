@extends('layout.main')

@section('content')
  <div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
      <h2 class="h2">Make a Payment</h2>
      <button class="btn-primary ac-modal-btn">
        <i class="las la-plus-circle text-base md:text-lg"></i>
        Open an Account
      </button>
    </div>

    <div class="box mb-4 3xl:mb-6">
      <div class="mb-6 pb-6 bb-dashed flex justify-between items-center">
        <h4 class="h4">Make a Payment</h4>
        @include('partials._horizontal-options')

      </div>
      <form class="grid grid-cols-2 gap-4 3xl:gap-6">
        <div class="col-span-2 md:col-span-1">
          <label for="name" class="mb-4 md:text-lg font-medium block">
            Name
          </label>
          <input type="text"
            class="w-full text-sm  bg-secondary/5  !border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
            placeholder="Enter name" id="name" required />
        </div>
        <div class="col-span-2 md:col-span-1">
          <label for="payfor" class="mb-4 md:text-lg font-medium block">
            Pay For
          </label>
          <select name="sort" class="nc-select full">
            <option value="day">National Grid</option>
            <option value="week">Electricity</option>
            <option value="year">Natural Gas</option>
          </select>
        </div>
        <div class="col-span-2 md:col-span-1">
          <label for="account" class="mb-4 md:text-lg font-medium block">
            Enter Account
          </label>
          <input type="number"
            class="w-full text-sm  bg-secondary/5  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
            placeholder="Enter Account" id="account" required />
        </div>
        <div class="col-span-2 md:col-span-1">
          <label for="currency" class="mb-4 md:text-lg font-medium block">
            Currency
          </label>
          <select name="sort" class="nc-select full ">
            <option value="usd">USD</option>
            <option value="gbp">GBP</option>
            <option value="eur">EUR</option>
          </select>
        </div>
        <div class="col-span-2 md:col-span-1">
          <label for="medium" class="mb-4 md:text-lg font-medium block">
            Select Medium
          </label>
          <select name="sort" class="nc-select full ">
            <option value="paypal">Paypal</option>
            <option value="visa">Visa</option>
            <option value="mastercard">Mastercard</option>
          </select>
        </div>
        <div class="col-span-2 md:col-span-1">
          <label for="date" class="md:text-lg font-medium block mb-4">
            Date
          </label>
          <div class="relative bg-secondary/5  border py-2.5 border-n30  rounded-3xl">
            <input type="date" class="border-none w-full px-4" placeholder="Select Date" autocomplete="off" />
          </div>
        </div>

        <div class="col-span-2 md:col-span-1">
          <label for="number" class="md:text-lg font-medium block mb-4">
            Phone Number
          </label>
          <input type="number"
            class="w-full text-sm  bg-secondary/5  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
            placeholder="Enter Number" id="number" required />
        </div>
        <div class="col-span-2 md:col-span-1">
          <label for="amount" class="md:text-lg font-medium block mb-4">
            Amount
          </label>
          <input type="number"
            class="w-full text-sm  bg-secondary/5  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
            placeholder="Enter Amount" id="amount" required />
        </div>
        <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
          <button class="btn-primary type=" submit">
            Pay Now
          </button>
          <button class="btn-outline" type="reset">
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection