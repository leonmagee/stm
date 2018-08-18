<?php
namespace App;
use \DB;

class ReportDataUser {

	public $user_name;
	public $user_company;
	private $user_id;
	public $report_data;
	private $site_id;

	public function __construct($user_name, $user_company, $user_id, $site_id) {

		$this->user_name = $user_name;
		$this->user_company = $user_company;
		$this->user_id = $user_id;
		$this->site_id = $site_id;
		$this->get_data();
	}

	public function get_data() {

		$report_types = ReportType::all();

		foreach($report_types as $report_type) {

			$matching_sims = DB::table('sims')
			->select('sims.value', 'sims.report_type_id')
			//->select('sims.value', 'sims.report_type_id')
			->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
			->where('sim_users.user_id', $this->user_id)
			->where('sims.report_type_id', $report_type->id)
			->get();

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
				$matching_sims
			);


			$report_data_array[] = new ReportDataItem(
				$report_type->carrier->name . ' ' .$report_type->name, 
				$number_sims,
				$payment->total_payment
			);

		}

		$this->report_data = $report_data_array;

	}
}