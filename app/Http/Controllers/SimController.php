<?php

namespace App\Http\Controllers;

use App\User;
use App\SimMaster;
use App\Sim;
use App\SimResidual;
use App\SimUser;
use App\ReportType;
use App\Carrier;
use App\Settings;
use App\Helpers;
use Illuminate\Http\Request;

class SimController extends Controller
{
    private $duplicate_sims;
    private $number_sims_uploaded;

    public function __construct() {
        $this->middleware('auth');
        ini_set('max_execution_time', '300');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
        * @todo current_site_data should comd from a provider???
        */
        $current_date = Settings::first()->current_date;
        //$sims = Sim::where('upload_date', $current_date)->latest()->get();

        $current_site_date = Helpers::current_date_name();

        //return view('sims.index', compact('sims', 'current_site_date'));
        return view('sims.index', compact('current_site_date'));
    }

    public function archive($id) {
        $current_date = Settings::first()->current_date;
        $report_type = ReportType::find($id);
        $spiff_or_resid = $report_type->spiff;


        $name = $report_type->carrier->name . ' ' . $report_type->name;


        if ( $spiff_or_resid ) {
            $sims = Sim::where(['report_type_id' => $id, 'upload_date' => $current_date])->get();
        } else {
            $sims = SimResidual::where(['report_type_id' => $id, 'upload_date' => $current_date])->get();
        }

        $current_site_date = Helpers::current_date_name();

        return view('sims.archive', compact('sims', 'name', 'current_site_date'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addSim() {
        $report_types = ReportType::all();
        return view('sims.add-sim', compact('report_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd('the method create is called');
    }

    /**
    * Show the upload form
    */
    public function upload_form()
    {
        $report_types = ReportType::all();
        $carriers = Carrier::all();
        $users = User::where('role', session('current_site_id', 1))->get();
        return view('sims.upload', compact('report_types', 'users', 'carriers'));
    }

    /**
    * Process the upload for monthly sims
    */
    // public function upload_old(Request $request)
    // {

    //     $spiff_or_resid = ReportType::find($request->report_type)->spiff;

    //     $current_date = Settings::first()->current_date;

    //     $upload = $request->file('upload-file');
        
    //     $filePath = $upload->getRealPath();
        
    //     $file = fopen($filePath, 'r');

    //     $header = fgetcsv($file); // this gets the first row:
    //     // array:4 [
    //     //   0 => "sim"
    //     //   1 => "plan"
    //     //   2 => "active_dt"
    //     //   3 => "mdn"
    //     // ]

        
    //     $header[] = 'report_type_id';

    //     //dd($header);

    //     $data_array = [];

    //     /**
    //     * this part actually happens really fast... so I could probably do a bult insert?
    //     * not sure what part is the really time consuming step?
    //     */
    //     while( $row = fgetcsv($file)) {

    //         if ( $row[0] == '') {
    //             continue;
    //         }

    //         /**
    //         * @todo this will always be the same so it's not necessary here. 
    //         */
    //         $row[] = $request->report_type; // adding report type id
            
    //         /**
    //         * @todo test this with a large file by setting headers, not changing column order
    //         * @todo how to get feedback when duplicate sims are uploaded
    //         * @todo I can also see how this works on the live site when I increase the instance
    //         * size or change config settings to allow for more time?
    //         * @todo this times out with the residual file even without the extra data?
    //         */

    //         $data_array[] = array_combine($header, $row);
    //     }

    //     //dd($data_array);
    //     // maybe make sure this array is uniqe for sim number?
    //     // I could remove duplicates while creating array?

    //     // DB::table('users')->insert([
    //     //     ['email' => 'taylor@example.com', 'votes' => 0],
    //     //     ['email' => 'dayle@example.com', 'votes' => 0]
    //     // ]);

    //     \DB::table('sims')->insert($data_array);



    //     $sim_number_array = array();

    //     foreach( $data_array as $data ) {
    //         /**
    //         * @todo how to handle Duplicate entry 
    //         * I can make an array of sim values as I loop through this and then log that some 
    //         * sims were uploaded twice... but this won't check to see if those sims already 
    //         * exist in the system... so I need to fall back to a secondary check. 
    //         * so maybe I can use Laravels error handler here so that the form still submits
    //         * but it also outpus an error that will be referenced by the form. 
    //         * maybe I should disable the browser validation for forms so I will see the actual
    //         * laravel notifications better..
    //         */

    //         // the following just makes sure there are not duplicate sims in the same file

    //         if ( ! in_array($data['sim'],$sim_number_array )) {

    //             if ( $spiff_or_resid ) {
                    
    //                 Sim::create(array(
    //                     'sim_number' => $data['sim'],
    //                     'value' => $data['plan'], 
    //                     'activation_date' => $data['active_dt'],
    //                     'mobile_number' => $data['mdn'], 
    //                     'report_type_id' => $data['report_type_id'],
    //                     'upload_date' => $current_date
    //                 ));

    //             } else {

    //                 SimResidual::create(array(
    //                     'sim_number' => $data['sim'],
    //                     'value' => $data['plan'], 
    //                     'activation_date' => $data['active_dt'],
    //                     'mobile_number' => $data['mdn'], 
    //                     'report_type_id' => $data['report_type_id'],
    //                     'upload_date' => $current_date
    //                 ));
    //             }

    //         }

    //         $sim_number_array[] = $data['sim'];
    //     }

    //     return redirect('/sims');
    // }

     /**
    * Process the upload for monthly sims
    */
    // public function upload_newish(Request $request)
    // {

    //     $spiff_or_resid = ReportType::find($request->report_type)->spiff;

    //     $current_date = Settings::first()->current_date;

    //     $upload = $request->file('upload-file');
        
    //     $filePath = $upload->getRealPath();
        
    //     $file = fopen($filePath, 'r');

    //     $header = fgetcsv($file); // this gets the first row: // just remove this somehow?
    //     // array:4 [
    //     //   0 => "sim"
    //     //   1 => "plan"
    //     //   2 => "active_dt"
    //     //   3 => "mdn"
    //     // ]

        
    //     //$header[] = 'report_type_id';

    //     $header = [
    //         'sim_number',
    //         'value',
    //         'activation_date',
    //         'mobile_number',
    //         'report_type_id',
    //         'upload_date'
    //     ];

    //     // 'sim_number' => $data['sim'],
    //     // 'value' => $data['plan'], 
    //     // 'activation_date' => $data['active_dt'],
    //     // 'mobile_number' => $data['mdn'], 
    //     // 'report_type_id' => $data['report_type_id'],
    //     // 'upload_date' => $current_date

    //     //dd($header);

    //     $data_array = [];

    //     /**
    //     * this part actually happens really fast... so I could probably do a bult insert?
    //     * not sure what part is the really time consuming step?
    //     */

    //     $sim_number_array = [];

    //     while( $row = fgetcsv($file)) {

    //         if ( $row[0] == '') {
    //             continue;
    //         }

    //         if ( ! in_array($row[0],$sim_number_array )) {

    //             /**
    //             * @todo this will always be the same so it's not necessary here. 
    //             */
    //             $row[] = $request->report_type; // adding report type id
    //             $row[] = $current_date;
                
    //             /**
    //             * @todo test this with a large file by setting headers, not changing column order
    //             * @todo how to get feedback when duplicate sims are uploaded
    //             * @todo I can also see how this works on the live site when I increase the instance
    //             * size or change config settings to allow for more time?
    //             * @todo this times out with the residual file even without the extra data?
    //             */

    //             $data_array[] = array_combine($header, $row);
    //             $sim_number_array[] = $row[0];
    //         }
    //     }

    //     //dd($data_array);
    //     // maybe make sure this array is uniqe for sim number?
    //     // I could remove duplicates while creating array?

    //     // DB::table('users')->insert([
    //     //     ['email' => 'taylor@example.com', 'votes' => 0],
    //     //     ['email' => 'dayle@example.com', 'votes' => 0]
    //     // ]);



    //     if ( $spiff_or_resid ) {

    //         \DB::table('sims')->insert($data_array);

    //     } else {
           
    //         \DB::table('sim_residuals')->insert($data_array);

    //     }



    //     // $sim_number_array = array();

    //     // foreach( $data_array as $data ) {
    //     //     /**
    //     //     * @todo how to handle Duplicate entry 
    //     //     * I can make an array of sim values as I loop through this and then log that some 
    //     //     * sims were uploaded twice... but this won't check to see if those sims already 
    //     //     * exist in the system... so I need to fall back to a secondary check. 
    //     //     * so maybe I can use Laravels error handler here so that the form still submits
    //     //     * but it also outpus an error that will be referenced by the form. 
    //     //     * maybe I should disable the browser validation for forms so I will see the actual
    //     //     * laravel notifications better..
    //     //     */

    //     //     // the following just makes sure there are not duplicate sims in the same file

    //     //     if ( ! in_array($data['sim'],$sim_number_array )) {

    //     //         if ( $spiff_or_resid ) {
                    
    //     //             Sim::create(array(
    //     //                 'sim_number' => $data['sim'],
    //     //                 'value' => $data['plan'], 
    //     //                 'activation_date' => $data['active_dt'],
    //     //                 'mobile_number' => $data['mdn'], 
    //     //                 'report_type_id' => $data['report_type_id'],
    //     //                 'upload_date' => $current_date
    //     //             ));

    //     //         } else {

    //     //             SimResidual::create(array(
    //     //                 'sim_number' => $data['sim'],
    //     //                 'value' => $data['plan'], 
    //     //                 'activation_date' => $data['active_dt'],
    //     //                 'mobile_number' => $data['mdn'], 
    //     //                 'report_type_id' => $data['report_type_id'],
    //     //                 'upload_date' => $current_date
    //     //             ));
    //     //         }

    //     //     }

    //     //     $sim_number_array[] = $data['sim'];
    //     // }

    //     return redirect('/sims');
    // }


     /**
    * Process the upload for monthly sims
    *
    * @todo I might still want to do this based on the header column names...
    * but I should get the timeout issue wit the residual worked out first. After that is done
    * and I have something that acutually works I can try getting it to work with the column 
    * titles instead of just the row position.
    */
    public function upload(Request $request)
    {

        $spiff_or_resid = ReportType::find($request->report_type)->spiff;

        $current_date = Settings::first()->current_date;

        $upload = $request->file('upload-file');
        
        $filePath = $upload->getRealPath();
        
        $file = fopen($filePath, 'r');

        $data_array = [];

        $report_type_id = $request->report_type;

        if ( $spiff_or_resid ) {

            $sims = new Sim();

        } else {

            $sims = new SimResidual();
        }
            
        $this->handle_upload($sims, $file, $report_type_id, $current_date);

        if ($num = $this->number_sims_uploaded) {
            session()->flash('message', $num . ' Sims successfully uploaded.');
        }
        
        if (count($this->duplicate_sims)) {
            session()->flash('duplicates', $this->duplicate_sims);
        }

        return redirect('/sims/upload');
    }


    public function handle_upload(SimMaster $sims, $file, $report_type_id, $current_date) {

        $sim_number_array = [];
        $duplicate_sims = [];
        $count = 0;

        while( $row = fgetcsv($file)) {

            if ( $row[0] == '' || ! is_numeric($row[0])) {
                continue;
            }

            if ( ! in_array($row[0],$sim_number_array )) {
             
                try {

                $sims->create(array(
                    'sim_number' => $row[0],
                    'value' => $row[1], 
                    'activation_date' => $row[2],
                    'mobile_number' => $row[3], 
                    'report_type_id' => $report_type_id,
                    'upload_date' => $current_date
                ));

                $count++;

                } catch(\Illuminate\Database\QueryException $e) {
                    $errorCode = $e->errorInfo[1];
                    if($errorCode == '1062'){
                        $duplicate_sims[] = $row[0];
                        continue;
                    }
                }

                $sim_number_array[] = $row[0];
            }
        }

        //$this->sim_number_array = $sim_number_array;
        $this->number_sims_uploaded = $count;
        $this->duplicate_sims = $duplicate_sims;
    }


    /**
    * Process the upload for monthly sims
    */
    public function upload_single(Request $request)
    {

        $user_id = $request->user_id;
        
        $carrier_id = $request->carrier_id;

        $upload = $request->file('upload-file-single');
        
        $filePath = $upload->getRealPath();
        
        $file = fopen($filePath, 'r');

        $data_array = [];

        while( $row = fgetcsv($file)) {

            if ( ! is_numeric($row[0]) ) {
                continue;
            }

            $data_array[] = $row[0];
        }

        array_unique($data_array);

        foreach( $data_array as $data ) {

            SimUser::create(array(
                'sim_number' => $data,
                'user_id' => $user_id,
                'carrier_id' => $carrier_id
            ));
        }

        return redirect('/sim_users');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //dd(request()->all());
        //dd(request('sim_number'));

        // $sim = new Sim;
        // $sim->sim_number = request('sim_number');
        // $sim->value = request('value');
        // $sim->activation_date = request('activation_date');
        // $sim->mobile_number = request('mobile_number');
        // $sim->carrier = request('carrier');
        // $sim->save();

        // Sim::create([
        //     'sim_number' => request('sim_number'),
        //     'value' => request('value'),
        //     'activation_date' => request('activation_date'),
        //     'mobile_number' => request('mobile_number'),
        //     'carrier' => request('carrier')
        // ]);

        $current_date = Settings::first()->current_date;

        $this->validate(request(), [
            'sim_number' => 'required|min:9',
            'value' => 'required',
            'activation_date' => 'required',
            'mobile_number' => 'required',
            'report_type_id' => 'required',
        ]);

        Sim::create([
            'sim_number' => $request->sim_number,
            'value' => $request->value,
            'activation_date' => $request->activation_date,
            'mobile_number' => $request->mobile_number,
            'report_type_id' => $request->report_type_id,
            'upload_date' => Settings::first()->current_date
        ]);

        // Sim::create(request([
        //     'sim_number', 
        //     'value', 
        //     'activation_date', 
        //     'mobile_number', 
        //     'report_type_id',
        //     //'upload_date' => Settings::first()->current_date
        //     'upload_date' => '6_2018'
        // ]));

        return redirect('/sims');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sim  $sim
     * @return \Illuminate\Http\Response
     * 
     * @todo this isn't working now because there is no longer an ID specific for one sim, so I would need to query by the sim number and date? Not sure how this will work for deleting sims... 
     */
    public function show($sim_number)
    {
        $sim = Sim::where('sim_number', $sim_number)->first();
        $sim_user = SimUser::where('sim_number', $sim_number)->first();
        return view('sims.show', compact('sim', 'sim_user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sim  $sim
     * @return \Illuminate\Http\Response
     */
    public function edit(Sim $sim)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sim  $sim
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sim $sim)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sim  $sim
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sim $sim)
    {
        //
    }
}
