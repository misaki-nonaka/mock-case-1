<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            [
                'user_id' => '1',
                'nickname' => 'サンプル1',
                'profile_img' => 'storage/profiles/sample01.png',
                'zipcode' => '111-1111',
                'address' => '東京都千代田区',
                'building' => 'サンプルマンション'
            ],
            [
                'user_id' => '2',
                'nickname' => 'サンプル2',
                'profile_img' => 'storage/profiles/sample02.png',
                'zipcode' => '222-2222',
                'address' => '東京都渋谷区',
                'building' => 'サンプルハイツ'
            ],
        ];
        DB::table('profiles')->insert($param);
    }
}
