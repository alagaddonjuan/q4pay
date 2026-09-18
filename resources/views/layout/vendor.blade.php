@include('layout.vendor-header')
<!-- Navigation -->
<section class="topbar-container z-30">
    @include('layout.vendor-nav')
    @include('layout.vendor-sidebar')
</section>
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
        
<!-- Main Content -->
<main class="main-content has-sidebar">
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
    @yield('content')
</main>

@include('layout.footer')
