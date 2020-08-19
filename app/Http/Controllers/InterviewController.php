<?php

namespace App\Http\Controllers;

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

use App\Qoption;
use App\Interview;
use App\Question;
use App\Log;


class InterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->PassedInterview()) {
            return view('front.errors.interview');
        }

        $default_skill = Auth::user()->DefaultSkill();

        $questions = Question::where('skill_id',$default_skill)->get()->random(10);
        return view('front.interview.create')->withQuestions($questions);
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
            'user_id'             => 'required',
            'skill_id'            => 'required',
            'questions'              => 'required|array',

        ]);

        if ($validator->fails()) {
            return redirect::back()->withErrors($validator)->withInput();

        }

        $interview = New Interview;
        $interview->user_id = $request->user_id;
        $interview->skill_id = $request->skill_id;
        $interview->save();


        $questions = $request->questions;

        if (count($questions)) {
            foreach ($questions as $key => $item) {
                $interview->questions()->attach($item);//$imageId => ['position'=>'foo', 'type'=>'bar']

            }
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $interview = Interview::findorfail($id);


        if (Auth::user()->PassedInterview() || Auth::user()->id != $interview->user_id ) {
            return view('front.errors.interview');
        }


        $questions = Question::where('skill_id',$interview->skill_id)->get();

        if (!$questions->isEmpty()) {
            $questions = $questions->random(10);
        } else {
            return view('front.errors.interview');
        }


        return view('front.interviews.show')->withInterview($interview)->withQuestions($questions);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function edit(Interview $interview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'question'   => 'required|array',

        ]);

        if ($validator->fails()) {
            return redirect::back()->withErrors($validator)->withInput();
        }

        $interview = Interview::findorfail($id);

        $questions = $request->question;

        foreach ($questions as $key => $value) {

            $question = Question::findorfail($key);


            if (is_numeric($value)) {
                $qoption = Qoption::findorfail($value);

                $interview->questions()->attach($question, ['qoption_id' => $qoption->id,'is_correct' => $qoption->is_true]);

            }else {
                $interview->questions()->attach($question, ['qoption_id' =>0,'is_correct' => 0,'answer'=>$value]);
            }
            
        }

        return view('front.interviews.success');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Interview  $interview
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
