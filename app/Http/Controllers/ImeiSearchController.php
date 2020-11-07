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

        // $apple_response = 'Model: iPhone 6s Plus 64GB Gold<br>IMEI: 353331072816483<br> Serial Number: F2LQT415GRX2<br>Carrier: Unlocked<br>SIMLock Status: <font color="green">Unlocked.</font> <br>GSMA Blacklist Status:<font  color="green"> <strong>Clean</strong></font> <br> Activated: <span style="color: green">Yes</span><br>Estimated Purchase Date: 2016-01-21<br>Valid Purchase Date: <span style="color: green">Yes</span><br>Repairs & Service Coverage: <span style="color:red">Expired</span><br>Days Remaining: 0<br>Telephone Technical Support: <span style="color:red">Expired</span><br>AppleCare: <span style="color: red">No</span><br>Refurbished: <span style="color: green">No</span><br>Replaced: <span style="color: green">No</span><br>Loaner: <span style="color: green">No</span><br>';

        // $apple_warranty = 'Model: iPhone 6s Plus 64GB Gold<br>IMEI: 353331072816483<br>Serial Number: ********GRX2<br>Activated: <span style="color: green">Yes</span><br>Estimated Purchase Date: 2016-01-21<br>Valid Purchase Date: <span style="color: green">Yes</span><br>Repairs & Service Coverage: <span style="color:red">Expired</span><br>Days Remaining: 0<br>Telephone Technical Support: <span style="color:red">Expired</span><br>AppleCare: <span style="color: red">No</span><br>Refurbished: <span style="color: green">No</span><br>Replaced: <span style="color: green">No</span><br>Loaner: <span style="color: green">No</span><br>';

        //$service = 134; // Custom Service - All Models Phone Details and Blacklist
        //$service = 72; // Samsung info/carrier
        //$service = 62; // Apple info/carrier
        //$service = 66; // Apple Warranty
        $imei = $request->imei;

        // $key = env('IMEI_KEY');
        // $url = 'https://api.imeicheck.com/api/v1/services/order/create?serviceid=' . $service . '&key=' . $key . '&imei=' . $imei;
        // $curl = curl_init($url);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        // curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        // $json = curl_exec($curl);
        // $curl_result = json_decode($json);
        // curl_close($curl);

        // service - 134 - all model general check with blacklist info
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

        $pattern = '|Model: ([^<]+)<br>|';
        $matches = [];
        preg_match($pattern, $result, $matches);
        if (isset($matches[1])) {
            $model = $matches[1];
        } else {
            $model = null;
        }

        $pattern = '|Model Name: ([^<]+)<br>|';
        $matches = [];
        preg_match($pattern, $result, $matches);
        if (isset($matches[1])) {
            $model_name = $matches[1];
        } else {
            $model_name = null;
        }

        $pattern = '|Manufacturer: ([^<]+)<br>|';
        $matches = [];
        preg_match($pattern, $result, $matches);
        if (isset($matches[1])) {
            $manufacturer = $matches[1];
        } else {
            $manufacturer = null;
        }

        $carrier = null;

        $result2 = false;
        if ($manufacturer) {
            // second api request for different manufacturers
            $apple = stripos($manufacturer, 'apple');
            if ($apple !== false) {
                // service - 62 - apple info/carrier
                $curl_new = Helpers::checkImei($imei, 62);
                //dd($curl_new);
                if ($curl_new) {
                    $status = $curl_new->status;
                    if ($status !== 'failed') {
                        $result2 = $curl_new->result;
                    }
                }
            }

            // get carrier from result
            if ($result2) {
                $pattern = '|Carrier: ([^<]+)<br>|';
                $matches = [];
                preg_match($pattern, $result2, $matches);
                if (isset($matches[1])) {
                    $carrier = $matches[1];
                } else {
                    $carrier = null;
                }

            }
        }

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
