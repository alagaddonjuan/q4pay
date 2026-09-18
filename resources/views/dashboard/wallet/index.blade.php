@extends('layout.vendor')

@section('content')

    <!-- 🟢 Q4I BRAND COLOR OVERRIDES -->
    <style>
        .box { background-color: #FFFFFF !important; border: 1px solid #D1D5DB !important; border-radius: 1rem; padding: 1.5rem; }
        .bb-dashed { border-bottom: 1px dashed #D1D5DB !important; }
        .h2, .h4 { color: #0B3A75 !important; font-weight: 900 !important; }
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
        
        .input-q4i:focus {
            border-color: #0878F8 !important;
            box-shadow: 0 0 0 1px #0878F8 !important;
        }
    </style>

    <div class="main-inner bg-[#F8FAFC] min-h-screen p-4 lg:p-6">
        
        <!-- HEADER -->
         <!-- 🟢 SYSTEM ALERT MESSAGES -->
        @if(session('success'))
            <div class="mb-6 rounded-xl bg-[#108981]/10 p-4 border border-[#108981]/30 text-[#108981] font-bold flex items-center gap-3">
                <i class="las la-check-circle text-2xl"></i> 
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-xl bg-[#EF4444]/10 p-4 border border-[#EF4444]/30 text-[#EF4444] font-bold flex items-center gap-3">
                <i class="las la-exclamation-triangle text-2xl"></i> 
                {{ $errors->first() }}
            </div>
        @endif
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div>
                <h2 class="h2 mb-2 text-3xl font-black">Wallet & Payouts</h2>
                <p class="text-sm text-[#64748B]">Manage your earnings, add bank accounts, and request secure withdrawals.</p>
            </div>
        </div>
        @if(auth()->user()->kyc_status !== 'verified')
            <div class="mb-6 rounded-2xl bg-gradient-to-r from-[#0B3A75] to-[#0878F8] p-6 text-white shadow-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5 relative overflow-hidden">
                <div class="absolute -right-6 -top-6 opacity-10">
                    <i class="las la-fingerprint text-[150px]"></i>
                </div>
                
                <div class="flex items-center gap-4 relative z-10">
                    <div class="flex size-14 shrink-0 items-center justify-center rounded-full bg-white/20 backdrop-blur-md shadow-inner border border-white/10">
                        <i class="las la-user-shield text-3xl"></i>
                    </div>
                    <div>
                        <h4 class="text-xl font-black tracking-wide">Identity Verification Required</h4>
                        <p class="text-sm text-white/80 mt-1 leading-relaxed max-w-xl">To comply with CBN regulations and enable withdrawals, you must verify your identity. Your official name will be permanently locked to this vault.</p>
                    </div>
                </div>
                <button onclick="toggleModal('kycModal')" class="bg-white text-[#0B3A75] font-black py-3 px-8 rounded-xl hover:shadow-xl transition-all hover:-translate-y-1 whitespace-nowrap relative z-10 flex items-center gap-2">
                    Verify Identity <i class="las la-arrow-right text-xl"></i>
                </button>
            </div>
        @endif
        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            
            <!-- LEFT COLUMN: Wallet Card & Linked Banks -->
            <div class="col-span-12 lg:col-span-5 space-y-6">
                
                <!-- Q4I Premium Wallet Card -->
                <div class="relative overflow-hidden rounded-2xl bg-[#0878F8] p-7 text-white shadow-xl shadow-[#0878F8]/30 transition-transform duration-300 hover:-translate-y-1">
                    <!-- Decorative Blurs -->
                    <div class="absolute -right-10 -top-10 size-48 rounded-full bg-white/20 blur-3xl"></div>
                    <div class="absolute -bottom-10 -left-10 size-48 rounded-full bg-[#0B3A75]/40 blur-3xl"></div>
                    <div class="absolute top-6 right-6 opacity-20">
                        <i class="las la-wallet text-6xl"></i>
                    </div>
                    
                    <div class="relative z-10">
                        <p class="mb-1 text-xs font-bold text-white/80 uppercase tracking-widest">Available Balance</p>
                        <h2 class="mb-8 text-4xl font-black tracking-tight">₦{{ number_format($availableBalance ?? 0, 2) }}</h2>
                        
                        <div class="flex items-center gap-3">
                            <button onclick="toggleModal('withdrawModal')" class="flex-1 rounded-xl bg-white px-4 py-3 text-center font-bold text-[#0878F8] transition-all hover:bg-[#F8FAFC] hover:shadow-lg">
                                <i class="las la-hand-holding-usd text-xl mr-1"></i> Withdraw
                            </button>
                            <button onclick="toggleModal('addBankModal')" class="flex-1 rounded-xl bg-[#0B3A75]/40 border border-white/10 px-4 py-3 text-center font-bold text-white backdrop-blur-md transition-all hover:bg-[#0B3A75]/60 hover:border-white/30">
                                <i class="las la-plus-circle text-xl mr-1"></i> Add Bank
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Linked Accounts -->
                <div class="box">
                    <div class="bb-dashed mb-5 flex items-center justify-between pb-4">
                        <h4 class="text-xl font-bold text-[#0B3A75]">Linked Accounts</h4>
                        <button onclick="toggleModal('addBankModal')" class="text-sm font-bold text-[#0878F8] hover:text-[#0B3A75] transition-colors flex items-center gap-1">
                            <i class="las la-plus"></i> Add New
                        </button>
                    </div>
                    
                    <div class="space-y-3">
                        <!-- Primary Bank (Success Theme) -->
                        <div class="flex items-center justify-between rounded-xl border border-[#108981]/30 bg-[#108981]/5 p-4 transition-colors hover:border-[#108981]">
                            <div class="flex items-center gap-3">
                                <div class="flex size-10 items-center justify-center rounded-lg bg-[#108981]/10 text-[#108981]">
                                    <i class="las la-university text-2xl"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-[#1F2937]">Guaranty Trust Bank</p>
                                    <p class="text-xs font-medium text-[#64748B]">**** 5678</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#108981]/10 px-2.5 py-1 text-xs font-bold text-[#108981] ring-1 ring-inset ring-[#108981]/20">
                                <span class="size-1.5 rounded-full bg-[#108981] animate-pulse"></span> Primary
                            </span>
                        </div>

                        <!-- Secondary Bank -->
                        <div class="flex items-center justify-between rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] p-4 transition-colors hover:border-[#0878F8]">
                            <div class="flex items-center gap-3">
                                <div class="flex size-10 items-center justify-center rounded-lg bg-[#0878F8]/10 text-[#0878F8]">
                                    <i class="las la-university text-2xl"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-[#1F2937]">Moniepoint MFB</p>
                                    <p class="text-xs font-medium text-[#64748B]">**** 1234</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Withdrawal History -->
            <div class="col-span-12 lg:col-span-7">
                <div class="box h-full flex flex-col">
                    <div class="bb-dashed mb-4 flex items-center justify-between pb-4">
                        <h4 class="text-xl font-bold text-[#0B3A75]">Withdrawal History</h4>
                        <button class="text-sm font-bold text-[#0878F8] hover:text-[#0B3A75] transition-colors">View All</button>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-[#D1D5DB] flex-1">
                        <table class="w-full whitespace-nowrap text-sm h-full">
                            <thead class="bg-[#F8FAFC] border-b border-[#D1D5DB] text-[#64748B]">
                                <tr>
                                    <th class="px-6 py-4 text-start font-bold uppercase tracking-wider text-xs">Date</th>
                                    <th class="px-6 py-4 text-start font-bold uppercase tracking-wider text-xs">Amount</th>
                                    <th class="px-6 py-4 text-start font-bold uppercase tracking-wider text-xs">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#D1D5DB]">
    @forelse($withdrawals as $withdrawal)
        <tr class="hover:bg-[#F8FAFC] transition-colors">
            <td class="px-6 py-4 text-sm font-bold text-[#1F2937]">
                {{ \Carbon\Carbon::parse($withdrawal->created_at)->format('M d, Y • h:i A') }}
            </td>
            <td class="px-6 py-4 text-base font-black text-[#1F2937]">
                ₦{{ number_format($withdrawal->amount, 2) }}
            </td>
            <td class="px-6 py-4">
                @if($withdrawal->status == 'completed')
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#108981]/10 px-3 py-1 text-xs font-bold text-[#108981]"><span class="size-1.5 rounded-full bg-[#108981]"></span> Completed</span>
                @elseif($withdrawal->status == 'pending')
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#F59E0B]/10 px-3 py-1 text-xs font-bold text-[#F59E0B]"><span class="size-1.5 rounded-full bg-[#F59E0B] animate-pulse"></span> Processing</span>
                @else
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EF4444]/10 px-3 py-1 text-xs font-bold text-[#EF4444]"><span class="size-1.5 rounded-full bg-[#EF4444]"></span> Failed</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="px-6 py-20 text-center h-full align-middle">
                <div class="flex flex-col items-center justify-center">
                    <div class="h-20 w-20 bg-[#F8FAFC] rounded-full flex items-center justify-center mb-4 border border-[#D1D5DB]">
                        <i class="las la-money-bill-wave text-4xl text-[#94A3B8]"></i>
                    </div>
                    <p class="text-xl font-bold text-[#1F2937] mb-1">No withdrawals yet</p>
                    <p class="text-sm text-[#64748B] max-w-sm">When you request a payout to your bank, the history will appear here.</p>
                </div>
            </td>
        </tr>
    @endforelse
</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ADD BANK MODAL -->
    <div id="addBankModal" class="fixed inset-0 z-[99999] hidden items-center justify-center transition-opacity bg-[#1F2937]/60 backdrop-blur-sm">
        <div class="w-full rounded-2xl bg-white p-8 shadow-2xl relative" style="max-width: 450px;">
            
            <button onclick="toggleModal('addBankModal')" class="absolute top-5 right-5 bg-[#F8FAFC] hover:bg-[#EF4444]/10 hover:text-[#EF4444] text-[#64748B] rounded-full h-8 w-8 flex items-center justify-center transition-colors">
                <i class="las la-times text-xl"></i>
            </button>

            <div class="mb-6 bb-dashed pb-4">
                <h3 class="text-xl font-black text-[#0B3A75]">Add Bank Account</h3>
                <p class="text-sm text-[#64748B] mt-1">Add a new destination for your payouts.</p>
            </div>
            
            <form action="{{ route('vendor.bank.store') }}" method="POST"
                  onsubmit="document.getElementById('bank-btn').innerHTML = '<i class=\'las la-spinner la-spin text-xl\'></i> Saving...'; document.getElementById('bank-btn').disabled = true;">
                @csrf
                <div class="space-y-5">
    <div>
        <label class="mb-2 block font-bold text-[#1F2937]">Select Bank</label>
        <!-- The 'select' ensures we get the exact Bank Code needed for the API -->
        <select name="bank_code" id="bank_select" required class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-bold text-[#1F2937]">
            <option value="">-- Choose your bank --</option>
            <option value="044" data-name="Access Bank">Access Bank</option>
            <option value="050" data-name="Ecobank">Ecobank</option>
            <option value="011" data-name="First Bank of Nigeria">First Bank of Nigeria</option>
            <option value="058" data-name="Guaranty Trust Bank">Guaranty Trust Bank (GTB)</option>
            <option value="090267" data-name="Kuda Bank">Kuda Bank</option>
            <option value="50211" data-name="Moniepoint">Moniepoint MFB</option>
            <option value="100004" data-name="Opay">Opay</option>
            <option value="033" data-name="United Bank for Africa">United Bank for Africa (UBA)</option>
            <option value="035" data-name="Wema Bank">Wema Bank</option>
            <option value="057" data-name="Zenith Bank">Zenith Bank</option>
        </select>
        
        <!-- We pass the text name of the bank secretly so the controller can save it -->
        <input type="hidden" name="bank_name" id="hidden_bank_name">
    </div>
    
    <div>
        <label class="mb-2 block font-bold text-[#1F2937]">Account Number</label>
        <input type="text" name="account_number" required minlength="10" maxlength="10" placeholder="0123456789" class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-bold text-[#1F2937]">
    </div>
</div>

<!-- JavaScript to pass the selected bank name to the hidden input -->
<script>
    document.getElementById('bank_select').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        document.getElementById('hidden_bank_name').value = selectedOption.getAttribute('data-name');
    });
</script>
                
                <div class="mt-8">
                    <button type="submit" id="bank-btn" class="btn-q4i-primary w-full flex items-center justify-center gap-2 py-3.5 rounded-xl font-bold text-lg">
                        <i class="las la-save text-xl"></i> Save Bank Account
                    </button>
                </div>
            </form>
        </div>
    </div>


    <div id="withdrawModal" class="fixed inset-0 z-[99999] hidden items-center justify-center transition-opacity bg-[#1F2937]/60 backdrop-blur-sm">
        <div class="w-full rounded-2xl bg-white p-8 shadow-2xl relative" style="max-width: 450px;">
            
            <button onclick="toggleModal('withdrawModal')" class="absolute top-5 right-5 bg-[#F8FAFC] hover:bg-[#EF4444]/10 hover:text-[#EF4444] text-[#64748B] rounded-full h-8 w-8 flex items-center justify-center transition-colors">
                <i class="las la-times text-xl"></i>
            </button>

            <div class="mb-6 bb-dashed pb-4">
                <h3 class="text-xl font-black text-[#0B3A75]">Request Withdrawal</h3>
                <p class="text-sm text-[#64748B] mt-1">Move your vault earnings to your local bank.</p>
            </div>
            
            <form action="{{ route('vendor.wallet.withdraw') }}" method="POST"
                  onsubmit="document.getElementById('withdraw-btn-submit').innerHTML = '<i class=\'las la-spinner la-spin text-xl\'></i> Processing...'; document.getElementById('withdraw-btn-submit').disabled = true;">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label class="mb-2 block font-bold text-[#1F2937]">Amount to Withdraw (₦)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-[#64748B]">₦</span>
                            <input type="number" name="amount" id="withdrawAmount" required min="1000" placeholder="0.00" max="{{ $availableBalance ?? 0 }}" class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] pl-10 pr-4 py-3 text-sm outline-none transition-all font-black text-[#1F2937]">
                        </div>
                        <p class="mt-2 text-xs font-bold text-[#108981] flex items-center gap-1">
                            <i class="las la-check-circle"></i> Max available: ₦{{ number_format($availableBalance ?? 0, 2) }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="mb-2 block font-bold text-[#1F2937]">Destination Account</label>
                        @if(isset($primaryBank) && $primaryBank)
                            <div class="rounded-xl border border-[#108981]/30 bg-[#108981]/5 p-4 flex items-center justify-between cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <div class="flex size-10 items-center justify-center rounded-lg bg-[#108981]/10 text-[#108981]">
                                        <i class="las la-university text-2xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-[#1F2937]">{{ $primaryBank->bank_name }}</p>
                                        <p class="text-xs font-medium text-[#64748B]">**** {{ substr($primaryBank->account_number, -4) }}</p>
                                    </div>
                                </div>
                                <i class="las la-check-circle text-[#108981] text-xl"></i>
                            </div>
                        @else
                            <div class="rounded-xl border border-[#EF4444]/30 bg-[#EF4444]/5 p-4 text-[#EF4444] text-sm font-bold flex items-center gap-2">
                                <i class="las la-exclamation-triangle text-xl"></i> Please add a bank account first.
                            </div>
                        @endif
                    </div>
                    
                    <div>
                        <label class="mb-2 block font-bold text-[#1F2937]">Enter Security PIN</label>
                        <input type="password" name="pin" required placeholder="••••" class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-center tracking-[0.5em] text-lg outline-none transition-all font-bold text-[#1F2937]">
                    </div>
                    
                    <div>
                        <label class="mb-2 block font-bold text-[#1F2937]">Email OTP</label>
                        <div class="flex gap-2">
                            <input type="text" name="otp" required placeholder="123456" class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-center tracking-[0.5em] text-lg outline-none transition-all font-bold text-[#1F2937]">
                            <button type="button" id="requestOtpBtn" onclick="requestOtp()" class="bg-[#0878F8] text-white px-4 py-3 rounded-xl font-bold whitespace-nowrap hover:bg-[#0B3A75] transition-colors">
                                Get OTP
                            </button>
                        </div>
                        <p id="otpMessage" class="mt-2 text-xs font-bold hidden"></p>
                    </div>
                </div>
                
                <div class="mt-8">
                    <button type="submit" id="withdraw-btn-submit" {{ (!isset($primaryBank) || !$primaryBank) ? 'disabled' : '' }} class="btn-q4i-primary w-full flex items-center justify-center gap-2 py-3.5 rounded-xl font-bold text-lg {{ (!isset($primaryBank) || !$primaryBank) ? 'opacity-50 cursor-not-allowed' : '' }}">
                        <i class="las la-paper-plane text-xl"></i> Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL LOGIC -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.body.appendChild(document.getElementById('addBankModal'));
            document.body.appendChild(document.getElementById('withdrawModal'));
        });

        function toggleModal(modalID) {
            const modal = document.getElementById(modalID);
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } else {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        }

        async function requestOtp() {
            const amountInput = document.getElementById('withdrawAmount');
            const amount = amountInput.value;
            const btn = document.getElementById('requestOtpBtn');
            const msg = document.getElementById('otpMessage');

            if (!amount || amount < 1000) {
                msg.textContent = "Please enter a valid amount (Min: ₦1,000) first.";
                msg.className = "mt-2 text-xs font-bold text-[#EF4444] block";
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="las la-spinner la-spin"></i> Sending...';
            msg.classList.add('hidden');

            try {
                const response = await fetch("{{ route('vendor.wallet.withdraw.otp') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ amount: amount })
                });

                const data = await response.json();

                msg.classList.remove('hidden');
                if (response.ok && data.status === 'success') {
                    msg.textContent = data.message;
                    msg.className = "mt-2 text-xs font-bold text-[#108981] block";
                    btn.innerHTML = 'OTP Sent!';
                } else {
                    msg.textContent = data.message || "Failed to send OTP.";
                    msg.className = "mt-2 text-xs font-bold text-[#EF4444] block";
                    btn.innerHTML = 'Get OTP';
                    btn.disabled = false;
                }
            } catch (error) {
                msg.textContent = "An error occurred. Please check your connection.";
                msg.className = "mt-2 text-xs font-bold text-[#EF4444] block";
                btn.innerHTML = 'Get OTP';
                btn.disabled = false;
            }
        }
    </script>
    <div id="kycModal" class="fixed inset-0 z-[99999] hidden items-center justify-center transition-opacity bg-[#1F2937]/60 backdrop-blur-sm">
        <div class="w-full rounded-2xl bg-white p-8 shadow-2xl relative" style="max-width: 450px;">
            
            <button onclick="toggleModal('kycModal')" class="absolute top-5 right-5 bg-[#F8FAFC] hover:bg-[#EF4444]/10 hover:text-[#EF4444] text-[#64748B] rounded-full h-8 w-8 flex items-center justify-center transition-colors">
                <i class="las la-times text-xl"></i>
            </button>

            <div class="text-center mb-6">
                <div class="mx-auto flex size-16 items-center justify-center rounded-full bg-[#0878F8]/10 text-[#0878F8] mb-4 border border-[#0878F8]/20">
                    <i class="las la-fingerprint text-4xl"></i>
                </div>
                <h3 class="text-2xl font-black text-[#0B3A75]">Verify Your BVN</h3>
                <p class="text-sm text-[#64748B] mt-2 leading-relaxed">Your Bank Verification Number is encrypted and processed securely via Dojah. It is used strictly for identity matching.</p>
            </div>
            
            <form action="{{ route('vendor.kyc.verify') }}" method="POST"
                  onsubmit="document.getElementById('kyc-btn').innerHTML = '<i class=\'las la-spinner la-spin text-xl\'></i> Verifying Identity...'; document.getElementById('kyc-btn').classList.add('opacity-75', 'cursor-not-allowed');">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label class="mb-2 block font-bold text-[#1F2937]">11-Digit BVN</label>
                        <input type="text" name="bvn" required minlength="11" maxlength="11" placeholder="Enter your BVN" class="input-q4i w-full rounded-xl border-2 border-[#D1D5DB] bg-[#F8FAFC] px-4 py-4 text-center tracking-[0.3em] text-xl outline-none transition-all font-black text-[#1F2937]">
                    </div>
                    
                    <div class="rounded-xl border border-[#F59E0B]/30 bg-[#F59E0B]/5 p-4 flex gap-3 text-left">
                        <i class="las la-lock text-[#F59E0B] text-2xl"></i>
                        <p class="text-xs font-medium text-[#F59E0B] leading-relaxed">The name attached to this BVN will be permanently locked to your Q4I profile. All future bank withdrawals must match this exact name.</p>
                    </div>
                </div>
                
                <div class="mt-8">
                    <button type="submit" id="kyc-btn" class="w-full bg-[#0B3A75] hover:bg-[#062142] text-white py-3.5 rounded-xl font-black text-lg transition-all shadow-lg hover:shadow-none hover:-translate-y-0.5 flex justify-center items-center gap-2">
                        <i class="las la-shield-alt text-xl"></i> Securely Verify
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection