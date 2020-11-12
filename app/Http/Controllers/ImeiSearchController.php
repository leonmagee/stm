<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\ImeiSearch;
use Illuminate\Http\Request;

class ImeiSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('imei_search.index');
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
            'carrier' => null,
            'price' => 0,
        ];
        if ($manufacturer) {

            $apple = stripos($manufacturer, 'apple');
            $samsung = stripos($manufacturer, 'samsung');
            $xiaomi = stripos($manufacturer, 'xiaomi');
            $huawei = stripos($manufacturer, 'huawei');
            $lg = stripos($manufacturer, 'lg');

            if ($apple !== false) {
                // 128 - 8 cents??? - carrier and warranty - he might give a discount
                $result_2 = Helpers::imeiCarrier(128, $imei);
            } elseif ($samsung !== false) {
                // 72 - 5 cents? -
                // 93 -
                $result_2 = Helpers::imeiCarrier(72, $imei); // maybe 93
            } elseif ($xiaomi !== false) {
                // 96 - 2 cents // info - no carrier or waranty info
                // 71 - 1 cent // just basic stuff
                //$result_2 = Helpers::imeiCarrier(96, $imei);
                $result_2 = Helpers::imeiCarrier(71, $imei);
            } elseif ($huawei !== false) {
                // 80 - 9 cents // lots of warranty info - no carrier
                $result_2 = Helpers::imeiCarrier(80, $imei); // maybe 93
            } elseif ($lg !== false) {
                // 97 - 6 cents // carrier and warranty
                $result_2 = Helpers::imeiCarrier(97, $imei); // maybe 93
            }
        }

        $user_id = \Auth::user()->id;

        $carrier = $result_2['carrier'];
        $total = floatval($price) + floatval($result_2['price']);

        // create new ImeiSearch entry
        ImeiSearch::create([
            'user_id' => $user_id,
            'imei' => $imei,
            'model' => $model,
            'model_name' => $model_name,
            'manufacturer' => $manufacturer,
            'carrier' => $carrier,
            'blacklist' => $blacklist,
            'price' => $total,
            'balance' => $balance,
        ]);

        session()->flash('message', 'Entry Recorded for IMEI: ' . $imei);
        return redirect('/imeis');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ImeiSearch  $imeiSearch
     * @return \Illuminate\Http\Response
     */
    public function show(ImeiSearch $imeiSearch)
    {
        //
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
