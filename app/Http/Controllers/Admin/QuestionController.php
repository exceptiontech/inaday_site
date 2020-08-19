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

use App\Department;
use App\Question;
use App\Qtype;
use App\Skill;
use App\Qoption;
use App\Log;


class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();

        return view('admin.questions.index')->withQuestions($questions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $qtypes = Qtype::all();
        $skills = Skill::where('is_active',1)->get();

        return view('admin.questions.create')->withQtypes($qtypes)->withSkills($skills);
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
            'title'             => 'required|array|unique:questions',
            'desc'             => 'required|array',
            'qtype_id'             => 'required|integer',
            'skill_id'             => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect('admin/questions/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $question = new Question;
        $question->title = $request->title;
        $question->desc = $request->desc;
        $question->qtype_id = $request->qtype_id;
        $question->skill_id = $request->skill_id;
        $question->user_id = Auth::user()->id;
        $question->save();

        if ($question) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'create';
            $log->model    = 'question';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();


            $options = $request->options;

            if (isset($options)) {
                foreach ($options as $item) {

                    $option = new Qoption;
                    $option->title = $item['title'];
                    $option->question_id = $question->id;
                    if ($item['is_true']) {
                        $option->is_true = $item['is_true'];
                    }
                    $option->save();
                    
                    if ($option) {
                        $log           = new Log;
                        $log->user_id  = Auth::user()->id;
                        $log->action   = 'create';
                        $log->model    = 'qoption ';
                        $log->url      = $request->server()['REQUEST_URI'];
                        $log->ip       = $request->server()['REMOTE_ADDR'];
                        $log->save();
                    }

                }
            }
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.create_success'));
        return redirect::to('admin/questions');
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
            $question = Question::find($id);
        }else {
            $question = Question::where('slug',$id)->first();
        }

        $qtypes = Qtype::all();
        $skills = Skill::where('is_active',1)->get();

        return view('admin.questions.edit')->withQuestion($question)->withQtypes($qtypes)->withSkills($skills);
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
            'title'             => 'required|array|unique:questions',
            'desc'             => 'required|array',
            'slug'              => 'required|unique:questions',
            'department_id'             => 'integer',
            'is_active'             => 'integer',
        ]);

        if ($validator->fails()) {
            return redirect('admin/questions/'.$id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $question = Question::find($id);
        $question->title = $request->title;
        $question->desc = $request->desc;
        $question->slug = $request->slug;
        $question->department_id = $request->department_id;
        $question->is_active = $request->is_active;
        if ($request->user_id) {
            $question->user_id = $request->user_id;
        }else {
            $question->user_id = Auth::user()->id;
        }
        
        $question->order = $request->order;
        $question->save();


        $file = $request->image;

        if (isset($file)) {
            $destinationPath = 'uploads/questions';
            $extension =  $file->getClientOriginalExtension();
            $fileName = date("Y-m-d").'-'.rand(999,9999).'.'.$extension; 
            $upload_success = $file->move($destinationPath, $fileName);
            $page->image =  $destinationPath.'/'.$fileName;
        }

        $question->save();


        if ($question) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'update';
            $log->model    = 'question';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        Session::flash('status', __('admin.success'));
        Session::flash('message', __('admin.update_success'));
        return redirect::to('admin/questions');
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
            $question = Question::find($id);
        }else {
            $question = Question::where('slug',$id)->first();
        }

        if ($question) {
            $log           = new Log;
            $log->user_id  = Auth::user()->id;
            $log->action   = 'delete';
            $log->model    = 'question';
            $log->url      = $request->server()['REQUEST_URI'];
            $log->ip       = $request->server()['REMOTE_ADDR'];
            $log->save();
        }

        $question->delete();
        

        Session::flash('status', __('admin.danger'));
        Session::flash('message', __('admin.delete_success'));

        return  redirect::to('admin/questions');
    }

}
