<?php

class ReviewsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('reviews')->delete();

        Review::create([
            'user_id' => 1,
            'service_id' => 3,
            'description' => 'Knows safety precautions. Good job!',
        ]);

        Review::create([
            'user_id' => 1,
            'service_id' => 4,
            'description' => 'Makes more leaks than he fixes. And he almost killed my pet duck.',
        ]);

        Review::create([
            'user_id' => 2,
            'service_id' => 1,
            'description' => 'Cheezy! Very Cheezy! ',
        ]);

        Review::create([
            'user_id' => 2,
            'service_id' => 2,
            'description' => 'For opening doors and windows. They do tables as well.',
        ]);

    }
}
