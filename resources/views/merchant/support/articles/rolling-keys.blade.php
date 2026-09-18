@extends('layout.merchant')
@section('title', 'Rolling API Keys | Help Center')

@section('content')
<div class="main-inner">
    <div class="mb-6">
        <a href="{{ route('merchant.support.help-center') }}" class="text-sm text-slate-500 hover:text-[#003366] font-medium inline-flex items-center gap-1">
            <i class="las la-arrow-left"></i> Back to Help Center
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        <div class="bg-gradient-to-r from-purple-600 to-fuchsia-700 p-10 md:p-14 text-white relative">
            <i class="las la-key absolute right-10 bottom-10 text-8xl text-white/10"></i>
            <div class="inline-flex items-center gap-2 mb-4">
                <span class="px-3 py-1 bg-white/20 text-white text-xs font-bold uppercase tracking-wider rounded-full">API</span>
            </div>
            <h1 class="text-3xl md:text-4xl font-black mb-4">Rolling API Keys</h1>
            <p class="text-purple-100 max-w-2xl text-lg">Best practices for rotating your secret and public keys securely without causing payment downtime.</p>
        </div>

        <div class="p-8 md:p-12 prose prose-slate max-w-none">
            <h2 class="text-2xl font-bold text-slate-800 mb-4">Why Rotate Keys?</h2>
            <p class="text-slate-600 mb-6 leading-relaxed">
                Security best practices dictate that you should periodically rotate (roll) your API keys, especially if a developer leaves your organization or if you suspect your secret key may have been accidentally committed to a public repository.
            </p>

            <h3 class="text-xl font-bold text-slate-800 mb-3 border-b border-slate-100 pb-2">How to Roll Keys</h3>
            <ol class="list-decimal pl-5 text-slate-600 space-y-2 mb-8">
                <li>Navigate to the <strong>API Keys</strong> page in your Gateway Dashboard.</li>
                <li>Click on the <strong>Roll Keys</strong> button next to the Live Environment keys.</li>
                <li>Your new keys will be generated immediately, and the old keys will be marked for expiration.</li>
            </ol>

            <div class="bg-purple-50 border-l-4 border-purple-500 p-6 rounded-r-xl mb-8">
                <h4 class="font-bold text-purple-800 flex items-center gap-2 mb-2">
                    <i class="las la-clock text-xl"></i> 24-Hour Grace Period
                </h4>
                <p class="text-purple-700 m-0">
                    To prevent downtime, Q4I provides a 24-hour grace period when you roll your keys. During this window, <strong>both the old and new keys will work simultaneously</strong>. You must update your backend configuration to use the new keys within this window, after which the old keys will be permanently invalidated.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
