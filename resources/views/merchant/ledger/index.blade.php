@extends('layout.merchant')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-[#003366]">Master Transaction Ledger</h2>
        <p class="text-sm text-slate-500 mt-1">Real-time settlement & utility view across all accounts.</p>
    </div>
    
    <div class="flex items-center gap-3">
        <button onclick="document.getElementById('filterModal').classList.remove('hidden')" class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-5 py-2.5 font-bold text-slate-600 shadow-sm transition-all hover:bg-slate-50">
            <i class="las la-filter text-xl"></i> 
            <span>Filter</span>
        </button>
        <a href="{{ url('/merchant/ledger/export') }}?{{ http_build_query(request()->except('page')) }}" class="flex items-center gap-2 rounded-lg px-5 py-2.5 font-bold shadow-sm transition-all text-white hover:bg-blue-900" style="background-color: #003366;">
            <i class="las la-file-csv text-xl"></i> 
            <span>Export CSV</span>
        </a>
    </div>
</div>

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

<div class="box bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">Date & Ref</th>
                    <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">Description</th>
                    <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">Type</th>
                    <th class="px-6 py-4 text-end text-xs font-bold uppercase tracking-wider text-slate-500">Amount</th>
                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-[#003366] font-mono text-sm">{{ $tx->session_id ?? $tx->reference ?? 'SYS-GEN' }}</div>
                        <div class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::parse($tx->created_at)->format('M d, Y • h:i A') }}</div>
                    </td>
                    
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-700 max-w-xs truncate" title="{{ $tx->remarks }}">
                            {{ $tx->remarks ?: 'Virtual Account Settlement' }}
                        </div>
                        @if($tx->fee_charged > 0)
                            <div class="text-xs text-slate-400 mt-1"><i class="las la-tag"></i> Platform Fee: ₦{{ number_format($tx->fee_charged, 2) }}</div>
                        @endif
                    </td>

                    <td class="px-6 py-4">
                        @if($tx->type === 'credit')
                            <span class="inline-flex items-center gap-1 rounded bg-green-50 px-2 py-1 text-xs font-bold text-green-700 border border-green-100">
                                <i class="las la-arrow-down"></i> Credit
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 rounded bg-red-50 px-2 py-1 text-xs font-bold text-red-700 border border-red-100">
                                <i class="las la-arrow-up"></i> Debit
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-end font-black text-lg @if($tx->type === 'credit') text-green-600 @else text-[#003366] @endif">
                        {{ $tx->type === 'credit' ? '+' : '-' }}₦{{ number_format($tx->amount, 2) }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        @if($tx->status === 'successful')
                            <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-bold text-green-700">
                                <div class="size-1.5 rounded-full bg-green-500"></div> Success
                            </span>
                        @elseif($tx->status === 'pending')
                            <span class="inline-flex items-center gap-1 rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-bold text-yellow-700">
                                <div class="size-1.5 rounded-full bg-yellow-500 animate-pulse"></div> Pending
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-bold text-red-700">
                                <div class="size-1.5 rounded-full bg-red-500"></div> Failed
                            </span>
                        @endif
                    </td>
                    
                    <td class="px-6 py-4 text-center">
                        <button onclick="openComplaintModal('{{ $tx->session_id ?? $tx->reference ?? 'UNKNOWN' }}')" class="p-2 bg-slate-100 text-slate-500 hover:text-[#D20103] hover:bg-red-50 rounded-lg transition-all" title="Raise Complaint">
                            <i class="las la-headset text-xl"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="size-16 bg-slate-50 rounded-full flex items-center justify-center mb-3 border border-slate-100">
                                <i class="las la-receipt text-3xl text-slate-400"></i>
                            </div>
                            <p class="font-bold text-slate-600 text-lg">No Transactions Yet</p>
                            <p class="text-sm text-slate-400 mt-1 max-w-sm mx-auto">When your sub-agents receive payments or you process utilities, they will appear here.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(method_exists($transactions, 'hasPages') && $transactions->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        {{ $transactions->links() }}
    </div>
    @endif
</div>

<div id="complaintModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h4 class="font-bold text-[#D20103] flex items-center gap-2">
                <i class="las la-exclamation-circle text-xl"></i> Report Issue
            </h4>
            <button onclick="document.getElementById('complaintModal').classList.add('hidden')" class="text-slate-400 hover:text-red-500 transition-colors">
                <i class="las la-times text-2xl"></i>
            </button>
        </div>
        
        <form action="{{ url('/merchant/ledger/complaint') }}" method="POST" class="p-6">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-bold text-slate-700 mb-2">Transaction Reference</label>
                <input type="text" id="complaint_ref" name="reference" readonly class="w-full text-sm bg-slate-50 border border-slate-200 text-slate-500 font-mono rounded-xl px-4 py-3 outline-none cursor-not-allowed">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-bold text-slate-700 mb-2">Issue Category</label>
                <select name="category" required class="w-full text-sm bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none">
                    <option value="">Select an issue...</option>
                    <option value="not_received">Value not received (Airtime/Data/Token)</option>
                    <option value="wrong_amount">Wrong amount debited</option>
                    <option value="failed_but_debited">Transaction Failed but account was debited</option>
                    <option value="other">Other</option>
                </select>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Message Details</label>
                <textarea name="message" required rows="3" placeholder="Please provide any extra details..." class="w-full text-sm bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-[#003366] focus:ring-1 outline-none resize-none"></textarea>
            </div>
            
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('complaintModal').classList.add('hidden')" class="px-5 py-2.5 rounded-lg font-bold text-slate-600 hover:bg-slate-50 transition-colors border border-slate-200">Cancel</button>
                <button type="submit" class="px-5 py-2.5 rounded-lg font-bold text-white transition-colors hover:bg-red-700 shadow-sm" style="background-color: #D20103;">Submit Report</button>
            </div>
        </form>
    </div>
</div>

<div id="filterModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h4 class="font-bold text-[#003366]">Filter Transactions</h4>
            <button onclick="document.getElementById('filterModal').classList.add('hidden')" class="text-slate-400 hover:text-red-500 transition-colors">
                <i class="las la-times text-2xl"></i>
            </button>
        </div>
        
        <div class="p-6">
            <form action="{{ url('/merchant/ledger') }}" method="GET">
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Fund Flow</label>
                        <select name="type" class="w-full text-sm bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-[#003366] outline-none">
                            <option value="">All Types</option>
                            <option value="credit" {{ request('type') == 'credit' ? 'selected' : '' }}>Money In (Credit)</option>
                            <option value="debit" {{ request('type') == 'debit' ? 'selected' : '' }}>Money Out (Debit)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Status</label>
                        <select name="status" class="w-full text-sm bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-[#003366] outline-none">
                            <option value="">All Statuses</option>
                            <option value="successful" {{ request('status') == 'successful' ? 'selected' : '' }}>Successful</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed / Refunded</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Service Category</label>
                    <select name="category" class="w-full text-sm bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-[#003366] outline-none">
                        <option value="">All Categories</option>
                        <option value="Airtime" {{ request('category') == 'Airtime' ? 'selected' : '' }}>Airtime Purchases</option>
                        <option value="Data" {{ request('category') == 'Data' ? 'selected' : '' }}>Data Bundles</option>
                        <option value="Betting" {{ request('category') == 'Betting' ? 'selected' : '' }}>Betting Deposits</option>
                        <option value="Electricity" {{ request('category') == 'Electricity' ? 'selected' : '' }}>Electricity Tokens</option>
                        <option value="Payout" {{ request('category') == 'Payout' ? 'selected' : '' }}>Withdrawals / Payouts</option>
                    </select>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Date Range</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="w-full text-sm bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-[#003366] outline-none">
                </div>
                
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ url('/merchant/ledger') }}" class="px-5 py-2.5 rounded-lg font-bold text-slate-600 hover:bg-slate-50 transition-colors border border-slate-200">Clear All</a>
                    <button type="submit" class="px-5 py-2.5 rounded-lg font-bold text-white transition-colors hover:bg-blue-900 shadow-sm" style="background-color: #003366;">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openComplaintModal(ref) {
        document.getElementById('complaint_ref').value = ref;
        document.getElementById('complaintModal').classList.remove('hidden');
    }
</script>
@endsection