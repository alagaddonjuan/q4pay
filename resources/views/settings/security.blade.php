@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Security</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="flex flex-col gap-4 xxl:gap-6">
            <!-- Change Password -->
            <div class="box xl:p-8 xxl:p-10">
                <h4 class="h4 bb-dashed pb-4 mb-4 md:mb-6 md:pb-6">
                    Change Password
                </h4>
                <form class="mt-6 xl:mt-8 grid grid-cols-2 gap-4 3xl:gap-6">
                    <div class="col-span-2 md:col-span-1">
                        <label for="email" class="md:text-lg font-medium block mb-4">
                            Old Password
                        </label>
                        <div
                            class="bg-primary/5  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3 relative">
                            <input type="password" class="w-11/12 text-sm bg-transparent p-0 border-none"
                                placeholder="Old Password" id="password1" required />
                            <span class="absolute eye-icon ltr:right-5 rtl:left-5 top-1/2 -translate-y-1/2 cursor-pointer"
                                id="password1-btn">
                                <i class="las la-eye" style="display: none;"></i>
                                <i class="las la-eye-slash"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="email" class="md:text-lg font-medium block mb-4">
                            New Password
                        </label>
                        <div
                            class="bg-primary/5  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3 relative">
                            <input type="password" class="w-11/12 text-sm bg-transparent p-0 border-none"
                                placeholder="Old Password" id="password2" required />
                            <span class="absolute eye-icon ltr:right-5 rtl:left-5 top-1/2 -translate-y-1/2 cursor-pointer"
                                id="password2-btn">
                                <i class="las la-eye" style="display: none;"></i>
                                <i class="las la-eye-slash"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <label for="email" class="md:text-lg font-medium block mb-4">
                            Confirm Password
                        </label>
                        <div
                            class="bg-primary/5  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3 relative">
                            <input type="password" class="w-11/12 text-sm bg-transparent p-0 border-none"
                                placeholder="Old Password" id="password3" required />
                            <span class="absolute eye-icon ltr:right-5 rtl:left-5 top-1/2 -translate-y-1/2 cursor-pointer"
                                id="password3-btn">
                                <i class="las la-eye" style="display: none;"></i>
                                <i class="las la-eye-slash"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <p class="font-medium text-lg mb-4">
                            New password must contain :
                        </p>
                        <ul class="marker:text-primary list-disc flex flex-col gap-3 list-inside">
                            <li>At least 8 characters</li>
                            <li>At least 1 lower letter (a-z)</li>
                            <li>At least 1 uppercase letter(A-Z)</li>
                            <li>At least 1 number (0-9)</li>
                            <li>At least 1 special characters</li>
                        </ul>
                    </div>
                    <div class="col-span-2 flex gap-4">
                        <button class="btn-primary px-5">Save Changes</button>
                        <button class="btn-outline px-5">Cancel</button>
                    </div>
                </form>
            </div>
            <!-- Two factor -->
            <div class="box xl:p-8">
                <div class="flex justify-between items-center  bb-dashed mb-4 pb-4 3xl:">
                    <h4 class="h4">Two-Factor Authentication</h4>
                    @include('partials._horizontal-options')

                </div>
                <div class="grid grid-cols-2 md:divide-x rtl:md:divide-x-reverse max-md:gap-4 divide-dashed divide-primary">
                    <div class="col-span-2 md:col-span-1 md:ltr:pr-5 md:rtl:pl-5 flex flex-col gap-4 xxl:gap-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-base md:text-lg xl:text-xl mb-2">
                                    Authentication app
                                </p>
                                <span class="text-xs md:text-sm">Google auth app</span>
                            </div>
                            <div class="flex items-center justify-center">
                                <label for="google" class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" id="google" class="custom-checkbox sr-only" />
                                        <div class="block w-14 h-8 rounded-full bg bg-primary/20"></div>
                                        <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition">
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-base md:text-lg xl:text-xl mb-2">
                                    Primary Email
                                </p>
                                <span class="text-xs md:text-sm">E-mail used to send notifications</span>
                            </div>
                            <div class="flex items-center justify-center">
                                <label for="email" class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" id="email" class="custom-checkbox sr-only" checked />
                                        <div class="block w-14 h-8 rounded-full bg bg-primary"></div>
                                        <div
                                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition translate-x-full">
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-base md:text-lg xl:text-xl mb-2">
                                    SMS Recovery
                                </p>
                                <span class="text-xs md:text-sm">Your phone number or something</span>
                            </div>
                            <div class="flex items-center justify-center">
                                <label for="sms" class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" id="sms" class="custom-checkbox sr-only" />
                                        <div class="block w-14 h-8 rounded-full bg bg-primary/20"></div>
                                        <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition">
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1 md:ltr:pl-5 md:rtl:pr-5 flex flex-col gap-4 xxl:gap-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-base md:text-lg xl:text-xl mb-2">
                                    Mobile Authenticator
                                </p>
                                <span class="text-xs md:text-sm">Enhance security with a mobile authentication app.</span>
                            </div>
                            <div class="flex items-center justify-center">
                                <label for="mobile" class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" id="mobile" class="custom-checkbox sr-only" checked />
                                        <div class="block w-14 h-8 rounded-full bg bg-primary"></div>
                                        <div
                                            class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition translate-x-full">
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-base md:text-lg xl:text-xl mb-2">
                                    Email Notifications
                                </p>
                                <span class="text-xs md:text-sm">Receive important notifications via your primary
                                    email.</span>
                            </div>
                            <div class="flex items-center justify-center">
                                <label for="recovery" class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" id="recovery" class="custom-checkbox sr-only" />
                                        <div class="block w-14 h-8 rounded-full bg bg-primary/20"></div>
                                        <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition">
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-base md:text-lg xl:text-xl mb-2">
                                    SMS Account Recovery
                                </p>
                                <span class="text-xs md:text-sm">Enable SMS-based account recovery for added
                                    convenience.</span>
                            </div>
                            <div class="flex items-center justify-center">
                                <label for="sms-account" class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" id="sms-account" class="custom-checkbox sr-only" />
                                        <div class="block w-14 h-8 rounded-full bg bg-primary/20"></div>
                                        <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition">
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection