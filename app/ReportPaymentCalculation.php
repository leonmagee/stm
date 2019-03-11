<?php
namespace App;

class ReportPaymentCalculation {
	public $total_payment;
	private $report_type_id;
	private $site_id;
	private $report_type_site_defaults_id;
	private $defaults_array;
	private $site;
	public function __construct(
		$report_type_id, 
		$site_id, 
		$matching_sims, 
		$is_spiff, 
		$user_id = null, 
		$defaults_array = null, 
		$res_override = null,
		$spiff_override = null,
		$site = null,
		$matching_sims_new = null
	) {
		$values_array = [];
		$defaults = $defaults_array[$report_type_id];
		if ( $defaults ) {
			if ( $is_spiff ) {
				foreach($defaults['report_type_site_values'] as $item) {
					$values_array[$item['plan_value']] = $item['payment_amount'];
				}	
				$total_charge = 0;
				$override_array = [];
				if(isset($spiff_override[$user_id])) {
					foreach( $spiff_override[$user_id] as $override ) {
						$override_array[$override['plan_value']] = $override['payment_amount'];
					}
				}
				foreach($matching_sims as $sim) {
					$new_charge = self::calc_spiff_payments(
						$override_array, 
						$sim->value, 
						$values_array, 
						$defaults['spiff_value'],
						$site_id,
						$site
					);
					$total_charge += $new_charge;
				}
			} else {
				$percent = self::calc_residual_percent(
					$user_id,
					$report_type_id,
					$defaults,
					$site_id,
					$res_override
				);
				$total_charge = 0;
				foreach($matching_sims as $sim) {
					$total_charge += ( $sim->value * ( $percent / 100));
				}
			}
			$this->total_payment = $total_charge;
		} else {
			$this->total_payment = 0;
		}
	}

	public static function calc_spiff_payments($override_array, $sim_val, $values_array, $default_spiff, $site_id, $site = null ) {
		if ( isset($override_array[$sim_val]) ) { // 1. user plan override
			$new_charge = $override_array[$sim_val];
		} elseif ( isset($values_array[$sim_val]) ) { // 2. report type plan specific
			$new_charge = $values_array[$sim_val];
		} elseif ($default_spiff !== null) {
			$new_charge = $default_spiff;
		} else {
			//$site_default = Site::find($site_id);
			//dd($site);
			//dd($site_default);
			if ( $site->default_spiff_amount ) {
				$new_charge = $site->default_spiff_amount;
			} else {
				$new_charge = 0;
			}
		}
		return $new_charge;
	}

	public static function calc_residual_percent($user_id, $report_type_id, $defaults, $site_id, $res_override = null) {
		$res_override_array = false;
		if(isset($res_override[$user_id])) {
			$user_res_override = $res_override[$user_id];	
			foreach( $user_res_override as $item ) {
				if ( $item['report_type_id'] == $report_type_id) {
					$res_override_array = $item;
				}
			}
		}
		if ( $res_override_array ) {
			$percent = $res_override_array['residual_percent'];
		} elseif (isset($defaults['residual_percent'])) {
			$percent = $defaults['residual_percent'];
		} elseif ($site_default = Site::find($site_id)) {
			$percent = $site_default->default_residual_percent;
		} else {
			$percent = 0;
		}
		return $percent;
	}
}