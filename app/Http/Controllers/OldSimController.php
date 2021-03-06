<?php

namespace App\Http\Controllers;

use App\Sim;
use App\ReportType;
use Illuminate\Http\Request;

class OldSimController extends Controller
{
    /**
    * Only Logged In Users can see this
    **/
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        /**
        * Query sims by month?
        **/
        // $archives = Sim::selectRaw('year(created_at) year, monthname(created_at) month, count(*) published')->groupBy('year', 'month')->orderByRaw('min(created_at)')->get()->toArray();

        // return $archives;

        //return Post::latest()->get();
        // $posts = Post::latest()->get();
        // $cats = Category::latest()->get();
        // //return $posts; //output json for api
        // return view('posts.index', compact('posts', 'cats'));
        //$sims = \DB::table('sims')->get(); // query builder
        //$sims = Sim::oldest()->get();
        //$sims = Sim::all();
        // how to add session variables?
        //dd($request);
        //dd($request->session());
        $sims = Sim::latest()->get();
        //return $sims;
        //dd($sims);
        // foreach( $sims as $sim ) {
        //     dd($sim->report_type->name);
        // }
        //return $sims;
        return view('sims.index', compact('sims'));
    }

    public function archive($id) {
        $report_type = ReportType::find($id);
        $name = $report_type->carrier->name . ' ' . $report_type->name;
        $sims = Sim::where('report_type_id', $id)->get();
        return view('sims.archive', compact('sims', 'name'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addSim() {
        $report_types = ReportType::query()->orderBy('order_index')->get();
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
        return view('sims.upload');
    }

    /**
    * Process the upload
    */
    public function upload(Request $request)
    {

        /**
        * Right now I'm able to upload a file without re-arranging the columns and just by naming the column headers... this is easier but it could also make things more difficult if the total file size winds up being a lot bigger, and maybe php needs to read all of the columns? It might be necessary to still process the files... and then it might actually be more difficult if I rely on having to name the columns - but I could do that instead of re-arranging things - just name and then delete instead of dragging to reorder?
        */

        //dd($request->file('upload-file'));
        //$request->file
        // get file
        $upload = $request->file('upload-file');
        $filePath = $upload->getRealPath();
        // open and read
        $file = fopen($filePath, 'r');

        /**
        * Get header row - this will remove the first row (like array_shift).
        * So if I'm not validating I need to ensure that the first row actually has
        * specific headers...
        */
        $header = fgetcsv($file);
        //dd($file, $header);

        // then loop through this data
        // validate
        //  $new_header = [];
        // foreach( $header as $key => $value ) {
        //     //var_dump($value);
        //     $lheader = strtolower($value); // not necessary here
        //     $escaped_items = preg_replace('/[^a-z]/','',$lheader);
        //     $new_header[] = $escaped_items;
        // }
        // add header for report type id
        $header[] = 'report_type_id';
        //dd($new_header);

        $data_array = [];
        while( $row = fgetcsv($file)) {
            if ( $row[0] == '') {
                continue;
            }

            $row[] = 2; // adding report type id
            // this should come from a select field when you upload.
            /**
            * @todo test this with a large file by setting headers, not changing column order
            * @todo how to get feedback when duplicate sims are uploaded
            */
            // foreach( $row as $key => $value ) {
            //     echo $value . ' - ';
            // }
            //echo "<br />";
            $data_array[] = array_combine($header, $row);
        }
        //dd($data_array);


        // I should try tp use the validation feature here, but it might be hard going through
        // a loop, and when it fails will it stop the upload entirely? Maybe it should
        // validate the data first before attempting the upload?
        //
        // $this->validate($data_array, [
        //     'sim_number' => 'required|min:13',
        //     'value' => 'required',
        //     'activation_date' => 'required',
        //     'mobile_number' => 'required',
        //     'report_type_id' => 'required',
        // ]);

        /**
        * @todo csv header keys should be prefixed with 'stm_' to avoid an conflicts
        */

        $sim_number_array = array();

        foreach( $data_array as $data ) {
            /**
            * @todo how to handle Duplicate entry
            * I can make an array of sim values as I loop through this and then log that some
            * sims were uploaded twice... but this won't check to see if those sims already
            * exist in the system... so I need to fall back to a secondary check.
            */

            if ( ! in_array($data['sim_number'],$sim_number_array )) {

                Sim::create(array(
                    'sim_number' => $data['sim_number'],
                    'value' => $data['value'],
                    'activation_date' => $data['activation_date'],
                    'mobile_number' => $data['mobile_number'],
                    'report_type_id' => $data['report_type_id']
                ));
            }

            $sim_number_array[] = $data['sim_number'];

        }

        // foreach( $data_array as $data ) {
        //     Sim::create(array(
        //     'sim_number',
        //     'value',
        //     'activation_date',
        //     'mobile_number',
        //     'report_type_id',
        // ));
        // }


        return redirect('/sims');
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

        $this->validate(request(), [
            'sim_number' => 'required|min:13',
            'value' => 'required',
            'activation_date' => 'required',
            'mobile_number' => 'required',
            'report_type_id' => 'required',
        ]);

        Sim::create(request([
            'sim_number',
            'value',
            'activation_date',
            'mobile_number',
            'report_type_id'
        ]));

        return redirect('/sims');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sim  $sim
     * @return \Illuminate\Http\Response
     */
    public function show(Sim $sim)
    {
        return view('sims.show', compact('sim'));
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
