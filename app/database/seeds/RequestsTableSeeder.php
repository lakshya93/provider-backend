<?php

class RequestsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('requests')->delete();

        Requestx::create([
            'user_id' => 1,
            'service_id' => 4,
            'status' => 'pending',
        ]);

        Requestx::create([
            'user_id' => 2,
            'service_id' => 1,
            'status' => 'accepted',
        ]);

        Requestx::create([
            'user_id' => 2,
            'service_id' => 2,
            'status' => 'declined',
        ]);

        Requestx::create([
            'user_id' => 3,
            'service_id' => 3,
            'status' => 'pending',
        ]);

        Requestx::create([
            'user_id' => 3,
            'service_id' => 4,
            'status' => 'pending',
        ]);

    }
}
