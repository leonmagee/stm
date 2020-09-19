<?php

namespace App\Providers;

use App\Helpers;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use jdavidbakr\MailTracker\Model\SentEmail;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('see-sent-emails', function ($user) {
            if ($user->isAdminManagerEmployee()) {
                return true;
            } else {
                $request = resolve(\Illuminate\Http\Request::class);
                $uri = $request->getUri();
                if (!(strpos($uri, 'show-email') !== false)) {
                    if ($user->isMasterAgent()) {
                        dd('true');
                        return true;
                    }
                }
                $matches = false;
                $match = preg_match('/email-tracker\/show-email\/([0-9]*)/', $uri, $matches);
                if ($match) {
                    $user_email = $user->email; // logged in user
                    $email_id = $matches[1];
                    $email = SentEmail::find($email_id);
                    if ($email) {
                        if ($user_email == $email->email_address) {
                            return true;
                        }
                        $recipient = User::where('email', $email->email_address)->first();
                        if ($recipient) {
                            //dd($recipient);
                            if ($user->isMasterAgent()) {
                                if (Helpers::get_role_id($user->isMasterAgent()) == $recipient->role_id) {
                                    return true;
                                }
                            }

                        }

                        return false;
                    }
                    return false;
                }
                return false;
            }
            return false;
        });
    }
}
