@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Notification</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="grid grid-cols-2 gap-4 xxl:gap-6">
            <!-- Email notifications -->
            <div class="box xl:p-8 col-span-2 md:col-span-1">
                <div class="flex justify-between items-center bb-dashed mb-4 pb-4 3xl:">
                    <h4 class="h4">Email Notification</h4>
                    @include('partials._horizontal-options')
                </div>
                <div class="flex flex-col gap-4 xl:gap-6">
                    <div class="flex items-center gap-3 justify-between">
                        <div>
                            <p class="font-medium text-base sm:text-lg lg:text-xl mb-2">
                                Two-Factor Authentication
                            </p>
                            <span class="text-xs md:text-sm">Use your favorite authentication app for added security.</span>
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
                    <div class="flex items-center gap-3 justify-between">
                        <div>
                            <p class="font-medium text-base sm:text-lg lg:text-xl mb-2">
                                Email Notifications
                            </p>
                            <span class="text-xs md:text-sm">Receive important notifications via your primary email.</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <label for="two-factor" class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="two-factor" class="custom-checkbox sr-only" />
                                    <div class="block w-14 h-8 rounded-full bg bg-primary/20"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 justify-between">
                        <div>
                            <p class="font-medium text-base sm:text-lg lg:text-xl mb-2">
                                SMS Recovery
                            </p>
                            <span class="text-xs md:text-sm">Set up SMS recovery for account access.</span>
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
            </div>
            <!-- sms notification -->
            <div class="box xl:p-8 col-span-2 md:col-span-1">
                <div class="flex justify-between items-center bb-dashed mb-4 pb-4 3xl:">
                    <h4 class="h4">SMS Notification</h4>
                    @include('partials._horizontal-options')
                </div>
                <div class="flex flex-col gap-4 xl:gap-6">
                    <div class="flex items-center gap-3 justify-between">
                        <div>
                            <p class="font-medium text-base sm:text-lg lg:text-xl mb-2">
                                Text Authentication Code
                            </p>
                            <span class="text-xs md:text-sm">Authenticate using SMS for quick access.</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <label for="text-sms" class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="text-sms" class="custom-checkbox sr-only" checked />
                                    <div class="block w-14 h-8 rounded-full bg bg-primary"></div>
                                    <div
                                        class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition translate-x-full">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 justify-between">
                        <div>
                            <p class="font-medium text-base sm:text-lg lg:text-xl mb-2">
                                Critical Alerts
                            </p>
                            <span class="text-xs md:text-sm">Get critical alerts directly to your phone via SMS.</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <label for="critical" class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="critical" class="custom-checkbox sr-only" />
                                    <div class="block w-14 h-8 rounded-full bg bg-primary/20"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 justify-between">
                        <div>
                            <p class="font-medium text-base sm:text-lg lg:text-xl mb-2">
                                Emergency Recovery
                            </p>
                            <span class="text-xs md:text-sm">Enable SMS recovery as a backup method.</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <label for="emegency" class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="emegency" class="custom-checkbox sr-only" />
                                    <div class="block w-14 h-8 rounded-full bg bg-primary/20"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Push Notifications -->
            <div class="box xl:p-8 col-span-2 md:col-span-1">
                <div class="flex justify-between items-center bb-dashed mb-4 pb-4 3xl:">
                    <h4 class="h4">Push Notification</h4>
                    @include('partials._horizontal-options')
                </div>
                <div class="flex flex-col gap-4 xl:gap-6">
                    <div class="flex items-center gap-3 justify-between">
                        <div>
                            <p class="font-medium text-base sm:text-lg lg:text-xl mb-2">
                                Push Authentication
                            </p>
                            <span class="text-xs md:text-sm">Securely authenticate with push notifications.</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <label for="push-auth" class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="push-auth" class="custom-checkbox sr-only" checked />
                                    <div class="block w-14 h-8 rounded-full bg bg-primary"></div>
                                    <div
                                        class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition translate-x-full">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 justify-between">
                        <div>
                            <p class="font-medium text-base sm:text-lg lg:text-xl mb-2">
                                Instant Alerts
                            </p>
                            <span class="text-xs md:text-sm">Receive instant alerts through push notifications.</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <label for="instant" class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="instant" class="custom-checkbox sr-only" />
                                    <div class="block w-14 h-8 rounded-full bg bg-primary/20"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 justify-between">
                        <div>
                            <p class="font-medium text-base sm:text-lg lg:text-xl mb-2">
                                Emergency Push
                            </p>
                            <span class="text-xs md:text-sm">Configure push notifications for emergency scenarios.</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <label for="emegency-push" class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="emegency-push" class="custom-checkbox sr-only" />
                                    <div class="block w-14 h-8 rounded-full bg bg-primary/20"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Update Notifications -->
            <div class="box xl:p-8 col-span-2 md:col-span-1">
                <div class="flex justify-between items-center bb-dashed mb-4 pb-4 3xl:">
                    <h4 class="h4">News Flash</h4>
                    @include('partials._horizontal-options')
                </div>
                <div class="flex flex-col gap-4 xl:gap-6">
                    <div class="flex items-center gap-3 justify-between">
                        <div>
                            <p class="font-medium text-base sm:text-lg lg:text-xl mb-2">
                                News Updates
                            </p>
                            <span class="text-xs md:text-sm">Stay informed with important news updates.</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <label for="news-update" class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="news-update" class="custom-checkbox sr-only" checked />
                                    <div class="block w-14 h-8 rounded-full bg bg-primary"></div>
                                    <div
                                        class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition translate-x-full">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 justify-between">
                        <div>
                            <p class="font-medium text-base sm:text-lg lg:text-xl mb-2">
                                Newsletter
                            </p>
                            <span class="text-xs md:text-sm">Subscribe to our newsletter for regular updates.</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <label for="newsletter" class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="newsletter" class="custom-checkbox sr-only" />
                                    <div class="block w-14 h-8 rounded-full bg bg-primary/20"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 justify-between">
                        <div>
                            <p class="font-medium text-base sm:text-lg lg:text-xl mb-2">
                                Emergency Alerts
                            </p>
                            <span class="text-xs md:text-sm">Receive emergency alerts for urgent news.</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <label for="emegency-alerts" class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="emegency-alerts" class="custom-checkbox sr-only" />
                                    <div class="block w-14 h-8 rounded-full bg bg-primary/20"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Buzz Alert -->
            <div class="box xl:p-8 col-span-2 md:col-span-1">
                <div class="flex justify-between items-center bb-dashed mb-4 pb-4 3xl:">
                    <h4 class="h4">Buzz Alert</h4>
                    @include('partials._horizontal-options')
                </div>
                <div class="flex flex-col gap-4 xl:gap-6">
                    <div class="flex items-center gap-3 justify-between">
                        <div>
                            <p class="font-medium text-base sm:text-lg lg:text-xl mb-2">
                                Buzzworthy Moments
                            </p>
                            <span class="text-xs md:text-sm">Get notified about buzzworthy moments in real-time.</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <label for="buzzworthy" class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="buzzworthy" class="custom-checkbox sr-only" checked />
                                    <div class="block w-14 h-8 rounded-full bg bg-primary"></div>
                                    <div
                                        class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition translate-x-full">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 justify-between">
                        <div>
                            <p class="font-medium text-base sm:text-lg lg:text-xl mb-2">
                                Popular Trends
                            </p>
                            <span class="text-xs md:text-sm">Stay updated on popular trends and topics.</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <label for="popular-trends" class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="popular-trends" class="custom-checkbox sr-only" />
                                    <div class="block w-14 h-8 rounded-full bg bg-primary/20"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 justify-between">
                        <div>
                            <p class="font-medium text-base sm:text-lg lg:text-xl mb-2">
                                Trend Alerts
                            </p>
                            <span class="text-xs md:text-sm">Receive alerts for trending topics and discussions. </span>
                        </div>
                        <div class="flex items-center justify-center">
                            <label for="trend-alerts" class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="trend-alerts" class="custom-checkbox sr-only" />
                                    <div class="block w-14 h-8 rounded-full bg bg-primary/20"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Update notifications -->
            <div class="box xl:p-8 col-span-2 md:col-span-1">
                <div class="flex justify-between items-center bb-dashed mb-4 pb-4 3xl:">
                    <h4 class="h4">Update Notification</h4>
                    @include('partials._horizontal-options')
                </div>
                <div class="flex flex-col gap-4 xl:gap-6">
                    <div class="flex items-center gap-3 justify-between">
                        <div>
                            <p class="font-medium text-base sm:text-lg lg:text-xl mb-2">
                                System Updates
                            </p>
                            <span class="text-xs md:text-sm">Receive notifications for system updates and
                                improvements.</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <label for="system-update" class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="system-update" class="custom-checkbox sr-only" checked />
                                    <div class="block w-14 h-8 rounded-full bg bg-primary"></div>
                                    <div
                                        class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition translate-x-full">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 justify-between">
                        <div>
                            <p class="font-medium text-base sm:text-lg lg:text-xl mb-2">
                                App Upgrades
                            </p>
                            <span class="text-xs md:text-sm">Get alerted about the latest app upgrades and features.</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <label for="app-upgrade" class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="app-upgrade" class="custom-checkbox sr-only" />
                                    <div class="block w-14 h-8 rounded-full bg bg-primary/20"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 justify-between">
                        <div>
                            <p class="font-medium text-base sm:text-lg lg:text-xl mb-2">
                                Emergency Updates
                            </p>
                            <span class="text-xs md:text-sm">Stay informed with emergency system updates.</span>
                        </div>
                        <div class="flex items-center justify-center">
                            <label for="emegency-update" class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="emegency-update" class="custom-checkbox sr-only" />
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
@endsection