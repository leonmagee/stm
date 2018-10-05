<?php
namespace App\Http\Controllers;

use App\SimMaster;
use App\Sim;
use App\SimResidual;
use App\SimUser;
use App\ReportType;
use App\Helpers;

use Illuminate\Support\Facades\DB;

class APIController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
  
    public function getSimsArchive($id)
    {
    	$report_type = ReportType::find($id);
        
        if ($report_type->spiff) {

        	$query = $this->archiveQuery(new Sim(), $id);

        } else {

        	$query = $this->archiveQuery(new SimResidual(), $id);

        }

        return datatables($query)->make(true);
    }

    public function archiveQuery(SimMaster $sims, $id) {

	    return $sims->where(
            [
                'report_type_id' => $id,
                'upload_date' => Helpers::current_date(),
            ]
        )->select(
	    	'sim_number', 
	    	'value', 
	    	'activation_date', 
	    	'mobile_number'
	    );
	}

    public function getSimUsers()
    {

        /**
        * Maybe try doing this with a select raw?
        * I could also try to include the user name with company
        * it creates a problem now because 'name' is the same key for both users and carriers
        */
        //return datatables(SimUser::all())->make(true);

        return datatables(
            \DB::select( \DB::raw(
                "SELECT sim_users.sim_number, carriers.name, users.company 
                FROM sim_users, carriers, users WHERE sim_users.user_id = :user_id AND sim_users.carrier_id = carriers.id AND sim_users.user_id = users.id"), array(
               'user_id' => 12,
             ))
        )->make(true);



        // return datatables(SimUser::query()
        //     ->select(
        //         'sim_users.sim_number', 
        //         'sim_users.user_id',
        //         'sim_users.carrier_id'
        //     ))->make(true);



        // return datatables(SimUser::query()
        //     ->join('carriers', 'carriers.id', '=', 'sim_users.carrier_id')
        //     ->join('users', 'users.id', '=', 'sim_users.user_id')
        //     ->select(
        //         'sim_users.sim_number', 
        //         'carriers.name',
        //         'users.company'
        //         //'sim_users.user_id',
        //         //'sim_users.carrier_id'
        //     ))->make(true);

    }

    public function getSimUser($id)
    {
        return datatables(SimUser::query()
            ->join('carriers', 'carriers.id', '=', 'sim_users.carrier_id')
            ->join('users', 'users.id', '=', 'sim_users.user_id')
            ->where('users.id', $id)
            ->select(
                'sim_users.sim_number', 
                'carriers.name',
                'users.company'
            ))->make(true);
    }
}

