<?php

use Illuminate\Database\Seeder;

class ContentOwnerSongTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $songIds = \App\Models\Singer::pluck('id')->toArray();
        $contentOwnerIds = \App\Models\ContentOwner::pluck('id')->toArray();
        $ownerTypes = ['singer', 'musican', 'title', 'film'];

        for ($i = 0; $i < 100; $i++) {
            $songId = $songIds[$i];
            $contentOwnerId = $faker->randomElement($contentOwnerIds);
            $owners = $faker->randomElements($ownerTypes, rand(1, 4));
            foreach ($owners as $owner) {
                \App\Models\ContentOwnerSong::create([
                    'song_id' => $songId,
                    'content_owner_id' => $contentOwnerId,
                    'type' => $owner,
                    'percentage' => 0,
                ]);
            }
        }
    }
}
