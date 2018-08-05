<?php

namespace App;

class Settings extends Model
{
    public function site() {

    	return $this->belongsTo(Site::class);
    }

}
