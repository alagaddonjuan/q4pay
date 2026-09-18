<aside id="sidebar" class="sidebar bg-white border-r border-slate-200 h-screen flex flex-col">
    
    <div class="h-[90px] flex items-center px-6 shrink-0 border-b border-slate-100 relative">
        <a href="{{ route('vendor.dashboard') ?? '/' }}" class="block">
            <img src="{{ asset('assets/images/logo-with-text.png') }}" class="h-10 w-auto" alt="Q4I Logo" />
        </a>
        <button class="sidebar-close-btn xl:hidden absolute right-4 text-slate-500" id="sidebar-close-btn">
            <i class="las la-times text-2xl"></i>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto px-4 py-6 flex flex-col gap-1" style="scrollbar-width: none;">
        
        <p class="px-4 text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 mt-2">Store Management</p>
        
        <a href="{{ url('/vendor/dashboard') }}" class="text-xs flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold transition-all duration-200 {{ request()->is('vendor/dashboard*') ? 'bg-[#0878F8] text-white shadow-lg shadow-[#0878F8]/20' : 'text-slate-600 hover:bg-[#0878F8]/10 hover:text-[#0878F8]' }}">
            <i class="las la-home text-2xl"></i> Dashboard
        </a>

        <a href="{{ url('/vendor/payment-links') }}" class="text-xs flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold transition-all duration-200 {{ request()->is('vendor/payment-links*') ? 'bg-[#0878F8] text-white shadow-lg shadow-[#0878F8]/20' : 'text-slate-600 hover:bg-[#0878F8]/10 hover:text-[#0878F8]' }}">
            <i class="las la-link text-2xl"></i> Payment Links
        </a>

        <a href="{{ route('vendor.orders.index') }}" class="text-xs flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold transition-all duration-200 {{ request()->is('vendor/escrow*') ? 'bg-[#0878F8] text-white shadow-lg shadow-[#0878F8]/20' : 'text-slate-600 hover:bg-[#0878F8]/10 hover:text-[#0878F8]' }}">
            <i class="las la-shield-alt text-2xl"></i> Escrow Orders
        </a>

        <a href="{{ route('vendor.products.index') }}" class="text-xs flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold transition-all duration-200 {{ request()->is('vendor/storefront*') ? 'bg-[#0878F8] text-white shadow-lg shadow-[#0878F8]/20' : 'text-slate-600 hover:bg-[#0878F8]/10 hover:text-[#0878F8]' }}">
            <i class="las la-store text-2xl"></i> Storefront
        </a>

        <a href="{{ url('/vendor/wallet') }}" class="text-xs flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold transition-all duration-200 {{ request()->is('vendor/wallet*') ? 'bg-[#0878F8] text-white shadow-lg shadow-[#0878F8]/20' : 'text-slate-600 hover:bg-[#0878F8]/10 hover:text-[#0878F8]' }}">
            <i class="las la-wallet text-2xl"></i> My Wallet
        </a>

        <p class="px-4 text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 mt-6">Account & Support</p>

        <a href="{{ url('/vendor/settings') }}" class="text-xs flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold transition-all duration-200 {{ request()->is('vendor/settings*') ? 'bg-[#0878F8] text-white shadow-lg shadow-[#0878F8]/20' : 'text-slate-600 hover:bg-[#0878F8]/10 hover:text-[#0878F8]' }}">
            <i class="las la-cog text-2xl"></i> Settings
        </a>

        <a href="{{ route('vendor.support.help-center') }}" class="text-xs flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold transition-all duration-200 {{ request()->routeIs('vendor.support.help-center') ? 'bg-[#0878F8] text-white shadow-lg shadow-[#0878F8]/20' : 'text-slate-600 hover:bg-[#0878F8]/10 hover:text-[#0878F8]' }}">
            <i class="las la-question-circle text-2xl"></i> Help Center
        </a>

        <a href="{{ route('vendor.support.contact') }}" class="text-xs flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold transition-all duration-200 {{ request()->routeIs('vendor.support.contact') ? 'bg-[#0878F8] text-white shadow-lg shadow-[#0878F8]/20' : 'text-slate-600 hover:bg-[#0878F8]/10 hover:text-[#0878F8]' }}">
            <i class="las la-headset text-2xl"></i> Support
        </a>

        <div class="mt-8 mb-6 border-t border-slate-100 pt-6">
            <form method="POST" action="{{ route('vendor.logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3.5 text-red-600 bg-red-50 hover:bg-red-600 hover:text-white transition-all duration-200 rounded-xl font-bold">
                    <i class="las la-sign-out-alt text-2xl"></i>
                    <span>Secure Logout</span>
                </button>
            </form>
        </div>
        
    </div>
</aside>