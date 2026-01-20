<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            [   'item_img' => 'storage/items/sample.jpg',
                'item_name' => '腕時計',
                'brand' => 'Rolax',
                'price' => '15000',
                'detail' => 'スタイリッシュなデザインのメンズ腕時計',
                'condition' => '1',
                'user_id' => '1',
                'sold' => '1'
            ],
            [   'item_img' => 'storage/items/sample.jpg',
                'item_name' => 'HDD',
                'brand' => '西芝',
                'price' => '5000',
                'detail' => '高速で信頼性の高いハードディスク',
                'condition' => '2',
                'user_id' => '2',
                'sold' => '1'
            ],
            [   'item_img' => 'storage/items/sample.jpg',
                'item_name' => '玉ねぎ3束',
                'brand' => 'なし',
                'price' => '300',
                'detail' => '新鮮な玉ねぎ3束のセット',
                'condition' => '3',
                'user_id' => '1',
                'sold' => '0'
            ],
            [   'item_img' => 'storage/items/sample.jpg',
                'item_name' => '革靴',
                'brand' => '',
                'price' => '4000',
                'detail' => 'クラシックなデザインの革靴',
                'condition' => '4',
                'user_id' => '2',
                'sold' => '0'
            ],
            [   'item_img' => 'storage/items/sample.jpg',
                'item_name' => 'ノートPC',
                'brand' => '',
                'price' => '45000',
                'detail' => '高性能なノートパソコン',
                'condition' => '1',
                'user_id' => '1',
                'sold' => '0'
            ],
            [   'item_img' => 'storage/items/sample.jpg',
                'item_name' => 'マイク',
                'brand' => 'なし',
                'price' => '8000',
                'detail' => '高音質のレコーディング用マイク',
                'condition' => '2',
                'user_id' => '2',
                'sold' => '0'
            ],
            [   'item_img' => 'storage/items/sample.jpg',
                'item_name' => 'ショルダーバッグ',
                'brand' => '',
                'price' => '3500',
                'detail' => 'おしゃれなショルダーバッグ',
                'condition' => '3',
                'user_id' => '1',
                'sold' => '0'
            ],
            [   'item_img' => 'storage/items/sample.jpg',
                'item_name' => 'タンブラー',
                'brand' => 'なし',
                'price' => '500',
                'detail' => '使いやすいタンブラー',
                'condition' => '4',
                'user_id' => '2',
                'sold' => '0'
            ],
            [   'item_img' => 'storage/items/sample.jpg',
                'item_name' => 'コーヒーミル',
                'brand' => 'Starbacks',
                'price' => '4000',
                'detail' => '手動のコーヒーミル',
                'condition' => '1',
                'user_id' => '1',
                'sold' => '0'
            ],
            [   'item_img' => 'storage/items/sample.jpg',
                'item_name' => 'メイクセット',
                'brand' => '',
                'price' => '2500',
                'detail' => '便利なメイクアップセット',
                'condition' => '2',
                'user_id' => '2',
                'sold' => '0'
            ],
        ];
        DB::table('items')->insert($param);
    }
}
