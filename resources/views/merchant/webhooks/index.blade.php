@extends('layout.merchant')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-[#003366]">Webhook Endpoints</h2>
        <p class="text-sm text-slate-500 mt-1">Receive real-time HTTP notifications when events happen on your account.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <div class="box col-span-1 lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h4 class="font-bold text-[#003366]">Endpoint Configuration</h4>
        </div>
        
        @if(session('success'))
            <div class="m-6 mb-0 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl flex items-center gap-3 text-green-700">
                <i class="las la-check-circle text-xl"></i>
                <p class="text-sm font-bold">{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="m-6 mb-0 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl flex items-center gap-3 text-red-700">
                <i class="las la-exclamation-circle text-xl"></i>
                <ul class="text-sm font-bold list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="p-6">
            <form action="{{ route('merchant.webhooks.update') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Live Webhook URL</label>
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-4 py-3 rounded-l-xl border border-r-0 border-slate-200 bg-slate-50 text-slate-500 text-sm">
                            <i class="las la-globe"></i>
                        </span>
                        <input type="url" name="live_url" placeholder="https://your-website.com/api/webhooks/live" value="{{ $webhookConfig->live_url ?? '' }}" class="flex-1 w-full text-sm bg-white border border-slate-200 rounded-r-xl px-4 py-3 focus:border-[#003366] focus:ring-1 focus:ring-[#003366] outline-none">
                    </div>
                    <p class="text-xs text-slate-500 mt-2">We will send live `transaction.successful` events to this URL.</p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Test Webhook URL</label>
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-4 py-3 rounded-l-xl border border-r-0 border-slate-200 bg-slate-50 text-slate-500 text-sm">
                            <i class="las la-flask"></i>
                        </span>
                        <input type="url" name="test_url" placeholder="https://your-website.com/api/webhooks/test" value="{{ $webhookConfig->test_url ?? '' }}" class="flex-1 w-full text-sm bg-white border border-slate-200 rounded-r-xl px-4 py-3 focus:border-[#003366] focus:ring-1 focus:ring-[#003366] outline-none">
                    </div>
                </div>

                <div class="mb-6 relative">
    <label class="block text-sm font-bold text-slate-700 mb-2">Webhook Signing Secret</label>
    <div class="relative">
        <input type="password" id="webhookSecret" value="whsec_q4i_live_8f7d6a5s4d3f2g1h" readonly class="w-full text-sm bg-slate-50 border border-slate-200 rounded-lg px-4 py-3 outline-none font-mono text-slate-600">
        <button type="button" onclick="toggleSecret()" class="absolute right-4 top-3.5 text-slate-400 hover:text-[#003366] transition-colors focus:outline-none">
            <i id="eyeIcon" class="las la-eye text-xl"></i>
        </button>
    </div>
    <p class="text-xs text-slate-400 mt-2">Use this secret to verify the `x-q4i-signature` header on incoming requests.</p>
</div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="text-sm font-bold text-white bg-[#003366] px-6 py-3 rounded-lg hover:bg-blue-900 transition-colors shadow-sm">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="box col-span-1 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <div class="size-12 bg-blue-50 text-[#003366] rounded-xl flex items-center justify-center mb-4">
            <i class="las la-shield-alt text-2xl"></i>
        </div>
        <h4 class="font-bold text-[#003366] mb-2">Secure Your Endpoints</h4>
        <p class="text-sm text-slate-500 mb-4">Anyone can send requests to your webhook URL. To prevent fraudulent credits, you must verify the cryptographic signature we send in the headers.</p>
        
        <div class="bg-slate-50 rounded-lg p-4 border border-slate-100">
            <p class="text-xs font-bold text-slate-600 mb-2">Expected Header:</p>
            <code class="text-xs text-[#D20103] bg-white px-2 py-1 border border-slate-200 rounded block break-all">x-q4i-signature: t=1678...,v1=4a5b...</code>
        </div>
    </div>

</div>

<div class="box bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <h4 class="font-bold text-[#003366]">Recent Deliveries</h4>
        <div class="flex items-center gap-4">
            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-bold">Last 24 Hours</span>
            <form action="{{ route('merchant.webhooks.test') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs font-bold text-white bg-green-600 px-4 py-2 rounded-lg hover:bg-green-700 transition-colors shadow-sm flex items-center gap-2">
                    <i class="las la-vial"></i> Send Test Event
                </button>
            </form>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">Event Type</th>
                    <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">Response</th>
                    <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">Environment</th>
                    <th class="px-6 py-4 text-end text-xs font-bold uppercase tracking-wider text-slate-500">Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentDeliveries as $delivery)
                <tr class="border-b border-slate-100 hover:bg-slate-50">
                    <td class="px-6 py-4">
                        <span class="text-sm font-bold text-[#003366]">{{ $delivery->event }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($delivery->is_successful)
                            <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-bold text-green-700">
                                {{ $delivery->response_status ?? 'OK' }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-bold text-red-700">
                                {{ $delivery->response_status ?? 'FAIL' }}
                            </span>
                        @endif
                        @if($delivery->processing_time_ms)
                            <span class="text-xs text-slate-400 ml-2">{{ $delivery->processing_time_ms }}ms</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm text-slate-500">{{ Str::contains($delivery->webhook_url, 'test') ? 'Test' : 'Live' }}</span>
                    </td>
                    <td class="px-6 py-4 text-end text-sm text-slate-500">
                        {{ $delivery->created_at->diffForHumans() }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="size-16 bg-slate-50 rounded-full flex items-center justify-center mb-3">
                                <i class="las la-satellite-dish text-3xl text-slate-400"></i>
                            </div>
                            <p class="font-bold text-slate-600 text-lg">No Deliveries Yet</p>
                            <p class="text-sm text-slate-400 mt-1 max-w-sm mx-auto">We'll show you the HTTP status codes for the webhook events we push to your server.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<script>
    function toggleSecret() {
        const input = document.getElementById('webhookSecret');
        const icon = document.getElementById('eyeIcon');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('la-eye');
            icon.classList.add('la-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('la-eye-slash');
            icon.classList.add('la-eye');
        }
    }
</script>
@endsection