<?php
namespace App\Http\Controllers;

use App\SimMaster;
use App\Sim;
use App\SimResidual;
use App\SimUser;
use App\ReportType;

use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    public function getSims()
    {
    	/**
    	* @todo Not sure if this works 100% correct with pagination... 
    	*/
    	$query_array = [];

        $spiff_query = Sim::select(
        	'sim_number', 
        	'value', 
        	'activation_date', 
        	'mobile_number', 
        	'report_type_id'
        )->get();

        $residual_query = SimResidual::select(
        	'sim_number', 
        	'value', 
        	'activation_date', 
        	'mobile_number', 
        	'report_type_id'
        )->get();

        $query_array = [];

        foreach( $spiff_query as $item ) {
        	$query_array[] = [
	        	'sim_number' => $item->sim_number,
	        	'value' => $item->value,
	        	'activation_date' => $item->activation_date,
	        	'mobile_number' => $item->mobile_number,
	        	'report_type' => $item->report_type->carrier->name . ' ' . $item->report_type->name
        	];
        }

        foreach( $residual_query as $item ) {
        	$query_array[] = [
	        	'sim_number' => $item->sim_number,
	        	'value' => $item->value,
	        	'activation_date' => $item->activation_date,
	        	'mobile_number' => $item->mobile_number,
	        	'report_type' => $item->report_type->carrier->name . ' ' . $item->report_type->name
        	];
        }

        return datatables($query_array)->toJson();
    }

    public function getSimsArchive($id)
    {

   //  	    $testing_array[] = [
	  //       	'sim_number' => '234234234',
	  //       	'value' => '33',
	  //       	'activation_date' => '23423',
	  //       	'mobile_number' => '6196189375'
   //      	];

			// return datatables($testing_array)->toJson();



    	$report_type = ReportType::find($id);
        
        if ($report_type->spiff) {

        	$query = $this->archiveQuery(new Sim(), $id);

        } else {

        	$query = $this->archiveQuery(new SimResidual(), $id);

        }

        return datatables($query)->toJson();
    }

    public function archiveQuery(SimMaster $sims, $id) {

	    return $sims->where('report_type_id', $id)->select(
	    	'sim_number', 
	    	'value', 
	    	'activation_date', 
	    	'mobile_number'
	    );
	}

    public function getSimUsers()
    {
        // $query_array = [];

        // $sim_user_query = SimUser::all();

        // $query_array = [];

        // foreach( $sim_user_query as $item ) {

        //     $query_array[] = [
        //         'sim_number' => $item->sim_number,
        //         'carrier_id' => $item->carrier->name,
        //         'user_id' => $item->user->name
        //     ];
        // }



        return datatables(SimUser::query())->make(true);



        //return datatables($query_array)->toJson();
        //return datatables(SimUser::all())->toJson();
        //return datatables()->of(SimUser::all())->toJson();
        
        //return datatables($query_array->make(true);

        //return Datatables::of(SimUser::all())->make(true);
        //return Datatables::eloquent(SimUser::all())->make(true);

        //return Datatables::of(SimUser::all())->make(true);
    }
}

