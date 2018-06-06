<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
//use App\Model;

class ReportType extends Model
{
    //
    // public static function spiff() {
    // 	return static::where('spiff',1)->get();
    // }

    public static function residual() {
    	return static::where('spiff',0)->get();
    }

    // public function scopeSpiff($query, $val) {
    // 	//return static::where('spiff',0)->get();
    // 	return $query->where('spiff',0);
    // }

    public function scopeSpiff($query) {
    	//return static::where('spiff',0)->get();
    	return $query->where('spiff',1);
    }

    public function carrier() {

        return $this->belongsTo(Carrier::class);
    }
}
