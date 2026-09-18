<!DOCTYPE html>
<html dir="ltr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Disputes | Q4I Vendor Portal</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-slate-50 font-sans text-slate-800 p-6 md:p-12">

    <div class="max-w-5xl mx-auto flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dispute Center</h1>
            <p class="text-sm text-slate-500 mt-1">Manage buyer complaints and locked Escrow funds</p>
        </div>
        <a href="{{ route('merchant.dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">
            <i class="las la-arrow-left text-lg"></i> Back to Dashboard
        </a>
    </div>

    <div class="max-w-5xl mx-auto bg-white rounded-[20px] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 p-10 flex flex-col items-center justify-center min-h-[400px] text-center">
        
        <div class="w-20 h-20 bg-green-50 text-[#10b981] rounded-full flex items-center justify-center mb-6">
            <i class="las la-shield-alt text-4xl"></i>
        </div>

        <h3 class="text-xl font-bold text-slate-900 mb-2">No Active Disputes</h3>
        <p class="text-slate-500 max-w-md mx-auto mb-8">
            Great job! You currently have no buyer disputes. All your Escrow transactions are running smoothly.
        </p>

        <div class="grid grid-cols-2 gap-4 w-full max-w-sm">
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                <p class="text-xs text-slate-500 mb-1">Total Disputes</p>
                <p class="text-xl font-bold text-slate-900">0</p>
            </div>
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                <p class="text-xs text-slate-500 mb-1">Resolved</p>
                <p class="text-xl font-bold text-[#10b981]">0</p>
            </div>
        </div>

    </div>

    @vite('resources/js/app.js')
</body>
</html>