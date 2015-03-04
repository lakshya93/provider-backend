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

            'address' => '#004, 5th Cross, 6th Main Kumaraswamy Layout',
            'mobile' => '9886077198',
            'zipcode' => '560999',
            'landline' => '0801234567',
            'city' => 'Bangalore',
            'gps_latitude' => 12.9050384,
            'gps_longitude' => 77.5648224
            ]);

        User::create([
            'id' => 2,
            'first_name' => 'lakie',
            'last_name' => 'ranganath',
            'email' => 'lakie@ranganath',
            'password' => Hash::make('lakie'),

            'address' => '#001, 2nd Cross, 3rd Main Kumaraswamy Layout',
            'mobile' => '9035209244',
            'zipcode' => '560999',
            'landline' => '0801234567',
            'city' => 'Bangalore',
            'gps_latitude' => 12.9050384,
            'gps_longitude' => 77.5648224
            ]);

        User::create([
            'id' => 3,
            'first_name' => 'deepak',
            'last_name' => 'pai',
            'email' => 'deepak@pai',
            'password' => Hash::make('deepak'),

            'address' => '#004, 4th Cross, 4th Main Kumaraswamy Layout',
            'mobile' => '9035209244',
            'zipcode' => '560999',
            'landline' => '0801234567',
            'city' => 'Bangalore',
            'gps_latitude' => 12.9050384,
            'gps_longitude' => 77.5648224
            ]);
    }
}





/*Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.*/