@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Reports Style 01</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            <!-- Statistics -->
            <div class="col-span-12 min-[650px]:col-span-6 3xl:col-span-3 box p-4 4xl:p-8 bg-n0 ">
                <div class="bb-dashed mb-4 pb-4 lg:pb-6 lg:mb-6 flex justify-between items-center">
                    <p class="font-medium">USD</p>
                    @include('partials._horizontal-options')

                </div>
                <div class="flex items-center justify-between gap-4 3xl:gap-6">
                    <div>
                        <h4 class="h4 mb-3">
                            $32,254.00
                        </h4>
                        <span>
                            <span class="text-primary">
                                <i class="las la-arrow-up text-lg"></i> +2.4%
                            </span>
                            Since last month
                        </span>
                    </div>
                    <div class="text-primary"><i class="las la-dollar-sign text-5xl"></i></div>
                </div>
                <div class="rounded-lg h-1 bg-n30  mt-4">
                    <div class="w-3/4 h-1 bg-primary rounded-lg"></div>
                </div>
            </div>
            <div class="col-span-12 min-[650px]:col-span-6 3xl:col-span-3 box p-4 4xl:p-8 bg-n0 ">
                <div class="bb-dashed mb-4 pb-4 lg:pb-6 lg:mb-6 flex justify-between items-center">
                    <p class="font-medium">EUR</p>
                    @include('partials._horizontal-options')

                </div>
                <div class="flex items-center justify-between gap-4 3xl:gap-6">
                    <div>
                        <h4 class="h4 mb-3">
                            €33,450.00
                        </h4>
                        <span>
                            <span class="text-primary">
                                <i class="las la-arrow-up text-lg"></i> +2.4%
                            </span>
                            Since last month
                        </span>
                    </div>
                    <div class="text-primary"><i class="las la-euro-sign text-5xl"></i></div>
                </div>
                <div class="rounded-lg h-1 bg-n30  mt-4">
                    <div class="w-3/4 h-1 bg-primary rounded-lg"></div>
                </div>
            </div>
            <div class="col-span-12 min-[650px]:col-span-6 3xl:col-span-3 box p-4 4xl:p-8 bg-n0 ">
                <div class="bb-dashed mb-4 pb-4 lg:pb-6 lg:mb-6 flex justify-between items-center">
                    <p class="font-medium">GBP</p>
                    @include('partials._horizontal-options')

                </div>
                <div class="flex items-center justify-between gap-4 3xl:gap-6">
                    <div>
                        <h4 class="h4 mb-3">
                            $32,254.00
                        </h4>
                        <span>
                            <span class="text-primary">
                                <i class="las la-arrow-up text-lg"></i> +2.4%
                            </span>
                            Since last month
                        </span>
                    </div>
                    <div class="text-primary"><i class="las la-pound-sign text-5xl"></i></div>
                </div>
                <div class="rounded-lg h-1 bg-n30  mt-4">
                    <div class="w-3/4 h-1 bg-primary rounded-lg"></div>
                </div>
            </div>
            <div class="col-span-12 min-[650px]:col-span-6 3xl:col-span-3 box p-4 4xl:p-8 bg-n0 ">
                <div class="bb-dashed mb-4 pb-4 lg:pb-6 lg:mb-6 flex justify-between items-center">
                    <p class="font-medium">JPY</p>
                    @include('partials._horizontal-options')

                </div>
                <div class="flex items-center justify-between gap-4 3xl:gap-6">
                    <div>
                        <h4 class="h4 mb-3">
                            ¥36,254.00
                        </h4>
                        <span>
                            <span class="text-primary">
                                <i class="las la-arrow-up text-lg"></i> +2.4%
                            </span>
                            Since last month
                        </span>
                    </div>
                    <div class="text-primary"><i class="las la-yen-sign text-5xl"></i></div>
                </div>
                <div class="rounded-lg h-1 bg-n30  mt-4">
                    <div class="w-3/4 h-1 bg-primary rounded-lg"></div>
                </div>
            </div>
            <!-- performance chart -->
            <div class="col-span-12 lg:col-span-6">
                <div class="col-span-12 lg:col-span-6 box overflow-x-hidden">
                    <div class="flex flex-wrap justify-between items-center gap-3 pb-4 lg:pb-6 mb-4 lg:mb-6 bb-dashed">
                        <h4 class="h4">Performance</h4>
                        <div class="flex items-center gap-2">
                            <p class="text-xs sm:text-sm md:text-base">Sort By : </p>
                            <select name="sort" class="nc-select green">
                                <option value="day">Last 15 Days</option>
                                <option value="week">Last 1 Month</option>
                                <option value="year">Last 6 Month</option>
                            </select>
                        </div>
                    </div>
                    <div class="performance-chart"></div>
                </div>
            </div>
            <!-- Monthly rewards -->
            <div class="col-span-12 lg:col-span-6">
                <div class="box xl:p-8">
                    <div class="flex justify-between items-center bb-dashed mb-4 pb-4 3xl:">
                        <h4 class="h4">Monthly Rewards</h4>
                        <div class="relative">
                            <i class="las la-ellipsis-h horiz-option-btn cursor-pointer"></i>
                            <ul
                                class="horiz-option hide absolute top-full z-3 min-w-[122px] rounded-md bg-n0 p-3 shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)] duration-300  ltr:right-0 ltr:origin-top-right rtl:left-0 rtl:origin-top-left">
                                <li>
                                    <span
                                        class="block cursor-pointer rounded px-3 py-1 text-sm leading-normal duration-300 hover:bg-primary/10 ">
                                        Edit
                                    </span>
                                </li>
                                <li>
                                    <span
                                        class="block cursor-pointer rounded px-3 py-1 text-sm leading-normal duration-300 hover:bg-primary/10 ">
                                        Print
                                    </span>
                                </li>
                                <li>
                                    <span
                                        class="block cursor-pointer rounded px-3 py-1 text-sm leading-normal duration-300 hover:bg-primary/10 ">
                                        Share
                                    </span>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="bb-dashed mb-4 pb-4 3xl: flex gap-4 xxl:gap-6 items-center">
                        <div class="text-primary px-3 py-2.5 bg-primary/5  border border-n30  rounded-xl">
                            <i class="las la-dollar-sign text-4xl"></i>
                        </div>
                        <div class="grow">
                            <div class="flex justify-between items-center mb-3">
                                <p class="text-base md:text-lg font-semibold">US Dollar (USD)</p>
                                <span>54</span>
                            </div>
                            <div class="flex gap-2 items-center">
                                <p>45%</p>
                                <div class="rounded-lg grow h-1 bg-primary/5 ">
                                    <div style="width:45%" class="h-1 bg-primary rounded-lg"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bb-dashed mb-4 pb-4 3xl: flex gap-4 xxl:gap-6 items-center">
                        <div class="text-primary px-3 py-2.5 bg-primary/5  border border-n30  rounded-xl">
                            <i class="las la-euro-sign text-4xl"></i>
                        </div>
                        <div class="grow">
                            <div class="flex justify-between items-center mb-3">
                                <p class="text-base md:text-lg font-semibold">Euro (EUR)</p>
                                <span>54</span>
                            </div>
                            <div class="flex gap-2 items-center">
                                <p>62%</p>
                                <div class="rounded-lg grow h-1 bg-primary/5 ">
                                    <div style="width: 62%" class="h-1 bg-primary rounded-lg"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-4  flex gap-4 xxl:gap-6 items-center">
                        <div class="text-primary px-3 py-2.5 bg-primary/5  border border-n30  rounded-xl">
                            <i class="las la-dollar-sign text-4xl"></i>
                        </div>
                        <div class="grow">
                            <div class="flex justify-between items-center mb-3">
                                <p class="text-base md:text-lg font-semibold">British Pound(GBP)</p>
                                <span>54</span>
                            </div>
                            <div class="flex gap-2 items-center">
                                <p>82%</p>
                                <div class="rounded-lg grow h-1 bg-primary/5 ">
                                    <div style="width:82%" class="h-1 bg-primary rounded-lg"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="text-primary font-semibold inline-flex gap-1 items-center mt-4 group" href="#">
                        See More
                        <i class="las la-arrow-right group-hover:pl-2 duration-300"></i>
                    </a>
                </div>
            </div>
            <div class="col-span-12">
                <div class="box col-span-12 lg:col-span-6 overflow-x-hidden">
                    <div class="mb-4 pb-4 xl:pb-6 xl:mb-6 bb-dashed flex justify-between items-center flex-wrap gap-4">
                        <h4 class="h4">US Dollar (USD)</h4>
                        <div class="flex items-center gap-2">
                            <p class="text-xs sm:text-sm md:text-base">Sort By : </p>
                            <select name="sort" class="nc-select green">
                                <option value="day">Last 15 Days</option>
                                <option value="week">Last 1 Month</option>
                                <option value="year">Last 6 Month</option>
                            </select>
                        </div>
                    </div>
                    <div class="usd-chart"></div>
                </div>
            </div>
        </div>
    </div>
@endsection