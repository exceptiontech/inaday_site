@extends('layouts.inner')
@section('title')
تعديل البيانات
@endsection
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

                        <div class="col-12 title mb-5">
                            <h2>إضافة خدمة</h2>
                        </div>

                        <div class="col-12 col-sm-8">
                            
                            {{ Form::open(['action' => 'Account\ServiceController@store', 'files'=>true]) }}
                            
                            @if(count($errors) > 0)
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissable" >
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        {{ $error}}
                                    </div>
                                @endforeach
                            @endif

                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('title', trans('forms.service_name'))!!} <em class="text-danger">*</em>
                                        {!! Form::text('title', null, ['required','class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('title', trans('forms.service_section'))!!} <em class="text-danger">*</em>
                                        {!! Form::select('section_id',$sections->pluck('title.'.App::getLocale(),'id'), null,['required', 'class' => 'form-control']) !!} 
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12 col-sm-3">
                                        {!! Form::label('cost', trans('forms.service_cost'))!!} <em class="text-danger">*</em>
                                        {!! Form::text('cost', null, ['required','class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        {!! Form::label('duration', trans('forms.service_duration'))!!}
                                        {!! Form::text('duration', null, ['required','class' => 'form-control']) !!}

                                    </div>
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('img', trans('forms.service_image'))!!} <em class="text-danger">*</em>
                                        {!! Form::file('img', array( 'class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12 mt-5">
                                        {!! Form::label('img', trans('forms.service_desc'))!!} <em class="text-danger">*</em>
                                        {!! Form::textarea('desc',null, array('required','class'=>'textarea form-control', 'rows'=>'3', 'id'=>'desc')) !!}
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                      الخبرات <em class="text-danger">*</em>
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

                        <div class="col-12 col-sm-4">
                            <div class="bg-light dark p-3">
                                <div class="text-center mt-n5">
                                    <img src="{{url('images/lamp.svg')}}">
                                </div>
                                <p class="mt-5">
                                    - أنت مقدم خدمه و تعرف تقدم خدمه و تقدر تحدد كل متطلبات المشروع من وقت و تكلفة. حدد كم مستعد تستثمر في كل مهمة.
                                </p>
                                  <!-- <p class="mt-5">
                                      - أنت مقدم خدمه و تعرف تقدم خدمه و تقدر تحدد كل متطلبات المشروع من وقت و تكلفة. حدد كم مستعد تستثمر في كل مهمة.
                                  </p>
                                  <p class="mt-5">
                                      - أنت مقدم خدمه و تعرف تقدم خدمه و تقدر تحدد كل متطلبات المشروع من وقت و تكلفة. حدد كم مستعد تستثمر في كل مهمة.
                                  </p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>     
        </div>
    </div>
</div>
@endsection