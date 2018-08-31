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

        view()->composer(['layouts.nav', 'layouts.nav-mobile'], function($view) {

            $report_types = ReportType::query()->get();

            $view->with('report_types', $report_types);
        });

        view()->composer('layouts.header', function($view) {

            $settings = Settings::first();
            $date_array = explode('_', $settings->current_date);
            $month = Carbon::createFromFormat('m', $date_array[0])->format('F');
            $date = $month . ' ' . $date_array[1];

            $view->with('current_date', $date)
                ->with('company', $settings->company)
                ->with('mode', $settings->mode)
                ->with('site', $settings->get_site_object()->name);
                //->with('site', $settings->site->name);
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
