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
                                        <li class="list-inline-item"><a href="{{url('/account/team')}}">فريقي</a></li>
                                        <li class="list-inline-item"><a class="active"  href="{{url('/account/teams')}}">الفرق المشارك بها</a></li>
                                        <li class="list-inline-item"><a href="{{url('/account/bookings')}}">الطلبات</a></li>
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

                            @if (Session::has('message'))
                            <div class="col-12">
                              <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                                    <h6>{{Session::get('message')}}</h6>
                              </div>
                            </div>
                            @endif


                            <div class="col-12 col-sm-8 profile-content services mb-5">

                                {{ Form::model($team, array('route' => array('front_teams.update', $team->id), 'method' => 'PUT')) }}

                                    @if(count($errors) > 0)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger alert-dismissable" >
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <h4>{{ $error}}</h4>
                                            </div>
                                        @endforeach
                                    @endif

                                        <div class="row mb-4">
                                            <div class="col-12 col-sm-6">
                                                {!! Form::label('title', trans('file.team_name')) !!}
                                                {!! Form::text('title', $team->title, ['required', 'class' => 'form-control required','autofocus']) !!}
                                            </div>
                                            <div class="col-12 col-sm-6 d-flex align-middle">
                                                @if($team->image)
                                                    <div class="col-3 d-flex align-middle">
                                                        <img class="img-fluid" src="{{url('/'.$team->image)}}">
                                                    </div>
                                                    <div class="col-9">
                                                        {!! Form::label('team_image', trans('file.team_logo'))!!}
                                                        {!! Form::file('image', array( 'class' => 'form-control')) !!}
                                                    </div>
                                                @else
                                                    {!! Form::label('team_image', trans('file.team_logo'))!!}
                                                    {!! Form::file('image', array( 'class' => 'form-control')) !!}
                                                @endif
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
                                                {!! Form::submit(trans('forms.edit'), array('class'=>'btn btn-primary')) !!}
                                            </div>
                                        </div>
                                    {{ Form::close() }}

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