@extends('layouts.inner')
@section('title')
  الخدمات
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

                                <!-- services -->
                                <div class="col-12 sub-title mt-5">
                                    <h3 class="mb-3">الخدمات المعروضة لي</h3>
                                </div>
                                

                                @if(count(Auth::user()->services))
                                    @foreach(Auth::user()->services as $service)
                                    <div class="col-12 service pb-3 pt-2">

                                        <div class="row">
                                            <div class="col-sm-2">
                                                <img class="img-fluid" src="{{ url($service->image ?? '/assets/images/logo.png' ) }}">
                                            </div>
                                            <div class="col-sm-10">
                                                <div class="row mb-2">
                                                    <div class="col-10">
                                                        <h2 class="mb-3">{{$service->title}}</h2>
                                                    </div>
                                                    <div class="col-2 sociel text-right">
                                                        <a class="mr-2" href="{{url('account/services/'.$service->id.'/edit/')}}">
                                                            <img src="{{url('images/edit.svg')}}">
                                                        </a>
                                                        <a class="" href="{{url('/account/services/delete/'.$service->id)}}">
                                                            <img src="{{url('images/delete.svg')}}">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-8">
                                                        <ul class="list-inline m-0 flex-shrink-1">
                                                            <li class="list-inline-item">
                                                                <div class="bg-light pt-1 pb-1 p-2 ">
                                                                    {{$service->section->title[App::getLocale()] ?? ' بدون تصنيف'}}
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-4 text-right">
                                                        <a class="btn btn-secondary rounded" href="#">{{$service->cost}} ريال</a>
                                                        <a class="btn btn-primary rounded" href="{{url('/services/'.$service->id)}}">تفاصيل الخدمة</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach
                                @else
                                    <p>لم تقم باضافة اي خدمات في الوقت الحالي</p>
                                @endif




                                <div class="col-12 mt-5 mb-5">

                                    {{ Form::open(['action' => 'Account\ServiceController@store', 'files'=>true]) }}
                                    
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
                                                {!! Form::label('title', trans('forms.service_name'))!!}
                                                {!! Form::text('title', null, ['required','class' => 'form-control']) !!}
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                {!! Form::label('title', trans('forms.service_section'))!!}
                                                {!! Form::select('section_id',$sections->pluck('title.'.App::getLocale(),'id'), null,['required', 'class' => 'form-control']) !!} 
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-12 col-sm-3">
                                                {!! Form::label('cost', trans('forms.service_cost'))!!}
                                                {!! Form::text('cost', null, ['required','class' => 'form-control']) !!}
                                            </div>
                                            <div class="col-12 col-sm-3">
                                                {!! Form::label('duration', trans('forms.service_duration'))!!}
                                                {!! Form::text('duration', null, ['required','class' => 'form-control']) !!}

                                            </div>
                                            <div class="col-12 col-sm-6">
                                                {!! Form::label('img', trans('forms.service_image'))!!}
                                                {!! Form::file('img', array( 'class' => 'form-control')) !!}
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-12 mt-5">
                                                {!! Form::label('img', trans('forms.service_desc'))!!}
                                                {!! Form::textarea('desc',null, array('class'=>'textarea form-control', 'rows'=>'3', 'id'=>'desc')) !!}
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-12">
                                              الخبرات
                                              <div class="row">
                                                @if (count($skills))
                                                  @foreach ($skills as $skill)
                                                  <div class="col-sm-6 check-item">
                                                    <div class="chicksign">
                                                      <label class="che-box">
                                                        <input
                                                          class="required"
                                                          type="checkbox"
                                                          name="skills[]"
                                                          value="{{$skill->id}}"
                                                        /><span class="label-text">
                                                            {{ @$skill->title[App::getLocale()] }}<em>*</em></span
                                                        >
                                                      </label>
                                                    </div>
                                                  </div>
                                                  @endforeach
                                                @endif
                                              </div>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-12">
                                              {!! Form::label('skills[]', trans('forms.other_skills'))!!}
                                              {!! Form::text('skills[]', null, ['class' => 'form-control']) !!}
                                            </div>
                                        </div>

                                        <div class="row mt-5 mb-3">
                                            <div class="col-12">
                                                {!! Form::submit(trans('forms.addservice'), array('class'=>'btn btn-primary')) !!}
                                            </div>
                                        </div>
                                    {{ Form::close() }}
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

