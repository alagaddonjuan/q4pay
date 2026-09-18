<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon" />
    @vite('resources/css/app.css')
    <title>{{ $title ?? 'Two-Factor Authentication' }} | Q4I</title>
    <style>
        .letter-spacing-2 {
            letter-spacing: 0.5em;
            font-size: 1.5rem;
            text-align: center;
        }
    </style>
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
            <div class="relative z-10 w-full max-w-[600px] mx-auto px-4 pb-10">
                <div class="bg-white rounded-3xl shadow-2xl shadow-[#003366]/5 border border-slate-100 overflow-hidden">
                    
                    <form action="{{ $postRoute }}" method="POST" class="p-8 md:p-12">
                        @csrf
                        
                        <div class="mb-8 text-center">
                            <h3 class="text-3xl font-black text-[#003366] mb-3">Two-Factor Auth</h3>
                            <p class="text-slate-500 text-sm md:text-base border-b border-slate-100 pb-6">
                                Please enter the 6-digit code from your authenticator app to continue.
                            </p>
                        </div>
                        
                        @if(session('error'))
                            <div class="bg-[#D20103]/10 border border-[#D20103]/20 text-[#D20103] rounded-xl p-4 mb-6 text-center text-sm font-bold">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="bg-[#D20103]/10 border border-[#D20103]/20 text-[#D20103] rounded-xl p-4 mb-6 text-center text-sm font-bold">
                                @foreach($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif

                        <div class="mb-8">
                            <label for="one_time_password" class="text-[#003366] font-bold block mb-4 text-sm uppercase tracking-wide text-center">
                                Authentication Code
                            </label>
                            <input type="text" name="one_time_password" required id="one_time_password"
                                class="w-full text-center bg-slate-50 border border-slate-200 rounded-2xl py-4 focus:bg-white focus:border-[#003366] focus:ring-2 focus:ring-[#003366]/20 outline-none transition-all duration-300 letter-spacing-2"
                                placeholder="XXXXXX" maxlength="6" autofocus autocomplete="off" />
                        </div>
                        
                        <div class="flex flex-col gap-4">
                            <button type="submit" class="w-full bg-[#003366] hover:bg-blue-900 text-white py-4 rounded-2xl font-bold text-lg shadow-lg shadow-[#003366]/20 transition-all duration-300 transform hover:-translate-y-1">
                                Verify Code <i class="las la-check-circle ml-2"></i>
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/app.js')
</body>
</html>
