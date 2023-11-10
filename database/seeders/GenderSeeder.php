<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('genders')->insert([
              'code' => 0,
              'name' => '不明',
              'created_at' => new DateTime(),
              'updated_at' => new DateTime(),
        ]);
        DB::table('genders')->insert([
              'code' => 1,
              'name' => '男',
              'created_at' => new DateTime(),
              'updated_at' => new DateTime(),
        ]);
        DB::table('genders')->insert([
              'code' => 2,
              'name' => '女',
              'created_at' => new DateTime(),
              'updated_at' => new DateTime(),
        ]);
        DB::table('genders')->insert([
              'code' => 9,
              'name' => '適用不能',
              'created_at' => new DateTime(),
              'updated_at' => new DateTime(),
        ]);
    }
}
