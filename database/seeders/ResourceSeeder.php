<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Resource::create(['id' => 1, 'name' => 'Nab-Bar',           'order' => 1, 'created_by' => 1]);
        Resource::create(['id' => 2, 'name' => 'User',              'order' => 2, 'created_by' => 1]);
        Resource::create(['id' => 3, 'name' => 'Role',              'order' => 3, 'created_by' => 1]);
        Resource::create(['id' => 4, 'name' => 'Permission',        'order' => 4, 'created_by' => 1]);
        Resource::create(['id' => 5, 'name' => 'Shop Types',        'order' => 5, 'created_by' => 1]);
        Resource::create(['id' => 6, 'name' => 'Shops',             'order' => 6, 'created_by' => 1]);
        Resource::create(['id' => 7, 'name' => 'Category',          'order' => 7, 'created_by' => 1]);
        Resource::create(['id' => 8, 'name' => 'Brand',             'order' => 8, 'created_by' => 1]);
        Resource::create(['id' => 9, 'name' => 'Product',           'order' => 9, 'created_by' => 1]);
        Resource::create(['id' => 10, 'name' => 'Customer',         'order' => 10, 'created_by' => 1]);
        Resource::create(['id' => 11, 'name' => 'Order',            'order' => 11, 'created_by' => 1]);
        Resource::create(['id' => 12, 'name' => 'Area',             'order' => 12, 'created_by' => 1]);
        Resource::create(['id' => 13, 'name' => 'Delivery Status',  'order' => 13, 'created_by' => 1]);
        Resource::create(['id' => 14, 'name' => 'Payment Status',   'order' => 14, 'created_by' => 1]);
        Resource::create(['id' => 15, 'name' => 'Tax',              'order' => 15, 'created_by' => 1]);
        Resource::create(['id' => 16, 'name' => 'Delivery Method',  'order' => 16, 'created_by' => 1]);
        Resource::create(['id' => 17, 'name' => 'Shopping Status',  'order' => 17, 'created_by' => 1]);
    }
}
