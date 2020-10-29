@extends('layouts.inner')
@section('title')
@endsection
@section('content')



    <div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">{{ __('file.services_managment') }}</h2>
                </div>

                <div class="col-12">
                    <div class="bg-light mt-5 p-3  profile rounded">
                        <div class="row">

                            <div class="col-12  profile-head-menu mb-5">
                                @include('front.profile.parts.menu')
                            </div>

                            <div class="col-12 col-sm-8 profile-content services mb-5">

                                <!-- services -->
                                <div class="col-12 sub-title mt-5">
                                    <h3 class="mb-3">{{ __('file.my_bookings') }}</h3>
                                </div>

                                <!-- projects -->
                                <div class="col-12 sub-title mt-5">
                                    <h3 class="mb-3">{{ __('file.my_projects_bookings') }}</h3>
                                </div>

                                @if(count(Auth::user()->ProjectOrders()))

                                    @foreach(Auth::user()->ProjectOrders() as $booking)

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
                                                                    {{$booking->user->first_name .' '. $booking->user->last_name ?? ' بدون تصنيف'}}
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-5 text-right">
                                                        <a class="btn btn-secondary rounded" href="#">{{$booking->offer->price}} {{ __('file.riyal') }}</a>
                                                        <a class="btn btn-primary rounded" href="{{url('/bookings/'.$booking->id)}}">{{ __('file.order_details') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="col-12">
                                        <p>{{ __('file.you_dont_have_projects_bookings') }}</p>
                                    </div>
                                @endif


                                <!-- services -->
                                <div class="col-12 sub-title mt-5">
                                    <h3 class="mb-3">{{ __('file.my_services_bookings') }}</h3>
                                </div>


                                @if(count(Auth::user()->ServiceOrders()))
                                    @foreach(Auth::user()->ServiceOrders() as $booking)
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
                                                                    {{$booking->user->first_name .' '. $booking->user->last_name ?? ' بدون تصنيف'}}
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-5 text-right">
                                                        <a class="btn btn-secondary rounded" href="#">{{$booking->service->cost}} {{ __('file.riyal') }}</a>
                                                        <a class="btn btn-primary rounded" href="{{url('/bookings/'.$booking->id)}}">{{ __('file.order_details') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="col-12">
                                        <p>{{ __('file.you_dont_have_services_bookings') }}</p>
                                    </div>
                                @endif

                                <!-- mixtures -->
                                <div class="col-12 sub-title mt-5">
                                    <h3 class="mb-3">{{ __('file.my_mixtures_bookings') }}</h3>
                                </div>
                                @if(count(Auth::user()->MixtureOrders()))
                                    @foreach(Auth::user()->MixtureOrders() as $booking)

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
                                                        <a class="btn btn-secondary rounded" href="#">{{$booking->mixture->cost}} {{ __('file.riyal') }}</a>
                                                        <a class="btn btn-primary rounded" href="{{url('/bookings/'.$booking->id)}}">{{ __('file.order_details') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="col-12">

                                        <p>
                                            {{ __('file.you_dont_have_mixtures_bookings') }}

                                    </div>

                                @endif


                            </div>

                            <div class="col-12 col-sm-4">
                                @include('front.profile.parts.service_provider')

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

