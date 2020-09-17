<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use Auth;
use DB;
use Hash;
use Mail;
use Validator;
use Redirect;
use Form;

use App\Section;
use App\Log;
use App\Company;
use App\Item;
use App\Image;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::paginate(15);
        return view('admin.sections.index')->withSections($sections);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sections.create');
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
            'title' => 'required|unique:sections',
            'desc' => 'required',
            'slug' => 'required|unique:sections|max:255|min:3',
            //'image' => 'required|mimes:svg,jpeg,jpg,png|max:2000',
            'is_active' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect('admin/sections/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $section = new Section;
        $section->title = $request->title;
        $section->slug = $request->slug;
        $section->desc = $request->desc;
        $section->is_active = $request->is_active;
        $section->icon = $request->icon;

        $file = $request->image;

        if (isset($file)) {
            $destinationPath = 'uploads/sections';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension; 
            $upload_success = $file->move($destinationPath, $fileName);
            $section->image =  $destinationPath.'/'.$fileName;
        }

        $section->save();


        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect('admin/sections');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (is_numeric($id)) {
            $section = Section::find($id);
        }else {
            $section = Section::where('slug',$id)->first();
        }

        $sid = $section->id;

        $companies = Company::whereHas('items', function ($query) use ($sid) {
                $query->whereHas('section', function ($query) use ($sid) {
                        $query->where('section_id', $sid);
                });
        })->get();


        return view('sections.show')->withSection($section)->withCompanies($companies);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //return $id;
        if (is_numeric($id)) {
            $section = Section::find($id);
        }else {
            $section = Section::where('slug',$id)->first();
        }

        $title = $section->title ;

        return view('admin.sections.edit')->withTitle($title)->withSection($section);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required|unique:pages',
            'desc'              => 'required',
            'is_active'              => 'required',

        ]);

        if ($validator->fails()) {
            return redirect('admin/sections/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $section = Section::find($id);

        $section->title = $request->title;
        $section->icon = $request->icon;

        $file = $request->image;

        if (isset($file)) {
            $destinationPath = 'uploads/sections';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension; 
            $upload_success = $file->move($destinationPath, $fileName);
            $section->image =  $destinationPath.'/'.$fileName;
        }

        $section->desc = $request->desc;
        $section->slug = $request->slug;
        $section->is_active = $request->is_active;
        $section->save();

        if ($section) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'section';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $sections = Section::all();

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (is_numeric($id)) {
            $section = Section::find($id);
        }else {
            $section = Section::where('slug',$id)->first();
        }

        if ($section) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'section';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $section->delete();
        

        Session::flash('status', "danger");
        Session::flash('message', __('admin.delete_success'));
        $section = Section::all();
        return  redirect::to('admin/sections');
    }


    public function ServicesShow(Request $request, $section, $company)
    {

        if (is_numeric($section)) {
            $section = Section::find($section);
        }else {
            $section = Section::where('slug',$section)->first();
        }

        if (is_numeric($company)) {
            $company = Company::find($company);
        }else {
            $company = Company::where('slug',$company)->first();
        }

        $items = Item::where('company_id',$company->id)->where('section_id',$section->id)->get();

        return view('sections.company.index')->withSection($section)->withCompany($company)->withItems($items);

    }


}
