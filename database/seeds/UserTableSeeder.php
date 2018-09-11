<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'date_of_birth' => now(),
                'gender' => 'Male'],
            [
                'name' => 'Najmul',
                'email' => 'najmul@gmail.com',
                'password' => Hash::make('najmul'),
                'date_of_birth' => now(),
                'gender' => 'Male'
            ]

        ]);
    }
}
