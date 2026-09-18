<footer class="footer bg-n0 border-t border-slate-200 mt-auto">
    <div class="flex flex-col items-center justify-center gap-4 px-4 py-5 lg:flex-row lg:justify-between xxl:px-8">
        
        <!-- Copyright -->
        <p class="text-[10px] max-md:w-full max-md:text-center lg:text-[11px] text-slate-500 font-medium shrink-0">
            Copyright &copy; <span id="current-year">{{ date('Y') }}</span>
            <a class="font-bold text-[#003366]" href="/">Q4I Limited&reg;</a>. 
            All rights reserved.
        </p>
        
        <!-- Socials -->
        <div class="flex-shrink-0">
            @include('partials._social-merchant')
        </div>
        
        <!-- Links -->
        <ul class="flex flex-wrap gap-2 text-[10px] max-lg:w-full max-lg:justify-center lg:gap-3 lg:text-[11px] text-slate-500 font-medium shrink-0">
            <li>
                <a href="{{ route('legal.privacy') }}" target="_blank" onmouseover="this.style.color='#D20103'" onmouseout="this.style.color='inherit'" style="transition: color 0.3s;">Privacy Policy</a>
            </li>
            <li>
                <a href="{{ route('legal.terms') }}" target="_blank" onmouseover="this.style.color='#D20103'" onmouseout="this.style.color='inherit'" style="transition: color 0.3s;">Terms of Service</a>
            </li>
            <span class="text-slate-300 hidden md:inline">|</span>
            <li>
                <a href="{{ route('merchant.support.help-center') }}" onmouseover="this.style.color='#003366'" onmouseout="this.style.color='inherit'" style="transition: color 0.3s;">Help Center</a>
            </li>
            <li>
                <a href="{{ route('merchant.support.contact') }}" onmouseover="this.style.color='#003366'" onmouseout="this.style.color='inherit'" style="transition: color 0.3s;">Contact Support</a>
            </li>
        </ul>
    </div>
</footer>

@include('layout.modal')

@yield('page-modal')

@stack('page-js')

@vite(['resources/js/app.js'])

<script>
    // Fills in the current year automatically if you didn't have it scripted yet
    document.getElementById('current-year').textContent = new Date().getFullYear();
</script>

</body>
</html>