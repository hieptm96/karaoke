<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class LoadSingerSong extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ktv:load-singer-song-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load singers and songs from csv';

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
        $songColumns = '(name, word_num, file_name, language, is_new_song, freq, name_raw, abbr)';
        import_from_csv($songsFile, 'songs', $songColumns);

        $singerFile = realpath('data/singers.csv');
        $singerColumns = '(id, name, sex, language, abbr, file_name, star, name_raw, freq)';
        import_from_csv($singerFile, 'singers', $singerColumns);

        $singerSongFile = realpath('data/singer_song.csv');
        $singerSongColumns = '(song_file_name, singer_id)';
        import_from_csv($singerSongFile, 'singer_song', $singerSongColumns);
    }
}
