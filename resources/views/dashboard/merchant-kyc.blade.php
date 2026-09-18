@extends('layout.main')

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h2 class="h2">Corporate Verification</h2>
            <span class="btn-outline text-amber-600 border-amber-600 cursor-default">
                <i class="las la-exclamation-triangle text-base md:text-lg"></i>
                Status: Pending KYC
            </span>
        </div>

        <div class="box xxl:p-8 3xl:p-10 mb-6 bg-amber-50/50 border border-amber-200">
            <h4 class="h4 text-amber-800 mb-2">Action Required</h4>
            <p class="text-amber-700">Before you can generate Virtual Accounts or use the Q4I Payment Gateway API, you must complete your Corporate KYC verification. Please upload the required documents below.</p>
        </div>

        <form action="{{ route('merchant.kyc.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-12 gap-4 xx3xl:gap-6">
                <div class="col-span-12 lg:col-span-6">
                    <div class="box xxl:p-8 3xl:p-10 h-full">
                        <h4 class="h4 bb-dashed mb-4 pb-4 md:mb-6 md:pb-6">
                            1. Business Information
                        </h4>
                        
                        <div class="grid grid-cols-2 gap-4 xx3xl:gap-6 mt-6 xl:mt-8">
                            <div class="col-span-2">
                                <label for="business_type" class="md:text-lg font-medium block mb-4">Business Entity Type</label>
                                <select name="business_type" class="w-full text-sm bg-primary/5 border border-n30 rounded-3xl px-3 md:px-6 py-2 md:py-3 focus:outline-none focus:border-primary" required>
                                    <option value="LIMITED_LIABILITY_COMPANY">Limited Liability Company (LLC)</option>
                                    <option value="PARTNERSHIP">Partnership</option>
                                    <option value="SOLE_PROPRIETORSHIP">Sole Proprietorship</option>
                                    <option value="NGO">NGO / Non-Profit</option>
                                </select>
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="registration_number" class="md:text-lg font-medium block mb-4">CAC Reg Number</label>
                                <input type="text" name="registration_number" class="w-full text-sm bg-primary/5 border border-n30 rounded-3xl px-3 md:px-6 py-2 md:py-3 focus:outline-none focus:border-primary" placeholder="e.g. RC123456" required />
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="tax_id" class="md:text-lg font-medium block mb-4">Tax ID Number (TIN)</label>
                                <input type="text" name="tax_id" class="w-full text-sm bg-primary/5 border border-n30 rounded-3xl px-3 md:px-6 py-2 md:py-3 focus:outline-none focus:border-primary" placeholder="Enter TIN" required />
                            </div>

                            <div class="col-span-2">
                                <label for="industrial_sector" class="md:text-lg font-medium block mb-4">Industrial Sector</label>
                                <select name="industrial_sector" class="w-full text-sm bg-primary/5 border border-n30 rounded-3xl px-3 md:px-6 py-2 md:py-3 focus:outline-none focus:border-primary" required>
                                    <option value="FINANCE">Finance & Fintech</option>
                                    <option value="TECHNOLOGY">Technology</option>
                                    <option value="RETAIL">Retail & Commerce</option>
                                    <option value="MANUFACTURING">Manufacturing</option>
                                    <option value="OTHER">Other</option>
                                </select>
                            </div>

                            <div class="col-span-2">
                                <label for="business_address" class="md:text-lg font-medium block mb-4">Full Corporate Address</label>
                                <textarea name="business_address" rows="3" class="w-full text-sm bg-primary/5 border border-n30 rounded-xl px-3 md:px-6 py-2 md:py-3 focus:outline-none focus:border-primary" placeholder="Registered office address..." required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-6">
                    <div class="box xxl:p-8 3xl:p-10 mb-6">
                        <h4 class="h4 bb-dashed mb-4 pb-4 md:mb-6 md:pb-6">2. Director Details</h4>
                        
                        <div class="grid grid-cols-2 gap-4 3xl:gap-6 mt-6 xl:mt-8">
                            <div class="col-span-2 md:col-span-1">
                                <label class="md:text-lg font-medium block mb-4">First Name</label>
                                <input type="text" name="rep_first_name" class="w-full text-sm bg-primary/5 border border-n30 rounded-3xl px-3 md:px-6 py-2 md:py-3 focus:outline-none focus:border-primary" placeholder="Director First Name" required />
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="md:text-lg font-medium block mb-4">Last Name</label>
                                <input type="text" name="rep_last_name" class="w-full text-sm bg-primary/5 border border-n30 rounded-3xl px-3 md:px-6 py-2 md:py-3 focus:outline-none focus:border-primary" placeholder="Director Last Name" required />
                            </div>
                            
                            <div class="col-span-2 md:col-span-1">
                                <label class="md:text-lg font-medium block mb-4">BVN</label>
                                <input type="text" name="rep_bvn" maxlength="11" class="w-full text-sm bg-primary/5 border border-n30 rounded-3xl px-3 md:px-6 py-2 md:py-3 focus:outline-none focus:border-primary" placeholder="11 Digit BVN" required />
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="md:text-lg font-medium block mb-4">NIN</label>
                                <input type="text" name="rep_nin" maxlength="11" class="w-full text-sm bg-primary/5 border border-n30 rounded-3xl px-3 md:px-6 py-2 md:py-3 focus:outline-none focus:border-primary" placeholder="11 Digit NIN" required />
                            </div>
                            <div class="col-span-2">
                                <label class="md:text-lg font-medium block mb-4">Date of Birth</label>
                                <input type="date" name="rep_dob" class="w-full text-sm bg-primary/5 border border-n30 rounded-3xl px-3 md:px-6 py-2 md:py-3 focus:outline-none focus:border-primary" required />
                            </div>
                        </div>
                    </div>

                    <div class="box xxl:p-8 3xl:p-10 mb-6">
                        <h4 class="h4 bb-dashed mb-4 pb-4 md:mb-6 md:pb-6">3. Required Documents</h4>
                        <p class="text-sm text-n60 mb-6">Accepted formats: PDF, JPG, PNG. Maximum file size: 5MB.</p>
                        
                        <div class="grid grid-cols-1 gap-6 mt-6 xl:mt-8">
                            <div>
                                <label class="md:text-lg font-medium block mb-2">Corporate Affairs Commission (CAC) Certificate</label>
                                <input type="file" name="cac_certificate" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" required />
                            </div>
                            <div>
                                <label class="md:text-lg font-medium block mb-2">Recent Utility Bill (Proof of Address)</label>
                                <input type="file" name="utility_bill" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" required />
                            </div>
                            <div>
                                <label class="md:text-lg font-medium block mb-2">Valid Government ID (Director)</label>
                                <input type="file" name="rep_id_card" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" required />
                            </div>
                            
                            <div class="flex pt-4 gap-4 justify-end mt-4">
                                <button type="submit" class="btn-primary px-8">Submit Documents for Review</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection