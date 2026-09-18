@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Payment Providers</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <!-- Payment Providers -->
        <button
            class="md:hidden flex items-center gap-2 min-w-max py-2 px-3 relative z-3 rounded-lg bg-primary text-white chatbtn">
            <i class="las la-bars"></i> <span>Menu</span>
        </button>
        <div class="grid grid-cols-12 relative gap-4 xxl:gap-6 max-md:mt-3 tabs">
            <div id="chat-sidebar" class="max-md:box md:bg-transparent duration-500 max-md:w-[280px] max-md:max-h-[600px]
                                max-md:overflow-y-auto max-md:rounded-xl max-md:absolute ltr:max-md:left-0 rtl:max-md:right-0 z-3 max-md:bg-n0 max-md:
                                max-md:top-0 md:col-span-5 xl:col-span-4 max-md:min-w-[300px] chathide">

                <div class="md:box sticky top-20">
                    <div class="bb-dashed border-secondary/20 mb-4 pb-4 3xl:">
                        <form
                            class="bg-primary/5  border border-n30  flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between w-full">
                            <input type="text" placeholder="Search"
                                class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                            <button
                                class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                                <i class="las la-search text-lg"></i>
                            </button>
                        </form>
                    </div>
                    <ul class="flex flex-col gap-4 lg:gap-6 bb-dashed mb-6 pb-6">
                        <li>
                            <button class="provider-btn tab-link active">
                                <div>
                                    <p class="text-base xxl:text-lg font-medium">
                                        Utilities
                                    </p>
                                    <span class="text-xs">Electricity, gas, water, sewage, trash disposal</span>
                                </div>
                                <span class="icon">
                                    <i class="las la-gas-pump"></i>
                                </span>
                            </button>
                        </li>
                        <li>
                            <button class="provider-btn tab-link">
                                <div>
                                    <p class="text-base xxl:text-lg font-medium">
                                        Saved Templates
                                    </p>
                                    <span class="text-xs">Payment your save template</span>
                                </div>
                                <span class="icon">
                                    <i class="lar la-star"></i>
                                </span>
                            </button>
                        </li>
                        <li>
                            <button class="provider-btn tab-link">
                                <div>
                                    <p class="text-base xxl:text-lg font-medium">
                                        Communication
                                    </p>
                                    <span class="text-xs">Telephone, internet, cable TV</span>
                                </div>
                                <span class="icon">
                                    <i class="las la-tv"></i>
                                </span>
                            </button>
                        </li>
                        <li>
                            <button class="provider-btn tab-link">
                                <div>
                                    <p class="text-base xxl:text-lg font-medium">
                                        Housing
                                    </p>
                                    <span class="text-xs">Rent, mortgage, property taxes, insurance</span>
                                </div>
                                <span class="icon">
                                    <i class="las la-home"></i>
                                </span>
                            </button>
                        </li>
                        <li>
                            <button class="provider-btn tab-link">
                                <div>
                                    <p class="text-base xxl:text-lg font-medium">
                                        Transportation
                                    </p>
                                    <span class="text-xs">Car loan, car insurance, gasoline</span>
                                </div>
                                <span class="icon">
                                    <i class="las la-car"></i>
                                </span>
                            </button>
                        </li>
                        <li>
                            <button class="provider-btn tab-link">
                                <div>
                                    <p class="text-base xxl:text-lg font-medium">
                                        Food
                                    </p>
                                    <span class="text-xs">Groceries, dining out</span>
                                </div>
                                <span class="icon">
                                    <i class="las la-hamburger"></i>
                                </span>
                            </button>
                        </li>
                        <li>
                            <button class="provider-btn tab-link">
                                <div>
                                    <p class="text-base xxl:text-lg font-medium">
                                        Healthcare
                                    </p>
                                    <span class="text-xs">Health insurance, medical bills</span>
                                </div>
                                <span class="icon">
                                    <i class="las la-heartbeat"></i>
                                </span>
                            </button>
                        </li>
                        <li>
                            <button class="provider-btn tab-link">
                                <div>
                                    <p class="text-base xxl:text-lg font-medium">
                                        Education
                                    </p>
                                    <span class="text-xs">Tuition, fees, books, supplies</span>
                                </div>
                                <span class="icon">
                                    <i class="las la-graduation-cap"></i>
                                </span>
                            </button>
                        </li>
                    </ul>
                    <a class="text-primary font-semibold inline-flex gap-1 items-center mt-6 group" href="#">
                        See More
                        <i class="las la-arrow-right group-hover:pl-2 duration-300"></i>
                    </a>
                </div>
            </div>
            <div class="col-span-12 md:col-span-7 xl:col-span-8 box xl:p-8">
                <div class="flex justify-between items-center gap-2 bb-dashed pb-4 mb-4 3xl:">
                    <h4 class="h4">Utility Services</h4>
                    @include('partials._horizontal-options')
                </div>
                <div class="bb-dashed border-secondary/20 mb-4 pb-4 3xl:">
                    <div>
                        <div class="tab-panel active">
                            <div class="grid grid-cols-12 gap-4 xxl:gap-6">
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tint"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Thames Water
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        46.5
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        National Grid
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        54.4
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Electricity
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        57.8
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Natural Gas
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        36.7
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-wifi"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        AT&T Internet
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        25.2
                                    </span>
                                </div>

                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tv"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Spectrum TV
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        27.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tv"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Direct TV
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        27.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Dish Network
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        40.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Duke Energy
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        23.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-ethernet"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Comcast Cable
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        26.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Nextera Energy
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        30.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tint"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        City Water Brand
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        22.2
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-panel hidden">
                            <div class="grid grid-cols-12 gap-4 xxl:gap-6">

                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        National Grid
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        54.4
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-wifi"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        AT&T Internet
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        25.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Electricity
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        57.8
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Natural Gas
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        36.7
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tint"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Thames Water
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        46.5
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tv"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Direct TV
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        27.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Dish Network
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        40.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tv"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Spectrum TV
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        27.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Duke Energy
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        23.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-ethernet"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Comcast Cable
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        26.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Nextera Energy
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        30.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tint"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        City Water Brand
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        22.2
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="tab-panel hidden">
                            <div class="grid grid-cols-12 gap-4 xxl:gap-6">

                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        National Grid
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        54.4
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-wifi"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        AT&T Internet
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        25.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Electricity
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        57.8
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Natural Gas
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        36.7
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tint"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Thames Water
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        46.5
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tv"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Direct TV
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        27.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Dish Network
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        40.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tv"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Spectrum TV
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        27.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Duke Energy
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        23.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-ethernet"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Comcast Cable
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        26.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Nextera Energy
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        30.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tint"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        City Water Brand
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        22.2
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-panel hidden">
                            <div class="grid grid-cols-12 gap-4 xxl:gap-6">

                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-wifi"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        AT&T Internet
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        25.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tv"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Direct TV
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        27.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Dish Network
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        40.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Electricity
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        57.8
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Natural Gas
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        36.7
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tint"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Thames Water
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        46.5
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        National Grid
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        54.4
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tv"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Spectrum TV
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        27.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Duke Energy
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        23.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-ethernet"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Comcast Cable
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        26.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Nextera Energy
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        30.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tint"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        City Water Brand
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        22.2
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-panel hidden">
                            <div class="grid grid-cols-12 gap-4 xxl:gap-6">
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        National Grid
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        54.4
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-wifi"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        AT&T Internet
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        25.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tv"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Direct TV
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        27.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Dish Network
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        40.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Electricity
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        57.8
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Natural Gas
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        36.7
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tint"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Thames Water
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        46.5
                                    </span>
                                </div>

                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tv"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Spectrum TV
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        27.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Duke Energy
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        23.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-ethernet"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Comcast Cable
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        26.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Nextera Energy
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        30.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tint"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        City Water Brand
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        22.2
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-panel hidden">
                            <div class="grid grid-cols-12 gap-4 xxl:gap-6">

                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        National Grid
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        54.4
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-wifi"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        AT&T Internet
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        25.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tv"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Direct TV
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        27.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Electricity
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        57.8
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Natural Gas
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        36.7
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tint"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Thames Water
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        46.5
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Dish Network
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        40.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tv"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Spectrum TV
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        27.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Duke Energy
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        23.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-ethernet"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Comcast Cable
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        26.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Nextera Energy
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        30.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tint"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        City Water Brand
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        22.2
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-panel hidden">
                            <div class="grid grid-cols-12 gap-4 xxl:gap-6">

                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        National Grid
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        54.4
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-wifi"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        AT&T Internet
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        25.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Electricity
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        57.8
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Natural Gas
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        36.7
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tint"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Thames Water
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        46.5
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tv"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Direct TV
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        27.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Dish Network
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        40.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tv"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Spectrum TV
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        27.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Duke Energy
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        23.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-ethernet"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Comcast Cable
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        26.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Nextera Energy
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        30.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tint"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        City Water Brand
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        22.2
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="tab-panel hidden">
                            <div class="grid grid-cols-12 gap-4 xxl:gap-6">

                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        National Grid
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        54.4
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-wifi"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        AT&T Internet
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        25.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tv"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Direct TV
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        27.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Electricity
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        57.8
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Natural Gas
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        36.7
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tint"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Thames Water
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        46.5
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Dish Network
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        40.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tv"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Spectrum TV
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        27.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-gas-pump"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Duke Energy
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        23.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-ethernet"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Comcast Cable
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        26.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-bolt"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        Nextera Energy
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        30.2
                                    </span>
                                </div>
                                <div class="provider-card">
                                    <div class="icon">
                                        <i class="las la-tint"></i>
                                    </div>
                                    <h5 class="h5 font-semibold mb-5 text-center">
                                        City Water Brand
                                    </h5>
                                    <span class="bg-primary py-1 px-3 rounded-lg text-n0">
                                        22.2
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
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