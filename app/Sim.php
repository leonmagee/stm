<?php

namespace App;

class Sim extends Model
{

    public function isActive() {
    	return false;
    }

    public function report_type() {
    	return $this->belongsTo(ReportType::class);
    }
}
