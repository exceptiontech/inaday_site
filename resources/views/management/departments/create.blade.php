@extends('layouts.admin')

@section('before-css')


@endsection

@section('page-css')
    <link rel="stylesheet" href="{{asset('assets/dashboard/vendor/quill.bubble.css')}}">
    <link rel="stylesheet" href="{{asset('assets/dashboard/vendor/quill.snow.css')}}">
@endsection

@section('content')

<div class="breadcrumb">
    <h1>{{trans('admin.departments')}}</h1>
    <ul>
        <li><a href="{{ url('/admin') }}">{{trans('admin.home')}}</a></li>
        <li>{{trans('admin.departments')}}</li>
    </ul>
</div>

<div class="separator-breadcrumb border-top"></div>


<div class="row">
    <!-- column -->
    <div class="col-md-12">
        <h4>{{trans('admin.adddepartment')}}</h4>
        <p></p>
        <div class="card mb-5">
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                {{ Form::open(['action' => 'Admin\DepartmentController@store', 'files'=>true,'novalidate'=>'novalidate','class'=>'mt-4']) }}

                    <ul class="nav nav-pills" id="myPillTab" role="tablist">
                        @foreach (Config::get('languages') as $lang => $language)

                            <li class="nav-item"><a class="nav-link @if ($lang  == App::getLocale()) active show @endif " id="{{$lang}}-icon-pill" data-toggle="pill" href="#{{$lang}}" role="tab" aria-controls="homePIll" aria-selected="true">{{$language}}</a></li>

                        @endforeach
                    </ul>

                    <div class="tab-content" id="myPillTabContent">
                    @foreach (Config::get('languages') as $lang => $language)

                        <div class="tab-pane  @if ($lang == App::getLocale()) fade active show @endif " id="{{$lang}}" role="tabpanel" aria-labelledby="{{$lang}}-icon-pill">
                            <div class="form-group">
                                {!! Form::label('question-'.$lang, trans('admin.question').' - '.$language ) !!}
                                {!! Form::text('question['.$lang.']', null, ['required','class' => 'form-control','autocomplete'=>'off','id'=>'title_'.$lang]) !!}
                            </div>


                            <div class="form-group">
                                {!! Form::label('answer-'.$lang, trans('admin.answer').' - '.$language) !!}
                                {!! Form::textarea('answer['.$lang.']', null,
                                    array('required',
                                        'class'=>'textarea form-control',
                                        'placeholder'=>trans('admin.answer'))) !!}
                            </div>
                        </div>
                    @endforeach
                    </div>

                    @if(count($departments) > 0)
                    <div class="form-group">
                        {!! Form::label('parent_id', trans('admin.parents'))  !!}

                        {!! Form::select('parent_id',$departments->pluck('title.'.App::getLocale(),'id'), null ,['required', 'class' => 'form-control','placeholder'=>'قسم اب']) !!}
                    </div>
                    @endif

                    <div class="form-group">
                        {!! Form::label('image', trans('admin.image')) !!}
                        {!! Form::file('image', array( 'class' => 'form-control')) !!}
                    </div>

                    <div class="form-group {{  $errors->has('title') ? 'has-error' : ''}}">

                        {!! Form::label('slug', trans('admin.slug'))!!}
                        {!! Form::text('slug', null, ['required','class' => 'form-control','autocomplete'=>'off','id'=>'slug']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('is_active', trans('admin.status')) !!}
                        {!!Form::select('is_active', ['1' => trans('admin.yes'), '0' => trans('admin.no')], '1', ['required', 'class' => 'form-control']) !!}
                    </div>

                    {!! Form::submit(trans('admin.createnew'), array('class'=>'btn btn-info')) !!}

                {{ Form::close() }}
            </div>

        </div>
    </div>
</div>
@endsection

@section('page-js')


<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
<script src="{{asset('assets/dashboard/js/scripts/vendor/quill.min.js')}}"></script>



@endsection

@section('bottom-js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
    <script src="{{asset('assets/dashboard/js/scripts/plugins/quill.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/js/scripts/customizer.script.min.js')}}"></script>

    <script src="{{asset('assets/dashboard/js/scripts/quill.script.js')}}"></script>
@endsection
