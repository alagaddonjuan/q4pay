@extends('layout.merchant')
@if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl flex items-center gap-3 text-green-700 shadow-sm">
        <i class="las la-check-circle text-xl"></i>
        <p class="text-sm font-bold">{{ session('success') }}</p>
    </div>
@endif

@if($errors->any())
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
        <div class="flex items-center gap-3 text-red-700 mb-2">
            <i class="las la-exclamation-triangle text-xl"></i>
            <p class="text-sm font-bold">Oops! Something went wrong:</p>
        </div>
        <ul class="list-disc list-inside text-sm text-red-600 ml-8">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div class="flex items-center gap-4">
        <a href="{{ url('/merchant/sub-agents') }}" class="flex size-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:bg-slate-50 hover:text-[#003366] transition-colors shadow-sm">
            <i class="las la-arrow-left text-xl"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-[#003366]">Agent Profile</h2>
            <p class="text-sm text-slate-500 mt-1">Ref: <span class="font-mono font-bold">{{ $agent->merchant_reference }}</span></p>
        </div>
    </div>
    
    <div class="flex items-center gap-3">
        <button onclick="document.getElementById('editAgentModal').classList.remove('hidden')" class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-5 py-2.5 font-bold text-slate-600 shadow-sm transition-all hover:bg-slate-50">
            <i class="las la-pen text-xl"></i> 
            <span>Edit Profile</span>
        </button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="box bg-white rounded-2xl shadow-sm border border-slate-200 p-6 lg:col-span-2">
        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-6 border-b border-slate-100 pb-3">Identity Details</h3>
        
        <div class="flex flex-col md:flex-row gap-6 items-start">
            <div class="flex size-20 items-center justify-center rounded-full bg-blue-50 text-[#003366] font-bold text-3xl shrink-0">
                {{ substr($agent->first_name, 0, 1) }}{{ substr($agent->last_name, 0, 1) }}
            </div>
            
            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-6 w-full">
                <div>
                    <p class="text-xs text-slate-500 font-bold mb-1">Full Name</p>
                    <p class="font-bold text-slate-800 text-lg">{{ $agent->first_name }} {{ $agent->last_name }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold mb-1">Contact Email</p>
                    <p class="font-medium text-slate-700">{{ $agent->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold mb-1">Phone Number</p>
                    <p class="font-medium text-slate-700">{{ $agent->phone_number }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold mb-1">Date of Birth</p>
                    <p class="font-medium text-slate-700">{{ \Carbon\Carbon::parse($agent->date_of_birth)->format('F d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="box bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-6 border-b border-slate-100 pb-3">KYC Compliance</h3>
        
        <div class="space-y-5">
            <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                <div>
                    <p class="text-xs font-bold text-slate-500 mb-0.5">BVN</p>
                    <p class="font-mono font-bold text-slate-700">
                        {{ !empty($agent->bvn) ? Str::mask($agent->bvn, '*', 0, 7) : 'Not Provided' }}
                    </p>
                </div>
                
                @if($agent->kyc_status === 'verified' && !empty($agent->bvn))
                    <i class="las la-check-circle text-2xl text-green-500" title="Verified"></i>
                @elseif($agent->kyc_status === 'pending')
                    <i class="las la-clock text-2xl text-yellow-500" title="Pending Re-verification"></i>
                @else
                    <i class="las la-times-circle text-2xl text-red-500" title="Not Verified"></i>
                @endif
            </div>

            <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                <div>
                    <p class="text-xs font-bold text-slate-500 mb-0.5">NIN</p>
                    <p class="font-mono font-bold text-slate-700">
                        {{ !empty($agent->nin) ? Str::mask($agent->nin, '*', 0, 7) : 'Not Provided' }}
                    </p>
                </div>
                
                @if($agent->kyc_status === 'verified' && !empty($agent->nin))
                    <i class="las la-check-circle text-2xl text-green-500" title="Verified"></i>
                @elseif($agent->kyc_status === 'pending')
                    <i class="las la-clock text-2xl text-yellow-500" title="Pending Re-verification"></i>
                @else
                    <i class="las la-times-circle text-2xl text-red-500" title="Not Verified"></i>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 space-y-6">
        <div class="box bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50">
                <h3 class="text-sm font-bold text-[#003366] uppercase tracking-wider">Assigned Accounts</h3>
            </div>
            
            <div class="p-4 space-y-3">
                @forelse($virtualAccounts as $account)
                <div class="p-4 rounded-xl border border-slate-200 hover:border-[#003366] transition-colors cursor-pointer group">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="text-xs font-bold text-slate-500 mb-1">{{ $account->bank_name }}</p>
                            <p class="text-lg font-black text-slate-800 tracking-wider">{{ $account->account_number }}</p>
                        </div>
                        <span class="inline-flex items-center gap-1 rounded-full {{ $account->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} px-2.5 py-0.5 text-xs font-bold">
                            <div class="size-1.5 rounded-full {{ $account->is_active ? 'bg-green-500' : 'bg-red-500' }}"></div> 
                            {{ $account->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex justify-between items-center">
                        <span class="text-xs text-slate-500 font-bold uppercase">Ledger Balance</span>
                        <span class="font-black text-[#003366]">₦{{ number_format($account->ledger_balance, 2) }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <i class="las la-wallet text-4xl text-slate-300 mb-2"></i>
                    <p class="text-sm font-bold text-slate-500">No accounts assigned.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="box bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden h-full">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-[#003366] uppercase tracking-wider">Recent Collections</h3>
                <a href="{{ url('/merchant/ledger') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800">View All</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">Date & Ref</th>
                            <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">Account</th>
                            <th class="px-6 py-4 text-end text-xs font-bold uppercase tracking-wider text-slate-500">Amount</th>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $tx)
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-[#003366]">{{ $tx->session_id ?? $tx->reference ?? 'N/A' }}</div>
                                <div class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($tx->created_at)->format('M d, Y • h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-700">{{ $tx->account_number }}</div>
                            </td>
                            <td class="px-6 py-4 text-end font-black text-[#003366]">
                                {{ $tx->type === 'credit' ? '+' : '-' }}₦{{ number_format($tx->amount, 2) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($tx->status === 'successful')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-bold text-green-700">Success</span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-bold text-yellow-700">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <p class="text-sm font-bold text-slate-500">No transactions recorded yet.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="editAgentModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-white">
            <h4 class="font-bold text-[#003366] text-xl">Edit Agent Profile</h4>
            <button onclick="document.getElementById('editAgentModal').classList.add('hidden')" class="text-slate-400 hover:text-red-500 transition-colors">
                <i class="las la-times text-2xl"></i>
            </button>
        </div>
        
        <div class="p-6">
            <form action="{{ url('/merchant/sub-agents/' . $agent->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">First Name <span class="text-red-500">*</span></label>
                        <input type="text" name="first_name" value="{{ $agent->first_name }}" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Last Name <span class="text-red-500">*</span></label>
                        <input type="text" name="last_name" value="{{ $agent->last_name }}" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Contact Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ $agent->email }}" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Phone Number <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" value="{{ $agent->phone_number }}" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none">
                    </div>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-bold text-[#003366] mb-2">Date of Birth <span class="text-red-500">*</span></label>
                    <input type="date" name="dob" value="{{ \Carbon\Carbon::parse($agent->date_of_birth)->format('Y-m-d') }}" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none text-slate-600">
                </div>

                <div class="bg-slate-50 rounded-lg p-4 flex gap-3 mb-8 border border-slate-200">
                    <i class="las la-lock text-slate-400 text-xl mt-0.5"></i>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        <strong>Note:</strong> Core KYC attributes (BVN & NIN) cannot be modified after initial verification to maintain compliance with Central Bank regulations. Contact API support if a hard reset is required.
                    </p>
                </div>
                
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('editAgentModal').classList.add('hidden')" class="px-5 py-2.5 font-bold text-slate-500 hover:text-slate-800 transition-colors">Cancel</button>
                    <button type="submit" class="flex items-center gap-2 px-6 py-2.5 rounded-lg font-bold text-white transition-all hover:bg-blue-900 shadow-sm" style="background-color: #003366;">
                        <i class="las la-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection