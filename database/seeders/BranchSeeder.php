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
            ['branch_name' => 'Main Branch'],
            ['branch_name' => 'East Branch'],
            ['branch_name' => 'West Branch'],
        ];

        Branch::insert($branches);
    }
}
