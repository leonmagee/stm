<?php

namespace App;

class Site extends Model
{
    public function company() {

    	return $this->belongsTo(Company::class);
    }
}
