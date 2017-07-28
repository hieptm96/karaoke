<?php

use Illuminate\Database\Seeder;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config = \App\Models\Config::create([
            'config' => '{"price":"200","singer_rate":"20","musician_rate":"30","title_rate":"30","film_rate":"20"}',
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
