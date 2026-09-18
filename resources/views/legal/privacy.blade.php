<!DOCTYPE html>
<html dir="ltr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon" />
    @vite('resources/css/app.css')
    <title>Privacy Policy | Q4I Limited</title>
</head>
<body class="bg-slate-50 text-slate-700 font-sans antialiased">

    <header class="bg-white border-b border-slate-200 py-6 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-6 flex justify-between items-center">
            <a href="/">
                <img src="{{ asset('assets/images/logo-with-text.png') }}" alt="Q4I Logo" class="h-8 w-auto" />
            </a>
            <a href="javascript:history.back()" class="text-sm font-bold text-[#003366] hover:text-[#D20103] transition-colors">
                <i class="las la-arrow-left"></i> Go Back
            </a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-12 md:py-20">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 md:p-14">
            <h1 class="text-3xl md:text-4xl font-black text-[#003366] mb-4">Privacy Policy</h1>
            <p class="text-slate-500 mb-8 pb-8 border-b border-slate-100">Last Updated: {{ date('F d, Y') }}</p>

            <div class="prose max-w-none text-slate-600 leading-relaxed space-y-6">
                <h3 class="text-xl font-bold text-[#003366]">1. Information We Collect</h3>
                <p>To facilitate secure financial routing, we collect necessary business and personal data. This includes but is not limited to: corporate registration details, API integration logs, transaction histories, and communication data bridging our webhooks (such as WhatsApp routing data).</p>

                <h3 class="text-xl font-bold text-[#003366]">2. How We Use Your Data</h3>
                <p>Your data is utilized strictly for the execution of payment processing, fraud prevention, anomaly detection, and providing customer support. We employ advanced cryptographic models to ensure data streams remain untampered.</p>

                <h3 class="text-xl font-bold text-[#003366]">3. Information Sharing</h3>
                <p>We do not sell your personal data. Data is only shared with verified banking partners, national switches (e.g., NIBSS), and regulatory bodies when legally required to facilitate your settlements.</p>

                <h3 class="text-xl font-bold text-[#003366]">4. Data Security</h3>
                <p>We implement bank-grade security protocols to protect your information. However, users must also protect their portal credentials and API keys.</p>

                <div class="mt-12 p-6 bg-red-50 rounded-xl border border-red-100 text-sm">
                    <p class="font-bold text-[#D20103]"><i class="las la-shield-alt text-lg"></i> Compliance Notice</p>
                    <p class="mt-2 text-red-800">This placeholder document will be replaced by the official Q4I Privacy Policy to fully reflect NDPR data protection regulations.</p>
                </div>
            </div>
        </div>
    </main>

</body>
</html>