@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Social Network</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="flex flex-col gap-4 xxl:gap-6">
            <!-- Extensions -->
            <div class="box xl:p-8">
                <div class="flex justify-between items-center  bb-dashed mb-4 pb-4 3xl:">
                    <h4 class="h4">Extensions</h4>
                    @include('partials._horizontal-options')
                </div>
                <!-- Extensions -->
                <div class="flex flex-col gap-4 xxl:gap-6">
                    <div
                        class="p-4 sm:p-5 md:p-6 bg-primary/5  rounded-xl border border-n30 gap-4  flex flex-wrap justify-between items-center">
                        <div class="flex items-center gap-4 md:gap-6">
                            <div class="bg-n0  rounded-full text-primary py-2 px-3 text-3xl">
                                <i class="lab la-dropbox text-3xl"></i>
                            </div>
                            <div>
                                <p class="text-xs mb-2">Dropbox</p>
                                <p class="text-lg lg:text-xl font-medium">@example.info</p>
                            </div>
                        </div>
                        <button class="btn-outline">Remove</button>
                    </div>
                    <div
                        class="p-4 sm:p-5 md:p-6 bg-primary/5  rounded-xl border border-n30 gap-4  flex flex-wrap justify-between items-center">
                        <div class="flex items-center gap-4 md:gap-6">
                            <div class="bg-n0  rounded-full text-primary py-2 px-3 text-3xl">
                                <i class="lab la-google-drive text-3xl"></i>
                            </div>
                            <div>
                                <p class="text-xs mb-2">Google Drive</p>
                                <p class="text-lg lg:text-xl font-medium">@example.info</p>
                            </div>
                        </div>
                        <button class="btn-outline">Remove</button>
                    </div>
                    <div
                        class="p-4 sm:p-5 md:p-6 bg-primary/5  rounded-xl border border-n30 gap-4  flex flex-wrap justify-between items-center">
                        <div class="flex items-center gap-4 md:gap-6">
                            <div class="bg-n0  rounded-full text-primary py-2 px-3 text-3xl">
                                <i class="lab la-microsoft text-3xl"></i>
                            </div>
                            <div>
                                <p class="text-xs mb-2">Microsoft Onedrive</p>
                                <p class="text-lg lg:text-xl font-medium">@example.info</p>
                            </div>
                        </div>
                        <button class="btn-outline">Remove</button>
                    </div>

                </div>
                <button class="btn-outline mt-6">
                    <i class="las la-plus-circle"></i> Add More
                </button>
            </div>
            <!-- SOcial Media -->
            <div class="box xl:p-8">
                <div class="flex justify-between items-center  bb-dashed mb-4 pb-4 3xl:">
                    <h4 class="h4">Social Media</h4>
                    @include('partials._horizontal-options')

                </div>
                <div class="flex flex-col gap-4 xxl:gap-6">

                    <div
                        class="p-4 sm:p-5 md:p-6 bg-primary/5  flex-wrap gap-4 rounded-xl border border-n30  flex justify-between items-center">
                        <div class="flex items-center gap-4 md:gap-6">
                            <div class="bg-n0  rounded-full text-primary py-2 px-3 text-3xl">
                                <i class="lab la-facebook-f text-3xl"></i>
                            </div>
                            <div>
                                <p class="text-xs mb-2">Facebook</p>
                                <p class="text-lg lg:text-xl font-medium">www.example.com</p>
                            </div>
                        </div>
                        <button class="btn-outline">
                            Disconnect
                        </button>
                    </div>
                    <div
                        class="p-4 sm:p-5 md:p-6 bg-primary/5  flex-wrap gap-4 rounded-xl border border-n30  flex justify-between items-center">
                        <div class="flex items-center gap-4 md:gap-6">
                            <div class="bg-n0  rounded-full text-primary py-2 px-3 text-3xl">
                                <i class="lab la-twitter text-3xl"></i>
                            </div>
                            <div>
                                <p class="text-xs mb-2">Twitter</p>
                                <p class="text-lg lg:text-xl font-medium">www.example.com</p>
                            </div>
                        </div>
                        <button class="btn-outline">
                            Connect
                        </button>
                    </div>
                    <div
                        class="p-4 sm:p-5 md:p-6 bg-primary/5  flex-wrap gap-4 rounded-xl border border-n30  flex justify-between items-center">
                        <div class="flex items-center gap-4 md:gap-6">
                            <div class="bg-n0  rounded-full text-primary py-2 px-3 text-3xl">
                                <i class="lab la-linkedin text-3xl"></i>
                            </div>
                            <div>
                                <p class="text-xs mb-2">LinkedIn</p>
                                <p class="text-lg lg:text-xl font-medium">www.example.com</p>
                            </div>
                        </div>
                        <button class="btn-outline">
                            Connect
                        </button>
                    </div>
                    <div
                        class="p-4 sm:p-5 md:p-6 bg-primary/5  flex-wrap gap-4 rounded-xl border border-n30  flex justify-between items-center">
                        <div class="flex items-center gap-4 md:gap-6">
                            <div class="bg-n0  rounded-full text-primary py-2 px-3 text-3xl">
                                <i class="lab la-snapchat text-3xl"></i>
                            </div>
                            <div>
                                <p class="text-xs mb-2">Snapchat</p>
                                <p class="text-lg lg:text-xl font-medium">www.example.com</p>
                            </div>
                        </div>
                        <button class="btn-outline">
                            Connect
                        </button>
                    </div>
                    <div
                        class="p-4 sm:p-5 md:p-6 bg-primary/5  flex-wrap gap-4 rounded-xl border border-n30  flex justify-between items-center">
                        <div class="flex items-center gap-4 md:gap-6">
                            <div class="bg-n0  rounded-full text-primary py-2 px-3 text-3xl">
                                <i class="lab la-pinterest text-3xl"></i>
                            </div>
                            <div>
                                <p class="text-xs mb-2">Pinterest</p>
                                <p class="text-lg lg:text-xl font-medium">www.example.com</p>
                            </div>
                        </div>
                        <button class="btn-outline">
                            Connect
                        </button>
                    </div>


                </div>
                <button class="btn-outline mt-6">
                    <i class="las la-plus-circle"></i> Add More
                </button>
            </div>
        </div>
    </div>
@endsection