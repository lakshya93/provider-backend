<?php

class ServicesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('services')->delete();

        Service::create([
            'user_id' => 1,
            'service_type_id' => 1,
            'rating' => 0,
            'rate_count' => 0,
            'name' => 'Mutthuraj Electricals',
            'address' => '#011, 12th Cross, 13th Main Kumaraswamy Layout',
            'mobile' => '+919012345678',
            'landline' => '08012345678',
            'zipcode' => '560999',
            'city' => 'Bangalore',
            'gps_latitude' => 12.908483,
            'gps_longitude' => 77.566245
        ]);

        Service::create([
            'user_id' => 1,
            'service_type_id' => 2,
            'rating' => 0,
            'rate_count' => 0,
            'name' => 'Mario Plumbers',
            'address' => '#012, 14th Cross, 16th Main Kumaraswamy Layout',
            'mobile' => '+919012345678',
            'landline' => '08012345678',
            'zipcode' => '560999',
            'city' => 'Bangalore',
            'gps_latitude' => 12.906025,
            'gps_longitude' => 77.573240
        ]);

        Service::create([
            'user_id' => 1,
            'service_type_id' => 3,
            'rating' => 0,
            'rate_count' => 0,
            'name' => 'Pizza Italia',
            'address' => '#013, 15th Cross, 16th Main Kumaraswamy Layout',
            'mobile' => '+919012345678',
            'landline' => '08012345678',
            'zipcode' => '560999',
            'city' => 'Bangalore',
            'gps_latitude' => 12.92000,
            'gps_longitude' => 77.55000
        ]);

        Service::create([
            'user_id' => 2,
            'service_type_id' => 4,
            'rating' => 0,
            'rate_count' => 0,
            'name' => 'Hard-Wood Carpenters',
            'address' => '#014, 14th Cross, 14th Main Kumaraswamy Layout',
            'mobile' => '+919012345678',
            'landline' => '08012345678',
            'zipcode' => '560999',
            'city' => 'Bangalore',
            'gps_latitude' => 12.898483,
            'gps_longitude' => 77.560245
        ]);

    }
}
