<?php
namespace App\Http\Controllers;

use App\Sim;
use App\SimResidual;

use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    public function getSims()
    {
        //$query = ::select('first_name', 'last_name', 'email');
        //dd('working?');
        //$query = Sim::all();
        // $query = Sim::select(
        // 	'sim_number', 
        // 	'value', 
        // 	'activation_date', 
        // 	'mobile_number', 
        // 	'report_type_id'
        // );

        //return datatables($query)->make(true);
        //return datatables($query)->toJson();
        return datatables(Sim::all())->toJson();

        //$demo_arry = ['1', '2', '3', '4', '5'];

        //return datatables($demo_arry)->toJson();
    }
}