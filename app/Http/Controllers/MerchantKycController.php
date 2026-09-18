<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MerchantKyc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Added for secure file deletion

class MerchantKycController extends Controller
{
    // 1. Show the KYC Form & Badges
    public function create()
    {
        $merchant = \App\Models\Merchant::current();

        // Fetch the record so the UI knows to show the "Pending" or "Approved" badge
        $kycRecord = MerchantKyc::where('user_id', $merchant->id)->first();

        // Return our new UI view
        return view('merchant.kyc.verify', compact('merchant', 'kycRecord')); 
    }

    // 2. Process the Uploads
    public function store(Request $request)
    {
        $merchant = \App\Models\Merchant::current();

        // 🟢 PRE-CHECK: Prevent Duplicate Submissions
        $existingKyc = MerchantKyc::where('user_id', $merchant->id)->first();

        if ($existingKyc) {
            if ($existingKyc->status === 'approved') {
                return redirect()->back()->withErrors(['error' => 'Your corporate KYC is already approved. You cannot submit it again.']);
            }
            if ($existingKyc->status === 'pending') {
                return redirect()->back()->withErrors(['error' => 'Your application is currently under review by compliance. Please wait for an update.']);
            }
        }

        // 1. Validate the form and the files (Max 5MB per file)
        $request->validate([
            'business_type'       => 'required|string',
            'registration_number' => 'required|string',
            'tax_id'              => 'required|string',
            'industrial_sector'   => 'required|string',
            'business_address'    => 'required|string',
            
            'rep_first_name'      => 'required|string',
            'rep_last_name'       => 'required|string',
            'rep_bvn'             => 'required|digits:11',
            'rep_nin'             => 'required|digits:11',
            'rep_dob'             => 'required|date',
            
            'cac_certificate'     => 'required|file|mimes:pdf,jpg,png|max:5120',
            'utility_bill'        => 'required|file|mimes:pdf,jpg,png|max:5120',
            'rep_id_card'         => 'required|file|mimes:pdf,jpg,png|max:5120',
        ]);

        // 2. Prepare the KYC record (Update if Rejected, Create if New)
        // 🟢 FIXED: If they were rejected, we overwrite their old row. If new, we create one.
        $kyc = $existingKyc ?? new MerchantKyc();
        
        $kyc->user_id = $merchant->id;
        $kyc->business_name = $merchant->business_name ?? 'Corporate Gateway'; 
        
        $kyc->business_type = $request->business_type;
        $kyc->registration_number = $request->registration_number;
        $kyc->tax_id = $request->tax_id;
        $kyc->industrial_sector = $request->industrial_sector;
        $kyc->business_address = $request->business_address;
        
        $kyc->rep_first_name = $request->rep_first_name;
        $kyc->rep_last_name = $request->rep_last_name;
        $kyc->rep_bvn = $request->rep_bvn;
        $kyc->rep_nin = $request->rep_nin;
        $kyc->rep_dob = $request->rep_dob;
        
        // Reset status back to pending so the Admin sees it in the queue again
        $kyc->status = 'pending';

        // 3. Securely handle file uploads & delete old files if resubmitting
        if ($request->hasFile('cac_certificate')) {
            if ($kyc->cac_certificate_path) Storage::disk('public')->delete($kyc->cac_certificate_path);
            $kyc->cac_certificate_path = $request->file('cac_certificate')->store('kyc_documents', 'public');
        }
        if ($request->hasFile('utility_bill')) {
            if ($kyc->utility_bill_path) Storage::disk('public')->delete($kyc->utility_bill_path);
            $kyc->utility_bill_path = $request->file('utility_bill')->store('kyc_documents', 'public');
        }
        if ($request->hasFile('rep_id_card')) {
            if ($kyc->rep_id_card_path) Storage::disk('public')->delete($kyc->rep_id_card_path);
            $kyc->rep_id_card_path = $request->file('rep_id_card')->store('kyc_documents', 'public');
        }

        $kyc->save();

        return redirect()->route('merchant.kyc.verify')->with('success', 'Corporate Verification submitted successfully! Our compliance team will review your application shortly.');
    }
}