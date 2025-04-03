<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create the Admin role if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // Create the Admin user
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'], 
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'), 
            ]
        );

        // Attach the role to the user if not already attached
        if (!$user->roles()->where('name', 'Admin')->exists()) {
            $user->roles()->attach($adminRole->id);
        }

        // Mark the email as verified
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        echo "Admin user seeded successfully! ✅\n";
    }
}
