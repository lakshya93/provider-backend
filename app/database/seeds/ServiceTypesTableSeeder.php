<?php

class ServiceTypesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('service_types')->delete();

        ServiceType::create([
            'id' => 1,
            'name' => 'Electrician',
            'icon' => 'ion_outlet',
            ]);

        ServiceType::create([
            'id' => 2,
            'name' => 'Plumber',
            ]);

        ServiceType::create([
            'id' => 3,
            'name' => 'Cook',
            ]);

        ServiceType::create([
            'id' => 4,
            'name' => 'Carpenter',
            ]);
    }
}
