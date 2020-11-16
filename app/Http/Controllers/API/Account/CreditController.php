<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Transaction;
use App\Log;
use Auth;
use Redirect;
use Session;

class CreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request  ,Transaction $transactions)
    {

        $transactions = $transactions->newQuery();

        $transactions->where('user_id',Auth::id());

        if ($request->title) {
            $title = $request->title;

            $transactions->whereHas('booking', function ($query) use ($title) {
                $query->whereHas('project', function ($query) use ($title) {
                    $query->where('title', 'like', '%' . $title . '%');
                });
            });

            $transactions->whereHas('booking', function ($query) use ($title) {
                $query->whereHas('service', function ($query) use ($title) {
                    $query->where('title', 'like', '%' . $title . '%');
                });
            });

            $transactions->whereHas('booking', function ($query) use ($title) {
                $query->whereHas('mixture', function ($query) use ($title) {
                    $query->where('title', 'like', '%' . $title . '%');
                });
            });
        }

        if ($request->type) {
            $type = $request->type;
            $transactions->where('type',$type);
        }

        if ($request->start_date) {
            $start_date = $request->start_date;
            $transactions->whereDate('created_at','>=', $start_date);
        }

        if ($request->end_date) {
            $end_date = $request->end_date;
            $transactions->whereDate('created_at','<=', $end_date);
        }


        if (Auth::user()->isServicesProvider()) {
            return view('front.profile.credit.services_provider.index')->withTransactions($transactions->latest()->get());
        }elseif(Auth::user()->isEntrepreneur()) {
            return view('front.profile.credit.entrepreneur.index')->withTransactions($transactions->latest()->get());
        }
        
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
