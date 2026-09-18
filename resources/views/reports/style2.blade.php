@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Reports Style 02</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="box xl:p-8">
            <div class="flex justify-between items-center flex-wrap gap-4 mb-4 pb-4 xl:pb-6 xl:mb-6 bb-dashed font-medium">
                <h4 class="h4">Accounts Overview</h4>
                <div class="flex items-center gap-2">
                    <p class="text-xs sm:text-sm md:text-base">Sort By : </p>
                    <select name="sort" class="nc-select green">
                        <option value="day">Last 15 Days</option>
                        <option value="week">Last 1 Month</option>
                        <option value="year">Last 6 Month</option>
                    </select>
                </div>
            </div>
            <!-- Statistics -->
            <div
                class="box 3xl:p-8 grid grid-cols-12 xxl:divide-x-2 xxl:rtl:divide-x-reverse bg-primary/5  rounded-xl border border-n30  divide-n30 divide-dashed max-xxl:gap-5 mb-4 3xl:mb-6">
                <div
                    class="col-span-12 sm:col-span-6 xxl:col-span-3 flex items-center justify-between overflow-x-hidden xxl:px-6 first:ltr:pl-0 first:rtl:pr-0 last:ltr:pr-0 last:rtl:pl-0 gap-3">
                    <div>
                        <p class="font-medium mb-4">Total Balance</p>
                        <div class="flex gap-2 items-center">
                            <h4 class="h4">$8500</h4>
                            <span class="text-primary text-sm flex items-center gap-1">
                                <i class="las la-arrow-up text-base"></i> 50.8%
                            </span>
                        </div>
                    </div>
                    <div class="reports-stat-chart"></div>
                </div>
                <div
                    class="col-span-12 sm:col-span-6 xxl:col-span-3 flex items-center justify-between overflow-x-hidden xxl:px-6 first:ltr:pl-0 first:rtl:pr-0 last:ltr:pr-0 last:rtl:pl-0 gap-3">
                    <div>
                        <p class="font-medium mb-4">Total Deposits</p>
                        <div class="flex gap-2 items-center">
                            <h4 class="h4">$5500</h4>
                            <span class="text-primary text-sm flex items-center gap-1">
                                <i class="las la-arrow-up text-base"></i> 50.8%
                            </span>
                        </div>
                    </div>
                    <div class="reports-stat-chart"></div>
                </div>
                <div
                    class="col-span-12 sm:col-span-6 xxl:col-span-3 flex items-center justify-between overflow-x-hidden xxl:px-6 first:ltr:pl-0 first:rtl:pr-0 last:ltr:pr-0 last:rtl:pl-0 gap-3">
                    <div>
                        <p class="font-medium mb-4">Yearly In</p>
                        <div class="flex gap-2 items-center">
                            <h4 class="h4">$2500</h4>
                            <span class="text-primary text-sm flex items-center gap-1">
                                <i class="las la-arrow-up text-base"></i> 50.8%
                            </span>
                        </div>
                    </div>
                    <div class="reports-stat-chart"></div>
                </div>
                <div
                    class="col-span-12 sm:col-span-6 xxl:col-span-3 flex items-center justify-between overflow-x-hidden xxl:px-6 first:ltr:pl-0 first:rtl:pr-0 last:ltr:pr-0 last:rtl:pl-0 gap-3">
                    <div>
                        <p class="font-medium mb-4">Yearly Out</p>
                        <div class="flex gap-2 items-center">
                            <h4 class="h4">$3500</h4>
                            <span class="text-primary text-sm flex items-center gap-1">
                                <i class="las la-arrow-up text-base"></i> 50.8%
                            </span>
                        </div>
                    </div>
                    <div class="reports-stat-chart"></div>
                </div>
            </div>
            <!-- Account balance chart -->
            <div class="reports-ac-balance overflow-x-hidden"></div>
        </div>
    </div>
@endsection