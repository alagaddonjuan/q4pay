<aside id="sidebar" class="sidebar bg-white border-r border-slate-200 h-screen flex flex-col">
    @php
        $isMerchant = auth('merchant')->check();
        $role = auth('team_member')->check() ? auth('team_member')->user()->role : null;
        $isAdmin = $isMerchant || $role === 'admin';
        $isFinance = $role === 'finance';
        $isDeveloper = $role === 'developer';
        $isSupport = $role === 'support';
    @endphp
    
    <div class="h-[90px] flex items-center px-6 shrink-0 border-b border-slate-100 relative">
        <a href="{{ route('merchant.dashboard') }}" class="block">
            <img src="{{ asset('assets/images/logo-with-text.png') }}" class="h-10 w-auto" alt="Q4I Logo" />
        </a>
        <button class="sidebar-close-btn xl:hidden absolute right-4 text-slate-500" id="sidebar-close-btn">
            <i class="las la-times text-2xl"></i>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto px-4 py-6 flex flex-col gap-1" style="scrollbar-width: none;">
        
        <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 mt-2">Corporate Gateway</p>
        
        <a href="{{ route('merchant.dashboard') }}" class="text-xs flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all duration-200 {{ request()->routeIs('merchant.dashboard') ? 'bg-[#D20103] text-white shadow-lg shadow-[#D20103]/20' : 'text-[#003366] hover:bg-[#D20103]/10 hover:text-[#D20103]' }}">
            <i class="las la-home text-xl"></i> Overview
        </a>

        <a href="{{ url('/merchant/virtual-accounts') }}" class="text-xs flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all duration-200 {{ request()->is('merchant/virtual-accounts*') ? 'bg-[#D20103] text-white shadow-lg shadow-[#D20103]/20' : 'text-[#003366] hover:bg-[#D20103]/10 hover:text-[#D20103]' }}">
            <i class="las la-university text-xl"></i> Virtual Accounts
        </a>

        @if($isAdmin || $isFinance || $isSupport)
        <a href="{{ url('/merchant/sub-agents') }}" class="text-xs flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all duration-200 {{ request()->is('merchant/sub-agents*') ? 'bg-[#D20103] text-white shadow-lg shadow-[#D20103]/20' : 'text-[#003366] hover:bg-[#D20103]/10 hover:text-[#D20103]' }}">
            <i class="las la-sitemap text-xl"></i> Sub-Agents
        </a>
        @endif

        <a href="{{ url('/merchant/ledger') }}" class="text-xs flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all duration-200 {{ request()->is('merchant/ledger*') ? 'bg-[#D20103] text-white shadow-lg shadow-[#D20103]/20' : 'text-[#003366] hover:bg-[#D20103]/10 hover:text-[#D20103]' }}">
            <i class="las la-exchange-alt text-xl"></i> Transaction Ledger
        </a>

        @if($isAdmin || $isFinance || $isSupport)
        <a href="{{ url('/merchant/settlements') }}" class="text-xs flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all duration-200 {{ request()->is('merchant/settlements*') ? 'bg-[#D20103] text-white shadow-lg shadow-[#D20103]/20' : 'text-[#003366] hover:bg-[#D20103]/10 hover:text-[#D20103]' }}">
            <i class="las la-money-check-alt text-xl"></i> Settlements
        </a>
        @endif

        @if($isAdmin || $isDeveloper)
        <a href="{{ url('/merchant/vas') }}" class="text-xs flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all duration-200 {{ request()->is('merchant/vas*') ? 'bg-[#D20103] text-white shadow-lg shadow-[#D20103]/20' : 'text-[#003366] hover:bg-[#D20103]/10 hover:text-[#D20103]' }}">
            <i class="las la-bolt text-xl"></i> Utility Kiosk
        </a>
        @endif

        @if($isAdmin || $isDeveloper)
        <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 mt-6">Developer</p>

        <a href="{{ route('merchant.api-keys.index') }}" class="text-xs flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all duration-200 {{ request()->routeIs('merchant.api-keys.*') ? 'bg-[#D20103] text-white shadow-lg shadow-[#D20103]/20' : 'text-[#003366] hover:bg-[#D20103]/10 hover:text-[#D20103]' }}">
            <i class="las la-key text-xl"></i> API Keys
        </a>

        <a href="{{ route('merchant.webhooks.index') }}" class="text-xs flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all duration-200 {{ request()->routeIs('merchant.webhooks.*') ? 'bg-[#D20103] text-white shadow-lg shadow-[#D20103]/20' : 'text-[#003366] hover:bg-[#D20103]/10 hover:text-[#D20103]' }}">
            <i class="las la-plug text-xl"></i> Webhooks
        </a>
        @endif

        <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 mt-6">Account & Support</p>

        @if($isAdmin)
        <a href="{{ url('/merchant/compliance') }}" class="text-xs flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all duration-200 {{ request()->is('merchant/compliance*') ? 'bg-[#D20103] text-white shadow-lg shadow-[#D20103]/20' : 'text-[#003366] hover:bg-[#D20103]/10 hover:text-[#D20103]' }}">
            <i class="las la-id-card text-xl"></i> Compliance
        </a>

        <a href="{{ route('merchant.team.index') }}" class="text-xs flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all duration-200 {{ request()->routeIs('merchant.team.*') ? 'bg-[#D20103] text-white shadow-lg shadow-[#D20103]/20' : 'text-[#003366] hover:bg-[#D20103]/10 hover:text-[#D20103]' }}">
            <i class="las la-users text-xl"></i> Team
        </a>
        @endif

        @if($isAdmin || $isDeveloper)
        <a href="{{ route('merchant.audit_logs.index') }}" class="text-xs flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all duration-200 {{ request()->routeIs('merchant.audit_logs.index') ? 'bg-[#D20103] text-white shadow-lg shadow-[#D20103]/20' : 'text-[#003366] hover:bg-[#D20103]/10 hover:text-[#D20103]' }}">
            <i class="las la-clipboard-list text-xl"></i> Audit Logs
        </a>
        @endif

        <a href="{{ route('merchant.support.help-center') }}" class="text-xs flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all duration-200 {{ request()->routeIs('merchant.support.help-center') ? 'bg-[#D20103] text-white shadow-lg shadow-[#D20103]/20' : 'text-[#003366] hover:bg-[#D20103]/10 hover:text-[#D20103]' }}">
            <i class="las la-question-circle text-xl"></i> Help Center
        </a>

        <a href="{{ route('merchant.support.contact') }}" class="text-xs flex items-center gap-3 px-4 py-3 rounded-xl font-bold transition-all duration-200 {{ request()->routeIs('merchant.support.contact') ? 'bg-[#D20103] text-white shadow-lg shadow-[#D20103]/20' : 'text-[#003366] hover:bg-[#D20103]/10 hover:text-[#D20103]' }}">
            <i class="las la-headset text-xl"></i> Contact NOC
        </a>


        <div class="mt-8 mb-6 border-t border-slate-100 pt-6">
            <form method="POST" action="{{ route('merchant.logout') }}">
                @csrf
                <button type="submit" class="w-full text-sm flex items-center gap-3 px-4 py-3 text-[#D20103] bg-red-50 hover:bg-[#D20103] hover:text-white transition-all duration-200 rounded-xl font-bold">
                    <i class="las la-sign-out-alt text-xl"></i>
                    <span>Secure Logout</span>
                </button>
            </form>
        </div>
        
    </div>
</aside>