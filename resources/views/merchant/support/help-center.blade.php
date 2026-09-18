@extends('layout.merchant')
@section('title', 'Help Center | Q4I Corporate Gateway')

@section('content')
<div class="main-inner">
    
    <div class="bg-[#003366] rounded-3xl p-10 md:p-14 mb-8 text-center relative overflow-hidden">
        <i class="las la-life-ring absolute -right-10 -bottom-10 text-9xl text-white/5"></i>
        <div class="relative z-10 max-w-2xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-black text-white mb-4">How Can We Help You?</h2>
            <p class="text-blue-100 mb-8">Search our documentation for API guides, settlement rules, and terminal compliance.</p>
            
            <form class="flex bg-white rounded-full p-2 shadow-xl focus-within:ring-4 focus-within:ring-[#D20103]/30 transition-all">
                <div class="flex items-center pl-4 text-slate-400"><i class="las la-search text-xl"></i></div>
                <input type="text" placeholder="Search knowledge base..." class="flex-grow bg-transparent border-none outline-none px-4 text-sm text-slate-700" />
                <button class="bg-[#D20103] hover:bg-red-800 text-white rounded-full px-6 py-2.5 font-bold transition-colors">Search</button>
            </form>
        </div>
    </div>

    <div class="mb-8">
        <h4 class="font-bold text-[#003366] text-xl mb-4 border-b border-slate-200 pb-2">Gateway Features</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <a href="{{ route('merchant.support.articles.master-wallets') }}" class="block bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-lg transition-all group flex items-start gap-4 cursor-pointer">
                <div class="size-12 rounded-xl bg-[#003366]/10 text-[#003366] flex items-center justify-center shrink-0 group-hover:bg-[#003366] group-hover:text-white transition-colors">
                    <i class="las la-wallet text-2xl"></i>
                </div>
                <div>
                    <h5 class="font-bold text-[#003366] mb-1">Master Wallets</h5>
                    <p class="text-xs text-slate-500">Understanding master and sub-agent wallet architecture.</p>
                </div>
            </a>

            <a href="{{ route('merchant.support.articles.api-webhooks') }}" class="block bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-lg transition-all group flex items-start gap-4 cursor-pointer">
                <div class="size-12 rounded-xl bg-[#D20103]/10 text-[#D20103] flex items-center justify-center shrink-0 group-hover:bg-[#D20103] group-hover:text-white transition-colors">
                    <i class="las la-plug text-2xl"></i>
                </div>
                <div>
                    <h5 class="font-bold text-[#003366] mb-1">API & Webhooks</h5>
                    <p class="text-xs text-slate-500">Integration documentation for your developer team.</p>
                </div>
            </a>

            <a href="{{ route('merchant.support.articles.settlements') }}" class="block bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-lg transition-all group flex items-start gap-4 cursor-pointer">
                <div class="size-12 rounded-xl bg-[#003366]/10 text-[#003366] flex items-center justify-center shrink-0 group-hover:bg-[#003366] group-hover:text-white transition-colors">
                    <i class="las la-university text-2xl"></i>
                </div>
                <div>
                    <h5 class="font-bold text-[#003366] mb-1">Settlements</h5>
                    <p class="text-xs text-slate-500">T+1 automated payout rules and bank configurations.</p>
                </div>
            </a>

        </div>
    </div>

    <div>
        <h4 class="font-bold text-[#003366] text-xl mb-4 border-b border-slate-200 pb-2">Popular Articles</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <div class="bg-white border border-slate-200 rounded-2xl p-6 hover:border-[#003366] transition-colors">
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-2.5 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wider rounded-full">Compliance</span>
                </div>
                <h5 class="font-bold text-slate-800 text-lg mb-2">Understanding Fraud Flags</h5>
                <p class="text-sm text-slate-500 mb-5 leading-relaxed">Know the signs of fraudulent activity and how our system automatically flags suspicious IPs.</p>
                <a href="{{ route('merchant.support.articles.fraud-flags') }}" class="inline-flex items-center gap-2 text-[#D20103] font-bold text-sm hover:text-red-800">
                    Read Article <i class="las la-arrow-right"></i>
                </a>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-6 hover:border-[#003366] transition-colors">
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-2.5 py-1 bg-green-50 text-green-600 text-[10px] font-bold uppercase tracking-wider rounded-full">Finance</span>
                </div>
                <h5 class="font-bold text-slate-800 text-lg mb-2">Chargebacks & Disputes</h5>
                <p class="text-sm text-slate-500 mb-5 leading-relaxed">How to upload evidence and respond to customer disputes through the gateway.</p>
                <a href="{{ route('merchant.support.articles.chargebacks') }}" class="inline-flex items-center gap-2 text-[#D20103] font-bold text-sm hover:text-red-800">
                    Read Article <i class="las la-arrow-right"></i>
                </a>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl p-6 hover:border-[#003366] transition-colors">
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-2.5 py-1 bg-purple-50 text-purple-600 text-[10px] font-bold uppercase tracking-wider rounded-full">API</span>
                </div>
                <h5 class="font-bold text-slate-800 text-lg mb-2">Rolling API Keys</h5>
                <p class="text-sm text-slate-500 mb-5 leading-relaxed">Best practices for rotating your secret and public keys without causing downtime.</p>
                <a href="{{ route('merchant.support.articles.rolling-keys') }}" class="inline-flex items-center gap-2 text-[#D20103] font-bold text-sm hover:text-red-800">
                    Read Article <i class="las la-arrow-right"></i>
                </a>
            </div>

        </div>
    </div>

</div>
@endsection