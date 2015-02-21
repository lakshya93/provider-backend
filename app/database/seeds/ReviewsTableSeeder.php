<?php

class ReviewsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('reviews')->delete();

        Review::create([
            'user_id' => 1,
            'service_id' => 3,
            'description' => 'User 1 reviewed Service 3',
        ]);

        Review::create([
            'user_id' => 1,
            'service_id' => 4,
            'description' => 'User 1 reviewed Service 4',
        ]);

        Review::create([
            'user_id' => 2,
            'service_id' => 1,
            'description' => 'User 2 reviewed Service 1',
        ]);

        Review::create([
            'user_id' => 2,
            'service_id' => 2,
            'description' => 'User 2 reviewed Service 1',
        ]);

    }
}
