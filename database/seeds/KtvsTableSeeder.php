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

        $ktvNames = ['Karaoke Kingdom', 'Karaoke Fyou', 'Karaoke Laravel', 'Karaoke Python', 'Karaoke Best',
            'Karaoke Nice', 'Karaoke Ruby', 'Karaoke Teemo'];

        $representatives = ['Nguyễn Xuân Phúc', 'Phan Văn Trường', 'Trần Thị Châu'];

        $role = \App\Models\Role::where('name', 'business_unit')->first();
        for ($i = 0; $i < count($ktvNames); $i++) {
            $email = generate_email($ktvNames[$i]);
            $user = \App\Models\User::create([
                'name' => $ktvNames[$i],
                'email' => $email,
                'password' => bcrypt('123456'),
            ]);

            $user->attachRole($role);

            $ktv = \App\Models\Ktv::create([
                'name' => $ktvNames[$i],
                'representative' => $faker->randomElement($representatives),
                'phone' => '09' . $faker->numerify("########"),
                'email' => $email,
                'province_id' => 24,
                'district_id' => 561,
                'user_id' => $user->id,
                'created_by' => 1,
                'updated_by' => 1
            ]);
        }
    }
}
