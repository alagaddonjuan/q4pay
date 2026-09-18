@extends('layout.merchant')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-[#003366]">Recent Payment Links</h2>
        <p class="text-sm text-slate-500 mt-1">Single-use URLs for quick customer invoicing.</p>
    </div>
    <div class="flex gap-4">
        <button onclick="document.getElementById('addLinkModal').classList.remove('hidden')" class="flex items-center gap-2 rounded-xl px-6 py-3 font-bold shadow-sm transition-all hover:-translate-y-1 hover:shadow-md" style="background-color: #D20103; color: white;">
            <i class="las la-plus-circle text-xl"></i> 
            <span>Create New Link</span>
        </button>
    </div>
</div>

<div class="box bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">Title & Ref</th>
                    <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">Checkout URL</th>
                    <th class="px-6 py-4 text-start text-xs font-bold uppercase tracking-wider text-slate-500">Temporary VA</th>
                    <th class="px-6 py-4 text-end text-xs font-bold uppercase tracking-wider text-slate-500">Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($paymentLinks as $link)
                <tr class="border-b border-slate-50 hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <p class="font-bold text-[#003366] text-sm">{{ $link->title }}</p>
                        <p class="text-xs text-slate-400 mt-0.5 uppercase">{{ $link->reference }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <input type="text" value="{{ route('corporate.checkout.show', $link->reference) }}" readonly class="text-xs bg-slate-100 text-slate-500 border border-slate-200 p-2 rounded-lg w-64 focus:outline-none">
                            <button onclick="navigator.clipboard.writeText('{{ route('corporate.checkout.show', $link->reference) }}'); alert('Copied!');" class="text-slate-400 hover:text-[#003366] transition-colors">
                                <i class="las la-copy text-lg"></i>
                            </button>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-[#003366] text-sm">Dynamic</p>
                        <p class="text-xs text-slate-400 mt-0.5">Generated at checkout</p>
                    </td>
                    <td class="px-6 py-4 text-end font-black text-[#003366]">
                        ₦{{ number_format($link->amount, 2) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                        <i class="las la-link text-4xl mb-2 text-slate-300"></i>
                        <p>No payment links generated yet.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(method_exists($paymentLinks, 'hasPages') && $paymentLinks->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $paymentLinks->links() }}
        </div>
    @endif
</div>

<div id="addLinkModal" class="fixed inset-0 hidden z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl p-8 w-full max-w-md shadow-xl">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-[#003366]">Create Payment Link</h3>
            <button onclick="document.getElementById('addLinkModal').classList.add('hidden')" class="text-slate-400 hover:text-red-500">
                <i class="las la-times text-2xl"></i>
            </button>
        </div>
        <form action="{{ route('merchant.payment-links.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-bold text-slate-700 mb-2">Purpose/Title</label>
                <input type="text" name="title" required placeholder="e.g. Cooking fees" class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-[#003366] transition-colors">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Amount (₦)</label>
                <input type="number" name="amount" required placeholder="10000" class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-[#003366] transition-colors">
            </div>
            <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl font-bold shadow-sm transition-all hover:-translate-y-1 hover:shadow-md" style="background-color: #003366; color: white;">
                <i class="las la-link"></i> Generate Link
            </button>
        </form>
    </div>
</div>
@endsection