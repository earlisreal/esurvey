<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'earl',
            'first_name' => 'Earl',
            'last_name' => 'Savadera',
            'email' => 'earl_savadera@yahoo.com',
            'password' => bcrypt('123456'),
            'verified' => 1,
            'gender' => 'Male',
            'birthday' => '1997-02-22',
            'country' => 'PH',
            'state' => 'CAV',
            'city' => 'Dasmariñas',
            'role_id' => 1,
            'created_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'username' => 'test',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@e-survey.xyz',
            'password' => bcrypt('123456'),
            'role_id' => 2,
            'verified' => 1,
            'created_at' => Carbon::now(),
        ]);
    }
}
