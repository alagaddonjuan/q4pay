@extends('layout.merchant')
@section('title', 'Account Settings | Q4I Corporate Gateway')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div>
            <h2 class="h2 text-[#003366]"><i class="las la-cog mr-2"></i>Gateway Settings</h2>
            <p class="text-sm text-slate-500 mt-1">Manage your corporate profile, security, notifications, and preferences.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
                <div class="p-6 border-b border-slate-100 bg-slate-50">
                    <div class="flex items-center gap-4">
                        <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : (isset($user->logo) && $user->logo ? asset('storage/' . $user->logo) : asset('assets/images/user-big-4.png')) }}" class="size-16 rounded-full object-cover border-2 border-white shadow-sm" alt="Profile">
                        <div>
                            <h3 class="font-bold text-[#003366]">{{ $user->business_name ?? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: 'Corporate Admin' }}</h3>
                            <p class="text-xs text-slate-500">Merchant Account</p>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <nav class="flex flex-col gap-1" id="settings-nav">
                        <button onclick="switchTab('profile')" id="btn-profile" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl text-[#003366] bg-slate-100 transition-colors text-left">
                            <i class="las la-building text-xl"></i> Business Profile
                        </button>
                        <button onclick="switchTab('security')" id="btn-security" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl text-slate-500 hover:bg-slate-50 transition-colors text-left">
                            <i class="las la-shield-alt text-xl"></i> Security & Passwords
                        </button>
                        <button onclick="switchTab('notifications')" id="btn-notifications" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl text-slate-500 hover:bg-slate-50 transition-colors text-left">
                            <i class="las la-bell text-xl"></i> Notifications
                        </button>
                        <div class="my-2 border-t border-slate-100"></div>
                        <button onclick="switchTab('danger')" id="btn-danger" class="tab-btn w-full flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl text-red-600 hover:bg-red-50 transition-colors text-left">
                            <i class="las la-exclamation-triangle text-xl"></i> Danger Zone
                        </button>
                    </nav>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            
            <div id="tab-profile" class="tab-content block">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50 flex items-center gap-3">
                        <div class="size-10 rounded-full bg-[#003366]/10 flex items-center justify-center text-[#003366]">
                            <i class="las la-building text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-[#003366] text-lg">Business Profile</h3>
                    </div>
                    
                    <form action="{{ route('merchant.settings.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div class="col-span-2 flex items-center gap-4 mb-2">
                                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : (isset($user->logo) && $user->logo ? asset('storage/' . $user->logo) : asset('assets/images/user-big-4.png')) }}" class="size-16 rounded-full object-cover border border-slate-200">
                                <div>
                                    <label class="block text-sm font-bold text-[#003366] mb-1">Profile Picture</label>
                                    <input type="file" name="profile_picture" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#003366]/10 file:text-[#003366] hover:file:bg-[#003366]/20">
                                    @error('profile_picture')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-bold text-[#003366] mb-2">{{ isset($user->business_name) ? 'Business Name' : 'Full Name' }}</label>
                                <input type="text" name="business_name" value="{{ $user->business_name ?? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) }}" {{ isset($user->first_name) ? 'readonly' : '' }} class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#003366] focus:ring-2 focus:ring-[#003366]/20 outline-none">
                                @error('business_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-bold text-[#003366] mb-2">Login Email</label>
                                <input type="email" name="email" value="{{ $user->email ?? '' }}" readonly class="w-full text-sm bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-slate-500 cursor-not-allowed outline-none">
                            </div>
                        </div>

                        <div class="flex justify-end pt-4 border-t border-slate-100">
                            <button type="submit" class="px-6 py-2.5 bg-[#003366] hover:bg-blue-900 text-white font-bold rounded-xl shadow-sm transition-colors">
                                Save Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="tab-security" class="tab-content hidden">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6">
                    <div class="p-6 border-b border-slate-100 bg-slate-50 flex items-center gap-3">
                        <div class="size-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-600">
                            <i class="las la-lock text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-[#003366] text-lg">Change Password</h3>
                    </div>
                    
                    <form action="{{ route('merchant.settings.password.update') }}" method="POST" class="p-6">
                        @csrf
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-[#003366] mb-2">Current Password</label>
                            <input type="password" name="current_password" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#003366] outline-none">
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-[#003366] mb-2">New Password</label>
                            <input type="password" name="new_password" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#003366] outline-none">
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-[#003366] mb-2">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#003366] outline-none">
                        </div>
                        <div class="pt-4 border-t border-slate-100">
                            <button type="submit" class="w-full py-3 bg-[#D20103] hover:bg-red-800 text-white font-bold rounded-xl shadow-sm transition-colors">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6">
                    <div class="p-6 border-b border-slate-100 bg-slate-50 flex items-center gap-3">
                        <div class="size-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-600">
                            <i class="las la-shield-alt text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-[#003366] text-lg">Two-Factor Authentication (2FA)</h3>
                    </div>
                    
                    <div class="p-6">
                        @if($user->two_factor_enabled)
                            <div class="bg-green-50 text-green-700 p-4 rounded-xl text-sm mb-4 border border-green-200">
                                <i class="las la-check-circle mr-1"></i> Two-Factor Authentication is <strong>enabled</strong>. Your account is secured.
                            </div>
                            <form action="{{ route('merchant.settings.2fa.disable') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-[#003366] mb-2">Account Password to Disable</label>
                                    <input type="password" name="password" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#003366] outline-none">
                                </div>
                                <button type="submit" class="px-6 py-2.5 bg-red-100 text-red-600 font-bold rounded-xl shadow-sm hover:bg-red-200 transition-colors">
                                    Disable 2FA
                                </button>
                            </form>
                        @else
                            <div class="text-sm text-slate-600 mb-4 leading-relaxed">
                                Protect your account with Two-Factor Authentication. Scan the QR code below with your Authenticator App (like Google Authenticator or Authy) and enter the generated code.
                            </div>
                            
                            <div class="flex flex-col md:flex-row gap-6 mb-6">
                                <div class="bg-white p-2 border border-slate-200 rounded-xl inline-block mx-auto md:mx-0">
                                    {!! $QR_Image !!}
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-bold text-slate-500 uppercase mb-1">Manual Setup Key</p>
                                    <code class="block bg-slate-100 p-3 rounded-lg text-[#003366] font-mono text-sm break-all">{{ $secret }}</code>
                                    
                                    <form action="{{ route('merchant.settings.2fa.verify') }}" method="POST" class="mt-4">
                                        @csrf
                                        <label class="block text-sm font-bold text-[#003366] mb-2">Authenticator Code</label>
                                        <div class="flex gap-2">
                                            <input type="text" name="one_time_password" required placeholder="123456" class="flex-1 text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#003366] outline-none">
                                            <button type="submit" class="px-6 py-3 bg-[#003366] text-white font-bold rounded-xl shadow-sm hover:bg-blue-900 transition-colors">
                                                Verify & Enable
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div id="tab-notifications" class="tab-content hidden">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50 flex items-center gap-3">
                        <div class="size-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i class="las la-bell text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-[#003366] text-lg">Alert Preferences</h3>
                    </div>
                    
                    @php
                        $prefs = json_decode($user->notification_preferences, true) ?? [];
                    @endphp
                    <form action="{{ route('merchant.settings.notifications.update') }}" method="POST">
                        @csrf
                        <div class="p-6 space-y-6">
                            <h4 class="font-bold text-[#003366] text-sm uppercase tracking-wide border-b border-slate-100 pb-2">Event Types</h4>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-[#003366] mb-1">Login Alerts</p>
                                    <p class="text-xs text-slate-500">Get notified when someone logs into your account.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="notify_login" class="sr-only peer" {{ ($prefs['login'] ?? false) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#003366]"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-[#003366] mb-1">Inflow Transactions</p>
                                    <p class="text-xs text-slate-500">Alerts for successful deposits or payments received.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="notify_inflow" class="sr-only peer" {{ ($prefs['inflow'] ?? false) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#003366]"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-[#003366] mb-1">Outflow Transactions</p>
                                    <p class="text-xs text-slate-500">Alerts for withdrawals, transfers, and bill payments.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="notify_outflow" class="sr-only peer" {{ ($prefs['outflow'] ?? false) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#003366]"></div>
                                </label>
                            </div>

                            <h4 class="font-bold text-[#003366] text-sm uppercase tracking-wide border-b border-slate-100 pb-2 mt-8">Delivery Channels</h4>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-[#003366] mb-1">Email</p>
                                    <p class="text-xs text-slate-500">Receive alerts via your corporate email address.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="channel_email" class="sr-only peer" {{ ($prefs['channel_email'] ?? false) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#003366]"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-[#003366] mb-1">SMS</p>
                                    <p class="text-xs text-slate-500">Receive instant text messages for critical events.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="channel_sms" class="sr-only peer" {{ ($prefs['channel_sms'] ?? false) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#003366]"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-[#003366] mb-1">Dashboard (Bell Icon)</p>
                                    <p class="text-xs text-slate-500">Show alerts in the top navigation bar.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="channel_dashboard" class="sr-only peer" {{ ($prefs['channel_dashboard'] ?? true) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#003366]"></div>
                                </label>
                            </div>
                            
                            <div class="pt-4 border-t border-slate-100 flex justify-end">
                                <button type="submit" class="px-6 py-2.5 bg-[#003366] hover:bg-blue-900 text-white font-bold rounded-xl shadow-sm transition-colors">
                                    Save Preferences
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="tab-danger" class="tab-content hidden">
                <div class="bg-white rounded-2xl shadow-sm border border-red-200 overflow-hidden">
                    <div class="p-6 border-b border-red-100 bg-red-50 flex items-center gap-3">
                        <div class="size-10 rounded-full bg-red-200 flex items-center justify-center text-[#D20103]">
                            <i class="las la-exclamation-triangle text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-[#D20103] text-lg">Danger Zone</h3>
                    </div>
                    
                    <div class="p-6">
                        <p class="text-sm text-slate-600 mb-6 leading-relaxed">
                            Deleting your account is a permanent action. All API keys, virtual accounts, and pending settlements will be frozen immediately. You can cancel the deletion process within 14 days by contacting support.
                        </p>
                        
                        <label class="flex items-center gap-3 mb-6 cursor-pointer">
                            <input type="checkbox" class="w-5 h-5 rounded border-gray-300 text-[#D20103] focus:ring-[#D20103]">
                            <span class="text-sm font-bold text-slate-700">I confirm that I want to delete my corporate profile.</span>
                        </label>

                        <button disabled class="px-6 py-3 bg-slate-200 text-slate-400 font-bold rounded-xl cursor-not-allowed transition-colors w-full sm:w-auto">
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function switchTab(tabId) {
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.getElementById('tab-' + tabId).classList.remove('hidden');

        // Reset all buttons
        document.querySelectorAll('.tab-btn').forEach(el => {
            if(el.id === 'btn-danger') {
                el.className = "tab-btn w-full flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl text-red-600 hover:bg-red-50 transition-colors text-left";
            } else {
                el.className = "tab-btn w-full flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl text-slate-500 hover:bg-slate-50 transition-colors text-left";
            }
        });

        // Highlight active button
        const activeBtn = document.getElementById('btn-' + tabId);
        if(tabId === 'danger') {
            activeBtn.classList.add('bg-red-100');
        } else {
            activeBtn.classList.remove('text-slate-500', 'hover:bg-slate-50');
            activeBtn.classList.add('text-[#003366]', 'bg-slate-100');
        }
    }
</script>
@endsection