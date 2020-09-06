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
                                </div>
                                <div class="col-3 p-0">
                                    <img src="{{ url($user->userdetail->first()->avater ?? '/assets/images/logo.png' ) }}" class="rounded-circle img-thumbnail img-icon80 img-fluid">
                                </div>
                                <div class="col-5 pt-2">
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


                    @if(!$user->userdetailComplete)
                    <div class="alert alert-info bg-dark ">
                        <span class="circle rounded-circle bg-dark text-center"><i class="fa fa-bell" aria-hidden="true"></i></span>
                        
                        برجاء اكمال وتحديث الملف الشخصي لما له تأثير فعلي على طريقة عملك
                    </div>
                    @endif


                    <div class="bg-light rounded pt-2 pb-3 p-2">
                        <div class="project">

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
                                       <p>لا يوجد اي تفاصيل عن هذا العضو</p>
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
