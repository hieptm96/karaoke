<?php

use Illuminate\Database\Seeder;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('vi_VN');

        for ($i = 0; $i < 5; $i++) {
            $province = \App\Models\Province::create([
                'name' => $faker->name,
            ]);

            for ($j = 0; $j < 5; $j++) {
                $district = \App\Models\District::create([
                    'name' => $faker->name,
                    'province_id' => $province->id,
                ]);
            }
        }
    }
}
