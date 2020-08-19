@extends('layouts.register_layout')
@section('title')
{{__('file.add_servives')}}
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

    {{ Form::open(['action' => 'ServiceController@store', 'files'=>true,'class'=>'formsignup','id'=>'contact']) }}

      <div>
        <h3></h3>
        <section>
          <div class="row">
            <div class="col-sm-5 rightbox">
              <div class="contant-item">
                <h4 class="titletext">  {{__('forms.add_service')}}</h4>

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
                <h4 class="titletext">  {{__('forms.add_service')}}</h4>
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
                    <label>{{ __('forms.service_name') }}<em>*</em></label>
                    <input name="title" class="form-control required"  id="firstname"  value="{{ old('title') }}" type="text" placeholder="{{ __('forms.service_name') }}" autofocus required="required">
                  </div>
                  <div class="col-sm-12 inpusrach">
                    <label> {{ __('forms.service_desc') }}<em>*</em></label>
                    <textarea class="form-control required " name="desc" id="lastname" placeholder=" {{ __('forms.project_desc') }}" required="required"> </textarea>
                  </div>
                  <div class="col-sm-6 inpusrach">
                    <label> {{ __('forms.image') }}<em>*</em></label>
                    <div class="input-group">
                      <label class="input-group-btn"><span class="btn btn-primary">{{ __('forms.image') }}
                          <input type="file" name="img"  style="display: none;"  required></span></label>
                      <input class="form-control required" type="text" required="required" readonly>
                    </div>
                  </div>
                  <div class="col-sm-6 inpusrach">
                    <div class="select">
                       <label>{{ __('forms.section_service') }}<em>*</em></label><i class="fas fa-sort-down"></i>
                            @if (count($sections))

                            <select name="section_id" class="form-control required" id="service" required="required" >
                            <option value="">{{trans('file.select_category')}}</option>
                              @foreach ($sections as $section)
                                  <option value="{{ $section->id }}"> {{ @$section->title[App::getLocale()] }}</option>
                              @endforeach
                            </select>
                            @endif
                    </div>
                  </div>


                  <div class="col-sm-6 inpusrach">
                    <label>{{ __('forms.cost_2it').' ('.__('forms.cost').')' }}<em>*</em></label>
                    <input name="cost" class="form-control required" type="number" min="0" placeholder="{{ __('forms.cost_2it') }}" required="required">
                  </div>
                  <div class="col-sm-6 inpusrach">
                    <label>{{ __('forms.time_2finish').' ('.__('forms.by_hour').')' }}<em>*</em></label>
                    <input name="duration" class="form-control required" type="number" min="0" placeholder="{{ __('forms.time_2finish') }}" required="required">
                  </div>

                  {{-- <div class="col-sm-6 inpusrach">
                    <div class="select">
                      <label>{{ __('forms.your_skills') }}<em>*</em></label>
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
                                  required="required"
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
                    <label>{{ __('forms.othr_skills') }}<em>*</em></label>
                    <input name="skills[]" class="form-control" type="text" placeholder="{{ __('forms.other_skills') }}" required>
                  </div> --}}
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
        </form>



      </div>
    </section>

@endsection

@section('jquery')
  <script type="text/javascript">
    $('#brith_day,#readiness_date').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '-3d'
  });
  </script>
@endsection

