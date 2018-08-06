<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//use App\Billing\Stripe;

use App\Settings;

use App\ReportType;

use \Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        /**
        * This crashes the artisan when settings don't exists?
        */
        $settings = Settings::first();
        if ( $settings ) {
            $date_array = explode('_', $settings->current_date);
            $month = Carbon::createFromFormat('m', $date_array[0])->format('F');
            $date = $month . ' ' . $date_array[1];
        } else {
            $date = '';
        }

        define('CURRENT_SITE_DATE', $date);

        view()->composer('layouts.nav', function($view) {

            $view->with('report_types', ReportType::all());
        });

        view()->composer('layouts.header', function($view) {

            $settings = Settings::first();
            $date_array = explode('_', $settings->current_date);
            $month = Carbon::createFromFormat('m', $date_array[0])->format('F');
            $date = $month . ' ' . $date_array[1];

            $view->with('current_date', $date)
                ->with('company', $settings->company)
                ->with('mode', $settings->mode)
                ->with('site', $settings->site->name);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //use this method to register things into the servie container

        // $this->app->singleton(Stripe::class, function() {
        //     return new Stripe(config('services.stripe.secret'));
        //     // config / services.php / services > stripe > secret
        // });
    }
}
