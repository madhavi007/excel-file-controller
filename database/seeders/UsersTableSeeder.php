<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();

        \DB::table('users')->insert(array(
            0 => array(
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin007'),
                'remember_token' => null,
            ),

        ));

    }
}
