<?php

namespace App;

class Site extends Model
{
    public function company() {

    	return $this->belongsTo(Company::class);
    }

    public function get_data($report_type_id) {

   		$row = ReportTypeSiteValue::where([
    		'site_id' => $this->id,
    		'report_type_id' => $report_type_id
    	])->first();

   		return $row;
    }

    public function spiff_value($report_type_id) {

    	$row = $this->get_data($report_type_id);

    	if ( $row ) {
    		return $row->spiff_value;
    	} else {
    		return false;
    	}
    }

    public function residual_percent($report_type_id) {

    	$row = $this->get_data($report_type_id);

    	if ( $row ) {
    		return $row->residual_percent;
    	} else {
    		return false;
    	}
    }
}
