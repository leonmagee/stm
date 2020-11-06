<?php

namespace App\Http\Controllers;

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

        $service = 134; // Custom Service - All Models Phone Details and Blacklist
        //$service = 72; // Samsung info
        //$service = 62; // Apple info
        $imei = $request->imei;

        //$imei = '351675643014677';
        //$imei = '353331072816483'; // apple
        //$imei = '354641090780928'; // blacklisted samsung
        //$imei = '351675643014677'; // my samsung galaxy s20 fe
        //$imei = '353331072816555'; // null

        $key = env('IMEI_KEY');
        //dd($key);
        $url = 'https://api.imeicheck.com/api/v1/services/order/create?serviceid=' . $service . '&key=' . $key . '&imei=' . $imei;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        $json = curl_exec($curl);
        $curl_result = json_decode($json);
        curl_close($curl);
        $status = $curl_result->status;
        if ($status == 'failed') {
            //dd($curl_result);
            session()->flash('danger', 'IMEI Number Not Found.');
            return redirect()->back();
        }
        //dd($curl_result);
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
            $blacklist = nulll;
        }

        $pattern = '|Model: ([^<]+)<br>|';
        $matches = [];
        preg_match($pattern, $result, $matches);
        if (isset($matches[1])) {
            $model = $matches[1];
        } else {
            $model = nulll;
        }

        $pattern = '|Model Name: ([^<]+)<br>|';
        $matches = [];
        preg_match($pattern, $result, $matches);
        if (isset($matches[1])) {
            $model_name = $matches[1];
        } else {
            $model_name = nulll;
        }

        $pattern = '|Manufacturer: ([^<]+)<br>|';
        $matches = [];
        preg_match($pattern, $result, $matches);
        if (isset($matches[1])) {
            $manufacturer = $matches[1];
        } else {
            $manufacturer = nulll;
        }

        // $pattern = '|Carrier: ([^<]+)<br>|';
        // $matches = [];
        // preg_match($pattern, $result2, $matches);
        // if (isset($matches[1])) {
        //     $carrier = $matches[1];
        // } else {
        //     $carrier = nulll;
        // }
        $carrier = null;

        $user_id = \Auth::user()->id;

        // create new ImeiSearch entry
        ImeiSearch::create([
            'user_id' => $user_id,
            'imei' => $imei,
            'model' => $model,
            'model_name' => $model_name,
            'manufacturer' => $manufacturer,
            'carrier' => $carrier,
            'blacklist' => $blacklist,
            'price' => $price,
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
