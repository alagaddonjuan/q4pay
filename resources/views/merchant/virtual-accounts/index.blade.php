@extends('layout.merchant')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-[#003366]">Virtual Accounts</h2>
        <p class="text-sm text-slate-500 mt-1">Manage static and dynamic collection accounts.</p>
    </div>
    
    <div class="flex flex-wrap items-center gap-3">
        <button onclick="openModal('bulk')" class="flex items-center gap-2 rounded-lg border px-5 py-2.5 font-bold shadow-sm transition-all hover:bg-slate-50" style="border-color: #003366; color: #003366;">
            <i class="las la-cloud-upload-alt text-xl"></i>
            <span>Bulk Import</span>
        </button>

        <button onclick="openModal('single')" class="flex items-center gap-2 rounded-lg px-5 py-2.5 font-bold shadow-sm transition-all hover:-translate-y-1 hover:shadow-md" style="background-color: #D20103; color: white;">
            <i class="las la-plus-circle text-xl"></i> 
            <span>Generate Single</span>
        </button>
    </div>
</div>
<!-- ========================================== -->
<!-- ERROR BANNER -->
<!-- ========================================== -->
@if($errors->any())
<div class="mb-6 rounded-xl bg-red-50 p-4 border border-red-200 shadow-sm transition-all">
    <div class="flex items-start gap-3">
        <div class="flex size-8 items-center justify-center rounded-full bg-red-100 shrink-0">
            <i class="las la-exclamation-circle text-red-600 text-xl"></i>
        </div>
        <div>
            <p class="text-sm text-red-700 font-bold mb-1">Account Provisioning Failed:</p>
            <ul class="list-disc list-inside text-xs text-red-600 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif
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

@if($accounts->isEmpty())
    <div class="box bg-white p-6 rounded-xl shadow-sm" style="border-top: 4px solid #003366;">
        <div class="flex flex-col items-center justify-center py-12">
            <div class="flex size-20 items-center justify-center rounded-full bg-slate-50 mb-4">
                <i class="las la-university text-4xl text-slate-400"></i>
            </div>
            <h4 class="text-lg font-bold text-[#003366] mb-1">No Virtual Accounts Found</h4>
            <p class="text-slate-500 text-center max-w-md">You haven't provisioned any sub-agent accounts yet. Use the buttons above to generate your collection accounts.</p>
        </div>
    </div>
@else
    <div class="box bg-white rounded-xl shadow-sm overflow-hidden" style="border-top: 4px solid #003366;">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-800">
                    <tr>
                        <th class="px-6 py-4 font-bold">Account Owner</th>
                        <th class="px-6 py-4 font-bold">Account Details</th>
                        <th class="px-6 py-4 font-bold">Ledger Balance</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                        <th class="px-6 py-4 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($accounts as $acc)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <p class="font-bold text-[#003366]">
                                {{ $acc->first_name }} {{ $acc->last_name }}
                                @if(isset($acc->merchant_reference) && strpos($acc->merchant_reference, 'MASTER_AGENT') !== false)
                                    <span class="ml-2 inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">Corporate Master</span>
                                @endif
                            </p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $acc->phone_number }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-bold text-slate-800">{{ $acc->account_number }}</span>
                                <button class="text-slate-400 hover:text-[#003366] transition-colors" title="Copy Account Number" onclick="navigator.clipboard.writeText('{{ $acc->account_number }}'); alert('Account number copied!')">
                                    <i class="las la-copy text-lg"></i>
                                </button>
                            </div>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $acc->bank_name }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-800">₦{{ number_format($acc->ledger_balance, 2) }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($acc->is_active)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-xs font-bold text-green-600 border border-green-100">
                                    <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span> Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-bold text-red-600 border border-red-100">
                                    <span class="h-1.5 w-1.5 rounded-full bg-red-600"></span> Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ url('/merchant/virtual-accounts/' . $acc->id . '/details') }}" class="inline-flex items-center gap-1 text-sm font-bold text-[#003366] hover:text-[#D20103] transition-colors bg-slate-50 hover:bg-red-50 px-3 py-1.5 rounded-lg border border-slate-200">
                                View Profile <i class="las la-angle-right"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

<div id="generate-modal" class="fixed inset-0 z-[100] items-center justify-center bg-slate-900/60 backdrop-blur-sm transition-opacity" style="display: none;">
    <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl overflow-hidden transform transition-all">
        
        <div class="flex items-center justify-between bg-slate-50 px-6 py-4 border-b border-slate-100">
            <h3 class="text-lg font-bold text-[#003366]" id="modal-title">Provision Sub-Agent Account</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-[#D20103] transition-colors">
                <i class="las la-times text-2xl"></i>
            </button>
        </div>

        <form id="form-single" action="{{ route('merchant.virtual-accounts.store-single') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="col-span-2">
                    <label class="mb-2 block text-sm font-bold text-[#003366]">Sub-Agent / Branch Name <span class="text-[#D20103]">*</span></label>
                    <input type="text" name="agent_name" required placeholder="e.g. Lagos Island Branch or Rider 001" class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm focus:border-[#003366] focus:ring-1 focus:ring-[#003366] outline-none transition-all">
                </div>
                
                <div>
                    <label class="mb-2 block text-sm font-bold text-[#003366]">Contact Email <span class="text-[#D20103]">*</span></label>
                    <input type="email" name="email" required placeholder="agent@company.com" class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm focus:border-[#003366] focus:ring-1 focus:ring-[#003366] outline-none transition-all">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-[#003366]">Phone Number <span class="text-[#D20103]">*</span></label>
                    <input type="text" name="phone" required placeholder="08012345678" class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm focus:border-[#003366] focus:ring-1 focus:ring-[#003366] outline-none transition-all">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-bold text-[#003366]">Date of Birth <span class="text-[#D20103]">*</span></label>
                    <input type="date" name="dob" required class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm focus:border-[#003366] focus:ring-1 focus:ring-[#003366] outline-none transition-all text-slate-600">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-[#003366]">BVN <span class="text-[#D20103]">*</span></label>
                    <input type="text" name="bvn" required maxlength="11" placeholder="11-digit BVN" class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm focus:border-[#003366] focus:ring-1 focus:ring-[#003366] outline-none transition-all">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-bold text-[#003366]">NIN <span class="text-[#D20103]">*</span></label>
                    <input type="text" name="nin" required maxlength="11" placeholder="11-digit NIN" class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm focus:border-[#003366] focus:ring-1 focus:ring-[#003366] outline-none transition-all">
                </div>
            </div>

            <div class="mb-6 rounded-lg bg-blue-50 p-4 border border-blue-100">
                <div class="flex items-start gap-3">
                    <i class="las la-shield-alt text-[#003366] text-xl mt-0.5"></i>
                    <p class="text-xs text-[#003366] leading-relaxed font-medium">
                        CBN regulations require BVN and NIN validation for all permanent static virtual accounts. By proceeding, you confirm consent has been acquired from the assigned sub-agent.
                    </p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal()" class="rounded-lg px-5 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-100 transition-colors">Cancel</button>
                <button type="submit" class="flex items-center gap-2 rounded-lg px-6 py-2.5 text-sm font-bold shadow-sm transition-all hover:-translate-y-0.5" style="background-color: #003366; color: white;">
                    <i class="las la-server"></i> Generate Account
                </button>
            </div>
        </form>

        <form id="form-bulk" action="{{ route('merchant.virtual-accounts.store-bulk') }}" method="POST" enctype="multipart/form-data" class="p-6 hidden">
            @csrf
            
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-sm font-bold text-[#003366]">Upload CSV File</label>
                    <a href="{{ route('merchant.virtual-accounts.template') }}" class="text-xs font-bold text-[#D20103] hover:underline flex items-center gap-1">
                        <i class="las la-download"></i> Download Template
                    </a>
                </div>
                
                <div id="dropzone" class="mt-2 flex justify-center rounded-xl border-2 border-dashed border-slate-300 bg-white px-6 py-10 hover:bg-slate-50 transition-all cursor-pointer" onclick="document.getElementById('file-upload').click()">
                    <div class="text-center">
                        <i id="upload-icon" class="las la-file-csv text-5xl text-slate-400 mb-2 transition-colors"></i>
                        <div class="mt-2 flex text-sm leading-6 text-slate-600 justify-center">
                            <label for="file-upload" class="relative cursor-pointer rounded-md bg-transparent font-semibold text-[#003366] focus-within:outline-none hover:text-[#D20103]" onclick="event.stopPropagation()">
                                <span>Upload a file</span>
                                <input id="file-upload" name="file-upload" type="file" class="sr-only" accept=".csv, .xlsx">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p id="file-name-display" class="text-xs text-slate-500 mt-1 transition-all">CSV or Excel up to 5MB</p>
                    </div>
                </div>
            </div>

            <div class="mb-6 rounded-lg bg-yellow-50 p-4 border border-yellow-100">
                <div class="flex items-start gap-3">
                    <i class="las la-exclamation-triangle text-yellow-700 text-xl mt-0.5"></i>
                    <p class="text-xs text-yellow-700 leading-relaxed font-medium">
                        Ensure your file strictly follows the downloadable template structure (Name, Email, Phone, BVN, NIN). Invalid rows will be skipped during processing.
                    </p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal()" class="rounded-lg px-5 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-100 transition-colors">Cancel</button>
                <button type="submit" class="flex items-center gap-2 rounded-lg px-6 py-2.5 text-sm font-bold shadow-sm transition-all hover:-translate-y-0.5" style="background-color: #003366; color: white;">
                    <i class="las la-cogs"></i> Process Batch
                </button>
            </div>
        </form>

    </div>
</div>

@push('page-js')
<script>
    const modal = document.getElementById('generate-modal');
    const singleForm = document.getElementById('form-single');
    const bulkForm = document.getElementById('form-bulk');
    const modalTitle = document.getElementById('modal-title');

    function openModal(type) {
        modal.style.display = 'flex';
        
        if(type === 'bulk') {
            singleForm.classList.add('hidden');
            bulkForm.classList.remove('hidden');
            modalTitle.innerText = "Bulk Provision Accounts (CSV)";
        } else {
            bulkForm.classList.add('hidden');
            singleForm.classList.remove('hidden');
            modalTitle.innerText = "Provision Sub-Agent Account";
        }
    }

    function closeModal() {
        modal.style.display = 'none';
    }

    // ==========================================
    // BULK UPLOAD DROPZONE LOGIC
    // ==========================================
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('file-upload');
    const fileNameDisplay = document.getElementById('file-name-display');
    const uploadIcon = document.getElementById('upload-icon');

    // 1. Handle standard click & select
    fileInput.addEventListener('change', function(e) {
        handleFiles(this.files);
    });

    // 2. Prevent default browser drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // 3. Highlight dropzone on drag over
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropzone.classList.remove('border-slate-300', 'bg-white');
        dropzone.classList.add('border-[#003366]', 'bg-blue-50');
    }

    function unhighlight(e) {
        dropzone.classList.remove('border-[#003366]', 'bg-blue-50');
        dropzone.classList.add('border-slate-300', 'bg-white');
    }

    // 4. Handle the actual drop
    dropzone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        // Transfer the dropped files into the hidden HTML input so the form can submit them
        fileInput.files = files;
        
        handleFiles(files);
    }

    // 5. Update UI with file name
    function handleFiles(files) {
        if (files.length > 0) {
            const file = files[0];
            // Turn the text green and show the file name
            fileNameDisplay.innerHTML = `<span class="text-green-600 font-bold text-sm"><i class="las la-check-circle"></i> ${file.name} ready!</span>`;
            
            // Change the icon to look active
            uploadIcon.classList.remove('text-slate-400');
            uploadIcon.classList.add('text-[#003366]');
        }
    }
</script>
@endpush
@endsection