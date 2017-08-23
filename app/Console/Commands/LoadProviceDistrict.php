<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class LoadProviceDistrict extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ktv:load-province-district-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load provinces and districts from csv file';

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
        $songsFile = realpath('data/provinces.csv');
        $songColumns = '(id, name)';
        import_from_csv($songsFile, 'provinces', $songColumns);

        $singerFile = realpath('data/districts.csv');
        $singerColumns = '(id, name, province_id)';
        import_from_csv($singerFile, 'districts', $singerColumns);

    }
}
