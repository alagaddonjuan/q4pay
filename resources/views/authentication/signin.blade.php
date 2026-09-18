<!DOCTYPE html>
<html dir="ltr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon" />
    @vite('resources/css/app.css')
    <title>Vendor Login - Q4I Escrow</title>
    <style>
        .auth-modal-card {
            max-width: 450px !important;
            margin: 0 auto;
            width: 100%;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            border-radius: 20px;
            background-color: #ffffff;
            position: relative;
            z-index: 10;
        }
        .dashed-divider {
            border-bottom: 1px dashed #cbd5e1;
            margin-bottom: 24px;
            padding-bottom: 16px;
        }
        /* The new Premium "Smart Button" */
        .smart-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff !important;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
            transition: all 0.3s ease;
            border: none;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            cursor: pointer;
        }
        .smart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
        }
    </style>
</head>

<body class="vertical bg-slate-50">
    <div class="relative min-h-screen flex flex-col justify-center overflow-hidden">
        
        <img src="{{ asset('assets/images/ellipse1.png') }}" class="absolute top-0 right-0 w-64 md:w-96 opacity-50 pointer-events-none" alt="ellipse" />
        <img src="{{ asset('assets/images/ellipse2.png') }}" class="absolute bottom-0 left-0 w-64 md:w-96 opacity-50 pointer-events-none" alt="ellipse" />

        <div class="absolute top-6 left-6 md:top-8 md:left-8 z-20">
            <a href="#">
                <img src="{{ asset('assets/images/logo-with-text.png') }}" alt="logo" class="h-8 md:h-10" />
            </a>
        </div>

        <div class="px-4 py-10 w-full flex items-center justify-center min-h-screen">
            <div class="auth-modal-card p-6 md:p-8 border border-slate-100">
                <form action="{{ route('vendor.login.submit') }}" method="POST">
                    @csrf
                    
                    <div class="dashed-divider flex justify-between items-center">
                        <h2 class="text-xl font-bold text-slate-900">Vendor Portal</h2>
                        <i class="las la-lock text-slate-400 text-xl"></i>
                    </div>

                    <div class="mb-5">
                        <label for="phone" class="block text-sm font-medium text-slate-700 mb-2">
                            Enter Your WhatsApp Number
                        </label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required
                            class="w-full text-sm bg-white border border-slate-200 rounded-xl px-4 py-3 focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-all"
                            placeholder="e.g. 08161326939" id="phone" />
                        @error('phone')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">
                            Enter Your Password
                        </label>
                        <div style="position: relative; width: 100%;">
                            <input type="password" name="password" required 
                                class="w-full text-sm bg-white border border-slate-200 rounded-xl pl-4 pr-12 py-3 focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none transition-all"
                                placeholder="Enter Password" id="password" />
                            
                            <span style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); z-index: 10;" 
                                  class="text-slate-400 cursor-pointer text-xl hover:text-slate-600 flex items-center justify-center" id="toggleBtn">
                                <i class="las la-eye" style="display: none;"></i>
                                <i class="las la-eye-slash"></i>
                            </span>
                        </div>

                        @error('password')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                        
                        <div class="flex justify-end mt-2">
                            <a href="#" class="text-xs text-green-600 hover:text-green-700 font-medium">Forgot Password?</a>
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="smart-btn">
                            Login to Dashboard
                        </button>
                    </div>

                    <div class="mt-6 text-center text-sm text-slate-500">
                        Don't have a vendor account? 
                        <a href="{{ route('vendor.register') }}" class="text-green-600 font-medium hover:underline">
                            Register via WhatsApp
                        </a>
                    </div>
                </form>
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