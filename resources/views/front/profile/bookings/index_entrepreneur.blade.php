@extends('layouts.inner')
@section('title')
@endsection
@section('content')



    <div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">ادارة المشاريع</h2>
                </div>

                <div class="col-12">
                    <div class="bg-light mt-5 p-3  profile rounded">
                        <div class="row">

                            <div class="col-12  profile-head-menu mb-5">
                                @include('front.profile.parts.menu')
                            </div>

                            <div class="col-12 col-sm-8 profile-content services mb-5">

                                <!-- projects -->
                                <div class="col-12 sub-title mt-5">
                                    <h3 class="mb-3">طلبات المشاريع</h3>
                                </div>

                                @if(count(Auth::user()->bookings))

                                    @foreach(Auth::user()->bookings as $booking)

                                        @if($booking->project)
                                        <div class="col-12 service pb-3 pt-2">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <img class="img-fluid" src="{{ url($booking->project->image ?? '/assets/images/logo.png' ) }}">
                                                </div>
                                                <div class="col-sm-10">
                                                    <div class="row mb-2">
                                                        <div class="col-10">
                                                            <h2 class="mb-3">{{$booking->project->title}}</h2>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <ul class="list-inline m-0 flex-shrink-1">
                                                                <li class="list-inline-item">
                                                                    <div class="bg-light pt-1 pb-1 p-2 ">
                                                                        {{$booking->offer->user->first_name .' '. $booking->offer->user->last_name ?? ' بدون تصنيف'}}
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-5 text-right">
                                                            <a class="btn btn-secondary rounded" href="#">{{$booking->offer->price}} ريال</a>
                                                            <a class="btn btn-primary rounded" href="{{url('/bookings/'.$booking->id)}}">تفاصيل الطلب</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach

                                @endif

                                <!-- service -->
                                <div class="col-12 sub-title mt-5">
                                    <h3 class="mb-3">طلبات الخدمات</h3>
                                </div>

                                @if(count(Auth::user()->bookings))

                                    @foreach(Auth::user()->bookings as $booking)

                                        @if($booking->service)
                                        <div class="col-12 service pb-3 pt-2">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <img class="img-fluid" src="{{ url($booking->service->img ?? '/assets/images/logo.png' ) }}">
                                                </div>
                                                <div class="col-sm-10">
                                                    <div class="row mb-2">
                                                        <div class="col-10">
                                                            <h2 class="mb-3">{{$booking->service->title}}</h2>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <ul class="list-inline m-0 flex-shrink-1">
                                                                <li class="list-inline-item">
                                                                    <div class="bg-light pt-1 pb-1 p-2 ">
                                                                        {{$service->user->first_name .' '. $service->user->last_name ?? ' بدون تصنيف'}}
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-5 text-right">
                                                            <a class="btn btn-secondary rounded" href="#">{{$service->price}} ريال</a>
                                                            <a class="btn btn-primary rounded" href="{{url('/bookings/'.$booking->id)}}">تفاصيل الطلب</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach

                                @endif


                                <!-- service -->
                                <div class="col-12 sub-title mt-5">
                                    <h3 class="mb-3">طلبات الخلطات</h3>
                                </div>

                                @if(count(Auth::user()->bookings))

                                @foreach(Auth::user()->bookings as $booking)

                                    @if($booking->mixture)

                                    <div class="col-12 service pb-3 pt-2">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <img class="img-fluid" src="{{ url($booking->mixture->image ?? '/assets/images/logo.png' ) }}">
                                            </div>
                                            <div class="col-sm-10">
                                                <div class="row mb-2">
                                                    <div class="col-10">
                                                        <h2 class="mb-3">{{$booking->mixture->title}}</h2>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-7">
                                                        <ul class="list-inline m-0 flex-shrink-1">
                                                            <li class="list-inline-item">
                                                                <div class="bg-light pt-1 pb-1 p-2 ">
                                                                    {{$booking->mixture->team->title ?? ' بدون تصنيف'}}
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-5 text-right">
                                                        <a class="btn btn-secondary rounded" href="#">{{$booking->mixture->cost}} ريال</a>
                                                        <a class="btn btn-primary rounded" href="{{url('/bookings/'.$booking->id)}}">تفاصيل الطلب</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
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

