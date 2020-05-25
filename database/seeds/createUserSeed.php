<?php

use Illuminate\Database\Seeder;

class createUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'User1',
            'lastname_addition' => 'test',
            'lastname' => 'test',
            'email' => 'arrieality@gmail.com',
            'phone' => '123123121',
            'type' => 'owner',
            'password' => \Illuminate\Support\Facades\Hash::make('Hoihoihoi1'),
        ]);
    }
}
