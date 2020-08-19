<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Session;
use Redirect;
use Input;
use Carbon\Carbon;
use DB;
use Auth;
use Config;
use App;

use App\City;
use App\Country;
use App\Log;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();

        return view('admin.cities.index')->withCities($cities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('admin.cities.create')->withCountries($countries);
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
            'title'             => 'required|array|unique:cities',
            'slug'             => 'required|unique:countries|max:255|min:3',
            'country_id'             => 'integer',
            'is_active'             => 'integer',
        ]);

        if ($validator->fails()) {
            return redirect('admin/cities/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $city = new City;
        $city->title = $request->title;
        $city->slug = $request->slug;
        $city->country_id = $request->country_id;
        $city->is_active = $request->is_active;
        $city->save();

        if ($city) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'coty';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/cities');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_numeric($id)) {
            $city = City::find($id);
        }else {
            $city = City::where('slug',$id)->first();
        }

        $countries = Country::all();

        return view('admin.cities.edit')->withCity($city)->withCountries($countries);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required|array|unique:countries',
            'slug'              => 'required|unique:countries',
            'country_id'             => 'integer',
            'is_active'             => 'integer',
        ]);

        if ($validator->fails()) {
            return redirect('admin/cities/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $city = City::find($id);
        $city->title = $request->title;
        $city->slug = $request->slug;
        $city->is_active = $request->is_active;
        $city->country_id = $request->country_id;
        $city->save();

        if ($city) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'city';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/cities');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if (is_numeric($id)) {
            $city = City::find($id);
        }else {
            $city = City::where('slug',$id)->first();
        }

        if ($city) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'city';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $city->delete();
        

        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/cities');
    }
}
