<?php

namespace App\Http\Controllers;

use App\Service;
use App\Favorite;
use App\Log;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use Session;

use App\Notifications\FavoriteCreated;
use App\Notifications\FavoriteUpdated;
use App\Notifications\FavoriteDeleted;

class FavoriteController extends Controller
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
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function show(Favorite $favorite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function edit(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $service = Service::findorfail($request->id);

        if (Auth::user()->ServicehasFavorite($request->id)) {

            $favorite = Favorite::where('service_id',$request->id);
            $favorite->delete();

            if ($favorite) {
                $log           = new Log;
                $log->user_id  = Auth::user()->id;
                $log->action   = 'delete';
                $log->model    = 'favorite';
                $log->url      = $request->server()['REQUEST_URI'];
                $log->ip       = $request->server()['REMOTE_ADDR'];
                $log->save();
            }

            $service->user->notify(new FavoriteDeleted($favorite));

            return response()->json(['result'=>'remove']);

        }else {
            $favorite = new Favorite;
            $favorite->service_id = $request->id;
            $favorite->user_id = Auth::user()->id;
            $favorite->save();

            if ($favorite) {
                $log           = new Log;
                $log->user_id  = Auth::user()->id;
                $log->action   = 'create';
                $log->model    = 'favorite';
                $log->url      = $request->server()['REQUEST_URI'];
                $log->ip       = $request->server()['REMOTE_ADDR'];
                $log->save();
            }

            $service->user->notify(new FavoriteCreated($favorite));
            return response()->json(['result'=>'done']);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite)
    {
        //
    }
}
