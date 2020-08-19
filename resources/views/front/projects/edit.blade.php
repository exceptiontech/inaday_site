@extends('layouts.inner')
@section('title')
{{__('file.projects')}}

@endsection
@section('content')
<section class="banner">
    <div class="container">
      <h1 class="title"> {{__('forms.edit')}} {{__('file.projects')}} </h1>
    </div>
  </section>


  <section class="signup">
    <div class="container">
      <div class="signupfilde">
        <h3 class="title">
            {{__('forms.edit')}} : <b>{{ $result->title }}</b>
        </h3>
        <form class="formsignup" action="{{ route('front_projects.update',$result->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
@if(count($errors) > 0)
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissable" >
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4>{{ $error}}</h4>
        </div>
    @endforeach
@endif
          <div class="row">
            <div class="col-sm-12 inpusrach">
                <label>{{ __('forms.project_name') }}<em>*</em></label>
                <input name="title" class="form-control required"  id="firstname"  value="{{ $result->title }}" type="text" placeholder="{{ __('forms.service_name') }}" autofocus required="required">
            </div>
            <div class="col-sm-12 inpusrach">
                <label> {{ __('forms.service_desc') }}</label>
                <textarea class="form-control required " name="desc" id="lastname" placeholder=" {{ __('forms.project_desc') }}" required="required">{{ $result->desc }} </textarea>
            </div>
            <div class="col-sm-6 inpusrach">
                <label> {{ __('forms.files') }}</label>
                <div class="input-group">
                  <label class="input-group-btn"><span class="btn btn-primary"> {{trans('file.browse')}}
                      <input type="file" name="files[]"  style="display: none;" multiple ></span></label>
                  <input class="form-control" type="text" readonly>
                </div>
              </div>
              <div class="col-sm-6 inpusrach">
                <div class="select">
                   <label>{{ __('forms.project_phase') }}<em>*</em></label>
                        @if (count($stages))
                        <select name="stage_id" class="form-control required" id="service" >
                            <option value="">{{ __('forms.project_phase') }}</option>
                            @foreach ($stages as $stage)
                                <option value="{{ $stage->id }}"  @if($stage->id == $result->stage_id) selected="" @endif> {{ @$stage->title[App::getLocale()] }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
              </div>
              <div class="col-sm-6 inpusrach">
                <div class="select">
                   <label>{{ __('forms.section') }}<em>*</em></label>
                        @if (count($sections))
                        <select name="section_id" class="form-control required" id="service" >
                            <option value="">{{ __('forms.section') }}</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}"  @if($section->id == $result->section_id) selected="" @endif> {{ @$section->title[App::getLocale()] }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
              </div>
              <div class="col-sm-3 inpusrach">
                <div class="select">
                   <label>{{ __('forms.applying_type') }}<em>*</em></label>
                    <select name="applykind_id" class="form-control required" id="service" >
                    @if (count($apply_kinds))
                      @foreach ($apply_kinds as $apply_kind)
                        <option value="{{ $apply_kind->id }}"  @if($apply_kind->id == $result->applykind_id) selected="" @endif>{{ @$apply_kind->title[App::getLocale()]}}</option>
                      @endforeach
                    @endif
                    </select>
                </div>
              </div>

              <div class="col-sm-3 inpusrach">
                <label>{{ __('forms.num_team') }}<em>*</em></label>
                <input name="num_team" class="form-control required" type="number" min="1"  value="{{ $result->num_team }}" placeholder="{{ __('forms.num_team') }}" value="1" required>
              </div>

              <div class="col-sm-6 inpusrach">
                <div class="select">
                  <label> {{trans('file.how_much_do_you_invest_basic')}}<em>*</em></label>
                      @if (count($averagekinds))
                      <select name="averagekind_id" class="form-control required" id="prefer_id" >
                        @foreach ($averagekinds as $averagekind)
                          <option value="{{$averagekind->id}}"  @if($averagekind->id == $result->averagekind_id) selected="" @endif>{{  @$averagekind->title[App::getLocale()] }}</option>
                        @endforeach
                      </select>
                    @endif
                </div>
              </div>
              <div class="col-sm-3 inpusrach">
                <label>{{trans('file.price_in_riyal')}}<em>*</em></label>
                <input class="form-control required" type="number" id="cost" name="cost"  value="{{ $result->cost }}" placeholder="{{trans('file.select_the_amount')}}" min="1"/>
              </div>
              <div class="col-sm-3 inpusrach">
                <div class="select">
                  <label>{{trans('file.select_the_accounting_method')}}<em>*</em></label>
                  @if (count($cost_kinds))
                      <select name="costkind_id" class="form-control required" id="prefer_id" >
                        @foreach ($cost_kinds as $cost_kind)
                          <option value="{{$cost_kind->id}}"  @if($cost_kind->id == $result->costkind_id) selected="" @endif>{{  @$cost_kind->title[App::getLocale()] }}</option>
                        @endforeach
                      </select>
                    @endif
                </div>
              </div>
              <div class="col-sm-3 inpusrach">
                <label> {{trans('file.reward')}}</label>
                <input class="form-control" type="number" id="amount" name="reward"  value="{{ $result->reward }}" placeholder="" min="1"/>
              </div>

              <div class="col-sm-6 inpusrach">
                <div class="select">
                  <label> {{trans('file.distribution_method')}}</label
                  >
                  @if (count($reward_kinds))
                      <select name="rewardkind_id" class="form-control" id="prefer_id" >
                        @foreach ($reward_kinds as $reward_kind)
                          <option value="{{$reward_kind->id}}"  @if($reward_kind->id == $result->rewardkind_id) selected="" @endif>{{  @$reward_kind->title[App::getLocale()] }}</option>
                        @endforeach
                      </select>
                    @endif
                </div>
              </div>
              <div class="col-sm-12 inpusrach">
                <label>{{trans('file.criterion')}}</label>
                <input class="form-control" type="text" id="standard" name="rule"  value="{{ $result->rule }}" placeholder="{{trans('file.determine_the_condition_of_receiving_the_bonus')}}"/>
                <p class="worning">
                  {{-- trans('file.such_as_achievement_at_a_specific_time_a_specific_sales_number_etc') --}}
                </p>
              </div>
              {{-- <div class="col-sm-12 inpusrach">
                <h1 style="font-size: 24px;line-height: 2;font-weight: bolder;"> {{ __('forms.phase_1text') }}</h1>
                <p>{{ __('forms.phase_1text2') }}</p>
              </div>
              <div class="col-sm-4 inpusrach">
                  <label>{{ __('forms.target_clients') }}<em>*</em></label>
                  <input name="target_clients" class="form-control required" type="number" min="1"  value="{{ $result->target_clients }}" required/>
              </div>
              <div class="col-sm-4 inpusrach">
                  <label>{{ __('forms.target_sales') }}<em>*</em></label>
                  <input name="target_sales" class="form-control required" type="number" min="1"  value="{{ $result->target_sales }}"  required/>
              </div>
              <div class="col-sm-4 inpusrach">
                  <label>{{ __('forms.target_profits') }}<em>*</em></label>
                  <input name="target_profits" class="form-control required" type="number" min="0"  value="{{ $result->target_profits }}" required/>
              </div>

              <div class="col-sm-6 inpusrach">
                  <div class="select">
                    <label > {{ __('forms.launching_in') }}<em>*</em></label>
                      @if (count($readiness_kinds))
                      <select name="readinesskind_id" class="form-control required" id="prefer_id" >
                        @foreach ($readiness_kinds as $readiness_kind)
                          <option value="{{$readiness_kind->id}}" @if($readiness_kind->id == $result->readinesskind_id) selected="" @endif>{{  @$readiness_kind->title[App::getLocale()] }}</option>
                        @endforeach
                      </select>
                    @endif
                  </div>
                </div>

                <div class="col-sm-3 inpusrach">
                  <label> {{ __('forms.launching_date') }}</label>
                  <input name="date" id="readiness_date"  value="{{ $result->date }}"  class="form-control" type="text"  autocomplete="off">
                </div> --}}
          </div>
          <div class="text-center">
              <input type="submit" class="bottom" name="submit" value="{{ __('forms.edit') }}" />
          </div>
        </form>
      </div>
    </div>
  </section>

@endsection
