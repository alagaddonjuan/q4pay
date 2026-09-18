<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accept Invitation | Q4I Gateway</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
        <div class="bg-[#003366] p-8 text-center">
            <h1 class="text-white text-2xl font-bold tracking-tight">Q4I Gateway</h1>
            <p class="text-blue-200 text-sm mt-2">Team Member Registration</p>
        </div>
        
        <div class="p-8">
            <div class="text-center mb-8">
                <h2 class="text-xl font-bold text-slate-800">Welcome, {{ $member->first_name }}!</h2>
                <p class="text-sm text-slate-500 mt-2">You've been invited as a <strong class="text-[#003366]">{{ ucfirst($member->role) }}</strong>. Please set your credentials to activate your account.</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm mb-6 border border-red-100">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('merchant.team.accept-invite.submit', $member->invite_token) }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-sm font-bold text-[#003366] mb-2">Login Password</label>
                    <input type="password" name="password" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#003366] focus:ring-2 focus:ring-[#003366]/20 outline-none transition-all placeholder-slate-400" placeholder="Minimum 8 characters">
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#003366] mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#003366] focus:ring-2 focus:ring-[#003366]/20 outline-none transition-all placeholder-slate-400" placeholder="Repeat your password">
                </div>

                <div class="pt-2">
                    <label class="block text-sm font-bold text-[#003366] mb-2 flex items-center gap-2">
                        Transaction PIN
                        <span class="text-[10px] uppercase font-bold bg-blue-100 text-[#003366] px-2 py-0.5 rounded-full">Security</span>
                    </label>
                    <p class="text-xs text-slate-500 mb-3">This 4-digit PIN is required for processing refunds or viewing sensitive data.</p>
                    <input type="password" name="transaction_pin" required maxlength="4" pattern="[0-9]{4}" class="w-full text-center tracking-[0.5em] text-xl font-bold bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#003366] focus:ring-2 focus:ring-[#003366]/20 outline-none transition-all placeholder-slate-300" placeholder="••••">
                </div>

                <button type="submit" class="w-full mt-4 bg-[#003366] hover:bg-blue-900 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-blue-900/20 transition-all flex items-center justify-center gap-2 group">
                    Activate My Account
                    <i class="las la-arrow-right text-lg group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>
        </div>
    </div>

</body>
</html>
