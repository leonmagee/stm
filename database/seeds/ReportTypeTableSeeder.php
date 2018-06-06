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
                'carrier_id' => 1,
                'spiff' => 1,
                'created_at' => $current_time,
                'updated_at' => $current_time
            ],
            [
                'name' => 'Residual',
                'carrier_id' => 1,
                'spiff' => 0,
                'created_at' => $current_time,
                'updated_at' => $current_time
            ],
            [
                'name' => 'Minute',
                'carrier_id' => 1,
                'spiff' => 1,
                'created_at' => $current_time,
                'updated_at' => $current_time
            ],
            [
                'name' => '2nd Recharge',
                'carrier_id' => 1,
                'spiff' => 1,
                'created_at' => $current_time,
                'updated_at' => $current_time
            ],
            [
                'name' => '3rd Recharge',
                'carrier_id' => 1,
                'spiff' => 1,
                'created_at' => $current_time,
                'updated_at' => $current_time
            ],
            [
                'name' => 'Month',
                'carrier_id' => 2,
                'spiff' => 1,
                'created_at' => $current_time,
                'updated_at' => $current_time
            ],
            [
                'name' => 'Residual',
                'carrier_id' => 2,
                'spiff' => 0,
                'created_at' => $current_time,
                'updated_at' => $current_time
            ],
        ]);
    }
}
