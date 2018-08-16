<?php
namespace App;

// $report_data_array = array();

// $report_types = ReportType::all();

// foreach($report_types as $report_type) {
//     $report_data_array[] = array(
//         'name' => $report_type->name,
//         'number' => '33',
//         'payment' => '$1,223.00'
//     );
// }


// $report_data = new ReportData($site_id, $current_date);
// $report_data_object = $report_data->get_data();


class ReportData {

	private $site_id;
	private $current_date;

	public function __construct($site_id, $current_date) {

		$this->site_id = $site_id;
		$this->current_date = $current_date;
	}

	public function get_data() {

		$report_types = ReportType::all();

		foreach($report_types as $report_type) {

            $report_data_array[] = new ReportDataItem(
            	$report_type->carrier->name . ' ' .$report_type->name, 
            	33, 
            	1333
            );
            
        }

        return $report_data_array;
	}
}










