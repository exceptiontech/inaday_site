@extends('layouts.inner')
@section('title')
  {{__('file.servives_provider_register')}}
@endsection
@section('content')


    <div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">الخبرات</h2>
                </div>

                <div class="col-12">
                    <div class="bg-light mt-5 p-3  wrapper profile rounded">
                        <div class="row">

                            <div class="col-12  profile-head-menu mb-5">

                                @if(Auth::user() && Auth::user()->isServicesProvider() && Auth::user()->isActive())
                                    <ul class="list-inline ">
                                        <li class="list-inline-item"><a href="{{url('/account/services')}}">خدماتي</a></li>
                                        <li class="list-inline-item"><a href="{{url('/account/experiences')}}">خبراتي</a></li>
                                        <li class="list-inline-item"><a href="{{url('/account/portfolios')}}">معرض الاعمال</a></li>
                                        <li class="list-inline-item"><a href="{{url('/account/skills')}}">مهاراتي</a></li>
                                        <li class="list-inline-item"><a href="{{url('/account/reviews')}}">اراء العملاء</a></li>
                                        <li class="list-inline-item"><a href="{{url('/account/packages')}}">خلطاتي</a></li>
                                        <li class="list-inline-item"><a class="active" href="{{url('/account/team')}}">فريقي</a></li>
                                        <li class="list-inline-item"><a href="{{url('/account/teams')}}">الفرق المشارك بها</a></li>
                                        <li class="list-inline-item"><a  href="{{url('/account/bookings')}}">الطلبات</a></li>
                                        <li class="list-inline-item"><a href="{{url('/account/credit')}}">محفظتي</a></li>
                                    </ul>
                                @elseif(Auth::user() && Auth::user()->isEntrepreneur() && Auth::user()->isActive())
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="{{url('/account/profile/edit')}}">نبذة عني</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{url('/account/projects')}}">مشاريعي</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{url('/account/bookings')}}">الحجوزات</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{url('/account/notifications')}}">الاشعارات</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{url('/account/')}}">الاعدادات</a>
                                        </li>
                                    </ul>
                                @endif
                            </div>



                            <div class="col-12 col-sm-8 profile-content services mb-5">

                                <!-- services -->
                                <div class="col-12 sub-title mt-5">
                                    <h3 class="mb-3">فريقي</h3>
                                </div>
                                

                                @if(Auth::user()->team)
                                
                                <div class="col-12 service pb-3 pt-2">

                                    <div class="row">
                                        <div class="col-sm-2">
                                            <img class="img-fluid" src="{{url(Auth::user()->team->image ?? '/assets/images/logo.png')}}">
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="row mb-2">
                                                <div class="col-10">
                                                    <h2 class="mb-3">{{Auth::user()->team->title ?? 'فريق بدون اسم' }}</h2>
                                                </div>
                                                <div class="col-2 sociel text-right">
                                                    <a class="mr-2" href="{{url('account/teams/'.Auth::user()->team->id.'/edit')}}">
                                                        <img src="{{url('/images/edit.svg')}}">
                                                    </a>
                                                    <a class="" href="{{url('/account/teams/delete/'.Auth::user()->team->id)}}">
                                                        <img src="{{url('images/delete.svg')}}">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-8">

                                                    <div class="dropdown">
                                                        <button class="btn bg-light dropdown-toggle" type="button" id="memberWrapper" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        اعضاء الفريق
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="memberWrapper">
                                                            @if(count(Auth::user()->team->users)>0)
                                                                @foreach(Auth::user()->team->users as $user)
                                                                <a class="dropdown-item" href="{{url('user/'.$user->id)}}">
                                                                    {{$user->first_name. ' ' .$user->last_name}}
                                                                </a>
                                                                @endforeach
                                                            @else
                                                            <a class="dropdown-item"  href="#">لم يتم اضافة اي اعضاء للفريق</a>

                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <a class="btn btn-primary rounded" href="{{url('list/services_provider')}}">اضافة أعضاء للفريق</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @else
                                    <p>انت لا تمتلك فريق حتى الان كون فريقك الان </p>
                                @endif


                                @if(!Auth::user()->team)
                                <div class="col-12 mt-5 mb-5">

                                    {{ Form::open(['action' => 'Account\TeamController@store', 'files'=>true]) }}
                                        <div class="row mb-4">
                                            <div class="col-12 col-sm-6">
                                                {!! Form::label('title', trans('file.team_name')) !!}
                                                {!! Form::text('title', old('title'), ['required', 'class' => 'form-control required','autofocus']) !!}
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                {!! Form::label('team_image', trans('file.team_logo'))!!}
                                                {!! Form::file('image', array( 'class' => 'form-control')) !!}
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
                                                {!! Form::submit(trans('forms.add'), array('class'=>'btn btn-primary')) !!}
                                            </div>
                                        </div>
                                    {{ Form::close() }}
                                </div>

                                @endif

                            </div>




                            <div class="col-12 col-sm-4">
                                <div class="bg-light dark p-3">
                                    <div class="text-center mt-n5">
                                        <img src="{{url('/images/lamp.svg')}}">
                                    </div>
                                    <p class="mt-5">
                                        - أنت مقدم خدمه و تعرف تقدم خدمه و تقدر تحدد كل متطلبات المشروع من وقت و تكلفة. حدد كم مستعد تستثمر في كل مهمة.
                                    </p>
                                    <p class="mt-5">
                                        - أنت مقدم خدمه و تعرف تقدم خدمه و تقدر تحدد كل متطلبات المشروع من وقت و تكلفة. حدد كم مستعد تستثمر في كل مهمة.
                                    </p>
                                    <p class="mt-5">
                                        - أنت مقدم خدمه و تعرف تقدم خدمه و تقدر تحدد كل متطلبات المشروع من وقت و تكلفة. حدد كم مستعد تستثمر في كل مهمة.
                                    </p>
                                </div>
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

