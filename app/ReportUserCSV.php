<?php
namespace App;
use \DB;
use League\Csv\Writer;
use SplTempFileObject;

/**
 * Class ReportUserCSV
 *
 * Loop through all sims assigned to a certain agent and generate a csv
 * file to download.
 *
 */
class ReportUserCSV {

	// function __construct( $user ) {
	// }

	private function create_array($user, $date) {

		$master_array = array();

		$site_id = Settings::first()->get_site_id();

		$report_types_array = ReportType::all();

		foreach ( $report_types_array as $report_type ) {
			
			$title = $report_type->carrier->name . ' ' . $report_type->name;

			$spiff_or_res = $report_type->spiff;

			$date = Helpers::current_date();

			if ( $spiff_or_res ) {

				$report_sims = DB::table('sims')
				->select('sims.sim_number', 'sims.value', 'sims.mobile_number', 'sims.activation_date', 'sims.report_type_id')
				->join('sim_users', 'sim_users.sim_number', '=', 'sims.sim_number')
				->where('sim_users.user_id', $user->id)
				->where('sims.report_type_id', $report_type->id)
				->where('sims.upload_date', $date)
				->get();

			} else {
				$report_sims = DB::table('sim_residuals')
				->select('sim_residuals.sim_number', 'sim_residuals.value', 'sim_residuals.mobile_number', 'sim_residuals.activation_date','sim_residuals.report_type_id')
				->join('sim_users', 'sim_users.sim_number', '=', 'sim_residuals.sim_number')
				->where('sim_users.user_id', $user->id)
				->where('sim_residuals.report_type_id', $report_type->id)
				->where('sim_residuals.upload_date', $date)
				->get();
			}

			if ( $report_sims ) {

				$master_array[] = array( "Sims for " . $title );

				$master_array[] = array(
					"Sim Number",
					"Sim Value",
					"Activation Date",
					"Mobile Number",
					"Type",
					"Amount"
				);


				/**
				 *  Get Array of Sims Values
				 */

				//$payment_amount = '333';

				//$counter = 0;

				foreach ( $report_sims as $report ) {

					//$payment_amount = "$" . number_format( $payments_value_array[ $counter ], 2 );

					//dd($report);

					$payment_amount = $this->calc_payment(
						$report_type->id, //
						$site_id, 
						$report->value, //
						$spiff_or_res, //
						$user->id //
					);

					//dd($payment_amount);

					if ($spiff_or_res) {
						$sp_res = 'Spiff';
					} else {
						$sp_res = 'Residual';
					}

					$master_array[] = array(
						"'$report->sim_number'",
						"'$report->value'",
						"'$report->activation_date'",
						"'$report->mobile_number'",
						"'$sp_res'",
						"'$payment_amount'"
					);

					//$counter ++;
				}

				$master_array[] = []; // empty lines - prob a way to do this with csv league
			}
		}

		dd($master_array);

		return $master_array;
	}

	private function calc_payment($report_type_id, $site_id, $value, $is_spiff, $user_id) {

		$values_array = [];

		$defaults = ReportTypeSiteDefault::where([
			'site_id' => $site_id,
			'report_type_id' => $report_type_id
		])->first();

		//dd($defaults);

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

				if ( isset($override_array[$value]) ) { // 1. user plan override

					$new_charge = $override_array[$value];

				} elseif ( isset($values_array[$value]) ) { // 2. report type plan specific

					$new_charge = $values_array[$value];
					
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

			} else {

				$percent = $defaults->residual_percent;

				$new_charge = ( $value * ( $percent / 100));
			}

		} 

		else {

			$new_charge = 0;
		}

		return $new_charge;
	}


	public static function process_csv_download( $user ) {

		// get data
		$report_types = ReportType::all();

		// current date
		$current_date = Helpers::current_date();
		$date_name = Helpers::current_date_name();

		// create csv file in memory
		$csv = Writer::createFromFileObject(new SplTempFileObject());

		// insert header
		$csv->insertOne([$user->name]);
		$csv->insertOne([$user->company]);
		$csv->insertOne(["'$date_name'"]);
		$csv->insertOne([]);
		$csv->insertOne([]);


		// get payment overview data
		$report_data_user = new ReportDataUser(
			$user->name, 
			$user->company, 
			$user->id,
			$user->role
		);

		//dd($report_data_user->report_data);

		$csv->insertOne(['Wireless Carrier', 'Number of Sims', 'Payment Amount']);

		foreach($report_data_user->report_data as $item) {

			$data_row = [
				$item->name,
				$item->number,
				$item->payment
			];

			$csv->insertOne($data_row);
		}

		$csv->insertOne([]);
		$csv->insertOne([]);

		//dd($report_data_user->report_data);










		// new ReportUserCSV object
		$csv_data = new static();

		// insert sims data
		$sims_array = $csv_data->create_array($user, $current_date);

		dd($sims_array);

		foreach ($sims_array as $sims_row) {
			$csv->insertOne($sims_row);
		}

		// output
		$name = strtolower(str_replace(' ', '-', $user->name));
		$filename = "stm-report-" . $current_date . "-" . $name . ".csv";
		$csv->output($filename);

		die();
	}

}