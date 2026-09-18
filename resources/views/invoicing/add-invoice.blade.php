@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Add New Invoice</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="box mb-4 3xl:mb-6">
            <div class="mb-6 pb-6 bb-dashed flex justify-between items-center">
                <h4 class="h4">Add New Invoice</h4>
                @include('partials._horizontal-options')

            </div>
            <form class="flex flex-col gap-6">
                <div class="box bg-secondary/5  xl:p-8 grid grid-cols-2 gap-4 xxl:gap-6">
                    <div class="col-span-2 flex justify-center items-center gap-6">
                        <div class="w-full h-px bg-secondary bg-opacity-[0.15]"></div>
                        <span class="btn-white  text-secondary font-semibold hover:text-secondary">
                            Template
                        </span>
                        <div class="w-full h-px bg-secondary bg-opacity-[0.15] "></div>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="template" class="mb-4 md:text-lg font-medium block">
                            Template
                        </label>
                        <select name="sort" class="nc-select full !bg-n0  ">
                            <option value="paypal">Web Design</option>
                            <option value="visa">Marketing</option>
                            <option value="mastercard">UI/UX Design</option>
                        </select>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="category" class="mb-4 md:text-lg font-medium block">
                            Category
                        </label>
                        <select name="sort" class="nc-select full !bg-n0   ">
                            <option value="paypal">Design</option>
                            <option value="visa">Development</option>
                            <option value="mastercard">Uncategorized</option>
                        </select>
                    </div>
                </div>

                <div class="box bg-secondary/5  xl:p-8 grid grid-cols-2 gap-4 xxl:gap-6">
                    <div class="col-span-2 flex justify-center items-center gap-6">
                        <div class="w-full h-px bg-secondary bg-opacity-[0.15]"></div>
                        <span class="btn-white  shrink-0 text-secondary font-semibold hover:text-secondary">
                            Company Details
                        </span>
                        <div class="w-full h-px bg-secondary bg-opacity-[0.15] "></div>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="invoice" class="md:text-lg font-medium block mb-4">
                            Invoice Number
                        </label>
                        <input type="number"
                            class="w-full text-sm  bg-n0  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Number" id="invoice" required />
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="date" class="md:text-lg font-medium block mb-4">
                            Due Date
                        </label>
                        <div class="relative bg-n0 py-2.5  border border-n30  rounded-3xl">
                            <input type="date" class="border-none w-full px-4" placeholder="Select Date" autocomplete="off" />
                        </div>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="name" class="md:text-lg font-medium block mb-4">
                            Company Name
                        </label>
                        <input type="text"
                            class="w-full text-sm  bg-n0  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Name" id="name" required />
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="address" class="md:text-lg font-medium block mb-4">
                            Enter Address
                        </label>
                        <input type="text"
                            class="w-full text-sm  bg-n0  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Address" id="address" required />
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="email" class="md:text-lg font-medium block mb-4">
                            Contact Email
                        </label>
                        <input type="email"
                            class="w-full text-sm  bg-n0  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Email" id="email" required />
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="number" class="md:text-lg font-medium block mb-4">
                            Contact Number
                        </label>
                        <input type="number"
                            class="w-full text-sm  bg-n0  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Email" id="number" required />
                    </div>
                </div>
                <div class="box bg-secondary/5  xl:p-8 grid grid-cols-2 gap-4 xxl:gap-6">
                    <div class="col-span-2 flex justify-center items-center gap-6">
                        <div class="w-full h-px bg-secondary bg-opacity-[0.15]"></div>
                        <span class="btn-white  shrink-0 text-secondary font-semibold hover:text-secondary">
                            Service
                        </span>
                        <div class="w-full h-px bg-secondary bg-opacity-[0.15] "></div>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="money" class="md:text-lg font-medium block mb-4">
                            Enter Money
                        </label>
                        <input type="number"
                            class="w-full text-sm  bg-n0  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Money" id="money" required />
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="rate" class="md:text-lg font-medium block mb-4">
                            Rate
                        </label>
                        <input type="number"
                            class="w-full text-sm  bg-n0  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Rate" id="rate" required />
                    </div>
                    <div class="col-span-2">
                        <label for="desc" class="md:text-lg font-medium block mb-4">
                            Enter Description
                        </label>
                        <textarea
                            class="w-full text-sm  bg-n0  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Description..." rows="5" id="desc" required></textarea>
                    </div>
                </div>

                <div class="flex gap-4 md:gap-6 mt-2">
                    <button class="btn-primary type=" submit">
                        Send Invoice
                    </button>
                    <button class="btn-outline">Save as Draft</button>
                </div>
            </form>
        </div>
    </div>
@endsection