<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert([
            'title' => 'User Management',
            'url' => 'users',
            'icon' => 'fa fa-users',
            'order_number' => 1,
            'created_at' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'title' => 'Role Management',
            'url' => 'roles',
            'icon' => 'fa fa-key',
            'order_number' => 2,
            'created_at' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'title' => 'Survey Templates',
            'url' => 'templates',
            'icon' => 'fa fa-list-alt',
            'order_number' => 3,
            'created_at' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'title' => 'Survey Categories',
            'url' => 'categories',
            'icon' => 'fa fa-bars',
            'order_number' => 4,
            'created_at' => Carbon::now(),
        ]);

        DB::table('modules')->insert([
            'title' => 'Admin Modules',
            'url' => 'modules',
            'icon' => 'fa fa-gears',
            'order_number' => 5,
            'created_at' => Carbon::now(),
        ]);
    }
}
