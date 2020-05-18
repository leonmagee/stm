<?php
namespace App\Http\Controllers;

use App\BalanceTracker;
use App\Helpers;
use App\Invoice;
use App\Note;
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

    public function getNotes()
    {
        $notes = Note::orderBy('created_at', 'DESC')->with('user')->get();
        foreach ($notes as $note) {
            if ($note->user) {
                $user = $note->user->company;
                $note->user_name = $user;
            } else {
                $note->user_name = '';
            }
            $note->date = $note->created_at->format('m/d/Y');
        }
        return datatables($notes)->make(true);
    }

    private static function standardizeBalance($balance)
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

        $balance = self::standardizeBalance($balance);

        return datatables($balance)->make(true);
    }

    public function getBalanceChangesUser()
    {
        $balance = BalanceTracker::where('user_id', \Auth::user()->id)->with(['user', 'admin_user'])->get();

        $balance = self::standardizeBalance($balance);

        return datatables($balance)->make(true);
    }

    public function getBalanceChangesShow(User $user)
    {
        $balance = BalanceTracker::where('user_id', $user->id)->with(['user', 'admin_user'])->get();

        $balance = self::standardizeBalance($balance);

        return datatables($balance)->make(true);
    }

    public function getInvoices()
    {
        $invoices = Invoice::all();
        foreach ($invoices as $item) {
            $item->due_date_new = \Carbon\Carbon::parse($item->due_date)->format('M d, Y');
            $item->invoice_date = $item->created_at->format('M d, Y');
            $item->company = $item->user->company;
            $item->user_name = $item->user->name;

            $total = 0;
            $discount = 0;
            $subtotal = 0;
            foreach ($item->items as $item_new) {
                if ($item_new->item == 3) {
                    $total -= ($item_new->cost * $item_new->quantity);
                    $discount += ($item_new->cost * $item_new->quantity);
                } else {
                    $total += ($item_new->cost * $item_new->quantity);
                    $subtotal += ($item_new->cost * $item_new->quantity);
                }
            }

            $item->total = '$' . number_format($total, 2);

        }

        return datatables($invoices)->make(true);
    }

    public function getInvoicesUser($id)
    {
        $invoices = Invoice::where('user_id', $id)->get();
        foreach ($invoices as $item) {
            $item->due_date_new = \Carbon\Carbon::parse($item->due_date)->format('M d, Y');
            $item->invoice_date = $item->created_at->format('M d, Y');
            $item->company = $item->user->company;
            $item->user_name = $item->user->name;
            $total = 0;
            $discount = 0;
            $subtotal = 0;
            foreach ($item->items as $item_new) {
                if ($item_new->item == 3) {
                    $total -= ($item_new->cost * $item_new->quantity);
                    $discount += ($item_new->cost * $item_new->quantity);
                } else {
                    $total += ($item_new->cost * $item_new->quantity);
                    $subtotal += ($item_new->cost * $item_new->quantity);
                }
            }

            $item->total = '$' . number_format($total, 2);

        }

        return datatables($invoices)->make(true);
    }

    // public static function standardizeCredit($credit)
    // {
    //     foreach ($credit as $item) {
    //         $item->created_at_new = $item->created_at->format('M d, Y');
    //         $item->credit = '$' . number_format($item->credit, 2);
    //         $item->type = str_replace('-', ' ', strtoupper($item->type));
    //     }
    //     return $credit;
    // }

    // public function getCreditRequests()
    // {
    //     $credit_query = CreditTracker::with(['user'])->get();

    //     $credit = self::standardizeCredit($credit_query);

    //     return datatables($credit)->make(true);
    // }

    // public function getCreditRequestsUser()
    // {
    //     $credit_query = CreditTracker::where('user_id', \Auth::user()->id)->with(['user'])->get();

    //     $credit = self::standardizeCredit($credit_query);

    //     return datatables($credit)->make(true);
    // }

    // public function getCreditRequestsShow(User $user)
    // {
    //     $credit_query = CreditTracker::where('user_id', $user->id)->with(['user'])->get();

    //     $credit = self::standardizeCredit($credit_query);

    //     return datatables($credit)->make(true);
    // }

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
