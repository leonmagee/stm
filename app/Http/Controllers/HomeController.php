<?php

namespace App\Http\Controllers;

use App\Carrier;
use App\Helpers;
use App\ReportType;
use App\Settings;
use App\Sim;
use App\User;
use App\UserCreditBonus;

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

        // if (Helpers::is_closed_user()) {
        //     dd('working');
        //     return $this->outputClosedPage();
        // }

        if ($user->isAdmin() || $user->isManager() || $user->isEmployee()) {
            return $this->outputCharts();
        } else {
            if (Helpers::is_site_locked()) {
                return $this->outputLockedPage();
            } else {
                return $this->outputCharts();
            }
            //return $this->outputProfile($user);
        }

    }

    public function commission()
    {
        $h2o_plans = [
            [
                'value' => 20,
                'text' => [
                    'Unlimited Talk & Text Nationwide',
                    '1GB of 4G LTE Data (unlimited at up to 128 kbps speed thereafter)',
                    'Unlimited International Talk to 50+ Countries',
                    '$10 International Talk Credit',
                ],
                'spiff' => [10, 10, 10],
                'rtr' => [
                    'percent' => 6,
                    'description' => 'Top Up',
                ],
                'life' => [
                    'percent' => 3,
                    'description' => '2 Year',
                ],
                'port-in' => [
                    'value' => 0,
                    'description' => 'Extra',
                ],
                'total' => 30,
            ],
            [
                'value' => 30,
                'text' => [
                    'Unlimited Talk & Text Nationwide',
                    '5GB of 4G LTE Data (unlimited at up to 128 kbps speed thereafter)',
                    'Unlimited International Talk to 50+ Countries',
                    '$10 International Talk Credit',
                ],
                'spiff' => [20, 15, 10],
                'rtr' => [
                    'percent' => 6,
                    'description' => 'Top Up',
                ],
                'life' => [
                    'percent' => 3,
                    'description' => '2 Year',
                ],
                'port-in' => [
                    'value' => 0,
                    'description' => 'Extra',
                ],
                'total' => 45,
            ],
            [
                'value' => 40,
                'text' => [
                    'Unlimited Talk & Text Nationwide',
                    '10GB of 4G LTE Data (unlimited at up to 128 kbps speed thereafter)',
                    'Unlimited International Talk to 50+ Countries',
                    '$20 International Talk Credit',
                ],
                'spiff' => [40, 20, 20],
                'rtr' => [
                    'percent' => 6,
                    'description' => 'Top Up',
                ],
                'life' => [
                    'percent' => 3,
                    'description' => '2 Year',
                ],
                'port-in' => [
                    'value' => 0,
                    'description' => 'Extra',
                ],
                'total' => 80,
            ],
            [
                'value' => 50,
                'text' => [
                    'Unlimited Talk & Text Nationwide',
                    '15GB of 4G LTE Data (unlimited at up to 128 kbps speed thereafter)',
                    'Unlimited International Talk to 50+ Countries',
                    '$20 International Talk Credit',
                ],
                'spiff' => [50, 25, 25],
                'rtr' => [
                    'percent' => 6,
                    'description' => 'Top Up',
                ],
                'life' => [
                    'percent' => 3,
                    'description' => '2 Year',
                ],
                'port-in' => [
                    'value' => 0,
                    'description' => 'Extra',
                ],
                'total' => 100,
            ],
            [
                'value' => 60,
                'text' => [
                    'Unlimited Talk & Text Nationwide',
                    'Unlimited 4G LTE Data (unlimited at up to 128 kbps speed thereafter)',
                    'Feature up to 30GB Hotspot',
                    'Unlimited International Talk to 50+ Countries',
                    '$20 International Talk Credit',
                ],
                'spiff' => [60, 30, 30],
                'rtr' => [
                    'percent' => 6,
                    'description' => 'Top Up',
                ],
                'life' => [
                    'percent' => 3,
                    'description' => '2 Year',
                ],
                'port-in' => [
                    'value' => 0,
                    'description' => 'Extra',
                ],
                'total' => 120,
            ],
        ];

        $lyca_plans = [
            [
                //$19    $9    $4    $3    $3
                'value' => 19,
                'text' => [
                    'Unlimited Nationwide Talk, Text and Data',
                    'Unlimited 1GBData at up to 4G LTE',
                    'Unlimited International Talk & Text to 75+ Countries',
                ],
                'spiff' => [9, 4, 3],
                'rtr' => [
                    'percent' => 8,
                    'description' => 'Top Up',
                ],
                'life' => [
                    'percent' => 1,
                    'description' => '1 Year',
                ],
                'port-in' => [
                    'value' => 3,
                    'description' => 'Extra',
                ],
                'total' => 16,
            ],
            [
                //$23    $9    $9    $9    $3
                'value' => 23,
                'text' => [
                    'Unlimited Nationwide Talk & Text',
                    'Unlimited Data with 2GB at up to 4G LTE',
                    'Unlimited International Talk & Text to 75+ Countries',
                    '$1.50 Bonus International Credit',
                ],
                'spiff' => [9, 9, 9],
                'rtr' => [
                    'percent' => 8,
                    'description' => 'Top Up',
                ],
                'life' => [
                    'percent' => 1,
                    'description' => '1 Year',
                ],
                'port-in' => [
                    'value' => 3,
                    'description' => 'Extra',
                ],
                'total' => 27,
            ],
            [
                //$29    $16    $14    $13    $10
                'value' => 29,
                'text' => [
                    'Unlimited Nationwide Talk & Text',
                    'Unlimited Data with 5GB at up to 4G LTE',
                    'Unlimited International Talk & Text to 75+ Countries',
                    '$2.50 Bonus International Credit',
                ],
                'spiff' => [16, 14, 13],
                'rtr' => [
                    'percent' => 8,
                    'description' => 'Top Up',
                ],
                'life' => [
                    'percent' => 1,
                    'description' => '1 Year',
                ],
                'port-in' => [
                    'value' => 10,
                    'description' => 'Extra',
                ],
                'total' => 43,
            ],
            [
                //$35    $15    $11    $3    $13
                'value' => 35,
                'text' => [
                    'Unlimited Nationwide Talk & Text',
                    'Unlimited Data with 7GB at up to 4G LTE',
                    'Unlimited International Talk & Text to 75+ Countries',
                ],
                'spiff' => [15, 11, 3],
                'rtr' => [
                    'percent' => 8,
                    'description' => 'Top Up',
                ],
                'life' => [
                    'percent' => 1,
                    'description' => '1 Year',
                ],
                'port-in' => [
                    'value' => 13,
                    'description' => 'Extra',
                ],
                'total' => 29,
            ],
            [
                //$39    $15    $13    $8    $13
                'value' => 39,
                'text' => [
                    'Unlimited Nationwide Talk and Text',
                    'Unlimited Data with 15GB at up to 4G LTE',
                    'Unlimited International Talk & text to 75+ Countries',
                    '$10 Bonus International Credit',
                ],
                'spiff' => [15, 13, 8],
                'rtr' => [
                    'percent' => 8,
                    'description' => 'Top Up',
                ],
                'life' => [
                    'percent' => 1,
                    'description' => '1 Year',
                ],
                'port-in' => [
                    'value' => 13,
                    'description' => 'Extra',
                ],
                'total' => 36,
            ],
            [
                // $45    $15    $13    $18    $13
                'value' => 45,
                'text' => [
                    'Unlimited Nationwide Talk & Text',
                    'Unlimited Data with 10 GB at up to 4G LTE',
                    'Unlimited International Talk & Text to 75+ Countries',
                ],
                'spiff' => [15, 13, 18],
                'rtr' => [
                    'percent' => 8,
                    'description' => 'Top Up',
                ],
                'life' => [
                    'percent' => 1,
                    'description' => '1 Year',
                ],
                'port-in' => [
                    'value' => 13,
                    'description' => 'Extra',
                ],
                'total' => 46,
            ],
            [
                //$50    $15    $13    $18    $18
                'value' => 50,
                'text' => [
                    'Unlimited Nationwide Talk & text',
                    'Unlimited Nationwide Data at up to 4G LTE',
                    'Unlimited International Talk & Text to 75+ Countries',
                ],
                'spiff' => [15, 13, 18],
                'rtr' => [
                    'percent' => 8,
                    'description' => 'Top Up',
                ],
                'life' => [
                    'percent' => 1,
                    'description' => '1 Year',
                ],
                'port-in' => [
                    'value' => 18,
                    'description' => 'Extra',
                ],
                'total' => 46,
            ],
        ];

        return view('commission', compact('h2o_plans', 'lyca_plans'));
    }

    public function outputLockedPage()
    {
        return view('locked');
    }

    // public function outputClosedPage()
    // {
    //     return view('closed');
    // }

    public function outputProfile(User $user)
    {
        //dd('profile');
        $bonus_credit = UserCreditBonus::where([
            'user_id' => $user->id,
            'date' => Helpers::current_date(),
        ])->first();

        if (isset($bonus_credit->bonus)) {
            $bonus = '$' . number_format($bonus_credit->bonus, 2);
        } else {
            $bonus = false;
        }
        if (isset($bonus_credit->credit)) {
            $credit = '$' . number_format($bonus_credit->credit, 2);
        } else {
            $credit = false;
        }

        // $role = $user->role();

        // dd($user->role->id);

        if ($user->role->id === 1) {
            $role = 'Admin';
        } else {
            //$role = Site::find($role)->name;
            $role = $user->role->name;
        }
        return view('users.show_not_admin', compact('user', 'role', 'bonus', 'credit'));
    }

    public function outputUpload()
    {

        $report_types = ReportType::query()->orderBy('order_index')->get();

        $carriers = Carrier::all();

        $role_id = Helpers::current_role_id();

        $users = User::where('role_id', $role_id)->get();
        return view('sims.upload', compact('report_types', 'users', 'carriers'));
    }

    public function outputCharts()
    {

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
            $three_month_ago,
        ];

        $date_name_array = [
            Helpers::current_date_name(),
            Helpers::get_date_name($one_month_ago),
            Helpers::get_date_name($two_month_ago),
            Helpers::get_date_name($three_month_ago),
        ];

        $report_types_array = ReportType::where('spiff', 1)->orderBy('order_index')->get();

        foreach ($report_types_array as $report_type) {

            $name = $report_type->name;

            $carrier = $report_type->carrier->name;

            $array_item['title'] = $carrier . " " . $name;

            $temp_count = 0;

            foreach ($date_array_final as $date) {

                $sims = Sim::where([
                    'upload_date' => $date,
                    'report_type_id' => $report_type->id,
                ])->get();

                // $sims = Sim::where([
                //     'upload_date' => $date,
                //     'report_type_id' => $report_type->id
                // ])->latest()->get();

                $number = count($sims);

                $array_item['counts'][] = $number;

                $temp_count += $number;
            }

            if ($temp_count > 0) { // exclude report types with no data
                $data_array[] = $array_item;
            }

            $array_item = [];
        }

        return view('index', compact('data_array', 'date_name_array'));

    }
}
