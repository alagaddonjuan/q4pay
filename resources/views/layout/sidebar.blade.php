<!-- 🟢 Q4I 3D ALIVE LOGO CSS -->
<style>
    @keyframes float3d {
        0% { transform: translateY(0px) rotateX(0deg) rotateY(0deg); filter: drop-shadow(0 4px 6px rgba(8, 120, 248, 0.2)); }
        50% { transform: translateY(-4px) rotateX(6deg) rotateY(6deg); filter: drop-shadow(0 12px 15px rgba(8, 120, 248, 0.4)); }
        100% { transform: translateY(0px) rotateX(0deg) rotateY(0deg); filter: drop-shadow(0 4px 6px rgba(8, 120, 248, 0.2)); }
    }
    .logo-3d-alive {
        animation: float3d 4s ease-in-out infinite;
        transform-style: preserve-3d;
        perspective: 1000px;
    }
</style>

<div class="logo-container border-b border-[#D1D5DB] mb-4">
    <div class="logo-inner flex items-center justify-between px-6 py-5">
        <a href="{{ route('vendor.dashboard') }}" class="logo-wrapper flex items-center gap-3" style="text-decoration: none;">
            
            <!-- 🟢 PERMANENT 3D BOUNCY Q4 BLOCK -->
            <div class="flex items-center justify-center bg-[#0878F8] text-white rounded-xl h-11 w-11 font-black shadow-lg logo-3d-alive text-xl border border-blue-400/30">
                Q4
            </div>
            
            <!-- 🟢 GATEWAY TEXT -->
            <h2 class="text-2xl font-black tracking-tight m-0 text-[#0B3A75]">
                Gateway
            </h2>

        </a>
        
        <button class="sidebar-close-btn xl:hidden text-[#64748B] hover:text-[#0878F8] transition-colors" id="sidebar-close-btn">
            <i class="las la-times text-2xl"></i>
        </button>
    </div>
</div>
<aside id="sidebar" class="sidebar bg-[#F8FAFC] shadow-xl z-50 border-r border-[#D1D5DB]">
    <div class="sidebar-inner relative h-full flex flex-col">
        <div class="logo-column shrink-0">

            <div class="menu-container flex-1 overflow-y-auto pb-28">
                <div class="menu-wrapper px-4">
                    <p class="text-xs font-bold text-[#64748B] mb-4 px-4 uppercase tracking-widest">Vendor Portal</p>
                    <ul class="menu-ul space-y-2">
                        
                        <li>
                            <a href="{{ route('vendor.dashboard') }}" class="{{ request()->routeIs('vendor.dashboard') ? 'bg-[#0878F8] text-white shadow-md shadow-[#0878F8]/30' : 'text-[#1F2937] hover:bg-[#0878F8]/10 hover:text-[#0878F8]' }} flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-medium text-sm">
                                <i class="las la-home text-xl"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('vendor.orders.index') }}" class="{{ request()->routeIs('vendor.orders.*') ? 'bg-[#0878F8] text-white shadow-md shadow-[#0878F8]/30' : 'text-[#1F2937] hover:bg-[#0878F8]/10 hover:text-[#0878F8]' }} flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-medium text-sm">
                                <i class="las la-box text-xl"></i>
                                <span>Escrow Orders</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('vendor.products.index', 'vendor.products.create') }}" class="{{ request()->routeIs('vendor.products.*') ? 'bg-[#0878F8] text-white shadow-md shadow-[#0878F8]/30' : 'text-[#1F2937] hover:bg-[#0878F8]/10 hover:text-[#0878F8]' }} flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-medium text-sm">
                                <i class="las la-store text-xl"></i>
                                <span>My Products</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('vendor.wallet.index') }}" class="{{ request()->routeIs('vendor.wallet.*') ? 'bg-[#0878F8] text-white shadow-md shadow-[#0878F8]/30' : 'text-[#1F2937] hover:bg-[#0878F8]/10 hover:text-[#0878F8]' }} flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-medium text-sm">
                                <i class="las la-wallet text-xl"></i>
                                <span>Wallet & Payouts</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('vendor.settings.index') }}" class="{{ request()->routeIs('vendor.settings.*') ? 'bg-[#0878F8] text-white shadow-md shadow-[#0878F8]/30' : 'text-[#1F2937] hover:bg-[#0878F8]/10 hover:text-[#0878F8]' }} flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-medium text-sm">
                                <i class="las la-cog text-xl"></i>
                                <span>Store Settings</span>
                            </a>
                        </li>

                        <li class="border-t border-dashed border-[#D1D5DB] pt-4 mt-4">
                            <form action="/logout" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-[#EF4444] hover:bg-[#EF4444]/10 transition-colors font-medium text-sm">
                                    <i class="las la-sign-out-alt text-xl"></i>
                                    <span>Log Out</span>
                                </button>
                            </form>
                        </li>

                    </ul>
                </div>
            </div>

        </div>
    </div>
</aside>