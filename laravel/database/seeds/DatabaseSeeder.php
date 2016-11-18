<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserRolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ModulesTableSeeder::class);
        $this->call(RoleModulesTableSeeder::class);
        $this->call(SurveyCategoriesTableSeeder::class);
        $this->call(QuestionTypesTableSeeder::class);
    }
}
