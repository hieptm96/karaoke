<?php

use Illuminate\Database\Seeder;
use App\Repositories\SongRepository;

class SongsTableSeeder extends Seeder
{
    private static $ownerTypes = ['singer', 'musican', 'title', 'film'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('vi_VN');

        $singerIds = \App\Models\Singer::pluck('id')->toArray();
        $contentOwnerIds = \App\Models\ContentOwner::pluck('id')->toArray();

        for ($i = 0; $i < 100; $i++) {
            $song = \App\Models\Song::create([
                'name' => $faker->name,
                'language' => $faker->randomElement([1, 2, 3]),
                'file_name' => 100000 + $i,
                'has_fee' => rand(0, 3),
                'created_by' => 1,
                'updated_by' => 1,
            ]);
            $songFileName = $song->file_name;
            $song->singers()->sync($faker->randomElements($singerIds, rand(1, 3)));
            $owners = $this->getOwners($contentOwnerIds, $songFileName, $faker);
            $song->contentOwners()->sync($owners);
        }
    }

    private function getOwners($contentOwnerIds, $songFileName, $faker)
    {
        $owners = [];
        $nOwners = rand(1, 4);
        $realOwnerTypes = $faker->randomElements(static::$ownerTypes, $nOwners);

        $sumPercent = 0;
        $songRepository = new SongRepository;

        for ($i = 0; $i < $nOwners; $i++) {
            $ownerType = $realOwnerTypes[$i];
            $ownerId = $faker->randomElement($contentOwnerIds);
            $defaultPercentage = $songRepository->getDefaultPercentage($ownerType);
            $owners[] = ['content_owner_id' => $ownerId,
                    'type' => $ownerType, 'percentage' => $defaultPercentage,
                    'song_file_name' => $songFileName];

            $sumPercent += $defaultPercentage;
        }

        $remainPercent = 100;
        $nComputedOwners = 0;

        foreach ($owners as $key => &$owner) {
            if ($nComputedOwners == count($owners) - 1) {    // last owner
                $owner['percentage'] = $remainPercent;
            } else {
                $realPercent = floatval($owner['percentage']) / $sumPercent * 100;
                $owner['percentage'] = round($realPercent);
                $remainPercent -= $owner['percentage'];
                $nComputedOwners++;
            }
        }

        return $owners;
    }
}
