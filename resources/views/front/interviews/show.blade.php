@extends('layouts.inner')

@section('title')
	{{trans('file.interview')}}
@endsection


@section('content')
<section class="banner">
	<div class="container">
		<h1 class="title">{{trans('file.interview')}}</h1>
	</div>
</section>


<section class="interview p-5">
    <div class="container">

        <div class="row">

    	@if(count($questions) > 0 )
        <div class="col-12">
        
        {{ Form::model($interview, array('route' => array('front_interviews.update', $interview->id), 'method' => 'PUT','files'=>true)) }}


    		@foreach($questions as $question)

    			@if($question->qtype_id != 1)
        				<h2 class="mb-2">{{$question->title[App::getLocale()]}}</h2>
        				<p class="mb-3">{{$question->desc[App::getLocale()]}}</p>
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
                            <p class="text-info">
                                {{trans('file.if_you_have_file_related_in_your_solution')}}
                            </p>
                        </div>

                        </div>
    			@endif


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

</section><!-- #content end -->


@endsection
