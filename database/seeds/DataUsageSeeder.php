<?php

use Illuminate\Database\Seeder;

class DataUsageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $songFileNames = \App\Models\Song::pluck('file_name')->toArray();
        $ktvIds = \App\Models\Ktv::pluck('id')->toArray();

        for ($i = 0; $i < 1000; $i++) {
            $data = \App\Models\ImportedDataUsage::create([
                'ktv_id' => $faker->randomElement($ktvIds),
                'song_file_name' => $faker->randomElement($songFileNames),
                'date' => $faker->dateTimeBetween($startDate="-1 year", $endDate="now")->format('Y-m-d'),
                'times' => $faker->numberBetween(1, 10)
            ]);
        }
    }
}
