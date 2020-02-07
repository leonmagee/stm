<?php

namespace App\Listeners;

use App\UserLoginLogout;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuccessLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        /**
         * Get Data
         */
        $user_id = Auth::user()->id;
        $session_id = $this->request->cookie('stm_session');
        $current_time = Carbon::now();

        /**
         * Save Record
         */
        $record = new UserLoginLogout;
        $record->user_id = $user_id;
        //$record->session_id = $session_id;
        $record->login = $current_time;
        $record->save();
    }
}
