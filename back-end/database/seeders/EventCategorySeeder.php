<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_categories')->insert([
            'name' => 'General',
            'picture' => 'https://source.unsplash.com/1920x1080/?General',
        ]);

        DB::table('event_categories')->insert([
            'name' => 'Educational',
            'picture' => 'https://source.unsplash.com/1920x1080/?Educational',
        ]);

        DB::table('event_categories')->insert([
            'name' => 'Fun',
            'picture' => 'https://source.unsplash.com/1920x1080/?Fun',
        ]);

        DB::table('event_categories')->insert([
            'name' => 'Other',
            'picture' => 'https://source.unsplash.com/1920x1080/?Other',
        ]);
    }
}