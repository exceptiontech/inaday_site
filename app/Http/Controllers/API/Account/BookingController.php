<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Booking;
use App\Log;
use Auth;
use Redirect;
use Session;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function projects()
    {
        if (count(Auth::user()->roles) == 0 ) {


            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);

        }

        $id = Auth::user()->id;
        $bookings = Booking::whereHas('project')->with('project','service','mixture','offer','payment','user','user.userdetails','user.skills','status','replays','replays.user','project.files')->where('user_id',$id)->paginate(10);


        $data['status'] = true;
        $data['data'] = $bookings;

        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);

    }


    public function services()
    {
        if (count(Auth::user()->roles) == 0 ) {


            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);

        }

        $id = Auth::user()->id;
        $bookings = Booking::whereHas('service')->with('project','service','mixture','offer','payment','user','user.userdetails','user.skills','status','replays','replays.user')->where('user_id',$id)->paginate(10);


        $data['status'] = true;
        $data['data'] = $bookings;

        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);

    }


    public function mixtures()
    {
        if (count(Auth::user()->roles) == 0 ) {


            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);

        }

        $bookings = Booking::whereHas('mixture')->with('project','service','mixture','offer','payment','user','user.userdetails','user.skills','status','replays','replays.user','mixture.team','mixture.team.users.userdetails','mixture.team.users','mixture.services')->where('user_id',$id)->paginate(10);


        $data['status'] = true;
        $data['data'] = $bookings;

        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);

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

        $booking = Booking::find($id);

        if (count(Auth::user()->roles) == 0 || !$booking) {


            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);

        }



        if (!$booking || !$booking->UserhaveAccess(Auth::user()->id)) {
            $arr = array("status" => 400, "errorMsg" => 'NO PERMISSIONS', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }



        $booking = Booking::find($id)->with('project','service','mixture','offer','payment','user','status','replays')->paginate(10);


        $data['status'] = true;
        $data['data'] = $booking;

        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);

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