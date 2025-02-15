<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed users
        \App\Models\User::factory(10)->create();

        \App\Models\User::updateOrCreate([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Run additional seeders
        $this->call([
            BranchSeeder::class,
            DepartmentSeeder::class,
            EmployeeTypeSeeder::class,
            JobPositionSeeder::class,
            EmployeeSeeder::class,
        ]);
    }
}
