@extends('layout.merchant')
@section('title', 'Contact Support | Q4I Corporate Gateway')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div>
            <h2 class="h2 text-[#003366]">Contact Operations</h2>
            <p class="text-sm text-slate-500 mt-1">Get in touch with our technical and merchant success teams.</p>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6">
        
        <div class="col-span-12 lg:col-span-7 xxl:col-span-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50">
                    <h4 class="font-bold text-[#003366] text-lg">Submit a Support Ticket</h4>
                </div>
                
                <form class="p-6 md:p-8 grid grid-cols-2 gap-5 xl:gap-6">
                    <div class="col-span-2 md:col-span-1">
                        <label for="name" class="text-sm font-bold text-[#003366] block mb-2">Representative Name</label>
                        <input type="text" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#003366] focus:ring-2 focus:ring-[#003366]/20 outline-none transition-all" placeholder="Enter Your Name" id="name" required />
                    </div>
                    
                    <div class="col-span-2 md:col-span-1">
                        <label for="email" class="text-sm font-bold text-[#003366] block mb-2">Corporate Email</label>
                        <input type="email" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#003366] focus:ring-2 focus:ring-[#003366]/20 outline-none transition-all" placeholder="name@company.com" id="email" required />
                    </div>
                    
                    <div class="col-span-2 md:col-span-1">
                        <label for="phone" class="text-sm font-bold text-[#003366] block mb-2">Phone Number</label>
                        <input type="text" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#003366] focus:ring-2 focus:ring-[#003366]/20 outline-none transition-all" placeholder="Enter Phone Number" id="phone" required />
                    </div>
                    
                    <div class="col-span-2 md:col-span-1">
                        <label for="category" class="text-sm font-bold text-[#003366] block mb-2">Issue Category</label>
                        <select id="category" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#003366] outline-none transition-all">
                            <option value="api">API & Webhooks</option>
                            <option value="settlement">Settlements & Payouts</option>
                            <option value="virtual_accounts">Virtual Accounts</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="col-span-2">
                        <label for="message" class="text-sm font-bold text-[#003366] block mb-2">Detailed Message</label>
                        <textarea rows="5" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#003366] focus:ring-2 focus:ring-[#003366]/20 outline-none transition-all" placeholder="Describe your issue..." id="message" required></textarea>
                    </div>
                    
                    <div class="col-span-2 pt-2 border-t border-slate-100">
                        <button class="bg-[#003366] hover:bg-blue-900 text-white font-bold px-8 py-3.5 rounded-xl shadow-lg shadow-[#003366]/20 transition-all transform hover:-translate-y-0.5">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-span-12 lg:col-span-5 xxl:col-span-4 space-y-4">
            
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center gap-5 hover:border-[#003366] transition-colors">
                <div class="size-14 shrink-0 bg-[#003366]/10 text-[#003366] rounded-full flex items-center justify-center border border-[#003366]/20">
                    <i class="las la-phone-volume text-3xl"></i>
                </div>
                <div>
                    <h5 class="text-lg font-bold text-[#003366] mb-1">NOC Operations Line</h5>
                    <p class="text-sm text-slate-500">0800 Q4I HELP</p>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center gap-5 hover:border-[#D20103] transition-colors">
                <div class="size-14 shrink-0 bg-[#D20103]/10 text-[#D20103] rounded-full flex items-center justify-center border border-[#D20103]/20">
                    <i class="las la-envelope-open text-3xl"></i>
                </div>
                <div>
                    <h5 class="text-lg font-bold text-[#003366] mb-1">Support Email</h5>
                    <p class="text-sm text-slate-500">merchants@q4iltd.com</p>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center gap-5 hover:border-[#003366] transition-colors">
                <div class="size-14 shrink-0 bg-[#003366]/10 text-[#003366] rounded-full flex items-center justify-center border border-[#003366]/20">
                    <i class="las la-map-marker text-3xl"></i>
                </div>
                <div>
                    <h5 class="text-lg font-bold text-[#003366] mb-1">Headquarters</h5>
                    <p class="text-sm text-slate-500">Lagos, Nigeria</p>
                </div>
            </div>

            <!-- Social Links Block -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col justify-center items-center gap-4 hover:border-[#003366] transition-colors">
                <h5 class="text-lg font-bold text-[#003366]">Connect With Us</h5>
                <div class="w-full flex justify-center">
                    @include('partials._social-merchant')
                </div>
            </div>

        </div>

        <div class="col-span-12 mt-4">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126844.06232704177!2d3.2844598165681403!3d6.536645391216694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b8b2ae68280c1%3A0xdc9e87a367c3d9cb!2sLagos!5e0!3m2!1sen!2sng!4v1700000000000!5m2!1sen!2sng" width="100%" height="400" style="border: 0; border-radius: 12px;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection