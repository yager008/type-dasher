<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class SavedTextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i = 0; $i < 10; $i++) {
            DB::table('saved_texts')->insert([
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'text' => $faker->paragraph,
                'text_name' => $faker->sentence(3),
                'best_speed' => $faker->numberBetween(0, 100),
            ]);
        }
    }
}
