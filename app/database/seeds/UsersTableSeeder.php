<?php

class UsersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create([
            'id' => 1,
            'first_name' => 'peri',
            'last_name' => 'nikhil',
            'email' => 'peri@nikhil',
            'password' => Hash::make('peri'),

            'address' => 'DSI',
            'mobile' => '9886077198',
            'zipcode' => '560999',
            'lamdline' => '0801234567',
            'city' => 'Bangalore',
            ]);

        User::create([
            'id' => 2,
            'first_name' => 'lakie',
            'last_name' => 'ranganath',
            'email' => 'lakie@ranganath',
            'password' => Hash::make('lakie'),

            'address' => 'DSI',
            'mobile' => '9035209244',
            'zipcode' => '560999',
            'lamdline' => '0801234567',
            'city' => 'Bangalore',            
            ]);
    }
}
