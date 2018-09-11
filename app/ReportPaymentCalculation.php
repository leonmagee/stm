<?php
namespace App;

class ReportPaymentCalculation {

	public $total_payment;
	private $report_type_id;
	private $site_id;
	private $report_type_site_defaults_id;

	public function __construct($report_type_id, $site_id, $matching_sims, $is_spiff, $user_id = null) {

		$values_array = [];

		$defaults = ReportTypeSiteDefault::where([
			'site_id' => $site_id,
			'report_type_id' => $report_type_id
		])->first();

		if ( $defaults ) {

			if ( $is_spiff ) {

				$report_plan_values = ReportTypeSiteValue::where(
					'report_type_site_defaults_id', 
					$defaults->id)
				->get();

				foreach($report_plan_values as $item) {

					$values_array[$item->plan_value] = $item->payment_amount;
				}

				$total_charge = 0;

				$user_override = UserPlanValues::where([
					'user_id' => $user_id,
					'report_type_id' => $report_type_id,
					//'plan_value' => $request->plan,
				])->get();

				$override_array = [];

				foreach( $user_override as $override ) {
					$override_array[$override->plan_value] = $override->payment_amount;
				}


				foreach($matching_sims as $sim) {

					if ( isset($override_array[$sim->value]) ) { // 1. user plan override

						$new_charge = $override_array[$sim->value];

					} elseif ( isset($values_array[$sim->value]) ) { // 2. report type plan specific

						$new_charge = $values_array[$sim->value];
						
					} elseif ($defaults->spiff_value !== null) {

						$new_charge = $defaults->spiff_value;

					} else {

						$site_default = Site::find($site_id)->first();

						if ( $site_default->default_spiff_amount ) {

							$new_charge = $site_default->default_spiff_amount;

						} else {

							$new_charge = 0;
						}
						
					}

					$total_charge += $new_charge;
				}

			} else {

				$percent = $defaults->residual_percent;

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
}