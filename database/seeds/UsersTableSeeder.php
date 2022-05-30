<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'admin',
            'username' => 'admin',
            // 'email' => 'admin@email.com',
            'password' =>  \Hash::make('123456')
        ])->roles()->attach(\App\Role::where('slug', 'admin')->get());
        
    }
}
