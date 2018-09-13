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
                'name' => 'Kalam',
                'email' => 'kalam@gmail.com',
                'password' => Hash::make('kalam1'),
                'date_of_birth' => now()->subYears(20),
                'gender' => 'Male',
                'latitude' => 12.343,
                'longitude' => 77.343434,
            ],

            [
                'name' => 'Najmul',
                'email' => 'najmul@gmail.com',
                'password' => Hash::make('najmul'),
                'date_of_birth' => now()->subYear(23),
                'gender' => 'Male',
                'latitude' => 87.343,
                'longitude' => 99.343434
            ]

        ]);
    }
}
