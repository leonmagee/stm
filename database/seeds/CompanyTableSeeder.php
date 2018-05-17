<?php

use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        DB::table('companies')->insert([
            [
                'name' => 'GS Wireless',
            ],
            [
                'name' => 'Loco Mobile',
            ],
            [
                'name' => 'Sim Satisfaction',
            ],
        ]);
    }
}
