<?php

namespace Database\Seeders;

use App\Models\CustomPermission;
use App\Models\CustomRole;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomPermission::create(['name' => 'master-control',           'guard_name' => 'web', 'resource_id' => 1, 'created_by' => 1]);
        CustomPermission::create(['name' => 'user-management',          'guard_name' => 'web', 'resource_id' => 1, 'created_by' => 1]);

        CustomPermission::create(['name' => 'user-access',              'guard_name' => 'web', 'resource_id' => 2, 'created_by' => 1]);
        CustomPermission::create(['name' => 'user-create',              'guard_name' => 'web', 'resource_id' => 2, 'created_by' => 1]);
        CustomPermission::create(['name' => 'user-edit',                'guard_name' => 'web', 'resource_id' => 2, 'created_by' => 1]);
        CustomPermission::create(['name' => 'user-delete',              'guard_name' => 'web', 'resource_id' => 2, 'created_by' => 1]);

        CustomPermission::create(['name' => 'role-access',              'guard_name' => 'web', 'resource_id' => 3, 'created_by' => 1]);
        CustomPermission::create(['name' => 'role-create',              'guard_name' => 'web', 'resource_id' => 3, 'created_by' => 1]);
        CustomPermission::create(['name' => 'role-edit',                'guard_name' => 'web', 'resource_id' => 3, 'created_by' => 1]);
        CustomPermission::create(['name' => 'role-delete',              'guard_name' => 'web', 'resource_id' => 3, 'created_by' => 1]);

        CustomPermission::create(['name' => 'permission-access',        'guard_name' => 'web', 'resource_id' => 4, 'created_by' => 1]);
        CustomPermission::create(['name' => 'permission-create',        'guard_name' => 'web', 'resource_id' => 4, 'created_by' => 1]);
        CustomPermission::create(['name' => 'permission-edit',          'guard_name' => 'web', 'resource_id' => 4, 'created_by' => 1]);
        CustomPermission::create(['name' => 'permission-delete',        'guard_name' => 'web', 'resource_id' => 4, 'created_by' => 1]);
        
        CustomPermission::create(['name' => 'shop-type-access',         'guard_name' => 'web', 'resource_id' => 5, 'created_by' => 1]);
        CustomPermission::create(['name' => 'shop-type-create',         'guard_name' => 'web', 'resource_id' => 5, 'created_by' => 1]);
        CustomPermission::create(['name' => 'shop-type-edit',           'guard_name' => 'web', 'resource_id' => 5, 'created_by' => 1]);
        CustomPermission::create(['name' => 'shop-type-delete',         'guard_name' => 'web', 'resource_id' => 5, 'created_by' => 1]);

        CustomPermission::create(['name' => 'shop-access',              'guard_name' => 'web', 'resource_id' => 6, 'created_by' => 1]);
        CustomPermission::create(['name' => 'shop-create',              'guard_name' => 'web', 'resource_id' => 6, 'created_by' => 1]);
        CustomPermission::create(['name' => 'shop-edit',                'guard_name' => 'web', 'resource_id' => 6, 'created_by' => 1]);
        CustomPermission::create(['name' => 'shop-delete',              'guard_name' => 'web', 'resource_id' => 6, 'created_by' => 1]);

        CustomPermission::create(['name' => 'category-access',          'guard_name' => 'web', 'resource_id' => 7, 'created_by' => 1]);
        CustomPermission::create(['name' => 'category-create',          'guard_name' => 'web', 'resource_id' => 7, 'created_by' => 1]);
        CustomPermission::create(['name' => 'category-edit',            'guard_name' => 'web', 'resource_id' => 7, 'created_by' => 1]);
        CustomPermission::create(['name' => 'category-delete',          'guard_name' => 'web', 'resource_id' => 7, 'created_by' => 1]);

        CustomPermission::create(['name' => 'brand-access',             'guard_name' => 'web', 'resource_id' => 8, 'created_by' => 1]);
        CustomPermission::create(['name' => 'brand-create',             'guard_name' => 'web', 'resource_id' => 8, 'created_by' => 1]);
        CustomPermission::create(['name' => 'brand-edit',               'guard_name' => 'web', 'resource_id' => 8, 'created_by' => 1]);
        CustomPermission::create(['name' => 'brand-delete',             'guard_name' => 'web', 'resource_id' => 8, 'created_by' => 1]);

        CustomPermission::create(['name' => 'product-access',           'guard_name' => 'web', 'resource_id' => 9, 'created_by' => 1]);
        CustomPermission::create(['name' => 'product-create',           'guard_name' => 'web', 'resource_id' => 9, 'created_by' => 1]);
        CustomPermission::create(['name' => 'product-edit',             'guard_name' => 'web', 'resource_id' => 9, 'created_by' => 1]);
        CustomPermission::create(['name' => 'product-delete',           'guard_name' => 'web', 'resource_id' => 9, 'created_by' => 1]);

        CustomPermission::create(['name' => 'customer-access',          'guard_name' => 'web', 'resource_id' => 10, 'created_by' => 1]);
        CustomPermission::create(['name' => 'customer-create',          'guard_name' => 'web', 'resource_id' => 10, 'created_by' => 1]);
        CustomPermission::create(['name' => 'customer-edit',            'guard_name' => 'web', 'resource_id' => 10, 'created_by' => 1]);
        CustomPermission::create(['name' => 'customer-delete',          'guard_name' => 'web', 'resource_id' => 10, 'created_by' => 1]);

        CustomPermission::create(['name' => 'order-access',             'guard_name' => 'web', 'resource_id' => 11, 'created_by' => 1]);
        CustomPermission::create(['name' => 'order-create',             'guard_name' => 'web', 'resource_id' => 11, 'created_by' => 1]);
        CustomPermission::create(['name' => 'order-edit',               'guard_name' => 'web', 'resource_id' => 11, 'created_by' => 1]);
        CustomPermission::create(['name' => 'order-delete',             'guard_name' => 'web', 'resource_id' => 11, 'created_by' => 1]);

        CustomPermission::create(['name' => 'area-access',              'guard_name' => 'web', 'resource_id' => 12, 'created_by' => 1]);
        CustomPermission::create(['name' => 'area-create',              'guard_name' => 'web', 'resource_id' => 12, 'created_by' => 1]);
        CustomPermission::create(['name' => 'area-edit',                'guard_name' => 'web', 'resource_id' => 12, 'created_by' => 1]);
        CustomPermission::create(['name' => 'area-delete',              'guard_name' => 'web', 'resource_id' => 12, 'created_by' => 1]);

        CustomPermission::create(['name' => 'shipping-status-access',   'guard_name' => 'web', 'resource_id' => 13, 'created_by' => 1]);
        CustomPermission::create(['name' => 'shipping-status-create',   'guard_name' => 'web', 'resource_id' => 13, 'created_by' => 1]);
        CustomPermission::create(['name' => 'shipping-status-edit',     'guard_name' => 'web', 'resource_id' => 13, 'created_by' => 1]);
        CustomPermission::create(['name' => 'shipping-status-delete',   'guard_name' => 'web', 'resource_id' => 13, 'created_by' => 1]);

        CustomPermission::create(['name' => 'payment-status-access',    'guard_name' => 'web', 'resource_id' => 14, 'created_by' => 1]);
        CustomPermission::create(['name' => 'payment-status-create',    'guard_name' => 'web', 'resource_id' => 14, 'created_by' => 1]);
        CustomPermission::create(['name' => 'payment-status-edit',      'guard_name' => 'web', 'resource_id' => 14, 'created_by' => 1]);
        CustomPermission::create(['name' => 'payment-status-delete',    'guard_name' => 'web', 'resource_id' => 14, 'created_by' => 1]);

        CustomPermission::create(['name' => 'tax-access',               'guard_name' => 'web', 'resource_id' => 15, 'created_by' => 1]);
        CustomPermission::create(['name' => 'tax-create',               'guard_name' => 'web', 'resource_id' => 15, 'created_by' => 1]);
        CustomPermission::create(['name' => 'tax-edit',                 'guard_name' => 'web', 'resource_id' => 15, 'created_by' => 1]);
        CustomPermission::create(['name' => 'tax-delete',               'guard_name' => 'web', 'resource_id' => 15, 'created_by' => 1]);

        CustomPermission::create(['name' => 'delivery-method-access',   'guard_name' => 'web', 'resource_id' => 16, 'created_by' => 1]);
        CustomPermission::create(['name' => 'delivery-method-create',   'guard_name' => 'web', 'resource_id' => 16, 'created_by' => 1]);
        CustomPermission::create(['name' => 'delivery-method-edit',     'guard_name' => 'web', 'resource_id' => 16, 'created_by' => 1]);
        CustomPermission::create(['name' => 'delivery-method-delete',   'guard_name' => 'web', 'resource_id' => 16, 'created_by' => 1]);

        CustomPermission::create(['name' => 'shippinng-status-access',   'guard_name' => 'web', 'resource_id' => 17, 'created_by' => 1]);
        CustomPermission::create(['name' => 'shippinng-status-create',   'guard_name' => 'web', 'resource_id' => 17, 'created_by' => 1]);
        CustomPermission::create(['name' => 'shippinng-status-edit',     'guard_name' => 'web', 'resource_id' => 17, 'created_by' => 1]);
        CustomPermission::create(['name' => 'shippinng-status-delete',   'guard_name' => 'web', 'resource_id' => 17, 'created_by' => 1]);

        // Attach all permissions to the admin role
        $adminRole = CustomRole::findOrFail(1);
        $permissions = CustomPermission::all();
        $adminRole->permissions()->attach($permissions);
    }
}
