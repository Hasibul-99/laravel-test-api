<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name'=> 'Hasibul', 'email'=> 'hasib@gmail.com', 'password'=> '123456'],
            ['name'=> 'Hasan', 'email'=> 'hasan@gmail.com', 'password'=> '123456'],
            ['name'=> 'Tushar', 'email'=> 'tushar@gmail.com', 'password'=> '123456']
        ];

        User::insert($users);
    }
}
