<?php

namespace App\Http\Controllers\API\Account;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Notifications;
use Carbon\Carbon;

use Session;
use Auth;
use Socialite;
use URL;
use Redirect;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (count(Auth::user()->roles) == 0  || !Auth::user()->isActive() ) {
            $arr = array("status" => 401, "errorMsg" => __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }


        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {
            $arr = array("status" => 402, "errorMsg" => __('api.un_updated_profile'), "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }

        //Auth::user()->unreadNotifications->markAsRead();
        $notifications = Auth::user()->notifications;

        $data['status'] = true;
        $data['data'] = $notifications;

        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);

    }


    public function unread()
    {
        if (count(Auth::user()->roles) == 0  ||  !Auth::user()->isActive() ) {
            $arr = array("status" => 401, "errorMsg" => __('api.dont_have_permissions'), "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }


        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {
            $arr = array("status" => 402, "errorMsg" => __('api.un_updated_profile'), "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }


        $notifications = Auth::user()->notifications->where('read_at', '=', null);

        $data['status'] = true;
        $data['data'] = $notifications;

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

        $notification = Auth::user()->notifications->where('id' , $id)->first();
        if ($notification) {
            $notification->read_at = Carbon::now();
            $notification->save();

            return response()->json(['data' => $notification], 200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $arr = array("status" => 402, "errorMsg" => __('api.not_valid'), "data" => array(),"appearForUser" => true);
        return \Response::json(['error'=> $arr]);


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
