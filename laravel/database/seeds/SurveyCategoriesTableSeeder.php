<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SurveyCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('survey_categories')->insert([
            'category' => 'Other',
            'created_at' => Carbon::now(),
        ]);
        DB::table('survey_categories')->insert([
            'category' => 'Community',
            'created_at' => Carbon::now(),
        ]);
        DB::table('survey_categories')->insert([
            'category' => 'Customer Feedback',
            'created_at' => Carbon::now(),
        ]);

        DB::table('survey_categories')->insert([
            'category' => 'Health',
            'created_at' => Carbon::now(),
        ]);
        DB::table('survey_categories')->insert([
            'category' => 'Just for Fun',
            'created_at' => Carbon::now(),
        ]);
        DB::table('survey_categories')->insert([
            'category' => 'Software Evaluation',
            'created_at' => Carbon::now(),
        ]);
    }
}
