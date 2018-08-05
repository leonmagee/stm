<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('settings')->insert([
            [
                'site_id' => 1,
                'current_date' => '07_2018',
                'default_residual_percent' => 5,
                'default_spiff_amount' => 10
            ]
        ]);
    }
}
