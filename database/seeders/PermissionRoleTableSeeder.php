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
        $listings_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 5) != 'user_' 
                    && substr($permission->title, 0, 5) != 'role_' 
                    && substr($permission->title, 0, 11) != 'permission_'
                    && substr($permission->title, 0, 8) != 'contact_'
                    && substr($permission->title, 0, 9) != 'followup_'
                    && substr($permission->title, 0, 5) != 'edit_'
                    && substr($permission->title, 0, 5) != 'team_'
                    && substr($permission->title, 0, 10) != 'task_create'
                    && substr($permission->title, 0, 11) != 'task_delete'
                    
                    
                    ;
        });
        Role::findOrFail(2)->permissions()->sync($listings_permissions);
        $sales_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 5) != 'user_' 
                    && substr($permission->title, 0, 5) != 'role_' 
                    && substr($permission->title, 0, 11) != 'permission_'
                   && substr($permission->title, 0, 5) != 'team_'
                    && substr($permission->title, 0, 10) != 'task_create'
                    && substr($permission->title, 0, 11) != 'task_delete'
                   && substr($permission->title, 0, 14) != 'listing_create' 
                    && substr($permission->title, 0, 14) != 'listing_delete' 
                    && substr($permission->title, 0, 12) != 'listing_edit' 
                    && substr($permission->title, 0, 14) != 'project_create' 
                    && substr($permission->title, 0, 14) != 'project_delete' 
                    && substr($permission->title, 0, 12) != 'project_edit' 
                    && substr($permission->title, 0, 14) != 'contact_delete' 
                    && substr($permission->title, 0, 15) != 'followup_delete' 
                    && substr($permission->title, 0, 13) != 'followup_edit' 
                    && substr($permission->title, 0, 15) != 'followup_access'
                    && substr($permission->title, 0, 6) != 'owner_' ;
        });
        Role::findOrFail(3)->permissions()->sync($sales_permissions);
    }
}
