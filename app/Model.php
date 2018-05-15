<?php

/**
* Parent class for all Models
* Prevents need for $fillable or $guarded
**/

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
	protected $guarded = [];
}
