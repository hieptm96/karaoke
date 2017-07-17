<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('users')->insert([
//            'name' => 'admin',
//            'email' => 'admin@gmail.com',
//            'password' => bcrypt('123456'),
//        ]);
        $roles = App\Models\Role::all();
        foreach ($roles as $role) {
            $user = new App\Models\User;
            $user->name = $role->display_name;
            $user->email = $role->name . '@gmail.com';
            $user->password = bcrypt('123456');
            $user->save();
            $user->attachRole($role);
        }
    }
}
