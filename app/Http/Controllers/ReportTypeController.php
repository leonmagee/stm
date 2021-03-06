<?php

namespace App\Http\Controllers;

use App\Carrier;
use App\ReportType;
use App\ReportTypeSiteDefault;
use App\ReportTypeSiteValue;
use App\Site;
//use App\Helpers;
use Illuminate\Http\Request;

class ReportTypeController extends Controller
{

    /**
     * Only Logged In Users can see this
     **/
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
        $report_types = ReportType::query()->orderBy('order_index')->get();

        return view('report_types.index', compact('report_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$sites = Site::all();
        $sites = Site::whereNotIn('id', [4])->get();

        $carriers = Carrier::all();

        return view('report_types.create', compact('sites', 'carriers'));
    }

    public function create_residual()
    {
        //$sites = Site::all();
        $sites = Site::whereNotIn('id', [4])->get();

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

        //$sites = Site::all();
        $sites = Site::whereNotIn('id', [4])->get();

        foreach ($sites as $site) {
            $spiff_key = 'spiff_' . $site->id;
            ReportTypeSiteDefault::create([
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

        //$sites = Site::all();
        $sites = Site::whereNotIn('id', [4])->get();

        foreach ($sites as $site) {
            $residual_key = 'residual_' . $site->id;
            ReportTypeSiteDefault::create([
                'site_id' => $site->id,
                'report_type_id' => $report_type->id,
                'residual_percent' => $request->{$residual_key},
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

        $user = \Auth::user();
        if (!$user->isAdmin()) {
            return redirect('/');
        }

        //return Helpers::admin_lock();

        //$sites = Site::all();
        $sites = Site::whereNotIn('id', [4])->get();

        if ($reportType->spiff) {

            return $this->show_spiff($reportType, $sites);

        } else {

            return $this->show_residual($reportType, $sites);
        }

    }

    public function show_spiff($reportType, $sites)
    {

        $site_values_array = array();

        /**
         * @todo conver part of this to be another class...
         */

        $site_values_array = [];

        foreach ($sites as $site) {

            $value = ReportTypeSiteDefault::where(
                [
                    'site_id' => $site->id,
                    'report_type_id' => $reportType->id,
                ]
            )->first();

            if (!$value) {
                $value = new ReportTypeSiteDefault();
                $value->site_id = $site->id;
                $value->report_type_id = $reportType->id;
                $value->spiff_value = 0;
                $value->residual_percent = null;
                $value->save();
            }

            /**
             * @todo In the case of no value, this should list the site default instead?
             * @todo here we should get the current site defalt and display it with like ($0 (default))
             */

            $default_spiff_string = '$' . $site->default_spiff_amount . ' <span>(Site Default)</span>';

            if ($value) {
                if ($value->spiff_value !== null) {
                    $spiff_value = '$' . $value->spiff_value;
                } else {
                    $spiff_value = $default_spiff_string;
                }

                $plan_payments = ReportTypeSiteValue::where(
                    'report_type_site_defaults_id', $value->id
                )->orderBy('plan_value')->get();

                $site_values_array[] = [
                    'id' => $value->id,
                    'value' => $spiff_value,
                    'name' => $site->name,
                    'plans' => $plan_payments,
                ];

            } else {
                $spiff_value = $default_spiff_string;
            }

        }

        return view('report_types.show', compact('reportType', 'site_values_array'));
    }

    public function show_residual(ReportType $reportType, $sites)
    {

        $site_values_array = [];

        foreach ($sites as $site) {

            $value = ReportTypeSiteDefault::where(
                [
                    'site_id' => $site->id,
                    'report_type_id' => $reportType->id,
                ]
            )->first();

            if (!$value) {
                $value = new ReportTypeSiteDefault();
                $value->site_id = $site->id;
                $value->report_type_id = $reportType->id;
                $value->spiff_value = null;
                $value->residual_percent = 0;
                $value->save();
            }

            $default_residual_string = $site->default_residual_percent . '% <span>(Site Default)</span>';

            if ($value) {
                if ($value->residual_percent) {
                    $residual_percent = $value->residual_percent . '%';
                } else {
                    $residual_percent = $default_residual_string;
                }

                $site_values_array[] = [
                    'id' => $value->id,
                    'value' => $residual_percent,
                    'name' => $site->name,
                    'plans' => [],
                ];

            } else {
                $residual_percent = $default_residual_string;
            }

        }

        return view('report_types.show', compact('reportType', 'site_values_array'));
    }

    public function add_plan_value(Request $request, ReportType $reportType)
    {

        $this->validate(request(), [
            'plan_value' => 'required',
            'payment_amount' => 'required',
        ]);

        $current = ReportTypeSiteValue::where([
            'plan_value' => $request->plan_value,
            'report_type_site_defaults_id' => $request->plan_value_id])->get();

        if (!count($current)) {
            ReportTypeSiteValue::create([
                'plan_value' => $request->plan_value,
                'payment_amount' => $request->payment_amount,
                'report_type_site_defaults_id' => $request->plan_value_id,
            ]);
        }
        return redirect('report-types/' . $reportType->id);

    }

    public function remove_plan_value(Request $request, ReportType $reportType)
    {

        $toDelete = ReportTypeSiteValue::find($request->report_plan_id);

        $toDelete->delete();

        return redirect('report-types/' . $reportType->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReportType  $reportType
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportType $reportType)
    {
        $carriers = Carrier::all();
        //$sites = Site::all();
        $sites = Site::whereNotIn('id', [4])->get();
        return view('report_types.edit', compact('reportType', 'carriers', 'sites'));
    }

    public function edit_residual(ReportType $reportType)
    {
        $carriers = Carrier::all();
        //$sites = Site::all();
        $sites = Site::whereNotIn('id', [4])->get();
        return view('report_types.edit_residual', compact('reportType', 'carriers', 'sites'));
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
        $this->validate(request(), [
            'name' => 'required',
            'carrier' => 'required',
        ]);

        $reportType->update([
            'name' => $request->name,
            'carrier_id' => $request->carrier,
        ]);

//        $sites = Site::all();
        $sites = Site::whereNotIn('id', [4])->get();

        foreach ($sites as $site) {

            $spiff_key = 'spiff_' . $site->id;

            $row = ReportTypeSiteDefault::where([
                'site_id' => $site->id,
                'report_type_id' => $reportType->id,
            ])->first();

            if ($row) {

                $row->spiff_value = $request->{$spiff_key};

                $row->save();

            } else {

                ReportTypeSiteDefault::create([
                    'site_id' => $site->id,
                    'report_type_id' => $reportType->id,
                    'spiff_value' => $request->{$spiff_key},
                ]);
            }

        }

        session()->flash('message', 'Report Type Updated.');

        return redirect('report-types/' . $reportType->id);
    }

    public function update_residual(Request $request, ReportType $reportType)
    {
        $this->validate(request(), [
            'name' => 'required',
            'carrier' => 'required',
        ]);

        $reportType->update([
            'name' => $request->name,
            'carrier_id' => $request->carrier,
        ]);

        //$sites = Site::all();
        $sites = Site::whereNotIn('id', [4])->get();

        foreach ($sites as $site) {

            $residual_key = 'residual_' . $site->id;

            $row = ReportTypeSiteDefault::where([
                'site_id' => $site->id,
                'report_type_id' => $reportType->id,
            ])->first();

            if ($row) {

                $row->residual_percent = $request->{$residual_key};

                $row->save();

            } else {

                ReportTypeSiteDefault::create([
                    'site_id' => $site->id,
                    'report_type_id' => $reportType->id,
                    'residual_percent' => $request->{$residual_key},
                ]);
            }

        }

        session()->flash('message', 'Report Type Updated.');

        return redirect('report-types/' . $reportType->id);
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
