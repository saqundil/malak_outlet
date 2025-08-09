<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:update-user {email=admin@malakoutlet.com}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user to be admin and set password';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if ($user) {
            $user->update([
                'is_admin' => true,
                'password' => Hash::make('admin123'),
            ]);
            
            $this->info("Updated user: {$user->name} ({$user->email})");
            $this->info("Set as admin with password: admin123");
        } else {
            $this->info("User with email {$email} not found.");
            $this->info("Creating new admin user...");
            
            $user = User::create([
                'name' => 'Administrator',
                'email' => $email,
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]);
            
            $this->info("Created admin user: {$user->email}");
            $this->info("Password: admin123");
        }
        
        // Show all admin users
        $this->info("\n=== All Admin Users ===");
        $adminUsers = User::where('is_admin', true)->get(['name', 'email']);
        
        foreach ($adminUsers as $admin) {
            $this->info("- {$admin->name} ({$admin->email})");
        }
        
        return Command::SUCCESS;
    }
}
