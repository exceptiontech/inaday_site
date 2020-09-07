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


                    @if(!$user->userdetailComplete)
                    <div class="alert alert-info bg-dark ">
                        <span class="circle rounded-circle bg-dark text-center"><i class="fa fa-bell" aria-hidden="true"></i></span>
                        
                        برجاء اكمال وتحديث الملف الشخصي لما له تأثير فعلي على طريقة عملك
                    </div>
                    @endif


                    <div class="bg-light rounded pt-2 pb-3 p-2">


                        <div class="project">



                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h2 class="mb-3">التكلفة بالساعة</h2> 
                                        <ul class="list-inline m-0 flex-shrink-1">
                                            <li class="list-inline-item">
                                                <div class="bg-light rounded pt-1 pb-1 p-2 ">{{ $user->userdetail->first()->costkind->title[App::getLocale()] ?? 'غير محدد' }}</div>
                                            </li>
                                            <li class="list-inline-item">
                                                <div class="bg-light rounded pt-1 pb-1 p-2 ">{{ $user->userdetail->first()->prefer->title[App::getLocale()] ?? 'غير محدد' }}</div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6">
                                        <h2 class="mb-3">نوع الدوام</h2> 
                                        <ul class="list-inline m-0 flex-shrink-1">
                                            <li class="list-inline-item">
                                                <div class="bg-light rounded pt-1 pb-1 p-2 ">{{ $user->userdetail->first()->jobtype->title[App::getLocale()] ?? 'غير محدد' }}</div>
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


                                    <div class="cv-history">
                                        <h2 class="mb-3">الخبرات</h2>


                                        @if (count($user->experiences))
                                            @foreach ($user->experiences as $experience)

                                            <div class="cv-item pl-3 pb-3">
                                                <h2>{{$experience->position}}</h2>
                                                <p class="date mb-1">
                                                    {{$experience->company}} من <span>{{ Carbon\Carbon::parse($experience->start_date)->format('m-Y') }} </span>  الي <span> {{ Carbon\Carbon::parse($experience->end_date)->format('m-Y ') ?? 'الان'}} </span>
                                                </p>
                                                <p class="details">
                                                    {{$experience->desc ?? ''}}
                                                </p>
                                            </div>

                                            @endforeach
                                        @else
                                            <p>لا يوجد اي خبرات مضافة لهذا العضو</p>
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
