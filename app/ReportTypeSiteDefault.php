<?php

namespace App;

class ReportTypeSiteDefault extends Model
{
	public function report_type_site_values() {
		return $this->hasMany(ReportTypeSiteDefault::class);
	}
}
