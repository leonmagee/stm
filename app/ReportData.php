<?php
namespace App;

class ReportData
{
    private $site_id;
    private $role_id;
    private $current_date;
    public $report_data;
    public $total_payment_all_users;
    private $defaults_array;
    private $res_override;
    private $spiff_override;
    private $site;
    public function __construct(
        $site_id,
        $current_date,
        $user_id = null,
        $defaults_array = null,
        $res_override = null,
        $spiff_override = null,
        $site = null,
        $master_agent = null
    ) {
        $this->site_id = $site_id;
        $this->role_id = Helpers::get_role_id($this->site_id);
        $this->current_date = $current_date;
        $this->user_id = $user_id;
        $this->defaults_array = $defaults_array;
        $this->res_override = $res_override;
        $this->spiff_override = $spiff_override;
        $this->site = $site;
        $this->master_agent = $master_agent;
        $this->get_data();
    }

    public function get_data()
    {
        $current_user = \Auth::user();
        if ($user_id = $this->user_id) {
            $users = User::where('id', $user_id)->get();
        } elseif ($current_user->isAdmin() || $current_user->isManager() || $current_user->isEmployee()) {
            $users = User::where('role_id', $this->role_id)->orderBy('company')->get();
        } elseif ($agent = $this->master_agent) {
            $site = Site::find($this->master_agent);
            $users = User::where('role_id', $site->role_id)->orderBy('company')->get();
        } else {
            $users = User::where('id', $current_user->id)->get();
        }
        $report_data_array = array();
        $total_payment_all_users = 0;
        $report_types = ReportType::query()->orderBy('order_index')->get();
        $total_payments_residual_data = [];
        foreach ($users as $user) {
            $report_data_user = new ReportDataUser(
                $user->name,
                $user->company,
                $user->id,
                $this->site_id,
                $this->defaults_array,
                $this->res_override,
                $this->spiff_override,
                $report_types,
                $this->current_date,
                $this->site
            );
            //dd($report_data_user->report_data);
            foreach ($report_data_user->report_data as $item) {
                if ($item->res_total) {
                    //dd($item->res_total['key']);
                    if (isset($total_payments_residual_data[$item->res_total['key']])) {
                        $total_payments_residual_data[$item->res_total['key']] += $item->res_total['value'];
                    } else {
                        $total_payments_residual_data[$item->res_total['key']] = $item->res_total['value'];
                    }
                }
            }
            $report_data_array[] = $report_data_user;
            $total_payment_all_users += $report_data_user->total_payment;
        }
        //dd($total_payments_residual_data);
        $this->total_payment_all_users = $total_payment_all_users;
        $total_payments_residual = [];
        $report_types_collection = ReportType::where('spiff', 0)->get();
        if (count($total_payments_residual_data)) {
            foreach ($report_types_collection as $report_type) {
                $total_payments_residual[] = [
                    'name' => $report_type->carrier->name . ' ' . $report_type->name,
                    'total' => '$' . number_format($total_payments_residual_data[$report_type->id], 2),
                ];
            }
        } else {
            $total_payments_residual = [];
        }
        $this->total_payments_residual = $total_payments_residual;

        $this->report_data = $report_data_array;
    }
}
