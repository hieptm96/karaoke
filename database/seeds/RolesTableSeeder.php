<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$roles = [
    		[
    			'name' => 'admin',
    			'display_name' => 'Administrator',
    			'description' => 'Bộ thông tin và truyền thông'
    		],
            [
                'name' => 'operating_staff',
                'display_name' => 'Operating Staff',
                'description' => 'Nhân viên vận hành'
            ],
            [
                'name' => 'mic',
                'display_name' => 'Ministry of Information and Communications',
                'description' => 'Bộ Thông tin và Truyền thông'
            ],
            [
                'name' => 'dic',
                'display_name' => 'Department of Information and Communications',
                'description' => 'Sở thông tin và truyền thông'
            ],
            [
                'name' => 'musician',
                'display_name' => 'Musician',
                'description' => 'Nhạc sỹ'
            ],
            [
                'name' => 'content_owner_unit',
                'display_name' => 'Content Owner Unit',
                'description' => 'Đơn vị sở hữu nội dung'
            ],
            [
                'name' => 'business_unit',
                'display_name' => 'Business Unit',
                'description' => 'Đơn vị kinh doanh'
            ],
            [
                'name' => 'license_fee_unit',
                'display_name' => 'License Fee Unit',
                'description' => 'Đơn vị thu phí bản quyền'
            ]

    	];
    	foreach ($roles as $item) {
            $role = new App\Models\Role();
            $role->name         = $item['name'];
            $role->display_name = $item['display_name'];
            $role->description  = $item['description'];
            $role->save();
        }
    }
}
