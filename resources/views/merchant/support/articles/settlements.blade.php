@extends('layout.merchant')
@section('title', 'Settlements | Help Center')

@section('content')
<div class="main-inner">
    <div class="mb-6">
        <a href="{{ route('merchant.support.help-center') }}" class="text-sm text-slate-500 hover:text-[#003366] font-medium inline-flex items-center gap-1">
            <i class="las la-arrow-left"></i> Back to Help Center
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="bg-gradient-to-r from-[#003366] to-[#004080] p-10 md:p-14 text-white relative">
            <i class="las la-university absolute right-10 bottom-10 text-8xl text-white/10"></i>
            <h1 class="text-3xl md:text-4xl font-black mb-4">Payouts & Settlements</h1>
            <p class="text-blue-100 max-w-2xl text-lg">Detailed rules regarding T+1 automated payouts, banking configurations, and settlement reports.</p>
        </div>

        <div class="p-8 md:p-12 prose prose-slate max-w-none">
            <h2 class="text-2xl font-bold text-slate-800 mb-4">Standard T+1 Settlements</h2>
            <p class="text-slate-600 mb-6 leading-relaxed">
                Q4I operates on a standard <strong>T+1 settlement schedule</strong>. This means that all transactions processed successfully on a given business day (T) are automatically paid out to your configured corporate bank account on the following business day (+1).
            </p>

            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-6 rounded-r-xl mb-8">
                <h4 class="font-bold text-yellow-800 flex items-center gap-2 mb-2">
                    <i class="las la-clock text-xl"></i> Weekend & Holiday Processing
                </h4>
                <p class="text-yellow-700 m-0">
                    Transactions occurring on weekends or Nigerian public holidays are rolled over to the next available business day. For example, payments received on Saturday will be settled on Tuesday morning.
                </p>
            </div>

            <h3 class="text-xl font-bold text-slate-800 mb-3 border-b border-slate-100 pb-2">Configuring Payout Accounts</h3>
            <p class="text-slate-600 mb-6 leading-relaxed">
                Before settlements can commence, you must link and verify a corporate bank account that strictly matches the business name on your KYC documents. You can configure this in your <strong>Settings -> Payout Accounts</strong> section. 
            </p>

            <h3 class="text-xl font-bold text-slate-800 mb-3 border-b border-slate-100 pb-2">Minimum Settlement Thresholds</h3>
            <p class="text-slate-600 mb-6 leading-relaxed">
                By default, the minimum settlement amount is ₦1,000. If your daily volume does not meet this threshold, the balance will roll over to the next day until the threshold is met.
            </p>
        </div>
    </div>
</div>
@endsection
