<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run()
    {
        $branches = [
            [
                'branch_name' => 'Daraga Office',
                'branch_code' => 'DAR001',
                'branch_address' => 'Daraga, Albay',
                'branch_phone' => '09123456789',
                'branch_email' => 'daraga@example.com',
                'branch_manager' => 'Juan Dela Cruz'
            ],
            [
                'branch_name' => 'Legazpi Office',
                'branch_code' => 'LEG002',
                'branch_address' => 'Legazpi City, Albay',
                'branch_phone' => '09129876543',
                'branch_email' => 'legazpi@example.com',
                'branch_manager' => 'Maria Santos'
            ],
            [
                'branch_name' => 'Camalig Office',
                'branch_code' => 'CAM003',
                'branch_address' => 'Camalig, Albay',
                'branch_phone' => '09127654321',
                'branch_email' => 'camalig@example.com',
                'branch_manager' => 'Pedro Ramos'
            ],
            [
                'branch_name' => 'Tabaco Office',
                'branch_code' => 'TAB004',
                'branch_address' => 'Tabaco City, Albay',
                'branch_phone' => '09126543210',
                'branch_email' => 'tabaco@example.com',
                'branch_manager' => 'Ana Dizon'
            ],
            [
                'branch_name' => 'Polangui Office',
                'branch_code' => 'POL005',
                'branch_address' => 'Polangui, Albay',
                'branch_phone' => '09125432109',
                'branch_email' => 'polangui@example.com',
                'branch_manager' => 'Carlos Mendoza'
            ],
            [
                'branch_name' => 'Sorsogon Office',
                'branch_code' => 'SOR006',
                'branch_address' => 'Sorsogon City, Sorsogon',
                'branch_phone' => '09124321098',
                'branch_email' => 'sorsogon@example.com',
                'branch_manager' => 'Roberto Cruz'
            ],
            [
                'branch_name' => 'Masbate Office',
                'branch_code' => 'MAS007',
                'branch_address' => 'Masbate City, Masbate',
                'branch_phone' => '09123210987',
                'branch_email' => 'masbate@example.com',
                'branch_manager' => 'Lourdes Reyes'
            ],
        ];

        Branch::insert($branches);
    }
}
