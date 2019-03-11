<?php
namespace App;
use \DB;

class ReportDataUser {

	public $user_name;
	public $user_company;
	public $user_id;
	public $report_data;
	public $bonus;
	public $credit;
	public $total_count;
	public $total_payment;
	public $count;
	private $site_id;
	private $defaults_array;
	private $res_override;
	private $spiff_override;
	private $report_types;
	private $current_date;
	private $site;

	public function __construct(
		$user_name, 
		$user_company, 
		$user_id, 
		$site_id = null, 
		$defaults_array = null, 
		$res_override = null,
		$spiff_override = null,
		$report_types = null,
		$current_date = null,
		$site = null
	) {
		$this->user_name = $user_name;
		$this->user_company = $user_company;
		$this->user_id = $user_id;
		$this->site_id = $site_id;
		$this->defaults_array = $defaults_array;
		$this->res_override = $res_override;
		$this->spiff_override = $spiff_override;
		$this->report_types = $report_types;
		$this->current_date = $current_date;
		$this->site = $site;
		$this->count = SimUser::where('user_id', $user_id)->count();
		$this->get_data();
	}

	public function get_data() {
		$total_count = $total_payment = 0;
		$current_date = $this->current_date;

		$matching_sims_spiff = DB::table('sims')
		->select('sims.value', 'sims.report_type_id')
		->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
		->where('sim_users.user_id', $this->user_id)
		->where('sims.upload_date', $current_date)
		->get()->toArray();
		//dd($matching_sims_spiff);

		$matching_spiff_array = [];
		foreach($matching_sims_spiff as $item) {
			$matching_spiff_array[$item->report_type_id][] = $item->value;
		}
		//dd($matching_spiff_array);

		$matching_sims_res = DB::table('sim_residuals')
		->select('sim_residuals.value', 'sim_residuals.report_type_id')
		->join('sim_users', 'sim_users.sim_number', '=', 'sim_residuals.sim_number')
		->where('sim_users.user_id', $this->user_id)
		->where('sim_residuals.upload_date', $current_date)
		->get();

		$matching_res_array = [];
		foreach($matching_sims_res as $item) {
			$matching_res_array[$item->report_type_id][] = $item->value;
		}
		//dd($matching_res_array);


		foreach($this->report_types as $report_type) {
			if ($report_type->spiff) {
				if(isset($matching_spiff_array[$report_type->id])) {
					$matching_sims_new = $matching_spiff_array[$report_type->id];
				} else {
					$matching_sims_new = null;
				}
				$matching_sims = DB::table('sims')
				->select('sims.value', 'sims.report_type_id')
				->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
				->where('sim_users.user_id', $this->user_id)
				->where('sims.report_type_id', $report_type->id)
				->where('sims.upload_date', $current_date)
				->get();
				//dd($matching_sims);
			} else {
				if(isset($matching_res_array[$report_type->id])) {
					$matching_sims_new = $matching_res_array[$report_type->id];
				} else {
					$matching_sims_new = null;
				}
				$matching_sims = DB::table('sim_residuals')
				->select('sim_residuals.value', 'sim_residuals.report_type_id')
				->join('sim_users', 'sim_users.sim_number', '=', 'sim_residuals.sim_number')
				->where('sim_users.user_id', $this->user_id)
				->where('sim_residuals.report_type_id', $report_type->id)
				->where('sim_residuals.upload_date', $current_date)
				->get();
			}
			// this is number sims per report type, we need to get this in
			// the calculation... 
			if ($matching_sims) {
				$number_sims = count($matching_sims);
			} else {
				$number_sims = 0;
			}
			$payment = new ReportPaymentCalculation(
				$report_type->id,
				$this->site_id,
				$matching_sims,
				$report_type->spiff,
				$this->user_id,
				$this->defaults_array,
				$this->res_override,
				$this->spiff_override,
				$this->site,
				$matching_sims_new
			);
			$report_data_array[] = new ReportDataItem(
				$report_type->carrier->name . ' ' .$report_type->name,
				$number_sims,
				$payment->total_payment
			);
			$total_count += $number_sims;
			$total_payment += $payment->total_payment;
		}
        $bonus_credit = UserCreditBonus::where([
            'user_id' => $this->user_id,
            'date' => $current_date
        ])->first();
        if ( isset($bonus_credit->bonus) ) {
            $this->bonus = $bonus_credit->bonus;
        } else {
            $this->bonus = 0;
        }
        if ( isset($bonus_credit->credit) ) {
            $this->credit = $bonus_credit->credit;
        } else {
            $this->credit = 0;
        }
		$this->total_count = $total_count;
		$total_payment = $total_payment + $this->bonus;
		$total_payment = $total_payment - $this->credit;
		$this->total_payment = $total_payment;
		$this->report_data = $report_data_array;
	}
}