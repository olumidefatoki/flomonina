<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('state')->insert(['name' => 'ABIA', 'state_code' => 'NG-AB']);
        DB::table('state')->insert(['name' => 'ADAMAWA', 'state_code' => 'NG-AD']);
        DB::table('state')->insert(['name' => 'AKWA IBOM', 'state_code' => 'NG-AK']);
        DB::table('state')->insert(['name' => 'ANAMBRA', 'state_code' => 'NG-AN']);
        DB::table('state')->insert(['name' => 'BAUCHI', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'BENUE', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'BORNO', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'BAYELSA', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'CROSS RIVER', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'DELTA', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'EBONYI', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'EDO', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'EKITI', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'ENUGU', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'FCT', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'GOMBE', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'IMO', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'JIGAWA', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'KEBBI', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'KADUNA', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'KOGI', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'KANO', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'KATSINA', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'KWARA', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'LAGOS', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'NIGER', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'NASSARAWA', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'ONDO', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'OGUN', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'OSUN', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'OYO', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'PLATEAU', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'RIVERS', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'SOKOTO', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'TARABA', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'YOBE', 'state_code' => 'NG']);
        DB::table('state')->insert(['name' => 'ZAMFARA', 'state_code' => 'NG']);
    }
}
