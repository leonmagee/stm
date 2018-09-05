<?php

use Illuminate\Database\Seeder;

class ReportTypeSiteDefaultTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

        DB::table('report_type_site_defaults')->insert([
            [
                'site_id' => 1,
                'report_type_id' => 1, // h2o month
                'spiff_value' => null,
                'residual_percent' => null,
            ],
            [
                'site_id' => 1,
                'report_type_id' => 2, // h2o residual
                'spiff_value' => null,
                'residual_percent' => null,
            ],
            [
                'site_id' => 1,
                'report_type_id' => 3, // h2o minute
                'spiff_value' => null,
                'residual_percent' => null,
            ],
            [
                'site_id' => 1,
                'report_type_id' => 4, // h2o instant
                'spiff_value' => null,
                'residual_percent' => null,
            ],
            [
                'site_id' => 1,
                'report_type_id' => 5, // h2o 2nd recharge
                'spiff_value' => null,
                'residual_percent' => null,
            ],
            [
                'site_id' => 1,
                'report_type_id' => 6, // h2o instant 2nd recharge
                'spiff_value' => null,
                'residual_percent' => null,
            ],
            [
                'site_id' => 1,
                'report_type_id' => 7, // h2o minute 2nd recharge
                'spiff_value' => null,
                'residual_percent' => null,
            ],
            [
                'site_id' => 1,
                'report_type_id' => 8, // h2o 3rd recharge
                'spiff_value' => null,
                'residual_percent' => null,
            ],
            [
                'site_id' => 1,
                'report_type_id' => 9, // h2o easy go month
                'spiff_value' => null,
                'residual_percent' => null,
            ],  
            [
                'site_id' => 1,
                'report_type_id' => 10, // h2o easy go residual
                'spiff_value' => null,
                'residual_percent' => 2,
            ],
            [
                'site_id' => 1,
                'report_type_id' => 11, // h2o easy go instant
                'spiff_value' => null,
                'residual_percent' => null,
            ],
            [
                'site_id' => 1,
                'report_type_id' => 12, // h2o easy go 2nd recharge
                'spiff_value' => null,
                'residual_percent' => null,
            ],
            [
                'site_id' => 1,
                'report_type_id' => 13, // h2o easy go 3rd recharge
                'spiff_value' => null,
                'residual_percent' => null,
            ],  
            [
                'site_id' => 1,
                'report_type_id' => 14, // lyca month
                'spiff_value' => null,
                'residual_percent' => null,
            ],
            [
                'site_id' => 1,
                'report_type_id' => 15, // lyca residual
                'spiff_value' => null,
                'residual_percent' => null,
            ],
            [
                'site_id' => 1,
                'report_type_id' => 16, // lyca instant
                'spiff_value' => null,
                'residual_percent' => null,
            ],
            [
                'site_id' => 1,
                'report_type_id' => 17, // lyca 2nd rechage
                'spiff_value' => null,
                'residual_percent' => null,
            ],  
            [
                'site_id' => 1,
                'report_type_id' => 18, // lyca 3rd recharge
                'spiff_value' => null,
                'residual_percent' => null,
            ],                                            
        ]);
    }
}
