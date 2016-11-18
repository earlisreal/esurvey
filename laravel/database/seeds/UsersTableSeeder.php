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
            'role_id' => 1,
            'created_at' => Carbon::now(),
        ]);
    }
}
