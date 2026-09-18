@extends('layout.merchant')
@section('title', 'Understanding Fraud Flags | Help Center')

@section('content')
<div class="main-inner">
    <div class="mb-6">
        <a href="{{ route('merchant.support.help-center') }}" class="text-sm text-slate-500 hover:text-[#003366] font-medium inline-flex items-center gap-1">
            <i class="las la-arrow-left"></i> Back to Help Center
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-10 md:p-14 text-white relative">
            <i class="las la-shield-alt absolute right-10 bottom-10 text-8xl text-white/10"></i>
            <div class="inline-flex items-center gap-2 mb-4">
                <span class="px-3 py-1 bg-white/20 text-white text-xs font-bold uppercase tracking-wider rounded-full">Compliance</span>
            </div>
            <h1 class="text-3xl md:text-4xl font-black mb-4">Understanding Fraud Flags</h1>
            <p class="text-blue-100 max-w-2xl text-lg">Learn how Q4I's automated fraud detection engine flags suspicious IPs and velocity anomalies.</p>
        </div>

        <div class="p-8 md:p-12 prose prose-slate max-w-none">
            <h2 class="text-2xl font-bold text-slate-800 mb-4">The Automated Risk Engine</h2>
            <p class="text-slate-600 mb-6 leading-relaxed">
                Q4I Gateway incorporates an intelligent, automated risk engine that operates behind the scenes on every transaction. To protect your business from chargebacks and liability, the engine may occasionally flag transactions as <strong>Suspicious</strong>.
            </p>

            <h3 class="text-xl font-bold text-slate-800 mb-3 border-b border-slate-100 pb-2">Common Flag Triggers</h3>
            <ul class="list-disc pl-5 text-slate-600 space-y-2 mb-8">
                <li><strong>Velocity Spikes:</strong> An unusually high number of transaction attempts from a single IP address or browser fingerprint within a short timeframe.</li>
                <li><strong>Geo-Mismatches:</strong> A transaction originating from a high-risk jurisdiction that does not align with the customer's billing profile.</li>
                <li><strong>Blacklisted Endpoints:</strong> Interaction from known bad actors on the global banking blacklist.</li>
            </ul>

            <div class="bg-slate-50 border border-slate-200 p-6 rounded-xl mb-8">
                <h4 class="font-bold text-slate-800 mb-2">What happens when a transaction is flagged?</h4>
                <p class="text-slate-600 m-0 text-sm">
                    Flagged transactions are temporarily frozen in Escrow and will not automatically settle. Our compliance team will require verification from you (such as proof of delivery or invoice details) before manually releasing the funds.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
