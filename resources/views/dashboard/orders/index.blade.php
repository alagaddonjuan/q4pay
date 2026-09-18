@extends('layout.vendor')

@section('content')
    <div class="main-inner bg-[#F8FAFC] min-h-screen p-4 lg:p-6">
        
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div>
                <h2 class="text-3xl font-black text-[#0B3A75] mb-1">Escrow Orders</h2>
                <p class="text-sm text-[#64748B]">Track incoming payments, active escrow locks, and released funds.</p>
            </div>
            
            <button class="flex items-center gap-2 rounded-xl border border-[#D1D5DB] bg-white px-4 py-2 font-semibold text-[#1F2937] shadow-sm transition-all hover:border-[#0878F8] hover:text-[#0878F8] hover:shadow-md">
                <i class="las la-download text-lg"></i> Download CSV
            </button>
        </div>

        <div class="bg-white border border-[#D1D5DB] rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap text-sm">
                    <thead class="bg-[#F8FAFC] border-b border-[#D1D5DB] text-[#64748B]">
                        <tr>
                            <th class="px-6 py-5 text-start font-bold uppercase tracking-wider text-xs">Transaction Ref</th>
                            <th class="px-6 py-5 text-start font-bold uppercase tracking-wider text-xs">Date</th>
                            <th class="px-6 py-5 text-start font-bold uppercase tracking-wider text-xs">Amount</th>
                            <th class="px-6 py-5 text-start font-bold uppercase tracking-wider text-xs">Escrow Status</th>
                            <th class="px-6 py-5 text-end font-bold uppercase tracking-wider text-xs">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#D1D5DB]">
                        @forelse($orders as $order)
                            <tr class="hover:bg-[#F8FAFC] transition-colors group">
                                
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex size-10 items-center justify-center rounded-full bg-[#0878F8]/10 text-[#0878F8] group-hover:bg-[#0878F8] group-hover:text-white transition-colors">
                                            <i class="las la-file-invoice-dollar text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-[#1F2937]">{{ $order->reference ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <p class="font-medium text-[#1F2937] mb-0.5">{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}</p>
                                    <span class="text-xs font-medium text-[#94A3B8]">{{ \Carbon\Carbon::parse($order->created_at)->format('h:i A') }}</span>
                                </td>
                                
                                <td class="px-6 py-4 font-black text-[#1F2937] text-base">
                                    ₦{{ number_format($order->amount, 2) }}
                                </td>
                                
                                <td class="px-6 py-4">
                                    @if($order->status == 'released')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#108981]/10 px-3 py-1.5 text-xs font-bold text-[#108981] ring-1 ring-inset ring-[#108981]/20">
                                            <span class="size-1.5 rounded-full bg-[#108981]"></span> Funds Released
                                        </span>
                                    @elseif($order->status == 'awaiting_funds')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#F59E0B]/10 px-3 py-1.5 text-xs font-bold text-[#F59E0B] ring-1 ring-inset ring-[#F59E0B]/20">
                                            <span class="size-1.5 rounded-full bg-[#F59E0B] animate-pulse"></span> Awaiting Buyer
                                        </span>
                                    @elseif($order->status == 'failed' || $order->status == 'cancelled')
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EF4444]/10 px-3 py-1.5 text-xs font-bold text-[#EF4444] ring-1 ring-inset ring-[#EF4444]/20">
                                            <i class="las la-times-circle text-sm"></i> Cancelled
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#0878F8]/10 px-3 py-1.5 text-xs font-bold text-[#0878F8] ring-1 ring-inset ring-[#0878F8]/20">
                                            <i class="las la-lock text-sm"></i> Locked in Escrow
                                        </span>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 text-end">
                                    <a href="{{ route('vendor.orders.show', $order->reference) }}" class="inline-flex items-center gap-1 rounded-lg border border-[#D1D5DB] bg-white px-3 py-2 text-sm font-semibold text-[#64748B] transition-all hover:bg-[#0878F8] hover:text-white hover:border-[#0878F8] shadow-sm">
                                        View Details <i class="las la-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="h-20 w-20 bg-[#F8FAFC] rounded-full flex items-center justify-center mb-4 border border-[#D1D5DB]">
                                            <i class="las la-receipt text-4xl text-[#94A3B8]"></i>
                                        </div>
                                        <p class="text-xl font-bold text-[#1F2937] mb-1">No orders yet</p>
                                        <p class="text-sm text-[#64748B] max-w-sm">When customers pay via your Q4I Gateway links, their escrow transactions will securely appear here.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection