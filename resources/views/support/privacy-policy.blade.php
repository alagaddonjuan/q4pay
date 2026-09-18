@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Privacy Policy</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <!-- Privacy Policy -->
        <div class="box xl:p-8">
            <div class="flex justify-between flex-wrap gap-5 items-center bb-dashed mb-4 pb-4 3xl:">
                <h4 class="h4">Privacy Policy Rules</h4>
                <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
                    <form
                        class="bg-primary/5 datatable-search  border border-n30  flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
                        <input type="text" placeholder="Search"
                            class="bg-transparent text-sm ltr:pl-4 rtl:pr-4 py-1 w-full border-none"
                            id="payment-account-search" />
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
                    <a class="text-base font-medium md:text-xl md:font-semibold mb-4 block" href="#">Data
                        Collection</a>
                    <p class="text-sm mb-6">Clearly state what types of personal information you collect from users (e.g.,
                        name,
                        email, address).</p>
                    <button class="flex items-center gap-2 text-primary">
                        <span class="font-semibold">Download</span><span
                            class="w-7 h-7 flex items-center justify-center shrink-0 bg-n0  rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                class="las la-download text-lg"></i></span>
                    </button>
                </div>
                <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                    <a class="text-base font-medium md:text-xl md:font-semibold mb-4 block" href="#">Purpose of Data
                        Collection</a>
                    <p class="text-sm mb-6">Specify the purpose for collecting user data, whether it's for account creation,
                        transactions, or communication.</p>
                    <button class="flex items-center gap-2 text-primary">
                        <span class="font-semibold">Download</span><span
                            class="w-7 h-7 flex items-center justify-center shrink-0 bg-n0  rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                class="las la-download text-lg"></i></span>
                    </button>
                </div>
                <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                    <a class="text-base font-medium md:text-xl md:font-semibold mb-4 block" href="#">Consent</a>
                    <p class="text-sm mb-6">Clearly outline how and when users give their consent for data collection, and
                        provide an opt-in mechanism.</p>
                    <button class="flex items-center gap-2 text-primary">
                        <span class="font-semibold">Download</span><span
                            class="w-7 h-7 flex items-center justify-center shrink-0 bg-n0  rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                class="las la-download text-lg"></i></span>
                    </button>
                </div>
                <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                    <a class="text-base font-medium md:text-xl md:font-semibold mb-4 block" href="#">Children's
                        Privacy</a>
                    <p class="text-sm mb-6">Specify if your service is intended for users under a certain age and outline
                        how
                        you handle the data of minors.</p>
                    <button class="flex items-center gap-2 text-primary">
                        <span class="font-semibold">Download</span><span
                            class="w-7 h-7 flex items-center justify-center shrink-0 bg-n0  rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                class="las la-download text-lg"></i></span>
                    </button>
                </div>
                <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                    <a class="text-base font-medium md:text-xl md:font-semibold mb-4 block" href="#">Cookies</a>
                    <p class="text-sm mb-6">Explain your use of cookies, including the types of cookies, their purpose, and
                        how
                        users can manage preferences.</p>
                    <button class="flex items-center gap-2 text-primary">
                        <span class="font-semibold">Download</span><span
                            class="w-7 h-7 flex items-center justify-center shrink-0 bg-n0  rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                class="las la-download text-lg"></i></span>
                    </button>
                </div>
                <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                    <a class="text-base font-medium md:text-xl md:font-semibold mb-4 block" href="#">Information
                        Security</a>
                    <p class="text-sm mb-6">Detail the security measures in place to protect user data from unauthorized
                        access
                        or breaches.</p>
                    <button class="flex items-center gap-2 text-primary">
                        <span class="font-semibold">Download</span><span
                            class="w-7 h-7 flex items-center justify-center shrink-0 bg-n0  rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                class="las la-download text-lg"></i></span>
                    </button>
                </div>
                <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                    <a class="text-base font-medium md:text-xl md:font-semibold mb-4 block" href="#">Data Storage
                        Duration</a>
                    <p class="text-sm mb-6">Specify how long user data will be retained and the criteria used to determine
                        the
                        retention period.</p>
                    <button class="flex items-center gap-2 text-primary">
                        <span class="font-semibold">Download</span><span
                            class="w-7 h-7 flex items-center justify-center shrink-0 bg-n0  rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                class="las la-download text-lg"></i></span>
                    </button>
                </div>
                <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                    <a class="text-base font-medium md:text-xl md:font-semibold mb-4 block" href="#">User Access</a>
                    <p class="text-sm mb-6">Explain how users can access, correct, or delete their personal information and
                        the
                        process for making such requests.</p>
                    <button class="flex items-center gap-2 text-primary">
                        <span class="font-semibold">Download</span><span
                            class="w-7 h-7 flex items-center justify-center shrink-0 bg-n0  rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                class="las la-download text-lg"></i></span>
                    </button>
                </div>
                <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                    <a class="text-base font-medium md:text-xl md:font-semibold mb-4 block" href="#">Third-Party
                        Sharing</a>
                    <p class="text-sm mb-6">Clarify if and how user data is shared with third parties, and provide the names
                        or
                        categories of such parties.</p>
                    <button class="flex items-center gap-2 text-primary">
                        <span class="font-semibold">Download</span><span
                            class="w-7 h-7 flex items-center justify-center shrink-0 bg-n0  rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                class="las la-download text-lg"></i></span>
                    </button>
                </div>
                <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                    <a class="text-base font-medium md:text-xl md:font-semibold mb-4 block" href="#">Marketing
                        Communications</a>
                    <p class="text-sm mb-6">Outline how users can opt in or out of marketing communications and how
                        frequently
                        they can expect to receive.</p>
                    <button class="flex items-center gap-2 text-primary">
                        <span class="font-semibold">Download</span><span
                            class="w-7 h-7 flex items-center justify-center shrink-0 bg-n0  rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                class="las la-download text-lg"></i></span>
                    </button>
                </div>
                <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                    <a class="text-base font-medium md:text-xl md:font-semibold mb-4 block" href="#">Data
                        Transfer</a>
                    <p class="text-sm mb-6">If applicable, explain how user data is transferred internationally and the
                        safeguards in place for such transfers.</p>
                    <button class="flex items-center gap-2 text-primary">
                        <span class="font-semibold">Download</span><span
                            class="w-7 h-7 flex items-center justify-center shrink-0 bg-n0  rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                class="las la-download text-lg"></i></span>
                    </button>
                </div>
                <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                    <a class="text-base font-medium md:text-xl md:font-semibold mb-4 block" href="#">Legal Basis for
                        Processing</a>
                    <p class="text-sm mb-6">Specify the legal basis for processing user data, such as consent, contract, or
                        legitimate interests.</p>
                    <button class="flex items-center gap-2 text-primary">
                        <span class="font-semibold">Download</span><span
                            class="w-7 h-7 flex items-center justify-center shrink-0 bg-n0  rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                class="las la-download text-lg"></i></span>
                    </button>
                </div>
                <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                    <a class="text-base font-medium md:text-xl md:font-semibold mb-4 block" href="#">Changes to
                        Privacy
                        Policy</a>
                    <p class="text-sm mb-6">Notify users of any changes to the privacy policy and provide a timeline for
                        when
                        changes will take effect.</p>
                    <button class="flex items-center gap-2 text-primary">
                        <span class="font-semibold">Download</span><span
                            class="w-7 h-7 flex items-center justify-center shrink-0 bg-n0  rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                class="las la-download text-lg"></i></span>
                    </button>
                </div>
                <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                    <a class="text-base font-medium md:text-xl md:font-semibold mb-4 block" href="#">Contact
                        Information</a>
                    <p class="text-sm mb-6">Provide contact details for users to reach out with privacy-related concerns or
                        inquiries.</p>
                    <button class="flex items-center gap-2 text-primary">
                        <span class="font-semibold">Download</span><span
                            class="w-7 h-7 flex items-center justify-center shrink-0 bg-n0  rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                class="las la-download text-lg"></i></span>
                    </button>
                </div>
                <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                    <a class="text-base font-medium md:text-xl md:font-semibold mb-4 block" href="#">Analytics</a>
                    <p class="text-sm mb-6">If using analytics tools, disclose the types of data collected and how it's
                        used to
                        improve the user experience.</p>
                    <button class="flex items-center gap-2 text-primary">
                        <span class="font-semibold">Download</span><span
                            class="w-7 h-7 flex items-center justify-center shrink-0 bg-n0  rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                class="las la-download text-lg"></i></span>
                    </button>
                </div>
                <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                    <a class="text-base font-medium md:text-xl md:font-semibold mb-4 block" href="#">Social Media
                        Integration</a>
                    <p class="text-sm mb-6">Explain if and how social media plugins or integrations collect and process
                        user
                        data.</p>
                    <button class="flex items-center gap-2 text-primary">
                        <span class="font-semibold">Download</span><span
                            class="w-7 h-7 flex items-center justify-center shrink-0 bg-n0  rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                class="las la-download text-lg"></i></span>
                    </button>
                </div>
                <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                    <a class="text-base font-medium md:text-xl md:font-semibold mb-4 block" href="#">User-Generated
                        Content</a>
                    <p class="text-sm mb-6">Detail how user-generated content is moderated and any associated privacy
                        considerations.</p>
                    <button class="flex items-center gap-2 text-primary">
                        <span class="font-semibold">Download</span><span
                            class="w-7 h-7 flex items-center justify-center shrink-0 bg-n0  rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
                                class="las la-download text-lg"></i></span>
                    </button>
                </div>
                <div class="col-span-12 md:col-span-6 xxl:col-span-4 box xl:p-6 bg-primary/5  border border-n30 ">
                    <a class="text-base font-medium md:text-xl md:font-semibold mb-4 block" href="#">Payment
                        Information</a>
                    <p class="text-sm mb-6">If applicable, outline how payment information is processed, stored, and
                        secured.
                    </p>
                    <button class="flex items-center gap-2 text-primary">
                        <span class="font-semibold">Download</span><span
                            class="w-7 h-7 flex items-center justify-center shrink-0 bg-n0  rounded-full shadow-[0px_6px_30px_0px_rgba(0,0,0,0.08)]"><i
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
@endsection