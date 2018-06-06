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
        //$this->call(SimsTableSeeder::class);


        //DB::table('users')->truncate();
        // foreach( $this->toTruncate as $table ) {
        //     DB::table($table)->truncate();
        // }
        factory('App\Sim',300)->create();
        // factory('App\SimUser',10)->create();
        // factory('App\User', 10)->create();
        //factory('App\ReportType')->create(); // needs to be created
        //factory('App\ReportType')->make(); // does not persist
    }
}
