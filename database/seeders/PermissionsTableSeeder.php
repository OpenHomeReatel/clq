<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'team_create',
            ],
            [
                'id'    => 18,
                'title' => 'team_edit',
            ],
            [
                'id'    => 19,
                'title' => 'team_show',
            ],
            [
                'id'    => 20,
                'title' => 'team_delete',
            ],
            [
                'id'    => 21,
                'title' => 'team_access',
            ],
            [
                'id'    => 22,
                'title' => 'listing_create',
            ],
            [
                'id'    => 23,
                'title' => 'listing_edit',
            ],
            [
                'id'    => 24,
                'title' => 'listing_show',
            ],
            [
                'id'    => 25,
                'title' => 'listing_delete',
            ],
            [
                'id'    => 26,
                'title' => 'listing_access',
            ],
            [
                'id'    => 100,
                'title' => 'listing_export_pdf',
            ],
            [
                'id'    => 27,
                'title' => 'owner_create',
            ],
            [
                'id'    => 28,
                'title' => 'owner_edit',
            ],
            [
                'id'    => 29,
                'title' => 'owner_show',
            ],
            [
                'id'    => 30,
                'title' => 'owner_delete',
            ],
            [
                'id'    => 31,
                'title' => 'owner_access',
            ],
            [
                'id'    => 32,
                'title' => 'project_create',
            ],
            [
                'id'    => 33,
                'title' => 'project_edit',
            ],
            [
                'id'    => 34,
                'title' => 'project_show',
            ],
            [
                'id'    => 35,
                'title' => 'project_delete',
            ],
            [
                'id'    => 36,
                'title' => 'project_access',
            ],
            [
                'id'    => 37,
                'title' => 'contact_create',
            ],
            [
                'id'    => 38,
                'title' => 'contact_edit',
            ],
            [
                'id'    => 39,
                'title' => 'contact_show',
            ],
            [
                'id'    => 40,
                'title' => 'contact_delete',
            ],
            [
                'id'    => 41,
                'title' => 'contact_access',
            ],
            [
                'id'    => 42,
                'title' => 'task_create',
            ],
            [
                'id'    => 43,
                'title' => 'task_edit',
            ],
            [
                'id'    => 44,
                'title' => 'task_show',
            ],
            [
                'id'    => 45,
                'title' => 'task_delete',
            ],
            [
                'id'    => 46,
                'title' => 'task_access',
            ],
            [
                'id'    => 47,
                'title' => 'profile_password_edit',
            ],
             [
                'id'    => 101,
                'title' => 'contact_followup',
            ],
            [
                'id'    => 102,
                'title' => 'followup_create',
            ],
            [
                'id'    => 103,
                'title' => 'followup_edit',
            ],
            [
                'id'    => 104,
                'title' => 'followup_show',
            ],
            [
                'id'    => 105,
                'title' => 'followup_delete',
            ],
            [
                'id'    => 106,
                'title' => 'followup_access',
            ],
            
        ];

        Permission::insert($permissions);
    }
}

