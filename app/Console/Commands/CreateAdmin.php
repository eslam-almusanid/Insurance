<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create {email} {password} {name?} {phone?} {national_id?}';
    protected $description = 'Create a new admin user';

    public function handle()
    {
        $this->info('Creating a new admin user...');

        $email = $this->argument('email');
        $password = $this->argument('password');
        $name = $this->argument('name') ?? $this->ask('What is the admin name?') ?? 'Admin';
        $phone = $this->argument('phone') ?? $this->ask('What is the admin phone?') ?? '01000000000';
        $nationalId = $this->argument('national_id') ?? $this->ask('What is the admin national ID? (optional)');

        try {
            $admin = Admin::create([
                'id' => Str::uuid(),
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'phone' => $phone,
                'national_id' => $nationalId,
                'status' => 'active',
            ]);

            $this->info('Admin created successfully!');
            $this->table(
                ['ID', 'Name', 'Email', 'Phone', 'Status'],
                [[$admin->id, $admin->name, $admin->email, $admin->phone, $admin->status]]
            );
        } catch (\Exception $e) {
            $this->error('Failed to create admin: ' . $e->getMessage());
        }
    }
} 