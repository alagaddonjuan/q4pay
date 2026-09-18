@extends('layout.vendor')

@section('content')
    <div class="main-inner bg-[#F8FAFC] min-h-screen p-4 lg:p-6">
        
        <!-- HEADER -->
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div>
                <h2 class="text-3xl font-black text-[#0B3A75] mb-1">My Products</h2>
                <p class="text-sm text-[#64748B]">Manage your inventory and copy secure payment links for your customers.</p>
            </div>
            
            <a href="{{ route('vendor.products.create') }}" class="flex items-center gap-2 rounded-xl bg-[#0878F8] px-5 py-2.5 font-bold text-white shadow-md shadow-[#0878F8]/30 transition-all hover:-translate-y-0.5 hover:bg-[#0B3A75] hover:shadow-none">
                <i class="las la-plus-circle text-xl"></i> Add New Product
            </a>
        </div>

        <!-- TABLE CONTAINER -->
        <div class="bg-white border border-[#D1D5DB] rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap text-sm">
                    <thead class="bg-[#F8FAFC] border-b border-[#D1D5DB] text-[#64748B]">
                        <tr>
                            <th class="px-6 py-5 text-start font-bold uppercase tracking-wider text-xs">Product Details</th>
                            <th class="px-6 py-5 text-start font-bold uppercase tracking-wider text-xs">Price</th>
                            <th class="px-6 py-5 text-start font-bold uppercase tracking-wider text-xs">Stock</th>
                            <th class="px-6 py-5 text-start font-bold uppercase tracking-wider text-xs">Status</th>
                            <th class="px-6 py-5 text-end font-bold uppercase tracking-wider text-xs">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#D1D5DB]">
                        @forelse($products as $product)
                            <tr class="hover:bg-[#F8FAFC] transition-colors group">
                                
                                <!-- Product Details -->
                                <td class="px-6 py-4">
    <div class="flex items-center gap-4">
        
        <!-- 🟢 ULTIMATE IMAGE DECODER -->
        @php
            $imageSrc = null;
            if(!empty($product->image)) {
                // Try to decode it properly first
                $decoded = json_decode($product->image, true);
                $firstImage = is_array($decoded) ? ($decoded[0] ?? null) : $product->image;
                
                if ($firstImage) {
                    // Forcefully clean up any rogue database characters (brackets, quotes, backslashes)
                    $cleanString = str_replace(['[', ']', '"', '\\'], '', $firstImage);
                    
                    // If multiple links got jammed together, safely grab just the first one
                    $firstImage = trim(explode(',', $cleanString)[0]);

                    // Check if it is an external URL, otherwise map it to local storage
                    if (preg_match('/^https?:\/\//i', $firstImage)) {
                        $imageSrc = $firstImage;
                    } else {
                        $imageSrc = asset('storage/' . ltrim($firstImage, '/'));
                    }
                }
            }
        @endphp

        @if($imageSrc)
            <img src="{{ $imageSrc }}" 
                 class="size-14 rounded-xl object-cover border border-[#D1D5DB] shadow-sm bg-white" 
                 alt="{{ $product->name }}"
                 onerror="this.onerror=null; this.src='https://placehold.co/100x100/F8FAFC/94A3B8?text=Error';">
        @else
            <div class="flex size-14 items-center justify-center rounded-xl bg-[#0878F8]/5 border border-[#0878F8]/10 text-[#0878F8]">
                <i class="las la-box text-3xl"></i>
            </div>
        @endif
        
        <div>
            <p class="font-bold text-[#1F2937] text-base mb-0.5">{{ $product->name }}</p>
            <span class="text-xs font-bold text-[#94A3B8] uppercase tracking-wider">{{ $product->category }}</span>
        </div>
    </div>
