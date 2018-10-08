<?php

namespace App;

class Settings extends Model
{
    // public function site() {
    // 	return Site::find(1);
    // }

    public function get_site_object() {
    	return Site::find(session('current_site_id', 1));
    }
    public function get_site_id() {
    	return session('current_site_id', 1);
    }
    public function get_role_id() {
    	$site_id = session('current_site_id', 1);
    	$site = Site::find($site_id);
    	return $site->role_id;
    	//return session('current_site_id', 1);
    }

}
