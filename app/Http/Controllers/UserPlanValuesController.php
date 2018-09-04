<?php

namespace App\Http\Controllers;

use App\UserPlanValues;
use Illuminate\Http\Request;

class UserPlanValuesController extends Controller
{

    public function __construct() {

        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {

        // add validation
        // primary keys? 
        // hot to just update?

        UserPlanValues::create([
            'user_id' => $id,
            'report_type_id' => $request->report_type,
            'plan_value' => $request->plan,
            'payment_amount' => $request->payment,
        ]);

        return redirect('user-plan-values/' . $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserPlanValues  $userPlanValues
     * @return \Illuminate\Http\Response
     */
    public function edit(UserPlanValues $userPlanValues)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserPlanValues  $userPlanValues
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserPlanValues $userPlanValues)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserPlanValues  $userPlanValues
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserPlanValues $userPlanValues)
    {
        //
    }
}
