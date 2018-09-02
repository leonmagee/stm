<?php

namespace App\Http\Controllers;

use App\UserCreditBonus;
use App\User;
use App\Helpers;
use Illuminate\Http\Request;

class UserCreditBonusController extends Controller
{

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
        //
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
     * @param  \App\UserCreditBonus  $userCreditBonus
     * @return \Illuminate\Http\Response
     */
    public function show(UserCreditBonus $userCreditBonus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserCreditBonus  $userCreditBonus
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

        $date = Helpers::current_date_name();

        $date_string = Helpers::current_date();

        $bonus_credit = UserCreditBonus::where([
            'user_id' => $user->id,
            'date' => $date_string
        ])->first();

        if ( isset($bonus_credit->bonus) ) {
            $bonus = $bonus_credit->bonus;
        } else {
            $bonus = false;
        }
        if ( isset($bonus_credit->credit) ) {
            $credit = $bonus_credit->credit;
        } else {
            $credit = false;
        }



        return view('users.bonus-credit', compact('user', 'date', 'bonus', 'credit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserCreditBonus  $userCreditBonus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $date = Helpers::current_date();

        $current = UserCreditBonus::where([
            'user_id' => $user->id,
            'date' => $date
        ])->first();

        if ( $current ) {

            $current->bonus = $request->bonus;
            $current->credit = $request->credit;
            $current->save();

        } else {

            $credit_bonus = UserCreditBonus::create([
                'user_id' => $user->id,
                'date' => $date,
                'bonus' => $request->bonus,
                'credit' => $request->credit,
            ]);
        }

        return redirect('users/' . $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserCreditBonus  $userCreditBonus
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserCreditBonus $userCreditBonus)
    {
        //
    }
}
