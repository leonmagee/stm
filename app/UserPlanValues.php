<?php

namespace App;

class UserPlanValues extends Model
{
    public function report_type() {
    	return $this->belongsTo(ReportType::class);
    }
}
