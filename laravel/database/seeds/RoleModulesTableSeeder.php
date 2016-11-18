<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoleModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_modules')->insert([
            'role_id' => 1,
            'module_id' => 1,
            'can_read' => true,
            'can_write' => true,
            'created_at' => Carbon::now(),
        ]);

        DB::table('role_modules')->insert([
            'role_id' => 1,
            'module_id' => 2,
            'can_read' => true,
            'can_write' => true,
            'created_at' => Carbon::now(),
        ]);

        DB::table('role_modules')->insert([
            'role_id' => 1,
            'module_id' => 3,
            'can_read' => true,
            'can_write' => true,
            'created_at' => Carbon::now(),
        ]);

        DB::table('role_modules')->insert([
            'role_id' => 1,
            'module_id' => 4,
            'can_read' => true,
            'can_write' => true,
            'created_at' => Carbon::now(),
        ]);

        DB::table('role_modules')->insert([
            'role_id' => 1,
            'module_id' => 5,
            'can_read' => true,
            'can_write' => true,
            'created_at' => Carbon::now(),
        ]);
    }
}
