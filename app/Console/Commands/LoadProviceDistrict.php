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
    protected $signature = 'ktv:load-province-district';

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
        $songFields = '(id, name)';
        $this->import($songsFile, 'provinces', $songFields);

        $singerFile = realpath('data/districts.csv');
        $singerFields = '(id, name, province_id)';
        $this->import($singerFile, 'districts', $singerFields);

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
