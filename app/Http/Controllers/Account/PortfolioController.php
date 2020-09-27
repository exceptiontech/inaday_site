<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

use App\Portfolio;
use Illuminate\Http\Request;

use App\Log;
use Auth;
use Redirect;
use Session;

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
            return view('front.errors.denied');
        }


        if (!Auth::user()->userdetailComplete()) {
            Session::flash('status', __('admin.info'));
            Session::flash('message', 'لا بد من تحديث الملف الشخصى لتتمكن من اضافة معرض اعمال');
            return redirect::to('/account/profile/edit');
        }

        return view('front.profile.portfolios.index');
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

        $this->validate($request,[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:8048'
        ]);

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


        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new PortfolioCreated($portfolio));
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.edit_success'));
        return redirect::to('/user/'.Auth::user()->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function show(Portfolio $portfolio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function edit(Portfolio $portfolio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        //
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        if (Auth::user() && Auth::user()->isServicesProvider() == 1)
        {
            $portfolio= Portfolio::find($id);
            $portfolio->deleted_at = now();
            $portfolio->save();
        }
        


        if (Auth::user()->usersettings && Auth::user()->usersettings->profile_notifications)
        {
            Auth::user()->notify(new PortfolioDeleted($portfolio));
        }

        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));
        return redirect::to('/user/'.Auth::user()->id);

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
