<?php

namespace App\Http\Controllers;

use App\UserResidualPercent;
use Illuminate\Http\Request;

class UserResidualPercentController extends Controller
{

    public function __construct()
    {
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

        $current = UserResidualPercent::where([
            'user_id' => $id,
            'report_type_id' => $request->report_type_residual
        ])->first();

        if ( $current ) {

            $current->residual_percent = $request->percent;
            $current->save();

        } else {
            UserResidualPercent::create([
                'user_id' => $id,
                'report_type_id' => $request->report_type_residual,
                'residual_percent' => $request->percent
            ]);
        }

        return redirect('user-plan-values/' . $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserResidualPercent  $userResidualPercent
     * @return \Illuminate\Http\Response
     */
    public function edit(UserResidualPercent $userResidualPercent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserResidualPercent  $userResidualPercent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserResidualPercent $userResidualPercent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserResidualPercent  $userResidualPercent
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserResidualPercent $userResidualPercent)
    {
        $userResidualPercent->delete();

        return redirect('user-plan-values/' . $userResidualPercent->user_id);
    }
}
