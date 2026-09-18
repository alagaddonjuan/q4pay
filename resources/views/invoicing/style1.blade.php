@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Invoice Style 01</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="box">
            <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 3xl:">
                <h4 class="h4">Recent Invoice</h4>
                <div class="flex items-center max-lg:flex-wrap gap-4">
                    <form
                        class="bg-primary/5  border border-n30  flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                        <input type="text" placeholder="Search"
                            class="bg-transparent text-sm ltr:pl-4 border-0 rtl:pr-4 py-1 w-full" />
                        <button
                            class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                            <i class="las la-search text-lg"></i>
                        </button>
                    </form>
                    <div class="rounded-[32px] bg-primary/5 border border-n30  flex invoice-btns">
                        <button class="font-medium text-xs px-4 sm:px-5 3xl:px-6 py-3 invoice-active">
                            All
                        </button>
                        <button class="font-medium text-xs px-4 sm:px-5 3xl:px-6 py-3 ">
                            Paid
                        </button>
                        <button class="font-medium text-xs px-4 sm:px-5 3xl:px-6 py-3 ">
                            Unpaid
                        </button>
                        <button class="font-medium text-xs px-4 sm:px-5 3xl:px-6 py-3 ">
                            Rejected
                        </button>
                    </div>
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
                            <th class="text-start py-5 px-6 min-w-[230px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Title
                                </div>
                            </th>
                            <th class="text-start py-5 min-w-[130px]">Invoice</th>
                            <th class="text-start py-5 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Amount
                                </div>
                            </th>
                            <th class="text-start py-5 min-w-[80px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Rate
                                </div>
                            </th>
                            <th class="text-start py-5 min-w-[130px]">Due Date</th>
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
                                    <i class="las la-file text-primary"></i>
                                    <span class="font-medium">Retirement Fund</span>
                                </div>
                            </td>
                            <td class="py-5">
                                <p class="font-medium">#105994</p>
                            </td>
                            <td class="py-5">
                                <span>$175.54</span>
                            </td>
                            <td class="py-5">75%</td>
                            <td class="py-5">05/22/2029</td>
                            <td>07:55 AM</td>
                            <td class="py-5">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                    Paid
                                </span>
                            </td>
                            <td class="py-5">
                                <div class="flex justify-center">
                                    <button>
                                        <i class="las la-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-3">
                                    <i class="las la-file text-primary"></i>
                                    <span class="font-medium">Emergency Savings</span>
                                </div>
                            </td>
                            <td class="py-5">
                                <p class="font-medium">#105995</p>
                            </td>
                            <td class="py-5">
                                <span>$455.54</span>
                            </td>
                            <td class="py-5">85%</td>
                            <td class="py-5">11/08/2028</td>
                            <td>09:40 PM</td>
                            <td class="py-5">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                    Paid
                                </span>
                            </td>
                            <td class="py-5">
                                <div class="flex justify-center">
                                    <button>
                                        <i class="las la-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-3">
                                    <i class="las la-file text-primary"></i>
                                    <span class="font-medium">Travel Fund</span>
                                </div>
                            </td>
                            <td class="py-5">
                                <p class="font-medium">#105996</p>
                            </td>
                            <td class="py-5">
                                <span>$275.54</span>
                            </td>
                            <td class="py-5">70%</td>
                            <td class="py-5">01/30/2029</td>
                            <td>06:10 AM</td>
                            <td class="py-5">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                    Rejected
                                </span>
                            </td>
                            <td class="py-5">
                                <div class="flex justify-center">
                                    <button>
                                        <i class="las la-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-3">
                                    <i class="las la-file text-primary"></i>
                                    <span class="font-medium">Healthcare Savings</span>
                                </div>
                            </td>
                            <td class="py-5">
                                <p class="font-medium">#105997</p>
                            </td>
                            <td class="py-5">
                                <span>$4,575.54</span>
                            </td>
                            <td class="py-5">90%</td>
                            <td class="py-5">04/12/2029</td>
                            <td>02:25 PM</td>
                            <td class="py-5">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-warning/10  text-warning">
                                    Unpaid
                                </span>
                            </td>
                            <td class="py-5">
                                <div class="flex justify-center">
                                    <button>
                                        <i class="las la-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-3">
                                    <i class="las la-file text-primary"></i>
                                    <span class="font-medium">Real Estate Investment</span>
                                </div>
                            </td>
                            <td class="py-5">
                                <p class="font-medium">#105998</p>
                            </td>
                            <td class="py-5">
                                <span>$555.54</span>
                            </td>
                            <td class="py-5">100%</td>
                            <td class="py-5">10/05/2028</td>
                            <td>08:50 AM</td>
                            <td class="py-5">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                    Paid
                                </span>
                            </td>
                            <td class="py-5">
                                <div class="flex justify-center">
                                    <button>
                                        <i class="las la-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-3">
                                    <i class="las la-file text-primary"></i>
                                    <span class="font-medium">Charity Fund</span>
                                </div>
                            </td>
                            <td class="py-5">
                                <p class="font-medium">#105999</p>
                            </td>
                            <td class="py-5">
                                <span>$411.54</span>
                            </td>
                            <td class="py-5">80%</td>
                            <td class="py-5">07/28/2029</td>
                            <td>01:05 PM</td>
                            <td class="py-5">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                    Rejected
                                </span>
                            </td>
                            <td class="py-5">
                                <div class="flex justify-center">
                                    <button>
                                        <i class="las la-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-3">
                                    <i class="las la-file text-primary"></i>
                                    <span class="font-medium">Personal Development</span>
                                </div>
                            </td>
                            <td class="py-5">
                                <p class="font-medium">#106000</p>
                            </td>
                            <td class="py-5">
                                <span>$225.54</span>
                            </td>
                            <td class="py-5">95%</td>
                            <td class="py-5">03/15/2029</td>
                            <td>11:35 AM</td>
                            <td class="py-5">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-warning/10  text-warning">
                                    Unpaid
                                </span>
                            </td>
                            <td class="py-5">
                                <div class="flex justify-center">
                                    <button>
                                        <i class="las la-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-3">
                                    <i class="las la-file text-primary"></i>
                                    <span class="font-medium">Rainy Day Fund</span>
                                </div>
                            </td>
                            <td class="py-5">
                                <p class="font-medium">#106001</p>
                            </td>
                            <td class="py-5">
                                <span>$525.54</span>
                            </td>
                            <td class="py-5">100%</td>
                            <td class="py-5">09/18/2028</td>
                            <td>04:20 AM</td>
                            <td class="py-5">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                    Paid
                                </span>
                            </td>
                            <td class="py-5">
                                <div class="flex justify-center">
                                    <button>
                                        <i class="las la-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-3">
                                    <i class="las la-file text-primary"></i>
                                    <span class="font-medium">Future Investment</span>
                                </div>
                            </td>
                            <td class="py-5">
                                <p class="font-medium">#106002</p>
                            </td>
                            <td class="py-5">
                                <span>$755.54</span>
                            </td>
                            <td class="py-5">85%</td>
                            <td class="py-5">06/05/2029</td>
                            <td>03:15 PM</td>
                            <td class="py-5">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                    Rejected
                                </span>
                            </td>
                            <td class="py-5">
                                <div class="flex justify-center">
                                    <button>
                                        <i class="las la-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-3">
                                    <i class="las la-file text-primary"></i>
                                    <span class="font-medium">Vacation Savings</span>
                                </div>
                            </td>
                            <td class="py-5">
                                <p class="font-medium">#106003</p>
                            </td>
                            <td class="py-5">
                                <span>$785.54</span>
                            </td>
                            <td class="py-5">90%</td>
                            <td class="py-5">02/25/2029</td>
                            <td>10:45 AM</td>
                            <td class="py-5">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-warning/10  text-warning">
                                    Unpaid
                                </span>
                            </td>
                            <td class="py-5">
                                <div class="flex justify-center">
                                    <button>
                                        <i class="las la-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-3">
                                    <i class="las la-file text-primary"></i>
                                    <span class="font-medium">Property Purchase</span>
                                </div>
                            </td>
                            <td class="py-5">
                                <p class="font-medium">#106004</p>
                            </td>
                            <td class="py-5">
                                <span>$695.54</span>
                            </td>
                            <td class="py-5">100%</td>
                            <td class="py-5">08/08/2029</td>
                            <td>07:30 PM</td>
                            <td class="py-5">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                    Paid
                                </span>
                            </td>
                            <td class="py-5">
                                <div class="flex justify-center">
                                    <button>
                                        <i class="las la-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-3">
                                    <i class="las la-file text-primary"></i>
                                    <span class="font-medium">Hobby Fund</span>
                                </div>
                            </td>
                            <td class="py-5">
                                <p class="font-medium">#106005</p>
                            </td>
                            <td class="py-5">
                                <span>$4,021.54</span>
                            </td>
                            <td class="py-5">75%</td>
                            <td class="py-5">04/02/2029</td>
                            <td>06:40 AM</td>
                            <td class="py-5">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-error/10  text-error">
                                    Rejected
                                </span>
                            </td>
                            <td class="py-5">
                                <div class="flex justify-center">
                                    <button>
                                        <i class="las la-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-primary/5  duration-500 border-b border-n30  first:border-t">
                            <td class="py-5 px-6">
                                <div class="flex items-center gap-3">
                                    <i class="las la-file text-primary"></i>
                                    <span class="font-medium">Family Vacation Fund</span>
                                </div>
                            </td>
                            <td class="py-5">
                                <p class="font-medium">#106006</p>
                            </td>
                            <td class="py-5">
                                <span>$475.54</span>
                            </td>
                            <td class="py-5">80%</td>
                            <td class="py-5">12/10/2028</td>
                            <td>09:20 AM</td>
                            <td class="py-5">
                                <span
                                    class="block text-xs w-28 xxl:w-36 text-center rounded-[30px]  border border-n30 py-2 bg-primary/10  text-primary">
                                    Paid
                                </span>
                            </td>
                            <td class="py-5">
                                <div class="flex justify-center">
                                    <button>
                                        <i class="las la-download"></i>
                                    </button>
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