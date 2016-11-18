<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            'title' => 'Super Admin',
            'created_at' => Carbon::now(),
        ]);

        DB::table('user_roles')->insert([
            'title' => 'User',
            'created_at' => Carbon::now(),
        ]);
    }
}
