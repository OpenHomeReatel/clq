<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'firstname'      => 'admin',
                'lastname'       => 'admin',
                'mobile'         => '5555555',
                'is_team_leader' => '0',
      
            ],
            [
                'id'             => 2,
                
                'email'          => 'listing1@gmail.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'firstname'      => 'listing1',
                'lastname'       => 'listing1',
                'mobile'         => '5555555',
                'is_team_leader' => '0',
            ],
            [
                'id'             => 3,
                
                'email'          => 'sales1@gmail.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'firstname'      => 'sales1',
                'lastname'       => 'sales1',
                'mobile'         => '5555555',
                'is_team_leader' => '0',
            ],
        ];

        User::insert($users);
    }
}

