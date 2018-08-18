<?php

use Illuminate\Database\Seeder;

class ReportTypeSiteValueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('report_type_site_values')->insert([
            [
                'plan_value' => 30,
                'payment_amount' => 1,
                'report_type_site_defaults_id' => 1,
            ],
            [
                'plan_value' => 40,
                'payment_amount' => 2,
                'report_type_site_defaults_id' => 1,
            ],
            [
                'plan_value' => 50,
                'payment_amount' => 3,
                'report_type_site_defaults_id' => 1,
            ],
        ]);
    }
}
