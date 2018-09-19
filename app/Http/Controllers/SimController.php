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

    public function __construct() 
    {
        $this->middleware('auth');
        ini_set('max_execution_time', '300');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @todo not using this for now - not really necessary
     */
    // public function index(Request $request)
    // {
    //     $current_site_date = Helpers::current_date_name();

    //     return view('sims.index', compact('current_site_date'));
    // }

    public function archive($id) {

        $report_type = ReportType::find($id);

        $name = $report_type->carrier->name . ' ' . $report_type->name;

        $current_site_date = Helpers::current_date_name();

        return view('sims.archive', compact('id', 'name', 'current_site_date'));
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
    *
    * @todo I might still want to do this based on the header column names...
    * but I should get the timeout issue wit the residual worked out first. After that is done
    * and I have something that acutually works I can try getting it to work with the column 
    * titles instead of just the row position.
    */
    public function upload(Request $request)
    {
        /**
        * @todo try using League CSV for this?
        */

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

            // if ( $row[0] == '' || ! is_numeric($row[0])) {
            //     continue;
            // }

            if ( ( ! in_array($row[0],$sim_number_array ) ) && (Helpers::verify_sim($row[0]))) {
             
                try { // use verify_sim here as well? test with bad data... 

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
    * @todo refactor this so it works for both the text or file upload
    */
    public function upload_single(Request $request)
    {
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

        return $this->complete_single_upload($data_array, $request);
    }


    /**
    * Process the upload for monthly sims
    * @todo refactor this so it works for both the text or file upload
    */
    public function upload_single_paste(Request $request)
    {

        /** get data **/

        $data = $request->sims_paste;

        $exploded = explode("\r\n", $data);

        $data_array = [];

        foreach( $exploded as $item ) {

            // strip out anything obviously not a sim number?
            // create a function to use anywhere to test_sim()
            // and then apply that to make sure it's not 'sim' or 
            // something else that is being uploaded..
            // also, I need to test this with different browsers
            // I can always look at the older code I used.. 

            $data_array[] = $item;
        }

        return $this->complete_single_upload($data_array, $request);
    }


    public function complete_single_upload($data_array, Request $request) {

        array_unique($data_array);

        $duplicate_sims = [];
        $count = 0;

        $user_id = $request->user_id;
        
        $carrier_id = $request->carrier_id;

        foreach( $data_array as $data ) {

            if ( Helpers::verify_sim($data) ) {

                try {

                    SimUser::create(array(
                        'sim_number' => $data,
                        'user_id' => $user_id,
                        'carrier_id' => $carrier_id
                    ));

                    $count++;

                } catch(\Illuminate\Database\QueryException $e) {
                    $errorCode = $e->errorInfo[1];
                    if($errorCode == '1062'){
                        $duplicate_sims[] = $data;
                        continue;
                    }
                }

            }

        }

        $this->number_sims_uploaded = $count;
        $this->duplicate_sims = $duplicate_sims;

        if ($num = $this->number_sims_uploaded) {
            session()->flash('message', $num . ' Sims successfully uploaded.');
        }
        
        if (count($this->duplicate_sims)) {
            session()->flash('duplicates', $this->duplicate_sims);
        }

        return redirect('/user-sims');

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
