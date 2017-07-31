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
        // $this->call(RolesTableSeeder::class);
        //
        // $this->call(SingersTableSeeder::class);
        //
        // $this->call(UsersTableSeeder::class);
        //
        $this->call(SongsTableSeeder::class);
        //
        // $this->call(KtvsTableSeeder::class);
        //
        // $this->call(ProvincesTableSeeder::class);
        //
        // $this->call(DataUsageSeeder::class);
    }
}
