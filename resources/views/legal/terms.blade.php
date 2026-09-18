<!DOCTYPE html>
<html dir="ltr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon" />
    @vite('resources/css/app.css')
    <title>Terms of Use | Q4I Limited</title>
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
            <h1 class="text-3xl md:text-4xl font-black text-[#003366] mb-4">Terms of Use</h1>
            <p class="text-slate-500 mb-8 pb-8 border-b border-slate-100">Last Updated: {{ date('F d, Y') }}</p>

            <div class="prose max-w-none text-slate-600 leading-relaxed space-y-6">
                <h3 class="text-xl font-bold text-[#003366]">1. Acceptance of Terms</h3>
                <p>By accessing or using the payment gateway, escrow infrastructure, and APIs provided by Q4I Limited, you agree to be bound by these Terms of Use. If you do not agree, do not use our services.</p>

                <h3 class="text-xl font-bold text-[#003366]">2. Service Description</h3>
                <p>Q4I Limited provides a secure financial infrastructure bridging corporate merchants and social commerce vendors. Our services include automated escrow, virtual accounts, and real-time ledger management. We hold funds securely pending the fulfillment of transactional conditions between buyers and sellers.</p>

                <h3 class="text-xl font-bold text-[#003366]">3. User Obligations</h3>
                <p>As a registered merchant or vendor, you agree to provide accurate KYC/KYB documentation. You are strictly prohibited from using our platform for illicit activities, unauthorized hardware tampering, or processing restricted goods.</p>

                <h3 class="text-xl font-bold text-[#003366]">4. Escrow and Settlements</h3>
                <p>Funds collected via dynamic virtual accounts or payment links are subject to verification protocols. Settlements to designated bank accounts will occur according to your specific SLA and risk profile.</p>

                <div class="mt-12 p-6 bg-blue-50 rounded-xl border border-blue-100 text-sm">
                    <p class="font-bold text-[#003366]"><i class="las la-info-circle text-lg"></i> Legal Disclaimer</p>
                    <p class="mt-2 text-blue-800">This is a placeholder document. The comprehensive Terms of Use is currently being finalized by our legal counsel and will be updated shortly.</p>
                </div>
            </div>
        </div>
    </main>

</body>
</html>