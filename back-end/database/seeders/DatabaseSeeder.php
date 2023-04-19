<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\eventCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // eventCategory::factory()->create([
        //     'name' => 'Fun Events',
        //     'picture' => 'https://source.unsplash.com/1920x1080/?FunEvent'
        // ]);

        // eventCategory::factory()->create([
        //     'name' => 'Educational Events',
        //     'picture' => 'https://source.unsplash.com/1920x1080/?Education'
        // ]);
        $this->call(EventCategorySeeder::class);
    }
}