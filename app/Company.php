<?php

namespace App;

class Company extends Model
{
    public function sites() {
    	return $this->hasMany(Site::class);
    }
}
