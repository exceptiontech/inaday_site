<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

use App\Transaction;
use Illuminate\Http\Request;

use Auth;
use Redirect;
use Session;
use Validator;


use App\Notifications\TransactionCreated;
use App\Notifications\TransactionUpdated;
use App\Notifications\TransactionDeleted;


class TransactionController extends Controller
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

        $validator = Validator::make($request->all(), [
            'mount'     =>'required|integer|numeric:10,'.Auth::user()->confirmedProfit(),
            'desc'      =>'required|max:500',
        ]);


        if ($validator->fails()) {
            return redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }

        // for services provider
        $transaction = new Transaction;
        $transaction->mount = $request->mount;
        $transaction->type = 'minus'; // plus or minus
        $transaction->title = 'سحب ارباح';
        $transaction->user_id = Auth::id();
        $transaction->is_confirmed = 0; // except project complete 
        $transaction->save();


        Session::flash('status', __('file.success'));
        Session::flash('message', 'تم ارسال طلب سحب ارباح');
        return redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
