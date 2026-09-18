@extends('layout.vendor')

@section('content')

    <style>
        .box { background-color: #FFFFFF !important; border: 1px solid #D1D5DB !important; border-radius: 1rem; padding: 1.5rem; }
        .bb-dashed { border-bottom: 1px dashed #D1D5DB !important; }
        .h2, .h4 { color: #0B3A75 !important; font-weight: 700 !important; }
        .text-q4i-primary { color: #0878F8 !important; }
        
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
    </style>

    <div class="main-inner bg-[#F8FAFC] min-h-screen p-4 lg:p-6">
        
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div>
                <h2 class="h2 mb-2 text-3xl font-black">Order Details</h2>
                <p class="text-sm text-[#64748B]">Ref: <span class="font-bold text-q4i-primary">{{ $order->reference ?? 'N/A' }}</span></p>
            </div>
            
            <a href="{{ route('vendor.orders.index') }}" class="btn-outline-q4i flex items-center gap-2 rounded-xl px-5 py-2.5 font-semibold">
                <i class="las la-arrow-left text-lg"></i> Back to Orders
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-xl border border-[#108981]/20 bg-[#108981]/10 p-4 text-[#108981] shadow-sm">
                <i class="las la-check-circle text-2xl"></i>
                <p class="font-bold text-sm">{{ session('success') }}</p>
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 flex items-center gap-3 rounded-xl border border-[#EF4444]/20 bg-[#EF4444]/10 p-4 text-[#EF4444] shadow-sm">
                <i class="las la-exclamation-circle text-2xl"></i>
                <p class="font-bold text-sm">{{ $errors->first() }}</p>
            </div>
        @endif

        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            
            <div class="col-span-12 lg:col-span-8 space-y-6">
                
                <div class="box flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 transition-all duration-300 hover:shadow-md hover:border-[#0878F8]/30">
                    <div class="flex items-center gap-4">
                        @if(($order->status ?? '') == 'released')
                            <div class="flex size-14 items-center justify-center rounded-full bg-[#108981]/10 text-[#108981]">
                                <i class="las la-check-circle text-3xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-[#108981]">Funds Released</h4>
                                <p class="text-sm text-[#64748B] mt-0.5">This transaction is complete and funds are in your wallet.</p>
                            </div>
                        @elseif(($order->status ?? '') == 'disputed')
                            <div class="flex size-14 items-center justify-center rounded-full bg-[#EF4444]/10 text-[#EF4444]">
                                <i class="las la-gavel text-3xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-[#EF4444]">Order Disputed</h4>
                                <p class="text-sm text-[#64748B] mt-0.5">The buyer has flagged an issue. Funds are frozen pending Admin review.</p>
                            </div>
                        @elseif(($order->status ?? '') == 'awaiting_funds')
                            <div class="flex size-14 items-center justify-center rounded-full bg-[#F59E0B]/10 text-[#F59E0B]">
                                <i class="las la-clock text-3xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-[#F59E0B]">Awaiting Payment</h4>
                                <p class="text-sm text-[#64748B] mt-0.5">Waiting for buyer to transfer funds to the vault.</p>
                            </div>
                        @else
                            <div class="flex size-14 items-center justify-center rounded-full bg-[#0878F8]/10 text-[#0878F8]">
                                <i class="las la-lock text-3xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-[#0878F8]">Locked in Escrow</h4>
                                <p class="text-sm text-[#64748B] mt-0.5">Funds are secured in Q4I Vault. Please fulfill the order.</p>
                            </div>
                        @endif
                    </div>
                    <div class="sm:text-right mt-2 sm:mt-0 pt-4 sm:pt-0 border-t sm:border-0 border-dashed border-[#D1D5DB] w-full sm:w-auto">
                        <p class="text-sm text-[#64748B] mb-1 font-medium">Transaction Amount</p>
                        <h2 class="text-3xl font-black text-[#1F2937]">₦{{ number_format($order->amount ?? 0, 2) }}</h2>
                    </div>
                </div>

                <div class="box">
                    <h3 class="text-xl font-bold text-[#0B3A75] mb-6 bb-dashed pb-4">Order Fulfillment</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-[#F8FAFC] border border-[#D1D5DB] p-4 rounded-xl">
                            <p class="text-xs font-bold uppercase tracking-wider text-[#64748B] mb-1">Items Ordered</p>
                            <p class="font-bold text-[#1F2937]">{{ $order->item_description ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-[#F8FAFC] border border-[#D1D5DB] p-4 rounded-xl">
                            <p class="text-xs font-bold uppercase tracking-wider text-[#64748B] mb-1">Delivery Method</p>
                            <p class="font-medium text-[#1F2937]">
                                @if($order->is_pickup ?? false)
                                    <span class="text-[#0878F8] font-bold"><i class="las la-store"></i> Local Store Pickup</span>
                                @else
                                    {{ $order->delivery_address ?? 'Awaiting address from buyer...' }}
                                @endif
                            </p>
                        </div>
                    </div>

                    @if(($order->status ?? '') == 'disputed')
                        <div class="bg-[#EF4444]/5 border border-[#EF4444]/20 rounded-xl p-5 relative overflow-hidden">
                            <div class="absolute right-0 top-0 opacity-5 p-4">
                                <i class="las la-shield-alt text-6xl text-[#EF4444]"></i>
                            </div>
                            <div class="flex flex-col gap-2 relative z-10">
                                <div class="flex items-center gap-2">
                                    <span class="size-2 rounded-full bg-[#EF4444] animate-pulse"></span>
                                    <p class="text-xs text-[#EF4444] font-bold uppercase tracking-wider">Transaction Frozen</p>
                                </div>
                                <p class="font-bold text-[#1F2937] text-lg">PIN Verification Disabled</p>
                                <p class="text-sm text-[#64748B]">This transaction is under investigation. Please check your disputes tab or contact Q4I Support.</p>
                            </div>
                        </div>

                    @elseif(($order->is_pickup ?? false) && ($order->status ?? '') == 'locked')
                        <div class="bg-[#0878F8]/5 border border-[#0878F8]/20 rounded-xl p-5 relative overflow-hidden">
                            <div class="absolute right-0 top-0 opacity-5 p-4">
                                <i class="las la-store text-6xl text-[#0878F8]"></i>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 relative z-10">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="size-2 rounded-full bg-[#0878F8] animate-pulse"></span>
                                        <p class="text-xs text-[#0878F8] font-bold uppercase tracking-wider">Local Pickup Authorized</p>
                                    </div>
                                    <p class="font-bold text-[#1F2937] text-lg">Awaiting Buyer Handshake</p>
                                </div>
                                <button onclick="document.getElementById('pinModal').classList.remove('hidden')" class="bg-[#0878F8] hover:bg-[#0B3A75] text-white text-sm font-bold py-2.5 px-6 rounded-xl transition-all shadow-md hover:shadow-none hover:-translate-y-0.5 text-center sm:text-left">
                                    <i class="las la-key mr-1"></i> Enter Buyer PIN
                                </button>
                            </div>
                        </div>

                    @elseif(!($order->is_pickup ?? false) && ($order->tracking_link ?? false))
                        <div class="bg-[#0878F8]/5 border border-[#0878F8]/20 rounded-xl p-5 relative overflow-hidden">
                            <div class="absolute right-0 top-0 opacity-5 p-4">
                                <i class="las la-truck text-6xl text-[#0878F8]"></i>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 relative z-10">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="size-2 rounded-full bg-[#0878F8] animate-pulse"></span>
                                        <p class="text-xs text-[#0878F8] font-bold uppercase tracking-wider">Automated Dispatch</p>
                                    </div>
                                    <p class="font-bold text-[#1F2937] text-lg">{{ $order->logistics_provider ?? 'Courier' }} - {{ $order->tracking_code ?? 'N/A' }}</p>
                                </div>
                                <a href="{{ $order->tracking_link }}" target="_blank" class="bg-[#0878F8] hover:bg-[#0B3A75] text-white text-sm font-bold py-2.5 px-6 rounded-xl transition-all shadow-md hover:shadow-none hover:-translate-y-0.5 text-center sm:text-left">
                                    <i class="las la-satellite-dish mr-1"></i> Track Live
                                </a>
                            </div>
                        </div>

                    @elseif(($order->status ?? '') == 'awaiting_funds')
                        <div class="bg-[#F8FAFC] border border-dashed border-[#D1D5DB] rounded-xl p-6 text-center">
                            <i class="las la-box text-3xl text-[#94A3B8] mb-2"></i>
                            <p class="text-[#64748B] font-medium">Fulfillment details will be generated once the buyer secures the funds.</p>
                        </div>

                    @elseif(($order->status ?? '') == 'released')
                        <div class="bg-[#108981]/10 border border-[#108981]/20 rounded-xl p-4">
                            <p class="text-[#108981] font-bold flex items-center gap-2">
                                <i class="las la-check-circle text-xl"></i> Order Successfully Fulfilled
                            </p>
                        </div>
                        
                    @else
                        <div class="bg-[#F59E0B]/10 border border-[#F59E0B]/20 rounded-xl p-4">
                            <p class="text-[#F59E0B] font-bold flex items-center gap-2">
                                <i class="las la-spinner la-spin text-xl"></i> Awaiting Courier Assignment...
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-span-12 lg:col-span-4 space-y-6">
                
                <div class="box">
                    <h4 class="text-lg font-bold text-[#0B3A75] mb-5 bb-dashed pb-4">Buyer Information</h4>
                    
                    @if(isset($buyer) && $buyer)
                        <div class="flex items-center gap-4 mb-6 bg-[#F8FAFC] p-4 rounded-xl border border-[#D1D5DB]">
                            <div class="flex size-12 items-center justify-center rounded-full bg-[#0878F8]/10 text-q4i-primary font-black text-xl border border-[#0878F8]/20 shadow-sm">
                                {{ strtoupper(substr($buyer->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-[#1F2937]">{{ $buyer->name }}</p>
                                <span class="inline-flex items-center gap-1 rounded bg-[#108981]/10 px-2 py-0.5 text-xs font-semibold text-[#108981]">
                                    <i class="las la-user-check"></i> Verified Buyer
                                </span>
                            </div>
                        </div>
                        
                        <div class="space-y-5 px-1">
                            <div class="flex items-center gap-3">
                                <div class="flex size-8 items-center justify-center rounded-full bg-[#F8FAFC] text-[#64748B]">
                                    <i class="las la-envelope text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-[#94A3B8] font-bold uppercase tracking-wider">Email</p>
                                    <p class="font-medium text-[#1F2937]">{{ $buyer->email }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="flex size-8 items-center justify-center rounded-full bg-[#F8FAFC] text-[#64748B]">
                                    <i class="las la-phone text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-[#94A3B8] font-bold uppercase tracking-wider">Phone</p>
                                    <p class="font-medium text-[#1F2937]">{{ $buyer->phone ?? 'Not provided' }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-6 bg-[#F8FAFC] rounded-xl border border-[#D1D5DB] border-dashed">
                            <div class="flex size-14 items-center justify-center rounded-full bg-white text-[#94A3B8] mx-auto mb-3 shadow-sm border border-[#D1D5DB]">
                                <i class="las la-user-secret text-2xl"></i>
                            </div>
                            <p class="font-bold text-[#1F2937] mb-1">Guest Checkout</p>
                            <p class="text-xs text-[#64748B] px-4 leading-relaxed">Contact details are securely hidden to protect user privacy until funds are locked.</p>
                        </div>
                    @endif
                    
                    <div class="mt-6 pt-5 bb-dashed border-t">
                        <button class="w-full flex items-center justify-center gap-2 rounded-xl bg-[#25D366] text-white px-4 py-3 font-bold hover:bg-[#128C7E] shadow-md shadow-[#25D366]/20 transition-all hover:-translate-y-0.5 hover:shadow-none">
                            <i class="lab la-whatsapp text-2xl"></i> Message Buyer
                        </button>
                    </div>
                </div>

                <div class="box">
                    <h4 class="text-lg font-bold text-[#0B3A75] mb-6 bb-dashed pb-4">Timeline</h4>
                    <div class="relative border-l-2 border-[#D1D5DB] ml-3 space-y-7 pb-2">
                        
                        <div class="relative pl-6">
                            <div class="absolute -left-[9px] top-1 size-4 rounded-full bg-[#0878F8] ring-4 ring-white shadow-sm"></div>
                            <p class="font-bold text-[#1F2937] mb-0.5">Order Created</p>
                            <p class="text-xs font-medium text-[#94A3B8]"><i class="las la-calendar-alt"></i> {{ \Carbon\Carbon::parse($order->created_at ?? now())->format('d M, Y • h:i A') }}</p>
                        </div>

                        @if(($order->status ?? '') != 'awaiting_funds')
                            <div class="relative pl-6">
                                <div class="absolute -left-[9px] top-1 size-4 rounded-full bg-[#0878F8] ring-4 ring-white shadow-sm"></div>
                                <p class="font-bold text-[#1F2937] mb-0.5">Funds Locked</p>
                                <p class="text-xs font-medium text-[#94A3B8]">Payment secured in Escrow</p>
                            </div>
                        @endif

                        @if(($order->status ?? '') == 'released')
                            <div class="relative pl-6">
                                <div class="absolute -left-[9px] top-1 size-4 rounded-full bg-[#108981] ring-4 ring-white shadow-sm"></div>
                                <p class="font-bold text-[#1F2937] mb-0.5 text-[#108981]">Funds Released</p>
                                <p class="text-xs font-medium text-[#94A3B8]"><i class="las la-calendar-check"></i> {{ \Carbon\Carbon::parse($order->updated_at ?? now())->format('d M, Y • h:i A') }}</p>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="pinModal" class="fixed inset-0 z-[99999] hidden items-center justify-center transition-opacity bg-[#1F2937]/60 backdrop-blur-sm">
        <div class="w-full rounded-2xl bg-white p-8 shadow-2xl relative" style="max-width: 400px;">
            
            <button onclick="document.getElementById('pinModal').classList.add('hidden')" class="absolute top-5 right-5 bg-[#F8FAFC] hover:bg-[#EF4444]/10 hover:text-[#EF4444] text-[#64748B] rounded-full h-8 w-8 flex items-center justify-center transition-colors">
                <i class="las la-times text-xl"></i>
            </button>

            <div class="text-center mb-6">
                <div class="mx-auto flex size-16 items-center justify-center rounded-full bg-[#108981]/10 text-[#108981] mb-4">
                    <i class="las la-shield-alt text-3xl"></i>
                </div>
                <h3 class="text-2xl font-black text-[#0B3A75]">Verify Pickup</h3>
                <p class="text-sm text-[#64748B] mt-2 leading-relaxed">Ask the buyer for their 4-digit Escrow PIN to instantly release ₦{{ number_format($order->amount ?? 0, 2) }} to your wallet.</p>
            </div>
            
            <form action="{{ route('vendor.orders.verify-pin', $order->id ?? 0) }}" method="POST"
                  onsubmit="document.getElementById('verify-btn').innerHTML = '<i class=\'las la-spinner la-spin text-xl\'></i> Verifying...'; document.getElementById('verify-btn').classList.add('opacity-75', 'cursor-not-allowed'); document.getElementById('verify-btn').disabled = true;">
                @csrf
                
                <div class="mb-8">
                    <input type="text" name="delivery_pin" maxlength="4" placeholder="••••" required autocomplete="off"
                        class="w-full rounded-xl border-2 border-[#D1D5DB] bg-[#F8FAFC] px-4 py-4 text-center text-3xl tracking-[1em] outline-none transition-all font-black text-[#1F2937] focus:border-[#108981] focus:bg-white focus:ring-4 focus:ring-[#108981]/10">
                </div>
                
                <button type="submit" id="verify-btn" class="w-full bg-[#108981] hover:bg-[#065F59] text-white font-bold py-3.5 rounded-xl shadow-lg shadow-[#108981]/30 hover:shadow-none hover:-translate-y-0.5 transition-all duration-300 flex justify-center items-center gap-2">
                    <i class="las la-unlock text-xl"></i> Verify & Release Funds
                </button>
            </form>
        </div>
    </div>
@endsection