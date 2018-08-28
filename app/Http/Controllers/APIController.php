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
        * @todo very slow change this so the query uses the same type as sim_user.
        * this works for now but it will prob break when there are a large number of residual sims.. 
        * also, this isn't selecting per date... 
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

        //return datatables($query_array)->toJson();
        return datatables($query_array)->make(true);
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

        //return datatables($query)->toJson();
        return datatables($query)->make(true);
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


        /**
        * Maybe try doing this with a select raw?
        * I could also try to include the user name with company
        * it creates a problem now because 'name' is the same key for both users and carriers
        */
        return datatables(SimUser::query()
            ->join('carriers', 'carriers.id', '=', 'sim_users.carrier_id')
            ->join('users', 'users.id', '=', 'sim_users.user_id')
            ->select(
                'sim_users.sim_number', 
                'carriers.name',
                'users.company'
                //'sim_users.user_id',
                //'sim_users.carrier_id'
            ))->make(true);

//->join('contacts', 'users.id', '=', 'contacts.user_id')


        //return datatables($query_array)->toJson();
        //return datatables(SimUser::all())->toJson();
        //return datatables()->of(SimUser::all())->toJson();
        
        //return datatables($query_array->make(true);

        //return Datatables::of(SimUser::all())->make(true);
        //return Datatables::eloquent(SimUser::all())->make(true);

        //return Datatables::of(SimUser::all())->make(true);
    }
}

