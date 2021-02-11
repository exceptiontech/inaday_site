@extends('layouts.inner')
@section('title')
  الخدمات
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
                                    <h3 class="mb-3">{{ __('file.my_services') }} </h3>
                                </div>
                                

                                @if(count(Auth::user()->services))
                                    @foreach(Auth::user()->services as $service)
                                    <div class="col-12 service pb-3 pt-2">

                                        <div class="row">
                                            <div class="col-12 col-sm-2 mb-2 mb-sm-0">
                                                <img class="img-fluid" src="{{ url($service->img ?? '/assets/images/logo.png' ) }}">
                                            </div>
                                            <div class="col-12 col-sm-10">
                                                <div class="row mb-2">
                                                    <div class="col-9 col-sm-10">
                                                        <h2 class="mb-3">{{$service->title}}
                                                            @if(!$service->is_approved)
                                                            <span class="badge badge-warning badge-pill">{{ __('file.under_confirm') }}</span>
                                                            @endif
                                                        </h2>
                                                    </div>
                                                    <div class="col-3 p-0 col-sm-2 sociel text-right">
                                                        <a class="mr-2" href="{{url('account/services/'.$service->id.'/edit/')}}">
                                                            <img src="{{url('images/edit.svg')}}">
                                                        </a>
                                                        <a class="" href="{{url('/account/services/delete/'.$service->id)}}">
                                                            <img src="{{url('images/delete.svg')}}">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-7 col-sm-6">
                                                        <ul class="list-inline m-0 flex-shrink-1">
                                                            <li class="list-inline-item">
                                                                <div class="bg-light pt-1 pb-1 p-2 ">
                                                                    {{$service->section->title[App::getLocale()] ?? ' بدون تصنيف'}}
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-5 col-sm-6 text-right text-sm-center p-0 mt-2 mt-sm-0">
                                                        <label class="btn btn-secondary rounded">{{$service->cost}} {{ __('file.riyal') }}</label>
                                                        <a class="btn btn-primary rounded" href="{{url('/services/'.$service->id)}}">{{ __('file.service_details') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach
                                @else
                                    <p>لم تقم باضافة اي خدمات في الوقت الحالي</p>
                                @endif



                                <div class="col-12 mt-4">
                                    <a href="{{url('/account/services/create')}}" class="btn btn-primary">{{ __('file.add_newـservice') }}</a>
                                </div>



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

