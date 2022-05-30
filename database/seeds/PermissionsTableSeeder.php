<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Permission::create([
            'name' => 'User List',
            'slug' => 'user-index'
        ]);
        \App\Permission::create([
            'name' => 'User View',
            'slug' => 'user-view'
        ]);
        \App\Permission::create([
            'name' => 'User Create',
            'slug' => 'user-create'
        ]);
        \App\Permission::create([
            'name' => 'User Edit',
            'slug' => 'user-update'
        ]);
        \App\Permission::create([
            'name' => 'User Delete',
            'slug' => 'user-delete'
        ]);
    }
}
