<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class QuestionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_types')->insert([
            'type' => 'Multiple Choice',
            'has_choices' => true,
            'created_at' => Carbon::now(),
        ]);

        DB::table('question_types')->insert([
            'type' => 'Dropdown',
            'has_choices' => true,
            'created_at' => Carbon::now(),
        ]);

        DB::table('question_types')->insert([
            'type' => 'Textbox',
            'has_choices' => false,
            'created_at' => Carbon::now(),
        ]);

        DB::table('question_types')->insert([
            'type' => 'Text Area',
            'has_choices' => false,
            'created_at' => Carbon::now(),
        ]);

        DB::table('question_types')->insert([
            'type' => 'Checkbox',
            'has_choices' => true,
            'created_at' => Carbon::now(),
        ]);

        DB::table('question_types')->insert([
            'type' => 'Rating Scale',
            'has_choices' => false,
            'created_at' => Carbon::now(),
        ]);

        DB::table('question_types')->insert([
            'type' => 'Likert Scale',
            'has_choices' => true,
            'created_at' => Carbon::now(),
        ]);
    }
}
