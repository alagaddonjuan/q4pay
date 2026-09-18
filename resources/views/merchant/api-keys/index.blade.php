@extends('layout.merchant')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-[#003366]">API Configuration</h2>
        <p class="text-sm text-slate-500 mt-1">Manage your API keys to authenticate requests from your application.</p>
    </div>
    
    <div class="flex items-center gap-3">
        <a href="{{ route('merchant.api-docs.index') }}" class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-5 py-2.5 font-bold text-slate-600 shadow-sm transition-all hover:bg-slate-50">
            <i class="las la-book text-xl"></i> 
            <span>API Documentation</span>
        </a>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl flex items-center gap-3 text-green-700 shadow-sm">
        <i class="las la-check-circle text-xl"></i>
        <p class="text-sm font-bold">{{ session('success') }}</p>
    </div>
@endif

@if(!$apiKeys)
    <div class="box bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center flex flex-col items-center justify-center">
        <div class="size-20 bg-blue-50 text-[#003366] rounded-full flex items-center justify-center mb-6">
            <i class="las la-key text-5xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-[#003366] mb-2">Generate Your API Keys</h3>
        <p class="text-slate-500 max-w-md mx-auto mb-8">You need to generate your unique cryptographic API keys before you can integrate our payment gateway into your application.</p>
        
        <form action="{{ route('merchant.api-keys.generate') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center gap-2 rounded-lg px-8 py-3.5 font-bold shadow-sm transition-all text-white hover:-translate-y-1 hover:shadow-md" style="background-color: #003366;">
                <i class="las la-cog text-xl"></i>
                <span>Generate API Keys Now</span>
            </button>
        </form>
    </div>
@else
    <div class="grid grid-cols-1 gap-6">
        
        <!-- TEST ENVIRONMENT KEYS -->
        <div class="box bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex size-10 items-center justify-center rounded-lg bg-orange-100 text-orange-600">
                        <i class="las la-vial text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800">Test Mode Keys</h4>
                        <p class="text-xs text-slate-500">Use these keys to test your integration without real money.</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold uppercase tracking-wider">Test</span>
            </div>
            
            <div class="p-6">
                <div class="mb-5">
                    <div class="flex justify-between items-end mb-2">
                        <label class="block text-sm font-bold text-slate-700">Test Public Key</label>
                    </div>
                    <div class="flex items-center relative">
                        <input type="text" readonly value="{{ $apiKeys->test_public_key }}" class="w-full text-sm font-mono bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-12 py-3 outline-none text-slate-600">
                        <button class="absolute right-3 text-slate-400 hover:text-[#003366] transition-colors" onclick="navigator.clipboard.writeText('{{ $apiKeys->test_public_key }}'); alert('Test Public Key copied to clipboard!');">
                            <i class="las la-copy text-xl"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-end mb-2">
                        <label class="block text-sm font-bold text-slate-700">Test Secret Key</label>
                    </div>
                    <div class="flex items-center relative">
                        <input type="password" readonly value="{{ $apiKeys->test_secret_key }}" class="w-full text-sm font-mono bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-12 py-3 outline-none text-slate-600" id="testSecretKey">
                        <button type="button" class="absolute right-3 text-slate-400 hover:text-[#003366] transition-colors" onclick="
                            const input = document.getElementById('testSecretKey');
                            input.type = input.type === 'password' ? 'text' : 'password';
                        ">
                            <i class="las la-eye text-xl"></i>
                        </button>
                    </div>
                    <p class="text-xs text-slate-400 mt-2"><i class="las la-shield-alt text-[#003366]"></i> Never expose your secret key in frontend code.</p>
                </div>
            </div>
        </div>

        <!-- LIVE ENVIRONMENT KEYS -->
        <div class="box bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden relative">
            
            <!-- KYC Lock Overlay -->
            @if(!$kycRecord || $kycRecord->status !== 'approved')
            <div class="absolute inset-0 bg-white/90 backdrop-blur-[2px] z-10 flex flex-col items-center justify-center p-6 text-center">
                <div class="size-16 bg-red-50 text-[#D20103] rounded-full flex items-center justify-center mb-4 shadow-sm">
                    <i class="las la-lock text-3xl"></i>
                </div>
                <h4 class="text-lg font-bold text-[#003366] mb-2">Live Keys Locked</h4>
                <p class="text-sm text-slate-500 max-w-sm mb-6">
                    @if(!$kycRecord)
                        You must complete your Corporate KYC compliance before accessing live production keys.
                    @elseif($kycRecord->status === 'pending')
                        Your Corporate KYC is currently <strong>Under Review</strong>. Live keys will unlock once approved.
                    @else
                        Your KYC application requires attention before live keys can be unlocked.
                    @endif
                </p>
                <a href="{{ url('/merchant/kyc') }}" class="rounded-lg px-6 py-3 font-bold shadow-sm transition-all text-white hover:-translate-y-0.5" style="background-color: #003366;">
                    @if(!$kycRecord)
                        Complete Verification
                    @else
                        Check KYC Status
                    @endif
                </a>
            </div>
            @endif

            <div class="p-6 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex size-10 items-center justify-center rounded-lg bg-green-100 text-green-600">
                        <i class="las la-bolt text-2xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800">Live Mode Keys</h4>
                        <p class="text-xs text-slate-500">Use these keys for real, production transactions.</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase tracking-wider">Live</span>
            </div>
            
            <div class="p-6">
                <div class="mb-5">
                    <div class="flex justify-between items-end mb-2">
                        <label class="block text-sm font-bold text-slate-700">Live Public Key</label>
                    </div>
                    <div class="flex items-center relative">
                        <input type="text" readonly value="{{ (!$kycRecord || $kycRecord->status !== 'approved') ? '********' : $apiKeys->live_public_key }}" class="w-full text-sm font-mono bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-12 py-3 outline-none text-slate-600">
                        <button class="absolute right-3 text-slate-400 hover:text-[#003366] transition-colors" onclick="navigator.clipboard.writeText('{{ $apiKeys->live_public_key }}'); alert('Live Public Key copied to clipboard!');">
                            <i class="las la-copy text-xl"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-end mb-2">
                        <label class="block text-sm font-bold text-slate-700">Live Secret Key</label>
                        
                        <form action="{{ route('merchant.api-keys.generate') }}" method="POST" class="inline" onsubmit="return confirm('WARNING: Are you absolutely sure? Rolling this key will immediately break any active API integrations using your old secret key. This action cannot be undone.');">
                            @csrf
                            <input type="hidden" name="action" value="roll_live_secret">
                            <button type="submit" class="text-xs font-bold text-[#D20103] hover:underline flex items-center gap-1">
                                <i class="las la-sync-alt"></i> Roll Key
                            </button>
                        </form>
                    </div>
                    <div class="flex items-center relative">
                        <input type="password" readonly value="{{ (!$kycRecord || $kycRecord->status !== 'approved') ? '********' : $apiKeys->live_secret_key }}" class="w-full text-sm font-mono bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-12 py-3 outline-none text-slate-600" id="liveSecretKey">
                        <button type="button" class="absolute right-3 text-slate-400 hover:text-[#D20103] transition-colors" onclick="
                            const input = document.getElementById('liveSecretKey');
                            input.type = input.type === 'password' ? 'text' : 'password';
                        ">
                            <i class="las la-eye text-xl"></i>
                        </button>
                    </div>
                    <p class="text-xs text-slate-400 mt-2"><i class="las la-exclamation-triangle text-orange-500"></i> Keep this key strictly confidential. It can perform any action on your account.</p>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection