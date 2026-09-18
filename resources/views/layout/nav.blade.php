@php
    // 🟢 DYNAMIC PORTAL DETECTION
    // This detects if the URL starts with /merchant. If not, it assumes /vendor.
    $isMerchant = request()->is('merchant*');
    
    // Dynamically assign routes based on the active portal
    $dashboardRoute = $isMerchant ? route('merchant.dashboard') : route('vendor.dashboard');
    $settingsRoute  = $isMerchant ? route('merchant.settings.index') : route('vendor.settings.index');
    $logoutRoute    = $isMerchant ? route('merchant.logout') : route('vendor.logout');
@endphp

<nav class="navbar-top topbarfull z-20 gap-3 bg-n0 py-3 shadow-sm duration-300 border-b border-n0 dark:bg-[#1E293B] dark:border-gray-700" id="topbar">
    <div class="topbar-inner flex items-center justify-between">
        
        <div class="flex grow items-center gap-4 xxl:gap-6">
            <a href="{{ $dashboardRoute }}" class="topbar-logo hidden shrink-0">
                <img width="174" height="38" src="{{ asset('assets/images/logo-with-text.png') }}" alt="Q4I Logo" class="logo-full2 hidden lg:block" />
            </a>
            
            <button class="flex items-center rounded-s-2xl bg-primary px-0.5 py-3 text-xl text-white" id="sidebar-toggle-btn">
                <i class="las la-angle-left text-lg"></i>
            </button>

            <form class="topnav-search hidden w-full max-w-xl sm:flex items-center rounded-full border border-n30 bg-primary/5 px-4 py-2 dark:border-gray-600 dark:bg-gray-800 transition-colors focus-within:border-primary">
                <i class="las la-search text-xl text-n100 dark:text-gray-400"></i>
                <input type="text" placeholder="Search transactions, orders, buyers..." class="w-full border-none bg-transparent px-3 py-1 text-sm focus:outline-none dark:text-white" />
            </form>
        </div>

        <div class="flex items-center gap-3 sm:gap-4 relative">
            
            <div class="relative sm:hidden">
                <button onclick="toggleNavMenu('mobile-search')" class="flex h-10 w-10 cursor-pointer select-none items-center justify-center rounded-full border border-n30 bg-primary/5">
                    <i class="las la-search"></i>
                </button>
                <div id="mobile-search" class="hidden absolute -left-10 top-full z-20 mt-2 w-64 rounded-xl bg-n0 p-3 shadow-lg dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                    <form class="flex w-full items-center rounded-full border border-primary bg-primary/5 px-3 py-2">
                        <input type="text" placeholder="Search..." class="w-full bg-transparent text-sm outline-none dark:text-white" />
                        <button type="submit" class="text-primary"><i class="las la-search text-lg"></i></button>
                    </form>
                </div>
            </div>

            <button id="darkModeToggle" aria-label="dark mode switch" class="h-10 w-10 shrink-0 rounded-full border border-n30 bg-primary/5 md:h-12 md:w-12 hover:bg-primary/10 transition-colors">
                <i class="las la-sun text-2xl dark:hidden!"></i>
                <span class="hidden! dark:block!">
                    <i class="las la-moon text-2xl text-white"></i>
                </span>
            </button>

            <div class="relative">
                <button onclick="toggleNavMenu('notification-menu')" class="relative h-10 w-10 rounded-full border border-n30 bg-primary/5 md:h-12 md:w-12 hover:bg-primary/10 transition-colors">
                    <i class="las la-bell text-2xl dark:text-gray-200"></i>
                    <span class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-[#EF4444] text-xs font-bold text-white shadow-sm">2</span>
                </button>
                <div id="notification-menu" class="hidden absolute top-full mt-3 z-50 w-[300px] rounded-xl bg-n0 shadow-xl border border-gray-100 dark:bg-gray-800 dark:border-gray-700 ltr:-right-[110px] sm:ltr:right-0 rtl:-left-[120px] sm:rtl:left-0">
                    <div class="flex items-center justify-between border-b border-n40 p-3 lg:px-4 dark:border-gray-700">
                        <h5 class="font-bold dark:text-white">Notifications</h5>
                        <a href="#" class="text-xs font-bold text-primary">View All</a>
                    </div>
                    <ul class="flex flex-col p-2 max-h-80 overflow-y-auto">
                        <div class="flex cursor-pointer gap-3 rounded-lg p-3 duration-300 hover:bg-primary/5 dark:hover:bg-gray-700">
                            <div class="flex size-10 items-center justify-center rounded-full bg-[#108981]/10 text-[#108981] shrink-0">
                                <i class="las la-wallet text-xl"></i>
                            </div>
                            <div class="text-sm">
                                <p class="font-bold text-[#1F2937] dark:text-gray-200">Withdrawal Processed</p>
                                <p class="text-xs text-[#64748B] dark:text-gray-400 mt-0.5">₦15,000 sent to your bank.</p>
                                <p class="text-[10px] text-n100 mt-1">Just now</p>
                            </div>
                        </div>
                        <div class="flex cursor-pointer gap-3 rounded-lg p-3 duration-300 hover:bg-primary/5 dark:hover:bg-gray-700">
                            <div class="flex size-10 items-center justify-center rounded-full bg-[#EF4444]/10 text-[#EF4444] shrink-0">
                                <i class="las la-gavel text-xl"></i>
                            </div>
                            <div class="text-sm">
                                <p class="font-bold text-[#1F2937] dark:text-gray-200">Order Disputed</p>
                                <p class="text-xs text-[#64748B] dark:text-gray-400 mt-0.5">Ref ESC-1234 has been frozen.</p>
                                <p class="text-[10px] text-n100 mt-1">1 hour ago</p>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>

            <div class="relative shrink-0">
                <div onclick="toggleNavMenu('profile-menu')" class="w-10 cursor-pointer md:w-12 rounded-full ring-2 ring-transparent hover:ring-primary transition-all">
                    <img src="{{ Auth::user()->store_logo ? asset('storage/' . Auth::user()->store_logo) : asset('assets/images/user-big-4.png') }}" class="rounded-full object-cover aspect-square border border-gray-200 dark:border-gray-600" width="48" height="48" alt="profile img" />
                </div>
                <div id="profile-menu" class="hidden absolute top-full mt-3 z-50 w-[240px] rounded-xl bg-n0 shadow-xl border border-gray-100 dark:bg-gray-800 dark:border-gray-700 right-0">
                    <div class="flex flex-col items-center border-b border-n40 p-4 text-center dark:border-gray-700">
                        <img src="{{ Auth::user()->store_logo ? asset('storage/' . Auth::user()->store_logo) : asset('assets/images/user-big-4.png') }}" width="60" height="60" class="rounded-full object-cover aspect-square shadow-sm" alt="profile img" />
                        <h6 class="font-black mt-2 text-[#0B3A75] dark:text-white">{{ Auth::user()->name ?? 'Q4I User' }}</h6>
                        <span class="text-xs text-[#64748B] dark:text-gray-400">
                            {{ !empty(Auth::user()->email) ? Auth::user()->email : (!empty(Auth::user()->phone) ? Auth::user()->phone : 'No email set') }}
                        </span>
                        <span class="mt-2 inline-flex items-center gap-1 rounded bg-[#108981]/10 px-2 py-0.5 text-[10px] font-black uppercase text-[#108981]">
                            {{ $isMerchant ? 'Corporate Merchant' : 'Vendor Account' }}
                        </span>
                    </div>
                    <ul class="flex flex-col p-2">
                        <li>
                            <a href="{{ $settingsRoute }}" class="flex items-center gap-3 rounded-lg p-2.5 text-sm font-semibold text-[#1F2937] duration-300 hover:bg-primary hover:text-white dark:text-gray-200">
                                <i class="las la-user-circle text-xl"></i> My Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ $settingsRoute }}" class="flex items-center gap-3 rounded-lg p-2.5 text-sm font-semibold text-[#1F2937] duration-300 hover:bg-primary hover:text-white dark:text-gray-200">
                                <i class="las la-cog text-xl"></i> Account Settings
                            </a>
                        </li>
                        <li class="my-1 border-t border-gray-100 dark:border-gray-700"></li>
                        <li>
                            <form method="POST" action="{{ $logoutRoute }}" id="logout-form" class="hidden">@csrf</form>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-3 rounded-lg p-2.5 text-sm font-bold text-[#EF4444] duration-300 hover:bg-[#EF4444] hover:text-white">
                                <i class="las la-sign-out-alt text-xl"></i> Secure Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
</nav>

<script>
    // --- 1. Dropdown Toggle Logic ---
    function toggleNavMenu(menuId) {
        const menu = document.getElementById(menuId);
        const isHidden = menu.classList.contains('hidden');
        
        // Close all dropdowns first
        document.getElementById('mobile-search').classList.add('hidden');
        document.getElementById('notification-menu').classList.add('hidden');
        document.getElementById('profile-menu').classList.add('hidden');
        
        // Open the clicked one
        if (isHidden) {
            menu.classList.remove('hidden');
        }
    }

    // Close dropdowns if user clicks outside of them
    document.addEventListener('click', function(event) {
        const isClickInside = event.target.closest('button[onclick^="toggleNavMenu"], div[id$="-menu"], div[id="mobile-search"]');
        if (!isClickInside) {
            document.getElementById('mobile-search').classList.add('hidden');
            document.getElementById('notification-menu').classList.add('hidden');
            document.getElementById('profile-menu').classList.add('hidden');
        }
    });

    // --- 2. Dark/Light Mode Engine ---
    const themeBtn = document.getElementById('darkModeToggle');
    const htmlElement = document.documentElement;

    // Check system preference or saved local storage on load
    if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        htmlElement.classList.add('dark');
    } else {
        htmlElement.classList.remove('dark');
    }

    // Toggle click event
    themeBtn.addEventListener('click', function() {
        htmlElement.classList.toggle('dark');
        
        if (htmlElement.classList.contains('dark')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    });
</script>