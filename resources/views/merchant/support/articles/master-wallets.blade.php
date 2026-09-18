@extends('layout.merchant')
@section('title', 'Master Wallets | Help Center')

@section('content')
<div class="main-inner">
    <div class="mb-6">
        <a href="{{ route('merchant.support.help-center') }}" class="text-sm text-slate-500 hover:text-[#003366] font-medium inline-flex items-center gap-1">
            <i class="las la-arrow-left"></i> Back to Help Center
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="bg-gradient-to-r from-[#003366] to-[#004080] p-10 md:p-14 text-white relative">
            <i class="las la-wallet absolute right-10 bottom-10 text-8xl text-white/10"></i>
            <h1 class="text-3xl md:text-4xl font-black mb-4">Master Wallets Architecture</h1>
            <p class="text-blue-100 max-w-2xl text-lg">Understanding how Q4I structures master and sub-agent wallets for maximum fund security and automated reconciliation.</p>
        </div>

        <div class="p-8 md:p-12 prose prose-slate max-w-none">
            <h2 class="text-2xl font-bold text-slate-800 mb-4">What is a Master Wallet?</h2>
            <p class="text-slate-600 mb-6 leading-relaxed">
                When your corporate profile passes our KYC compliance checks, Q4I automatically provisions a <strong>Master Virtual Account</strong> linked to your Merchant ID. This Master Account is tied to an invisible "Agent 0" that acts as the absolute source of truth for your ledger.
            </p>

            <div class="bg-blue-50 border-l-4 border-[#003366] p-6 rounded-r-xl mb-8">
                <h4 class="font-bold text-[#003366] flex items-center gap-2 mb-2">
                    <i class="las la-info-circle text-xl"></i> Key Concept
                </h4>
                <p class="text-slate-700 m-0">
                    All dynamic payment links, escrow transactions, and static transfers eventually settle into your Master Wallet. Your API keys are strictly bound to this wallet.
                </p>
            </div>

            <h3 class="text-xl font-bold text-slate-800 mb-3 border-b border-slate-100 pb-2">Sub-Agent Wallets</h3>
            <p class="text-slate-600 mb-6 leading-relaxed">
                If your business utilizes field agents or branch locations, you can create sub-agents. Each sub-agent receives their own unique Virtual Account.
            </p>
            <ul class="list-disc pl-5 text-slate-600 space-y-2 mb-8">
                <li>Funds collected by sub-agents are instantly credited to their specific ledger balance.</li>
                <li>At the end of the settlement window, sub-agent balances are automatically swept into your Master Wallet.</li>
                <li>You can configure sweep schedules (e.g., end-of-day, real-time, or manual) in your dashboard settings.</li>
            </ul>

            <h3 class="text-xl font-bold text-slate-800 mb-3 border-b border-slate-100 pb-2">Reconciliation</h3>
            <p class="text-slate-600 mb-6 leading-relaxed">
                Q4I handles ledger reconciliation asynchronously via secure webhooks from our banking partners (like 9PSB). If a customer pays via a dynamic payment link, the system maps the unique <code>session_id</code> to your Master Wallet to ensure accurate attribution, even without a persistent static account for the buyer.
            </p>
        </div>
    </div>
</div>
@endsection
