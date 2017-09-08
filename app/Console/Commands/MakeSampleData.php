<?php

namespace App\Console\Commands;

use DB;
use App\Models\Ktv;
use App\Models\Song;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MakeSampleData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ktv:generate-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate random data usage';

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
        $from = Carbon::today()->subDays(30);

        $dates = [];
        for ($date=Carbon::today(); $date->gte($from); $date->subDay()) {
            $dates[] = $date->toDateString();
        }

//        $ktvIds = Ktv::pluck('id')->toArray();
        $ktvBoxes = DB::table('boxes')
                        ->select('ktv_id', 'code')
                        ->get()->toArray();

        $data = [];
        for ($i = 0; $i < 1000; $i ++) {
            $ktvBox = array_random($ktvBoxes);

            $song = Song::inRandomOrder()->first();

            $data[] = [
                'ktv_id' => $ktvBox->ktv_id,
                'song_id' => $song->id,
                'box_code' => $ktvBox->code,
                'times' => rand(10, 1000),
                'date' => array_random($dates),
            ];
        }

        \DB::table('imported_data_usages')->insert($data);
    }
}
