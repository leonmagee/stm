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

            $monthly_sims_sub = [
                // [
                //     'name' => 'All Sims',
                //     'link' => '/sims'
                // ]
            ];
            foreach($report_types as $report_type) {

                $monthly_sims_sub[] = [
                    'name' => $report_type->carrier->name . ' ' . $report_type->name,
                    'link' => '/sims/archive/' . $report_type->id
                ];

            }
            // $monthly_sims_sub[] = [
            //     'name' => 'Add Sim',
            //     'link' => '/sims/create'
            // ];

            $report_types_sub = [
                [
                    'name' => 'All Report Types',
                    'link' => '/report-types'
                ]
            ];
            foreach($report_types as $report_type) {

                $report_types_sub[] = [
                    'name' => $report_type->carrier->name . ' ' . $report_type->name,
                    'link' => '/report-types/' . $report_type->id
                ];
            }

            $users_sub = [
                [
                    'name' => 'All Users',
                    'link' => '/users'
                ],
                [
                    'name' => 'Add New User',
                    'link' => '/register'
                ]
            ];

            $user_sims_sub = [
                [
                    'name' => 'All Sims',
                    'link' => '/user-sims'
                ],
                [
                    'name' => 'Look Up Sims',
                    'link' => '/find-sims'
                ],
                [
                    'name' => 'Delete Sims',
                    'link' => '/delete-sims'
                ]
            ];

            $user_sims_sub_non_admin = [
                [
                    'name' => 'All Sims',
                    'link' => '/user-sims'
                ],
                [
                    'name' => 'Look Up Sims',
                    'link' => '/find-sims'
                ]
            ];

            $settings_sub = [
                [
                    'name' => 'Default Settings',
                    'link' => '/settings'
                ],
                [
                    'name' => 'Site Settings',
                    'link' => '/site-settings'
                ],
                [
                    'name' => 'Carriers',
                    'link' => '/carriers'
                ],
                [
                    'name' => 'Add New Spiff',
                    'link' => '/add-report-type-spiff'
                ],
                [
                    'name' => 'Add New Residual',
                    'link' => '/add-report-type-residual'
                ]
            ];

            $user = \Auth::user();

            if ( $user->isAdmin() ) {

                // complete menu
                $menu_array = [
                    [
                        'name' => 'Monthly Sims',
                        'link' => false,
                        'sub' => $monthly_sims_sub,
                        'icon' => 'flaticon-sim-card',
                        'default' => false,
                    ],
                    [
                        'name' => 'Report Types',
                        'link' => false,
                        'sub' => $report_types_sub,
                        'icon' => 'flaticon-report',
                        'default' => '/report-types',
                    ],
                    [
                        'name' => 'Upload Sims',
                        'link' => '/sims/upload',
                        'sub' => false,
                        'icon' => 'flaticon-upload',
                        'default' => false,
                    ],
                    [
                        'name' => 'Users',
                        'link' => false,
                        'sub' => $users_sub,
                        'icon' => 'flaticon-group',
                        'default' => '/users',
                    ],
                    [
                        'name' => 'User Sims',
                        'link' => false,
                        'sub' => $user_sims_sub,
                        'icon' => 'flaticon-report-1',
                        'default' => '/user-sims',
                    ],
                    [
                        'name' => 'Settings',
                        'link' => false,
                        'sub' => $settings_sub,
                        'icon' => 'flaticon-gear',
                        'default' => '/settings',
                    ],
                    [
                        'name' => 'Report Totals',
                        'link' => '/report-totals',
                        'sub' => false,
                        'icon' => 'flaticon-growth',
                        'default' => false,
                    ],
                    [
                        'name' => 'User Reports',
                        'link' => '/reports',
                        'sub' => false,
                        'icon' => 'flaticon-bar-chart',
                        'default' => false,
                    ],
                    [
                        'name' => 'Archives',
                        'link' => '/archives',
                        'sub' => false,
                        'icon' => 'flaticon-history-clock-button',
                        'default' => false,
                    ],
                    [
                        'name' => 'Recharge Data',
                        'link' => '/recharge-data',
                        'sub' => false,
                        'icon' => 'flaticon-electric-plug',
                        'default' => false,
                    ],
                    [
                        'name' => 'Email Blast',
                        'link' => '/email-blast',
                        'sub' => false,
                        'icon' => 'flaticon-mail',
                        'default' => false,
                    ],
                    [
                        'name' => 'Homepage',
                        'link' => '/',
                        'sub' => false,
                        'icon' => 'flaticon-home',
                        'default' => false,
                    ],
                ];

            } else {

                /**
                * @todo create a menu for 'Managers'
                */

                // user menu
                $menu_array = [
                    [
                        'name' => 'Monthly Sims',
                        'link' => false,
                        'sub' => $monthly_sims_sub,
                        'icon' => 'flaticon-sim-card',
                        'default' => false,
                    ],
                    [
                        'name' => 'Your Sims',
                        'link' => false,
                        'sub' => $user_sims_sub_non_admin,
                        'icon' => 'flaticon-report-1',
                        'default' => '/user-sims',
                    ],
                    [
                        'name' => 'Your Report',
                        'link' => '/reports',
                        'sub' => false,
                        'icon' => 'flaticon-growth',
                        'default' => false,
                    ],
                    [
                        'name' => 'Your Profile',
                        'link' => '/',
                        'sub' => false,
                        'icon' => 'flaticon-user',
                        'default' => false,
                    ],
                ];

            }

            $view->with('menu', $menu_array);
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
