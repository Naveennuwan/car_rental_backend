<?php

namespace Database\Seeders;

use App\Models\CustomPermission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['id' => 1, 'name' => 'admin', ]);
        Role::create(['id' => 2, 'name' => 'user', ]);
    }
}
