<?php
namespace App;

class ReportData {

	private $site_id;
	private $current_date;
	public $report_data;

	public function __construct($site_id, $current_date) {

		$this->site_id = $site_id;
		$this->current_date = $current_date;
		$this->get_data();
	}

	public function get_data() {

		$current_user = \Auth::user();

		if ($current_user->isAdmin())
		{
			$users = User::where('role', $this->site_id)->get();
		} 
		else 
		{
			$users = User::where('id', $current_user->id)->get();
		}

		$report_data_array = array();

		foreach ( $users as $user ) {

			$report_data_array[] = new ReportDataUser(
				$user->name, 
				$user->company, 
				$user->id,
				$this->site_id
			);
		}

        $this->report_data = $report_data_array;
	}
}










