<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class TypeResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i = 0; $i < 100; $i++) {
            DB::table('type_results')->insert([
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'result' => $faker->numberBetween(200, 500),
                'number_of_mistakes' => $faker->numberBetween(200, 500),
                'username' => 'Joseph Plaz',
                'user_local_time' => now()
            ]);
        }
    }
}
