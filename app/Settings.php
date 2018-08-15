<?php

namespace App;

class Settings extends Model
{
    public function site() {

    	//return Site::find(session('current_site_id', 1));
    	return Site::find(1);

    	//return $this->belongsTo(Site::class);
    }

}
