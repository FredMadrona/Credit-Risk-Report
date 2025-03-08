<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Ensure the "Admin" role exists
        $role = Role::firstOrCreate(['name' => 'Admin']);

        // Create an Admin user
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'], // Change to your desired email
            [
                'name' => 'Admin User',
                'password' => bcrypt('password123'), // Change password if needed
            ]
        );

        // Assign the Admin role to the user
        $user->assignRole($role);

        echo "Admin user seeded successfully! ✅\n";
    }
}
