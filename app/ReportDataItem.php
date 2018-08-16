<?php
namespace App;

class ReportDataItem {

	public $name;
	public $number;
	public $payment;

	public function __construct($name, $number, $payment) {

		$this->name = $name;
		$this->number = $number;
		$this->payment = '$' . number_format($payment, 2);
	}
}