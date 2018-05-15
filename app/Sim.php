<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
//use App\Model;

class Sim extends Model
{
	// protected $fillable = [
	// 	'sim_number', 
	// 	'value', 
	// 	'activation_date', 
	// 	'mobile_number', 
	// 	'carrier'
	// ];

    public function isActive() {
    	return false;
    }

    public function report_type() {
    	return $this->belongsTo(ReportType::class);
    }

    // public function user() {

    // 	return $this->belongsTo(User::class);
    // }
}
