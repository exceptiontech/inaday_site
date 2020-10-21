@extends('layouts.inner')

@section('title')
  {{Auth::user()->first_name. ' ' .Auth::user()->last_name}}
@endsection


@section('content')
<div id="innerpage" class="pt-5 pb-5">
        <div class="container">

                <div class="col-12 title">
                    <h2 class="text-white mb-5">{{ __('file.profile') }}</h2>
                </div>

                <div class="row profile">
                <!-- sidebar Begin -->
                <div class="col-12 col-md-4 sidaber">
                    <div class="bg-light rounded pt-3 pb-3 p-2 text-center">

                        <div class="mt-n5 ">
                            <div class="row">
                                <div class="col-4 pt-2">
                                    <a class="btn btn-light small" href="{{url('/account/profile/edit')}}"><i class="fa fa-pencil" aria-hidden="true"></i> {{ __('file.edit') }}</a>
                                </div>
                                <div class="col-3 p-0">
                                    <img src="{{ url($userdetail->avater ?? '/assets/images/logo.png' ) }}" class="rounded-circle img-thumbnail img-icon80 img-fluid">
                                </div>
                                <div class="col-5 pt-2">
                                    <a class="btn btn-light small" href="{{url('/account/services')}}"><i class="fa fa-gear" aria-hidden="true"></i> {{ __('file.service_managment') }}</a>
                                </div>
                            </div>
                        </div>

                        <h2 class="mt-5">{{Auth::user()->first_name. ' ' .Auth::user()->last_name}}</h2>

                        <ul class="list-inline info">
                            <li class="list-inline-item">{{ $userdetail->position }}</li>
                            <li class="list-inline-item">                                              {{ Auth::user()->userdetail->first()->country->title[App::getLocale()] ?? __('file.undefined')}} / {{ Auth::user()->userdetail->first()->city->title[App::getLocale()] ?? __('file.undefined')}}</li>
                        </ul>


                        <div class="project-info mb-5 mt-5">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex">
                                    <a href="{{url('/account/profile/edit')}}">{{ __('file.about_me') }}</a>
                                </li>
                                <li class="list-group-item d-flex">
                                    <a href="{{url('/account/services')}}">{{ __('file.my_services') }}</a>
                                </li>
                                <li class="list-group-item d-flex">
                                    <a href="{{url('/account/skills')}}">{{ __('file.my_skills') }}</a>
                                </li>
                                <li class="list-group-item d-flex">
                                    <a href="{{url('/account/portfolios')}}">{{ __('file.my_portfolios') }}</a>
                                </li>
                                <li class="list-group-item d-flex">
                                    <a href="{{url('/account/experiences')}}">{{ __('file.my_experiences') }}</a>
                                </li>
                                <li class="list-group-item d-flex">
                                    <a href="{{url('/account/reviews')}}">{{ __('file.my_reviews') }}</a>
                                </li>
                            </ul>
                        </div>


                        <div class="col-12 contact_author align-bottom">
                            <a href="{{url('/account/messages/')}}" class="btn btn-primary btn-block mb-2">{{__('file.contact_me')}}</a>
                        </div>

                    </div>
                </div>
                <!-- sidebar End -->


                <!-- Content Begin -->
                <div class="col-12 col-md-8 profile-content">

                    @if (Session::has('message'))
                      <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                            {{Session::get('message')}}
                      </div>
                    @endif


                    @if(!Auth::user()->userdetailComplete())
                    <div class="alert alert-info bg-dark ">
                        <span class="circle rounded-circle bg-dark text-center"><i class="fa fa-bell" aria-hidden="true"></i></span>
                        
                        {{ __('file.completeprofile') }}
                    </div>
                    @endif


                    <div class="bg-light rounded pt-2 pb-3 p-2">
                        <div class="project">

                        @if (!empty($userdetail->notes))
                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                       <h2 class="mb-3">{{ __('profile.notes') }}</h2> 
                                       <p>{{ $userdetail->notes}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                       <h2 class="mb-3">{{ __('profile.skills') }}</h2> 
                                       
                                        <ul class="list-inline m-0 flex-shrink-1">
                                        @if (count(Auth::user()->skills))
                                            @foreach (Auth::user()->skills as $skill)
                                            <li class="list-inline-item">
                                                <div class="bg-light rounded pt-1 pb-1 p-2 ">- {{ $skill->title[App::getLocale()] }}</div>
                                            </li>
                                            @endforeach
                                        @endif
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <!-- sidebar End -->
            </div>
        </div>
    </div>
  @section('jquery')
@endsection
@endsection
