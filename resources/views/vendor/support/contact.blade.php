@extends('layout.vendor')
@section('title', 'Contact Support | Q4I Vendor Portal')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div>
            <h2 class="h2 text-[#0878F8]">Vendor Support</h2>
            <p class="text-sm text-slate-500 mt-1">Need help with a buyer dispute or payout? We are here for you.</p>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6">
        
        <div class="col-span-12 lg:col-span-7 xxl:col-span-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50">
                    <h4 class="font-bold text-[#0878F8] text-lg">Send us a message</h4>
                </div>
                
                <form class="p-6 md:p-8 grid grid-cols-2 gap-5 xl:gap-6">
                    <div class="col-span-2 md:col-span-1">
                        <label for="name" class="text-sm font-bold text-slate-700 block mb-2">Store Name</label>
                        <input type="text" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#0878F8] focus:ring-2 focus:ring-[#0878F8]/20 outline-none transition-all" placeholder="Enter Store Name" id="name" required />
                    </div>
                    
                    <div class="col-span-2 md:col-span-1">
                        <label for="email" class="text-sm font-bold text-slate-700 block mb-2">Email Address</label>
                        <input type="email" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#0878F8] focus:ring-2 focus:ring-[#0878F8]/20 outline-none transition-all" placeholder="store@example.com" id="email" required />
                    </div>
                    
                    <div class="col-span-2 md:col-span-1">
                        <label for="phone" class="text-sm font-bold text-slate-700 block mb-2">WhatsApp Number</label>
                        <input type="text" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#0878F8] focus:ring-2 focus:ring-[#0878F8]/20 outline-none transition-all" placeholder="Enter WhatsApp Number" id="phone" required />
                    </div>
                    
                    <div class="col-span-2 md:col-span-1">
                        <label for="category" class="text-sm font-bold text-slate-700 block mb-2">What do you need help with?</label>
                        <select id="category" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#0878F8] outline-none transition-all">
                            <option value="payout">Missing or Delayed Payout</option>
                            <option value="dispute">Buyer Dispute / Escrow</option>
                            <option value="store">Storefront Setup</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="col-span-2">
                        <label for="message" class="text-sm font-bold text-slate-700 block mb-2">Message</label>
                        <textarea rows="5" class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#0878F8] focus:ring-2 focus:ring-[#0878F8]/20 outline-none transition-all" placeholder="Please provide transaction IDs if applicable..." id="message" required></textarea>
                    </div>
                    
                    <div class="col-span-2 pt-2 border-t border-slate-100">
                        <button class="bg-[#0878F8] hover:bg-blue-700 text-white font-bold px-8 py-3.5 rounded-xl shadow-lg shadow-[#0878F8]/20 transition-all transform hover:-translate-y-0.5">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-span-12 lg:col-span-5 xxl:col-span-4 space-y-4">
            
            <div class="bg-gradient-to-br from-[#0878F8] to-blue-800 text-white p-8 rounded-2xl shadow-lg shadow-[#0878F8]/20 relative overflow-hidden">
                <i class="las la-comments absolute -right-4 -bottom-4 text-8xl opacity-10"></i>
                <div class="relative z-10">
                    <h5 class="text-xl font-bold mb-2 flex items-center gap-2">
                        <i class="lab la-whatsapp text-3xl text-green-400"></i> WhatsApp Support
                    </h5>
                    <p class="text-blue-100 text-sm mb-6 leading-relaxed">The fastest way to reach our Vendor Success team is directly through WhatsApp. We are online 24/7.</p>
                    <button class="bg-white text-[#0878F8] hover:bg-slate-50 px-6 py-3 rounded-xl font-bold text-sm transition-colors w-full sm:w-auto">
                        Chat with us
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex items-center gap-5 hover:border-[#0878F8] transition-colors mt-4">
                <div class="size-14 shrink-0 bg-blue-50 text-[#0878F8] rounded-full flex items-center justify-center border border-blue-100">
                    <i class="las la-envelope-open text-3xl"></i>
                </div>
                <div>
                    <h5 class="text-lg font-bold text-slate-800 mb-1">Email Support</h5>
                    <p class="text-sm text-slate-500">vendors@q4iltd.com</p>
                </div>
            </div>

            <!-- Social Links Block -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col justify-center items-center gap-4 hover:border-[#0878F8] transition-colors mt-4">
                <h5 class="text-lg font-bold text-slate-800">Connect With Us</h5>
                <div class="w-full flex justify-center">
                    @include('partials._social')
                </div>
            </div>

        </div>
    </div>
</div>
@endsection