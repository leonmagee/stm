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
                'name' => 'Agents',
                'company_id' => 1
            ],
            [
                'name' => 'Dealers',
                'company_id' => 1
            ],
            [
                'name' => 'Signature Store',
                'company_id' => 1
            ],
            [
                'name' => 'Misc Dudes',
                'company_id' => 2
            ],
            [
                'name' => 'Random Peeps',
                'company_id' => 3
            ],
        ]);
    }
}
