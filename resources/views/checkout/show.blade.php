<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | {{ $product->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden">
        
        <div class="bg-blue-600 p-6 text-center text-white">
            <h2 class="text-xl font-bold">{{ $vendor->store_name ?? $vendor->name }}</h2>
            <p class="text-blue-100 text-sm mt-1">Secured by Q4I Escrow 🔒</p>
        </div>

        <div class="p-6">
            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-20 h-20 object-cover rounded-xl shadow-sm" alt="Product">
                @else
                    <div class="w-20 h-20 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                @endif
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">{{ $product->name }}</h3>
                    <p class="text-2xl font-black text-blue-600 mt-1">₦{{ number_format($product->price, 2) }}</p>
                </div>
            </div>

            @if(session('error'))
                <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('account_details'))
                <div class="bg-green-50 border border-green-200 rounded-xl p-5 text-center">
                    <p class="text-green-800 font-medium mb-1">Make a transfer to the account below</p>
                    <p class="text-xs text-gray-500 mb-4">This account expires in {{ session('account_details')['expires_in'] }}</p>
                    
                    <div class="bg-white rounded-lg p-4 shadow-sm mb-4">
                        <p class="text-sm text-gray-500">Bank Name</p>
                        <p class="font-bold text-gray-800 text-lg">{{ session('account_details')['bankName'] }}</p>
                        
                        <p class="text-sm text-gray-500 mt-3">Account Number</p>
                        <p class="font-black text-3xl text-blue-600 tracking-wider my-1">{{ session('account_details')['accountNumber'] }}</p>
                        
                        <p class="text-sm text-gray-500 mt-3">Amount</p>
                        <p class="font-bold text-gray-800 text-lg">₦{{ number_format(session('account_details')['amount'], 2) }}</p>
                    </div>
                    
                    <p class="text-xs text-gray-500">Once you transfer, the vendor will be notified immediately and your funds will be locked in Escrow until delivery.</p>
                </div>

            @else
                <form action="{{ route('public.checkout.generate', $product->slug) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Your Full Name</label>
                        <input type="text" name="buyer_name" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all" placeholder="e.g. John Doe">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Your WhatsApp Number</label>
                        <input type="text" name="buyer_phone" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all" placeholder="e.g. 08012345678">
                    </div>
                    
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-lg hover:shadow-blue-500/30 flex justify-center items-center gap-2">
                        Get Payment Details
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            @endif

        </div>
    </div>

</body>
</html>