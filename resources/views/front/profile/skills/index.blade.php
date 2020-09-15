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

                                @include('front.profile.parts.edit')
                            </div>



                            <div class="col-12 col-sm-8 projects">
                                <div class="sub-title mb-2">
                                    <h3>المهارات</h3>
                                </div>
                                

                                @if(count(Auth::user()->skills))
                                    @foreach(Auth::user()->skills as $skill)
                                        <div class="col-12 project pb-3 pt-2">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <h2>{{$skill->title[App::getLocale()]}}</h2>
                                                </div>
                                                <div class="col-sm-3">
                                                    <a class="btn btn-block btn-danger rounded" href="{{ url('account/skills/'.$skill->id) }}">الغاء المهارة</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p>لم تقم باضافة اي خبرات في الوقت الحالي</p>
                                @endif
                                



                                <div class="col-12 mt-4">
                                    <a href="{{url('/account/profile/edit')}}" class="btn btn-primary">تعديل مهارة جديدة</a>
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

