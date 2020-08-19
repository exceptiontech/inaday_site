@extends('layouts.register_layout')
@section('title')
{{__('file.add_team')}}
@endsection
@section('content')

<style>
  .steps
  {
    display: none !important;
    visibility: hidden;
  }
</style>
<section class="signup new-item">
  <div class="step-app">
    <div class="logo">
        <a href="{{ url('/') }}"> <img src="{{url('assets/images/logo.png') }}" alt="Inaday" title="Inaday"></a>
      </div>

    {{ Form::open(['action' => 'TeamController@store', 'files'=>true,'class'=>'formsignup','id'=>'contact']) }}

      <div>
        <h3></h3>
        <section>
          <div class="row">
            <div class="col-sm-5 rightbox">
              <div class="contant-item">
                <h4 class="titletext">  {{__('file.add_team')}}</h4>

              </div>
            </div>
            <!-- End rightbox -->
            <div class="col-sm-7 leftbox">
              <div class="row">

                <div class="col-sm-12">
                    <p style="text-align: center">
                    {{trans('file.you_are_a_service_provider_know_service_delivery_and_can_determine_all_project_requirements_from_time_to_cost')}}
                    </p>
                </div>
                <div class="col-sm-12">
                    <p style="text-align: center">
                    {{trans('file.determine_how_much_you_are_willing_to_invest_in_each_mission')}}
                    </p>
                </div>

              </div>
            </div>
          </div>
          <!-- End row -->
        </section>
        <!---------------------------2 ------------>
        <h3></h3>

        <section>
          <div class="row">
            <div class="col-sm-5 rightbox">
              <div class="contant-item">
                <h4 class="titletext">  {{__('file.add_team')}}</h4>
              </div>
            </div>
            <div class="col-sm-7 leftbox">
              <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @csrf
                <div class="col-sm-12 inpusrach">
                    {!! Form::label('title', trans('file.team_name')) !!}
                    {!! Form::text('title', old('title'), ['required', 'class' => 'form-control required','autofocus']) !!}

                  </div>
                  <div class="col-sm-12 inpusrach">
                      {!! Form::label('desc', trans('file.team_desc')) !!}
                      {!! Form::textarea('desc', null, 
                          array('required', 
                                'class'=>'textarea form-control', 
                                'placeholder'=>trans('file.team_desc'))) !!}
                  </div>
                  <div class="col-sm-12 inpusrach">
                    <label> {{ __('file.team_logo') }}<em>*</em></label>
                    <div class="input-group">
                      <label class="input-group-btn"><span class="btn btn-primary">{{ __('forms.image') }}
                          <input type="file" name="image"  style="display: none;"  required></span></label>
                      <input class="form-control required" type="text" required="required" readonly>
                    </div>
                  </div>
                  

                  <div class="chicksign">
                    <label class="che-box">
                      <input type="checkbox" id="accepted2" name="check" required="required"><span class="label-text"><em>*</em> {{trans('file.i_have_read_and_accept_the_policy_of_posting_services_and_all_the_terms_of_its_contract')}}
                        <a href="#" target="_blank"><em>*</em> {{trans('file.please_see_if_you_are_not')}}</a>
                      </span>
                    </label>
                  </div>
                  <div class="col-sm-12"> &nbsp;</div>

              </div>
            </div>
          </div>
        </section>
          </div>
        {{ Form::close() }}



      </div>
    </section>

@endsection
