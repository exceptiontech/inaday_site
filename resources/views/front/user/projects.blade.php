@extends('layouts.inner')

@section('title')
  {{$user->first_name. ' ' .$user->last_name}}
@endsection


@section('content')
<div id="innerpage" class="pt-5 pb-5">
        <div class="container">

                <div class="col-12 title">
                    <h2 class="text-white mb-5">الملف الشخصي</h2>
                </div>

                <div class="row profile">
                <!-- sidebar Begin -->
                <div class="col-12 col-md-4 sidaber">
                    <div class="bg-light rounded pt-3 pb-3 p-2 text-center">

                        <div class="mt-n5 ">
                            <div class="row">
                                <div class="col-4 pt-2">
                                    @if($user->id == Auth::user()->id)
                                    <a class="btn btn-light small" href="{{url('/account/profile/edit')}}"><i class="fa fa-pencil" aria-hidden="true"></i> تعديل</a>
                                    @endif
                                </div>
                                <div class="col-3 p-0">
                                    <img src="{{ url($user->userdetail->first()->avater ?? '/assets/images/logo.png' ) }}" class="rounded-circle img-thumbnail img-icon80 img-fluid">
                                </div>
                                <div class="col-5 pt-2">
                                    @if($user->id == Auth::user()->id)
                                    <a class="btn btn-light small" href="{{url('/account/services')}}"><i class="fa fa-gear" aria-hidden="true"></i> ادارة الخدمات</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <h2 class="mt-5">{{$user->first_name. ' ' .$user->last_name}}</h2>

                        <ul class="list-inline info">
                            <li class="list-inline-item">{{ $user->userdetail->first()->position ?? 'رائد أعمال' }}</li>
                            <li class="list-inline-item">                                              {{ $user->userdetail->first()->country->title[App::getLocale()] ?? 'دولة غير محددة'}} / {{ $user->userdetail->first()->city->title[App::getLocale()] ?? 'مدينة غير محددة '}}</li>
                        </ul>


                        <div class="project-info mb-5 mt-5">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex">
                                    <a href="{{url('/user/'.$user->id.'/about')}}">نبذة عني</a>
                                </li>
                                @if($user->isEntrepreneur() )
                                <li class="list-group-item d-flex">
                                    <a href="{{url('/user/'.$user->id.'/projects')}}">خدماتي</a>
                                </li>
                                @endif

                                @if($user->isServicesProvider() )
                                <li class="list-group-item d-flex">
                                    <a href="{{url('/user/'.$user->id.'/services')}}">خدماتي</a>
                                </li>
                                <li class="list-group-item d-flex">
                                    <a href="{{url('/user/'.$user->id.'/skills')}}">مهاراتي</a>
                                </li>
                                <li class="list-group-item d-flex">
                                    <a href="{{url('/user/'.$user->id.'/portfolios')}}">معرض الأعمال</a>
                                </li>
                                <li class="list-group-item d-flex">
                                    <a href="{{url('/user/'.$user->id.'/experiences')}}">خبراتي</a>
                                </li>
                                @endif
                                <li class="list-group-item d-flex">
                                    <a href="{{url('/user/'.$user->id.'/reviews')}} ">تقييمات العملاء</a>
                                </li>
                            </ul>
                        </div>


                        <div class="col-12 contact_author align-bottom">
                            <a href="{{url('/messages/'.$user->id)}}" class="btn btn-primary btn-block mb-2">تواصل معي</a>
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
                                            @foreach ($user->projects as $project)
                                                <div class="col-12 project pb-3 pt-2">
                                                    <h2>{{$project->title}}</h2>

                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                            <ul class="list-inline m-0 flex-shrink-1">
                                                                <li class="list-inline-item">
                                                                    <img src="{{ url($project->user->userdetail->first()->avater ?? '/assets/images/logo.png' ) }}" class="rounded-circle img-thumbnail img-fluid">
                                                                    {{$project->user->first_name .' '.$project->user->last_name }}
                                                                </li>
                                                                <li class="list-inline-item">
                                                                    <div class="bg-light pt-1 pb-1 p-2 ">{{$project->section->title[App::getLocale()] ?? 'بدون تصنيف' }} </div>
                                                                </li>
                                                                <li class="list-inline-item">
                                                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                                    10/07/2020 
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            @if(Auth::user()->id == $user->id)
                                                            <a class="btn btn-primary rounded" href="{{ url('/projects/'.$project->id) }}">تفاصيل المشروع</a>
                                                            <a class="btn btn-secondary rounded" href="{{ url('account/projects/'.$project->id.'/edit') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>لا يوجد اي مشاريع </p>
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
