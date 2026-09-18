@extends('layout.vendor')

@section('content')

    <style>
        .box { background-color: #FFFFFF !important; border: 1px solid #D1D5DB !important; border-radius: 1rem; padding: 1.5rem; }
        .bb-dashed { border-bottom: 1px dashed #D1D5DB !important; }
        .h2, .h4 { color: #0B3A75 !important; font-weight: 700 !important; }
        .text-q4i-primary { color: #0878F8 !important; }
        
        .btn-q4i-primary { background-color: #0878F8 !important; color: #FFFFFF !important; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(8, 120, 248, 0.3); }
        .btn-q4i-primary:hover { background-color: #0B3A75 !important; transform: translateY(-1px); box-shadow: 0 6px 8px -1px rgba(11, 58, 117, 0.3); }
        
        .btn-outline-q4i { border: 1px solid #D1D5DB; color: #1F2937; background-color: #FFFFFF; transition: all 0.3s ease; }
        .btn-outline-q4i:hover { border-color: #0878F8; color: #0878F8; box-shadow: 0 4px 6px -1px rgba(8, 120, 248, 0.1); }
        
        .input-q4i:focus { border-color: #0878F8 !important; box-shadow: 0 0 0 1px #0878F8 !important; }
    </style>

    <div class="main-inner bg-[#F8FAFC] min-h-screen p-4 lg:p-6">
        
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div>
                <h2 class="h2 mb-2 text-3xl font-black">Add New Product</h2>
                <p class="text-sm text-[#64748B]">Create an item to generate a secure Escrow payment link.</p>
            </div>
            <a href="{{ route('vendor.dashboard') }}" class="btn-outline-q4i flex items-center gap-2 rounded-xl px-5 py-2.5 font-semibold">
                <i class="las la-arrow-left text-lg"></i> Back to Dashboard
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

        <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data" 
              onsubmit="document.getElementById('submit-btn').innerHTML = '<i class=\'las la-spinner la-spin text-xl\'></i> Processing...'; document.getElementById('submit-btn').classList.add('opacity-75', 'cursor-not-allowed'); document.getElementById('submit-btn').disabled = true;">
            @csrf
            
            <div class="grid grid-cols-12 gap-4 xxl:gap-6">
                
                <div class="col-span-12 lg:col-span-8">
                    
                    <div class="box mb-6">
                        <h4 class="h4 mb-6 bb-dashed pb-4 text-xl">Basic Information</h4>
                        
                        <div class="mb-5">
                            <label class="mb-2 block font-bold text-[#1F2937]">Product Name <span class="text-[#EF4444]">*</span></label>
                            <input type="text" name="name" placeholder="e.g., Nike Air Force 1 '07" required value="{{ old('name') }}" class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-medium text-[#1F2937]">
                        </div>

                        <div class="mb-5">
                            <label class="mb-2 block font-bold text-[#1F2937]">Description</label>
                            <textarea name="description" rows="4" placeholder="Describe the condition, size, and details..." class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-medium text-[#1F2937]">{{ old('description') }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="mb-2 block font-bold text-[#1F2937]">Price (₦) <span class="text-[#EF4444]">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-[#64748B]">₦</span>
                                    <input type="number" name="price" placeholder="0.00" required step="0.01" value="{{ old('price') }}" class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] pl-10 pr-4 py-3 text-sm outline-none transition-all font-medium text-[#1F2937]">
                                </div>
                            </div>
                            <div>
                                <label class="mb-2 block font-bold text-[#1F2937]">Stock Quantity</label>
                                <input type="number" name="stock" placeholder="1" value="{{ old('stock', 1) }}" class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-medium text-[#1F2937]">
                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <h4 class="h4 mb-6 bb-dashed pb-4 text-xl">Product Settings</h4>
                        
                        <div class="grid grid-cols-2 gap-5 mb-2">
                            <div>
                                <label class="mb-2 block font-bold text-[#1F2937]">Category <span class="text-[#EF4444]">*</span></label>
                                <select name="category" class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-medium text-[#1F2937] cursor-pointer">
                                    <option value="" disabled selected>Select a category...</option>
                                    <option value="fashion" {{ old('category') == 'fashion' ? 'selected' : '' }}>👗 Clothing & Fashion</option>
                                    <option value="electronics" {{ old('category') == 'electronics' ? 'selected' : '' }}>📱 Electronics</option>
                                    <option value="beauty" {{ old('category') == 'beauty' ? 'selected' : '' }}>💄 Health & Beauty</option>
                                    <option value="home" {{ old('category') == 'home' ? 'selected' : '' }}>🛋️ Home & Furniture</option>
                                    <option value="services" {{ old('category') == 'services' ? 'selected' : '' }}>💻 Digital Services</option>
                                    <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>🛍️ Other Items</option>
                                </select>
                            </div>
                            <div>
                                <label class="mb-2 block font-bold text-[#1F2937]">Publish Status</label>
                                <select name="is_active" class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-medium text-[#1F2937] cursor-pointer">
                                    <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>🟢 Active (Visible to buyers)</option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>⚪ Draft (Hidden from store)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-4">
                    <div class="box mb-6">
                        <h4 class="h4 mb-6 bb-dashed pb-4 text-xl">Product Images</h4>
                        
                        <div class="flex gap-2 mb-4 p-1 bg-[#F8FAFC] border border-[#D1D5DB] rounded-lg">
                            <button type="button" onclick="switchMode('file')" id="btn-file" class="flex-1 py-2 rounded-md bg-[#0878F8] text-white font-bold text-sm transition-all shadow-sm">Upload File</button>
                            <button type="button" onclick="switchMode('url')" id="btn-url" class="flex-1 py-2 rounded-md bg-transparent text-[#64748B] font-bold text-sm transition-all hover:text-[#0878F8]">Image URLs</button>
                        </div>

                        <div id="mode-file">
                            <label class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-[#D1D5DB] bg-[#F8FAFC] p-8 text-center transition-all hover:border-[#0878F8] hover:bg-[#0878F8]/5 cursor-pointer group">
                                <i class="las la-cloud-upload-alt text-5xl text-[#94A3B8] mb-3 group-hover:text-[#0878F8] transition-colors"></i>
                                <p id="file-name-display" class="font-bold text-[#1F2937] group-hover:text-[#0878F8] transition-colors">Click to upload files</p>
                                <p class="text-xs text-[#64748B] mt-2 leading-relaxed">Select up to 3 images<br>(Max 2MB. JPG, PNG, WEBP, GIF, SVG, BMP)</p>
                                
                                <input type="file" name="image[]" multiple accept="image/*" class="hidden" 
                                    onchange="document.getElementById('file-name-display').innerText = this.files.length > 1 ? this.files.length + ' images selected' : (this.files[0] ? this.files[0].name : 'Click to upload files'); document.getElementById('file-name-display').classList.add('text-[#0878F8]');">
                            </label>
                        </div>

                        <div id="mode-url" class="hidden">
                            <label class="mb-2 block font-bold text-[#1F2937] text-sm">Paste Image Links</label>
                            <textarea name="image_urls" rows="4" placeholder="https://example.com/shoe-front.jpg&#10;https://example.com/shoe-side.jpg" class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-medium text-[#1F2937] leading-relaxed"></textarea>
                            <p class="text-xs text-[#64748B] mt-2 leading-relaxed"><i class="las la-info-circle text-[#0878F8]"></i> Paste up to 3 direct image URLs. Separate each link by pressing Enter.</p>
                        </div>

                    </div>

                    <div class="box">
                        <h4 class="h4 mb-4 bb-dashed pb-4 text-xl">Publish</h4>
                        <p class="text-sm text-[#64748B] mb-6 leading-relaxed">Once published, this item will be instantly available in your digital catalog.</p>
                        
                        <button type="submit" id="submit-btn" class="btn-q4i-primary w-full flex items-center justify-center gap-2 py-3.5 rounded-xl font-bold text-lg">
                            <i class="las la-check-circle text-xl"></i> Create Product
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function switchMode(mode) {
            const btnFile = document.getElementById('btn-file');
            const btnUrl = document.getElementById('btn-url');
            const viewFile = document.getElementById('mode-file');
            const viewUrl = document.getElementById('mode-url');

            // Reset buttons
            btnFile.className = "flex-1 py-2 rounded-md bg-transparent text-[#64748B] font-bold text-sm transition-all hover:text-[#0878F8]";
            btnUrl.className = "flex-1 py-2 rounded-md bg-transparent text-[#64748B] font-bold text-sm transition-all hover:text-[#0878F8]";
            viewFile.classList.add('hidden');
            viewUrl.classList.add('hidden');

            if(mode === 'file') {
                btnFile.className = "flex-1 py-2 rounded-md bg-[#0878F8] text-white font-bold text-sm transition-all shadow-sm";
                viewFile.classList.remove('hidden');
            } else {
                btnUrl.className = "flex-1 py-2 rounded-md bg-[#0878F8] text-white font-bold text-sm transition-all shadow-sm";
                viewUrl.classList.remove('hidden');
            }
        }
    </script>
@endsection