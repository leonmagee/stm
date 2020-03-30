<?php
namespace App\Http\Controllers;

use App\BalanceTracker;
use App\Helpers;
use App\ReportType;
use App\Sim;
use App\SimMaster;
use App\SimResidual;
use App\User;
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

    private static function processBalance($balance)
    {
        foreach ($balance as $item) {
            if ($item->difference < 0) {
                $item->difference = '-$' . number_format(abs($item->difference), 2);
            } else {
                $item->difference = '$' . number_format($item->difference, 2);
            }
            $item->previous_balance = '$' . number_format($item->previous_balance, 2);
            $item->new_balance = '$' . number_format($item->new_balance, 2);
            $item->created_at_new = $item->created_at->format('M d, Y');
        }

        return $balance;
    }

    public function getBalanceChanges()
    {
        $balance = BalanceTracker::with(['user', 'admin_user'])->get();

        $balance = self::processBalance($balance);

        return datatables($balance)->make(true);
    }

    public function getBalanceChangesUser()
    {
        $balance = BalanceTracker::where('user_id', \Auth::user()->id)->with(['user', 'admin_user'])->get();

        $balance = self::processBalance($balance);

        return datatables($balance)->make(true);
    }

    public function getBalanceChangesShow(User $user)
    {
        \Log::info('its sunday' . $user);
        $balance = BalanceTracker::where('user_id', $user->id)->with(['user', 'admin_user'])->get();

        $balance = self::processBalance($balance);

        return datatables($balance)->make(true);
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
