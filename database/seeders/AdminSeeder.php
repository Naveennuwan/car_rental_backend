<?php

namespace Database\Seeders;

use App\Models\CustomRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'first_name' => 'admin first',
            'last_name' => 'admin last',
            'phone_number' => '0705742090',
            'date_of_birth' => '1996.12.11',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'user_type' => 'user',
            'created_by' => 1,
        ])->assignRole('admin');

        CustomRole::query()->update(['created_by' => 1]);
    }
}
