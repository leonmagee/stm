<?php
namespace App;
use \DB;

class ReportDataUser {

	public $user_name;
	public $user_company;
	public $user_id;
	public $report_data;
	private $site_id;
	public $bonus;
	public $credit;
	public $total_count;
	public $total_payment;
	public $count;

	public function __construct($user_name, $user_company, $user_id, $site_id, $count) {

		$this->user_name = $user_name;
		$this->user_company = $user_company;
		$this->user_id = $user_id;
		$this->site_id = $site_id;
		$this->count = $count;
		$this->get_data();
	}

	public function get_data() {

		$report_types = ReportType::all();

		$total_count = 0;
		$total_payment = 0;

		// get current date?
		$current_date = Helpers::current_date();

		foreach($report_types as $report_type) {

			if ($report_type->spiff ){

				$matching_sims = DB::table('sims')
				->select('sims.value', 'sims.report_type_id')
				//->select('sims.value', 'sims.report_type_id')
				->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
				->where('sim_users.user_id', $this->user_id)
				->where('sims.report_type_id', $report_type->id)
				->where('sims.upload_date', $current_date)
				->get();

			} else {

				$matching_sims = DB::table('sim_residuals')
				->select('sim_residuals.value', 'sim_residuals.report_type_id')
				//->select('sims.value', 'sims.report_type_id')
				->join('sim_users', 'sim_users.sim_number', '=', 'sim_residuals.sim_number')
				->where('sim_users.user_id', $this->user_id)
				->where('sim_residuals.report_type_id', $report_type->id)
				->where('sim_residuals.upload_date', $current_date)
				->get();
			}

			//dd($matching_sims);

			if ($matching_sims) {
				$number_sims = count($matching_sims);
			} else {
				$number_sims = 0;
			}

			/**
			* @todo here I need to loop through all of the sims and get the different payment values, or else default back to the main default, but I will in the future add the per user overide to this...
			*/
			// site id
			$payment = new ReportPaymentCalculation(
				$report_type->id, 
				$this->site_id, 
				$matching_sims,
				$report_type->spiff,
				$this->user_id
			);


			$report_data_array[] = new ReportDataItem(
				$report_type->carrier->name . ' ' .$report_type->name, 
				$number_sims,
				$payment->total_payment
			);

			$total_count += $number_sims;
			$total_payment += $payment->total_payment;

		}

		/**
		* @todo subtract monthly credit and add monthly bonus
		*/
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