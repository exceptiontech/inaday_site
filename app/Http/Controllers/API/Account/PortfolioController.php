<?php

namespace App\Http\Controllers\API\Account;

use App\Http\Controllers\Controller;

use App\Portfolio;
use Illuminate\Http\Request;

use App\Log;
use Auth;
use Validator;

use App\Notifications\PortfolioCreated;
use App\Notifications\PortfolioUpdated;
use App\Notifications\PortfolioDeleted;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (count(Auth::user()->roles) == 0  || !Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }


        if (Auth::user()->userdetailComplete && !Auth::user()->userdetailComplete->first()) {
            $arr = array("status" => 402, "errorMsg" => 'you must complete your profile', "data" => array(),"appearForUser" => true);
            return \Response::json(['error'=> $arr]);
        }


        $portfolios = Portfolio::where('user_id',Auth::user()->id)->paginate(10);

        $data['status'] = true;
        $data['data'] = $portfolios;

        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);

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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:8048'
        ]);

        if ($validator->fails()) {
            $arr = array("status" => 401, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        $portfolio = new Portfolio();

        $file = $request->image;
        if ($file) {
            $destinationPath = 'uploads/portfolios';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $file->move($destinationPath, $fileName);
            $portfolio->image = $destinationPath.'/'.$fileName;
        }

        $portfolio->user_id=Auth::id();
        $portfolio->title=$request->title;
        $portfolio->desc=$request->desc;
        $portfolio->url=$request->url;
        $portfolio->save();

        if ($portfolio) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'portfolio';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Auth::user()->notify(new \App\Notifications\Database\PortfolioCreated($portfolio));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new PortfolioCreated($portfolio));
        }


        $portfolios = Portfolio::where('user_id',Auth::user()->id)->paginate(10);

        $data['status'] = true;
        $data['data'] = $portfolios;

        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {

            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);

        }
        elseif(is_null(Portfolio::where('user_id',Auth::id())->first()) == 1)
        {
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }



        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:8048'
        ]);

        if ($validator->fails()) {
            $arr = array("status" => 401, "errorMsg" => $validator->errors()->first(), "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }


        $portfolio= Portfolio::find($id);

        $file = $request->image;
        if ($file) {
            $destinationPath = 'uploads/portfolios';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension;
            $upload_success = $file->move($destinationPath, $fileName);
            $portfolio->image = $destinationPath.'/'.$fileName;
        }

        $portfolio->user_id=Auth::id();
        $portfolio->title=$request->title;
        $portfolio->desc=$request->desc;
        $portfolio->url=$request->url;
        $portfolio->save();


        if ($portfolio) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'portfolio';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }


        Auth::user()->notify(new \App\Notifications\Database\PortfolioCreated($portfolio));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new PortfolioCreated($portfolio));
        }


        $portfolios = Portfolio::where('user_id',Auth::user()->id)->paginate(10);


        $data['status'] = true;
        $data['data'] = $portfolios;

        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);

    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        if (!Auth::user()->isServicesProvider() || !Auth::user()->isActive() ) {

            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);

        }
        elseif(is_null(Portfolio::where('user_id',Auth::id())->first()) == 1)
        {
            $arr = array("status" => 401, "errorMsg" => 'UnAuthorised', "data" => array(),"appearForUser" => true);

            return \Response::json(['error'=> $arr]);
        }

        if (Auth::user() && Auth::user()->isServicesProvider() == 1)
        {
            $portfolio= Portfolio::find($id);
            $portfolio->deleted_at = now();
            $portfolio->save();

            if ($portfolio) {
                $log           = new Log;
                $log->user_id  = Auth::user()->id;
                $log->action   = 'delete';
                $log->model    = 'portfolio';
                $log->url      = $request->server()['REQUEST_URI'];
                $log->ip       = $request->server()['REMOTE_ADDR'];
                $log->save();
            }
        }
        
        Auth::user()->notify(new \App\Notifications\Database\PortfolioDeleted($portfolio));

        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new PortfolioDeleted($portfolio));
        }

        $portfolios = Portfolio::where('user_id',Auth::user()->id)->paginate(10);

        $data['status'] = true;
        $data['data'] = $portfolios;

        $arr = array("status" => 200,"data" => $data);
        return \Response::json(['data'=> $arr]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portfolio $portfolio)
    {
        //
    }
}
