<footer class="footer bg-n0 border-t border-slate-200">
    <div class="flex flex-col items-center justify-center gap-4 px-4 py-5 lg:flex-row lg:justify-between xxl:px-8">
        
        <p class="text-[10px] max-md:w-full max-md:text-center lg:text-[11px] text-slate-600">
            Copyright &copy; <span id="current-year">{{ date('Y') }}</span>
            <a class="font-bold text-[#128C7E]" href="{{ route('vendor.dashboard') }}"> Q4I Gateway </a>
            . Designed By
            <a href="https://q4iltd.com" target="_blank" class="font-bold text-blue-600 hover:text-[#128C7E] transition-colors">Q4I Limited&reg;</a>
        </p>
        
        <div class="flex-shrink-0">
            @include('partials._social')
        </div>

        <ul class="flex gap-2 text-[10px] font-medium text-slate-600 max-lg:w-full max-lg:justify-center lg:gap-3 lg:text-[11px]">
            <li>
                <a href="#" class="hover:text-[#128C7E] transition-colors">Privacy Policy</a>
            </li>
            <li>
                <a href="#" class="hover:text-[#128C7E] transition-colors">Terms of condition</a>
            </li>
        </ul>
    </div>
</footer>

@include('layout.modal')

@yield('page-modal')

<div id="customizer-container" class="z-[60] w-full"></div>

@stack('page-js')

@vite(['resources/js/app.js'])

</body>
</html>