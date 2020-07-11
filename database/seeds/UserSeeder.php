<?php

use App\Admin;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Example User',
            'email' => 'user@mail.com',
            'password' => bcrypt("password")
        ]);
        Admin::create([
            'name' => 'Example Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt("password")
        ]);
    }
}
