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
                'report_type_id' => 1,
                'spiff_value' => 10,
                'residual_percent' => 0,
            ],
            [
                'site_id' => 2,
                'report_type_id' => 1,
                'spiff_value' => 5,
                'residual_percent' => 0,
            ],
            [
                'site_id' => 3,
                'report_type_id' => 1,
                'spiff_value' => 8,
                'residual_percent' => 0,
            ],
            [
                'site_id' => 1,
                'report_type_id' => 2,
                'spiff_value' => 0,
                'residual_percent' => 3,
            ],
            [
                'site_id' => 2,
                'report_type_id' => 2,
                'spiff_value' => 0,
                'residual_percent' => 5,
            ],
            [
                'site_id' => 3,
                'report_type_id' => 2,
                'spiff_value' => 0,
                'residual_percent' => 3,
            ],
            [
                'site_id' => 1,
                'report_type_id' => 3,
                'spiff_value' => 20,
                'residual_percent' => 0,
            ],
            [
                'site_id' => 2,
                'report_type_id' => 3,
                'spiff_value' => 15,
                'residual_percent' => 0,
            ],
            [
                'site_id' => 3,
                'report_type_id' => 3,
                'spiff_value' => 18,
                'residual_percent' => 0,
            ],
        ]);
    }
}
