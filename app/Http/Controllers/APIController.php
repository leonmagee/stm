<?php
namespace App\Http\Controllers;

use App\Helpers;
use App\ReportType;
use App\Sim;
use App\SimMaster;
use App\SimResidual;
use App\UserLoginLogout;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

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

    public function getLogins()
    {
        $logs = UserLoginLogout::with('user')->get();

        return datatables($logs)->make(true);
    }

    public function getLogin($id)
    {
        $logs = UserLoginLogout::where('user_id', $id)->with('user')->get();

        return datatables($logs)->make(true);
    }

    public function archiveQuery(SimMaster $sims, $id)
    {

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

        $user = \Auth::user();

        if ($user->isAdminManagerEmployee()) {
            $sim_users_query = \DB::table('sim_users')
                ->join('users', 'sim_users.user_id', '=', 'users.id')
                ->join('carriers', 'sim_users.carrier_id', '=', 'carriers.id')
                ->select(['sim_users.sim_number', 'carriers.name as carrier_name', 'users.company as company', 'users.name as user_name']);
        } else {
            $sim_users_query = \DB::table('sim_users')
                ->join('users', 'sim_users.user_id', '=', 'users.id')
                ->join('carriers', 'sim_users.carrier_id', '=', 'carriers.id')
                ->where('users.id', $user->id)
                ->select(['sim_users.sim_number', 'carriers.name as carrier_name', 'users.company as company', 'users.name as user_name']);
        }

        return Datatables::of($sim_users_query)->make(true);
    }

    public function getSimUser($id)
    {
        $sim_users_query = \DB::table('sim_users')
            ->join('users', 'sim_users.user_id', '=', 'users.id')
            ->join('carriers', 'sim_users.carrier_id', '=', 'carriers.id')
            ->where('users.id', $id)
            ->select(['sim_users.sim_number', 'carriers.name as carrier_name', 'users.company as company', 'users.name as user_name']);

        return Datatables::of($sim_users_query)->make(true);
    }

}
