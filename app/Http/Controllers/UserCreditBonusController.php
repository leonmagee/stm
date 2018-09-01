<?php

namespace App\Http\Controllers;

use App\UserCreditBonus;
use App\User;
use App\Helpers;
use Illuminate\Http\Request;

class UserCreditBonusController extends Controller
{
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
        return view('users.bonus-credit', compact('user', 'date'));
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
        // $bonus = $request->bonus;
        // $credit = $request->credit;
        // get current date
        // create method?
        // update method?
        // insert where? look it up first
        //var_dump($bonus);
        //var_dump($credit);
        //dd('working');

        /**
        * @todo first, query to find record, if it doesn't exist update it?
        * There should be a primary key of user id plus date?
        */

        $credit_bonus = UserCreditBonus::create([
            'user_id' => $user->id,
            'date' => Helpers::current_date(),
            'bonus' => $request->bonus,
            'credit' => $request->credit,
        ]);

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
