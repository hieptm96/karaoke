<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class MakeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ktv:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate datas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->importFromCSV();
    }

    private function importFromCSV()
    {
        $this->line('hello');
        $csvFilePath = realpath('datas/songs.csv');

//        if (file_exists('datas/songs.csv'))
//        {
//            $this->info('File tồn tại');
//            $this->info(realpath('datas/songs.csv'));
//        }

        $command = "LOAD DATA INFILE 'datas/songs.csv' 
                    INTO TABLE songs 
                    FIELDS TERMINATED BY ',' 
                    ENCLOSED BY '\"'
                    LINES TERMINATED BY '\n'
                    IGNORE 1 ROWS";

        DB::raw($command);

        $csv = $csvFilePath;

//ofcourse you have to modify that with proper table and field names
        $query = sprintf("LOAD DATA local INFILE '%s' INTO TABLE songs FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' ESCAPED BY '\"' LINES TERMINATED BY '\\n' IGNORE 0 LINES ", addslashes($csv));

        return DB::connection()->getpdo()->exec($query);
    }

    private function generateCSVFile()
    {
        $faker = \Faker\Factory::create('vi_VN');

//        $singerIds = \App\Models\Singer::pluck('id')->toArray();
//        $contentOwnerIds = \App\Models\ContentOwner::pluck('id')->toArray();

        $path = 'songs.csv';
        $songFile = @fopen($path, "w");
        $tiles = ['name', 'song_file_name', ];


        for ($i = 0; $i < 100; $i++) {
            $song = \App\Models\Song::create([
                'name' => $faker->name,
                'language' => $faker->randomElement([1, 2, 3]),
                'file_name' => 100000 + $i,
                'has_fee' => rand(0, 3),
                'created_by' => 1,
                'updated_by' => 1,
            ]);
//            $songFileName = $song->file_name;
//            $song->singers()->sync($faker->randomElements($singerIds, rand(1, 3)));
//            $owners = $this->getOwners($contentOwnerIds, $songFileName, $faker);
//            $song->contentOwners()->sync($owners);
        }
    }
}
