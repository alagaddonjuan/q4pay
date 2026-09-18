@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Transaction Style 03</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <!-- Transaction style 03 -->
        <div class="overflow-x-auto">
            <div class="bg-n0  rounded-xl px-3 min-w-min mb-4 lg:mb-6">
                <table cell-padding="0" cell-spacing="0" style="border-spacing: 0px 12px;"
                    class="w-full whitespace-nowrap p-0 border-none border-separate">
                    <tbody>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    01
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/paypal.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-error/10  text-error">
                                        Cancelled
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    02
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/paypal.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-error/10  text-error">
                                        Cancelled
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    03
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/visa.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-warning/10  text-warning">
                                        Pending
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    04
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/paypal.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-error/10  text-error">
                                        Cancelled
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    05
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/visa.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-warning/10  text-warning">
                                        Pending
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    06
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/paypal.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-primary/10  text-primary">
                                        Successful
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    07
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/payoneer.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-primary/10  text-primary">
                                        Successful
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    08
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/paypal.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-warning/10  text-warning">
                                        Pending
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    09
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/payoneer.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-primary/10  text-primary">
                                        Successful
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    10
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/paypal.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-warning/10  text-warning">
                                        Pending
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    11
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/visa.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-warning/10  text-warning">
                                        Pending
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    12
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/paypal.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-warning/10  text-warning">
                                        Pending
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    13
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/visa.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-warning/10  text-warning">
                                        Pending
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    14
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/paypal.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-error/10  text-error">
                                        Cancelled
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    15
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/visa.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-warning/10  text-warning">
                                        Pending
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    16
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/paypal.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-primary/10  text-primary">
                                        Successful
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    17
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/payoneer.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-primary/10  text-primary">
                                        Successful
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    18
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/paypal.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-warning/10  text-warning">
                                        Pending
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    19
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/payoneer.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-primary/10  text-primary">
                                        Successful
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    20
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/paypal.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-warning/10  text-warning">
                                        Pending
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="py-5 pl-6 px-3 bg-secondary/5  rounded-s-lg">
                                    21
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center py-2.5 gap-3 pr-6 min-w-[300px] px-3 bg-secondary/5 ">
                                    <img width="32" height="32" class="rounded-full shrink-0"
                                        src="{{ asset('assets/images/paypal.png') }}" alt="img" />
                                    <div class="flex flex-col">
                                        <span class="font-medium inline-block mb-1">
                                            Hooli INV-79820
                                        </span>
                                        <span class="text-xs">11 Aug, 24. 10:36 am</span>
                                    </div>
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    #521452
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    Paypal
                                </div>
                            </td>
                            <td class="w-[15%]">
                                <div class="bg-secondary/5  py-5 px-3">
                                    $1,121,212
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-[13px]">
                                    <span
                                        class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 !py-[11px] bg-error/10  text-error">
                                        Cancelled
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="bg-secondary/5  px-3 py-5 rounded-e-xl flex justify-end pr-5">
                                    @include('partials._horizontal-options-two')
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
@endsection

@section('page-modal')
    <div class="tn-modal fixed inset-0 z-99 modalhide overflow-y-auto bg-n900/80 duration-500">
        <div class="overflow-y-auto">
            <div
                class="modal box modal-inner absolute left-1/2 my-10 max-h-[90vh] w-[95%] max-w-[496px] -translate-x-1/2 overflow-y-auto duration-300 xl:p-8">
                <div class="relative">
                    <button class="tn-modal-close-btn absolute top-0 ltr:right-0 rtl:left-0">
                        <i class="las la-times"></i>
                    </button>
                    <div class="bb-dashed mb-4 flex items-center justify-between pb-4 3xl:">
                        <h4 class="h4">Transaction Details</h4>
                    </div>
                    <div class="py-3 px-6 bg-secondary/5 flex items-center gap-4 mb-6 lg:mb-8">
                        <img src="{{ asset('assets/images/paypal-big.png') }}" width="56" height="56" alt="paypal icon" />
                        <div>
                            <p class="xm:text-xl font-medium mb-2">Deposit Cash</p>
                            <span class="text-sm">Payment Successful</span>
                        </div>
                    </div>
                    <ul class="flex flex-col gap-4 bb-dashed border-secondary/20 pb-4 mb-4 3xl:">
                        <li class="flex justify-between">
                            <span>Transfer:</span> <span class="font-medium">#555443223</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Send To:</span> <span class="font-medium">Felecia Brown</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Bank Account:</span> <span class="font-medium">Wadk6265dlkd565</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Date:</span> <span class="font-medium">11 August 2024</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Time:</span> <span class="font-medium">10:36 AM</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Card Number:</span> <span class="font-medium">325 *** *** ***</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Amount:</span> <span class="font-medium">25,211.00 USD</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Fee:</span> <span class="font-medium">98 USD</span>
                        </li>
                    </ul>
                    <div class=" bb-dashed border-secondary/20 pb-4 mb-4 3xl:">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d2141.544710579929!2d90.39140680797202!3d23.87599993653183!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1702184930477!5m2!1sen!2sbd"
                            width="100%" height="200" style="border: 0" allowFullScreen={true} loading="lazy"
                            referrerPolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="flex justify-center gap-4 flex-wrap lg:gap-6">
                        <button class="flex items-center gap-2">
                            <i class="las la-download border border-n30  rounded-full bg-primary/5 p-2"></i>
                            <span>Download PDF </span>
                        </button>
                        <button class="flex items-center gap-2">
                            <i class="las la-print border border-n30  rounded-full bg-primary/5 p-2"></i>
                            <span>Print PDF </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection