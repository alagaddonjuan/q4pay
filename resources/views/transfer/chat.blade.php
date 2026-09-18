@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Chat</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <!-- chat -->
        <button
            class="md:hidden flex items-center gap-2 min-w-max py-2 px-3 relative z-3 rounded-lg bg-primary text-white chatbtn">
            <i class="las la-user-friends shrink-0"></i> <span>Contacts</span>
        </button>

        <div class="rounded-2xl bg-n0  shadow-3 grid grid-cols-12 relative max-md:mt-3">
            <div id="chat-sidebar"
                class="p-2 sm:p-4 duration-500 md:p-6 xl:p-8 max-md:w-[280px] max-md:max-h-[600px] max-md:overflow-y-auto max-md:rounded-xl max-md:absolute ltr:max-md:left-0 rtl:max-md:right-0 z-3 max-md:bg-n0 max-md: max-md:top-0 md:col-span-5 xxl:col-span-4 md:border-r border-n30  chathide">
                <div class="flex items-center justify-between flex-wrap">
                    <div class="w-10 h-10 md:w-14 md:h-14 rounded-full overflow-hidden shrink-0">
                        <img width="60" height="60" src="{{ asset('assets/images/user.png') }}" alt="image"
                            class="w-full h-full object-fit-cover" />
                    </div>
                    <div class="flex gap-3 items-center justify-content-end flex-wrap">
                        <button class="inline-block shrink-0 hover:text-primary">
                            <i class="las la-pencil-alt"></i>
                        </button>
                        @include('partials._horizontal-options')
                    </div>
                </div>
                <form class="flex items-center p-2 border border-n30  bg-secondary/5  rounded-full my-6">
                    <input type="text" placeholder="Search" class="w-full  lg:px-6 bg-transparent border-0" />
                    <button type="button"
                        class="grid place-content-center  w-10 h-10 rounded-full border-0 bg-primary text-white shrink-0">
                        <i class="las la-search"></i>
                    </button>
                </form>
                <div class="max-h-[600px] overflow-y-auto scrollbar-hidden mt-5 md:mt-0" style="overflow-y: auto">
                    <ul class="flex flex-col gap-2">
                        <li>
                            <div
                                class="flex flex-wrap items-center cursor-pointer gap-4 p-2 justify-center md:justify-start rounded-lg bg-secondary/10  duration-300">
                                <div class="md:w-11 md:h-11 w-8 h-8 relative z-1 rounded-full shrink-0">
                                    <img width="44" height="44" src="{{ asset('assets/images/user-5.png') }}" alt="image"
                                        class="w-full h-full object-fit-cover overflow-hidden rounded-full" />
                                    <span
                                        class="inline-block w-1.5 h-1.5 rounded-full bg-warningdark absolute right-1 bottom-1 z-1"></span>
                                </div>
                                <div class="flex-grow flex items-center justify-between gap-4">
                                    <div class="flex-grow">
                                        <p class="font-semibold mb-1"> John Smith </p>
                                        <span class="block text-xs">Just ideas for next time</span>
                                    </div>
                                    <div class="shrink-0 inline-block text-center">
                                        <div class="grid place-content-center w-6 h-6 rounded-full bg-primary text-white">
                                            <span class="text-sm lh-1">3</span>
                                        </div>
                                        <span class="inline-block text-xs">
                                            4m
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div
                                class="flex flex-wrap items-center cursor-pointer gap-4 p-2 justify-center md:justify-start rounded-lg hover:bg-secondary/10  duration-300">
                                <div class="md:w-11 md:h-11 w-8 h-8 relative z-1 rounded-full shrink-0">
                                    <img width="44" height="44" src="{{ asset('assets/images/user-3.png') }}" alt="image"
                                        class="w-full h-full object-fit-cover overflow-hidden rounded-full" />
                                    <span
                                        class="inline-block w-1.5 h-1.5 rounded-full bg-warningdark absolute right-1 bottom-1 z-1"></span>
                                </div>
                                <div class="flex-grow flex items-center justify-between gap-4">
                                    <div class="flex-grow">
                                        <p class="font-semibold mb-1"> Emma Johnson </p>
                                        <span class="block text-xs">Just next time</span>
                                    </div>
                                    <div class="shrink-0 inline-block text-center">
                                        <div class="grid place-content-center w-6 h-6 rounded-full bg-primary text-white">
                                            <span class="text-sm lh-1">3</span>
                                        </div>
                                        <span class="inline-block text-xs">
                                            4m
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div
                                class="flex flex-wrap items-center cursor-pointer gap-4 p-2 justify-center md:justify-start rounded-lg hover:bg-secondary/10  duration-300">
                                <div class="md:w-11 md:h-11 w-8 h-8 relative z-1 rounded-full shrink-0">
                                    <img width="44" height="44" src="{{ asset('assets/images/user-1.png') }}" alt="image"
                                        class="w-full h-full object-fit-cover overflow-hidden rounded-full" />
                                    <span
                                        class="inline-block w-1.5 h-1.5 rounded-full bg-warningdark absolute right-1 bottom-1 z-1"></span>
                                </div>
                                <div class="flex-grow flex items-center justify-between gap-4">
                                    <div class="flex-grow">
                                        <p class="font-semibold mb-1"> Luam Jones </p>
                                        <span class="block text-xs">Just ideas for next time</span>
                                    </div>
                                    <div class="shrink-0 inline-block text-center">
                                        <span class="inline-block text-xs">
                                            8m
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div
                                class="flex flex-wrap items-center cursor-pointer gap-4 p-2 justify-center md:justify-start rounded-lg hover:bg-secondary/10  duration-300">
                                <div class="md:w-11 md:h-11 w-8 h-8 relative z-1 rounded-full shrink-0">
                                    <img width="44" height="44" src="{{ asset('assets/images/user-3.png') }}" alt="image"
                                        class="w-full h-full object-fit-cover overflow-hidden rounded-full" />
                                    <span
                                        class="inline-block w-1.5 h-1.5 rounded-full bg-warningdark absolute right-1 bottom-1 z-1"></span>
                                </div>
                                <div class="flex-grow flex items-center justify-between gap-4">
                                    <div class="flex-grow">
                                        <p class="font-semibold mb-1"> Sophia Davis </p>
                                        <span class="block text-xs">Just ideas for next time</span>
                                    </div>
                                    <div class="shrink-0 inline-block text-center">
                                        <div class="grid place-content-center w-6 h-6 rounded-full bg-primary text-white">
                                            <span class="text-sm lh-1">3</span>
                                        </div>
                                        <span class="inline-block text-xs">
                                            14m
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div
                                class="flex flex-wrap items-center cursor-pointer gap-4 p-2 justify-center md:justify-start rounded-lg hover:bg-secondary/10  duration-300">
                                <div class="md:w-11 md:h-11 w-8 h-8 relative z-1 rounded-full shrink-0">
                                    <img width="44" height="44" src="{{ asset('assets/images/user-2.png') }}" alt="image"
                                        class="w-full h-full object-fit-cover overflow-hidden rounded-full" />
                                    <span
                                        class="inline-block w-1.5 h-1.5 rounded-full bg-warningdark absolute right-1 bottom-1 z-1"></span>
                                </div>
                                <div class="flex-grow flex items-center justify-between gap-4">
                                    <div class="flex-grow">
                                        <p class="font-semibold mb-1"> William Wilson</p>
                                        <span class="block text-xs">Just ideas for next time</span>
                                    </div>
                                    <div class="shrink-0 inline-block text-center">
                                        <span class="inline-block text-xs">
                                            4h
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div
                                class="flex flex-wrap items-center cursor-pointer gap-4 p-2 justify-center md:justify-start rounded-lg hover:bg-secondary/10  duration-300">
                                <div class="md:w-11 md:h-11 w-8 h-8 relative z-1 rounded-full shrink-0">
                                    <img width="44" height="44" src="{{ asset('assets/images/user-3.png') }}" alt="image"
                                        class="w-full h-full object-fit-cover overflow-hidden rounded-full" />
                                    <span
                                        class="inline-block w-1.5 h-1.5 rounded-full bg-warningdark absolute right-1 bottom-1 z-1"></span>
                                </div>
                                <div class="flex-grow flex items-center justify-between gap-4">
                                    <div class="flex-grow">
                                        <p class="font-semibold mb-1"> Amelia Lee </p>
                                        <span class="block text-xs">Just ideas for next time</span>
                                    </div>
                                    <div class="shrink-0 inline-block text-center">

                                        <span class="inline-block text-xs">
                                            4m
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div
                                class="flex flex-wrap items-center cursor-pointer gap-4 p-2 justify-center md:justify-start rounded-lg hover:bg-secondary/10  duration-300">
                                <div class="md:w-11 md:h-11 w-8 h-8 relative z-1 rounded-full shrink-0">
                                    <img width="44" height="44" src="{{ asset('assets/images/user-7.png') }}" alt="image"
                                        class="w-full h-full object-fit-cover overflow-hidden rounded-full" />
                                    <span
                                        class="inline-block w-1.5 h-1.5 rounded-full bg-warningdark absolute right-1 bottom-1 z-1"></span>
                                </div>
                                <div class="flex-grow flex items-center justify-between gap-4">
                                    <div class="flex-grow">
                                        <p class="font-semibold mb-1"> John Smith </p>
                                        <span class="block text-xs">Just ideas for next time</span>
                                    </div>
                                    <div class="shrink-0 inline-block text-center">
                                        <span class="inline-block text-xs">
                                            4m
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div
                                class="flex flex-wrap items-center cursor-pointer gap-4 p-2 justify-center md:justify-start rounded-lg hover:bg-secondary/10  duration-300">
                                <div class="md:w-11 md:h-11 w-8 h-8 relative z-1 rounded-full shrink-0">
                                    <img width="44" height="44" src="{{ asset('assets/images/user-5.png') }}" alt="image"
                                        class="w-full h-full object-fit-cover overflow-hidden rounded-full" />
                                    <span
                                        class="inline-block w-1.5 h-1.5 rounded-full bg-warningdark absolute right-1 bottom-1 z-1"></span>
                                </div>
                                <div class="flex-grow flex items-center justify-between gap-4">
                                    <div class="flex-grow">
                                        <p class="font-semibold mb-1"> Amber Hard </p>
                                        <span class="block text-xs">Just ideas for next time</span>
                                    </div>
                                    <div class="shrink-0 inline-block text-center">

                                        <span class="inline-block text-xs">
                                            4m
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div
                                class="flex flex-wrap items-center cursor-pointer gap-4 p-2 justify-center md:justify-start rounded-lg hover:bg-secondary/10  duration-300">
                                <div class="md:w-11 md:h-11 w-8 h-8 relative z-1 rounded-full shrink-0">
                                    <img width="44" height="44" src="{{ asset('assets/images/user-4.png') }}" alt="image"
                                        class="w-full h-full object-fit-cover overflow-hidden rounded-full" />
                                    <span
                                        class="inline-block w-1.5 h-1.5 rounded-full bg-warningdark absolute right-1 bottom-1 z-1"></span>
                                </div>
                                <div class="flex-grow flex items-center justify-between gap-4">
                                    <div class="flex-grow">
                                        <p class="font-semibold mb-1"> John Smith </p>
                                        <span class="block text-xs">Just ideas for next time</span>
                                    </div>
                                    <div class="shrink-0 inline-block text-center">
                                        <span class="inline-block text-xs">
                                            4m
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div
                                class="flex flex-wrap items-center cursor-pointer gap-4 p-2 justify-center md:justify-start rounded-lg hover:bg-secondary/10  duration-300">
                                <div class="md:w-11 md:h-11 w-8 h-8 relative z-1 rounded-full shrink-0">
                                    <img width="44" height="44" src="{{ asset('assets/images/user-3.png') }}" alt="image"
                                        class="w-full h-full object-fit-cover overflow-hidden rounded-full" />
                                    <span
                                        class="inline-block w-1.5 h-1.5 rounded-full bg-warningdark absolute right-1 bottom-1 z-1"></span>
                                </div>
                                <div class="flex-grow flex items-center justify-between gap-4">
                                    <div class="flex-grow">
                                        <p class="font-semibold mb-1"> John Smith </p>
                                        <span class="block text-xs">Just ideas for next time</span>
                                    </div>
                                    <div class="shrink-0 inline-block text-center">
                                        <span class="inline-block text-xs">
                                            2d
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-span-12 md:col-span-7 xxl:col-span-8">
                <div class="chat-box__content-head p-4 md:p-6">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 md:w-14 md:h-14 relative z-1 rounded-full shrink-0">
                                <img width="60" height="60" src="{{ asset('assets/images/user-10.png') }}" alt="image"
                                    class="rounded-full" />
                                <span
                                    class="inline-block w-1.5 h-1.5 rounded-full bg-warningdark absolute right-0.5 bottom-0.5 z-1"></span>
                            </div>
                            <h5 class="flex-grow">
                                John Smith
                            </h5>
                        </div>
                        <div class="flex gap-3 items-center justify-content-end flex-wrap">
                            <a href="#" class="inline-block shrink-0 hover:text-primary">
                                <i class="las la-phone"></i>
                            </a>
                            <a href="#" class="inline-block shrink-0 hover:text-primary">
                                <i class="las la-video"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div id="chatbox"
                    class="max-h-[640px] md:min-h-[620px] scrollbar-hidden bg-secondary/5  p-4 md:p-6 xl:py-8 overflow-y-auto mx-3 lg:mx-6 rounded-2xl">
                    <ul class="flex flex-col justify-end">
                        <li>
                            <div class="flex flex-col items-start">
                                <div class="w-8 h-8 xl:w-12 xl:h-12 md:mb-2">
                                    <img width="48" height="48" src="{{ asset('assets/images/user-1.png') }}" alt="image"
                                        class="rounded-full " />
                                </div>
                                <div
                                    class="bg-n0  rounded-lg py-2 xxl:py-3 px-3 xxl:px-5 md:max-w-[55%] my-2 relative arrow-top ">
                                    <p class="text-sm md:text-base">Hi</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex flex-col items-end">
                                <div
                                    class="bg-primary text-white  rounded-lg py-2 xxl:py-3 px-3 xxl:px-5 md:max-w-[55%] my-2 relative arrow-bottom ">
                                    <p class="text-sm md:text-base">Hello</p>
                                </div>
                                <div class="w-8 h-8 xl:w-12 xl:h-12 mt-2">
                                    <img width="48" height="48" src="{{ asset('assets/images/user-2.png') }}" alt="image"
                                        class="rounded-full " />
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex flex-col items-start">
                                <div class="w-8 h-8 xl:w-12 xl:h-12 md:mb-2">
                                    <img width="48" height="48" src="{{ asset('assets/images/user-1.png') }}" alt="image"
                                        class="rounded-full " />
                                </div>
                                <div
                                    class="bg-n0  rounded-lg py-2 xxl:py-3 px-3 xxl:px-5 md:max-w-[55%] my-2 relative arrow-top ">
                                    <p class="text-sm md:text-base">How are you? my friend?</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex flex-col items-end">
                                <div
                                    class="bg-primary text-white  rounded-lg py-2 xxl:py-3 px-3 xxl:px-5 md:max-w-[55%] my-2 relative arrow-bottom ">
                                    <p class="text-sm md:text-base">I am fine. What about you?</p>
                                </div>
                                <div class="w-8 h-8 xl:w-12 xl:h-12 mt-2">
                                    <img width="48" height="48" src="{{ asset('assets/images/user-2.png') }}" alt="image"
                                        class="rounded-full " />
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex flex-col items-start">
                                <div class="w-8 h-8 xl:w-12 xl:h-12 md:mb-2">
                                    <img width="48" height="48" src="{{ asset('assets/images/user-1.png') }}" alt="image"
                                        class="rounded-full " />
                                </div>
                                <div
                                    class="bg-n0  rounded-lg py-2 xxl:py-3 px-3 xxl:px-5 md:max-w-[55%] my-2 relative arrow-top ">
                                    <p class="text-sm md:text-base">Good. lets go fo </p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="flex flex-col items-end">
                                <div
                                    class="bg-primary text-white  rounded-lg py-2 xxl:py-3 px-3 xxl:px-5 md:max-w-[55%] my-2 relative arrow-bottom ">
                                    <p class="text-sm md:text-base">Ok thanks</p>
                                </div>
                                <div class="w-8 h-8 xl:w-12 xl:h-12 mt-2">
                                    <img width="48" height="48" src="{{ asset('assets/images/user-2.png') }}" alt="image"
                                        class="rounded-full " />
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="p-4 flex items-center max-[479px]:flex-wrap gap-4">
                    <div class="flex items-center justify-between max-w-[150px] gap-4 shrink-0">
                        <div class="shrink-0">
                            <label for="file" class="inline-block hover:text-primary cursor-pointer">
                                <input type="file" name="file" id="file" class="hidden" />
                                <i class="las la-plus-circle"></i>
                            </label>
                        </div>
                        <div class="shrink-0">
                            <button class="inline-block hover:text-primary">
                                <i class="las la-microphone"></i>
                            </button>
                        </div>
                        <div class="shrink-0">
                            <label for="img" class="inline-block hover:text-primary">
                                <input type="file" name="img" id="img" class="hidden" />
                                <i class="las la-camera"></i>
                            </label>
                        </div>
                        <div class="shrink-0">
                            <button class="inline-block hover:text-primary">
                                <i class="las la-smile"></i>
                            </button>
                        </div>
                    </div>
                    <form class="flex items-center flex-grow p-1 md:p-2 border border-n30  bg-secondary/5  rounded-full">
                        <input type="text" placeholder="Type message..."
                            class="w-full bg-transparent  px-3 md:px-6 border-0 flex-grow" />
                        <button type="submit"
                            class="grid place-content-center w-8 md:w-10 h-8 md:h-10 rounded-full border-0 bg-primary text-white shrink-0">
                            <i class="las la-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection