<?php

use Illuminate\Database\Seeder;

class LikeTableSeeder extends Seeder
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
        $likes = [];
        foreach( $userIds as $userId){
            $like['likeable_type'] = 'User';
            $like['likeable_id'] = $faker->randomElement($userIds);
            $like['is_like'] = $faker->numberBetween(0,1);
            $like['user_id'] = $userId;
            $likes[] = $like;
        }
        DB::table('likes')->insert($likes);
    }
}
