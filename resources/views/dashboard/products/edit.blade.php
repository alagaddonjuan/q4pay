@extends('layout.vendor')

@section('content')

    <!-- 🟢 Q4I BRAND COLOR OVERRIDES -->
    <style>
        .box { background-color: #FFFFFF !important; border: 1px solid #D1D5DB !important; border-radius: 1rem; padding: 1.5rem; }
        .bb-dashed { border-bottom: 1px dashed #D1D5DB !important; }
        .h2, .h4 { color: #0B3A75 !important; font-weight: 700 !important; }
        .text-q4i-primary { color: #0878F8 !important; }
        
        .btn-q4i-primary { 
            background-color: #0878F8 !important; 
            color: #FFFFFF !important; 
            transition: all 0.3s ease; 
            box-shadow: 0 4px 6px -1px rgba(8, 120, 248, 0.3); 
        }
        .btn-q4i-primary:hover { 
            background-color: #0B3A75 !important; 
            transform: translateY(-1px); 
            box-shadow: 0 6px 8px -1px rgba(11, 58, 117, 0.3);
        }
        
        .btn-outline-q4i { 
            border: 1px solid #D1D5DB; 
            color: #1F2937; 
            background-color: #FFFFFF;
            transition: all 0.3s ease; 
        }
        .btn-outline-q4i:hover { 
            border-color: #0878F8; 
            color: #0878F8; 
            box-shadow: 0 4px 6px -1px rgba(8, 120, 248, 0.1); 
        }
        
        .input-q4i:focus {
            border-color: #0878F8 !important;
            box-shadow: 0 0 0 1px #0878F8 !important;
        }
    </style>

    <div class="main-inner bg-[#F8FAFC] min-h-screen p-4 lg:p-6">
        
        <!-- HEADER -->
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div>
                <h2 class="h2 mb-2 text-3xl font-black">Edit Product</h2>
                <p class="text-sm text-[#64748B]">Update details, pricing, and inventory for <span class="font-bold text-[#0878F8]">{{ $product->name }}</span>.</p>
            </div>
            <a href="{{ route('vendor.products.index') }}" class="btn-outline-q4i flex items-center gap-2 rounded-xl px-5 py-2.5 font-semibold">
                <i class="las la-arrow-left text-lg"></i> Back to Products
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-[#EF4444]/20 bg-[#EF4444]/5 p-4 text-[#EF4444]">
                <p class="font-bold mb-2"><i class="las la-exclamation-circle text-lg"></i> Please fix the following errors:</p>
                <ul class="list-inside list-disc pl-4 text-sm font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('vendor.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
              onsubmit="document.getElementById('submit-btn').innerHTML = '<i class=\'las la-spinner la-spin text-xl\'></i> Saving Changes...'; document.getElementById('submit-btn').classList.add('opacity-75', 'cursor-not-allowed'); document.getElementById('submit-btn').disabled = true;">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-12 gap-4 xxl:gap-6">
                
                <!-- LEFT COLUMN: Basic Info & Settings -->
                <div class="col-span-12 lg:col-span-8">
                    
                    <div class="box mb-6">
                        <h4 class="h4 mb-6 bb-dashed pb-4 text-xl">Basic Information</h4>
                        
                        <div class="mb-5">
                            <label class="mb-2 block font-bold text-[#1F2937]">Product Name <span class="text-[#EF4444]">*</span></label>
                            <input type="text" name="name" value="{{ $product->name }}" required
                                class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-medium text-[#1F2937]">
                        </div>

                        <div class="mb-5">
                            <label class="mb-2 block font-bold text-[#1F2937]">Description</label>
                            <textarea name="description" rows="4" 
                                class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-medium text-[#1F2937]">{{ $product->description }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="mb-2 block font-bold text-[#1F2937]">Price (₦) <span class="text-[#EF4444]">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-[#64748B]">₦</span>
                                    <input type="number" name="price" required step="0.01" value="{{ $product->price }}"
                                        class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] pl-10 pr-4 py-3 text-sm outline-none transition-all font-medium text-[#1F2937]">
                                </div>
                            </div>
                            <div>
                                <label class="mb-2 block font-bold text-[#1F2937]">Stock Quantity</label>
                                <input type="number" name="stock" value="{{ $product->stock }}" required
                                    class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-medium text-[#1F2937]">
                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <h4 class="h4 mb-6 bb-dashed pb-4 text-xl">Product Settings</h4>
                        
                        <div class="grid grid-cols-2 gap-5 mb-2">
                            <div>
                                <label class="mb-2 block font-bold text-[#1F2937]">Category <span class="text-[#EF4444]">*</span></label>
                                <select name="category" class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-medium text-[#1F2937] cursor-pointer">
                                    <option value="fashion" {{ $product->category == 'fashion' ? 'selected' : '' }}>👗 Clothing & Fashion</option>
                                    <option value="electronics" {{ $product->category == 'electronics' ? 'selected' : '' }}>📱 Electronics</option>
                                    <option value="beauty" {{ $product->category == 'beauty' ? 'selected' : '' }}>💄 Health & Beauty</option>
                                    <option value="home" {{ $product->category == 'home' ? 'selected' : '' }}>🛋️ Home & Furniture</option>
                                    <option value="services" {{ $product->category == 'services' ? 'selected' : '' }}>💻 Digital Services</option>
                                    <option value="other" {{ $product->category == 'other' ? 'selected' : '' }}>🛍️ Other Items</option>
                                </select>
                            </div>
                            <div>
                                <label class="mb-2 block font-bold text-[#1F2937]">Publish Status</label>
                                <select name="is_active" class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-medium text-[#1F2937] cursor-pointer">
                                    <option value="1" {{ $product->is_active ? 'selected' : '' }}>🟢 Active (Visible to buyers)</option>
                                    <option value="0" {{ !$product->is_active ? 'selected' : '' }}>⚪ Draft (Hidden from store)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Images & Publish -->
                <div class="col-span-12 lg:col-span-4">
                    <div class="box mb-6">
                        <h4 class="h4 mb-6 bb-dashed pb-4 text-xl">Product Image</h4>
                        
                        <!-- Show Current Image if it exists -->
                        @php
    $imageSrc = null;
    if($product->image) {
        $decoded = json_decode($product->image, true);
        $firstImage = is_array($decoded) ? ($decoded[0] ?? null) : $product->image;
        
        if ($firstImage) {
            $firstImage = trim($firstImage, ' "');
            $imageSrc = str_starts_with($firstImage, 'http') ? $firstImage : asset('storage/' . $firstImage);
        }
    }
@endphp

@if($imageSrc)
    <div class="mb-4">
        <p class="text-xs font-bold uppercase tracking-wider text-[#64748B] mb-2">Current Image</p>
        <div class="relative rounded-xl border border-[#D1D5DB] overflow-hidden bg-[#F8FAFC] p-2 flex justify-center">
            <img src="{{ $imageSrc }}" 
                 alt="{{ $product->name }}" 
                 class="h-40 w-auto object-contain rounded-lg drop-shadow-sm"
                 onerror="this.src='https://placehold.co/400x400/F8FAFC/94A3B8?text=Image+Broken'">
        </div>
    </div>
@endif
                        
                        <label class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-[#D1D5DB] bg-[#F8FAFC] p-6 text-center transition-all hover:border-[#0878F8] hover:bg-[#0878F8]/5 cursor-pointer group">
                            <i class="las la-cloud-upload-alt text-4xl text-[#94A3B8] mb-2 group-hover:text-[#0878F8] transition-colors"></i>
                            
                            <p id="file-name-display" class="font-bold text-[#1F2937] group-hover:text-[#0878F8] transition-colors">Replace Image</p>
                            <p class="text-xs text-[#64748B] mt-1">Leave blank to keep current image</p>
                            
                            <input type="file" name="image" accept="image/*" class="hidden" 
                                onchange="document.getElementById('file-name-display').innerText = this.files[0] ? this.files[0].name : 'Replace Image'; document.getElementById('file-name-display').classList.add('text-[#0878F8]');">
                        </label>
                    </div>

                    <div class="box">
                        <h4 class="h4 mb-4 bb-dashed pb-4 text-xl">Save Updates</h4>
                        <p class="text-sm text-[#64748B] mb-6 leading-relaxed">Changes will immediately reflect on your live WhatsApp catalog.</p>
                        
                        <div class="space-y-3">
                            <button type="submit" id="submit-btn" class="btn-q4i-primary w-full flex items-center justify-center gap-2 py-3.5 rounded-xl font-bold text-lg">
                                <i class="las la-save text-xl"></i> Save Changes
                            </button>
                            <a href="{{ route('vendor.products.index') }}" class="btn-outline-q4i w-full flex items-center justify-center gap-2 py-3.5 rounded-xl font-bold text-lg">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection