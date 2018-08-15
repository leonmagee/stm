<?php

namespace App\Http\Controllers;

use App\ReportType;
use App\Site;
use App\Carrier;
use App\ReportTypeSiteValue;
use Illuminate\Http\Request;

class ReportTypeController extends Controller
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
    public function index()
    {
        $report_types = ReportType::all();

        return view('report_types.index', compact('report_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sites = Site::all();

        $carriers = Carrier::all();

        return view('report_types.create', compact('sites', 'carriers'));
    }

    public function create_residual()
    {
        $sites = Site::all();

        $carriers = Carrier::all();

        return view('report_types.create_residual', compact('sites', 'carriers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'carrier' => 'required',
        ]);

        $report_type = ReportType::create([
            'name' => $request->name,
            'spiff' => 1,
            'carrier_id' => $request->carrier,
        ]);

        $sites = Site::all();

        foreach( $sites as $site ) {
            $spiff_key = 'spiff_' . $site->id;
            ReportTypeSiteValue::create([
                'site_id' => $site->id,
                'report_type_id' => $report_type->id,
                'spiff_value' => $request->{$spiff_key},
            ]);
        }

        return redirect('report-types/' . $report_type->id);
    }

    public function store_residual(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'carrier' => 'required',
        ]);

        $report_type = ReportType::create([
            'name' => $request->name,
            'spiff' => 0,
            'carrier_id' => $request->carrier,
        ]);

        $sites = Site::all();

        foreach( $sites as $site ) {
            $residual_key = 'residual_' . $site->id;
            ReportTypeSiteValue::create([
                'site_id' => $site->id,
                'report_type_id' => $report_type->id,
                'residual_percent' => $request->{$residual_key}
            ]);
        }

        return redirect('report-types/' . $report_type->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReportType  $reportType
     * @return \Illuminate\Http\Response
     * @todo I should probably have a different method if this is a spiff or a residual... 
     */
    public function show(ReportType $reportType)
    {
        $sites = Site::all();

        if ( $reportType->spiff ) {

            return $this->show_spiff($reportType, $sites);

        } else {

            return $this->show_residual($reportType, $sites);
        }


    }

    public function show_spiff($reportType, $sites) {

        $site_values_array = array();

        foreach( $sites as $site ) {

            $value = ReportTypeSiteValue::where(
                [
                    'site_id' => $site->id,
                    'report_type_id' => $reportType->id
                ]
            )->first();

            if ( $value ) {
                if ( $value->spiff_value ) {
                    $spiff_value = '$' . number_format($value->spiff_value, 2);
                } else {
                    $spiff_value = 'Default';
                }
            } else {
                $spiff_value = 'Default';
            }

            $site_values_array[$site->name] = $spiff_value;
        }

        return view('report_types.show', compact('reportType', 'site_values_array'));
    }

    public function show_residual(ReportType $reportType, $sites) {
        $site_values_array = array();

        foreach( $sites as $site ) {

            $value = ReportTypeSiteValue::where(
                [
                    'site_id' => $site->id,
                    'report_type_id' => $reportType->id
                ]
            )->first();

            if ( $value ) {
                if ( $value->residual_percent ) {
                    $residual_percent = $value->residual_percent . '%';
                } else {
                    $residual_percent = 'Default';
                }
            } else {
                $residual_percent = 'Default';
            }

            $site_values_array[$site->name] = $residual_percent;
        }

        return view('report_types.show', compact('reportType', 'site_values_array'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReportType  $reportType
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportType $reportType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReportType  $reportType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReportType $reportType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReportType  $reportType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportType $reportType)
    {

        $reportType->delete();

        session()->flash('message', 'Report Type ' . $reportType->carrier->name . ' ' . $reportType->name . ' has been deleted.');

        return redirect('report-types');

        //$item = Item::findOrFail($id);
        //$item->delete();
    }
}
