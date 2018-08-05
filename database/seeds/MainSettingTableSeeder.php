<?php

use Illuminate\Database\Seeder;

class MainSettingTableSeeder extends Seeder
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
                'current_date' => '07_2018',
            ]
        ]);
    }
}
