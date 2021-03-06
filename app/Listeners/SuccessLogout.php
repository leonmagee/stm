<?php

namespace App\Listeners;

use App\UserLoginLogout;
use Carbon\Carbon;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuccessLogout
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        //$this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $user = Auth::user();
        if ($user) {
            $user_id = $user->id;
            $record = UserLoginLogout::where('user_id', $user_id)->orderBy('id', 'DESC')->first();
            if ($record) {
                if ($record->logout == null) {
                    $record->logout = Carbon::now();
                    $record->save();
                }
            }
        }
    }
}
