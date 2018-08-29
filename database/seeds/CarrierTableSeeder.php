<?php

use Illuminate\Database\Seeder;
use \Carbon\Carbon;

class CarrierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $current_time =  Carbon::now()->format('Y-m-d H:i:s');

        DB::table('carriers')->insert([
            [
                'name' => 'H2O',
                'created_at' => $current_time,
                'updated_at' => $current_time
            ],
            [
                'name' => 'Lyca',
                'created_at' => $current_time,
                'updated_at' => $current_time
            ],
            [
                'name' => 'Boost',
                'created_at' => $current_time,
                'updated_at' => $current_time
            ]
        ]);
    }
}
