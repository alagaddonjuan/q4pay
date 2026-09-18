@extends('layout.merchant')
@section('title', 'Team Management | Q4I Corporate Gateway')

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div>
            <h2 class="h2 text-[#003366]"><i class="las la-users mr-2"></i>Team Management</h2>
            <p class="text-sm text-slate-500 mt-1">Manage users, roles, and access to your corporate gateway.</p>
        </div>
        <button onclick="document.getElementById('inviteModal').classList.remove('hidden')" class="btn btn-primary bg-[#003366] hover:bg-blue-900 text-white font-bold py-2.5 px-5 rounded-xl shadow-sm transition-colors flex items-center gap-2">
            <i class="las la-plus text-lg"></i> Invite Member
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-700 p-4 rounded-xl text-sm mb-6 border border-green-200 flex items-center gap-2">
            <i class="las la-check-circle text-xl"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 text-red-700 p-4 rounded-xl text-sm mb-6 border border-red-200 flex items-center gap-2">
            <i class="las la-exclamation-circle text-xl"></i> {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-500">
                <thead class="bg-slate-50 text-xs font-bold text-[#003366] uppercase">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($teamMembers as $member)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-[#003366]">{{ $member->first_name }} {{ $member->last_name }}</div>
                            <div class="text-xs text-slate-400">{{ $member->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 capitalize">
                                {{ $member->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($member->status === 'active')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Active
                                </span>
                            @elseif($member->status === 'invited')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Invited
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Suspended
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($member->status === 'invited')
                                    <form action="{{ route('merchant.team.resend', $member->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-medium p-2 hover:bg-blue-50 rounded-lg transition-colors" title="Resend Invite">
                                            <i class="las la-paper-plane text-xl"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                @if($member->status !== 'invited')
                                    <form action="{{ route('merchant.team.suspend', $member->id) }}" method="POST">
                                        @csrf
                                        @if($member->status === 'active')
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium p-2 hover:bg-yellow-50 rounded-lg transition-colors" title="Suspend User">
                                                <i class="las la-ban text-xl"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-medium p-2 hover:bg-green-50 rounded-lg transition-colors" title="Reactivate User">
                                                <i class="las la-check-circle text-xl"></i>
                                            </button>
                                        @endif
                                    </form>
                                @endif

                                <form action="{{ route('merchant.team.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this team member? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium p-2 hover:bg-red-50 rounded-lg transition-colors" title="Remove User">
                                        <i class="las la-trash-alt text-xl"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                            <div class="size-16 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-3 text-slate-400">
                                <i class="las la-users text-3xl"></i>
                            </div>
                            <p class="font-medium">No team members yet.</p>
                            <p class="text-xs mt-1">Invite your team to collaborate.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Invite Modal -->
<div id="inviteModal" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full overflow-hidden" style="max-width: 500px;">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h3 class="font-bold text-[#003366] text-lg">Invite Team Member</h3>
            <button onclick="document.getElementById('inviteModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <i class="las la-times text-2xl"></i>
            </button>
        </div>
        <form action="{{ route('merchant.team.store') }}" method="POST" class="p-6">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-bold text-[#003366] mb-2">First Name</label>
                    <input type="text" name="first_name" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#003366] outline-none">
                </div>
                <div>
                    <label class="block text-sm font-bold text-[#003366] mb-2">Last Name</label>
                    <input type="text" name="last_name" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#003366] outline-none">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold text-[#003366] mb-2">Email Address</label>
                <input type="email" name="email" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#003366] outline-none">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-bold text-[#003366] mb-2">Assigned Role</label>
                <select name="role" required class="w-full text-sm bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:bg-white focus:border-[#003366] outline-none">
                    <option value="admin">Administrator (Full Access)</option>
                    <option value="finance">Finance (Settlements & Reports)</option>
                    <option value="developer">Developer (API Keys & Webhooks)</option>
                    <option value="support">Support (View Orders & Resolve Disputes)</option>
                </select>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('inviteModal').classList.add('hidden')" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-6 py-2.5 bg-[#003366] hover:bg-blue-900 text-white font-bold rounded-xl shadow-sm transition-colors flex items-center gap-2">
                    <i class="las la-paper-plane"></i> Send Invite
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
