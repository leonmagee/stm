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
                'role_id' => 3,
                'default_residual_percent' => 1,
                'default_spiff_amount' => 0
            ],
            [
                'name' => 'Dealer',
                'role_id' => 4,
                'default_residual_percent' => 0,
                'default_spiff_amount' => 10
            ],
            [
                'name' => 'Signature Store',
                'role_id' => 5,
                'default_residual_percent' => 0,
                'default_spiff_amount' => 0
            ],
        ]);
    }
}
