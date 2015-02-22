<?php

class ServicesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('services')->delete();

        Service::create([
            'user_id' => 1,
            'service_type_id' => 1,
            'rating' => 4,
            'rate_count' => 1,
            'business_name' => 'Mutthuraj Electricals',
            'business_address' => 'KSLayout',
            'business_mobile' => '+919012345678',
            'business_landline' => '08012345678',
            'business_zipcode' => '560999',
            'business_city' => 'Bangalore'
        ]);

        Service::create([
            'user_id' => 1,
            'service_type_id' => 2,
            'rating' => 2,
            'rate_count' => 2,
            'business_name' => 'Mario Plumbers',
            'business_address' => 'KSLayout',
            'business_mobile' => '+919012345678',
            'business_landline' => '08012345678',
            'business_zipcode' => '560999',
            'business_city' => 'Bangalore'
        ]);

        Service::create([
            'user_id' => 2,
            'service_type_id' => 3,
            'rating' => 5,
            'rate_count' => 3,
            'business_name' => 'Pizza Italia',
            'business_address' => 'KSLayout',
            'business_mobile' => '+919012345678',
            'business_landline' => '08012345678',
            'business_zipcode' => '560999',
            'business_city' => 'Bangalore'
        ]);

        Service::create([
            'user_id' => 2,
            'service_type_id' => 4,
            'rating' => 4,
            'rate_count' => 4,
            'business_name' => 'Hard-Wood Carpenters',
            'business_address' => 'KSLayout',
            'business_mobile' => '+919012345678',
            'business_landline' => '08012345678',
            'business_zipcode' => '560999',
            'business_city' => 'Bangalore'
        ]);

    }
}
