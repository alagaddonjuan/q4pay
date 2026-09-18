@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Help Center</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="flex flex-col gap-4 xxl:gap-6">
            <!-- Hero -->
            <div class="box xl:p-6 ">
                <div class="box bg-primary/5  xl:p-10 3xl:p-[60px] grid grid-cols-2 gap-4 items-center">
                    <div class="col-span-2 md:col-span-1">
                        <h2 class="display-4 mb-6">How Can We Help You?</h2>
                        <p class="mb-7 lg:mb-10">
                            Welcome to our Help Center! We&apos;re here to provide you with the
                            assistance and information you need.
                        </p>
                        <form
                            class=" datatable-search  border border-n30  gap-3 rounded-[30px] focus-within:border-primary p-2 items-center justify-between min-w-[200px] bg-n0  xxl:max-w-[610px] max-w-[300px] flex w-full ">
                            <input type="text" placeholder="Search"
                                class="bg-transparent text-sm border-none ltr:pl-4 rtl:pr-4 py-1 w-full"
                                id="payment-account-search" />
                            <button
                                class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                                <i class="las la-search text-lg"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-span-2 md:col-span-1 flex justify-center md:justify-end">
                        <img src="{{ asset('assets/images/help-center.png') }}" width="384" height="325"
                            alt="help center img" />
                    </div>
                </div>
            </div>
            <!-- Product Info -->
            <div class="box xl:p-8">
                <div class="flex justify-between items-center bb-dashed mb-4 pb-4 3xl:">
                    <h4 class="h4">Product Info</h4>
                    @include('partials._horizontal-options')

                </div>
                <div class="grid grid-cols-12 gap-4 xxl:gap-6">
                    <div
                        class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 gap-3 bg-primary/5  border border-n30  flex justify-between items-center">
                        <a href="#" class="flex gap-3 sm:gap-4 xxl:gap-6 items-center">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  text-primary rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                                <i class="text-3xl las la-wallet"></i>
                            </div>
                            <div>
                                <p class="text-lg md:text-xl font-medium mb-1 sm:mb-2">
                                    Wallet
                                </p>
                                <span class="text-xs md:text-sm">The best self-hosted wallet</span>
                            </div>
                        </a>
                        <button
                            class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                            <i class="las la-download text-2xl"></i>
                        </button>
                    </div>
                    <div
                        class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 gap-3 bg-primary/5  border border-n30  flex justify-between items-center">
                        <a href="#" class="flex gap-3 sm:gap-4 xxl:gap-6 items-center">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  text-primary rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                                <i class="text-3xl las la-shopping-cart"></i>
                            </div>
                            <div>
                                <p class="text-lg md:text-xl font-medium mb-1 sm:mb-2">
                                    E-Commerce
                                </p>
                                <span class="text-xs md:text-sm">Accept payment from anyone</span>
                            </div>
                        </a>
                        <button
                            class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                            <i class="las la-download text-2xl"></i>
                        </button>
                    </div>
                    <div
                        class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 gap-3 bg-primary/5  border border-n30  flex justify-between items-center">
                        <a href="#" class="flex gap-3 sm:gap-4 xxl:gap-6 items-center">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  text-primary rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                                <i class="text-3xl las la-cloud"></i>
                            </div>
                            <div>
                                <p class="text-lg md:text-xl font-medium mb-1 sm:mb-2">
                                    Cloud
                                </p>
                                <span class="text-xs md:text-sm">Build the future of payments</span>
                            </div>
                        </a>
                        <button
                            class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                            <i class="las la-download text-2xl"></i>
                        </button>
                    </div>
                    <div
                        class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 gap-3 bg-primary/5  border border-n30  flex justify-between items-center">
                        <a href="#" class="flex gap-3 sm:gap-4 xxl:gap-6 items-center">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  text-primary rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                                <i class="text-3xl las la-globe"></i>
                            </div>
                            <div>
                                <p class="text-lg md:text-xl font-medium mb-1 sm:mb-2">
                                    Online Trading
                                </p>
                                <span class="text-xs md:text-sm">Access our trading terminal</span>
                            </div>
                        </a>
                        <button
                            class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                            <i class="las la-download text-2xl"></i>
                        </button>
                    </div>
                    <div
                        class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 gap-3 bg-primary/5  border border-n30  flex justify-between items-center">
                        <a href="#" class="flex gap-3 sm:gap-4 xxl:gap-6 items-center">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  text-primary rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                                <i class="text-3xl las la-exchange-alt"></i>
                            </div>
                            <div>
                                <p class="text-lg md:text-xl font-medium mb-1 sm:mb-2">
                                    Exchange
                                </p>
                                <span class="text-xs md:text-sm">Access to our exchange</span>
                            </div>
                        </a>
                        <button
                            class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                            <i class="las la-download text-2xl"></i>
                        </button>
                    </div>
                    <div
                        class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 gap-3 bg-primary/5  border border-n30  flex justify-between items-center">
                        <a href="#" class="flex gap-3 sm:gap-4 xxl:gap-6 items-center">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  text-primary rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                                <i class="text-3xl las la-clipboard-list"></i>
                            </div>
                            <div>
                                <p class="text-lg md:text-xl font-medium mb-1 sm:mb-2">
                                    Query &amp; Transactions
                                </p>
                                <span class="text-xs md:text-sm">The best self-hosted wallet</span>
                            </div>
                        </a>
                        <button
                            class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                            <i class="las la-download text-2xl"></i>
                        </button>
                    </div>
                    <div
                        class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 gap-3 bg-primary/5  border border-n30  flex justify-between items-center">
                        <a href="#" class="flex gap-3 sm:gap-4 xxl:gap-6 items-center">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  text-primary rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                                <i class="text-3xl las la-credit-card"></i>
                            </div>
                            <div>
                                <p class="text-lg md:text-xl font-medium mb-1 sm:mb-2">
                                    Card
                                </p>
                                <span class="text-xs md:text-sm">Spend funds, earn rewards</span>
                            </div>
                        </a>
                        <button
                            class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                            <i class="las la-download text-2xl"></i>
                        </button>
                    </div>
                    <div
                        class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 gap-3 bg-primary/5  border border-n30  flex justify-between items-center">
                        <a href="#" class="flex gap-3 sm:gap-4 xxl:gap-6 items-center">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  text-primary rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                                <i class="text-3xl las la-robot"></i>
                            </div>
                            <div>
                                <p class="text-lg md:text-xl font-medium mb-1 sm:mb-2">
                                    Intelligence
                                </p>
                                <span class="text-xs md:text-sm">Power your fintech complance</span>
                            </div>
                        </a>
                        <button
                            class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                            <i class="las la-download text-2xl"></i>
                        </button>
                    </div>
                    <div
                        class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 gap-3 bg-primary/5  border border-n30  flex justify-between items-center">
                        <a href="#" class="flex gap-3 sm:gap-4 xxl:gap-6 items-center">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  text-primary rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                                <i class="text-3xl las la-mobile"></i>
                            </div>
                            <div>
                                <p class="text-lg md:text-xl font-medium mb-1 sm:mb-2">
                                    App downloads
                                </p>
                                <span class="text-xs md:text-sm">Our apps for web and mobile</span>
                            </div>
                        </a>
                        <button
                            class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                            <i class="las la-download text-2xl"></i>
                        </button>
                    </div>
                    <div
                        class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 gap-3 bg-primary/5  border border-n30  flex justify-between items-center">
                        <a href="#" class="flex gap-3 sm:gap-4 xxl:gap-6 items-center">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  text-primary rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                                <i class="text-3xl las la-coins"></i>
                            </div>
                            <div>
                                <p class="text-lg md:text-xl font-medium mb-1 sm:mb-2">
                                    Loans &amp; Credit
                                </p>
                                <span class="text-xs md:text-sm">Applying for Loans or Credit Card</span>
                            </div>
                        </a>
                        <button
                            class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                            <i class="las la-download text-2xl"></i>
                        </button>
                    </div>
                    <div
                        class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 gap-3 bg-primary/5  border border-n30  flex justify-between items-center">
                        <a href="#" class="flex gap-3 sm:gap-4 xxl:gap-6 items-center">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  text-primary rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                                <i class="text-3xl las la-piggy-bank"></i>
                            </div>
                            <div>
                                <p class="text-lg md:text-xl font-medium mb-1 sm:mb-2">
                                    Digital Banking
                                </p>
                                <span class="text-xs md:text-sm">Security Tips for Digital Transactions</span>
                            </div>
                        </a>
                        <button
                            class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                            <i class="las la-download text-2xl"></i>
                        </button>
                    </div>
                    <div
                        class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 gap-3 bg-primary/5  border border-n30  flex justify-between items-center">
                        <a href="#" class="flex gap-3 sm:gap-4 xxl:gap-6 items-center">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  text-primary rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                                <i class="text-3xl las la-handshake"></i>
                            </div>
                            <div>
                                <p class="text-lg md:text-xl font-medium mb-1 sm:mb-2">
                                    Customer Support
                                </p>
                                <span class="text-xs md:text-sm">Contacting Customer Support</span>
                            </div>
                        </a>
                        <button
                            class="w-10 h-10 sm:w-12 sm:h-12 md:w-[60px] md:h-[60px] shrink-0 flex items-center justify-center bg-n0  rounded-full shadow-[0px_6px_40px_0px_rgba(0,0,0,0.02)]">
                            <i class="las la-download text-2xl"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Help articles -->
            <div class="box xl:p-8">
                <div class="flex justify-between flex-wrap items-center gap-4 bb-dashed mb-4 pb-4 3xl:">
                    <h4 class="h4">Popular Help Articles</h4>
                    <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                        <form
                            class="bg-primary/5 datatable-search  border border-n30  flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                            <input type="text" placeholder="Search"
                                class="bg-transparent text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
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
                <div class="grid grid-cols-12 gap-4 xxl:gap-6 bb-dashed mb-4 pb-4 3xl:">
                    <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                        <p class="font-medium mb-3 text-secondary">Scores</p>
                        <a class="h5 mb-4 block text-base font-medium md:text-xl md:font-semibold" href="#">
                            Understanding Credit
                            Scores</a>
                        <p class="text-sm mb-6">Demystify credit scores and their impact on your financial health. Learn
                            how to
                            interpret your credit report</p>
                        <button class="flex items-center gap-2 text-primary">
                            <span class="font-semibold">Download</span><span
                                class="w-7 h-7 shrink-0 bg-n0  flex items-center justify-center rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                    class="las la-download text-lg"></i></span>
                        </button>
                    </div>
                    <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                        <p class="font-medium mb-3 text-secondary">Reporting Fraud</p>
                        <a class="h5 mb-4 block text-base font-medium md:text-xl md:font-semibold" href="#">What You
                            Need to
                            Know</a>
                        <p class="text-sm mb-6">Know the signs of fraudulent activity and understand the steps to report
                            it. Learn
                            how we prioritize your security</p>
                        <button class="flex items-center gap-2 text-primary">
                            <span class="font-semibold">Download</span><span
                                class="w-7 h-7 shrink-0 bg-n0  flex items-center justify-center rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                    class="las la-download text-lg"></i></span>
                        </button>
                    </div>
                    <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                        <p class="font-medium mb-3 text-secondary">Your Guide</p>
                        <a class="h5 mb-4 block text-base font-medium md:text-xl md:font-semibold" href="#">Contacting
                            Customer
                            Support</a>
                        <p class="text-sm mb-6">Find the various channels through which you can reach our customer support
                            team
                            for assistance.</p>
                        <button class="flex items-center gap-2 text-primary">
                            <span class="font-semibold">Download</span><span
                                class="w-7 h-7 shrink-0 bg-n0  flex items-center justify-center rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                    class="las la-download text-lg"></i></span>
                        </button>
                    </div>
                    <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                        <p class="font-medium mb-3 text-secondary">Savings Account</p>
                        <a class="h5 mb-4 block text-base font-medium md:text-xl md:font-semibold" href="#">Choosing
                            the Right
                            Savings Account</a>
                        <p class="text-sm mb-6">Explore the features and benefits of different savings account options to
                            help you
                            make an informed decision that aligns</p>
                        <button class="flex items-center gap-2 text-primary">
                            <span class="font-semibold">Download</span><span
                                class="w-7 h-7 shrink-0 bg-n0  flex items-center justify-center rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                    class="las la-download text-lg"></i></span>
                        </button>
                    </div>
                    <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                        <p class="font-medium mb-3 text-secondary">Fees</p>
                        <a class="h5 mb-4 block text-base font-medium md:text-xl md:font-semibold" href="#">Demystifying
                            Overdraft
                            Fees</a>
                        <p class="text-sm mb-6">Understand how overdraft fees work, how to avoid them, and what to do if
                            you find
                            yourself in an overdraft situation.</p>
                        <button class="flex items-center gap-2 text-primary">
                            <span class="font-semibold">Download</span><span
                                class="w-7 h-7 shrink-0 bg-n0  flex items-center justify-center rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                    class="las la-download text-lg"></i></span>
                        </button>
                    </div>
                    <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                        <p class="font-medium mb-3 text-secondary">Investment</p>
                        <a class="h5 mb-4 block text-base font-medium md:text-xl md:font-semibold" href="#">Investment
                            Basics for
                            Beginners</a>
                        <p class="text-sm mb-6">A beginner's guide to understanding different investment options, risk
                            factors,
                            and potential returns.</p>
                        <button class="flex items-center gap-2 text-primary">
                            <span class="font-semibold">Download</span><span
                                class="w-7 h-7 shrink-0 bg-n0  flex items-center justify-center rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                    class="las la-download text-lg"></i></span>
                        </button>
                    </div>
                    <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                        <p class="font-medium mb-3 text-secondary">Tips</p>
                        <a class="h5 mb-4 block text-base font-medium md:text-xl md:font-semibold" href="#">Credit
                            Card Usage Tips
                            and Tricks</a>
                        <p class="text-sm mb-6">Learn how to maximize the benefits of your credit card while maintaining
                            responsible usage habits.</p>
                        <button class="flex items-center gap-2 text-primary">
                            <span class="font-semibold">Download</span><span
                                class="w-7 h-7 shrink-0 bg-n0  flex items-center justify-center rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                    class="las la-download text-lg"></i></span>
                        </button>
                    </div>
                    <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                        <p class="font-medium mb-3 text-secondary">Tips</p>
                        <a class="h5 mb-4 block text-base font-medium md:text-xl md:font-semibold" href="#">Credit
                            Card Usage Tips
                            and Tricks</a>
                        <p class="text-sm mb-6">Learn how to maximize the benefits of your credit card while maintaining
                            responsible usage habits.</p>
                        <button class="flex items-center gap-2 text-primary">
                            <span class="font-semibold">Download</span><span
                                class="w-7 h-7 shrink-0 bg-n0  flex items-center justify-center rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                    class="las la-download text-lg"></i></span>
                        </button>
                    </div>
                    <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                        <p class="font-medium mb-3 text-secondary">Traveling Card</p>
                        <a class="h5 mb-4 block text-base font-medium md:text-xl md:font-semibold" href="#">Traveling with
                            Your
                            Debit/Credit Card</a>
                        <p class="text-sm mb-6">Tips and precautions for using your cards while traveling to ensure a
                            secure and
                            hassle-free experience.</p>
                        <button class="flex items-center gap-2 text-primary">
                            <span class="font-semibold">Download</span><span
                                class="w-7 h-7 shrink-0 bg-n0  flex items-center justify-center rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                    class="las la-download text-lg"></i></span>
                        </button>
                    </div>
                    <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                        <p class="font-medium mb-3 text-secondary">Imergency Funds</p>
                        <a class="h5 mb-4 block text-base font-medium md:text-xl md:font-semibold" href="#">The
                            Importance of
                            Emergency Funds</a>
                        <p class="text-sm mb-6">Understand why having an emergency fund is crucial for financial stability
                            and how
                            to build one.</p>
                        <button class="flex items-center gap-2 text-primary">
                            <span class="font-semibold">Download</span><span
                                class="w-7 h-7 shrink-0 bg-n0  flex items-center justify-center rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                    class="las la-download text-lg"></i></span>
                        </button>
                    </div>
                    <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                        <p class="font-medium mb-3 text-secondary">Scores</p>
                        <a class="h5 mb-4 block text-base font-medium md:text-xl md:font-semibold" href="#">Understanding
                            Credit
                            Scores</a>
                        <p class="text-sm mb-6">Demystify credit scores and their impact on your financial health. Learn
                            how to
                            interpret your credit report</p>
                        <button class="flex items-center gap-2 text-primary">
                            <span class="font-semibold">Download</span><span
                                class="w-7 h-7 shrink-0 bg-n0  flex items-center justify-center rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                    class="las la-download text-lg"></i></span>
                        </button>
                    </div>
                    <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                        <p class="font-medium mb-3 text-secondary">Reporting Fraud</p>
                        <a class="h5 mb-4 block text-base font-medium md:text-xl md:font-semibold" href="#">What You
                            Need to
                            Know</a>
                        <p class="text-sm mb-6">Know the signs of fraudulent activity and understand the steps to report
                            it. Learn
                            how we prioritize your security</p>
                        <button class="flex items-center gap-2 text-primary">
                            <span class="font-semibold">Download</span><span
                                class="w-7 h-7 shrink-0 bg-n0  flex items-center justify-center rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                    class="las la-download text-lg"></i></span>
                        </button>
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