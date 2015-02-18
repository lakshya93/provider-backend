<?php

class ServicesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('services')->delete();

        Service::create([
            'user_id' => 1,
            'service_type_id' => 1,
            'business_name' => 'Mutthuraj Electricals',
        ]);

        Service::create([
            'user_id' => 1,
            'service_type_id' => 2,
            'business_name' => 'Mutthuraj Plumbers',
        ]);

        Service::create([
            'user_id' => 2,
            'service_type_id' => 3,
            'business_name' => 'Lolipop Cooks',
        ]);

        Service::create([
            'user_id' => 2,
            'service_type_id' => 4,
            'business_name' => 'Hard-Wood Carpenters',
        ]);

    }
}
