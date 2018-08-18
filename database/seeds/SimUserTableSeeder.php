<?php

use Illuminate\Database\Seeder;
//use SimsTableSeeder;

class SimUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
    	DB::table('sim_users')->insert([
    		[
    			'user_id' => 3,
    			'carrier_id' => 1,
    			'sim_number' => 1111111111111111,
    		],
    		[
    			'user_id' => 3,
    			'carrier_id' => 1,
    			'sim_number' => 1111111111111112,
    		],
    		[
    			'user_id' => 3,
    			'carrier_id' => 1,
    			'sim_number' => 1111111111111113,
    		],
    		[
    			'user_id' => 3,
    			'carrier_id' => 1,
    			'sim_number' => 1111111111111114,
    		],
    		[
    			'user_id' => 3,
    			'carrier_id' => 1,
    			'sim_number' => 1111111111111115,
    		],          
    	]);

        //factory('App\SimUser',10)->create();
    }
}
