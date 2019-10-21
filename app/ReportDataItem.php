<?php
namespace App;

class ReportDataItem
{

    public $name;
    public $number;
    public $payment;
    public $res_total;

    public function __construct($name, $number, $payment, $res_total = null)
    {

        $this->name = $name;
        $this->number = $number;
        $this->payment = '$' . number_format($payment, 2);
        $this->res_total = $res_total;
    }
}
