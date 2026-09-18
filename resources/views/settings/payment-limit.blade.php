@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Payment Limits</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="flex flex-col gap-4 xxl:gap-6">
            <!-- Payment Limits -->
            <div class="box xl:p-8">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 3xl:">
                    <h4 class="h4">Payment Limits</h4>
                    @include('partials._horizontal-options')

                </div>
                <div class="bb-dashed mb-4 flex flex-col gap-4 pb-4 3xl: xxl:gap-6">
                    <div
                        class="flex grow flex-wrap items-center justify-between gap-4 rounded-xl border border-n30 bg-primary/5 p-4   md:p-6 xl:px-8">
                        <div>
                            <p class="mb-2 text-sm">Cash withdrawal</p>
                            <p class="text-xl font-medium">Amount spent and setup</p>
                        </div>
                        <div class="flex grow items-center gap-4 max-sm:flex-wrap sm:justify-end">
                            <h5 class="range whitespace-nowrap text-xl font-medium">
                                <span> $99.00 </span> /
                                <span class="range__value text-primary"> $35.00 </span>
                            </h5>
                            <div class="w-full max-w-[203px] grow" dir="ltr">
                                <form class="range">
                                    <div class="form-group range__slider">
                                        <input type="range" step="1" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex grow flex-wrap items-center justify-between gap-4 rounded-xl border border-n30 bg-primary/5 p-4   md:p-6 xl:px-8">
                        <div>
                            <p class="mb-2 text-sm">Private Transaction</p>
                            <p class="text-xl font-medium">Amount spent and setup</p>
                        </div>
                        <div class="flex grow items-center gap-4 max-sm:flex-wrap sm:justify-end">
                            <h5 class="range whitespace-nowrap text-xl font-medium">
                                <span> $99.00 </span> /
                                <span class="range__value text-primary"> $35.00 </span>
                            </h5>
                            <div class="w-full max-w-[203px] grow" dir="ltr">
                                <form class="range">
                                    <div class="form-group range__slider">
                                        <input type="range" step="1" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex grow flex-wrap items-center justify-between gap-4 rounded-xl border border-n30 bg-primary/5 p-4   md:p-6 xl:px-8">
                        <div>
                            <p class="mb-2 text-sm">Online Payment</p>
                            <p class="text-xl font-medium">Amount spent and setup</p>
                        </div>
                        <div class="flex grow items-center gap-4 max-sm:flex-wrap sm:justify-end">
                            <h5 class="range whitespace-nowrap text-xl font-medium">
                                <span> $99.00 </span> /
                                <span class="range__value text-primary"> $35.00 </span>
                            </h5>
                            <div class="w-full max-w-[203px] grow" dir="ltr">
                                <form class="range">
                                    <div class="form-group range__slider">
                                        <input type="range" step="1" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex gap-4 xl:gap-6">
                    <button class="btn-primary">Save Changes</button>
                    <button class="btn-outline">Cancel</button>
                </div>
            </div>
            <!-- transaction limits -->
            <div class="box xl:p-8">
                <div class="bb-dashed mb-4 flex items-center justify-between pb-4 3xl:">
                    <h4 class="h4">Transaction Limits</h4>
                    @include('partials._horizontal-options')

                </div>
                <div class="bb-dashed mb-4 flex flex-col gap-4 pb-4 3xl: xxl:gap-6">
                    <div
                        class="flex grow flex-wrap items-center justify-between gap-4 rounded-xl border border-n30 bg-primary/5 p-4   md:p-6 xl:px-8">
                        <div>
                            <p class="mb-2 text-sm">One-time purchase in store</p>
                            <p class="text-xl font-medium">Account Limits</p>
                        </div>
                        <div class="flex grow items-center gap-4 max-sm:flex-wrap sm:justify-end">
                            <h5 class="range whitespace-nowrap text-xl font-medium">
                                <span> $99.00 </span> /
                                <span class="range__value text-primary"> $35.00 </span>
                            </h5>
                            <div class="w-full max-w-[203px] grow" dir="ltr">
                                <form class="range">
                                    <div class="form-group range__slider">
                                        <input type="range" step="1" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-primary/5 grow  border rounded-xl gap-4 flex-wrap border-n30  p-4 md:p-6 xl:px-8 flex items-center justify-between">
                        <div>
                            <p class="text-sm mb-2">One-time purchase online</p>
                            <p class="font-medium text-xl">Account Limits </p>
                        </div>
                        <div class="flex items-center max-sm:flex-wrap gap-4 grow sm:justify-end">
                            <h5 class="text-xl font-medium whitespace-nowrap range">
                                <span>
                                    $99.00
                                </span> /
                                <span class="text-primary range__value">
                                    $35.00
                                </span>
                            </h5>
                            <div class="grow max-w-[203px] w-full" dir="ltr">
                                <form class="range">
                                    <div class="form-group range__slider">
                                        <input type="range" step="1">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-primary/5 grow  border rounded-xl gap-4 flex-wrap border-n30  p-4 md:p-6 xl:px-8 flex items-center justify-between">
                        <div>
                            <p class="text-sm mb-2">One-time p2p transfer</p>
                            <p class="font-medium text-xl">Account Limits </p>
                        </div>
                        <div class="flex items-center max-sm:flex-wrap gap-4 grow sm:justify-end">
                            <h5 class="text-xl font-medium whitespace-nowrap range">
                                <span>
                                    $99.00
                                </span> /
                                <span class="text-primary range__value">
                                    $35.00
                                </span>
                            </h5>
                            <div class="grow max-w-[203px] w-full" dir="ltr">
                                <form class="range">
                                    <div class="form-group range__slider">
                                        <input type="range" step="1">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex gap-4 xl:gap-6">
                    <button class="btn-primary">Save Changes</button>
                    <button class="btn-outline">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection