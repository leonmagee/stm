<?php

namespace App\Http\Controllers;

use App\ReportType;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReportType  $reportType
     * @return \Illuminate\Http\Response
     */
    public function show(ReportType $reportType)
    {
        //
        return view('report_types.show', compact('reportType'));
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
        //
    }
}
