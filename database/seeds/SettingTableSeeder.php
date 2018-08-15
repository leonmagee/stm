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
                'company' => 'GS Wireless',
                'mode' => 'online',
                'current_date' => '6_2018',
                //'site_id' => 1,
            ]
        ]);
    }
}
