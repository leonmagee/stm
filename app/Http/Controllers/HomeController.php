<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers;
use App\Settings;
use App\Site;
use App\ReportType;
use App\User;
use App\UserCreditBonus;
use App\Sim;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /**
        * Create separate methods for getting reports
        * or outputting user homepage?
        */

        $user = \Auth::user();

        if ($user->isAdmin())
        {
            return $this->outputCharts(); 
        } else {
            return $this->outputProfile($user);
        }

    }

    public function outputProfile(User $user) {
        //dd('profile');
        $bonus_credit = UserCreditBonus::where([
            'user_id' => $user->id,
            'date' => Helpers::current_date()
        ])->first();

        if ( isset($bonus_credit->bonus) ) {
            $bonus = '$' . number_format($bonus_credit->bonus, 2);
        } else {
            $bonus = false;
        }
        if ( isset($bonus_credit->credit) ) {
            $credit = '$' . number_format($bonus_credit->credit, 2);
        } else {
            $credit = false;
        }

        $role = $user->role;

        if ( $role == 'admin' ) {
            $role = 'Admin';
        } else {
            $role = Site::find($role)->name;
        }
        return view('users.show_not_admin', compact('user', 'role', 'bonus', 'credit'));
    }

    public function outputCharts() {

        $current_date = Settings::first()->current_date;

        // $data_array = [
        //  [
        //      'title' => 'H2O Wireless Month',
        //      'counts' => [
        //          '200',
        //          '133',
        //          '144'
        //      ]
        //  ],
        // ];

        $data_array = [];

        $array_item = [];

        $date_array = Helpers::date_array();

        $array_index = array_search($current_date, $date_array);

        $one_month_ago = $date_array[$array_index - 1];
        $two_month_ago = $date_array[$array_index - 2];
        $three_month_ago = $date_array[$array_index - 3];

        $date_array_final = [
            $current_date,
            $one_month_ago, 
            $two_month_ago,
            $three_month_ago
        ];

        $date_name_array = [
            Helpers::current_date_name(),
            Helpers::get_date_name($one_month_ago),
            Helpers::get_date_name($two_month_ago),
            Helpers::get_date_name($three_month_ago)
        ];

        $report_types_array = ReportType::where('spiff',1)->get();

        foreach( $report_types_array as $report_type ) {

            $name = $report_type->name;

            $carrier = $report_type->carrier->name;

            $array_item['title'] = $carrier . " " . $name;

            $temp_count = 0;

            foreach( $date_array_final as $date ) {

                $sims = Sim::where([
                    'upload_date' => $date,
                    'report_type_id' => $report_type->id
                ])->latest()->get();

                $number = count($sims);

                $array_item['counts'][] = $number;

                $temp_count += $number;
            }

            if ( $temp_count > 0 ) { // exclude report types with no data
                $data_array[] = $array_item;
            }

            $array_item = [];
        }

        return view('index', compact('data_array', 'date_name_array'));

    }
}
