<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class KtvInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ktv:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->comment('Loading provinces, districts data...');
        $this->call('ktv:load-province-district-data');
        $this->info('Loaded provinces, district data');

        $this->call('db:seed');

        $this->comment('Loading singers, songs data...');
        $this->call('ktv:load-singer-song-data');
        $this->info('Loaded singers, songs data data');

        $this->comment('Loading content owners data...');
        $this->call('ktv:load-content-owner-data');
        $this->info('Loaded content owners data');

        $this->comment('Generating sample data...');
        $this->call('ktv:generate-data');
        $this->info('Generated sample data');

        $this->info('Done!!!');
    }
}
