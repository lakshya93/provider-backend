<?php

class ServiceTypesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('service_types')->delete();

        ServiceType::create([
            'id' => 1,
            'name' => 'Electrician',
            'icon' => 'ion-outlet',
            ]);

        ServiceType::create([
            'id' => 2,
            'name' => 'Plumber',
            'icon' => 'ion-wrench',
            ]);

        ServiceType::create([
            'id' => 3,
            'name' => 'Cook',
            ]);

        ServiceType::create([
            'id' => 4,
            'name' => 'Carpenter',
            'icon' => 'ion-hammer'
            ]);
    }
}
