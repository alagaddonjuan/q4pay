@extends('layout.merchant')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-[#003366]">Compliance & KYC</h2>
        <p class="text-sm text-slate-500 mt-1">Verify your corporate identity to unlock full platform features.</p>
    </div>
</div>

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
            <p class="text-sm font-bold">Oops! Please check the following errors:</p>
        </div>
        <ul class="list-disc list-inside text-sm text-red-600 ml-8">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1 space-y-6">
        <div class="box bg-white rounded-2xl shadow-sm border border-slate-200 p-8 flex flex-col items-center text-center">
            
            @if(($kyc && $kyc->status === 'approved') || \App\Models\Merchant::current()->kyc_status === 'approved')
                <div class="size-20 rounded-full bg-green-50 text-green-500 flex items-center justify-center mb-4">
                    <i class="las la-shield-check text-5xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-1">Fully Verified</h3>
                <p class="text-sm text-slate-500 mb-4">Your corporate account is unrestricted.</p>
                <span class="bg-green-100 text-green-700 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">Approved</span>
            
            @elseif(($kyc && $kyc->status === 'rejected') || \App\Models\Merchant::current()->kyc_status === 'rejected')
                <div class="size-20 rounded-full bg-red-50 text-red-500 flex items-center justify-center mb-4">
                    <i class="las la-times-circle text-5xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-1">Action Required</h3>
                <p class="text-sm text-slate-500 mb-4">Your submission was rejected.</p>
                <span class="bg-red-100 text-red-700 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-4">Rejected</span>
                <div class="bg-red-50 border border-red-100 p-3 rounded-lg text-xs text-red-600 text-left w-full">
                    <strong>Reason:</strong> {{ $kyc->rejection_reason ?? 'Please re-upload clearer documents.' }}
                </div>
                
            @elseif(($kyc && $kyc->status === 'pending') || \App\Models\Merchant::current()->kyc_status === 'pending')
                <div class="size-20 rounded-full bg-yellow-50 text-yellow-600 flex items-center justify-center mb-4">
                    <i class="las la-clock text-5xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-1">Under Review</h3>
                <p class="text-sm text-slate-500 mb-4">Our team is verifying your documents.</p>
                <span class="bg-yellow-100 text-yellow-700 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">Reviewing</span>
            
            @else
                <div class="size-20 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center mb-4">
                    <i class="las la-file-upload text-5xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-1">Not Submitted</h3>
                <p class="text-sm text-slate-500 mb-4">Please submit your corporate details.</p>
                <span class="bg-slate-100 text-slate-600 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">Incomplete</span>
            @endif

            <div class="w-full mt-8 border-t border-slate-100 pt-6 text-left">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Verification Checklist</p>
                <ul class="space-y-3 text-sm font-medium">
                    <li class="flex items-center gap-2 {{ ($kyc && $kyc->registration_number) ? 'text-green-600' : 'text-slate-400' }}">
                        <i class="las {{ ($kyc && $kyc->registration_number) ? 'la-check-circle' : 'la-circle' }} text-lg"></i> Company & Tax Info
                    </li>
                    <li class="flex items-center gap-2 {{ ($kyc && $kyc->rep_bvn) ? 'text-green-600' : 'text-slate-400' }}">
                        <i class="las {{ ($kyc && $kyc->rep_bvn) ? 'la-check-circle' : 'la-circle' }} text-lg"></i> Director Identity
                    </li>
                    <li class="flex items-center gap-2 {{ ($kyc && $kyc->cac_certificate_path) ? 'text-green-600' : 'text-slate-400' }}">
                        <i class="las {{ ($kyc && $kyc->cac_certificate_path) ? 'la-check-circle' : 'la-circle' }} text-lg"></i> CAC Certificate
                    </li>
                    <li class="flex items-center gap-2 {{ ($kyc && $kyc->utility_bill_path) ? 'text-green-600' : 'text-slate-400' }}">
                        <i class="las {{ ($kyc && $kyc->utility_bill_path) ? 'la-check-circle' : 'la-circle' }} text-lg"></i> Utility Bill
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="box bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50">
                <h3 class="text-lg font-bold text-[#003366]">Submission Form</h3>
            </div>
            
            <form action="{{ url('/merchant/compliance') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i class="las la-building text-lg"></i> Business Information
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-[#003366] mb-2">Registered Business Name</label>
                        <input type="text" name="business_name" 
                            value="{{ old('business_name', $kyc->business_name ?? \App\Models\Merchant::current()->business_name) }}" 
                            required 
                            class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none" 
                            {{ (($kyc && $kyc->status === 'approved') || \App\Models\Merchant::current()->kyc_status === 'approved') ? 'readonly' : '' }}>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Business Type</label>
                        <select name="business_type" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none" {{ (($kyc && $kyc->status === 'approved') || \App\Models\Merchant::current()->kyc_status === 'approved') ? 'disabled' : '' }}>
                            <option value="">Select Type...</option>
                            <option value="Private Limited Company (LTD)" {{ (old('business_type', $kyc->business_type ?? '') == 'Private Limited Company (LTD)') ? 'selected' : '' }}>Private Limited Company (LTD)</option>
                            <option value="Business Name (BN)" {{ (old('business_type', $kyc->business_type ?? '') == 'Business Name (BN)') ? 'selected' : '' }}>Business Name (BN)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Registration Number (RC/BN)</label>
                        <input type="text" name="registration_number" value="{{ old('registration_number', $kyc->registration_number ?? '') }}" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none" {{ (($kyc && $kyc->status === 'approved') || \App\Models\Merchant::current()->kyc_status === 'approved') ? 'readonly' : '' }}>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Tax Identification Number (TIN)</label>
                        <input type="text" name="tax_id" value="{{ old('tax_id', $kyc->tax_id ?? '') }}" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none" {{ (($kyc && $kyc->status === 'approved') || \App\Models\Merchant::current()->kyc_status === 'approved') ? 'readonly' : '' }}>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Industrial Sector</label>
                        <input type="text" name="industrial_sector" value="{{ old('industrial_sector', $kyc->industrial_sector ?? '') }}" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none" {{ (($kyc && $kyc->status === 'approved') || \App\Models\Merchant::current()->kyc_status === 'approved') ? 'readonly' : '' }}>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-[#003366] mb-2">Registered Business Address</label>
                        <input type="text" name="business_address" value="{{ old('business_address', $kyc->business_address ?? '') }}" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none" {{ (($kyc && $kyc->status === 'approved') || \App\Models\Merchant::current()->kyc_status === 'approved') ? 'readonly' : '' }}>
                    </div>
                </div>

                <hr class="border-slate-100 my-8">

                <!-- 🟢 FIXED TAILWIND STYLING FOR DIRECTOR SECTION -->
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 mt-8 flex items-center gap-2">
                    <i class="las la-user-tie text-lg"></i> Primary Representative / Director
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">First Name</label>
                        <input type="text" name="rep_first_name" value="{{ old('rep_first_name', $kyc->rep_first_name ?? '') }}" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none" {{ (($kyc && $kyc->status === 'approved') || \App\Models\Merchant::current()->kyc_status === 'approved') ? 'readonly' : '' }}>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Last Name</label>
                        <input type="text" name="rep_last_name" value="{{ old('rep_last_name', $kyc->rep_last_name ?? '') }}" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none" {{ (($kyc && $kyc->status === 'approved') || \App\Models\Merchant::current()->kyc_status === 'approved') ? 'readonly' : '' }}>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Middle Name <span class="text-slate-400 font-normal">(As on BVN)</span></label>
                        <input type="text" name="rep_other_names" value="{{ old('rep_other_names', $kyc->rep_other_names ?? '') }}" placeholder="Leave blank if none" class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none" {{ (($kyc && $kyc->status === 'approved') || \App\Models\Merchant::current()->kyc_status === 'approved') ? 'readonly' : '' }}>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Gender</label>
                        <select name="rep_gender" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none" {{ (($kyc && $kyc->status === 'approved') || \App\Models\Merchant::current()->kyc_status === 'approved') ? 'disabled' : '' }}>
                            <option value="" disabled selected>Select Gender...</option>
                            <option value="0" {{ (old('rep_gender', $kyc->rep_gender ?? '') == '0') ? 'selected' : '' }}>Male</option>
                            <option value="1" {{ (old('rep_gender', $kyc->rep_gender ?? '') == '1') ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Phone Number <span class="text-slate-400 font-normal">(Linked to BVN)</span></label>
                        <input type="text" name="rep_phone" value="{{ old('rep_phone', $kyc->rep_phone ?? '') }}" placeholder="e.g. 08012345678" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none" {{ (($kyc && $kyc->status === 'approved') || \App\Models\Merchant::current()->kyc_status === 'approved') ? 'readonly' : '' }}>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">BVN <span class="text-slate-400 font-normal">(11 Digits)</span></label>
                        <input type="text" name="rep_bvn" value="{{ old('rep_bvn', $kyc->rep_bvn ?? '') }}" maxlength="11" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none" {{ (($kyc && $kyc->status === 'approved') || \App\Models\Merchant::current()->kyc_status === 'approved') ? 'readonly' : '' }}>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">NIN <span class="text-slate-400 font-normal">(11 Digits)</span></label>
                        <input type="text" name="rep_nin" value="{{ old('rep_nin', $kyc->rep_nin ?? '') }}" maxlength="11" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none" {{ (($kyc && $kyc->status === 'approved') || \App\Models\Merchant::current()->kyc_status === 'approved') ? 'readonly' : '' }}>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#003366] mb-2">Date of Birth</label>
                        <input type="date" name="rep_dob" value="{{ old('rep_dob', $kyc->rep_dob ?? '') }}" required class="w-full text-sm bg-white border border-slate-200 rounded-lg px-4 py-3 focus:border-[#003366] outline-none" {{ (($kyc && $kyc->status === 'approved') || \App\Models\Merchant::current()->kyc_status === 'approved') ? 'readonly' : '' }}>
                    </div>
                </div>
                <!-- END OF FIXED SECTION -->

                <hr class="border-slate-100 my-8">

                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    <i class="las la-file-upload text-lg"></i> Document Uploads
                </h4>

                <div class="grid grid-cols-1 gap-5 mb-8">
                    <div class="p-4 border border-slate-200 rounded-xl bg-slate-50 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-[#003366]">CAC Certificate</p>
                            <p class="text-xs text-slate-500">PDF, JPG, or PNG (Max 5MB)</p>
                        </div>
                        @if($kyc && $kyc->cac_certificate_path)
                            <span class="text-xs font-bold text-green-600 bg-green-100 px-3 py-1 rounded">Uploaded</span>
                        @endif
                        @if((!$kyc || ($kyc->status !== 'approved' && \App\Models\Merchant::current()->kyc_status !== 'approved')))
                            <input type="file" name="cac_certificate" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#003366] file:text-white hover:file:bg-blue-900 cursor-pointer">
                        @endif
                    </div>
                    
                    <div class="p-4 border border-slate-200 rounded-xl bg-slate-50 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-[#003366]">Recent Utility Bill</p>
                            <p class="text-xs text-slate-500">Less than 3 months old</p>
                        </div>
                        @if($kyc && $kyc->utility_bill_path)
                            <span class="text-xs font-bold text-green-600 bg-green-100 px-3 py-1 rounded">Uploaded</span>
                        @endif
                        @if((!$kyc || ($kyc->status !== 'approved' && \App\Models\Merchant::current()->kyc_status !== 'approved')))
                            <input type="file" name="utility_bill" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#003366] file:text-white hover:file:bg-blue-900 cursor-pointer">
                        @endif
                    </div>

                    <div class="p-4 border border-slate-200 rounded-xl bg-slate-50 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-[#003366]">Director's ID Card</p>
                            <p class="text-xs text-slate-500">National ID, Passport, or Driver's License</p>
                        </div>
                        @if($kyc && $kyc->rep_id_card_path)
                            <span class="text-xs font-bold text-green-600 bg-green-100 px-3 py-1 rounded">Uploaded</span>
                        @endif
                        @if((!$kyc || ($kyc->status !== 'approved' && \App\Models\Merchant::current()->kyc_status !== 'approved')))
                            <input type="file" name="rep_id_card" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#003366] file:text-white hover:file:bg-blue-900 cursor-pointer">
                        @endif
                    </div>
                </div>

                @if((!$kyc || ($kyc->status !== 'approved' && \App\Models\Merchant::current()->kyc_status !== 'approved')))
                <div class="flex justify-end pt-6 border-t border-slate-100">
                    <button type="submit" class="flex items-center gap-2 px-8 py-3 rounded-lg font-bold text-white transition-all shadow-md hover:bg-red-700" style="background-color: #D20103;">
                        <i class="las la-paper-plane text-xl"></i> Submit Documents
                    </button>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection