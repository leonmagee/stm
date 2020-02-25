<?php

namespace App\Providers;

use App\Helpers;

//use App\Billing\Stripe;

use App\ReportType;
use App\Settings;
use Illuminate\Support\ServiceProvider;

//use App\UserLockedRedirect;

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

        view()->composer(['layouts.nav', 'layouts.nav-mobile'], function ($view) {

            $path = \Request::path();

            $report_types = ReportType::query()->orderBy('order_index')->get();

            $monthly_sims_sub = [
                // [
                //     'name' => 'All Sims',
                //     'link' => '/sims'
                // ]
            ];
            foreach ($report_types as $report_type) {

                $monthly_sims_sub[] = [
                    'name' => $report_type->carrier->name . ' ' . $report_type->name,
                    'link' => '/sims/archive/' . $report_type->id,
                ];

            }
            // $monthly_sims_sub[] = [
            //     'name' => 'Add Sim',
            //     'link' => '/sims/create'
            // ];

            $report_types_sub = [
                [
                    'name' => 'All Report Types',
                    'link' => '/report-types',
                ],
            ];
            foreach ($report_types as $report_type) {

                $report_types_sub[] = [
                    'name' => $report_type->carrier->name . ' ' . $report_type->name,
                    'link' => '/report-types/' . $report_type->id,
                ];
            }

            // $users_sub = [
            //     [
            //         'name' => 'Site Users',
            //         'link' => '/users',
            //     ],
            //     [
            //         'name' => 'Add New User',
            //         'link' => '/register',
            //     ],
            // ];

            $user_sims_sub = [
                [
                    'name' => 'All Sims',
                    'link' => '/user-sims',
                ],
                [
                    'name' => 'Look Up Sims',
                    'link' => '/find-sims',
                ],
                [
                    'name' => 'Delete Sims',
                    'link' => '/delete-sims',
                ],
            ];

            $user_sims_sub_non_admin = [
                [
                    'name' => 'All Sims',
                    'link' => '/user-sims',
                ],
                [
                    'name' => 'Look Up Sims',
                    'link' => '/find-sims',
                ],
            ];

            $settings_sub = [
                [
                    'name' => 'Default Settings',
                    'link' => '/settings',
                ],
                [
                    'name' => 'Site Settings',
                    'link' => '/site-settings',
                ],
                // [
                //     'name' => 'Carriers',
                //     'link' => '/carriers',
                // ],
                [
                    'name' => 'Add New Spiff',
                    'link' => '/add-report-type-spiff',
                ],
                [
                    'name' => 'Add New Residual',
                    'link' => '/add-report-type-residual',
                ],
            ];

            $sims_sub = [
                [
                    'name' => 'User Sims',
                    'link' => '/user-sims',
                ],
                [
                    'name' => 'Upload Sims',
                    'link' => '/sims/upload-all',
                ],
                [
                    'name' => 'Look Up Sims',
                    'link' => '/find-sims',
                ],
                [
                    'name' => 'Transfer Sims',
                    'link' => '/transfer-sims',
                ],
                [
                    'name' => 'Delete Sims',
                    'link' => '/delete-sims',
                ],
            ];

            $sims_sub_manager = [
                [
                    'name' => 'User Sims',
                    'link' => '/user-sims',
                ],
                [
                    'name' => 'Upload Sims',
                    'link' => '/sims/upload-all',
                ],
                [
                    'name' => 'Look Up Sims',
                    'link' => '/find-sims',
                ],
            ];

            $sims_sub_employees = [
                [
                    'name' => 'User Sims',
                    'link' => '/user-sims',
                ],
                [
                    'name' => 'Look Up Sims',
                    'link' => '/find-sims',
                ],
            ];

            $users_sub = [
                [
                    'name' => 'Agents / Dealers',
                    'link' => '/all-users',
                ],
                [
                    'name' => 'Admin Users',
                    'link' => '/admins-managers',
                ],
                [
                    'name' => 'Add New User',
                    'link' => '/register',
                ],
            ];

            $reports_sub = [
                [
                    'name' => 'Report Totals',
                    'link' => '/report-totals',
                ],
                [
                    'name' => 'User Reports',
                    'link' => '/reports',
                ],
            ];

            $emails_sub = [
                [
                    'name' => 'Email Blast',
                    'link' => '/email-blast',
                ],
                [
                    'name' => 'Email Tracker',
                    'link' => '/email-tracker',
                ],
                [
                    'name' => 'Login Tracker',
                    'link' => '/login-tracker',
                ],
            ];

            $emails_sub_manager = [
                [
                    'name' => 'Send Email',
                    'link' => '/send-email',
                ],
                [
                    'name' => 'Email Tracker',
                    'link' => '/email-tracker',
                ],
                [
                    'name' => 'Login Tracker',
                    'link' => '/login-tracker',
                ],
            ];

            $emails_sub_employee = [
                [
                    'name' => 'Email Tracker',
                    'link' => '/email-tracker',
                ],
                [
                    'name' => 'Login Tracker',
                    'link' => '/login-tracker',
                ],
            ];

            $settings = Settings::first();

            $site = $settings->get_site_object()->name;

            // $uploads_sub = [
            //     [
            //         'name' => 'Upload to All Users',
            //         'link' => '/sims/upload-all',
            //     ],
            //     [
            //         'name' => 'Upload to ' . $site . ' Only',
            //         'link' => '/sims/upload',
            //     ],
            // ];

            // $recharge_data = [
            //     [
            //         'name' => '2nd Recharge Data',
            //         'link' => '/recharge-data'
            //     ],
            //     [
            //         'name' => '3rd Recharge Data',
            //         'link' => '/3rd-recharge-data'
            //     ]
            // ];

            $user = \Auth::user();

            if ($user->isAdmin()) {

                // complete menu
                $menu_array = [
                    [
                        'name' => 'Homepage',
                        'link' => '/',
                        'sub' => false,
                        'icon' => 'flaticon-home',
                        'default' => false,
                    ],
                    [
                        'name' => 'Notes',
                        'link' => '/notes',
                        'sub' => false,
                        'icon' => 'flaticon-graph-1',
                        'default' => false,
                    ],
                    [
                        'name' => 'Sim Orders / POS',
                        'link' => '/orders',
                        'sub' => false,
                        'icon' => 'flaticon-sim',
                        'default' => false,
                    ],
                    [
                        'name' => 'Emails',
                        'link' => false,
                        'sub' => $emails_sub,
                        'icon' => 'flaticon-mail',
                        'default' => '/email-blast',
                    ],
                    [
                        'name' => 'Sims',
                        'link' => false,
                        'sub' => $sims_sub,
                        'icon' => 'flaticon-sim-card-1',
                        'default' => '/user-sims',
                    ],
                    [
                        'name' => 'Monthly Sims',
                        'link' => false,
                        'sub' => $monthly_sims_sub,
                        'icon' => 'flaticon-sim-card',
                        'default' => false,
                    ],
                    [
                        'name' => 'Reports',
                        'link' => false,
                        'sub' => $reports_sub,
                        'icon' => 'flaticon-growth',
                        'default' => '/report-totals',
                    ],
                    [
                        'name' => 'Report Types',
                        'link' => false,
                        'sub' => $report_types_sub,
                        'icon' => 'flaticon-report',
                        'default' => '/report-types',
                    ],
                    [
                        'name' => 'Archives',
                        'link' => '/archives',
                        'sub' => false,
                        'icon' => 'flaticon-history-clock-button',
                        'default' => false,
                    ],
                    [
                        'name' => 'Settings',
                        'link' => false,
                        'sub' => $settings_sub,
                        'icon' => 'flaticon-gear',
                        'default' => '/settings',
                    ],
                    [
                        'name' => 'Users',
                        'link' => false,
                        'sub' => $users_sub,
                        'icon' => 'flaticon-group',
                        'default' => '/all-users',
                    ],
                    [
                        'name' => '2nd Recharge',
                        'link' => '/recharge-data',
                        'sub' => false,
                        'icon' => 'flaticon-electric-plug',
                        'default' => false,
                    ],
                    [
                        'name' => '3rd Recharge',
                        'link' => '/3rd-recharge-data',
                        'sub' => false,
                        'icon' => 'flaticon-charging-battery',
                        'default' => false,
                    ],
                ];

            } elseif ($user->isManager()) {

                $menu_array = [
                    [
                        'name' => 'Homepage',
                        'link' => '/',
                        'sub' => false,
                        'icon' => 'flaticon-home',
                        'default' => false,
                    ],
                    // [
                    //     'name' => 'Your Profile',
                    //     'link' => '/profile',
                    //     'sub' => false,
                    //     'icon' => 'flaticon-user',
                    //     'default' => false,
                    // ],
                    [
                        'name' => 'Notes',
                        'link' => '/notes',
                        'sub' => false,
                        'icon' => 'flaticon-graph-1',
                        'default' => false,
                    ],
                    [
                        'name' => 'Sim Orders / POS',
                        'link' => '/orders',
                        'sub' => false,
                        'icon' => 'flaticon-sim',
                        'default' => false,
                    ],
                    [
                        'name' => 'Emails',
                        'link' => false,
                        'sub' => $emails_sub_manager,
                        'icon' => 'flaticon-mail',
                        'default' => '/email-blast',
                    ],
                    [
                        'name' => 'Sims',
                        'link' => false,
                        'sub' => $sims_sub_manager,
                        'icon' => 'flaticon-sim-card-1',
                        'default' => '/user-sims',
                    ],
                    [
                        'name' => 'Monthly Sims',
                        'link' => false,
                        'sub' => $monthly_sims_sub,
                        'icon' => 'flaticon-sim-card',
                        'default' => false,
                    ],
                    [
                        'name' => 'Reports',
                        'link' => false,
                        'sub' => $reports_sub,
                        'icon' => 'flaticon-growth',
                        'default' => '/report-totals',
                    ],
                    // [
                    //     'name' => 'Report Totals',
                    //     'link' => '/report-totals',
                    //     'sub' => false,
                    //     'icon' => 'flaticon-growth',
                    //     'default' => false,
                    // ],
                    // [
                    //     'name' => 'User Reports',
                    //     'link' => '/reports',
                    //     'sub' => false,
                    //     'icon' => 'flaticon-bar-chart',
                    //     'default' => false,
                    // ],
                    [
                        'name' => 'Archives',
                        'link' => '/archives',
                        'sub' => false,
                        'icon' => 'flaticon-history-clock-button',
                        'default' => false,
                    ],
                    [
                        'name' => 'Settings',
                        'link' => '/settings',
                        'sub' => false,
                        'icon' => 'flaticon-gear',
                        'default' => false,
                    ],
                    [
                        'name' => 'Agents / Dealers',
                        'link' => '/all-users',
                        'sub' => false,
                        'icon' => 'flaticon-group',
                        'default' => false,
                    ],
                    [
                        'name' => '2nd Recharge',
                        'link' => '/recharge-data',
                        'sub' => false,
                        'icon' => 'flaticon-electric-plug',
                        'default' => false,
                    ],
                    [
                        'name' => '3rd Recharge',
                        'link' => '/3rd-recharge-data',
                        'sub' => false,
                        'icon' => 'flaticon-charging-battery',
                        'default' => false,
                    ],
                ];

            } elseif ($user->isEmployee()) {

                $menu_array = [
                    [
                        'name' => 'Homepage',
                        'link' => '/',
                        'sub' => false,
                        'icon' => 'flaticon-home',
                        'default' => false,
                    ],
                    // [
                    //     'name' => 'Your Profile',
                    //     'link' => '/profile',
                    //     'sub' => false,
                    //     'icon' => 'flaticon-user',
                    //     'default' => false,
                    // ],
                    [
                        'name' => 'Notes',
                        'link' => '/notes',
                        'sub' => false,
                        'icon' => 'flaticon-graph-1',
                        'default' => false,
                    ],
                    [
                        'name' => 'Sim Orders / POS',
                        'link' => '/orders',
                        'sub' => false,
                        'icon' => 'flaticon-sim',
                        'default' => false,
                    ],
                    [
                        'name' => 'Emails',
                        'link' => false,
                        'sub' => $emails_sub_employee,
                        'icon' => 'flaticon-mail',
                        'default' => '/email-tracker',
                    ],
                    [
                        'name' => 'Sims',
                        'link' => false,
                        'sub' => $sims_sub_employees,
                        'icon' => 'flaticon-sim-card-1',
                        'default' => '/user-sims',
                    ],
                    [
                        'name' => 'Monthly Sims',
                        'link' => false,
                        'sub' => $monthly_sims_sub,
                        'icon' => 'flaticon-sim-card',
                        'default' => false,
                    ],
                    [
                        'name' => 'Reports',
                        'link' => false,
                        'sub' => $reports_sub,
                        'icon' => 'flaticon-growth',
                        'default' => '/report-totals',
                    ],
                    // [
                    //     'name' => 'Report Totals',
                    //     'link' => '/report-totals',
                    //     'sub' => false,
                    //     'icon' => 'flaticon-growth',
                    //     'default' => false,
                    // ],
                    // [
                    //     'name' => 'User Reports',
                    //     'link' => '/reports',
                    //     'sub' => false,
                    //     'icon' => 'flaticon-bar-chart',
                    //     'default' => false,
                    // ],
                    [
                        'name' => 'Archives',
                        'link' => '/archives',
                        'sub' => false,
                        'icon' => 'flaticon-history-clock-button',
                        'default' => false,
                    ],
                    [
                        'name' => 'Settings',
                        'link' => '/settings',
                        'sub' => false,
                        'icon' => 'flaticon-gear',
                        'default' => false,
                    ],
                    [
                        'name' => 'Agents / Dealers',
                        'link' => '/all-users',
                        'sub' => false,
                        'icon' => 'flaticon-group',
                        'default' => false,
                    ],
                    [
                        'name' => '2nd Recharge',
                        'link' => '/recharge-data',
                        'sub' => false,
                        'icon' => 'flaticon-electric-plug',
                        'default' => false,
                    ],
                    [
                        'name' => '3rd Recharge',
                        'link' => '/3rd-recharge-data',
                        'sub' => false,
                        'icon' => 'flaticon-charging-battery',
                        'default' => false,
                    ],
                ];

            } elseif ($agents = $user->master_agent_site) {
                /**
                 * Master Agents
                 */
                $menu_array = [
                    [
                        'name' => 'Homepage',
                        'link' => '/',
                        'sub' => false,
                        'icon' => 'flaticon-home',
                        'default' => false,
                    ],
                    [
                        'name' => 'Your Profile',
                        'link' => '/profile',
                        'sub' => false,
                        'icon' => 'flaticon-user',
                        'default' => false,
                    ],
                    [
                        'name' => 'Your Emails',
                        'link' => '/your-emails',
                        'sub' => false,
                        'icon' => 'flaticon-mail',
                        'default' => false,
                    ],
                    [
                        'name' => 'Your Report',
                        'link' => '/reports',
                        'sub' => false,
                        'icon' => 'flaticon-growth',
                        'default' => false,
                    ],
                    [
                        'name' => 'Your Sims',
                        'link' => '/user-sims',
                        'sub' => false,
                        'icon' => 'flaticon-report-1',
                        'default' => false,
                    ],
                    [
                        'name' => 'Your Archives',
                        'link' => '/archives',
                        'sub' => false,
                        'icon' => 'flaticon-history-clock-button',
                        'default' => false,
                    ],
                    [
                        'name' => 'Look Up Sims',
                        'link' => '/find-sims',
                        'sub' => false,
                        'icon' => 'flaticon-zoom-1',
                        'default' => false,
                    ],
                    [
                        'name' => 'Order Sims / POS',
                        'link' => '/order-sims',
                        'sub' => false,
                        'icon' => 'flaticon-sim',
                        'default' => false,
                    ],
                    [
                        'name' => '2nd<span>/</span>3rd Recharge',
                        'link' => '/all-recharge-data',
                        'sub' => false,
                        'icon' => 'flaticon-electric-plug',
                        'default' => false,
                    ],
                    [
                        'name' => 'Your Dealers',
                        'link' => '/your-dealers',
                        'sub' => false,
                        'icon' => 'flaticon-group',
                        'default' => false,
                    ],
                    [
                        'name' => 'Dealer Reports',
                        'link' => '/dealer-reports',
                        'sub' => false,
                        'icon' => 'flaticon-bar-chart',
                        'default' => false,
                    ],
                    [
                        'name' => 'Report Totals',
                        'link' => '/dealer-report-totals',
                        'sub' => false,
                        'icon' => 'flaticon-growth',
                        'default' => false,
                    ],
                ];

            } else {
                /**
                 * Agents / Dealers / VIP Menu
                 */
                $menu_array = [
                    [
                        'name' => 'Homepage',
                        'link' => '/',
                        'sub' => false,
                        'icon' => 'flaticon-home',
                        'default' => false,
                    ],
                    [
                        'name' => 'Your Profile',
                        'link' => '/profile',
                        'sub' => false,
                        'icon' => 'flaticon-user',
                        'default' => false,
                    ],
                    [
                        'name' => 'Your Emails',
                        'link' => '/your-emails',
                        'sub' => false,
                        'icon' => 'flaticon-mail',
                        'default' => false,
                    ],
                    [
                        'name' => 'Your Report',
                        'link' => '/reports',
                        'sub' => false,
                        'icon' => 'flaticon-growth',
                        'default' => false,
                    ],
                    [
                        'name' => 'Your Sims',
                        'link' => '/user-sims',
                        'sub' => false,
                        'icon' => 'flaticon-report-1',
                        'default' => false,
                    ],
                    [
                        'name' => 'Your Archives',
                        'link' => '/archives',
                        'sub' => false,
                        'icon' => 'flaticon-history-clock-button',
                        'default' => false,
                    ],
                    [
                        'name' => 'Look Up Sims',
                        'link' => '/find-sims',
                        'sub' => false,
                        'icon' => 'flaticon-zoom-1',
                        'default' => false,
                    ],
                    [
                        'name' => 'Order Sims / POS',
                        'link' => '/order-sims',
                        'sub' => false,
                        'icon' => 'flaticon-sim',
                        'default' => false,
                    ],
                    [
                        'name' => '2nd<span>/</span>3rd Recharge',
                        'link' => '/all-recharge-data',
                        'sub' => false,
                        'icon' => 'flaticon-electric-plug',
                        'default' => false,
                    ],
                ];

            }

            //$view->with('menu', $menu_array);
            $view->with(['menu' => $menu_array, 'path' => $path]);
        });

        view()->composer('layouts.header', function ($view) {

            $settings = Settings::first();
            $date_array = explode('_', $settings->current_date);
            $month = Carbon::createFromFormat('m', $date_array[0])->format('F');
            $date = $month . ' ' . $date_array[1];
            $logged_in_user = \Auth::user();

            if (Helpers::is_normal_user()) {
                $site = $logged_in_user->role->name;
            } else {
                $site = $settings->get_site_object()->name;
            }

            $view->with('current_date', $date)
                ->with('logged_in_user', $logged_in_user)
                ->with('company', $settings->company)
                ->with('mode', $settings->mode)
                ->with('site', $site);
            //->with('site', $settings->site->name);
        });

        view()->composer(['users.edit', 'users.edit_profile', 'registration.create'], function ($view) {

            $states = [
                "N/A", "AK", "AL", "AR", "AZ", "CA", "CO", "CT", "DC",
                "DE", "FL", "GA", "HI", "IA", "ID", "IL", "IN", "KS", "KY", "LA",
                "MA", "MD", "ME", "MI", "MN", "MO", "MS", "MT", "NC", "ND", "NE",
                "NH", "NJ", "NM", "NV", "NY", "OH", "OK", "OR", "PA", "PR", "RI", "SC",
                "SD", "TN", "TX", "UT", "VA", "VT", "WA", "WI", "WV", "WY"];

            $view->with('states', $states);

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

        //$lock_test = new UserLockedRedirect();

        // $this->app->singleton(UserLockedRedirect::class, function() {
        //     return new UserLockedRedirect();
        // });

        // $this->app->singleton(Stripe::class, function() {
        //     return new Stripe(config('services.stripe.secret'));
        //     // config / services.php / services > stripe > secret
        // });
    }
}
