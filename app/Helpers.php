<?php

namespace App;

use App\Settings;
use \Carbon\Carbon;

class Helpers {

	public function __construct() {

	}

	public static function current_date_name() {

		$settings = Settings::first();
		$date_array = explode('_', $settings->current_date);
		$month = Carbon::createFromFormat('m', $date_array[0])->format('F');
		$current_site_date = $month . ' ' . $date_array[1];
		return $current_site_date;
	}

	public static function get_date_name($date) {

		$date_array = explode('_', $date);
		$month = Carbon::createFromFormat('m', $date_array[0])->format('F');
		$current_site_date = $month . ' ' . $date_array[1];
		return $current_site_date;
	}
}