<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay {{ $link->title }} | Q4i Gateway</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-sm text-center">
        <h1 class="text-2xl font-bold mb-2">{{ $link->title }}</h1>
        <p class="text-slate-500 mb-6">You are paying</p>
        <h2 class="text-4xl font-black text-primary mb-8">₦{{ number_format($link->amount, 2) }}</h2>
        
        <form action="{{ route('checkout.process', $link->reference) }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-green-600 text-white font-bold py-4 rounded-xl hover:bg-green-700 transition">
                Pay Securely Now
            </button>
        </form>
    </div>

</body>
</html>