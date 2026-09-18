@include('layout.merchant-header')

<style>
    :root {
        --q4i-blue: #003366;
        --q4i-red: #D20103;
    }

    /* 1. Sidebar Background */
    .sidebar-wrapper, aside, .sidebar {
        background-color: #ffffff !important;
        border-right: 1px solid #e2e8f0 !important;
    }

    /* 2. Inactive Button Style */
    .sidebar-menu li a {
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        padding: 14px 20px !important;
        margin: 0 16px 8px 16px !important;
        border-radius: 12px !important;
        color: var(--q4i-blue) !important;
        font-weight: 600 !important;
        transition: all 0.3s ease !important;
        border: none !important;
    }
    
    .sidebar-menu li a i {
        font-size: 24px !important;
        color: var(--q4i-blue) !important;
        transition: all 0.3s ease !important;
    }

    /* 3. Hover Effect */
    .sidebar-menu li a:hover {
        background-color: rgba(210, 1, 3, 0.06) !important;
        color: var(--q4i-red) !important;
        transform: translateX(4px);
    }
    .sidebar-menu li a:hover i {
        color: var(--q4i-red) !important;
    }

    /* 4. Active Button Style (Solid Red Pill) */
    .sidebar-menu li.active > a {
        background-color: var(--q4i-red) !important;
        color: #ffffff !important;
        box-shadow: 0 6px 16px rgba(210, 1, 3, 0.25) !important;
    }
    .sidebar-menu li.active > a i,
    .sidebar-menu li.active > a span {
        color: #ffffff !important;
    }

    /* 5. Fix Section Titles */
    .sidebar-menu .menu-title {
        padding-left: 24px !important;
        color: #94a3b8 !important;
        font-weight: 700 !important;
        letter-spacing: 1px !important;
    }

    /* Fix primary buttons */
    .btn-primary, .bg-primary {
        background-color: var(--q4i-red) !important;
        border-color: var(--q4i-red) !important;
        color: #ffffff !important;
    }
    .btn-primary:hover, .bg-primary:hover {
        background-color: #a30102 !important; 
        border-color: #a30102 !important;
    }

    /* 6. Sidebar Scroll Fix - TYPO FIXED HERE */
    .sidebar-inner .menu-container {
        height: calc(100vh - 90px) !important; 
        overflow-y: auto !important;
        padding-bottom: 40px !important; 
    }
    
    /* Elegant Slim Scrollbar */
    .sidebar-inner .menu-container::-webkit-scrollbar {
        width: 4px;
    }
    .sidebar-inner .menu-container::-webkit-scrollbar-track {
        background: transparent;
    }
    .sidebar-inner .menu-container::-webkit-scrollbar-thumb {
        background-color: transparent;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .sidebar-inner .menu-container:hover::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
    }
</style>

@include('layout.merchant-nav')

@include('layout.sidebar-merchant')

@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 z-[9999] flex items-center w-full max-w-xs p-4 space-x-3 bg-white rounded-xl shadow-lg border-l-4 border-green-500 transform transition-all duration-500 ease-in-out" role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
            <i class="las la-check text-xl"></i>
        </div>
        <div class="ml-3 text-sm font-medium text-n700">{{ session('success') }}</div>
        <button type="button" onclick="document.getElementById('toast-success').style.display='none'" class="ml-auto -mx-1.5 -my-1.5 bg-white text-n500 hover:text-n700 rounded-lg p-1.5 hover:bg-n30 inline-flex h-8 w-8">
            <i class="las la-times text-lg"></i>
        </button>
    </div>
    <script>
        setTimeout(() => { 
            let toast = document.getElementById('toast-success');
            if(toast) toast.style.opacity = '0';
            setTimeout(() => { if(toast) toast.remove(); }, 500);
        }, 4000);
    </script>
@endif

@if(session('error'))
    <div id="toast-error" class="fixed top-5 right-5 z-[9999] flex items-center w-full max-w-xs p-4 space-x-3 bg-white rounded-xl shadow-lg border-l-4 border-red-500 transform transition-all duration-500 ease-in-out" role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
            <i class="las la-exclamation text-xl"></i>
        </div>
        <div class="ml-3 text-sm font-medium text-n700">{{ session('error') }}</div>
        <button type="button" onclick="document.getElementById('toast-error').style.display='none'" class="ml-auto -mx-1.5 -my-1.5 bg-white text-n500 hover:text-n700 rounded-lg p-1.5 hover:bg-n30 inline-flex h-8 w-8">
            <i class="las la-times text-lg"></i>
        </button>
    </div>
    <script>
        setTimeout(() => { 
            let toast = document.getElementById('toast-error');
            if(toast) toast.style.opacity = '0';
            setTimeout(() => { if(toast) toast.remove(); }, 500);
        }, 4000);
    </script>
@endif
        
<main class="main-content has-sidebar flex flex-col min-h-screen">
    <div class="mb-4">
        @if(session('success'))
            <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-green-700 shadow-sm flex items-center gap-3">
                <i class="las la-check-circle text-2xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('info'))
            <div class="rounded-xl border border-blue-200 bg-blue-50 p-4 text-blue-700 shadow-sm flex items-center gap-3">
                <i class="las la-info-circle text-2xl"></i>
                <span class="font-medium">{{ session('info') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-700 shadow-sm flex items-center gap-3">
                <i class="las la-exclamation-circle text-2xl"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif
    </div>
    
    <div class="flex-grow">
        @yield('content')
    </div>
</main>

@include('partials._support-chat-widget')

@include('layout.footer-merchant')