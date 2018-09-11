<?php

use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = \Faker\Factory::create();
      $userIds = \App\Models\User::pluck('id')->toArray();
      $locations = [];
      foreach ( $userIds as $userId){
          $location['latitude'] = $faker->numberBetween(100.9222,30023.232);
          $location['longitude'] =  $faker->randomFloat();
          $location['user_id'] = $userId;
          $locations[] = $location;
      }

      DB::table('locations')->insert($locations);
    }
}
