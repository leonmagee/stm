<?php
namespace App;
use \DB;

class ReportDataUser {

	public $user_name;
	public $user_company;
	private $user_id;
	public $report_data;

	public function __construct($user_name, $user_company, $user_id) {

		$this->user_name = $user_name;
		$this->user_company = $user_company;
		$this->user_id = $user_id;
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

			if ($matching_sims) {
				$number_sims = count($matching_sims);
			} else {
				$number_sims = 0;
			}


			$report_data_array[] = new ReportDataItem(
				$report_type->carrier->name . ' ' .$report_type->name, 
				$number_sims,
				1333
			);

		}

		$this->report_data = $report_data_array;

	}
}