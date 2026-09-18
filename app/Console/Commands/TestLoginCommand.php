<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class TestLoginCommand extends Command
{
    protected $signature = 'test:login {email} {password}';
    protected $description = 'Test team member login';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $result = Auth::guard('team_member')->attempt(['email' => $email, 'password' => $password]);
        
        if ($result) {
            $this->info("Login successful for team_member!");
        } else {
            $this->error("Login failed for team_member!");
            $member = \App\Models\MerchantTeamMember::where('email', $email)->first();
            if ($member) {
                $this->line("Member exists. DB hash: " . $member->password);
                $this->line("Hash check result: " . (\Illuminate\Support\Facades\Hash::check($password, $member->password) ? 'YES' : 'NO'));
            } else {
                $this->line("Member does not exist in DB.");
            }
        }
    }
}
