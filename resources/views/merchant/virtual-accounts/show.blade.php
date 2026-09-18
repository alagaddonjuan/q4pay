@extends('layout.merchant')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div class="flex items-center gap-4">
        <a href="{{ url('/merchant/virtual-accounts') }}" class="flex size-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:bg-slate-50 hover:text-[#003366] transition-all">
            <i class="las la-arrow-left text-xl"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-[#003366]">Account Profile</h2>
            <p class="text-sm text-slate-500 mt-1">System ID: <span class="font-mono text-slate-700">{{ $account->customer_id }}</span> • Provisioned {{ \Carbon\Carbon::parse($account->created_at)->format('M d, Y') }}</p>
        </div>
    </div>
    
    <div class="flex items-center gap-3">
        @if($account->is_active)
            <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-4 py-2 text-sm font-bold text-green-600 border border-green-200 shadow-sm">
                <span class="h-2 w-2 rounded-full bg-green-600"></span> Live & Active
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-4 py-2 text-sm font-bold text-red-600 border border-red-200 shadow-sm">
                <span class="h-2 w-2 rounded-full bg-red-600"></span> Inactive / Suspended
            </span>
        @endif
    </div>
</div>
@if(session('success'))
<div class="mb-6 rounded-xl bg-green-50 p-4 border border-green-200 shadow-sm transition-all">
    <div class="flex items-center gap-3">
        <div class="flex size-8 items-center justify-center rounded-full bg-green-100">
            <i class="las la-check text-green-600 text-xl"></i>
        </div>
        <p class="text-sm text-green-700 font-bold">{{ session('success') }}</p>
    </div>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <div class="box bg-[#003366] text-white p-6 rounded-2xl shadow-lg relative overflow-hidden col-span-1">
        <div class="absolute -right-10 -top-10 opacity-10">
            <i class="las la-wallet text-9xl"></i>
        </div>
        
        <p class="text-blue-200 text-sm font-bold uppercase tracking-wider mb-1">Available Balance</p>
        <h3 class="text-4xl font-black tracking-tight mb-6">₦{{ number_format($account->ledger_balance, 2) }}</h3>
        
        <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm border border-white/20">
            <p class="text-blue-200 text-xs uppercase font-bold mb-1">Account Number</p>
            <div class="flex items-center justify-between">
                <p class="text-2xl font-mono tracking-widest font-bold">{{ $account->account_number }}</p>
                <button class="text-white hover:text-blue-200 transition-colors" onclick="navigator.clipboard.writeText('{{ $account->account_number }}'); alert('Copied!')">
                    <i class="las la-copy text-xl"></i>
                </button>
            </div>
            <p class="text-sm font-medium mt-1">{{ $account->bank_name }}</p>
        </div>
    </div>

    <div class="box bg-white p-6 rounded-2xl shadow-sm border border-slate-200 col-span-1 lg:col-span-2">
        <div class="flex items-center gap-4 mb-6 pb-4 border-b border-slate-100">
            <div class="flex size-14 items-center justify-center rounded-full bg-slate-100 text-[#003366]">
                <i class="las la-user-tie text-3xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800">{{ $account->first_name }} {{ $account->last_name }}</h3>
                <p class="text-sm text-slate-500"><i class="las la-envelope mr-1"></i> {{ $account->email }}</p>
            </div>
            <button onclick="document.getElementById('edit-modal').style.display='flex'" class="ml-auto flex items-center gap-2 rounded-lg px-4 py-2 text-sm font-bold text-slate-600 bg-slate-50 border border-slate-200 hover:bg-slate-100 transition-all">
                <i class="las la-edit text-lg"></i> Edit Details
            </button>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Phone Number</p>
                <p class="font-bold text-slate-700">{{ $account->phone_number }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Date of Birth</p>
                <p class="font-bold text-slate-700">{{ $account->date_of_birth }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">BVN Validation</p>
                <p class="font-bold text-slate-700 flex items-center gap-1">
                    {{ $account->bvn }} <i class="las la-check-circle text-green-500"></i>
                </p>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">NIN Validation</p>
                <p class="font-bold text-slate-700 flex items-center gap-1">
                    {{ $account->nin }} <i class="las la-check-circle text-green-500"></i>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="box bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 bg-slate-50/50">
        <div class="flex items-center gap-2">
            <i class="las la-exchange-alt text-xl text-[#003366]"></i>
            <h3 class="text-lg font-bold text-slate-800">Transaction History</h3>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ url('/merchant/virtual-accounts/' . $account->id . '/mock-transaction') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm font-bold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100 hover:bg-blue-100 transition-colors flex items-center gap-1">
                    <i class="las la-bolt text-lg"></i> Simulate Transfer
                </button>
            </form>

            <a href="{{ url('/merchant/virtual-accounts/' . $account->id . '/export') }}" class="text-sm font-bold text-[#003366] hover:text-[#D20103] flex items-center gap-1 transition-colors">
                <i class="las la-download text-lg"></i> Export Statement
            </a>
        </div>
    </div>

    @if(empty($transactions) || count($transactions) === 0)
        <div class="flex flex-col items-center justify-center py-16">
            <div class="flex size-16 items-center justify-center rounded-full bg-slate-50 mb-4 border border-slate-100">
                <i class="las la-receipt text-3xl text-slate-300"></i>
            </div>
            <h4 class="text-md font-bold text-slate-700 mb-1">No Transactions Yet</h4>
            <p class="text-sm text-slate-500 text-center max-w-sm">This virtual account has not received any inbound transfers or collections.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-800">
                    <tr>
                        <th class="px-6 py-4 font-bold">Date & Time</th>
                        <th class="px-6 py-4 font-bold">Session ID</th>
                        <th class="px-6 py-4 font-bold">Type</th>
                        <th class="px-6 py-4 font-bold text-right">Amount</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($transactions as $trx)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($trx->created_at)->format('M d, Y') }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($trx->created_at)->format('h:i A') }}</p>
                        </td>
                        <td class="px-6 py-4 font-mono text-xs">{{ $trx->session_id }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded bg-slate-100 px-2 py-1 text-xs font-bold text-slate-600">
                                <i class="las la-arrow-down text-green-600"></i> Credit
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-green-600">+₦{{ number_format($trx->amount, 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded border border-green-100">Successful</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
<div id="edit-modal" class="fixed inset-0 z-[100] items-center justify-center bg-slate-900/60 backdrop-blur-sm transition-opacity" style="display: none;">
    <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl overflow-hidden transform transition-all">
        <div class="flex items-center justify-between bg-slate-50 px-6 py-4 border-b border-slate-100">
            <h3 class="text-lg font-bold text-[#003366]">Update Contact Details</h3>
            <button onclick="document.getElementById('edit-modal').style.display='none'" class="text-slate-400 hover:text-[#D20103] transition-colors">
                <i class="las la-times text-2xl"></i>
            </button>
        </div>

        <form action="{{ url('/merchant/virtual-accounts/' . $account->id . '/update') }}" method="POST" class="p-6">
            @csrf
            <div class="mb-4">
                <label class="mb-2 block text-sm font-bold text-[#003366]">Contact Email</label>
                <input type="email" name="email" value="{{ $account->email }}" required class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm focus:border-[#003366] outline-none">
            </div>
            <div class="mb-6">
                <label class="mb-2 block text-sm font-bold text-[#003366]">Phone Number</label>
                <input type="text" name="phone" value="{{ $account->phone_number }}" required class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm focus:border-[#003366] outline-none">
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="button" onclick="document.getElementById('edit-modal').style.display='none'" class="rounded-lg px-5 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-100 transition-colors">Cancel</button>
                <button type="submit" class="rounded-lg px-6 py-2.5 text-sm font-bold shadow-sm transition-all text-white" style="background-color: #003366;">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection