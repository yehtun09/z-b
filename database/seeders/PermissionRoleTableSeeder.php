<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));

        $administrator_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, -7) != '_delete' && substr($permission->title, 0, 5) != 'role_' && substr($permission->title, 0, 11) != 'permission_';
        });
        Role::findOrFail(2)->permissions()->sync($administrator_permissions);

        $data_entry_permissions = $administrator_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 5) != 'user_' && substr($permission->title, 0, 5) != 'role_' && substr($permission->title, 0, 11) != 'permission_';
        });
        Role::findOrFail(3)->permissions()->sync($data_entry_permissions);

        $engineer_permissions = $administrator_permissions->filter(function ($permission) {
            return $permission->title == 'customer_assign_access' || $permission->title == 'customer_assign_edit' || $permission->title == 'customer_assign_access'|| $permission->title == 'invoice_edit' || $permission->title == 'invoice_access' || $permission->title == 'invoice_delete' || $permission->title == 'invoice_show' || $permission->title == 'customer_assign_complete' || $permission->title == 'customer_assign_suspend'  || $permission->title == 'customer_assign_pending' || $permission->title == 'customer_create' || $permission->title == 'customer_show' || $permission->title == 'customer_access' ;
        });
        Role::findOrFail(4)->permissions()->sync($engineer_permissions);

        // $user_permissions = $admin_permissions->filter(function ($permission) {
        //     return substr($permission->title, 0, 5) != 'user_' && substr($permission->title, 0, 5) != 'role_' && substr($permission->title, 0, 11) != 'permission_';
        // });
        // Role::findOrFail(3)->permissions()->sync($user_permissions);
        // Role::findOrFail(4)->permissions()->sync(46);
    }
}
