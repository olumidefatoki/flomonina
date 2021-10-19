<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommoditySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('commodity')->insert(['name' => 'Rice']);
        DB::table('commodity')->insert(['name' => 'Maize']);
        DB::table('commodity')->insert(['name' => 'Soybean']);
    }
}
