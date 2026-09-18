@extends('layout.merchant')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-[#003366]">Audit Logs</h2>
        <p class="text-sm text-slate-500 mt-1">Review all actions and security events on your account.</p>
    </div>
</div>

<div class="box bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-8">
    <div class="p-6 border-b border-slate-100">
        <h4 class="font-bold text-[#003366]">Activity Log</h4>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">Timestamp</th>
                    <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">Action</th>
                    <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">Module</th>
                    <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">User / Actor</th>
                    <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">IP Address</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($logs as $log)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $log->created_at->format('d M, Y • H:i:s') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <p class="text-sm font-bold text-[#003366]">{{ ucwords(str_replace('_', ' ', $log->action)) }}</p>
                                @if($log->description)
                                    <i class="las la-info-circle text-slate-400 cursor-pointer" title="{{ $log->description }}"></i>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            {{ ucfirst($log->module) }}
                        </td>
                        <td class="px-6 py-4">
                            @if($log->user_type === 'merchant')
                                <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-bold text-blue-700">
                                    Merchant (Owner)
                                </span>
                            @elseif($log->user_type === 'team_member')
                                <span class="inline-flex items-center gap-1 rounded-full bg-purple-100 px-2.5 py-0.5 text-xs font-bold text-purple-700">
                                    Team Member ({{ $log->user_id }})
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-bold text-slate-700">
                                    System
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm font-mono text-slate-500">
                            {{ $log->ip_address ?? 'N/A' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            <i class="las la-clipboard-list text-4xl mb-2 text-slate-300"></i>
                            <p>No activity logs found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(method_exists($logs, 'hasPages') && $logs->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $logs->links() }}
        </div>
    @endif
</div>

@endsection
