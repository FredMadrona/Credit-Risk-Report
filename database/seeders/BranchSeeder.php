<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run()
    {
        $branches = [
            ['name' => 'Daraga Office'],
            ['name' => 'Legazpi Office'],
            ['name' => 'Camalig Office'],
            ['name' => 'Tabaco Office'],
            ['name' => 'Polangui Office'],
            ['name' => 'Sorsogon Office'],
            ['name' => 'Masbate Office'],



        ];

        Branch::insert($branches);
    }
}
