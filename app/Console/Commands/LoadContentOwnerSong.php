<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LoadContentOwnerSong extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ktv:load-content-owner-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load content owners, content owner songs from csv';

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
        $contentOwnerFile = realpath('data/content_owners.csv');
        $contentOwnerColumns = '(id, name, email, phone, province_id, district_id)';
        import_from_csv($contentOwnerFile, 'content_owners', $contentOwnerColumns);

        $contentOwnerSongFile = realpath('data/content_owner_song.csv');
        $contentOwnerSongColumns = '(song_file_name, content_owner_id, percentage, type)';
        import_from_csv($contentOwnerSongFile, 'content_owner_song', $contentOwnerSongColumns);
    }
}
