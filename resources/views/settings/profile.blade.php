@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Profile</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="grid grid-cols-12 gap-4 xx3xl:gap-6">
            <div class="col-span-12 lg:col-span-6">
                <div class="box xxl:p-8 3xl:p-10">
                    <h4 class="h4 bb-dashed mb-4 pb-4 md:mb-6 md:pb-6">
                        Account Settings
                    </h4>
                    <p class="text-lg font-medium mb-4">Profile Photo</p>
                    <div class="flex flex-wrap gap-6 xxl:gap-10 items-center bb-dashed mb-6 pb-6">
                        <img src="{{ asset('assets/images/placeholder.png') }}" width="120" height="120" class="rounded-xl"
                            alt="img" />
                        <div class="flex gap-4">
                            <label for="photo-upload" class="btn-primary">
                                Upload Photo
                            </label>
                            <input type="file" id="photo-upload" class="hidden" />
                            <button class="btn-outline">Cancel</button>
                        </div>
                    </div>
                    <form class="mt-6 xl:mt-8 grid grid-cols-2 gap-4 xx3xl:gap-6">
                        <div class="col-span-2 md:col-span-1">
                            <label for="fname" class="md:text-lg font-medium block mb-4">
                                First Name
                            </label>
                            <input type="text"
                                class="w-full text-sm bg-primary/5  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                id="fname" placeholder="First Name" value="Darrel" required />
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label for="lname" class="md:text-lg font-medium block mb-4">
                                Last Name
                            </label>
                            <input type="text"
                                class="w-full text-sm bg-primary/5  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Last Name" value="Steward" id="lname" required />
                        </div>
                        <div class="col-span-2">
                            <label for="email" class="md:text-lg font-medium block mb-4">
                                Email
                            </label>
                            <input type="email"
                                class="w-full text-sm bg-primary/5  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Email" value="example@mail.com" id="email" required />
                        </div>
                        <div class="col-span-2">
                            <label for="phone" class="md:text-lg font-medium block mb-4">
                                Phone (Optional)
                            </label>
                            <input type="text"
                                class="w-full text-sm bg-primary/5  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Phone" value="91021421144" id="phone" required />
                        </div>
                        <div class="col-span-2">
                            <label for="phone" class="md:text-lg font-medium block mb-4">
                                Gender :
                            </label>
                            <div class="flex gap-5">
                                <label for="male" class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" id="male" name="gender" checked class="accent-secondary" />
                                    Male
                                </label>
                                <label for="female" class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" id="female" name="gender" class="accent-secondary" />
                                    Female
                                </label>
                                <label for="other" class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" id="other" name="gender" class="accent-secondary" />
                                    Other
                                </label>
                            </div>
                        </div>

                        <div class="col-span-2">
                            <label for="tagline" class="md:text-lg font-medium block mb-4">
                                Tagline :
                            </label>
                            <div>
                                <div id="editor">
                                    <p>Hello World!</p>
                                </div>
                            </div>

                        </div>
                        <div></div>
                        <div class="col-span-2">
                            <div class="flex flex-col gap-4">
                                <div class="flex items-center relative">
                                    <input type="checkbox" id="I agree to the privacy &amp; policy" name="A3-confirmation"
                                        class="opacity-0 absolute h-8 w-8" />
                                    <div
                                        class="bg-n0  border border-gray-400 rounded-full w-5 h-5 flex shrink-0 justify-center items-center ltr:mr-2 rtl:ml-2 focus-within:border-primary">
                                        <svg class="fill-current hidden w-[10px] h-[10px] text-primary pointer-events-none"
                                            version="1.1" viewBox="0 0 17 12" xmlns="http://www.w3.org/2000/svg">
                                            <g fill="none" fill-rule="evenodd">
                                                <g transform="translate(-9 -11)" fill="#20B757" fill-rule="nonzero">
                                                    <path
                                                        d="m25.576 11.414c0.56558 0.55188 0.56558 1.4439 0 1.9961l-9.404 9.176c-0.28213 0.27529-0.65247 0.41385-1.0228 0.41385-0.37034 0-0.74068-0.13855-1.0228-0.41385l-4.7019-4.588c-0.56584-0.55188-0.56584-1.4442 0-1.9961 0.56558-0.55214 1.4798-0.55214 2.0456 0l3.679 3.5899 8.3812-8.1779c0.56558-0.55214 1.4798-0.55214 2.0456 0z" />
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <label for="I agree to the privacy &amp; policy"
                                        class="select-none text-sm md:text-base flex gap-2 cursor-pointer items-center">
                                        I agree to the privacy &amp; policy
                                    </label>
                                </div>
                                <div class="flex items-center relative">
                                    <input type="checkbox" id="I agree with all terms &amp; conditions"
                                        name="A3-confirmation" class="opacity-0 absolute h-8 w-8" />
                                    <div
                                        class="bg-n0  border border-gray-400 rounded-full w-5 h-5 flex shrink-0 justify-center items-center ltr:mr-2 rtl:ml-2 focus-within:border-primary">
                                        <svg class="fill-current hidden w-[10px] h-[10px] text-primary pointer-events-none"
                                            version="1.1" viewBox="0 0 17 12" xmlns="http://www.w3.org/2000/svg">
                                            <g fill="none" fill-rule="evenodd">
                                                <g transform="translate(-9 -11)" fill="#20B757" fill-rule="nonzero">
                                                    <path
                                                        d="m25.576 11.414c0.56558 0.55188 0.56558 1.4439 0 1.9961l-9.404 9.176c-0.28213 0.27529-0.65247 0.41385-1.0228 0.41385-0.37034 0-0.74068-0.13855-1.0228-0.41385l-4.7019-4.588c-0.56584-0.55188-0.56584-1.4442 0-1.9961 0.56558-0.55214 1.4798-0.55214 2.0456 0l3.679 3.5899 8.3812-8.1779c0.56558-0.55214 1.4798-0.55214 2.0456 0z" />
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <label for="I agree with all terms &amp; conditions"
                                        class="select-none text-sm md:text-base flex gap-2 cursor-pointer items-center">
                                        I agree with all terms &amp; conditions
                                    </label>
                                </div>
                            </div>
                            <div class="flex mt-6 xxl:mt-10 gap-4">
                                <button class="btn-primary px-5">Save Changes</button>
                                <button class="btn-outline px-5">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-6">
                <div class="box xxl:p-8 3xl:p-10 mb-6">
                    <h4 class="h4 bb-dashed mb-4 pb-4 md:mb-6 md:pb-6">Address</h4>
                    <form class="mt-6 xl:mt-8 grid grid-cols-2 gap-4 3xl:gap-6">
                        <div class="col-span-2">
                            <label for="location" class="md:text-lg font-medium block mb-4">
                                Location
                            </label>
                            <select name="sort" class="nc-select full bg-primary/5! py-3">
                                <option value="usa">USA</option>
                                <option value="uk">UK</option>
                                <option value="sa">SA</option>
                            </select>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label for="address1" class="md:text-lg font-medium block mb-4">
                                Address 1
                            </label>
                            <input type="text"
                                class="w-full text-sm bg-primary/5  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Address 1" value="Road 12, House 3, New York" id="address1" required />
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label for="address2" class="md:text-lg font-medium block mb-4">
                                Address 2 (Optional)
                            </label>
                            <input type="text"
                                class="w-full text-sm bg-primary/5  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Address 2" value="Road 12, House 3, Los angelos" id="address2"
                                required />
                        </div>
                        <div class="col-span-2">
                            <label for="zip" class="md:text-lg font-medium block mb-4">
                                Zip Code
                            </label>
                            <input type="text"
                                class="w-full text-sm bg-primary/5  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Zip Code" value="2250" id="zip" required />
                        </div>
                        <div class="col-span-2 flex pt-4 gap-4">
                            <button class="btn-primary px-5">Save Changes</button>
                            <button class="btn-outline px-5">Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="box xxl:p-8 3xl:p-10 mb-6">
                    <h4 class="h4 bb-dashed mb-4 pb-4 md:mb-6 md:pb-6">Privacy</h4>
                    <form class="mt-6 xl:mt-8 grid grid-cols-2 gap-4 3xl:gap-6">
                        <div class="col-span-2">
                            <label for="privacy" class="md:text-lg font-medium block mb-4">
                                Who can see your profile photo?
                            </label>
                            <select name="sort" class="nc-select full bg-primary/5 py-3">
                                <option value="anyone">Anyone</option>
                                <option value="friends">Friends</option>
                                <option value="frndsoffrnds">Friends of Friends</option>
                            </select>
                        </div>
                        <div class="col-span-2 flex pt-4 gap-4">
                            <button class="btn-primary px-5">Save Changes</button>
                            <button class="btn-outline px-5">Cancel</button>
                        </div>
                    </form>
                </div>
                <div class="box xxl:p-8 3xl:p-10 mb-6">
                    <h4 class="h4 bb-dashed mb-4 pb-4 md:mb-6 md:pb-6">
                        Delete Your Account
                    </h4>
                    <form class="mt-6 xl:mt-8 gap-4 3xl:gap-6">
                        <p class="mb-4">
                            When you delete your account, you lose access to Front account
                            services, and we permanently delete your personal data. You can
                            cancel the deletion for 14 days.
                        </p>
                        <div class="flex items-center relative">
                            <input type="checkbox" id="Confirm that I want to delete my profile" name="A3-confirmation"
                                class="opacity-0 absolute h-8 w-8" />
                            <div
                                class="bg-n0  border border-gray-400 rounded-full w-5 h-5 flex shrink-0 justify-center items-center ltr:mr-2 rtl:ml-2 focus-within:border-primary">
                                <svg class="fill-current hidden w-[10px] h-[10px] text-primary pointer-events-none"
                                    version="1.1" viewBox="0 0 17 12" xmlns="http://www.w3.org/2000/svg">
                                    <g fill="none" fill-rule="evenodd">
                                        <g transform="translate(-9 -11)" fill="#20B757" fill-rule="nonzero">
                                            <path
                                                d="m25.576 11.414c0.56558 0.55188 0.56558 1.4439 0 1.9961l-9.404 9.176c-0.28213 0.27529-0.65247 0.41385-1.0228 0.41385-0.37034 0-0.74068-0.13855-1.0228-0.41385l-4.7019-4.588c-0.56584-0.55188-0.56584-1.4442 0-1.9961 0.56558-0.55214 1.4798-0.55214 2.0456 0l3.679 3.5899 8.3812-8.1779c0.56558-0.55214 1.4798-0.55214 2.0456 0z" />
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <label for="Confirm that I want to delete my profile"
                                class="select-none text-sm md:text-base flex gap-2 cursor-pointer items-center">
                                Confirm that I want to delete my profile
                            </label>
                        </div>
                        <div class="col-span-2 flex mt-6 xxl:mt-10 gap-4">
                            <button class="btn-outline px-5">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection