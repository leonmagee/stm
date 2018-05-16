<?php

use Illuminate\Database\Seeder;

class ReportTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        //factory('App\ReportType', 5)->create(); // needs to be created

        DB::table('report_types')->insert([
            [
                'name' => 'Month',
                'carrier' => 'H2O Wireless',
                'spiff' => 1
            ],
            [
                'name' => 'Residual',
                'carrier' => 'H2O Wireless',
                'spiff' => 0
            ],
            [
                'name' => 'Minute',
                'carrier' => 'H2O Wireless',
                'spiff' => 1
            ],
            [
                'name' => '2nd Recharge',
                'carrier' => 'H2O Wireless',
                'spiff' => 1
            ],
            [
                'name' => '3rd Recharge',
                'carrier' => 'H2O Wireless',
                'spiff' => 1
            ],
            [
                'name' => 'Month',
                'carrier' => 'Lyca Mobile',
                'spiff' => 1
            ],
            [
                'name' => 'Residual',
                'carrier' => 'Lyca Mobile',
                'spiff' => 0
            ],
        ]);
    }
}
