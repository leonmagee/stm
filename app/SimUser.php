<?php

namespace App;

class SimUser extends Model
{
    public function user() {

    	return $this->belongsTo(User::class);
    }
}
