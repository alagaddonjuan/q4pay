@extends('layout.merchant')
@section('title', 'API & Webhooks | Help Center')

@section('content')
<div class="main-inner">
    <div class="mb-6">
        <a href="{{ route('merchant.support.help-center') }}" class="text-sm text-slate-500 hover:text-[#D20103] font-medium inline-flex items-center gap-1">
            <i class="las la-arrow-left"></i> Back to Help Center
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="bg-gradient-to-r from-[#800000] to-[#D20103] p-10 md:p-14 text-white relative">
            <i class="las la-plug absolute right-10 bottom-10 text-8xl text-white/10"></i>
            <h1 class="text-3xl md:text-4xl font-black mb-4">API & Webhooks Integration</h1>
            <p class="text-red-100 max-w-2xl text-lg">A guide for developer teams integrating Q4I payment gateways via our RESTful APIs and listening for asynchronous payment webhooks.</p>
        </div>

        <div class="p-8 md:p-12 prose prose-slate max-w-none">
            <h2 class="text-2xl font-bold text-slate-800 mb-4">API Authentication</h2>
            <p class="text-slate-600 mb-6 leading-relaxed">
                All requests to the Q4I API must be authenticated via Bearer tokens. You can obtain your <strong>Public Key</strong> and <strong>Secret Key</strong> from the <em>Developer -> API Keys</em> section of your dashboard once your KYC is approved.
            </p>

            <div class="bg-slate-900 rounded-xl p-4 text-slate-300 font-mono text-sm mb-8 overflow-x-auto">
                Authorization: Bearer sk_live_your_secret_key_here<br>
                Content-Type: application/json
            </div>

            <h3 class="text-xl font-bold text-slate-800 mb-3 border-b border-slate-100 pb-2">Configuring Webhooks</h3>
            <p class="text-slate-600 mb-6 leading-relaxed">
                Webhooks are essential for receiving real-time payment notifications. Because bank transfers are asynchronous, you should never rely solely on polling. Instead, configure a webhook URL in your dashboard to listen for <code>charge.successful</code> events.
            </p>

            <div class="bg-red-50 border-l-4 border-[#D20103] p-6 rounded-r-xl mb-8">
                <h4 class="font-bold text-[#D20103] flex items-center gap-2 mb-2">
                    <i class="las la-shield-alt text-xl"></i> Webhook Security
                </h4>
                <p class="text-slate-700 m-0">
                    Always verify the webhook signature. Q4I sends an <code>X-Q4I-Signature</code> header containing a HMAC SHA512 signature of the payload signed with your Secret Key. Ensure this signature matches before processing the webhook.
                </p>
            </div>

            <h3 class="text-xl font-bold text-slate-800 mb-3 border-b border-slate-100 pb-2">Session Reconciliation</h3>
            <p class="text-slate-600 mb-6 leading-relaxed">
                When a payment is processed, the webhook payload includes a <code>session_id</code> and a <code>reference</code>. Your backend should map the <code>reference</code> to your internal order IDs to fulfill the customer's purchase automatically.
            </p>
        </div>
    </div>
</div>
@endsection
