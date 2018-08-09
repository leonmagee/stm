<?php

use Illuminate\Database\Seeder;

class SiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('sites')->insert([
            [
                'name' => 'Agent',
                'default_residual_percent' => 5,
                'default_spiff_amount' => 10
            ],
            [
                'name' => 'Dealer',
                'default_residual_percent' => 3,
                'default_spiff_amount' => 5
            ],
            [
                'name' => 'Signature Store',
                'default_residual_percent' => 4,
                'default_spiff_amount' => 8
            ],
        ]);
    }
}
