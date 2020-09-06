
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


                <div class="bg-light mt-5 p-3  wrapper rounded">
                    <div class="row">
                        <div class="col-12 title mb-5">
                            <h2>{{__('forms.add_project')}}</h2>
                        </div>

                        <div class="col-12 col-sm-8">
                          {{ Form::open(['action' => 'Account\ProjectController@store', 'files'=>true]) }}
                            
                                <div class="row mb-4">
                                    <div class="col-6">
                                        {!! Form::label('title', trans('forms.project_name'))!!}
                                        {!! Form::text('title', null, ['required','class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-6">
                                        {!! Form::label('title', trans('forms.section'))!!}
                                        {!! Form::select('section_id',$sections->pluck('title.'.App::getLocale(),'id'), null,['required', 'class' => 'form-control']) !!} 
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        {!! Form::label('desc', trans('forms.project_desc'))!!}
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
                                        {!! Form::label('num_team', trans('forms.num_team'))!!}
                                        {!! Form::text('num_team', 1, ['required','class' => 'form-control','placeholder'=>'1']) !!}
                                    </div>

                                </div>


                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('cost', trans('forms.cost'))!!} <sub>(تكلفة المشروع المتوقعة)</sub>
                                        {!! Form::text('cost', null, ['required','class' => 'form-control','placeholder'=>'1000']) !!}
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        {!! Form::label('duration', trans('forms.duration'))!!}
                                        {!! Form::text('duration', null, ['required','class' => 'form-control','placeholder'=>'1']) !!}
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        {!! Form::label('duration_type', trans('forms.duration_type'))!!}
                                        {!! Form::select('costkind_id',$costkinds->pluck('title.'.App::getLocale(),'id') , null,['required', 'class' => 'form-control']) !!} 
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('reward', trans('forms.reward'))!!}
                                        {!! Form::text('reward', null, ['class' => 'form-control','placeholder'=>'1']) !!}
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('rewardkind_id', trans('forms.rewardkind'))!!}
                                        {!! Form::select('rewardkind_id',$rewardkinds->pluck('title.'.App::getLocale(),'id'), null,['required', 'class' => 'form-control']) !!} 
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                      {!! Form::label('skills', trans('forms.skills'))!!}
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


                                <div class="row mb-4">
                                    <div class="col-12">
                                        {!! Form::label('rule', trans('forms.rule'))!!}
                                        {!! Form::textarea('rule',null, array('class'=>'textarea form-control', 'rows'=>'3', 'placeholder'=>'مثال: عند الانتهاء من المشروع في اقل من اسبوع')) !!}
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                      <div class="title mb-5">
                                          <h2>{{ __('forms.phase_1text') }}</h2>
                                          <p>{{ __('forms.phase_1text2') }}</p>
                                      </div>
                                      <div class="row">
                                        <div class="col-sm-4 inpusrach">
                                            <label>{{ __('forms.target_clients') }}<em>*</em></label>
                                            <input name="target_clients" class="form-control required" type="number" min="1" value="1" required>
                                        </div>
                                        <div class="col-sm-4 inpusrach">
                                            <label>{{ __('forms.target_sales') }}<em>*</em></label>
                                            <input name="target_sales" class="form-control required" type="number" min="1" value="1"  required>
                                        </div>
                                        <div class="col-sm-4 inpusrach">
                                            <label>{{ __('forms.target_profits') }}<em>*</em></label>
                                            <input name="target_profits" class="form-control required" type="number" min="0" value="1" required>
                                        </div>
                                      </div>
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