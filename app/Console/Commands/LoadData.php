<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class LoadData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ktv:load-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load data from csv';

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
        $songsFile = realpath('data/songs.csv');
        $songFields = '(name, word_num, file_name, language, is_new_song, freq, name_raw, abbr)';
        $this->import($songsFile, 'songs', $songFields);

        $singerFile = realpath('data/singers.csv');
        $singerFields = '(id, name, sex, language, abbr, file_name, star, name_raw, freq)';
        $this->import($singerFile, 'singers', $singerFields);

        $singerSongFile = realpath('data/singer_song.csv');
        $singerSongFields = '(song_file_name, singer_id)';
        $this->import($singerSongFile, 'singer_song', $singerSongFields);
    }

    private function import($pathFile, $table, $fields)
    {
        $query = sprintf("LOAD DATA local INFILE '%s'
                INTO TABLE %s
                CHARACTER SET UTF8
                FIELDS TERMINATED BY ',' 
                ENCLOSED BY '\"'
                LINES TERMINATED BY '\n'
                IGNORE 1 ROWS %s", addslashes($pathFile), $table, $fields);

        echo $query;

        return DB::connection()->getpdo()->exec($query);
    }
}
