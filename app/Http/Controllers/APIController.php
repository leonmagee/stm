<?php
namespace App\Http\Controllers;

use App\BalanceTracker;
use App\Helpers;
use App\ImeiSearch;
use App\Invoice;
use App\Note;
use App\Product;
use App\Purchase;
use App\ReportType;
use App\Rma;
use App\Sim;
use App\SimMaster;
use App\SimResidual;
use App\User;
use App\UserLoginLogout;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use \Carbon\Carbon;

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
        $user = \Auth::user();
        if ($user) {
            if ($user->isAdminManagerEmployee()) {
                $logs = UserLoginLogout::select('user_login_logouts.id', 'user_login_logouts.login', 'user_login_logouts.logout', 'users.company', 'users.name')->join('users', 'users.id', 'user_login_logouts.user_id')->get();
            } elseif ($site_id = $user->isMasterAgent()) {
                $role_id = Helpers::get_role_id($site_id);
                $logs = UserLoginLogout::select('user_login_logouts.id', 'user_login_logouts.login', 'user_login_logouts.logout', 'users.company', 'users.name')->join('users', 'users.id', 'user_login_logouts.user_id')->where('users.role_id', $role_id)->get();
            } else {
                return redirect('/');
            }
            return datatables($logs)->make(true);
        }
        return redirect('/');
    }

    public function getImeiRecords()
    {
        $user = \Auth::user();
        if ($user) {
            if ($user->isAdminManagerEmployee()) {
                $data = ImeiSearch::all();
                // $logs = UserLoginLogout::select('user_login_logouts.id', 'user_login_logouts.login', 'user_login_logouts.logout', 'users.company', 'users.name')->join('users', 'users.id', 'user_login_logouts.user_id')->get();
            } elseif ($site_id = $user->isMasterAgent()) {
                // $role_id = Helpers::get_role_id($site_id);
                // $logs = UserLoginLogout::select('user_login_logouts.id', 'user_login_logouts.login', 'user_login_logouts.logout', 'users.company', 'users.name')->join('users', 'users.id', 'user_login_logouts.user_id')->where('users.role_id', $role_id)->get();
            } else {
                return redirect('/');
            }
            return datatables($data)->make(true);
        }
        return redirect('/');

    }

    public function getProducts()
    {
        $products = Product::all();
        foreach ($products as $product) {
            $quantity = 0;
            if (count($product->variations)) {
                foreach ($product->variations as $variation) {
                    $quantity += $variation->quantity;
                }
            }
            $product->quantity = $quantity;
            if ($product->cost) {
                $product->cost_val = '$' . number_format($product->cost, 2);
            }
            if ($product->discount) {
                $product->discount_val = $product->discount . '%';
            } else {
                $product->discount_val = '';
            }
            $product->total = '$' . $product->discount_cost();
        }

        return datatables($products)->make(true);
    }

    public function getPurchases()
    {
        $purchases = Purchase::with('user')->get();
        foreach ($purchases as $key => $purchase) {
            if ($purchase->user) {
                $purchase->total = '$' . number_format($purchase->total, 2);
            } else {
                unset($purchase[$key]);
            }
            $purchase->type = \strtoupper($purchase->type);
            $purchase->date = $purchase->created_at->format('M d, Y');
        }

        return datatables($purchases)->make(true);
    }

    public function getPurchasesDealer()
    {
        $user = \Auth::user();
        if ($site_id = $user->isMasterAgent()) {
            $role_id = Helpers::get_role_id($site_id);
            $purchases = Purchase::select('purchases.id', 'users.company', 'users.name', 'purchases.total', 'purchases.type', 'purchases.created_at', 'purchases.status')->join('users', 'users.id', 'purchases.user_id')->where('users.role_id', $role_id)->get();
            if ($purchases) {
                foreach ($purchases as $key => $purchase) {
                    $purchase->total = '$' . number_format($purchase->total, 2);
                    $purchase->type = \strtoupper($purchase->type);
                    $purchase->date = $purchase->created_at->format('M d, Y');
                }
            }
            return datatables($purchases)->make(true);
        }
    }

    public function getRmas()
    {
        $user = \Auth::user();
        if ($user->isAdminManagerEmployee()) {
            //$rmas = Rma::with(['user', 'product'])->get();
            $rmas = RMA::select(
                'rmas.id',
                'rmas.quantity',
                'rmas.created_at',
                'rmas.status',
                'users.company',
                'users.name as user_name',
                'purchase_products.name as product_name'
            )
                ->join('users', 'users.id', 'rmas.user_id')
                ->join('purchase_products', 'purchase_products.id', 'rmas.purchase_product_id')
                ->get();
        } elseif ($user->isMasterAgent()) {
            $site_id = $user->master_agent_site;
            $role_id = Helpers::get_role_id($site_id);
            $rmas = RMA::select(
                'rmas.id',
                'rmas.quantity',
                'rmas.created_at',
                'rmas.status',
                'users.company',
                'users.name as user_name',
                'purchase_products.name as product_name'
            )
                ->join('users', 'users.id', 'rmas.user_id')
                ->join('purchase_products', 'purchase_products.id', 'rmas.purchase_product_id')
                ->where('users.role_id', $role_id)
                ->get();
        } else {
            return false;
        }
        foreach ($rmas as $key => $rma) {
            if ($rma->user) {
                $rma->total = '$' . number_format($rma->total, 2);
            } else {
                unset($rma[$key]);
            }
            $rma->date = $rma->created_at->format('M d, Y');
        }

        return datatables($rmas)->make(true);
    }

    public function getNotes()
    {
        $notes = Note::orderBy('created_at', 'DESC')->with('user')->get();
        foreach ($notes as $key => $note) {
            if ($note->user) {
                $user = $note->user->company;
                $note->user_name = $user;
            } else {
                // remove ones without users
                unset($notes[$key]);
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

    public function getBalanceChangesDealer()
    {
        $site_id = \Auth::user()->isMasterAgent();
        if ($site_id) {
            $role_id = Helpers::get_role_id($site_id);
            //dd($role_id);
            // select('purchases.id', 'users.company', 'users.name', 'purchases.total', 'purchases.type', 'purchases.created_at', 'purchases.status')

            //$balance = BalanceTracker::with(['user', 'admin_user'])->select('balance_trackers.id', 'user.company', 'admin_user.name')->join('users', 'users.id', 'balance_trackers.user_id')->where('users.role_id', $role_id)->get();
            $balance = BalanceTracker::select('balance_trackers.id', 'balance_trackers.previous_balance', 'balance_trackers.difference', 'balance_trackers.new_balance', 'balance_trackers.created_at', 'balance_trackers.note', 'balance_trackers.status', 'users.company', 'admin_users.name')->leftJoin('users', 'users.id', 'balance_trackers.user_id')->leftJoin('users as admin_users', 'admin_users.id', 'balance_trackers.admin_id')->where('users.role_id', $role_id)->get();
            $balance = self::standardizeBalance($balance);
            return datatables($balance)->make(true);
        }
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
        $user = \Auth::user();
        $query = Invoice::select(
            'invoices.id',
            'invoices.created_at',
            'invoices.status',
            'users.company',
            'users.name')
            ->join('users', 'users.id', 'invoices.user_id');

        if ($user->isAdmin()) {
            $invoices = $query->get();
        } elseif ($site_id = $user->isMasterAgent()) {
            $role_id = Helpers::get_role_id($site_id);
            $invoices = $query
                ->where('users.role_id', $role_id)
                ->get();
        } else {
            return false;
        }
        foreach ($invoices as $item) {
            $item->due_date_new = \Carbon\Carbon::parse($item->due_date)->format('M d, Y');
            $item->invoice_date = $item->created_at->format('M d, Y');
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
                ->select(['sim_users.sim_number', 'carriers.name as carrier_name', 'users.company as company', 'users.name as user_name', 'sim_users.created_at'])
                ->orderBy('created_at', 'DESC');
        } else {
            $sim_users_query = \DB::table('sim_users')
                ->join('users', 'sim_users.user_id', '=', 'users.id')
                ->join('carriers', 'sim_users.carrier_id', '=', 'carriers.id')
                ->where('users.id', $user->id)
                ->select(['sim_users.sim_number', 'carriers.name as carrier_name', 'users.company as company', 'users.name as user_name', 'sim_users.created_at'])
                ->orderBy('created_at', 'DESC');
        }

        return Datatables::of($sim_users_query)->editColumn('created_at', function ($item) {
            return Carbon::parse($item->created_at)->format('M d, Y');
        })->make(true);

    }

    public function getSimUser($id)
    {
        $sim_users_query = \DB::table('sim_users')
            ->join('users', 'sim_users.user_id', '=', 'users.id')
            ->join('carriers', 'sim_users.carrier_id', '=', 'carriers.id')
            ->where('users.id', $id)
            ->select(['sim_users.sim_number', 'carriers.name as carrier_name', 'users.company as company', 'users.name as user_name', 'sim_users.created_at'])
            ->orderBy('created_at', 'DESC');

        //return Datatables::of($sim_users_query)->make(true);
        return Datatables::of($sim_users_query)->editColumn('created_at', function ($item) {
            return Carbon::parse($item->created_at)->format('M d, Y');
        })->make(true);

    }

}
