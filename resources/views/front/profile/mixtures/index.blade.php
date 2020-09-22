@extends('layouts.inner')
@section('content')

    <div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">ادارة الخدمات</h2>
                </div>

                <div class="col-12">
                    <div class="bg-light mt-5 p-3  profile rounded">
                        <div class="row">

                            <div class="col-12  profile-head-menu mb-5">
                                @include('front.profile.parts.menu')
                            </div>

                            <div class="col-12 col-sm-8 profile-content services mb-5">

                                <!-- mixtures -->
                                

                                @if(count(Auth::user()->myteams))
                                @foreach(Auth::user()->myteams as $team)
                                <div class="col-12 sub-title mt-5">
                                    <h3 class="mb-3">خلطات فريق  {{$team->title}}</h3>
                                </div>

                                @if(count($team->mixtures))
                                    @foreach($team->mixtures as $mixture)
                                    <div class="col-12 service pb-3 pt-2">

                                        <div class="row">
                                            <div class="col-sm-2">
                                                <img class="img-fluid" src="{{ url($mixture->image ?? '/assets/images/logo.png' ) }}">
                                            </div>
                                            <div class="col-sm-10">
                                                <div class="row mb-2">
                                                    <div class="col-10">
                                                        <h2 class="mb-3">{{$mixture->title}}</h2>
                                                    </div>
                                                    <div class="col-2 sociel text-right">
                                                        <a class="mr-2" href="{{url('account/mixtures/'.$mixture->id.'/edit/')}}">
                                                            <img src="{{url('images/edit.svg')}}">
                                                        </a>
                                                        <a class="" href="{{url('/account/mixtures/delete/'.$mixture->id)}}">
                                                            <img src="{{url('images/delete.svg')}}">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <ul class="list-inline m-0 flex-shrink-1">
                                                            <li class="list-inline-item">
                                                                <div class="bg-light pt-1 pb-1 p-2 ">
                                                                    {{$mixture->section->title[App::getLocale()] ?? ' بدون تصنيف'}}
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-6 text-right">
                                                        <label class="btn btn-secondary rounded">{{$mixture->cost}} ريال</label>
                                                        <a class="btn btn-primary rounded" href="{{url('/mixtures/'.$mixture->id)}}">تفاصيل الخلطة</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach
                                    <a  href="{{url('/account/mixtures/create/'.$team->id)}}" class="btn btn-sm btn-primary mt-3">اضافة خلطة جديدة لفريق {{$team->title}}</a>
                                @else
                                    <p>لم تقم باضافة اي خلطة في الوقت الحالي في هذا الفريق
                                        
                                    </p>
                                    <p>
                                        <a href="{{url('/account/mixtures/create/'.$team->id)}}" class="btn btn-sm btn-primary">اضافة خلطة جديدة لفريق {{$team->title}}</a>
                                    </p>
                                @endif

                                @endforeach
                                @else
                                    <p>لا توجد اي خلطات في هذا الفريق قم باضافة خلطة</p>
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

