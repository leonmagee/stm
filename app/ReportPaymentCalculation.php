<?php
namespace App;

class ReportPaymentCalculation {

	public $total_payment;
	private $report_type_id;
	private $site_id;
	private $report_type_site_defaults_id;

	public function __construct($report_type_id, $site_id, $matching_sims, $is_spiff, $user_id = null) {

		$values_array = [];

		// we need to go back to the basic default if this doesn't exit...
		$defaults = ReportTypeSiteDefault::where([
			'site_id' => $site_id,
			'report_type_id' => $report_type_id
		])->first();

		if ( ! $defaults ) {
			// ? get site default?
		}

		if ( $defaults ) { // this shoud change since we still need to pay based on site default?


			if ( $is_spiff ) {

				$report_plan_values = ReportTypeSiteValue::where(
					'report_type_site_defaults_id', 
					$defaults->id)
				->get();

				foreach($report_plan_values as $item) {
					$values_array[$item->plan_value] = $item->payment_amount;
				}

				$total_charge = 0;

				// maybe get one array for sim user overrides?

				//dd($report_type_id);
				// h2o month = $640


				$user_override = UserPlanValues::where([
					'user_id' => $user_id,
					'report_type_id' => $report_type_id,
					//'plan_value' => $request->plan,
				])->get();

				$override_array = [];
				foreach( $user_override as $override ) {
					$override_array[$override->plan_value] = $override->payment_amount;
				}

				//dd($override_array);

				foreach($matching_sims as $sim) {
				// maybe here get user sims value?

					//dd($sim->value);

					if ( isset($override_array[$sim->value]) ) {

						$new_charge = $override_array[$sim->value];

					} elseif ( isset($values_array[$sim->value]) ) {

						$new_charge = $values_array[$sim->value];
						
					} else {
					// get report type default
						if ( $defaults->spiff_value ) {
							$new_charge = $defaults->spiff_value;
						} else {
						// get site default
							$site_default = Site::find($site_id)->first();
							if ( $site_default->default_spiff_amount ) {
								$new_charge = $site_default->default_spiff_amount;
							} else {
								$new_charge = 0;
							}
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