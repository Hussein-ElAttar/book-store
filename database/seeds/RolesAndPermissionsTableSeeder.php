<?php
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use \Spatie\Permission\PermissionRegistrar;
class RolesAndPermissionsTableSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Role::truncate();
        Permission::truncate();

        Permission::create(['name'=> 'view books', 'guard_name' => 'api']);
        Permission::create(['name'=> 'store books', 'guard_name' => 'api']);
        Permission::create(['name'=> 'update books', 'guard_name' => 'api']);
        Permission::create(['name'=> 'destroy books', 'guard_name' => 'api']);


        // or may be done by chaining
        Role::create(['name' => 'admin', 'guard_name' => 'api'])
            ->givePermissionTo([
                'view books',
                'store books',
                'update books',
                'destroy books',
            ])->save();
        Role::create(['name' => 'editor', 'guard_name' => 'api'])
            ->givePermissionTo([
                'view books',
                'store books',
                'update books',
            ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}