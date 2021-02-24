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



                            <div class="col-12 col-sm-8 profile-content services mb-5">

                                <!-- services -->
                                <div class="col-12 sub-title mt-5">
                                    <h3 class="mb-3">فريقي</h3>
                                </div>
                                

                                @if(count(Auth::user()->myteams)>0)
                                
                                @foreach(Auth::user()->myteams as $team)
                                <div class="col-12 service pb-3 pt-2">

                                    <div class="row">
                                        <div class="col-sm-2">
                                            <img class="img-fluid" src="{{url($team->image ?? '/assets/images/logo.png')}}">
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="row mb-2">
                                                <div class="col-12 col-sm-10">
                                                    <h2 class="mb-3">{{$team->title ?? 'فريق بدون اسم' }}</h2>
                                                    <p class="pb-0">{{$team->desc ?? 'فريق بدون وصف' }}</p>
                                                </div>
                                                <div class="col-12 col-sm-2 sociel text-right">
                                                    <a class="mr-2" href="{{url('account/teams/'.$team->id.'/edit')}}">
                                                        <img src="{{url('/images/edit.svg')}}">
                                                    </a>
                                                    <a class="" href="{{url('/account/teams/delete/'.$team->id)}}">
                                                        <img src="{{url('images/delete.svg')}}">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 col-sm-8">

                                                    <div class="dropdown">
                                                        <button class="btn bg-light dropdown-toggle" type="button" id="memberWrapper" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        {{ __('file.team_members') }}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="memberWrapper">

                                                            <a class="dropdown-item" href="#">
                                                              <i class="fa fa-star" aria-hidden="true"></i>

                                                                {{$team->user->first_name. ' ' .$team->user->last_name}}
                                                            </a>
                                                            
                                                            @if(count($team->users)>0)
                                                                @foreach($team->users as $user)
                                                                <a class="dropdown-item" href="{{url('user/'.$user->id)}}">
                                                                    {{$user->first_name. ' ' .$user->last_name}}
                                                                    <span class="float-left">
                                                                    {{ Form::open(['action' => 'Account\TeamController@DeleteUser']) }}
                                                                                                
                                                                    {!! Form::hidden('id',$user->id , []) !!}
                                                                    {!! Form::hidden('team_id',$team->id , []) !!}

                                                                    {!! Form::submit('X', array('class'=>'btn p-0')) !!}
                                                                    {{ Form::close() }}
                                                                    </span>


                                                                </a>
                                                                @endforeach
                                                            @else
                                                            <a class="dropdown-item"  href="#">
                                                                {{trans('file.no_team_members')}}
                                                            </a>

                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-sm-4 text-right">
                                                    <a class="btn btn-primary rounded" href="{{url($team->id.'/list/services_provider')}}">
                                                        {{trans('file.add_team_members')}}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                @else
                                    <p>{{trans('file.create_your_team')}} </p>
                                @endif


                                <div class="col-12 mt-5 mb-5">

                                    {{ Form::open(['action' => 'Account\TeamController@store', 'files'=>true]) }}

                                        @if(count($errors) > 0)
                                            @foreach ($errors->all() as $error)
                                                <div class="alert alert-danger alert-dismissable" >
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    {{ $error}}
                                                </div>
                                            @endforeach
                                        @endif


                                        <div class="row mb-4">
                                            <div class="col-12 col-sm-6">
                                                {!! Form::label('title', trans('file.team_name')) !!} <em class="text-danger">*</em>
                                                {!! Form::text('title', old('title'), ['required', 'class' => 'form-control required','autofocus']) !!}
                                            </div>
                                            <div class="col-12 col-sm-6 form-group">
                                                {!! Form::label('team_image', trans('file.team_logo'))!!} <em class="text-danger">*</em>
                                                  <div class="input-group">
                                                    <span class="form-control overflow-hidden"></span>
                                                    <span class="input-group-btn">
                                                      <input name="image" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                                                      <span class="btn btn-light h-100 shadow" onclick="$(this).parent().find('input[type=file]').click();">{{trans('file.download')}}</span>
                                                    </span>
                                                  </div>

                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-12 ">
                                                {!! Form::label('desc', trans('file.team_desc')) !!} <em class="text-danger">*</em>
                                                {!! Form::textarea('desc', null, 
                                                  array('required', 
                                                        'class'=>'textarea form-control', 
                                                        'placeholder'=>trans('file.team_desc') , 'rows'=>'3')) !!}
                                            </div>
                                        </div>

                                        <div class="row mt-5 mb-3">
                                            <div class="col-12">
                                                {!! Form::submit(trans('forms.addteam'), array('class'=>'btn btn-primary')) !!}
                                            </div>
                                        </div>
                                    {{ Form::close() }}
                                </div>


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

