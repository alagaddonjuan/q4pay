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
    <div>
        <h2 class="text-2xl font-bold text-[#003366]">Sub-Agents Directory</h2>
        <p class="text-sm text-slate-500 mt-1">Manage your branches, riders, and collection personnel.</p>
    </div>
    
    <div class="flex items-center gap-3">
        <button onclick="document.getElementById('addAgentModal').classList.remove('hidden')" class="flex items-center gap-2 rounded-lg px-5 py-2.5 font-bold shadow-sm transition-all text-white hover:bg-blue-900" style="background-color: #003366;">
            <i class="las la-user-plus text-xl"></i> 
            <span>Add New Agent</span>
        </button>
    </div>
</div>

@if($agents->isEmpty())
    <div class="box bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <div class="flex flex-col items-center justify-center py-12">
            <div class="flex size-20 items-center justify-center rounded-full bg-slate-50 mb-4">
                <i class="las la-users text-4xl text-slate-400"></i>
            </div>
            <h4 class="text-lg font-bold text-[#003366] mb-1">No Sub-Agents Found</h4>
            <p class="text-slate-500 text-center max-w-md">You haven't added any personnel or branches yet. Sub-agents are automatically created when you provision a static virtual account.</p>
        </div>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($agents as $agent)
        <div class="box bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow flex flex-col">
            <div class="p-6 border-b border-slate-100 flex items-start gap-4">
                <div class="flex size-12 items-center justify-center rounded-full bg-blue-50 text-[#003366] font-bold text-lg shrink-0">
                    {{ substr($agent->first_name, 0, 1) }}{{ substr($agent->last_name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-bold text-slate-800 truncate">{{ $agent->first_name }} {{ $agent->last_name }}</h3>
                    <p class="text-sm text-slate-500 truncate"><i class="las la-envelope mr-1"></i>{{ $agent->email }}</p>
                    <p class="text-sm text-slate-500 mt-0.5"><i class="las la-phone mr-1"></i>{{ $agent->phone_number }}</p>
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">KYC Status</div>
                <div class="flex gap-2">
                    @if($agent->kyc_status === 'verified' && !empty($agent->bvn))
                        <span class="inline-flex items-center gap-1 rounded bg-green-100 px-2 py-0.5 text-xs font-bold text-green-700" title="BVN Verified">
                            <i class="las la-check-circle"></i> BVN
                        </span>
                    @elseif($agent->kyc_status === 'pending')
                        <span class="inline-flex items-center gap-1 rounded bg-yellow-100 px-2 py-0.5 text-xs font-bold text-yellow-700" title="Pending Re-verification">
                            <i class="las la-clock"></i> BVN Pending
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 rounded bg-red-50 px-2 py-0.5 text-xs font-bold text-red-600" title="Not Verified">
                            <i class="las la-times-circle"></i> No BVN
                        </span>
                    @endif

                    @if($agent->kyc_status === 'verified' && !empty($agent->nin))
                        <span class="inline-flex items-center gap-1 rounded bg-green-100 px-2 py-0.5 text-xs font-bold text-green-700" title="NIN Verified">
                            <i class="las la-check-circle"></i> NIN
                        </span>
                    @elseif($agent->kyc_status === 'pending')
                        <span class="inline-flex items-center gap-1 rounded bg-yellow-100 px-2 py-0.5 text-xs font-bold text-yellow-700" title="Pending Re-verification">
                            <i class="las la-clock"></i> NIN Pending
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 rounded bg-red-50 px-2 py-0.5 text-xs font-bold text-red-600" title="Not Verified">
                            <i class="las la-times-circle"></i> No NIN
                        </span>
                    @endif
                </div>
            </div>
            <div class="p-6 flex-1 flex flex-col justify-between">
                <div class="flex justify-between items-end mb-4">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Collections</p>
                        <h4 class="text-xl font-black text-[#003366]">₦{{ number_format($agent->total_balance ?? 0, 2) }}</h4>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Active Accounts</p>
                        <span class="inline-flex items-center justify-center min-w-[2rem] rounded-lg bg-slate-100 px-2 py-1 text-sm font-bold text-slate-700">
                            {{ $agent->account_count ?? 0 }}
                        </span>
                    </div>
                </div>
                
                <a href="{{ url('/merchant/sub-agents/' . $agent->id) }}" class="block text-center w-full rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-[#003366] hover:bg-slate-50 hover:text-[#D20103] transition-colors mt-auto">
                    Manage Agent Profile <i class="las la-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
@endif
<div id="addAgentModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-white">
            <h4 class="font-bold text-[#003366] text-xl">Provision Sub-Agent Account</h4>
            <button onclick="document.getElementById('addAgentModal').classList.add('hidden')" class="text-slate-400 hover:text-red-500 transition-colors">
                <i class="las la-times text-2xl"></i>
            </button>
        </div>
        
        <div class="p-6">
            <form action="{{ url('/merchant/sub-agents') }}" method="POST">
                @csrf
                
                <div class="mb-5">
                    <label class="block text-sm font-bold text-[#003366] mb-2">Sub-Agent / Branch Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required placeholder="e.g. Lagos Island Branch or Rider 001" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none">
                </div>

                <div class="grid grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Contact Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required placeholder="agent@company.com" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Phone Number <span class="text-red-500">*</span></label>
                        <input type="text" name="phone" required placeholder="08012345678" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none">
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Date of Birth <span class="text-red-500">*</span></label>
                        <input type="date" name="dob" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none text-slate-600">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">BVN <span class="text-red-500">*</span></label>
                        <input type="text" name="bvn" required maxlength="11" placeholder="11-digit BVN" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">NIN <span class="text-red-500">*</span></label>
                        <input type="text" name="nin" required maxlength="11" placeholder="11-digit NIN" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none">
                    </div>
                </div>

                <div class="bg-[#F4F9FF] rounded-lg p-4 flex gap-3 mb-8 border border-[#E1EEFE]">
                    <i class="las la-shield-alt text-[#003366] text-xl mt-0.5"></i>
                    <p class="text-sm text-[#003366] leading-relaxed">
                        CBN regulations require BVN and NIN validation for all permanent static virtual accounts. By proceeding, you confirm consent has been acquired from the assigned sub-agent.
                    </p>
                </div>
                
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="document.getElementById('addAgentModal').classList.add('hidden')" class="px-5 py-2.5 font-bold text-slate-500 hover:text-slate-800 transition-colors">Cancel</button>
                    <button type="submit" class="flex items-center gap-2 px-6 py-2.5 rounded-lg font-bold text-white transition-all hover:bg-blue-900 shadow-sm" style="background-color: #003366;">
                        <i class="las la-server"></i> Generate Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection