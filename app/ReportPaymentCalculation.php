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

		// dd($matching_sims);

		// dd($values_array);


			$total_charge = 0;

			foreach($matching_sims as $sim) {

				$new_charge = $values_array[$sim->value];

				$total_charge += $total_charge + $new_charge;
			}

		//dd($total_charge);

			$this->total_payment = $total_charge;

		} else {

			$this->total_payment = 0;
		}
	}
}