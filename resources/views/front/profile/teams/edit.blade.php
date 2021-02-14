@extends('layouts.inner')
@section('title')
  {{__('file.servives_provider_register')}}
@endsection
@section('content')


    <div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">{{ __('file.services_managment') }}</h2>
                </div>

                <div class="col-12">
                    <div class="bg-light mt-5 p-3  wrapper profile rounded">
                        <div class="row">

                            <div class="col-12  profile-head-menu mb-5">

                                @include('front.profile.parts.menu')
                            </div>

                            @if (Session::has('message'))
                            <div class="col-12">
                              <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                                    <h6>{{Session::get('message')}}</h6>
                              </div>
                            </div>
                            @endif


                            <div class="col-12 col-sm-8 profile-content services mb-5">

                                {{ Form::model($team, array('route' => array('front_teams.update', $team->id), 'method' => 'PUT')) }}

                                    @if(count($errors) > 0)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger alert-dismissable" >
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <h4>{{ $error}}</h4>
                                            </div>
                                        @endforeach
                                    @endif

                                        <div class="row mb-4">
                                            <div class="col-12 col-sm-6 mb-1">
                                                {!! Form::label('title', trans('file.team_name')) !!}
                                                {!! Form::text('title', $team->title, ['required', 'class' => 'form-control required','autofocus']) !!}
                                            </div>
                                            <div class="col-12 col-sm-6 d-flex align-middle">
                                                @if($team->image)
                                                    <div class="col-3 d-flex align-middle">
                                                        <img class="img-fluid" src="{{url('/'.$team->image)}}">
                                                    </div>
                                                    <div class="col-9">
                                                        {!! Form::label('team_image', trans('file.team_logo'))!!}
                                                        {!! Form::file('image', array( 'class' => 'form-control')) !!}
                                                    </div>
                                                @else
                                                    {!! Form::label('team_image', trans('file.team_logo'))!!}
                                                    {!! Form::file('image', array( 'class' => 'form-control')) !!}
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-12 ">
                                                {!! Form::label('desc', trans('file.team_desc')) !!}
                                                {!! Form::textarea('desc', null, 
                                                  array('required', 
                                                        'class'=>'textarea form-control', 
                                                        'placeholder'=>trans('file.team_desc') , 'rows'=>'3')) !!}
                                            </div>
                                        </div>

                                        <div class="row mt-5 mb-3">
                                            <div class="col-12">
                                                {!! Form::submit(trans('file.edititem'), array('class'=>'btn btn-primary')) !!}
                                            </div>
                                        </div>
                                    {{ Form::close() }}

                            </div>




                            <div class="col-12 col-sm-4">

                              @include('front.profile.parts.service_provider')

                            </div>

                        </div>
                    </div>
                </div>
                    
            </div>
        </div>
    </div>




@endsection

@section('jquery')

@endsection