<?php

use Illuminate\Database\Seeder;
//use SimsTableSeeder;

class SimTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    //protected $toTruncate = ['users', 'sims', 'report_types'];

    public function run()
    {



        //         'sim_number' => rand(98729237491111111, 98729237499999999),
        // 'value' => rand(20,60),
        // 'activation_date' => '12/17/2017',
        // 'mobile_number' => rand(6191111111,6199999999),
        // 'report_type_id' => rand(1,7), // report type id will tell you the name and carrier
        // 'upload_date' => '6_2018',
        

        DB::table('sims')->insert([
            [
                'sim_number' => 1111111111111111,
                'value' => 30,
                'activation_date' => '12/17/2017',
                'mobile_number' => 6196189375,
                'report_type_id' => 1,
                'upload_date' => '6_2018',
            ],
            [
                'sim_number' => 1111111111111112,
                'value' => 30,
                'activation_date' => '12/14/2017',
                'mobile_number' => 6196189375,
                'report_type_id' => 1,
                'upload_date' => '6_2018',
            ],
            [
                'sim_number' => 1111111111111113,
                'value' => 40,
                'activation_date' => '12/17/2017',
                'mobile_number' => 6196189375,
                'report_type_id' => 1,
                'upload_date' => '6_2018',
            ],
            [
                'sim_number' => 1111111111111114,
                'value' => 40,
                'activation_date' => '12/14/2017',
                'mobile_number' => 6196189375,
                'report_type_id' => 1,
                'upload_date' => '6_2018',
            ],
            [
                'sim_number' => 1111111111111115,
                'value' => 50,
                'activation_date' => '12/17/2017',
                'mobile_number' => 6196189375,
                'report_type_id' => 1,
                'upload_date' => '6_2018',
            ],          
        ]);



        //factory('App\Sim',300)->create();


        //$this->call(SimsTableSeeder::class);


        //DB::table('users')->truncate();
        // foreach( $this->toTruncate as $table ) {
        //     DB::table($table)->truncate();
        // }
        
        // factory('App\SimUser',10)->create();
        // factory('App\User', 10)->create();
        //factory('App\ReportType')->create(); // needs to be created
        //factory('App\ReportType')->make(); // does not persist
    }
}
