
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



                <div class="bg-light mt-5 p-3 profile  wrapper rounded">
                    <div class="row">
                        <div class="col-12  profile-head-menu mb-5">

                            @include('front.profile.parts.menu')
                        </div>

                        <div class="col-12 title mb-5">
                            <h2>{{__('forms.add_project')}}</h2>
                        </div>

                        <div class="col-12 col-sm-8">
                          {{ Form::open(['action' => 'Account\ProjectController@store', 'files'=>true]) }}

                                @if(count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger alert-dismissable" >
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h6>{{ $error}}</h6>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="row mb-4">
                                    <div class="col-6">
                                        {!! Form::label('title', trans('forms.project_name'))!!} <em class="text-danger">*</em>
                                        {!! Form::text('title', null, ['required','class' => 'form-control']) !!} 
                                    </div>
                                    <div class="col-6">
                                        {!! Form::label('title', trans('forms.section'))!!} <em class="text-danger">*</em>
                                        {!! Form::select('section_id',$sections->pluck('title.'.App::getLocale(),'id'), null,['required', 'class' => 'form-control']) !!} 
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        {!! Form::label('desc', trans('forms.project_desc'))!!} <em class="text-danger">*</em>
                                        {!! Form::textarea('desc',null, array('class'=>'textarea form-control', 'rows'=>'3', 'id'=>'desc')) !!}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12"> 
                                        {!! Form::label('files', trans('forms.files'))!!}
                                        {!! Form::file('files', array( 'class' => 'form-control')) !!}
                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('applykind_id', trans('forms.applying_type'))!!}
                                        {!! Form::select('applykind_id',$applykinds->pluck('title.'.App::getLocale(),'id'), null,['required', 'class' => 'form-control']) !!} 
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('num_team', trans('forms.num_team'))!!} <em class="text-danger">*</em>
                                        {!! Form::text('num_team', 1, ['required','class' => 'form-control']) !!}
                                    </div>

                                </div>


                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('cost', trans('forms.cost'))!!} <sub>(تكلفة المشروع المتوقعة)</sub> <em class="text-danger">*</em><em class="text-danger">*</em>
                                        {!! Form::text('cost', null, ['required','class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        {!! Form::label('duration', trans('forms.duration'))!!} <em class="text-danger">*</em>
                                        {!! Form::text('duration', null, ['required','class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        {!! Form::label('duration_type', trans('forms.duration_type'))!!}
                                        {!! Form::select('costkind_id',$costkinds->pluck('title.'.App::getLocale(),'id') , null,['required', 'class' => 'form-control']) !!} 
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('reward', trans('forms.reward'))!!}
                                        {!! Form::text('reward', null, ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('rewardkind_id', trans('forms.rewardkind'))!!} 
                                        {!! Form::select('rewardkind_id',$rewardkinds->pluck('title.'.App::getLocale(),'id'), null,['class' => 'form-control','placeholder'=>'اختر طريقة المكافأة']) !!} 
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                      {!! Form::label('skills', trans('forms.skills'))!!} <em class="text-danger">*</em>
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
                                                    {{ @$skill->title[App::getLocale()] }}</span
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


                                <div class="row mb-4">
                                    <div class="col-12">
                                        {!! Form::label('rule', trans('forms.rule'))!!}
                                        {!! Form::textarea('rule',null, array('class'=>'textarea form-control', 'rows'=>'3', 'placeholder'=>'مثال: عند الانتهاء من المشروع في اقل من اسبوع')) !!}
                                    </div>
                                </div>


                                <div class="row mt-5 mb-3">
                                    <div class="col-12">
                                        {!! Form::submit(trans('forms.addproject'), array('class'=>'btn btn-primary')) !!}

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
@endsection