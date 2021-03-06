<?php

namespace App\Http\Controllers;

use App\Archive;
use App\Helpers;
use App\ReportData;
use App\ReportType;
use App\ReportTypeSiteDefault;
use App\ReportUserCSV;
use App\Settings;
use App\Site;
use App\User;
use App\UserPlanValues;
use App\UserResidualPercent;
use Illuminate\Http\Request;
use \DB;

class ReportsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Settings::first();
        $current_date = $settings->current_date;
        $current_site_date = Helpers::get_date_name($current_date);
        /**
         * Here the site needs to change per user if it's we're looking just talking about a single user...
         */
        $current_user = \Auth::user();
        if ($current_user->isAdmin() || $current_user->isManager() || $current_user->isEmployee()) {
            $site_id = $settings->get_site_id();
        } else {
            $site_id = $current_user->site_id();
        }
        $site = Site::find($site_id);
        $site_name = $site->name;

        /**
         * Get report_type_sites_default table data
         */
        $defaults_array_orig = ReportTypeSiteDefault::where([
            'site_id' => $site_id,
        ])->with('report_type_site_values')->get()->toArray();

        $defaults_array = [];
        foreach ($defaults_array_orig as $item) {
            $defaults_array[$item['report_type_id']] = $item;
        }

        /**
         * Get Residual Overrides
         */
        $user_residual = UserResidualPercent::all()->toArray();
        $user_residual_override = [];
        foreach ($user_residual as $item) {
            $user_residual_override[$item['user_id']][] = $item;
        }

        /**
         * Get Spiff Overrides
         */
        $user_spiff = UserPlanValues::all()->toArray();
        $user_spiff_override = [];
        foreach ($user_spiff as $item) {
            $user_spiff_override[$item['user_id']][] = $item;
        }

        /**
         * Get ReportData
         */
        $report_data_object = new ReportData($site_id, $current_date, null, $defaults_array, $user_residual_override, $user_spiff_override, $site);
        $total_payment_all_users = $report_data_object->total_payment_all_users;
        // $total_payment_all_users = false;
        /**
         * Residual total listing - only for master agents
         */
        $not_in_array = [1, 2, 3, 4];
        if (!in_array($site_id, $not_in_array) && \Auth::user()->isAdmin()) {
            $total_payments_residual = $report_data_object->total_payments_residual;
        } else {
            $total_payments_residual = [];
        }
        //dd($total_payments_residual);
        if (!\Auth::user()->isAdmin()) {
            $is_single = true;
        } else {
            $is_single = false;
        }

        $report_data_array = $report_data_object->report_data;
        $is_admin = Helpers::current_user_admin();

        return view('reports.index', compact(
            'site_name',
            'current_site_date',
            'report_data_array',
            'total_payment_all_users',
            'total_payments_residual',
            'is_admin',
            'is_single'
        ));
    }

    /**
     * This should only apply to agents with dealers under them to show that report.
     * The 'site_id' will be the 'master_agent_site' from the users table.
     *
     * @return \Illuminate\Http\Response
     */
    public function dealer_reports()
    {

        $settings = Settings::first();
        $current_date = $settings->current_date;
        $current_site_date = Helpers::get_date_name($current_date);
        $current_user = \Auth::user();
        // if ($current_user->isAdmin() || $current_user->isManager() || $current_user->isEmployee()) {
        //     $site_id = $settings->get_site_id();
        // } else {
        //     $site_id = $current_user->site_id();
        // }
        $user = \Auth::user();
        $site_id = $user->isMasterAgent();
        if (!$site_id) {
            return redirect('/');
        }
        $site = Site::find($site_id);

        $site_name = $site->name;

        /**
         * Get report_type_sites_default table data
         */
        $defaults_array_orig = ReportTypeSiteDefault::where([
            'site_id' => $site_id,
        ])->with('report_type_site_values')->get()->toArray();

        $defaults_array = [];
        foreach ($defaults_array_orig as $item) {
            $defaults_array[$item['report_type_id']] = $item;
        }

        /**
         * Get Residual Overrides
         */
        $user_residual = UserResidualPercent::all()->toArray();
        $user_residual_override = [];
        foreach ($user_residual as $item) {
            $user_residual_override[$item['user_id']][] = $item;
        }

        /**
         * Get Spiff Overrides
         */
        $user_spiff = UserPlanValues::all()->toArray();
        $user_spiff_override = [];
        foreach ($user_spiff as $item) {
            $user_spiff_override[$item['user_id']][] = $item;
        }

        /**
         * Get ReportData
         */

        $report_data_object = new ReportData($site_id, $current_date, null, $defaults_array, $user_residual_override, $user_spiff_override, $site, $current_user->isMasterAgent());
        $total_payment_all_users = $report_data_object->total_payment_all_users;
        $total_payments_residual = $report_data_object->total_payments_residual;
        //$total_payments_residual = [];
        $report_data_array = $report_data_object->report_data;
        $is_admin = Helpers::current_user_admin();
        return view('reports.index', compact(
            'site_name',
            'current_site_date',
            'report_data_array',
            'total_payment_all_users',
            'total_payments_residual',
            'is_admin'
        ));

    }

    /**
     * Report Totals Page
     */
    public function totals()
    {
        $current_date = Settings::first()->current_date;
        $current_site_date = Helpers::current_date_name();
        $site_id = Settings::first()->get_site_id();
        $site = Site::find($site_id);
        $site_name = $site->name;
        $role_id = $site->role_id;
        $report_types = ReportType::query()->orderBy('order_index')->get();
        $current_date = Helpers::current_date();
        $report_type_totals_array = [];
        $total_count_final = 0;
        $total_count_final_res = 0;

        foreach ($report_types as $report_type) {

            //dd($report_type);

            if ($report_type->spiff) {

                $matching_sims_count = DB::table('sims')
                    ->select('sims.value', 'sims.report_type_id')
                    ->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
                    ->join('users', 'users.id', '=', 'sim_users.user_id')
                    ->where('sims.report_type_id', $report_type->id)
                    ->where('sims.upload_date', $current_date)
                    ->where('users.role_id', $role_id)
                    ->count();

                $name = $report_type->carrier->name . ' ' . $report_type->name;

                //$report_type_totals_array[$name] = $matching_sims_count;
                $report_type_totals_array[] = [
                    'name' => $name,
                    'count' => $matching_sims_count,
                    'carrier' => $report_type->carrier_id,
                ];
                $total_count_final += $matching_sims_count;

            } else {

                $matching_sims_count = DB::table('sim_residuals')
                    ->select('sim_residuals.value', 'sim_residuals.report_type_id')
                    ->join('sim_users', 'sim_users.sim_number', '=', 'sim_residuals.sim_number')
                    ->join('users', 'users.id', '=', 'sim_users.user_id')
                    ->where('sim_residuals.report_type_id', $report_type->id)
                    ->where('sim_residuals.upload_date', $current_date)
                    ->where('users.role_id', $role_id)
                    ->count();

                $name = $report_type->carrier->name . ' ' . $report_type->name;

                //$report_type_totals_array[$name] = $matching_sims_count;
                $report_type_totals_array[] = [
                    'name' => $name,
                    'count' => $matching_sims_count,
                    'carrier' => $report_type->carrier_id,
                ];

                $total_count_final_res += $matching_sims_count;
            }
        }

        //dd($report_type_totals_array);

        return view('reports.totals', compact(
            'site_name',
            'current_site_date',
            'report_type_totals_array',
            'total_count_final',
            'total_count_final_res'
        ));
    }

    /**
     * Report Totals Page
     */
    public function totals_dealers()
    {
        $current_date = Settings::first()->current_date;
        $current_site_date = Helpers::current_date_name();
        $user = \Auth::user();
        $site_id = $user->isMasterAgent();
        //$site_id = Settings::first()->get_site_id();
        $site = Site::find($site_id);
        $site_name = $site->name;
        $role_id = $site->role_id;
        $report_types = ReportType::query()->orderBy('order_index')->get();
        $current_date = Helpers::current_date();
        $report_type_totals_array = [];
        $total_count_final = 0;
        $total_count_final_res = 0;

        foreach ($report_types as $report_type) {

            if ($report_type->spiff) {

                $matching_sims_count = DB::table('sims')
                    ->select('sims.value', 'sims.report_type_id')
                    ->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
                    ->join('users', 'users.id', '=', 'sim_users.user_id')
                    ->where('sims.report_type_id', $report_type->id)
                    ->where('sims.upload_date', $current_date)
                    ->where('users.role_id', $role_id)
                    ->count();

                $name = $report_type->carrier->name . ' ' . $report_type->name;

                //$report_type_totals_array[$name] = $matching_sims_count;
                $report_type_totals_array[] = [
                    'name' => $name,
                    'count' => $matching_sims_count,
                    'carrier' => $report_type->carrier_id,
                ];

                $total_count_final += $matching_sims_count;
            } else {

                $matching_sims_count = DB::table('sim_residuals')
                    ->select('sim_residuals.value', 'sim_residuals.report_type_id')
                    ->join('sim_users', 'sim_users.sim_number', '=', 'sim_residuals.sim_number')
                    ->join('users', 'users.id', '=', 'sim_users.user_id')
                    ->where('sim_residuals.report_type_id', $report_type->id)
                    ->where('sim_residuals.upload_date', $current_date)
                    ->where('users.role_id', $role_id)
                    ->count();

                $name = $report_type->carrier->name . ' ' . $report_type->name;

                //$report_type_totals_array[$name] = $matching_sims_count;
                $report_type_totals_array[] = [
                    'name' => $name,
                    'count' => $matching_sims_count,
                    'carrier' => $report_type->carrier_id,
                ];

                $total_count_final_res += $matching_sims_count;
            }
        }

        return view('reports.totals', compact(
            'site_name',
            'current_site_date',
            'report_type_totals_array',
            'total_count_final',
            'total_count_final_res'
        ));
    }

    private static function recharge_data($master_agent_id = null)
    {
        $current_date = Settings::first()->current_date;

        if ($master_agent_id) {
            $role_id = Helpers::get_role_id($master_agent_id);
            $users = User::where('role_id', $role_id)->orderBy('company')->get();
        } else {
            $role_id = Helpers::current_role_id();
            if (Helpers::is_normal_user()) {
                $logged_in_user = \Auth::user();
                $users = User::where('id', $logged_in_user->id)->get();
            } else {
                $users = User::where('role_id', $role_id)->orderBy('company')->get();
            }
        }

        $recharge_data_array = [];

        /**
         * I need to chagne this so it combines multiple report types, so I can
         * use both regular and instant...
         * @todo I need to add instant and second recharge HDN do this data
         */
        $config_array = [ // this can be changed for different report types
            'current' => 1, // Month
            //'current_instant' => 4, // Emida / GS Posa
            'current_bundles' => 23, // Bundles
            'current_hdn' => 25, // Instant HDN
            // 'current_instant_hdn' => 19, // this isn't necessary
            'recharge' => 5, // H2O 2nd Recharge
            //'recharge_instant' => 6, // H2O 2nd Rechage Instant
            'recharge_instant_hdn' => 19, // H2O 2nd Recharge HDN
            'recharge_bundles' => 24, // H2O 2nd Recharge HDN
        ];

        $report_type_current = ReportType::find($config_array['current']);
        //$report_type_current_instant = ReportType::find($config_array['current_instant']);
        $report_type_current_bundles = ReportType::find($config_array['current_bundles']);
        $report_type_current_hdn = ReportType::find($config_array['current_hdn']);
        $report_type_recharge = ReportType::find($config_array['recharge']);
        //$report_type_recharge_instant = ReportType::find($config_array['recharge_instant']);
        $report_type_recharge_hdn = ReportType::find($config_array['recharge_instant_hdn']);
        $report_type_recharge_bundles = ReportType::find($config_array['recharge_bundles']);

        $date_array = Helpers::date_array();

        $array_index = array_search($current_date, $date_array);

        $one_month_ago = $date_array[$array_index - 1];
        $two_months_ago = $date_array[$array_index - 2];
        $three_months_ago = $date_array[$array_index - 3];

        $recarge_search_array = [
            [
                [
                    'rt_id' => $report_type_current->id,
                    //'rt_i_id' => $report_type_current_instant->id,
                    'rt_bnd_id' => $report_type_current_bundles->id,
                    'rt_hdn_id' => $report_type_current_hdn->id,
                    'date' => $one_month_ago,
                ],
                [
                    'rt_id' => $report_type_recharge->id,
                    //'rt_i_id' => $report_type_recharge_instant->id,
                    'rt_hdn_id' => $report_type_recharge_hdn->id,
                    'rt_bnd_id' => $report_type_recharge_bundles->id,
                    'date' => $current_date,
                ],
            ],
            [
                [
                    'rt_id' => $report_type_current->id,
                    //'rt_i_id' => $report_type_current_instant->id,
                    'rt_bnd_id' => $report_type_current_bundles->id,
                    'rt_hdn_id' => $report_type_current_hdn->id,
                    'date' => $two_months_ago,
                ],
                [
                    'rt_id' => $report_type_recharge->id,
                    //'rt_i_id' => $report_type_recharge_instant->id,
                    'rt_hdn_id' => $report_type_recharge_hdn->id,
                    'rt_bnd_id' => $report_type_recharge_bundles->id,
                    'date' => $one_month_ago,
                ],
            ],
            [
                [
                    'rt_id' => $report_type_current->id,
                    //'rt_i_id' => $report_type_current_instant->id,
                    'rt_bnd_id' => $report_type_current_bundles->id,
                    'rt_hdn_id' => $report_type_current_hdn->id,
                    'date' => $three_months_ago,
                ],
                [
                    'rt_id' => $report_type_recharge->id,
                    //'rt_i_id' => $report_type_recharge_instant->id,
                    'rt_hdn_id' => $report_type_recharge_hdn->id,
                    'rt_bnd_id' => $report_type_recharge_bundles->id,
                    'date' => $two_months_ago,
                ],
            ],
        ];

        foreach ($users as $user) {

            $data = [];

            foreach ($recarge_search_array as $item) {

                $matching_sims_count_activation = DB::table('sims')
                    ->select('sims.value')
                    ->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
                //->whereIn('sims.report_type_id', [$item[0]['rt_id'], $item[0]['rt_i_id'], $item[0]['rt_bnd_id'], $item[0]['rt_hdn_id']])
                    ->whereIn('sims.report_type_id', [$item[0]['rt_id'], $item[0]['rt_bnd_id'], $item[0]['rt_hdn_id']])
                // ->where('sims.report_type_id', $item[0]['rt_id'])
                // ->orWhere('sims.report_type_id', $item[0]['rt_i_id'])
                    ->where('sim_users.user_id', $user->id)
                    ->where('sims.upload_date', $item[0]['date'])
                    ->count();

                $matching_sims_count_recharge = DB::table('sims')
                    ->select('sims.value')
                    ->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
                    ->whereIn('sims.report_type_id', [$item[1]['rt_id'], $item[1]['rt_hdn_id'], $item[1]['rt_bnd_id']])
                // ->where('sims.report_type_id', $item[1]['rt_id'])
                // ->orWhere('sims.report_type_id', $item[1]['rt_i_id'])
                    ->where('sim_users.user_id', $user->id)
                    ->where('sims.upload_date', $item[1]['date'])
                    ->count();

                if ($matching_sims_count_activation && $matching_sims_count_recharge) {
                    $recharge_percent = number_format((($matching_sims_count_recharge / $matching_sims_count_activation) * 100), 2);
                } else {
                    $recharge_percent = '0.00';
                }

                if ($recharge_percent >= 70) {
                    $percent_class = 'best';
                } elseif ($recharge_percent >= 60) {
                    $percent_class = 'good';
                } elseif ($recharge_percent >= 50) {
                    $percent_class = 'ok';
                } else {
                    $percent_class = 'bad';
                }

                $data[] = [
                    'act_name' => Helpers::get_date_name($item[0]['date']) . ' Activation',
                    'act_count' => $matching_sims_count_activation,
                    'rec_name' => Helpers::get_date_name($item[1]['date']) . '<span> 2nd</span> Recharge',
                    'rec_count' => $matching_sims_count_recharge,
                    'percent' => $recharge_percent,
                    'class' => $percent_class,
                ];
            }

            $recharge_data_array[] = [
                'name' => $user->name,
                'company' => $user->company,
                'data' => $data,
            ];

        }

        return $recharge_data_array;
    }

    public function recharge()
    {
        $current_site_date = Helpers::current_date_name();
        $site_id = Settings::first()->get_site_id();
        $site_name = Site::find($site_id)->name;
        $recharge_data_array = self::recharge_data();
        $recharge = '2nd';

        return view('reports.recharge', compact(
            'site_name',
            'current_site_date',
            'recharge_data_array',
            'recharge'
        ));
    }

    private static function third_recharge_data($master_agent_id = null)
    {
        $current_date = Settings::first()->current_date;

        if ($master_agent_id) {
            $role_id = Helpers::get_role_id($master_agent_id);
            $users = User::where('role_id', $role_id)->orderBy('company')->get();
        } else {
            $role_id = Helpers::current_role_id();
            if (Helpers::is_normal_user()) {
                $logged_in_user = \Auth::user();
                $users = User::where('id', $logged_in_user->id)->get();
            } else {
                $users = User::where('role_id', $role_id)->orderBy('company')->get();
            }
        }

        $recharge_data_array = [];

        $config_array = [
            'current' => 5, // H2O 2nd Recharge
            //'current_instant' => 6, // H2O 2nd Rechage Instant
            'current_bundles' => 24, // H2O 2nd Rechage Bundles
            'current_hdn' => 19, // H2O 2nd Recharge HDN
            'recharge' => 8, // H2O 3rd Recharge
            //'recharge_emida' => 33, // H2O 2nd Recharge HDN
            'recharge_hdn' => 20, // H2O 2nd Recharge HDN
            //'recharge_instant' => 6 // H2O 2nd Rechage Instant
        ];

        $report_type_current = ReportType::find($config_array['current']);
        //$report_type_current_instant = ReportType::find($config_array['current_instant']);
        $report_type_current_bundles = ReportType::find($config_array['current_bundles']);
        $report_type_current_hdn = ReportType::find($config_array['current_hdn']);
        $report_type_recharge = ReportType::find($config_array['recharge']);
        //$report_type_recharge_emida = ReportType::find($config_array['recharge_emida']);
        $report_type_recharge_hdn = ReportType::find($config_array['recharge_hdn']);
        //$report_type_recharge_instant = ReportType::find($config_array['recharge_instant']);

        $date_array = Helpers::date_array();

        $array_index = array_search($current_date, $date_array);

        $one_month_ago = $date_array[$array_index - 1];
        $two_months_ago = $date_array[$array_index - 2];
        $three_months_ago = $date_array[$array_index - 3];

        $recarge_search_array = [
            [
                [
                    'rt_id' => $report_type_current->id,
                    //'rt_i_id' => $report_type_current_instant->id,
                    'rt_bdl_id' => $report_type_current_bundles->id,
                    'rt_hdn_id' => $report_type_current_hdn->id,
                    'date' => $one_month_ago,
                ],
                [
                    'rt_id' => $report_type_recharge->id,
                    //'rt_emd_id' => $report_type_recharge_emida->id,
                    'rt_hdn_id' => $report_type_recharge_hdn->id,
                    'date' => $current_date,
                ],
            ],
            [
                [
                    'rt_id' => $report_type_current->id,
                    //'rt_i_id' => $report_type_current_instant->id,
                    'rt_bdl_id' => $report_type_current_bundles->id,
                    'rt_hdn_id' => $report_type_current_hdn->id,
                    'date' => $two_months_ago,
                ],
                [
                    'rt_id' => $report_type_recharge->id,
                    //'rt_emd_id' => $report_type_recharge_emida->id,
                    'rt_hdn_id' => $report_type_recharge_hdn->id,
                    'date' => $one_month_ago,
                ],
            ],
            [
                [
                    'rt_id' => $report_type_current->id,
                    //'rt_i_id' => $report_type_current_instant->id,
                    'rt_bdl_id' => $report_type_current_bundles->id,
                    'rt_hdn_id' => $report_type_current_hdn->id,
                    'date' => $three_months_ago,
                ],
                [
                    'rt_id' => $report_type_recharge->id,
                    //'rt_emd_id' => $report_type_recharge_emida->id,
                    'rt_hdn_id' => $report_type_recharge_hdn->id,
                    'date' => $two_months_ago,
                ],
            ],
        ];

        foreach ($users as $user) {

            $data = [];

            foreach ($recarge_search_array as $item) {

                $matching_sims_count_activation = DB::table('sims')
                    ->select('sims.value')
                    ->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
                    ->whereIn('sims.report_type_id', [$item[0]['rt_id'], $item[0]['rt_hdn_id'], $item[0]['rt_bdl_id']])
                // ->where('sims.report_type_id', $item[0]['rt_id'])
                // ->orWhere('sims.report_type_id', $item[0]['rt_i_id'])
                    ->where('sim_users.user_id', $user->id)
                    ->where('sims.upload_date', $item[0]['date'])
                    ->count();

                $matching_sims_count_recharge = DB::table('sims')
                    ->select('sims.value')
                    ->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
                    ->whereIn('sims.report_type_id', [$item[1]['rt_id'], $item[1]['rt_hdn_id']])
                // ->where('sims.report_type_id', $item[1]['rt_id'])
                // ->orWhere('sims.report_type_id', $item[1]['rt_i_id'])
                    ->where('sim_users.user_id', $user->id)
                    ->where('sims.upload_date', $item[1]['date'])
                    ->count();

                if ($matching_sims_count_activation && $matching_sims_count_recharge) {
                    $recharge_percent = number_format((($matching_sims_count_recharge / $matching_sims_count_activation) * 100), 2);
                } else {
                    $recharge_percent = '0.00';
                }

                if ($recharge_percent >= 70) {
                    $percent_class = 'best';
                } elseif ($recharge_percent >= 60) {
                    $percent_class = 'good';
                } elseif ($recharge_percent >= 50) {
                    $percent_class = 'ok';
                } else {
                    $percent_class = 'bad';
                }

                $second_recharge_name = Helpers::get_date_name($item[0]['date']) . ' <span>2nd</span> Recharge';
                $third_recahrge_name = Helpers::get_date_name($item[1]['date']) . ' <span>3rd</span> Recharge';

                $data[] = [
                    'act_name' => $second_recharge_name,
                    'act_count' => $matching_sims_count_activation,
                    'rec_name' => $third_recahrge_name,
                    'rec_count' => $matching_sims_count_recharge,
                    'percent' => $recharge_percent,
                    'class' => $percent_class,
                ];
            }

            $recharge_data_array[] = [
                'name' => $user->name,
                'company' => $user->company,
                'data' => $data,
            ];

        }

        return $recharge_data_array;

    }

    private static function fourth_recharge_data($master_agent_id = null)
    {
        $current_date = Settings::first()->current_date;

        if ($master_agent_id) {
            $role_id = Helpers::get_role_id($master_agent_id);
            $users = User::where('role_id', $role_id)->orderBy('company')->get();
        } else {
            $role_id = Helpers::current_role_id();
            if (Helpers::is_normal_user()) {
                $logged_in_user = \Auth::user();
                $users = User::where('id', $logged_in_user->id)->get();
            } else {
                $users = User::where('role_id', $role_id)->orderBy('company')->get();
            }
        }

        $recharge_data_array = [];

        $config_array = [
            'current' => 8, // H2O 3rd Recharge
            'current_hdn' => 20, // H2O 3rd Recharge HDN
            'recharge' => 37, // H2O 4th Recharge
            'recharge_hdn' => 36, // H2O 4th Recharge HDN
        ];

        $report_type_current = ReportType::find($config_array['current']);
        $report_type_current_hdn = ReportType::find($config_array['current_hdn']);
        $report_type_recharge = ReportType::find($config_array['recharge']);
        $report_type_recharge_hdn = ReportType::find($config_array['recharge_hdn']);

        $date_array = Helpers::date_array();

        $array_index = array_search($current_date, $date_array);

        $one_month_ago = $date_array[$array_index - 1];
        $two_months_ago = $date_array[$array_index - 2];
        $three_months_ago = $date_array[$array_index - 3];

        $recarge_search_array = [
            [
                [
                    'rt_id' => $report_type_current->id,
                    'rt_hdn_id' => $report_type_current_hdn->id,
                    'date' => $one_month_ago,
                ],
                [
                    'rt_id' => $report_type_recharge->id,
                    'rt_hdn_id' => $report_type_recharge_hdn->id,
                    'date' => $current_date,
                ],
            ],
            [
                [
                    'rt_id' => $report_type_current->id,
                    'rt_hdn_id' => $report_type_current_hdn->id,
                    'date' => $two_months_ago,
                ],
                [
                    'rt_id' => $report_type_recharge->id,
                    'rt_hdn_id' => $report_type_recharge_hdn->id,
                    'date' => $one_month_ago,
                ],
            ],
            [
                [
                    'rt_id' => $report_type_current->id,
                    'rt_hdn_id' => $report_type_current_hdn->id,
                    'date' => $three_months_ago,
                ],
                [
                    'rt_id' => $report_type_recharge->id,
                    'rt_hdn_id' => $report_type_recharge_hdn->id,
                    'date' => $two_months_ago,
                ],
            ],
        ];

        foreach ($users as $user) {

            $data = [];

            foreach ($recarge_search_array as $item) {

                $matching_sims_count_activation = DB::table('sims')
                    ->select('sims.value')
                    ->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
                    ->whereIn('sims.report_type_id', [$item[0]['rt_id'], $item[0]['rt_hdn_id']])
                    ->where('sim_users.user_id', $user->id)
                    ->where('sims.upload_date', $item[0]['date'])
                    ->count();

                $matching_sims_count_recharge = DB::table('sims')
                    ->select('sims.value')
                    ->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
                    ->whereIn('sims.report_type_id', [$item[1]['rt_id'], $item[1]['rt_hdn_id']])
                    ->where('sim_users.user_id', $user->id)
                    ->where('sims.upload_date', $item[1]['date'])
                    ->count();

                if ($matching_sims_count_activation && $matching_sims_count_recharge) {
                    $recharge_percent = number_format((($matching_sims_count_recharge / $matching_sims_count_activation) * 100), 2);
                } else {
                    $recharge_percent = '0.00';
                }

                if ($recharge_percent >= 70) {
                    $percent_class = 'best';
                } elseif ($recharge_percent >= 60) {
                    $percent_class = 'good';
                } elseif ($recharge_percent >= 50) {
                    $percent_class = 'ok';
                } else {
                    $percent_class = 'bad';
                }

                $second_recharge_name = Helpers::get_date_name($item[0]['date']) . ' <span>3rd</span> Recharge';
                $third_recahrge_name = Helpers::get_date_name($item[1]['date']) . ' <span>4th</span> Recharge';

                $data[] = [
                    'act_name' => $second_recharge_name,
                    'act_count' => $matching_sims_count_activation,
                    'rec_name' => $third_recahrge_name,
                    'rec_count' => $matching_sims_count_recharge,
                    'percent' => $recharge_percent,
                    'class' => $percent_class,
                ];
            }

            $recharge_data_array[] = [
                'name' => $user->name,
                'company' => $user->company,
                'data' => $data,
            ];

        }

        return $recharge_data_array;

    }

    public function third_recharge()
    {
        $current_site_date = Helpers::current_date_name();
        $site_id = Settings::first()->get_site_id();
        $site_name = Site::find($site_id)->name;

        $recharge_data_array = self::third_recharge_data();

        $recharge = '3rd';

        return view('reports.recharge', compact(
            'site_name',
            'current_site_date',
            'recharge_data_array',
            'recharge'
        ));
    }

    public function fourth_recharge()
    {
        $current_site_date = Helpers::current_date_name();
        $site_id = Settings::first()->get_site_id();
        $site_name = Site::find($site_id)->name;

        $recharge_data_array = self::fourth_recharge_data();

        $recharge = '4th';

        return view('reports.recharge', compact(
            'site_name',
            'current_site_date',
            'recharge_data_array',
            'recharge'
        ));
    }

    public function all_recharge()
    {
        $current_site_date = Helpers::current_date_name();
        $site_id = Settings::first()->get_site_id();
        $site_name = Site::find($site_id)->name;
        $recharge_data_array = self::recharge_data();
        $recharge_data_array_third = self::third_recharge_data();

        return view('reports.recharge-all', compact(
            'site_name',
            'current_site_date',
            'recharge_data_array',
            'recharge_data_array_third'
        ));

    }

    /**
     * Dealer 2nd Recharge
     */
    public function dealer_2nd_recharge()
    {
        if ($master_agent_id = \Auth::user()->isMasterAgent()) {
            $current_site_date = Helpers::current_date_name();
            $site_id = Settings::first()->get_site_id();
            $site_name = Site::find($site_id)->name;

            $recharge_data_array = self::recharge_data($master_agent_id);
            $recharge = '2nd';
            return view('reports.recharge', compact(
                'site_name',
                'current_site_date',
                'recharge_data_array',
                'recharge'
            ));

        } else {
            return redirect('/');
        }

    }

    /**
     * Dealer 3rd Recharge
     */
    public function dealer_3rd_recharge()
    {
        if ($master_agent_id = \Auth::user()->isMasterAgent()) {
            $current_site_date = Helpers::current_date_name();
            $site_id = Settings::first()->get_site_id();
            $site_name = Site::find($site_id)->name;

            $recharge_data_array = self::third_recharge_data($master_agent_id);

            $recharge = '3rd';

            return view('reports.recharge', compact(
                'site_name',
                'current_site_date',
                'recharge_data_array',
                'recharge'
            ));
        } else {
            return redirect('/');
        }

    }

    /**
     * Dealer 4th Recharge
     */
    public function dealer_4th_recharge()
    {
        if ($master_agent_id = \Auth::user()->isMasterAgent()) {
            $current_site_date = Helpers::current_date_name();
            $site_id = Settings::first()->get_site_id();
            $site_name = Site::find($site_id)->name;

            $recharge_data_array = self::fourth_recharge_data($master_agent_id);

            $recharge = '4th';

            return view('reports.recharge', compact(
                'site_name',
                'current_site_date',
                'recharge_data_array',
                'recharge'
            ));
        } else {
            return redirect('/');
        }

    }

    public function download_csv(Request $request, $id)
    {
        $user = User::find($id);
        ReportUserCSV::process_csv_download($user);
    }

    public function download_csv_archive(Request $request, $id)
    {
        $user = User::find($id);
        ReportUserCSV::process_csv_download_archive($user, $request->archive_date);
    }

    public function save_archive()
    {
        $settings = Settings::first();
        $current_date = $settings->current_date;
        $current_site_date = Helpers::get_date_name($current_date);
        $site_id = $settings->get_site_id();
        $site = Site::find($site_id);
        $site_name = $site->name;

        /**
         * Get report_type_sites_default table data
         */
        $defaults_array_orig = ReportTypeSiteDefault::where([
            'site_id' => $site_id,
        ])->with('report_type_site_values')->get()->toArray();

        $defaults_array = [];
        foreach ($defaults_array_orig as $item) {
            $defaults_array[$item['report_type_id']] = $item;
        }

        /**
         * Get Residual Overrides
         */
        $user_residual = UserResidualPercent::all()->toArray();
        $user_residual_override = [];
        foreach ($user_residual as $item) {
            $user_residual_override[$item['user_id']][] = $item;
        }

        /**
         * Get Spiff Overrides
         */
        $user_spiff = UserPlanValues::all()->toArray();
        $user_spiff_override = [];
        foreach ($user_spiff as $item) {
            $user_spiff_override[$item['user_id']][] = $item;
        }

        //$report_data_object = new ReportData($site_id, $current_date);
        $report_data_object = new ReportData($site_id, $current_date, null, $defaults_array, $user_residual_override, $user_spiff_override, $site);
        $report_data_array = $report_data_object->report_data;

        foreach ($report_data_array as $report_data) {

            $save_data = serialize($report_data);
            //dd($report_data->user_id);

            //Archive::create('')

            $current = Archive::where([
                'user_id' => $report_data->user_id,
                'date' => $current_date,
            ])->first();

            if ($current) {

                $current->archive_data = $save_data;
                $current->save();

            } else {
                Archive::create([
                    'user_id' => $report_data->user_id,
                    'date' => $current_date,
                    'archive_data' => $save_data,
                ]);
            }
        }

        session()->flash('message', 'Archives have been saved');

        return redirect('/archives');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $settings = Settings::first();
        $current_date = $settings->current_date;
        $current_site_date = Helpers::get_date_name($current_date);
        //$site_id = $settings->get_site_id();
        $site_id = $user->site_id();
        //dd($user->site_id());
        $site = Site::find($site_id);
        $site_name = $site->name;

        /**
         * Get report_type_sites_default table data
         */
        $defaults_array_orig = ReportTypeSiteDefault::where([
            'site_id' => $site_id,
        ])->with('report_type_site_values')->get()->toArray();

        $defaults_array = [];
        foreach ($defaults_array_orig as $item) {
            $defaults_array[$item['report_type_id']] = $item;
        }

        /**
         * Get Residual Overrides
         */
        $user_residual = UserResidualPercent::all()->toArray();
        $user_residual_override = [];
        foreach ($user_residual as $item) {
            $user_residual_override[$item['user_id']][] = $item;
        }

        /**
         * Get Spiff Overrides
         */
        $user_spiff = UserPlanValues::all()->toArray();
        $user_spiff_override = [];
        foreach ($user_spiff as $item) {
            $user_spiff_override[$item['user_id']][] = $item;
        }

        /**
         * Get ReportData
         */
        $report_data_object = new ReportData($site_id, $current_date, $user->id, $defaults_array, $user_residual_override, $user_spiff_override, $site);

        /**
         * @todo here's where we get the report data - so this should probably be its own class.
         * for now, we'll just omit the per user spiff and residual settings and credit or bonus
         * features.
         */
        // $current_date = Settings::first()->current_date;
        // $current_site_date = Helpers::current_date_name();
        // $site_id = Settings::first()->get_site_id();
        // $site_name = Site::find($site_id)->name;
        // $report_data_object = new ReportData($site_id, $current_date, $user->id);
        $report_data_array = $report_data_object->report_data;
        $is_admin = Helpers::current_user_admin();
        $total_payment_all_users = $report_data_array[0]->total_payment;
        $is_single = true;
        return view('reports.index', compact(
            'site_name',
            'current_site_date',
            'report_data_array',
            'total_payment_all_users',
            'is_admin',
            'is_single',
            'user'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
