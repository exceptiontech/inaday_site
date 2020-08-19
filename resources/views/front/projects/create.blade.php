
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
                          {{ Form::open(['action' => 'ProjectController@store', 'files'=>true,'class'=>'formsignup','id'=>'contact']) }}
                            
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <label for="inputEmail4">{{ __('forms.project_name') }} <em>*</em></label>
                                        <input type="text" class="form-control" placeholder="{{ __('forms.project_name') }}">
                                    </div>
                                    <div class="col-6">
                                        <label for="inputEmail4">{{ __('forms.section') }} <em>*</em></label>
                        
                                        @if (count($sections))
                                          <select class="form-control" name="type">
                                              <option value="">{{ __('forms.section') }}</option>
                                                @foreach ($sections as $section)
                                                    <option value="{{ $section->id }}"> {{ @$section->title[App::getLocale()] }}</option>
                                                @endforeach
                                          </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="inputEmail4">{{ __('forms.project_desc') }} <em>*</em></label>
                                        <textarea class="form-control" placeholder="{{ __('forms.project_desc') }}"></textarea> 
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="inputEmail4">{{ __('forms.files') }} <em>*</em></label>
                                        <input type="file" class="form-control">
                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <div class="col-6">
                                        <label for="inputEmail4">{{ __('forms.applying_type') }} <em>*</em></label>
                                        <select class="form-control" name="type">
                                            @if (count($apply_kinds))
                                              @foreach ($apply_kinds as $apply_kind)
                                                <option value="{{ $apply_kind->id }}">{{ @$apply_kind->title[App::getLocale()]}}</option>
                                              @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="inputEmail4">{{ __('forms.num_team') }} <em>*</em></label>
                                        <input name="num_team" class="form-control required" type="number" min="1" placeholder="{{ __('forms.num_team') }}" value="1" required>
                                    </div>
                                    

                                </div>

                                

                                <div class="row mb-4">
                                    <div class="col-6">
                                        <label for="inputEmail4">{{trans('file.price_in_riyal')}} <em>*</em><sub>(تكلفة المشروع المتوقعة)</sub> </label>
                                        <input type="text" class="form-control" placeholder="{{trans('file.select_the_amount')}}">
                                    </div>
                                    <div class="col-6">
                                        <label for="inputEmail4">{{trans('file.select_the_accounting_method')}} <em>*</em></label>
                                        
                                        @if (count($cost_kinds))
                                          <select class="form-control" name="type">
                                            @foreach ($cost_kinds as $cost_kind)
                                              <option value="{{$cost_kind->id}}">{{  @$cost_kind->title[App::getLocale()] }}</option>
                                            @endforeach
                                          </select>
                                        @endif
                                    </div>
                                    <!-- <div class="col-3">
                                        <label for="inputEmail4">يوم/ ساعة</label>
                                        <select class="form-control" name="type">
                                            <option value="d">يوم</option>
                                            <option value="h">ساعة</option>
                                        </select>
                                    </div> -->
                                </div>

                                <div class="row mb-4">
                                    <div class="col-6">
                                        <label for="inputEmail4">{{trans('file.reward')}}</label>
                                        <input type="text" class="form-control" placeholder="">
                                    </div>
                                    <div class="col-6">
                                        <label for="inputEmail4">{{trans('file.distribution_method')}}</label>
                                       
                                        @if (count($reward_kinds))
                                          <select class="form-control" name="type">
                                            @foreach ($reward_kinds as $reward_kind)
                                              <option value="{{$reward_kind->id}}">{{  @$reward_kind->title[App::getLocale()] }}</option>
                                            @endforeach
                                          </select>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label for="inputEmail4">{{trans('file.criterion')}}</label>
                                        <textarea class="form-control" placeholder="{{trans('file.determine_the_condition_of_receiving_the_bonus')}}"></textarea> 
                                        <sub>
                                            {{trans('file.such_as_achievement_at_a_specific_time_a_specific_sales_number_etc')}}
                                        </sub>
                                    </div>
                                </div>

                                <div class="col-sm-12 inpusrach">
                                    <div class="select">
                                      <label>{{ __('forms.skills') }}<em>*</em></label>
                                      <div class="row">
                                        @if (count($skills))
                                          @foreach ($skills as $skill)
                                          <div class="col-sm-9 check-item">
                                            <div class="chicksign">
                                              <label class="che-box">
                                                <input
                                                  class="required"
                                                  type="checkbox"
                                                  id="experience"
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

                                <div class="col-sm-6 inpusrach">
                                    <label>{{ __('forms.other_skills') }}</label>
                                    <input name="skills[]" class="form-control" type="text" placeholder="{{ __('forms.other_skills') }}" required>
                                </div>

                                <div class="row mt-5 mb-3">
                                    <div class="col-12">
                                        <button class="btn btn-primary">اضافة المشروع</button>
                                    </div>
                                </div>
                            </form>

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