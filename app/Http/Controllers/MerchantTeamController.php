<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MerchantTeamMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\TeamMemberInvite;
use App\Mail\TeamMemberSetupComplete;
use App\Traits\AuditLogger;

class MerchantTeamController extends Controller
{
    use AuditLogger;
    public function index()
    {
        $user = Auth::user();
        $merchantId = $user instanceof MerchantTeamMember ? $user->merchant_id : $user->id;

        $teamMembers = MerchantTeamMember::where('merchant_id', $merchantId)->get();

        return view('merchant.team.index', compact('teamMembers'));
    }

    public function store(Request $request)
    {
        $user = Auth::guard('team_member')->check() ? Auth::guard('team_member')->user() : Auth::guard('merchant')->user();
        $merchantId = $user instanceof \App\Models\MerchantTeamMember ? $user->merchant_id : $user->id;

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:merchant_team_members,email',
            'role' => 'required|in:admin,finance,developer,support',
        ]);

        $token = Str::random(64);

        $member = MerchantTeamMember::create([
            'merchant_id' => $merchantId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => 'invited',
            'invite_token' => $token,
        ]);

        try {
            Mail::to($member->email)->send(new TeamMemberInvite($member));
            $this->logAuditAction('invited_team_member', 'team', "Invited team member: {$member->email} with role {$member->role}");
            return back()->with('success', 'Team member invited successfully.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Team Invite Email Failed: " . $e->getMessage());
            $this->logAuditAction('invited_team_member', 'team', "Added team member: {$member->email} with role {$member->role}, but email failed to send.");
            return back()->with('error', 'Team member added, but the email failed to send due to SMTP configuration. Please check your email settings.');
        }
    }

    public function resend($id)
    {
        $user = Auth::user();
        $merchantId = $user instanceof MerchantTeamMember ? $user->merchant_id : $user->id;

        $member = MerchantTeamMember::where('merchant_id', $merchantId)->where('id', $id)->firstOrFail();

        if ($member->status === 'invited') {
            try {
                Mail::to($member->email)->send(new TeamMemberInvite($member));
                $this->logAuditAction('resent_team_invite', 'team', "Resent invite to team member: {$member->email}");
                return back()->with('success', 'Invitation resent successfully.');
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Team Invite Resend Email Failed: " . $e->getMessage());
                return back()->with('error', 'Failed to send the email due to SMTP configuration. Please check your email settings.');
            }
        }

        return back()->with('error', 'Cannot resend invite to this user.');
    }

    public function suspend($id)
    {
        $user = Auth::user();
        $merchantId = $user instanceof MerchantTeamMember ? $user->merchant_id : $user->id;

        $member = MerchantTeamMember::where('merchant_id', $merchantId)->where('id', $id)->firstOrFail();

        if ($member->status === 'active') {
            $member->update(['status' => 'suspended']);
            $this->logAuditAction('suspended_team_member', 'team', "Suspended team member: {$member->email}");
            return back()->with('success', 'Team member suspended.');
        } elseif ($member->status === 'suspended') {
            $member->update(['status' => 'active']);
            $this->logAuditAction('reactivated_team_member', 'team', "Reactivated team member: {$member->email}");
            return back()->with('success', 'Team member reactivated.');
        }

        return back()->with('error', 'Cannot change status of an invited user.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $merchantId = $user instanceof MerchantTeamMember ? $user->merchant_id : $user->id;

        $member = MerchantTeamMember::where('merchant_id', $merchantId)->where('id', $id)->firstOrFail();
        $email = $member->email;
        $member->delete();

        $this->logAuditAction('removed_team_member', 'team', "Removed team member: {$email}");
        return back()->with('success', 'Team member removed successfully.');
    }

    public function acceptInviteForm($token)
    {
        $member = MerchantTeamMember::where('invite_token', $token)->where('status', 'invited')->firstOrFail();

        return view('merchant.team.accept-invite', compact('member'));
    }

    public function acceptInvite(Request $request, $token)
    {
        $member = MerchantTeamMember::where('invite_token', $token)->where('status', 'invited')->firstOrFail();

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
            'transaction_pin' => 'required|digits:4'
        ]);

        $member->update([
            'password' => Hash::make($request->password),
            'transaction_pin' => Hash::make($request->transaction_pin),
            'status' => 'active',
            'invite_token' => null,
        ]);

        try {
            Mail::to($member->email)->send(new TeamMemberSetupComplete($member));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Team Member Setup Complete Email Failed: " . $e->getMessage());
            // We still proceed even if email fails
        }

        return redirect()->route('merchant.login')->with('success', 'Account created successfully! You can now log in.');
    }
}
