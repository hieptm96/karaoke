<?php

use Illuminate\Database\Seeder;

class SingersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('vi_VN');

        for ($i = 0; $i < 100; $i++) {
            \App\Models\Singer::create([
                'name' => $faker->name,
                'sex' => $faker->randomElement([1, 2, 3]),
                'language' => $faker->randomElement([1, 2, 3]),
                'star' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }
    }
}
