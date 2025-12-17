<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Create or update the default admin user.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@email.com'],
            [
                'name' => 'Admin',
                // User model casts password to hashed, so plain text is fine here.
                'password' => 'adminadmin',
            ]
        );

        // Ensure the user has the admin role.
        $user->syncRoles(['admin']);
    }
}

