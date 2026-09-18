<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice | {{ $businessName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4 font-sans text-slate-800">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
        
        @if(isset($merchant->logo) && $merchant->logo-with-text.png)
                <img src="{{ asset('storage/' . $merchant->logo-with-text.png) }}" class="size-16 rounded-full mx-auto mb-3 shadow-md border-4 border-blue-800 object-cover bg-white" alt="Merchant Logo">
            @else
                <div class="size-16 bg-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-md border-4 border-blue-800 text-[#003366] text-2xl font-black">
                    {{ substr($businessName, 0, 2) }}
                </div>
            @endif

        <div class="p-8">
            <div class="text-center mb-8">
                <p class="text-slate-500 text-sm mb-2">{{ $link->title }}</p>
                <h2 class="text-4xl font-black text-[#003366]">₦{{ number_format($link->amount, 2) }}</h2>
                <p class="text-xs text-slate-400 mt-2">Ref: {{ $link->reference }}</p>
            </div>

            @if(session('error'))
                <div class="bg-red-50 text-red-600 p-4 rounded-lg text-sm text-center mb-6 border border-red-100 font-bold">
                    {{ session('error') }}
                </div>
            @endif

            @if(isset($alreadyPaid) && $alreadyPaid)
                <!-- Success Screen (Already Paid) -->
                <div class="text-center py-6">
                    <div class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="las la-check text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-2">Payment Successful!</h3>
                    <p class="text-slate-500">This invoice has already been paid and confirmed.</p>
                </div>
            @elseif(session('account_details'))
                <div id="payment-status-container">
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 text-center mb-6">
                        <p class="text-sm font-bold text-blue-800 mb-4">Transfer exactly ₦{{ number_format(session('account_details')['amount'], 2) }} to:</p>
                        
                        <div class="mb-4">
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-1">Bank Name</p>
                            <p class="text-lg font-bold text-slate-700">{{ session('account_details')['bankName'] }}</p>
                        </div>

                        <div class="mb-4 relative">
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-bold mb-1">Account Number</p>
                            <div class="flex items-center justify-center gap-3">
                                <p class="text-3xl font-black text-[#003366] tracking-widest" id="accountNumber">{{ session('account_details')['accountNumber'] }}</p>
                                <button onclick="navigator.clipboard.writeText('{{ session('account_details')['accountNumber'] }}'); alert('Copied!');" class="text-[#D20103] hover:bg-red-50 p-2 rounded-lg transition-colors">
                                    <i class="las la-copy text-2xl"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <i class="las la-spinner la-spin text-3xl text-blue-500 mb-2"></i>
                        <p class="text-sm text-slate-500 font-bold">Awaiting your transfer...</p>
                    </div>
                </div>

                <!-- Success Screen (Hidden by default, shown via JS) -->
                <div id="success-container" class="hidden text-center py-6">
                    <div class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="las la-check text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-2">Payment Successful!</h3>
                    <p class="text-slate-500">Thank you. Your payment has been received and confirmed.</p>
                </div>

                @if(isset(session('account_details')['session_id']))
                <script>
                    const sessionId = "{{ session('account_details')['session_id'] }}";
                    const pollInterval = setInterval(() => {
                        fetch(`/checkout/status/${sessionId}`)
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'paid') {
                                    clearInterval(pollInterval);
                                    document.getElementById('payment-status-container').classList.add('hidden');
                                    document.getElementById('success-container').classList.remove('hidden');
                                }
                            })
                            .catch(err => console.error(err));
                    }, 5000); // Check every 5 seconds
                </script>
                @endif
            @else
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-6 text-center mb-6">
                    <i class="las la-university text-4xl text-blue-500 mb-2"></i>
                    <h3 class="text-lg font-bold text-blue-900 mb-1">Bank Transfer</h3>
                    <p class="text-sm text-blue-700">Click below to generate a temporary, secure bank account for this exact amount.</p>
                </div>

                <form action="{{ route('corporate.checkout.process', $link->reference) }}" method="POST">
                    @csrf
                    
                    <div class="mb-5 text-left">
                        <label for="customer_email" class="block text-sm font-bold text-slate-700 mb-1">Your Email Address <span class="text-red-500">*</span></label>
                        <input type="email" id="customer_email" name="customer_email" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-slate-800" 
                            placeholder="To receive your payment receipt">
                    </div>

                    <button type="submit" onclick="if(this.form.checkValidity()) this.innerHTML='<i class=\'las la-spinner la-spin text-xl\'></i> Generating...'" class="w-full py-4 rounded-xl font-bold text-white transition-all shadow-md hover:-translate-y-0.5 hover:shadow-lg flex items-center justify-center gap-2" style="background-color: #D20103;">
                        <i class="las la-sync text-xl"></i> Generate Account Number
                    </button>
                </form>
            @endif
            
            <p class="text-center text-xs text-slate-400 mt-6 flex items-center justify-center gap-1">
                <i class="las la-lock"></i> Secured by Q4I Gateway
            </p>
        </div>
    </div>
</body>
</html>