@extends('layout.merchant')

@section('content')
<div class="max-w-3xl mx-auto mt-10">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-[#003366]">Corporate KYC Compliance</h2>
        <p class="text-sm text-slate-500 mt-1">Manage your business verification and API access limits.</p>
    </div>

    <div class="box bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden text-center p-12">
        <div class="size-24 bg-yellow-50 rounded-full flex items-center justify-center mx-auto mb-6 border-4 border-yellow-100">
            <i class="las la-user-clock text-5xl text-yellow-600"></i>
        </div>
        
        <h3 class="text-2xl font-black text-[#003366] mb-2">Application Under Review</h3>
        <p class="text-slate-500 mb-8 max-w-md mx-auto">
            Your corporate documents have been securely received. Our compliance team is currently verifying your business details. Live API Keys will be unlocked automatically once approved.
        </p>

        <div class="bg-slate-50 rounded-xl p-4 inline-block text-left mb-6 border border-slate-100">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Submitted Documents</p>
            <ul class="space-y-2 text-sm font-medium text-slate-700">
                <li><i class="las la-check-circle text-green-500 text-lg mr-1"></i> Certificate of Incorporation (CAC)</li>
                <li><i class="las la-check-circle text-green-500 text-lg mr-1"></i> Directors BVN / NIN</li>
                <li><i class="las la-check-circle text-green-500 text-lg mr-1"></i> Utility Bill (Proof of Address)</li>
            </ul>
        </div>

        <div>
            <a href="{{ url('/merchant/dashboard') }}" class="inline-flex items-center gap-2 px-8 py-3 rounded-lg font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 transition-colors">
    <i class="las la-arrow-left"></i> Return to Dashboard
</a>
        </div>
    </div>
</div>
@endsection