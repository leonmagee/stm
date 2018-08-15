<?php

namespace App;

class Site extends Model
{
    public function company() {

    	return $this->belongsTo(Company::class);
    }

    public function spiff_value($report_type_id) {
    	$row = ReportTypeSiteValue::where([
    		'site_id' => $this->id,
    		'report_type_id' => $report_type_id
    	])->first();
    	return $row->spiff_value;
    }

    public function residual_percent($report_type_id) {
    	$row = ReportTypeSiteValue::where([
    		'site_id' => $this->id,
    		'report_type_id' => $report_type_id
    	])->first();
    	return $row->residual_percent;
    }
}
