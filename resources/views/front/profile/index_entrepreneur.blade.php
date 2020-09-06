@extends('layouts.inner')

@section('title')
  {{Auth::user()->first_name. ' ' .Auth::user()->last_name}}
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
                                    <a class="btn btn-light small" href="{{url('/account/profile/edit')}}"><i class="fa fa-pencil" aria-hidden="true"></i> تعديل</a>
                                </div>
                                <div class="col-3 p-0">
                                    <img src="{{ url($userdetail->avater ?? '/assets/images/logo.png' ) }}" class="rounded-circle img-thumbnail img-icon80 img-fluid">
                                </div>
                                <div class="col-5 pt-2">
                                    <a class="btn btn-light small" href="{{url('/account/projects')}}"><i class="fa fa-gear" aria-hidden="true"></i> ادارة المشاريع</a>
                                </div>
                            </div>
                        </div>

                        <h2 class="mt-5">{{Auth::user()->first_name. ' ' .Auth::user()->last_name}}</h2>

                        <ul class="list-inline info">
                            <li class="list-inline-item">رائد أعمال</li>
                            <li class="list-inline-item">                                              {{ Auth::user()->userdetail->first()->country->title[App::getLocale()] ?? 'دولة غير محددة'}} / {{ Auth::user()->userdetail->first()->city->title[App::getLocale()] ?? 'مدينة غير محددة '}}</li>
                        </ul>


                        <div class="project-info mb-5 mt-5">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex">
                                    <a href="{{url('/account/profile/edit')}}">نبذة عني</a>
                                </li>
                                <li class="list-group-item d-flex">
                                    <a href="{{url('/account/projects')}}">مشاريعي</a>
                                </li>
                                <li class="list-group-item d-flex">
                                    <a href="{{url('/account/bookings')}}">الحجوزات</a>
                                </li>
                                <li class="list-group-item d-flex">
                                    <a href="{{url('/account/notifications')}}">الاشعارات</a>
                                </li>
                                <li class="list-group-item d-flex">
                                    <a href="{{url('/account/')}}">الاعدادات</a>
                                </li>
                            </ul>
                        </div>


                        <div class="col-12 contact_author align-bottom">
                            <a href="{{url('/account/messages/')}}" class="btn btn-primary btn-block mb-2">الرسائل</a>
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

                    @if(!Auth::user()->userdetailComplete)
                    <div class="alert alert-info bg-dark ">
                        <span class="circle rounded-circle bg-dark text-center"><i class="fa fa-bell" aria-hidden="true"></i></span>
                        
                        برجاء اكمال وتحديث الملف الشخصي لما له تأثير فعلي على طريقة عملك
                    </div>
                    @endif

                    <div class="bg-light rounded pt-2 pb-3 p-2">
                        <div class="project">


                            <!-- project -->
                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                      <h2 class="mb-3"> نبذة عني</h2>
                                      <p> {{ $userdetail->notes ?? 'من فضلك قم بتحديث الملف الشخصي' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="block projects col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                       <h2 class="mb-3">المشاريع</h2> 
                                
                                      @if(count(Auth::user()->projects))
                                        @foreach(Auth::user()->projects as $project)
                                        <div class="col-12 project pb-3 pt-2">
                                            <h2>{{$project->title}}</h2>

                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <ul class="list-inline m-0 flex-shrink-1">
                                                        <li class="list-inline-item">
                                                            @if($project->user )
                                                                @if(count($project->user->userdetail) > 0)
                                                                    @if($project->user->userdetail->first()->avater)
                                                                      <img src="{{ url($project->user->userdetail->first()->avater) }}" class="rounded-circle img-thumbnail img-fluid" alt="{{$project->title}}" title="{{$project->title}}" />
                                                                    @else
                                                                      <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid" alt="{{$project->title}}" title="{{$project->title}}" />
                                                                    @endif
                                                                @else
                                                                  <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid" alt="{{$project->title}}" title="{{$project->title}}" /> 
                                                                @endif
                                                            @else
                                                              <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid" alt="{{$project->title}}" title="{{$project->title}}" />                                                             
                                                            @endif                                                             
                                                            {{Auth::user()->first_name. ' ' .Auth::user()->last_name}}
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
                                                    </ul>
                                                </div>

                                                <div class="col-sm-3">
                                                    <a class="btn btn-primary rounded" href="{{ url('/projects/'.$project->id) }}">تفاصيل المشروع</a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                          <div class="book-details">
                                              <div class="col-sm-12">
                                                    {{trans('file.you_dont_have_any_projects_right_now')}}
                                              </div>
                                          </div>
                                      @endif


                                        <div class="col-12 mt-4">
                                            <a href="{{ url('account/projects/create') }}" class="btn btn-primary">اضافة مشروع جديد</a>
                                        </div>
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
@endsection
