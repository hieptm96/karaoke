<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SingersTableSeeder::class);

        $this->call(UsersTableSeeder::class);
    }
}
