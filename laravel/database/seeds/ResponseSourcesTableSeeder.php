<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ResponseSourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('response_sources')->insert([
            'source' => 'Web',
            'created_at' => Carbon::now()
        ]);

        DB::table('response_sources')->insert([
            'source' => 'Android',
            'created_at' => Carbon::now()
        ]);

        DB::table('response_sources')->insert([
            'source' => 'Mobile Browser',
            'created_at' => Carbon::now()
        ]);
    }
}
