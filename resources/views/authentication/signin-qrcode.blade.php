<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon" />
    @vite('resources/css/app.css')
    <title>Bankhub - HTML Tailwindcss Fintech and Banking Dashboard</title>
</head>

<body class="vertical bg-secondary/5 ">
    <!-- Loader -->
    {{-- <div class="loader flex items-center justify-center min-w-screen min-h-screen fixed !z-50 inset-0 bg-n0 ">
        <svg viewBox="25 25 50 50">
            <circle r="20" cy="50" cx="50"></circle>
        </svg>
    </div> --}}
    <div class="relative min-h-screen bg-secondary/5 ">
        <img src="{{ asset('assets/images/ellipse1.png') }}" class="absolute top-16 md:top-5 ltr:right-10 rtl:left-10"
            alt="ellipse" />
        <img src="{{ asset('assets/images/ellipse2.png') }}"
            class="absolute bottom-6 ltr:left-0 rtl:right-0 ltr:sm:left-32 rtl:sm:right-32" alt="ellipse" />
        <a href="{{ route('vendor.dashboard') }}">
            <img src="{{ asset('assets/images/logo-with-text.png') }}" alt="logo"
                class="logo-full2 lg:block p-6 lg:p-8 relative z-2" />
        </a>
        <div class="flex items-center justify-center mt-7">
            <div class="relative z-2 max-w-[1416px] mx-auto px-3 pb-10">
                <div
                    class="box  p-3 md:p-4 xl:p-6 grid grid-cols-12 gap-6 items-center shadow-[0px_6px_30px_0px_rgba(0,0,0,0.04)]">
                    <div class="col-span-12 lg:col-span-6">
                        <div class="box bg-primary/5 lg:p-6 xl:p-8 border border-n30  text-center">
                            <h3 class="h3 mb-4">Sign In With QR Code</h3>
                            <p class="mb-6 lg:mb-8 bb-dashed pb-4  lg:pb-8">
                                Scan this code with mobile app to Sign In Instantly
                            </p>
                            <div class="max-w-[400px] mx-auto box  rounded-xl border  p-6 lg:p-8">
                                <img src="{{ asset('assets/images/qrcode.png') }}" class="qrcode-img" width="336"
                                    height="349" alt="qrcode" />
                            </div>
                            <p class="mt-6 lg:mt-8">
                                Sign in with email and password?
                                <a href="/auth/sign-in.html" class="text-primary font-medium">
                                    Click Here
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-start-8 lg:col-span-5">
                        <img src="{{ asset('assets/images/auth.png') }}" alt="img" width="533" height="560" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/app.js')
</body>

</html>