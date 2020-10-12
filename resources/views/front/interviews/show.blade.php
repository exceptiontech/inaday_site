@extends('layouts.inner')
@section('title')
{{trans('file.contact_us')}}

@endsection
@section('content')
<div id="innerpage" class="pt-5 pb-5">
        <div class="container">
            <div class="row">

                <div class="col-12 title">
                    <h2 class="text-white mb-5">{{trans('file.interview')}}</h2>
                </div>


                <div class="col-12 ">
                    <div class="bg-light contact_us rounded pt-3 pb-3 p-2">
                      <div class="p-4 project">

                    	@if(count($questions) > 0 )
                        <div class="col-12 block">
                        
                        {{ Form::model($interview, array('route' => array('front_interviews.update', $interview->id), 'method' => 'PUT','files'=>true)) }}


                    		@foreach($questions as $question)

                    			@if($question->qtype_id != 1)
                        				<h2 class="mb-2">{{$question->title[App::getLocale()]}}</h2>
                        				<p class="mb-3 p-0">{{$question->desc[App::getLocale()]}}</p>
                        				@if(count($question->qoptions)> 0)
                                            <div class="form-group"> 
                                            {!!Form::select('question['.$question->id.']',$question->qoptions->pluck('title.'.App::getLocale(),'id'), null, ['required', 'class' => 'form-control']) !!}
                                            </div>

                        				@else
                        					{{trans('file.no_options_to_this_question_please_contact_us')}}
                        				@endif
                    			@else
                                        <h2 class="mb-2">{{$question->title[App::getLocale()]}}</h2>
                                        <p class="mb-3">{{$question->desc[App::getLocale()]}}</p>
                                        <div class="form-group">
                                            {!! Form::textarea('question['.$question->id.']',null, ['required','class' => 'form-control','rows'=>3,'id'=>'title_'.App::getLocale()]) !!}

                                        <div class="form-group">
                                            {!! Form::label('file', trans('file.files')) !!}
                                            {!! Form::file('file', array( 'class' => 'form-control')) !!}
                                            <p class="text-info p-0">
                                                {{trans('file.if_you_have_file_related_in_your_solution')}}
                                            </p>
                                        </div>

                                        </div>
                    			@endif

                                <hr class="mt-5 mb-5">

                    		@endforeach
                                <div class="form-group">
                                    {!! Form::submit(trans('file.send'),array('class'=>'btn btn-primary')) !!}
                                </div>
                        </div>
                    	@else
                    		<h2 class="title"> {{trans('file.no_questions_to_this_interview_at_this_time')}}</h2>
                    		<p class="text">  {{trans('file.please_contact_us')}} </p>
                    	@endif
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
