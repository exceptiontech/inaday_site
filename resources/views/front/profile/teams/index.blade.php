@extends('layouts.inner')
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

                                <!-- services -->
                                <div class="col-12 sub-title mt-5">
                                    <h3 class="mb-3">{{ __('file.my_teams') }}</h3>
                                </div>
                                

                                @if(count(Auth::user()->teams) > 0 )
                                  @foreach(Auth::user()->teams as $team)
                                    <div class="col-12 service pb-3 pt-2">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <img class="img-fluid" src="{{url($team->image ?? '/assets/images/logo.png')}}">
                                            </div>
                                            <div class="col-sm-10">
                                                <div class="row mb-2">
                                                    <div class="col-8 col-sm-9">
                                                        <h2 class="mb-3">{{$team->title ?? __('file.undefined') }}</h2>
                                                        <p class="pb-0">{{$team->desc ?? __('file.undefined') }}</p>
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
                                                                    <a class="dropdown-item" href="#">
                                                                        {{$user->first_name. ' ' .$user->last_name}}
                                                                    </a>
                                                                    @endforeach
                                                                @else
                                                                <a class="dropdown-item"  href="#">
                                                                    {{ __('file.no_team_members') }}
                                                                </a>

                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 col-sm-3">
                                                    @if(Auth::user()->id != $team->user_id)
                                                      @if($team->pivot->is_approved != 1)

                                                          {{ Form::open(['action' => 'Account\TeamController@acceptRequest']) }}
                                                          
                                                          {!! Form::hidden('id',$team->id ) !!}

                                                          {!! Form::submit(trans('profile.accept'), array('class'=>'btn btn-primary btn-block mb-2')) !!}
                                                          {{ Form::close() }}

                                                          {{ Form::open(['action' => 'Account\TeamController@refusedRequest']) }}
                                                          
                                                          {!! Form::hidden('id',$team->id ) !!}

                                                          {!! Form::submit(trans('profile.refused'), array('class'=>'btn btn-danger btn-block ')) !!}
                                                          {{ Form::close() }}


                                                      @else


                                                          {{ Form::open(['action' => 'Account\TeamController@cancelRequest']) }}
                                                          
                                                          {!! Form::hidden('id',$team->id ) !!}

                                                          {!! Form::submit(trans('profile.cancel'), array('class'=>'btn btn-danger btn-block ')) !!}
                                                          {{ Form::close() }}


                                                      @endif 
                                                    </div>
                                                    @endif 

                                                    </div>

                                                </div>


                                            </div>
                                        </div>
                                  @endforeach

                                @else
                                    <p>{{ __('file.dont_have_any_invitation') }} </p>
                                @endif



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