@extends('layout.merchant')
@section('title', 'Chargebacks & Disputes | Help Center')

@section('content')
<div class="main-inner">
    <div class="mb-6">
        <a href="{{ route('merchant.support.help-center') }}" class="text-sm text-slate-500 hover:text-[#003366] font-medium inline-flex items-center gap-1">
            <i class="las la-arrow-left"></i> Back to Help Center
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="bg-gradient-to-r from-emerald-600 to-teal-700 p-10 md:p-14 text-white relative">
            <i class="las la-balance-scale absolute right-10 bottom-10 text-8xl text-white/10"></i>
            <div class="inline-flex items-center gap-2 mb-4">
                <span class="px-3 py-1 bg-white/20 text-white text-xs font-bold uppercase tracking-wider rounded-full">Finance</span>
            </div>
            <h1 class="text-3xl md:text-4xl font-black mb-4">Chargebacks & Disputes</h1>
            <p class="text-emerald-100 max-w-2xl text-lg">Learn how to upload evidence, respond to customer disputes, and win chargeback cases.</p>
        </div>

        <div class="p-8 md:p-12 prose prose-slate max-w-none">
            <h2 class="text-2xl font-bold text-slate-800 mb-4">The Dispute Process</h2>
            <p class="text-slate-600 mb-6 leading-relaxed">
                A chargeback occurs when a customer disputes a transaction with their bank, claiming they did not authorize the payment or did not receive the goods. When this happens, the funds are temporarily deducted from your ledger while the dispute is investigated.
            </p>

            <h3 class="text-xl font-bold text-slate-800 mb-3 border-b border-slate-100 pb-2">Responding to a Dispute</h3>
            <p class="text-slate-600 mb-6 leading-relaxed">
                You have exactly <strong>72 hours</strong> to respond to a dispute once it is logged in your dashboard. To respond:
            </p>
            <ol class="list-decimal pl-5 text-slate-600 space-y-2 mb-8">
                <li>Navigate to the <strong>Disputes</strong> tab in your Merchant Dashboard.</li>
                <li>Locate the transaction and click <em>Resolve</em>.</li>
                <li>Upload compelling evidence (receipts, delivery confirmations, signed waybills, or chat logs).</li>
                <li>Submit your response to the Q4I arbitration team.</li>
            </ol>

            <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-r-xl mb-8">
                <h4 class="font-bold text-green-800 flex items-center gap-2 mb-2">
                    <i class="las la-check-circle text-xl"></i> Winning a Dispute
                </h4>
                <p class="text-green-700 m-0">
                    If the arbitration rules in your favor, the chargeback is overturned and the funds are immediately credited back to your Master Wallet. Maintaining clear records of customer interactions significantly increases your win rate.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
