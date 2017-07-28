<?php

use Illuminate\Database\Seeder;

class KtvsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('vi_VN');

        $role = \App\Models\Role::where('name', 'business_unit')->first();
        for ($i = 0; $i < 5; $i++) {
            $user = \App\Models\User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('123456'),
            ]);

            $user->attachRole($role);

            $ktv = \App\Models\Ktv::create([
                'name' => $faker->name,
                'representative' => $faker->name,
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'address' => $faker->address,
                'province_id' => 1,
                'district_id' => 1,
                'user_id' => $user->id,
                'created_by' => 1,
                'updated_by' => 1
            ]);
        }
    }
}
