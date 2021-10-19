<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bank')->insert(['name' => 'Sterling Bank']);
        DB::table('bank')->insert(['name' => 'FCMB']);
        DB::table('bank')->insert(['name' => 'UBA Bank']);
        DB::table('bank')->insert(['name' => 'JAIZ Bank']);
        DB::table('bank')->insert(['name' => 'Fidelity Bank']);
        DB::table('bank')->insert(['name' => 'Polaris Bank']);
        DB::table('bank')->insert(['name' => 'Citi Bank']);
        DB::table('bank')->insert(['name' => 'Ecobank Bank']);
        DB::table('bank')->insert(['name' => 'Unity Bank']);
        DB::table('bank')->insert(['name' => 'StanbicIBTC Bank']);
        DB::table('bank')->insert(['name' => 'GTBank Plc']);
        DB::table('bank')->insert(['name' => 'Access Bank']);
        DB::table('bank')->insert(['name' => 'First Bank of Nigeria']);
        DB::table('bank')->insert(['name' => 'Wema Bank']);
        DB::table('bank')->insert(['name' => 'Union Bank']);
        DB::table('bank')->insert(['name' => 'Enterprise Bank']);
        DB::table('bank')->insert(['name' => 'Ecobank Heritage']);
    }
}