</td>
                                
                                <!-- Price -->
                                <td class="px-6 py-4 font-black text-[#1F2937] text-base">
                                    ₦{{ number_format($product->price, 2) }}
                                </td>
                                
                                <!-- Stock -->
                                <td class="px-6 py-4">
                                    <span class="font-medium text-[#64748B] bg-[#F8FAFC] border border-[#D1D5DB] px-3 py-1 rounded-lg">
                                        {{ $product->stock }} in stock
                                    </span>
                                </td>
                                
                                <!-- Status Badge -->
                                <td class="px-6 py-4">
                                    @if($product->is_active)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#108981]/10 px-3 py-1.5 text-xs font-bold text-[#108981] ring-1 ring-inset ring-[#108981]/20">
                                            <span class="size-1.5 rounded-full bg-[#108981]"></span> Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#94A3B8]/10 px-3 py-1.5 text-xs font-bold text-[#64748B] ring-1 ring-inset ring-[#94A3B8]/30">
                                            <span class="size-1.5 rounded-full bg-[#94A3B8]"></span> Draft
                                        </span>
                                    @endif
                                </td>
                                
                                <!-- Action Buttons -->
                                <td class="px-6 py-4 text-end">
                                    <div class="flex items-center justify-end gap-2">
                                        
                                        @if(isset($product->slug))
                                            <button onclick="copyLink(this, '{{ route('checkout.show', $product->slug) }}')" class="flex items-center gap-1.5 rounded-lg bg-[#0878F8]/10 border border-[#0878F8]/20 px-3 py-2 text-sm font-bold text-[#0878F8] transition-all hover:bg-[#0878F8] hover:text-white" title="Copy Escrow Link">
                                                <i class="las la-link text-lg link-icon"></i> <span class="link-text">Copy Link</span>
                                            </button>
                                        @else
                                            <span class="text-xs font-medium text-[#94A3B8] px-2 bg-[#F8FAFC] rounded border border-dashed border-[#D1D5DB]">Legacy Item</span>
                                        @endif
                                        
                                        <a href="{{ route('vendor.products.edit', $product->id) }}" class="flex size-[38px] items-center justify-center rounded-lg border border-[#D1D5DB] bg-white text-[#64748B] transition-all hover:border-[#0878F8] hover:text-[#0878F8] shadow-sm">
                                            <i class="las la-pen text-lg"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <!-- Empty State -->
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="h-20 w-20 bg-[#F8FAFC] rounded-full flex items-center justify-center mb-4 border border-[#D1D5DB]">
                                            <i class="las la-box-open text-4xl text-[#94A3B8]"></i>
                                        </div>
                                        <p class="text-xl font-bold text-[#1F2937] mb-1">No products found</p>
                                        <p class="text-sm text-[#64748B] max-w-sm mb-6">You haven't uploaded any items to sell yet. Add a product to generate your first Escrow payment link.</p>
                                        
                                        <a href="{{ route('vendor.products.create') }}" class="inline-flex items-center gap-2 rounded-xl border border-[#0878F8] text-[#0878F8] bg-white px-5 py-2.5 font-bold transition-all hover:bg-[#0878F8]/5">
                                            <i class="las la-plus text-xl"></i> Create Product
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Smart Copy Link Script -->
    <script>
        function copyLink(btnElement, link) {
            navigator.clipboard.writeText(link).then(() => {
                // Grab the text and icon elements inside the button
                const icon = btnElement.querySelector('.link-icon');
                const text = btnElement.querySelector('.link-text');
                
                // Save original styles
                const originalBg = btnElement.className;
                const originalText = text.innerText;
                const originalIcon = icon.className;

                // Apply Success state (Q4I Success Teal)
                btnElement.className = "flex items-center gap-1.5 rounded-lg bg-[#108981] border border-[#108981] px-3 py-2 text-sm font-bold text-white transition-all";
                icon.className = "las la-check-circle text-lg link-icon";
                text.innerText = "Copied!";

                // Revert back after 2 seconds
                setTimeout(() => {
                    btnElement.className = originalBg;
                    icon.className = originalIcon;
                    text.innerText = originalText;
                }, 2000);
            });
        }
    </script>
@endsection