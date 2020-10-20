@extends('layouts.inner')

@section('title')
  {{$user->first_name. ' ' .$user->last_name}}
@endsection


@section('content')
<div id="innerpage" class="pt-5 pb-5">
        <div class="container">

                <div class="col-12 title">
                    <h2 class="text-white mb-5">{{ __('file.profile') }}</h2>
                </div>

                <div class="row profile">
                    <!-- sidebar Begin -->
                    @include('front.user.parts.sidebar')
                    <!-- sidebar End -->


                <!-- Content Begin -->
                <div class="col-12 col-md-8 profile-content">

                    @if (Session::has('message'))
                      <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                            {{Session::get('message')}}
                      </div>
                    @endif


                    @if(!$user->userdetailComplete())
                    <div class="alert alert-info bg-dark ">
                        <span class="circle rounded-circle bg-dark text-center"><i class="fa fa-bell" aria-hidden="true"></i></span>
                        
                        {{ __('file.completeprofile') }}
                    </div>
                    @endif


                    <div class="bg-light rounded pt-2 pb-3 p-2">


                        <div class="project">



                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h2 class="mb-3">{{ __('file.cost_by_hour') }}</h2>  
                                        <ul class="list-inline m-0 flex-shrink-1">
                                            <li class="list-inline-item">
                                                <div class="bg-light rounded pt-1 pb-1 p-2 ">{{ $user->userdetail->first()->costkind->title[App::getLocale()] ?? __('file.undefined') }}</div>
                                            </li>
                                            <li class="list-inline-item">
                                                <div class="bg-light rounded pt-1 pb-1 p-2 ">{{ $user->userdetail->first()->prefer->title[App::getLocale()] ?? __('file.undefined') }}</div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6">
                                        <h2 class="mb-3">{{__('file.jobtypes')}}</h2> 
                                        <ul class="list-inline m-0 flex-shrink-1">
                                            <li class="list-inline-item">
                                                <div class="bg-light rounded pt-1 pb-1 p-2 ">{{ $user->userdetail->first()->jobtype->title[App::getLocale()] ?? __('file.undefined') }}</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>



                        @if (!empty($user->userdetail->first()->notes))
                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                       <h2 class="mb-3">{{ __('profile.notes') }}</h2> 
                                       <p>{{ $user->userdetail->first()->notes}}</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                       <h2 class="mb-3">{{ __('profile.notes') }}</h2> 
                                       <p>{{ __('file.no_notes') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                        @endif


                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                       <h2 class="mb-3">{{ __('profile.skills') }}</h2> 
                                       
                                        <ul class="list-inline m-0 flex-shrink-1">
                                        @if (count($user->skills))
                                            @foreach ($user->skills as $skill)
                                            <li class="list-inline-item">
                                                <div class="bg-light rounded pt-1 pb-1 p-2 ">- {{ $skill->title[App::getLocale()] }}</div>
                                            </li>
                                            @endforeach
                                        @endif
                                        </ul>

                                    </div>
                                </div>
                            </div>


                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                       <h2 class="mb-3">{{ __('file.portfolios') }}</h2> 
                                       
                                        <div class="d-flex d-inline-flex mb-5">

                                        @if(count($user->portfolios))
                                            @foreach($user->portfolios as $portfolio)
                                                <div class="position-relative">
                                                    <img class="mr-2 img-icon120" src="{{url($portfolio->image)}}">
                                                </div>
                                            @endforeach
                                        @else
                                            <p>{{ __('file.no_items') }}</p>
                                        @endif


                                        </div>

                                    </div>
                                </div>
                            </div>


                            <div class="block col-12 pt-3 pb-2 mb-1">


                                    <div class="cv-history">
                                        <h2 class="mb-3">{{ __('file.experiences') }}</h2>


                                        @if (count($user->experiences))
                                            @foreach ($user->experiences as $experience)

                                            <div class="cv-item pl-3 pb-3">
                                                <h2>{{$experience->position}}</h2>
                                                <p class="date mb-1">
                                                    {{$experience->company}} من <span>{{ Carbon\Carbon::parse(strtotime($experience->start_date))->format('m-Y') }} </span>  {{ __('file.to') }} <span> {{ Carbon\Carbon::parse($experience->end_date)->format('m-Y ') ?? ''}} </span>
                                                </p>
                                                <p class="details">
                                                    {{$experience->desc ?? ''}}
                                                </p>
                                            </div>

                                            @endforeach
                                        @else
                                            <p>{{ __('file.no_items') }}</p>
                                        @endif

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
