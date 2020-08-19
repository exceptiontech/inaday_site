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

use App\Article;
use App\Department;
use App\Log;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::all();
        return view('admin.articles.index')->withArticles($articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::where('type','blog')->get();
        return view('admin.articles.create')->withDepartments($departments);
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
            'title'             => 'required|array|unique:articles',
            'desc'             => 'required|array',
            'slug'             => 'required|unique:articles|max:255|min:3',
            'department_id'             => 'integer',
            'is_active'             => 'integer',
        ]);

        if ($validator->fails()) {
            return redirect('admin/articles/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $article = new Article;
        $article->title = $request->title;
        $article->desc = $request->desc;
        $article->slug = $request->slug;
        $article->department_id = $request->department_id;
        $article->is_active = $request->is_active;
        if ($request->user_id) {
            $article->user_id = $request->user_id;
        }else {
            $article->user_id = Auth::user()->id;
        }
        
        $article->order = $request->order;
        $article->save();


        $file = $request->image;

        if (isset($file)) {
            $destinationPath = 'uploads/articles';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension; 
            $upload_success = $file->move($destinationPath, $fileName);
            $article->image =  $destinationPath.'/'.$fileName;
        }

        $article->save();


        if ($article) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'article';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/articles');
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
        if (is_numeric($id)) {
            $article = Article::find($id);
        }else {
            $article = Article::where('slug',$id)->first();
        }

        $departments = Department::where('type','blog')->get();

        return view('admin.articles.edit')->withArticle($article)->withDepartments($departments);
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

        $validator = Validator::make($request->all(), [
            'title'             => 'required|array|unique:articles',
            'desc'             => 'required|array',
            //'slug'              => 'required|unique:articles',
            'department_id'             => 'integer',
            'is_active'             => 'integer',
        ]);

        if ($validator->fails()) {
            return redirect('admin/articles/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $article = Article::find($id);
        $article->title = $request->title;
        $article->desc = $request->desc;
        $article->slug = $request->slug;
        $article->department_id = $request->department_id;
        $article->is_active = $request->is_active;
        if ($request->user_id) {
            $article->user_id = $request->user_id;
        }else {
            $article->user_id = Auth::user()->id;
        }
        
        $article->order = $request->order;
        $article->save();


        $file = $request->image;

        if (isset($file)) {
            $destinationPath = 'uploads/articles';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension; 
            $upload_success = $file->move($destinationPath, $fileName);
            $page->image =  $destinationPath.'/'.$fileName;
        }

        $article->save();


        if ($article) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'article';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/articles');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if (is_numeric($id)) {
            $article = Article::find($id);
        }else {
            $article = Article::where('slug',$id)->first();
        }

        if ($article) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'article';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $article->delete();
        

        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/articles');
    }
}
