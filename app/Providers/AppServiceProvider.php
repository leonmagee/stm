<?php

namespace App\Providers;

use App\Category;
use App\Helpers;
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
        //Product::observe(ProductObserver::class);
        view()->composer('*', function ($view) {
            $name = str_replace('.', '-', $view->getName());
            view()->share('view_name', $name);
        });

        view()->composer(['layouts.product-menu'], function ($view) {
            $cats = Category::all();
            $view->with(compact('cats'));
        });

        view()->composer(['layouts.nav-mobile-logged-out'], function ($view) {

            $menu_array = [
                [
                    "name" => "About",
                    "link" => "/about",
                    "sub" => false,
                    "default" => false,
                ],
                [
                    "name" => "Contact",
                    "link" => "/contact-us",
                    "sub" => false,
                    "default" => false,
                ],
                [
                    "name" => "H2O Direct",
                    "link" => "https://h2odirectnow.com",
                    "sub" => false,
                    "default" => false,
                ],
                [
                    "name" => "Lyca Direct",
                    "link" => "https://pos.gswmax.com",
                    "sub" => false,
                    "default" => false,
                ],
                [
                    "name" => "GS Posa",
                    "link" => "https://gsposa.instapayportal.com/login",
                    "sub" => false,
                    "default" => false,
                ],
            ];
            $view->with(['menu' => $menu_array]);

        });

        view()->composer(['layouts.nav', 'layouts.nav-mobile'], function ($view) {

            $path = \Request::path();

            $report_types = ReportType::query()->orderBy('order_index')->get();

            foreach ($report_types as $report_type) {

                $monthly_sims_sub[] = [
                    'name' => $report_type->carrier->name . ' ' . $report_type->name,
                    'link' => '/sims/archive/' . $report_type->id,
                ];

            }

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
                [
                    'name' => 'Add New Spiff',
                    'link' => '/add-report-type-spiff',
                ],
                [
                    'name' => 'Add New Residual',
                    'link' => '/add-report-type-residual',
                ],
                [
                    'name' => 'Add New Plan',
                    'link' => '/plan/create',
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
                [
                    'name' => '2nd Recharge',
                    'link' => '/recharge-data',
                ],
                [
                    'name' => '3rd Recharge',
                    'link' => '/3rd-recharge-data',
                ],
            ];

            $trackers_sub = [
                [
                    'name' => 'Email Tracker',
                    'link' => '/email-tracker',
                ],
                [
                    'name' => 'Login Tracker',
                    'link' => '/login-tracker',
                ],
                [
                    'name' => 'Credit History',
                    'link' => '/transaction-tracker',
                ],
            ];

            $trackers_sub_dealer = [
                [
                    'name' => 'Email Tracker',
                    'link' => '/email-tracker-dealer',
                ],
                [
                    'name' => 'Login Tracker',
                    'link' => '/login-tracker',
                ],
                [
                    'name' => 'Credit History',
                    'link' => '/transaction-tracker-dealer',
                ],
                [
                    'name' => 'Purchase Orders',
                    'link' => '/dealer-purchases',
                ],
                [
                    'name' => 'RMAs',
                    'link' => '/rmas',
                ],
                [
                    'name' => 'Total Sales',
                    'link' => '/sales',
                ],
                [
                    'name' => 'Invoices',
                    'link' => '/invoices',
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

            $invoice_sub = [
                [
                    'name' => 'All Invoices',
                    'link' => '/invoices',
                ],
                [
                    'name' => 'Create Invoice',
                    'link' => '/new-invoice',
                ],
            ];

            $products_sub = [
                [
                    'name' => 'IMEI Lookup',
                    'link' => 'imei',
                ],
                [
                    'name' => 'Products List',
                    'link' => '/products-list',
                ],
                [
                    'name' => 'Products Sort',
                    'link' => '/products-sort?cat=1',
                ],
                [
                    'name' => 'Create New Product',
                    'link' => '/product-new',
                ],
                [
                    'name' => 'Purchase Orders',
                    'link' => '/purchases',
                ],
                [
                    'name' => 'RMAs',
                    'link' => '/rmas',
                ],
                [
                    'name' => 'Total Sales',
                    'link' => '/sales',
                ],
                // [
                //     'name' => 'Total Sales Agents',
                //     'link' => '/sales-agents',
                // ],
            ];

            $my_history_sub = [
                [
                    'name' => 'Email History',
                    'link' => '/your-emails',
                ],
                [
                    'name' => 'Invoice History',
                    'link' => '/your-invoices',
                ],
                [
                    'name' => 'Credit History',
                    'link' => '/transaction-tracker',
                ],
            ];

            $my_report_sub = [
                [
                    'name' => 'Commission Report',
                    'link' => '/reports',
                ],
                [
                    'name' => '2nd<span>/</span>3rd Recharge',
                    'link' => '/all-recharge-data',
                ],
            ];

            $dealer_report_totals = [
                [
                    'name' => 'Dealer Reports',
                    'link' => '/dealer-reports',
                ],
                [
                    'name' => 'Dealer 2nd Recharge',
                    'link' => '/dealer-2nd-recharge',
                ],
                [
                    'name' => 'Dealer 3rd Recharge',
                    'link' => '/dealer-3rd-recharge',
                ],
            ];

            $settings = Settings::first();

            $site = $settings->get_site_object()->name;

            $user = \Auth::user();

            if ($user->isAdmin()) {

                $menu_array = [
                    [
                        'name' => 'Plans Spiff',
                        'link' => '/plans',
                        'sub' => false,
                        'icon' => 'flaticon-wifi',
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
                        'name' => 'Sim Orders',
                        'link' => '/orders',
                        'sub' => false,
                        'icon' => 'flaticon-sim',
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
                        'name' => 'Invoices',
                        'link' => false,
                        'sub' => $invoice_sub,
                        'icon' => 'flaticon-mail-2',
                        'default' => '/invoices',
                    ],
                    [
                        'name' => 'History Trackers',
                        'link' => false,
                        'sub' => $trackers_sub,
                        'icon' => 'flaticon-bar-graph-on-a-rectangle',
                        'default' => '/email-tracker',
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
                        'name' => 'Products List',
                        'link' => false,
                        'sub' => $products_sub,
                        'icon' => 'flaticon-wifi',
                        'default' => '/products-list',
                    ],
                ];

            } elseif ($user->isManager()) {

                $menu_array = [
                    [
                        'name' => 'Plans Spiff',
                        'link' => '/plans',
                        'sub' => false,
                        'icon' => 'flaticon-wifi',
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
                        'name' => 'Sim Orders',
                        'link' => '/orders',
                        'sub' => false,
                        'icon' => 'flaticon-sim',
                        'default' => false,
                    ],
                    [
                        'name' => 'Send Email',
                        'link' => '/send-email',
                        'sub' => false,
                        'icon' => 'flaticon-mail',
                        'default' => false,
                    ],
                    [
                        'name' => 'Invoices',
                        'link' => '/invoices',
                        'sub' => false,
                        'icon' => 'flaticon-mail-2',
                        'default' => false,
                    ],
                    [
                        'name' => 'History Trackers',
                        'link' => false,
                        'sub' => $trackers_sub,
                        'icon' => 'flaticon-bar-graph-on-a-rectangle',
                        'default' => '/email-tracker',
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
                        'name' => 'Users',
                        'link' => '/all-users',
                        'sub' => false,
                        'icon' => 'flaticon-group',
                        'default' => false,
                    ],
                ];

            } elseif ($user->isEmployee()) {

                $menu_array = [
                    [
                        'name' => 'Plans Spiff',
                        'link' => '/plans',
                        'sub' => false,
                        'icon' => 'flaticon-wifi',
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
                        'name' => 'Sim Orders',
                        'link' => '/orders',
                        'sub' => false,
                        'icon' => 'flaticon-sim',
                        'default' => false,
                    ],
                    [
                        'name' => 'Invoices',
                        'link' => '/invoices',
                        'sub' => false,
                        'icon' => 'flaticon-mail-2',
                        'default' => false,
                    ],
                    [
                        'name' => 'History Trackers',
                        'link' => false,
                        'sub' => $trackers_sub,
                        'icon' => 'flaticon-bar-graph-on-a-rectangle',
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
                        'name' => 'Users',
                        'link' => '/all-users',
                        'sub' => false,
                        'icon' => 'flaticon-group',
                        'default' => false,
                    ],
                ];

            } elseif ($user->isMasterAgent()) {
                /**
                 * Master Agents
                 */
                $menu_array = [
                    [
                        'name' => 'Plans Spiff',
                        'link' => '/plans',
                        'sub' => false,
                        'icon' => 'flaticon-wifi',
                        'default' => false,
                    ],
                    [
                        'name' => 'Redeem Credit',
                        'link' => '/redeem-credit',
                        'sub' => false,
                        'icon' => 'flaticon-report',
                        'default' => false,
                    ],
                    // [
                    //     'name' => 'Order Free Sims',
                    //     'link' => '/order-sims',
                    //     'sub' => false,
                    //     'icon' => 'flaticon-sim',
                    //     'default' => false,
                    // ],
                    [
                        'name' => 'Look Up Sims',
                        'link' => '/look-up-sims',
                        'sub' => false,
                        'icon' => 'flaticon-zoom-1',
                        'default' => false,
                    ],
                    [
                        'name' => 'My Sims',
                        'link' => '/user-sims',
                        'sub' => false,
                        'icon' => 'flaticon-report-1',
                        'default' => false,
                    ],
                    [
                        'name' => 'My Archives',
                        'link' => '/archives',
                        'sub' => false,
                        'icon' => 'flaticon-history-clock-button',
                        'default' => false,
                    ],
                    [
                        'name' => 'My Profile',
                        'link' => '/profile',
                        'sub' => false,
                        'icon' => 'flaticon-user',
                        'default' => false,
                    ],
                    [
                        'name' => 'My Reports',
                        'link' => false,
                        'sub' => $my_report_sub,
                        'icon' => 'flaticon-growth',
                        'default' => '/reports',
                    ],
                    [
                        'name' => 'My History',
                        'link' => false,
                        'sub' => $my_history_sub,
                        'icon' => 'flaticon-mail',
                        'default' => '/your-emails',
                    ],
                    [
                        'name' => 'Report Totals',
                        'link' => '/dealer-report-totals',
                        'sub' => false,
                        'icon' => 'flaticon-growth',
                        'default' => false,
                    ],
                    [
                        'name' => 'Dealer Report Totals',
                        'link' => false,
                        'sub' => $dealer_report_totals,
                        'icon' => 'flaticon-group',
                        'default' => '/dealer-reports',
                    ],
                    [
                        'name' => 'Your Dealers',
                        'link' => '/your-dealers',
                        'sub' => false,
                        'icon' => 'flaticon-group',
                        'default' => false,
                    ],
                    [
                        'name' => 'Your Dealers History',
                        'link' => false,
                        'sub' => $trackers_sub_dealer,
                        'icon' => 'flaticon-bar-graph-on-a-rectangle',
                        'default' => '/email-tracker-dealer',
                    ],
                ];

            } else {
                /**
                 * Agents / Dealers / VIP Menu
                 */
                $menu_array = [
                    [
                        'name' => 'Plans Spiff',
                        'link' => '/plans',
                        'sub' => false,
                        'icon' => 'flaticon-wifi',
                        'default' => false,
                    ],
                    [
                        'name' => 'Redeem Credit',
                        'link' => '/redeem-credit',
                        'sub' => false,
                        'icon' => 'flaticon-report',
                        'default' => false,
                    ],
                    [
                        'name' => 'Order Free Sims',
                        'link' => '/order-sims',
                        'sub' => false,
                        'icon' => 'flaticon-sim',
                        'default' => false,
                    ],
                    [
                        'name' => 'Look Up Sims',
                        'link' => '/look-up-sims',
                        'sub' => false,
                        'icon' => 'flaticon-zoom-1',
                        'default' => false,
                    ],
                    [
                        'name' => 'My Sims',
                        'link' => '/user-sims',
                        'sub' => false,
                        'icon' => 'flaticon-report-1',
                        'default' => false,
                    ],
                    [
                        'name' => 'My Archives',
                        'link' => '/archives',
                        'sub' => false,
                        'icon' => 'flaticon-history-clock-button',
                        'default' => false,
                    ],
                    [
                        'name' => 'My Profile',
                        'link' => '/profile',
                        'sub' => false,
                        'icon' => 'flaticon-user',
                        'default' => false,
                    ],
                    [
                        'name' => 'My Reports',
                        'link' => false,
                        'sub' => $my_report_sub,
                        'icon' => 'flaticon-growth',
                        'default' => '/reports',
                    ],
                    [
                        'name' => 'My History',
                        'link' => false,
                        'sub' => $my_history_sub,
                        'icon' => 'flaticon-mail',
                        'default' => '/your-emails',
                    ],
                ];

            }

            $match_array = [
                'admins-managers' => 'all-users',
                'register' => 'all-users',
                'login-tracker' => 'email-tracker',
                'transaction-tracker' => 'email-tracker',
                'transaction-tracker-dealer' => 'email-tracker-dealer',
                'dealer-purchases' => 'email-tracker-dealer',
                'rmas' => 'email-tracker-dealer',
                'sims/upload-all' => 'user-sims',
                'find-sims' => 'user-sims',
                'transfer-sims' => 'user-sims',
                'delete-sims' => 'user-sims',
                'reports' => 'report-totals',
                'recharge-data' => 'report-totals',
                '3rd-recharge-data' => 'report-totals',
                'site-settings' => 'settings',
                'add-report-type-spiff' => 'settings',
                'add-report-type-residual' => 'settings',
                'edit-profile' => 'settings',
                'profile' => 'settings',
                'all-recharge-data' => 'reports',
                'your-invoices' => 'your-emails',
                'dealer-2nd-recharge' => 'dealer-reports',
                'dealer-3rd-recharge' => 'dealer-reports',
                'product-new' => 'products-list',
                'purchases' => 'products-list',
                'sales' => 'products-list',
            ];

            $view->with(['menu' => $menu_array, 'path' => $path, 'match_array' => $match_array]);
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
