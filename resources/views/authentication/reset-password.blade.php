<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon" />
    @vite('resources/css/app.css')
    <title>Create New Password | Q4I Gateway</title>
</head>

<body class="vertical bg-slate-50">
    <div class="relative min-h-screen flex flex-col">
        <img src="{{ asset('assets/images/ellipse1.png') }}" class="absolute top-16 md:top-5 ltr:right-10 rtl:left-10 opacity-50" alt="ellipse" />
        <img src="{{ asset('assets/images/ellipse2.png') }}" class="absolute bottom-6 ltr:left-0 rtl:right-0 ltr:sm:left-32 rtl:sm:right-32 opacity-50" alt="ellipse" />
        
        <div class="p-6 lg:p-8 relative z-10">
            <a href="/">
                <img src="{{ asset('assets/images/logo-with-text.png') }}" alt="Q4I Logo" class="logo-full2 h-10 w-auto" />
            </a>
        </div>
        
        <div class="flex flex-1 items-center justify-center">
            <div class="relative z-10 w-full max-w-md mx-auto px-4 pb-10">
                <div class="bg-white rounded-3xl shadow-2xl shadow-[#003366]/5 border border-slate-100 overflow-hidden p-8 md:p-10">
                    
                    <div class="mb-8 text-center">
                        <div class="size-16 bg-[#D20103]/10 text-[#D20103] rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="las la-key text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-black text-[#003366] mb-2">Create New Password</h3>
                        <p class="text-slate-500 text-sm">
                            Your new password must be securely encrypted and different from previous passwords.
                        </p>
                    </div>
                    
                    <form action="{{ route('merchant.password.update') }}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="token" value="{{ $token ?? request()->route('token') }}">
                        
                        <div class="mb-5">
                            <label class="text-[#003366] font-bold block mb-2 text-sm uppercase tracking-wide">Email Address</label>
                            <div class="relative">
                                <i class="las la-envelope absolute left-5 top-1/2 -translate-y-1/2 text-xl text-slate-400"></i>
                                <input type="email" name="email" value="{{ $email ?? old('email') }}" required readonly
                                    class="w-full text-sm bg-slate-100 border border-slate-200 rounded-2xl pl-12 pr-6 py-3.5 text-slate-500 cursor-not-allowed outline-none" />
                            </div>
                            @error('email')
                                <span class="text-[#D20103] font-bold text-xs mt-2 block px-2">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-5">
                            <label class="text-[#003366] font-bold block mb-2 text-sm uppercase tracking-wide">New Password</label>
                            <div class="relative">
                                <i class="las la-lock absolute left-5 top-1/2 -translate-y-1/2 text-xl text-slate-400"></i>
                                <input type="password" name="password" required id="password"
                                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-12 py-3.5 focus:bg-white focus:border-[#003366] focus:ring-2 focus:ring-[#003366]/20 outline-none transition-all duration-300"
                                    placeholder="••••••••••••" />
                            </div>
                            @error('password')
                                <span class="text-[#D20103] font-bold text-xs mt-2 block px-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-8">
                            <label class="text-[#003366] font-bold block mb-2 text-sm uppercase tracking-wide">Confirm Password</label>
                            <div class="relative">
                                <i class="las la-check-circle absolute left-5 top-1/2 -translate-y-1/2 text-xl text-slate-400"></i>
                                <input type="password" name="password_confirmation" required id="password_confirmation"
                                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-12 py-3.5 focus:bg-white focus:border-[#003366] focus:ring-2 focus:ring-[#003366]/20 outline-none transition-all duration-300"
                                    placeholder="••••••••••••" />
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-[#003366] hover:bg-blue-900 text-white py-4 rounded-2xl font-bold text-lg shadow-lg shadow-[#003366]/20 transition-all duration-300 transform hover:-translate-y-1">
                            Reset Password & Login <i class="las la-sign-in-alt ml-2"></i>
                        </button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>