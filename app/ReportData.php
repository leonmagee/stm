<?php
namespace App;

class ReportData {

	private $site_id;
	private $role_id;
	private $current_date;
	public $report_data;
	public $total_payment_all_users;

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

		$total_payment_all_users = 0;

		foreach ( $users as $user ) {

			$report_data_user = new ReportDataUser(
				$user->name, 
				$user->company, 
				$user->id,
				$this->site_id
			);

			$report_data_array[] = $report_data_user;

			$total_payment_all_users += $report_data_user->total_payment;

			//dd($report_data_user->total_payment);
		}

		//dd($total_payment_all_users);

		$this->total_payment_all_users = $total_payment_all_users;

        $this->report_data = $report_data_array;
	}
}










