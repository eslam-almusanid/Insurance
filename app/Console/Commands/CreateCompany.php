<?php

namespace App\Console\Commands;

use App\Enums\TokenTypesEnum;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateCompany extends Command
{
    protected $signature = 'create:company {email} {password} {name?} {phone?} {national_id?}';
    protected $description = 'Create a new company user';

    public function handle()
    {
        $this->info('Creating a new company user...');

        $email = $this->argument('email');
        $password = $this->argument('password');
        $name = $this->argument('name') ?? $this->ask('What is the company name?') ?? 'Company';
        $phone = $this->argument('phone') ?? $this->ask('What is the company phone?') ?? '05000000000';
        $nationalId = $this->argument('national_id') ?? $this->ask('What is the company national ID? (optional)');

        try {
            $company = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'phone' => $phone,
                'national_id' => $nationalId,
                'role' => TokenTypesEnum::COMPANY,
                'status' => 'active',
            ]);

            $this->info('Company created successfully!');
            $this->table(
                ['Name', 'Email', 'Phone', 'Status'],
                [[$company->name, $company->email, $company->phone, $company->status]]
            );
        } catch (\Exception $e) {
            $this->error('Failed to create company: ' . $e->getMessage());
        }
    }
} 