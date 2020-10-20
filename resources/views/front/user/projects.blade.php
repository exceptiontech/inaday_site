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




                    <div class="bg-light rounded pt-2 pb-3 p-2">
                        <div class="project">

                        @if (!empty($user->userdetail->notes))
                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                       <h2 class="mb-3">{{ __('profile.notes') }}</h2> 
                                       <p>{{ $user->userdetail->notes}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                       <h2 class="mb-3">المشاريع</h2> 
                                       
                                        @if (count($user->projects))
                                        <div class="projects">
                                            @foreach ($user->projects as $project)



                                            <div class="project col-12 pt-3 pb-2 mb-3">
                                                <div class="row">
                                                    <div class="col-sm-11">
                                                        <h2 class="mb-4"><a href="{{ url('/projects/'.$project->id) }}">{{ $project->title }}</a></h2>
                                                    </div>
                                                    <div class="col-sm-1">

                                                        @if(Auth::user())

                                                            @if(Auth::user()->ProjecthasFavorite($project->id))
                                                                <a id="RemoveFromFav" class="updateFav updateFav{{$project->id}}" data-id="{{$project->id}}" href="#">
                                                                <i class="fa fa-star starred" aria-hidden="true"></i></a>
                                                            @else
                                                                <a id="AddToFav" class="updateFav updateFav{{$project->id}}" data-id="{{$project->id}}"  href="#">
                                                                <i class="fa fa-star-o" aria-hidden="true"></i></a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-9">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                                              @if($project->user )
                                                                  @if(count($project->user->userdetail) > 0)
                                                                      @if($project->user->userdetail->first()->avater)
                                                                        <img src="{{ url($project->user->userdetail->first()->avater) }}" class="rounded-circle img-thumbnail img-fluid" alt="{{$project->title}}" title="{{$project->title}}" />
                                                                        {{ $project->user->first_name.' '.$project->user->last_name }}
                                                                      @else
                                                                        <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid" alt="{{$project->title}}" title="{{$project->title}}" />
                                                                        {{ $project->user->first_name.' '.$project->user->last_name }}
                                                                      @endif
                                                                  @else
                                                                    <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid" alt="{{$project->title}}" title="{{$project->title}}" />
                                                                    {{ $project->user->first_name.' '.$project->user->last_name }}
                                                                  @endif
                                                              @else
                                                                <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid" alt="{{$project->title}}" title="{{$project->title}}" />
                                                                {{ $project->user->first_name.' '.$project->user->last_name }}
                                                              @endif
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <div class="bg-light pt-1 pb-1 p-2 ">
                                                                    @if($project->section)
                                                                      {{@$project->section->title[App::getLocale()]}}
                                                                    @else
                                                                      {{trans('file.without_section')}}
                                                                    @endif
                                                                </div>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                                {{ $project->created_at }}
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>
                                                                {{$project->offers->count()}}  {{ __('file.offer') }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-12 col-sm-3">
                                                        <a class="btn btn-primary btn-block rounded" href="{{ url('/projects/'.$project->id) }}">{{trans('file.project_details')}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        @else
                                            <p>{{ __('file.no_items') }} </p>
                                        @endif

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
