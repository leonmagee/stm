<?php

namespace App;

use App\Settings;

class HelpersSave
{
    /**
     * Invoice Status
     */
    public static function status($id)
    {
        if ($id == 2) {
            return 'Pending';
        } elseif ($id == 3) {
            return 'Paid';
        } elseif ($id == 4) {
            return 'Cancelled';
        } else {
            return 'New';
        }
    }

    /**
     * Purchase Status
     */
    public static function purchase_status($id)
    {
        if ($id == 2) {
            return 'Pending';
        } elseif ($id == 3) {
            return 'Shipped';
        } else {
            return 'Cancelled'; // 4
        }
    }

    /**
     * Calc Discount
     */
    public static function get_discount_price($price, $discount)
    {
        return $price - ($price * ($discount / 100));
    }

    /**
     * Purchase Status
     */
    public static function rma_status($id)
    {
        if ($id == 1) {
            return 'Completed';
        } elseif ($id == 2) {
            return 'Pending';
        } elseif ($id == 3) {
            return 'Approved';
        } else {
            //return 'Denied'; // 4
            return 'Rejected'; // 4
        }
    }

    public static function invoice_item($id)
    {
        if ($id == 2) {
            return 'Service';
        } elseif ($id == 3) {
            return 'Payment';
        } else {
            return 'Product';
        }
    }

    public static function get_date_name($date)
    {
        $month_array = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];
        $exploded = explode('_', $date);
        //$month = Carbon::createFromFormat('m', $exploded[0])->format('F');
        // carbon doesn't work for some weird reason - issue with february?
        $month = $month_array[$exploded[0] - 1];
        $current_site_date = $month . ' ' . $exploded[1];
        return $current_site_date;
    }

    public static function current_date_name()
    {
        $settings = Settings::first();
        return Self::get_date_name($settings->current_date);
    }

    public static function current_date()
    {
        $settings = Settings::first();
        return $settings->current_date;
    }

    public static function verify_sim($sim)
    {
        if (strlen($sim) > 7) {
            return true;
        } else {
            return false;
        }
    }

    public static function is_site_locked()
    {

        $settings = Settings::first();
        if ($settings->mode === 'locked') {
            return true;
        }
        return false;
    }

    public static function current_user_admin()
    {
        if ($user = \Auth::user()) {
            if ($user->role_id === 1) {
                return true;
            }
        }
        return false;
    }

    public static function current_user_master_agent($user)
    {
        if ($logged_in_user = \Auth::user()) {
            if ($site_id = $logged_in_user->isMasterAgent()) {
                if ($user->site_id() == $site_id) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        return false;
    }

    public static function current_user_manager()
    {
        if ($user = \Auth::user()) {
            if ($user->role_id === 2) {
                return true;
            }
        }
        return false;
    }

    public static function current_user_employee()
    {
        if ($user = \Auth::user()) {
            if ($user->role_id === 6) {
                return true;
            }
        }
        return false;
    }

    public static function is_normal_user()
    {
        if ($user = \Auth::user()) {
            $admin_users = [1, 2, 6]; //1 = admin, 2 = manager, 6 = employee
            if (in_array($user->role_id, $admin_users)) {
                return false;
            }
            return true;
            // if (($user->role_id === 3) || ($user->role_id === 4) || ($user->role_id === 5)) {
            //     return true;
            // }
        }
        return false;
    }

    public static function is_closed_user()
    {
        if ($user = \Auth::user()) {
            if ($user->role_id === 7) {
                return true;
            }
        }
        return false;
    }

    public static function restrict_page()
    {
        if ($user = \Auth::user()) {
            if (($user->role_id === 3) || ($user->role_id === 4) || ($user->role_id === 5)) {
                return redirect('/');
            }
        }
    }

    public static function current_role_id()
    {
        $current_site_id = session('current_site_id', 1);
        $current_site = Site::find($current_site_id);
        return $current_site->role_id;
    }

    public static function get_role_id($site_id)
    {
        $current_site = Site::find($site_id);
        return $current_site->role_id;
    }

    public static function get_site_id($role_id)
    {
        $site = Site::where('role_id', $role_id)->first();
        if (!$site) {
            return 1;
        }
        return $site->id;
    }

    public static function isRussian($text)
    {
        return preg_match('/[А-Яа-яЁё]/u', $text);
    }

    public static function checkImei($imei, $service)
    {
        $key = env('IMEI_KEY');
        $url = 'https://api.imeicheck.com/api/v1/services/order/create?serviceid=' . $service . '&key=' . $key . '&imei=' . $imei;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        $json = curl_exec($curl);
        $curl_result = json_decode($json);
        curl_close($curl);
        return $curl_result;
    }

    public static function imeiCarrier($service, $imei)
    {
        $curl_new = Helpers::checkImei($imei, $service);
        $result2 = false;
        if ($curl_new) {
            //dd($curl_new);
            $status = $curl_new->status;
            if ($status !== 'failed') {
                $result2 = $curl_new->result;
            }
        }
        if ($result2) {
            // carrier
            $pattern = '|Carrier: ([^<]+)<br|';
            $matches = [];
            preg_match($pattern, $result2, $matches);
            if (isset($matches[1])) {
                $carrier = $matches[1];
            } else {
                $carrier = null;
            }

            // warranty status
            $pattern = '|Warranty Status: ([^<]+)<br|';
            $matches = [];
            preg_match($pattern, $result2, $matches);
            if (isset($matches[1])) {
                $warranty_status = $matches[1];
            } else {
                $warranty_status = null;
            }

            // warranty start date
            $pattern = '|Warranty Start[^:]*: ([^<]+)<br|';
            $matches = [];
            preg_match($pattern, $result2, $matches);
            if (isset($matches[1])) {
                $warranty_start = $matches[1];
            } else {
                $warranty_start = null;
            }

            // warranty end date
            $pattern = '|Warranty End[^:]*: ([^<]+)<br|';
            $matches = [];
            preg_match($pattern, $result2, $matches);
            if (isset($matches[1])) {
                $warranty_end = $matches[1];
            } else {
                $warranty_end = null;
            }

            // apple care
            $pattern = '|AppleCare: <span[^>]*>([^<]+)<\/span>|';
            $matches = [];
            preg_match($pattern, $result2, $matches);
            if (isset($matches[1])) {
                $apple_care = $matches[1];
            } else {
                $apple_care = null;
            }

            // activated
            $pattern = '|Activated: <span[^>]*>([^<]+)<\/span>|';
            $matches = [];
            preg_match($pattern, $result2, $matches);
            if (isset($matches[1])) {
                $activated = $matches[1];
            } else {
                $activated = null;
            }

            // repairs & service coverage
            $pattern = '|Repairs & Service Coverage: <span[^>]*>([^<]+)<\/span>|';
            $matches = [];
            preg_match($pattern, $result2, $matches);
            if (isset($matches[1])) {
                $repairs_service = $matches[1];
            } else {
                $repairs_service = null;
            }

            // refurbished
            $pattern = '|Refurbished: <span[^>]*>([^<]+)<\/span>|';
            $matches = [];
            preg_match($pattern, $result2, $matches);
            if (isset($matches[1])) {
                $refurbished = $matches[1];
            } else {
                $refurbished = null;
            }

            $result = [
                'price' => $curl_new->price,
                'carrier' => $carrier,
                'warranty_status' => $warranty_status,
                'warranty_start' => $warranty_start,
                'warranty_end' => $warranty_end,
                'apple_care' => $apple_care,
                'activated' => $activated,
                'repairs_service' => $repairs_service,
                'refurbished' => $refurbished,
                'all_data' => json_encode($result2),
            ];

        } else {
            $result = [
                'price' => 0,
                'carrier' => null,
                'warranty_status' => null,
                'warranty_start' => null,
                'warranty_end' => null,
                'apple_care' => null,
                'activated' => null,
                'repairs_service' => null,
                'refurbished' => null,
                'all_data' => null,
            ];

        }

        return $result;

    }

    public static function date_array()
    {
        return [
            '1_2018',
            '2_2018',
            '3_2018',
            '4_2018',
            '5_2018',
            '6_2018',
            '7_2018',
            '8_2018',
            '9_2018',
            '10_2018',
            '11_2018',
            '12_2018',
            '1_2019',
            '2_2019',
            '3_2019',
            '4_2019',
            '5_2019',
            '6_2019',
            '7_2019',
            '8_2019',
            '9_2019',
            '10_2019',
            '11_2019',
            '12_2019',
            '1_2020',
            '2_2020',
            '3_2020',
            '4_2020',
            '5_2020',
            '6_2020',
            '7_2020',
            '8_2020',
            '9_2020',
            '10_2020',
            '11_2020',
            '12_2020',
            '1_2021',
            '2_2021',
            '3_2021',
            '4_2021',
            '5_2021',
            '6_2021',
            '7_2021',
            '8_2021',
            '9_2021',
            '10_2021',
            '11_2021',
            '12_2021',
            '1_2022',
            '2_2022',
            '3_2022',
            '4_2022',
            '5_2022',
            '6_2022',
            '7_2022',
            '8_2022',
            '9_2022',
            '10_2022',
            '11_2022',
            '12_2022',
            '1_2023',
            '2_2023',
            '3_2023',
            '4_2023',
            '5_2023',
            '6_2023',
            '7_2023',
            '8_2023',
            '9_2023',
            '10_2023',
            '11_2023',
            '12_2023',
            '1_2024',
            '2_2024',
            '3_2024',
            '4_2024',
            '5_2024',
            '6_2024',
            '7_2024',
            '8_2024',
            '9_2024',
            '10_2024',
            '11_2024',
            '12_2024',
            '1_2025',
            '2_2025',
            '3_2025',
            '4_2025',
            '5_2025',
            '6_2025',
            '7_2025',
            '8_2025',
            '9_2025',
            '10_2025',
            '11_2025',
            '12_2025',
            '1_2026',
            '2_2026',
            '3_2026',
            '4_2026',
            '5_2026',
            '6_2026',
            '7_2026',
            '8_2026',
            '9_2026',
            '10_2026',
            '11_2026',
            '12_2026',
            '1_2027',
            '2_2027',
            '3_2027',
            '4_2027',
            '5_2027',
            '6_2027',
            '7_2027',
            '8_2027',
            '9_2027',
            '10_2027',
            '11_2027',
            '12_2027',
            '1_2028',
            '2_2028',
            '3_2028',
            '4_2028',
            '5_2028',
            '6_2028',
            '7_2028',
            '8_2028',
            '9_2028',
            '10_2028',
            '11_2028',
            '12_2028',
            '1_2029',
            '2_2029',
            '3_2029',
            '4_2029',
            '5_2029',
            '6_2029',
            '7_2029',
            '8_2029',
            '9_2029',
            '10_2029',
            '11_2029',
            '12_2029',
            '1_2030',
            '2_2030',
            '3_2030',
            '4_2030',
            '5_2030',
            '6_2030',
            '7_2030',
            '8_2030',
            '9_2030',
            '10_2030',
            '11_2030',
            '12_2030',
        ];
    }

}
