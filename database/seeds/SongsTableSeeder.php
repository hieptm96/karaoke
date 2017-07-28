<?php

use Illuminate\Database\Seeder;

class SongsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('vi_VN');

        $singerIds = \App\Models\Singer::pluck('id')->toArray();
        $contentOwners = \App\Models\ContentOwner::pluck('id')->toArray();

        for ($i = 0; $i < 100; $i++) {
            $song = \App\Models\Song::create([
                'name' => $faker->name,
                'language' => $faker->randomElement([1, 2, 3]),
                'file_name' => 100000 + $i,
                'created_by' => 1,
                'updated_by' => 1,
            ]);

            $song->singers()->sync($faker->randomElements($singerIds, rand(1, 3)));
        
        }
    }

    private function generateContentOwners($contentOwners)
    {
        //$faker->randomElements($singerIds, rand(0, 4))
    }
}
