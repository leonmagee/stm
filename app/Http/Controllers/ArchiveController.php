<?php

namespace App\Http\Controllers;

use App\Archive;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data = 'a:22:{i:0;a:3:{s:12:"report-title";s:18:"H2O Wireless Month";s:11:"number-sims";i:86;s:7:"payment";s:8:"1,140.00";}i:1;a:3:{s:12:"report-title";s:21:"H2O Wireless Residual";s:11:"number-sims";i:1729;s:7:"payment";s:6:"788.63";}i:2;a:3:{s:12:"report-title";s:19:"H2O Wireless Minute";s:11:"number-sims";i:16;s:7:"payment";s:5:"80.00";}i:3;a:3:{s:12:"report-title";s:19:"H2O Wireless Family";s:11:"number-sims";i:0;s:7:"payment";s:4:"0.00";}i:4;a:3:{s:12:"report-title";s:21:"H2O Bolt LTE Residual";s:11:"number-sims";i:0;s:7:"payment";s:4:"0.00";}i:5;a:3:{s:12:"report-title";s:18:"H2O Bolt LTE Month";s:11:"number-sims";i:0;s:7:"payment";s:4:"0.00";}i:6;a:3:{s:12:"report-title";s:19:"H2O easyGO Residual";s:11:"number-sims";i:61;s:7:"payment";s:5:"18.07";}i:7;a:3:{s:12:"report-title";s:16:"H2O easyGO Month";s:11:"number-sims";i:1;s:7:"payment";s:5:"10.00";}i:8;a:3:{s:12:"report-title";s:22:"H2O Month 2nd Recharge";s:11:"number-sims";i:7;s:7:"payment";s:5:"65.00";}i:9;a:3:{s:12:"report-title";s:23:"H2O easyGO 2nd Recharge";s:11:"number-sims";i:0;s:7:"payment";s:4:"0.00";}i:10;a:3:{s:12:"report-title";s:23:"H2O Minute 2nd Recharge";s:11:"number-sims";i:3;s:7:"payment";s:5:"15.00";}i:11;a:3:{s:12:"report-title";s:21:"H2O Bolt 2nd Recharge";s:11:"number-sims";i:0;s:7:"payment";s:4:"0.00";}i:12;a:3:{s:12:"report-title";s:24:"H2O Instant 2nd Recharge";s:11:"number-sims";i:0;s:7:"payment";s:4:"0.00";}i:13;a:3:{s:12:"report-title";s:29:"H2O Instant Spiff and Bundles";s:11:"number-sims";i:0;s:7:"payment";s:4:"0.00";}i:14;a:3:{s:12:"report-title";s:26:"easyGO Instant and Bundles";s:11:"number-sims";i:0;s:7:"payment";s:4:"0.00";}i:15;a:3:{s:12:"report-title";s:17:"Lyca Mobile Spiff";s:11:"number-sims";i:0;s:7:"payment";s:4:"0.00";}i:16;a:3:{s:12:"report-title";s:24:"Lyca Mobile 2nd Recharge";s:11:"number-sims";i:0;s:7:"payment";s:4:"0.00";}i:17;a:3:{s:12:"report-title";s:20:"Lyca Mobile Residual";s:11:"number-sims";i:0;s:7:"payment";s:4:"0.00";}i:18;a:3:{s:12:"report-title";s:24:"Lyca Mobile 3rd Recharge";s:11:"number-sims";i:0;s:7:"payment";s:4:"0.00";}i:19;a:3:{s:12:"report-title";s:36:"Lyca Mobile Instant Spiff and Bundle";s:11:"number-sims";i:0;s:7:"payment";s:4:"0.00";}i:20;a:3:{s:12:"report-title";s:25:"H2O Wireless 3rd Recharge";s:11:"number-sims";i:8;s:7:"payment";s:5:"40.00";}i:21;a:3:{s:12:"report-title";s:20:"H2O Wireless Port-In";s:11:"number-sims";i:0;s:7:"payment";s:4:"0.00";}}';

        $data_new = unserialize($data);

        dd($data_new);
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
     * @param  \App\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function show(Archive $archive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function edit(Archive $archive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Archive $archive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function destroy(Archive $archive)
    {
        //
    }
}
