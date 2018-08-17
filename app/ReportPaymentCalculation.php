<?php
namespace App;

class ReportPaymentCalculation {

	public $total_payment;
	private $report_type_id;
	private $site_id;
	private $report_type_site_defaults_id;
	public function __construct($report_type_id, $site_id = null) {

		$this->total_payment = 777;
	}
}