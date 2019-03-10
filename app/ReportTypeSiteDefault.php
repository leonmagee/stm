<?php

namespace App;

class ReportTypeSiteDefault extends Model
{
	public function report_type_site_values() {
		//return $this->hasMany(ReportTypeSiteDefault::class);
		return $this->hasMany(ReportTypeSiteValue::class, 'report_type_site_defaults_id');
	}
}
