@extends('layouts.inner')
@section('title')
  {{__('file.servives_provider_register')}}
@endsection
@section('content')


    <div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">إدارة المشاريع</h2>
                </div>

                <div class="col-12">
                    <div class="bg-light mt-5 p-3  wrapper profile  services rounded">
                        <div class="row">

                            <div class="col-12  profile-head-menu mb-5">

                                @include('front.profile.parts.menu')
                            </div>

                            <div class="col-12 title mb-3">
                                <h2>المشاريع المعتمدة <span class="badge badge-warning badge-pill">{{count(Auth::user()->BookedProjects())}}</span></h2>
                            </div>

                            

                            <div class="col-12 col-sm-8 projects">
                                <div class="sub-title mb-2">
                                    <h3>المشاريع</h3>
                                </div>
                                

                                @if(count(Auth::user()->projects))
                                    @foreach(Auth::user()->projects as $project)
                                    <div class="col-12 service pb-3 pt-2">

                                        <div class="row">
                                            <div class="col-sm-2">
                                                <img class="img-fluid" src="{{ url($service->img ?? '/assets/images/logo.png' ) }}">
                                            </div>
                                            <div class="col-sm-10">
                                                <div class="row mb-2">
                                                    <div class="col-10">
                                                        <h2 class="mb-3">{{$project->title}}</h2>
                                                    </div>
                                                    <div class="col-2 sociel text-right">
                                                        <a class="mr-2" href="{{url('account/projects/'.$project->id.'/edit/')}}">
                                                            <img src="{{url('images/edit.svg')}}">
                                                        </a>
                                                        <a class="" href="{{url('/account/projects/delete/'.$project->id)}}">
                                                            <img src="{{url('images/delete.svg')}}">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-7">
                                                        <ul class="list-inline m-0 flex-shrink-1">
                                                            <li class="list-inline-item">
                                                                <div class="bg-light pt-1 pb-1 p-2 ">
                                                                    {{$project->section->title[App::getLocale()] ?? ' بدون تصنيف'}}
                                                                </div>
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                                {{ Carbon\Carbon::parse(strtotime($project->created_at))->format('d-m-Y') }}
                                                            </li>
                                                            <li class="list-inline-item">
                                                                <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>
                                                                {{$project->offers->count()}}  عرض
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-5 text-right">
                                                        <label class="btn btn-secondary rounded text-white">{{$project->cost}} ريال</label>
                                                        <a class="btn btn-primary rounded" href="{{url('/projects/'.$project->id)}}">تفاصيل المشروع</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach
                                @else
                                    <p>لم تقم باضافة اي مشاريع في الوقت الحالي</p>
                                @endif
                                



                                <div class="col-12 mt-4">
                                    <a href="{{url('/account/projects/create')}}" class="btn btn-primary">اضافة مشروع جديد</a>
                                </div>
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

