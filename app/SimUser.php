<?php

namespace App;

class SimUser extends Model
{
    //

	/**
	* You can access this like a property on a SimUser object instance.
	**/
    public function user() {

    	return $this->belongsTo(User::class);
    }
}
