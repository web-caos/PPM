<?php

class UsersDbSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $args = array(
            'username' => 'Admin',
            'password' => Hash::make('Tr41n1t0!'),
            'email'    => 'luciano@pcperformance-store.com'
        );
        User::create($args);
    }

}