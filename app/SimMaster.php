<?php

namespace App;

class SimMaster extends Model
{

    // public function isActive() {
    // 	return false;
    // }

    public function report_type() {
    	return $this->belongsTo(ReportType::class);
    }
}
