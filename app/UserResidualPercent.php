<?php

namespace App;

class UserResidualPercent extends Model
{
    public function report_type() {
    	return $this->belongsTo(ReportType::class);
    }
}
