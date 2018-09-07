<?php

namespace App;

use App\Settings;
use \Carbon\Carbon;

class Helpers {

	public static function get_date_name($date) {

		$exploded = explode('_', $date);
		$month = Carbon::createFromFormat('m', $exploded[0])->format('F');
		$current_site_date = $month . ' ' . $exploded[1];
		return $current_site_date;
	}

	public static function current_date_name() {

		$settings = Settings::first();
		return Self::get_date_name($settings->current_date);
	}

	public static function current_date() {
		$settings = Settings::first();
		return $settings->current_date;	
	}

	public static function verify_sim($sim) {
		if (strlen($sim) > 7) {
			return true;
		} else {
			return false;
		}
	}

	// public static function admin_lock() {

	// 	$user = \Auth::user();

 //        if ( ! $user->isAdmin() ) {
 //            return redirect('/');
 //        }
	// }

}