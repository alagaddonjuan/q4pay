@extends('layout.vendor')

@section('content')

    <!-- 🟢 Q4I BRAND COLOR OVERRIDES -->
    <style>
        .box { background-color: #FFFFFF !important; border: 1px solid #D1D5DB !important; border-radius: 1rem; padding: 1.5rem; transition: all 0.3s ease; }
        .box:hover { border-color: rgba(8, 120, 248, 0.3) !important; box-shadow: 0 4px 12px rgba(8, 120, 248, 0.05); }
        .bb-dashed { border-bottom: 1px dashed #D1D5DB !important; }
        .h2, .h4 { color: #0B3A75 !important; font-weight: 900 !important; }
        .text-q4i-primary { color: #0878F8 !important; }
        
        .btn-q4i-primary { 
            background-color: #0878F8 !important; 
            color: #FFFFFF !important; 
            transition: all 0.3s ease; 
            box-shadow: 0 4px 6px -1px rgba(8, 120, 248, 0.3); 
        }
        .btn-q4i-primary:hover { 
            background-color: #0B3A75 !important; 
            transform: translateY(-1px); 
            box-shadow: 0 6px 8px -1px rgba(11, 58, 117, 0.3);
        }
        
        .btn-outline-q4i { 
            border: 1px solid #D1D5DB; 
            color: #1F2937; 
            background-color: #FFFFFF;
            transition: all 0.3s ease; 
        }
        .btn-outline-q4i:hover { 
            border-color: #0878F8; 
            color: #0878F8; 
            background-color: rgba(8, 120, 248, 0.05);
        }
        
        .input-q4i:focus {
            border-color: #0878F8 !important;
            box-shadow: 0 0 0 1px #0878F8 !important;
        }

        /* Custom Toggle Switch Styles */
        .toggle-checkbox:checked + .toggle-label-email { background-color: #0878F8; }
        .toggle-checkbox:checked + .toggle-label-wa { background-color: #25D366; }
        .toggle-checkbox:checked + .toggle-label-email .toggle-dot,
        .toggle-checkbox:checked + .toggle-label-wa .toggle-dot { transform: translateX(100%); }
    </style>

    <div class="main-inner bg-[#F8FAFC] min-h-screen p-4 lg:p-6">
        
        <!-- HEADER -->
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div>
                <h2 class="h2 mb-1 text-3xl font-black">Store Settings</h2>
                <p class="text-sm text-[#64748B]">Manage your business profile, security, and notification preferences.</p>
            </div>
        </div>

        <!-- ALERTS -->
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-xl border border-[#108981]/20 bg-[#108981]/10 p-4 text-[#108981] shadow-sm">
                <i class="las la-check-circle text-2xl"></i>
                <p class="font-bold text-sm">{{ session('success') }}</p>
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 flex items-center gap-3 rounded-xl border border-[#EF4444]/20 bg-[#EF4444]/10 p-4 text-[#EF4444] shadow-sm">
                <i class="las la-exclamation-circle text-2xl"></i>
                <p class="font-bold text-sm">{{ $errors->first() }}</p>
            </div>
        @endif

        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            
            <!-- LEFT COLUMN: Business Profile -->
            <div class="col-span-12 lg:col-span-7">
                <div class="box mb-6">
                    <h4 class="h4 mb-6 bb-dashed pb-4 text-xl">Business Profile</h4>
                    
                    <form action="{{ route('vendor.settings.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Logo Upload -->
                        <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center gap-6 bg-[#F8FAFC] p-5 rounded-xl border border-[#D1D5DB]">
                            <div class="flex size-24 shrink-0 items-center justify-center rounded-full bg-[#0878F8]/10 text-[#0878F8] border-2 border-dashed border-[#0878F8]/50 text-3xl font-black overflow-hidden relative shadow-inner">
                                @if(Auth::check() && Auth::user()->profile_picture)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" id="profilePreview" class="w-full h-full object-cover" alt="Profile Picture">
                                    <span id="profileInitials" style="display: none;">{{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}</span>
                                @elseif(Auth::check() && Auth::user()->store_logo)
                                    <img src="{{ asset('storage/' . Auth::user()->store_logo) }}" id="profilePreview" class="w-full h-full object-cover" alt="Store Logo">
                                    <span id="profileInitials" style="display: none;">{{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}</span>
                                @else
                                    <img src="" id="profilePreview" class="w-full h-full object-cover hidden" alt="Profile Picture">
                                    <span id="profileInitials">{{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}</span>
                                @endif
                            </div>
                            
                            <div class="flex-1 w-full grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h5 class="font-bold text-[#1F2937] mb-1">Store Logo</h5>
                                    <p class="text-xs font-medium text-[#64748B] mb-2">For your receipts & store page</p>
                                    <input type="file" name="store_logo" id="store_logo_input" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#0878F8]/10 file:text-[#0878F8] hover:file:bg-[#0878F8]/20" accept="image/png, image/jpeg, image/webp" onchange="previewImage(event)">
                                </div>
                                
                                <div>
                                    <h5 class="font-bold text-[#1F2937] mb-1">Profile Picture</h5>
                                    <p class="text-xs font-medium text-[#64748B] mb-2">For your dashboard display</p>
                                    <input type="file" name="profile_picture" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#0878F8]/10 file:text-[#0878F8] hover:file:bg-[#0878F8]/20" accept="image/png, image/jpeg, image/webp" onchange="previewImage(event)">
                                </div>
                            </div>
                        </div>

                        <!-- Profile Inputs -->
                        <div class="grid grid-cols-2 gap-5 mb-6">
                            <div class="col-span-2">
                                <label class="mb-2 block font-bold text-[#1F2937]">Store Name <span class="text-[#EF4444]">*</span></label>
                                <input type="text" name="name" value="{{ Auth::user()->name ?? '' }}" class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-medium text-[#1F2937]">
                            </div>
                            
                            <div class="col-span-2 sm:col-span-1">
                                <label class="mb-2 block font-bold text-[#1F2937]">Email Address</label>
                                <input type="email" name="email" value="{{ Auth::user()->email ?? '' }}" readonly class="w-full rounded-xl border border-[#D1D5DB] bg-[#E2E8F0]/50 px-4 py-3 text-sm font-medium text-[#94A3B8] outline-none cursor-not-allowed">
                                <p class="text-xs font-bold text-[#108981] mt-2 flex items-center gap-1"><i class="las la-check-circle text-sm"></i> Verified Email</p>
                            </div>
                            
                            <div class="col-span-2 sm:col-span-1">
                                <label class="mb-2 block font-bold text-[#1F2937]">Phone Number</label>
                                <input type="text" name="phone" value="{{ Auth::user()->phone ?? '' }}" placeholder="+234..." class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-medium text-[#1F2937]">
                            </div>
                        </div>

                        <button type="submit" class="btn-q4i-primary w-full py-3.5 rounded-xl mt-2 font-bold text-lg flex justify-center items-center gap-2">
                            <i class="las la-save text-xl"></i> Save Profile Changes
                        </button>
                    </form>
                </div>
            </div>

            <!-- RIGHT COLUMN: Security & Notifications -->
            <div class="col-span-12 lg:col-span-5 space-y-6">
                
                <!-- Security Section -->
                <div class="box">
                    <h4 class="h4 mb-6 bb-dashed pb-4 text-xl">Security</h4>
                    <form action="{{ route('vendor.settings.password.update') }}" method="POST">
                        @csrf
                        <div class="space-y-5">
                            <div>
                                <label class="mb-2 block font-bold text-[#1F2937]">Current Password</label>
                                <input type="password" name="current_password" placeholder="••••••••" class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-bold text-[#1F2937] tracking-widest">
                            </div>
                            <div>
                                <label class="mb-2 block font-bold text-[#1F2937]">New Password</label>
                                <input type="password" name="new_password" placeholder="••••••••" class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-bold text-[#1F2937] tracking-widest">
                            </div>
                            
                            <button type="submit" class="btn-outline-q4i w-full py-3.5 rounded-xl font-bold text-base mt-2 flex justify-center items-center gap-2">
                                <i class="las la-lock text-xl"></i> Update Password
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-8 pt-8 border-t border-dashed border-[#D1D5DB]">
                        <h5 class="font-bold text-[#1F2937] text-lg mb-4">Two-Factor Authentication (2FA)</h5>
                        
                        @if($user->two_factor_enabled)
                            <div class="bg-green-50 text-green-700 p-4 rounded-xl text-sm mb-4 border border-green-200">
                                <i class="las la-check-circle mr-1"></i> Two-Factor Authentication is <strong>enabled</strong>. Your account is secured.
                            </div>
                            <form action="{{ route('vendor.settings.2fa.disable') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-[#1F2937] mb-2">Account Password to Disable</label>
                                    <input type="password" name="password" required class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-bold text-[#1F2937] tracking-widest">
                                </div>
                                <button type="submit" class="btn-outline-q4i !border-red-200 !text-red-600 hover:!bg-red-50 hover:!border-red-300 w-full py-3.5 rounded-xl font-bold text-base flex justify-center items-center gap-2">
                                    Disable 2FA
                                </button>
                            </form>
                        @else
                            <div class="text-sm text-slate-600 mb-4 leading-relaxed">
                                Protect your account with Two-Factor Authentication. Scan the QR code below with your Authenticator App (like Google Authenticator or Authy) and enter the generated code.
                            </div>
                            
                            <div class="flex flex-col gap-6 mb-6">
                                <div class="bg-white p-2 border border-[#D1D5DB] rounded-xl inline-block self-start">
                                    {!! $QR_Image !!}
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-bold text-slate-500 uppercase mb-1">Manual Setup Key</p>
                                    <code class="block bg-[#F8FAFC] p-3 rounded-lg text-[#0878F8] font-mono text-sm break-all border border-[#D1D5DB]">{{ $secret }}</code>
                                    
                                    <form action="{{ route('vendor.settings.2fa.verify') }}" method="POST" class="mt-4">
                                        @csrf
                                        <label class="block text-sm font-bold text-[#1F2937] mb-2">Authenticator Code</label>
                                        <div class="flex gap-2">
                                            <input type="text" name="one_time_password" required placeholder="123456" class="input-q4i w-full rounded-xl border border-[#D1D5DB] bg-[#F8FAFC] px-4 py-3 text-sm outline-none transition-all font-bold text-[#1F2937]">
                                            <button type="submit" class="btn-q4i-primary px-6 py-3 rounded-xl font-bold shadow-sm whitespace-nowrap">
                                                Verify & Enable
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Notifications Section -->
                <div class="box">
                    <h4 class="h4 mb-6 bb-dashed pb-4 text-xl">Notifications</h4>
                    
                    @php
                        $prefs = json_decode($user->notification_preferences, true) ?? [];
                    @endphp
                    <form action="{{ route('vendor.settings.notifications.update') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            
                            <h5 class="font-bold text-[#1F2937] text-sm uppercase tracking-wide border-b border-[#D1D5DB] pb-2">Event Types</h5>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-[#1F2937] mb-1">Login Alerts</p>
                                    <p class="text-xs font-medium text-[#64748B]">Get notified when someone logs into your account.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="notify_login" class="sr-only toggle-checkbox peer" {{ ($prefs['login'] ?? false) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-[#D1D5DB] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0878F8]"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-[#1F2937] mb-1">Inflow Transactions</p>
                                    <p class="text-xs font-medium text-[#64748B]">Alerts for successful deposits or payments received.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="notify_inflow" class="sr-only toggle-checkbox peer" {{ ($prefs['inflow'] ?? false) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-[#D1D5DB] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0878F8]"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-[#1F2937] mb-1">Outflow Transactions</p>
                                    <p class="text-xs font-medium text-[#64748B]">Alerts for withdrawals, transfers, and bill payments.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="notify_outflow" class="sr-only toggle-checkbox peer" {{ ($prefs['outflow'] ?? false) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-[#D1D5DB] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0878F8]"></div>
                                </label>
                            </div>

                            <h5 class="font-bold text-[#1F2937] text-sm uppercase tracking-wide border-b border-[#D1D5DB] pb-2 mt-8">Delivery Channels</h5>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-[#1F2937] mb-1">Email</p>
                                    <p class="text-xs font-medium text-[#64748B]">Receive alerts via your corporate email address.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="channel_email" class="sr-only toggle-checkbox peer" {{ ($prefs['channel_email'] ?? false) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-[#D1D5DB] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0878F8]"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-[#1F2937] mb-1">SMS</p>
                                    <p class="text-xs font-medium text-[#64748B]">Receive instant text messages for critical events.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="channel_sms" class="sr-only toggle-checkbox peer" {{ ($prefs['channel_sms'] ?? false) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-[#D1D5DB] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0878F8]"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-[#1F2937] mb-1">Dashboard (Bell Icon)</p>
                                    <p class="text-xs font-medium text-[#64748B]">Show alerts in the top navigation bar.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="channel_dashboard" class="sr-only toggle-checkbox peer" {{ ($prefs['channel_dashboard'] ?? true) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-[#D1D5DB] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0878F8]"></div>
                                </label>
                            </div>
                            
                            <div class="pt-4 border-t border-[#D1D5DB]">
                                <button type="submit" class="btn-q4i-primary w-full py-3.5 rounded-xl mt-2 font-bold text-lg flex justify-center items-center gap-2">
                                    <i class="las la-save text-xl"></i> Save Preferences
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Image Preview Script -->
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const preview = document.getElementById('profilePreview');
                const initials = document.getElementById('profileInitials');
                
                preview.src = reader.result;
                preview.classList.remove('hidden'); // Show the uploaded image
                
                if(initials) {
                    initials.style.display = 'none'; // Hide the initials
                }
            }
            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
@endsection