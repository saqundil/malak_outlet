<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ShowAdminUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:show-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show admin users credentials';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Admin Users ===');
        
        $adminUsers = User::where('is_admin', true)->get(['name', 'email']);
        
        if ($adminUsers->count() > 0) {
            foreach ($adminUsers as $admin) {
                $this->info("Name: {$admin->name}");
                $this->info("Email: {$admin->email}");
                $this->info("Password: admin123 (default)");
                $this->info("---");
            }
        } else {
            $this->info('No admin users found.');
            $this->info('Creating default admin user...');
            
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@malakoutlet.com',
                'password' => bcrypt('admin123'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]);
            
            $this->info('Admin user created:');
            $this->info('Email: admin@malakoutlet.com');
            $this->info('Password: admin123');
        }
        
        return Command::SUCCESS;
    }
}
