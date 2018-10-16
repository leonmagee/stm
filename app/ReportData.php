<?php
namespace App;

class ReportData {

	private $site_id;
	private $role_id;
	private $current_date;
	public $report_data;

	public function __construct($site_id, $current_date, $user_id = null) {

		$this->site_id = $site_id;
		$this->role_id = Helpers::get_role_id($this->site_id);
		$this->current_date = $current_date;
		$this->user_id = $user_id;
		$this->get_data();
	}

	public function get_data() {

		$current_user = \Auth::user();

		if($user_id = $this->user_id)
		{
			$users = User::where('id', $user_id)->get();
		}
		elseif ($current_user->isAdmin() || $current_user->isManager())
		{
			$users = User::where('role_id', $this->role_id)->get();
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










