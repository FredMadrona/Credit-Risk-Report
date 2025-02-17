<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clients')->insert([
            [
                'first_name' => 'John',
                'middle_name' => 'A.',
                'last_name' => 'Doe',
                'birthday' => '1990-05-15',
                'applied_date' => Carbon::now()->subDays(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Jane',
                'middle_name' => null,
                'last_name' => 'Smith',
                'birthday' => '1985-08-22',
                'applied_date' => Carbon::now()->subDays(20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Michael',
                'middle_name' => 'B.',
                'last_name' => 'Jordan',
                'birthday' => '1992-12-03',
                'applied_date' => Carbon::now()->subDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
