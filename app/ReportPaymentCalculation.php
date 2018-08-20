<?php
namespace App;

class ReportPaymentCalculation {

	public $total_payment;
	private $report_type_id;
	private $site_id;
	private $report_type_site_defaults_id;

	public function __construct($report_type_id, $site_id, $matching_sims, $user_id = null) {

		$values_array = [];

		// we need to go back to the basic default if this doesn't exit...
		$defaults = ReportTypeSiteDefault::where([
			'site_id' => $site_id,
			'report_type_id' => $report_type_id
		])->first();

		if ( $defaults ) {

			$report_plan_values = ReportTypeSiteValue::where(
				'report_type_site_defaults_id', 
				$defaults->id)
			->get();

			// this will possibly be overridden by user preferences... 
			foreach($report_plan_values as $item) {
				$values_array[$item->plan_value] = $item->payment_amount;
			}

			$total_charge = 0;

			foreach($matching_sims as $sim) {
				// maybe here get user sims value?

				if ( isset($values_array[$sim->value]) ) {
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

			$this->total_payment = $total_charge;

		} else {

			$this->total_payment = 0;
		}
	}
}