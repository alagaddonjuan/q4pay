<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon" />
    @vite('resources/css/app.css')
    <title>Corporate Registration | Q4I Gateway</title>
</head>

<body class="vertical bg-slate-50">
    <div class="relative min-h-screen flex flex-col">
        <img src="{{ asset('assets/images/ellipse1.png') }}" class="absolute top-16 md:top-5 ltr:right-10 rtl:left-10 opacity-50" alt="ellipse" />
        <img src="{{ asset('assets/images/ellipse2.png') }}" class="absolute bottom-6 ltr:left-0 rtl:right-0 ltr:sm:left-32 rtl:sm:right-32 opacity-50" alt="ellipse" />
        
        <div class="p-6 lg:p-8 relative z-10">
            <a href="/">
                <img src="{{ asset('assets/images/logo-with-text.png') }}" alt="Q4I Logo" class="logo-full2 h-10 md:h-12 w-auto" />
            </a>
        </div>
        
        <div class="flex flex-1 items-center justify-center mt-2 mb-10">
            <div class="relative z-10 w-full max-w-[1200px] mx-auto px-4">
                <div class="grid grid-cols-12 gap-8 items-center bg-white rounded-3xl shadow-2xl shadow-[#003366]/5 border border-slate-100 overflow-hidden">
                    @if(session('success'))
    <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg flex items-center gap-3 text-green-700">
        <p class="text-sm font-bold">{{ session('success') }}</p>
    </div>
@endif
                    <form action="{{ route('merchant.register.submit') }}" method="POST" class="col-span-12 lg:col-span-7 p-8 md:p-12 xl:p-14">
                        @csrf
                        
                        <div class="mb-8">
                            <h3 class="text-3xl md:text-4xl font-black text-[#003366] mb-3">Let's Get Started!</h3>
                            <p class="text-slate-500 text-sm md:text-base border-b border-slate-100 pb-6">
                                Create your Q4I Corporate Gateway Account
                            </p>
                        </div>
                        
                        <div class="mb-5">
                            <label for="business_name" class="text-[#003366] font-bold block mb-2 text-sm uppercase tracking-wide">
                                Registered Business / Company Name
                            </label>
                            <div class="relative">
                                <i class="las la-building absolute left-5 top-1/2 -translate-y-1/2 text-xl text-slate-400"></i>
                                <input type="text" name="business_name" value="{{ old('business_name') }}" required
                                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-6 py-3.5 focus:bg-white focus:border-[#003366] focus:ring-2 focus:ring-[#003366]/20 outline-none transition-all duration-300"
                                    placeholder="e.g. Q4 International Ltd" id="business_name" />
                            </div>
                            @error('business_name')
                                <span class="text-[#D20103] font-bold text-xs mt-2 block px-2"><i class="las la-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-5">
                            <label for="email" class="text-[#003366] font-bold block mb-2 text-sm uppercase tracking-wide">
                                Corporate Email Address
                            </label>
                            <div class="relative">
                                <i class="las la-envelope absolute left-5 top-1/2 -translate-y-1/2 text-xl text-slate-400"></i>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-6 py-3.5 focus:bg-white focus:border-[#003366] focus:ring-2 focus:ring-[#003366]/20 outline-none transition-all duration-300"
                                    placeholder="e.g. corporate@yourcompany.com" id="email" />
                            </div>
                            @error('email')
                                <span class="text-[#D20103] font-bold text-xs mt-2 block px-2"><i class="las la-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label for="password" class="text-[#003366] font-bold block mb-2 text-sm uppercase tracking-wide">
                                Create Your Password
                            </label>
                            <div class="relative">
                                <i class="las la-lock absolute left-5 top-1/2 -translate-y-1/2 text-xl text-slate-400"></i>
                                <input type="password" name="password" required id="password"
                                    class="w-full text-sm bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-12 py-3.5 focus:bg-white focus:border-[#003366] focus:ring-2 focus:ring-[#003366]/20 outline-none transition-all duration-300"
                                    placeholder="Create a strong password" />
                                <span class="absolute right-5 top-1/2 -translate-y-1/2 cursor-pointer text-slate-400 hover:text-[#003366] transition-colors" id="toggleBtn">
                                    <i class="las la-eye text-xl" style="display: none;"></i>
                                    <i class="las la-eye-slash text-xl"></i>
                                </span>
                            </div>
                            @error('password')
                                <span class="text-[#D20103] font-bold text-xs mt-2 block px-2"><i class="las la-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <p class="text-sm text-slate-500 font-medium leading-relaxed mb-8">
                            By clicking submit, you agree to the Q4I Gateway 
                            <a href="{{ url('/terms-and-conditions') }}" target="_blank" class="text-[#D20103] font-bold hover:text-red-800 transition-colors">Terms of Use</a> & 
                            <a href="{{ url('/privacy-policy') }}" target="_blank" class="text-[#D20103] font-bold hover:text-red-800 transition-colors">Privacy Policy</a>.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                            <button type="submit" class="w-full sm:w-auto bg-[#003366] hover:bg-blue-900 text-white px-10 py-4 rounded-2xl font-bold text-lg shadow-lg shadow-[#003366]/20 transition-all duration-300 transform hover:-translate-y-1">
                                Create Account
                            </button>
                            
                            <span class="text-sm text-slate-500 font-medium">
                                Already registered? 
                                <a href="{{ route('merchant.login') }}" class="text-[#D20103] font-black hover:underline ml-1">Login Here</a>
                            </span>
                        </div>
                    </form>

                    <div class="hidden lg:flex col-span-5 bg-slate-50 h-full items-center justify-center p-8 xl:p-12 border-l border-slate-100">
                        <img src="{{ asset('assets/images/auth.png') }}" alt="Secure Registration" class="max-w-full h-auto drop-shadow-xl hover:scale-105 transition-transform duration-500" />
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/app.js')
    
    <script>
        document.getElementById('toggleBtn')?.addEventListener('click', function () {
            const passField = document.getElementById('password');
            const eye = this.querySelector('.la-eye');
            const eyeSlash = this.querySelector('.la-eye-slash');
            
            if (passField.type === 'password') {
                passField.type = 'text';
                eye.style.display = 'block';
                eyeSlash.style.display = 'none';
            } else {
                passField.type = 'password';
                eye.style.display = 'none';
                eyeSlash.style.display = 'block';
            }
        });
    </script>
</body>
</html>