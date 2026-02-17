<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
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
                'name' => 'ユーザー1',
                'email' => 'sample1@sample.com',
                'password' => Hash::make('sample01'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'ユーザー2',
                'email' => 'sample2@sample.com',
                'password' => Hash::make('sample02'),
                'email_verified_at' => null,
            ],
        ];
        DB::table('users')->insert($param);
    }
}
