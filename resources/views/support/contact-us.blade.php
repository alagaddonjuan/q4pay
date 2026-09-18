@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Contact Us</h2>
            <button class="btn-primary ac-modal-btn">
                <i class="las la-plus-circle text-base md:text-lg"></i>
                Open an Account
            </button>
        </div>

        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            <div class="col-span-12 lg:col-span-7 xxl:col-span-8">
                <div class="box xl:p-8">
                    <h4 class="h4 bb-dashed mb-4 pb-4 3xl:">
                        Get in touch with us.
                    </h4>
                    <form class="grid grid-cols-2 gap-4 xl:gap-6">
                        <div class="col-span-2 md:col-span-1">
                            <label for="name" class="md:text-lg font-medium block mb-4">
                                Name
                            </label>
                            <input type="text"
                                class="w-full text-sm bg-secondary/5  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Your Name" id="name" required />
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label for="email" class="md:text-lg font-medium block mb-4">
                                Email
                            </label>
                            <input type="email"
                                class="w-full text-sm bg-secondary/5  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Your Email" id="email" required />
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label for="phone" class="md:text-lg font-medium block mb-4">
                                Phone
                            </label>
                            <input type="number"
                                class="w-full text-sm bg-secondary/5  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Your Number" id="phone" required />
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label for="country" class="md:text-lg font-medium block mb-4">
                                Country
                            </label>
                            <select name="sort" class="nc-select full">
                                <option value="usa">USA</option>
                                <option value="uk">UK</option>
                                <option value="canada">Canada</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="message" class="md:text-lg font-medium block mb-4">
                                Message
                            </label>
                            <textarea rows="5"
                                class="w-full text-sm bg-secondary/5  border border-n30  rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Your Message..." id="message" required></textarea>
                        </div>
                        <div class="col-span-2">
                            <button class="btn-primary px-6">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-5 xxl:col-span-4">
                <div class="box xl:p-8">
                    <h4 class="h4 bb-dashed mb-4 pb-4 3xl:">
                        Need more help?
                    </h4>
                    <div class="flex flex-col gap-4 xxl:gap-6">
                        <div
                            class="box bg-secondary/5  xl:p-4 xxl:p-6 flex items-center gap-4 xxl:gap-6 3xl:gap-8 border border-n30 ">
                            <div
                                class="bg-n0  text-primary w-14 h-14 3xl:w-[84px] 3xl:h-[84px] shrink-0 flex items-center justify-center rounded-full border border-n30 ">
                                <i class="las la-phone-volume text-4xl"></i>
                            </div>
                            <div>
                                <h5 class="text-xl font-medium mb-1 md:mb-2 xxl:mb-3">
                                    Call Now
                                </h5>
                                <div class="text-sm">
                                    <p class="mb-1">(907) 555-0101</p>
                                    <p>(252) 555-0126</p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="box bg-secondary/5  xl:p-6 flex items-center gap-4 xxl:gap-6 3xl:gap-8 border border-n30 ">
                            <div
                                class="bg-n0  text-primary w-14 h-14 3xl:w-[84px] 3xl:h-[84px] shrink-0 flex items-center justify-center rounded-full border border-n30 ">
                                <i class="las la-envelope-open text-4xl"></i>
                            </div>
                            <div>
                                <h5 class="text-xl font-medium mb-1 md:mb-2 xxl:mb-3">
                                    Email Address
                                </h5>
                                <div class="text-sm">
                                    <p class="mb-1">info@example.com</p>
                                    <p>info2@example.com</p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="box bg-secondary/5  xl:p-6 flex items-center gap-4 xxl:gap-6 3xl:gap-8 border border-n30 ">
                            <div
                                class="bg-n0  text-primary min w-14 h-14 3xl:w-[84px] 3xl:h-[84px] shrink-0 flex items-center justify-center rounded-full border border-n30 ">
                                <i class="las la-map-marker text-4xl"></i>
                            </div>
                            <div>
                                <h5 class="text-lg md:text-xl font-medium mb-3">Location</h5>
                                <div class="text-sm">
                                    <p>2118 Thornridge Cir. Syracuse, Connecticut 35624</p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="box bg-secondary/5  xl:p-6 flex flex-col justify-center items-center gap-4 border border-n30 ">
                            <h5 class="text-lg md:text-xl font-medium">Connect With Us</h5>
                            <div class="w-full flex justify-center mt-2">
                                @include('partials._social')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12">
                <div class="box xl:p-6">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d14594.420868364632!2d90.38272851617783!3d23.86814853155446!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1702450501605!5m2!1sen!2sbd"
                        width="100%" height="450" style="border: 0" class="rounded-xl border border-n30 "
                        allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection