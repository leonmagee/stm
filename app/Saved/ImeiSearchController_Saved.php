<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\ImeiSearch;
use App\User;
use Illuminate\Http\Request;
use \Carbon\Carbon;

class ImeiSearchControllerSave extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        if ($user->isAdminManagerEmployee()) {
            return view('imei_search.index');
        } else {
            return view('imei_search.index-dealer');
        }
    }

    public function index_dealers()
    {
        return view('imei_search.index-agent');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('imei_search.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'imei' => 'required',
        ]);

        $imei = $request->imei;
        $user_id = \Auth::user()->id;

        $existing = ImeiSearch::where([
            'user_id' => $user_id,
            'imei' => $imei,
        ])->first();

        if ($existing) {
            $now = Carbon::now();

            $saved = $existing->created_at;

            $days = $saved->diffInDays($now);

            if ($days >= 3) {
                // delete saved instance
                $existing->delete();
            } else {
                // redirect to saved instance
                session()->flash('message', 'Entry Previously Recorded for IMEI: ' . $imei);
                return redirect('/imeis/' . $existing->id);
            }

        }

        /**
         * Get curl result for service 134
         * All model lookup for model and blacklist
         */
        $curl_result = Helpers::checkImei($imei, 134);

        $status = $curl_result->status;
        //dd($curl_result);
        if ($status == 'failed') {
            session()->flash('danger', 'IMEI Number Not Found.');
            return redirect()->back();
        }
        $result = $curl_result->result;
        $imei = $curl_result->imei;
        $balance = $curl_result->balance;
        $price = $curl_result->price;
        $id = $curl_result->id;

        $pattern = '|Blacklist Status: <[a-z =":;]+>([A-Za-z]+)</span>|';
        $matches = [];
        preg_match($pattern, $result, $matches);
        if (isset($matches[1])) {
            $blacklist = $matches[1];
        } else {
            $blacklist = null;
        }

        $pattern = '|Model: ([^<]+)<br|';
        $matches = [];
        preg_match($pattern, $result, $matches);
        if (isset($matches[1])) {
            $model = $matches[1];
        } else {
            $model = null;
        }

        $pattern = '|Model Name: ([^<]+)<br|';
        $matches = [];
        preg_match($pattern, $result, $matches);
        if (isset($matches[1])) {
            $model_name = $matches[1];
        } else {
            $model_name = null;
        }

        $pattern = '|Manufacturer: ([^<]+)<br|';
        $matches = [];
        preg_match($pattern, $result, $matches);
        if (isset($matches[1])) {
            $manufacturer = $matches[1];
        } else {
            $manufacturer = null;
        }

        // set default for second curl request data
        $result_2 = [
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
        if ($manufacturer) {

            $apple = stripos($manufacturer, 'apple');
            $samsung = stripos($manufacturer, 'samsung');
            $lg = stripos($manufacturer, 'lg');
            //$xiaomi = stripos($manufacturer, 'xiaomi');
            //$huawei = stripos($manufacturer, 'huawei');
            //$motorola = stripos($manufacturer, 'motorola');
            //$sony = stripos($manufacturer, 'sony');
            //$google = stripos($manufacturer, 'google');
            //$nokia = stripos($manufacturer, 'nokia');

            if ($apple !== false) {
                // 128 - 8 cents - carrier and warranty - he might give a discount
                $result_2 = Helpers::imeiCarrier(128, $imei);
            } elseif ($samsung !== false) {
                // 72 - 6 cents - carrier - some warranty
                // 93 - 10 cents - carrier - some warranty - usa open instead of factory unlocked
                $result_2 = Helpers::imeiCarrier(72, $imei);
            } elseif ($lg !== false) {
                // 97 - 6 cents // carrier and warranty
                $result_2 = Helpers::imeiCarrier(97, $imei);
            }

            // if ($apple !== false) {
            //     // 128 - 8 cents - carrier and warranty - he might give a discount
            //     $result_2 = Helpers::imeiCarrier(128, $imei);
            // } elseif ($samsung !== false) {
            //     // 72 - 6 cents - carrier - some warranty
            //     // 93 - 10 cents - carrier - some warranty - usa open instead of factory unlocked
            //     $result_2 = Helpers::imeiCarrier(72, $imei);
            // } elseif ($xiaomi !== false) {
            //     // 71 - 1 cent // just basic stuff
            //     // 96 - 2 cents // info - no carrier or waranty info
            //     $result_2 = Helpers::imeiCarrier(71, $imei);
            // } elseif ($huawei !== false) {
            //     // 80 - 9 cents // lots of warranty info - no carrier
            //     $result_2 = Helpers::imeiCarrier(80, $imei);
            // } elseif ($motorola !== false) {
            //     // 119 - 5 cents // warranty only
            //     $result_2 = Helpers::imeiCarrier(119, $imei);
            // } elseif ($sony !== false) {
            //     // 95 - 10 cents - warranty only
            //     $result_2 = Helpers::imeiCarrier(95, $imei);
            // } elseif ($google !== false) {
            //     // 102 - 2 cents - warranty only
            //     $result_2 = Helpers::imeiCarrier(102, $imei);
            // } elseif ($nokia !== false) {
            //     // 94 - 10 cents - warranty only
            //     $result_2 = Helpers::imeiCarrier(94, $imei);
            // } elseif ($lg !== false) {
            //     // 97 - 6 cents // carrier and warranty
            //     $result_2 = Helpers::imeiCarrier(97, $imei);
            // }

        }

        $carrier = $result_2['carrier'];
        $warranty_status = $result_2['warranty_status'];
        $warranty_start = $result_2['warranty_start'];
        $warranty_end = $result_2['warranty_end'];
        $apple_care = $result_2['apple_care'];
        $activated = $result_2['activated'];
        $repairs_service = $result_2['repairs_service'];
        $refurbished = $result_2['refurbished'];
        $all_data = $result_2['all_data'];
        $total = floatval($price) + floatval($result_2['price']);

        // create new ImeiSearch entry
        $imei_id = ImeiSearch::create([
            'user_id' => $user_id,
            'imei' => $imei,
            'model' => $model,
            'model_name' => $model_name,
            'manufacturer' => $manufacturer,
            'blacklist' => $blacklist,
            'carrier' => $carrier,
            'warranty_status' => $warranty_status,
            'warranty_start' => $warranty_start,
            'warranty_end' => $warranty_end,
            'apple_care' => $apple_care,
            'activated' => $activated,
            'repairs_service' => $repairs_service,
            'refurbished' => $refurbished,
            'price' => $total,
            'balance' => $balance,
            'all_data' => $all_data,
        ]);

        session()->flash('message', 'Entry Recorded for IMEI: ' . $imei);
        return redirect('/imeis/' . $imei_id->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ImeiSearch  $imeiSearch
     * @return \Illuminate\Http\Response
     */
    public function show(ImeiSearch $imei)
    {
        $all_data = $imei->all_data;
        $all_data = str_replace(['\\', '<strong>', '</strong>'], '', $all_data);
        //dd($all_data);
        $all_data = explode('<br>', $all_data);
        //$new_array = [];
        $new_string = null;
        foreach ($all_data as $data) {
            $one = substr($data, 0, 1);
            if ($one == '"') {
                $data = substr($data, 1);
            }
            if ($data) {
                $red = '#ef476f';
                $green = '#05cc98';
                $data = str_replace(['color: red', 'color:red'], 'color:' . $red, $data);
                $data = str_replace(['"red"'], '"' . $red . '"', $data);
                $data = str_replace(['color: green', 'color:green'], 'color:' . $green, $data);
                $data = str_replace(['"green"'], '"' . $green . '"', $data);
                $data = preg_replace('/:/', ':</span>', $data, 1);
                //$new_array[] = '<div class="imei-item"><span>' . trim($data) . '</div>';
                $new_string .= '<div class="imei-item"><span class="bold-span">' . trim($data) . '</div>';

            }
            //$new_array[] = '<div class="imei-data-item">' . trim(str_replace('"', '', $data)) . '</div>';
            //$new_array[] = '<div class="imei-data-item">' . trim($data) . '</div>';
        }
        if ($new_string) {
            //dd($new_array);
            //dd($new_string);
            //dd('yes');
            $imei->all_data = $new_string;
        }
        //dd($new_array);
        //dd($all_data);
        $user = \Auth::user();
        if (!$user->isAdminManagerEmployee() && ($user->id !== $imei->user_id)) {
            if ($site_id = $user->isMasterAgent()) {
                $role_id = Helpers::get_role_id($site_id);
                $imei_user = User::find($imei->user_id);
                if ($role_id !== $imei_user->role_id) {
                    return redirect('/');
                }
            } else {
                return redirect('/');
            }
        }
        return view('imei_search.show', compact('imei'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ImeiSearch  $imeiSearch
     * @return \Illuminate\Http\Response
     */
    public function edit(ImeiSearch $imeiSearch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ImeiSearch  $imeiSearch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImeiSearch $imeiSearch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ImeiSearch  $imeiSearch
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImeiSearch $imeiSearch)
    {
        //
    }
}
