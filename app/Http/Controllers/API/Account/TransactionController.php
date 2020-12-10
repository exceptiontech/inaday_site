<?php

namespace App\Http\Controllers\API\Account;

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
            'mount'     =>'required|numeric|min:1|max:'.Auth::user()->confirmedProfit(),
            'desc'      =>'required|max:500',
        ]);


        if ($validator->fails()) {
            $arr = array("status" => 401, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }

        // for services provider
        $transaction = new Transaction;
        $transaction->mount = $request->mount;
        $transaction->desc = $request->desc;
        $transaction->type = 'minus'; // plus or minus
        $transaction->title = 'سحب ارباح';
        $transaction->user_id = Auth::id();
        $transaction->is_confirmed = 0; // except project complete 
        $transaction->save();


        $data['status'] = true;
        $data['data'] = Auth::user()->transactions;

        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);

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
