<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateAllDatabases extends Command
{
    protected $signature = 'migrate:all {--fresh : Drop all tables and re-run migrations}';
    protected $description = 'Migrate all databases (user_db, vehicle_db, insurance_db, shared_db)';

    public function handle()
    {
        $databases = [
            'shared_db' => 'database/migrations/shared_db',
            'user_db' => 'database/migrations/user_db',
            'vehicle_db' => 'database/migrations/vehicle_db',
            'insurance_db' => 'database/migrations/insurance_db',
        ];

        $option = $this->option('fresh') ? 'fresh' : 'migrate';

        foreach ($databases as $db => $path) {
            $this->info("Migrating $db...");
            $this->call("migrate:$option", [
                '--database' => $db,
                '--path' => $path,
                '--verbose' => true,
            ]);
        }

        $this->info('All databases migrated successfully!');
    }
}
