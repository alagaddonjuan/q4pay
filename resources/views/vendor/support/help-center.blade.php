@extends('layout.vendor')
@section('title', 'Help Center | Q4I Vendor Portal')

@section('content')
<div class="main-inner">
    
    <div class="bg-[#0878F8] rounded-3xl p-10 md:p-14 mb-8 text-center relative overflow-hidden">
        <i class="las la-store absolute -right-10 -bottom-10 text-9xl text-white/10"></i>
        <div class="relative z-10 max-w-2xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">Grow your social business.</h2>
            <p class="text-blue-100 mb-8">Search guides on how to use Escrow, generate payment links, and handle payouts.</p>
            
            <form class="flex bg-white rounded-full p-2 shadow-xl focus-within:ring-4 focus-within:ring-blue-400/30 transition-all">
                <div class="flex items-center pl-4 text-slate-400"><i class="las la-search text-xl"></i></div>
                <input type="text" placeholder="Search for 'How to create a payment link'..." class="flex-grow bg-transparent border-none outline-none px-4 text-sm text-slate-700" />
                <button class="bg-[#0878F8] hover:bg-blue-700 text-white rounded-full px-6 py-2.5 font-bold transition-colors">Search</button>
            </form>
        </div>
    </div>

    <div class="mb-8">
        <h4 class="font-bold text-slate-800 text-xl mb-4 border-b border-slate-200 pb-2">Selling on Q4I</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <div class="bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-md transition-all group flex items-start gap-4 cursor-pointer">
                <div class="size-12 rounded-xl bg-blue-50 text-[#0878F8] flex items-center justify-center shrink-0 group-hover:bg-[#0878F8] group-hover:text-white transition-colors">
                    <i class="las la-link text-2xl"></i>
                </div>
                <div>
                    <h5 class="font-bold text-slate-800 mb-1">Payment Links</h5>
                    <p class="text-xs text-slate-500">How to generate links for WhatsApp & Instagram.</p>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-md transition-all group flex items-start gap-4 cursor-pointer">
                <div class="size-12 rounded-xl bg-blue-50 text-[#0878F8] flex items-center justify-center shrink-0 group-hover:bg-[#0878F8] group-hover:text-white transition-colors">
                    <i class="las la-shield-alt text-2xl"></i>
                </div>
                <div>
                    <h5 class="font-bold text-slate-800 mb-1">Escrow Explained</h5>
                    <p class="text-xs text-slate-500">How buyers approve funds after receiving goods.</p>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-md transition-all group flex items-start gap-4 cursor-pointer">
                <div class="size-12 rounded-xl bg-blue-50 text-[#0878F8] flex items-center justify-center shrink-0 group-hover:bg-[#0878F8] group-hover:text-white transition-colors">
                    <i class="las la-money-bill-wave text-2xl"></i>
                </div>
                <div>
                    <h5 class="font-bold text-slate-800 mb-1">Getting Paid</h5>
                    <p class="text-xs text-slate-500">Adding your bank account and tracking withdrawals.</p>
                </div>
            </div>

        </div>
    </div>

    <div>
        <h4 class="font-bold text-slate-800 text-xl mb-4 border-b border-slate-200 pb-2">Popular Articles</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <div class="bg-white border border-slate-200 rounded-2xl p-6 hover:border-[#0878F8] transition-colors">
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-2.5 py-1 bg-red-50 text-red-600 text-[10px] font-bold uppercase tracking-wider rounded-full">Disputes</span>
                </div>
                <h5 class="font-bold text-slate-800 text-lg mb-2">Handling a Buyer Dispute</h5>
                <p class="text-sm text-slate-500 mb-5 leading-relaxed">What to do when a buyer claims they didn't receive the item or it arrived damaged.</p>
                <a href="#" class="inline-flex items-center gap-2 text-[#0878F8] font-bold text-sm hover:text-blue-800">
                    Read Article <i class="las la-arrow-right"></i>
                </a>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-6 hover:border-[#0878F8] transition-colors">
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-2.5 py-1 bg-green-50 text-green-600 text-[10px] font-bold uppercase tracking-wider rounded-full">Store</span>
                </div>
                <h5 class="font-bold text-slate-800 text-lg mb-2">Setting up your Storefront</h5>
                <p class="text-sm text-slate-500 mb-5 leading-relaxed">How to upload products, set prices, and customize your public Q4I seller profile.</p>
                <a href="#" class="inline-flex items-center gap-2 text-[#0878F8] font-bold text-sm hover:text-blue-800">
                    Read Article <i class="las la-arrow-right"></i>
                </a>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-6 hover:border-[#0878F8] transition-colors">
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-2.5 py-1 bg-purple-50 text-purple-600 text-[10px] font-bold uppercase tracking-wider rounded-full">Social</span>
                </div>
                <h5 class="font-bold text-slate-800 text-lg mb-2">Selling on WhatsApp</h5>
                <p class="text-sm text-slate-500 mb-5 leading-relaxed">Learn how to instantly send an escrow payment link to your customers in chat.</p>
                <a href="#" class="inline-flex items-center gap-2 text-[#0878F8] font-bold text-sm hover:text-blue-800">
                    Read Article <i class="las la-arrow-right"></i>
                </a>
            </div>

        </div>
    </div>

</div>
@endsection