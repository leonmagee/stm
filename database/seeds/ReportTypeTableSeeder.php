<?php

use Illuminate\Database\Seeder;
use \Carbon\Carbon;

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

        $current_time =  Carbon::now()->format('Y-m-d H:i:s');

        DB::table('report_types')->insert([
            [
                'name' => 'Month',
                'carrier' => 'H2O Wireless',
                'spiff' => 1,
                'created_at' => $current_time,
                'updated_at' => $current_time
            ],
            [
                'name' => 'Residual',
                'carrier' => 'H2O Wireless',
                'spiff' => 0,
                'created_at' => $current_time,
                'updated_at' => $current_time
            ],
            [
                'name' => 'Minute',
                'carrier' => 'H2O Wireless',
                'spiff' => 1,
                'created_at' => $current_time,
                'updated_at' => $current_time
            ],
            [
                'name' => '2nd Recharge',
                'carrier' => 'H2O Wireless',
                'spiff' => 1,
                'created_at' => $current_time,
                'updated_at' => $current_time
            ],
            [
                'name' => '3rd Recharge',
                'carrier' => 'H2O Wireless',
                'spiff' => 1,
                'created_at' => $current_time,
                'updated_at' => $current_time
            ],
            [
                'name' => 'Month',
                'carrier' => 'Lyca Mobile',
                'spiff' => 1,
                'created_at' => $current_time,
                'updated_at' => $current_time
            ],
            [
                'name' => 'Residual',
                'carrier' => 'Lyca Mobile',
                'spiff' => 0,
                'created_at' => $current_time,
                'updated_at' => $current_time
            ],
        ]);
    }
}
