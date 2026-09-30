<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'username' => 'admin',
                'full_name' => 'Admin User',
                'password_hash' => Hash::make('password123'),
                'role_id' => 1,
                'status' => 'Active',
            ]
        );

        $this->call([
            EmployeeSeeder::class,
            ServiceSeeder::class,
            ReportSeeder::class,
        ]);
    }
}
