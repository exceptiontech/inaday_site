@extends('layouts.inner')
@section('title')
{{__('file.services')}}

@endsection
@section('content')
<section class="banner">
    <div class="container">
      <h1 class="title"> {{__('forms.edit')}} {{__('file.services')}} </h1>
    </div>
  </section>


  <section class="signup">
    <div class="container">
      <div class="signupfilde">
        <div class="title-sig">

        </div>
        <form class="formsignup" action="{{ route('front_services.update',$result->id) }}" method="post" enctype="multipart/form-data">
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
                <label>{{ __('forms.service_name') }}<em>*</em></label>
                <input name="title" class="form-control required"  id="firstname"  value="{{ $result->title }}" type="text" placeholder="{{ __('forms.service_name') }}" autofocus required="required">
            </div>
            <div class="col-sm-12 inpusrach">
                <label> {{ __('forms.service_desc') }}</label>
                <textarea class="form-control required " name="desc" id="lastname" placeholder=" {{ __('forms.project_desc') }}" required="required">{{ $result->desc }} </textarea>
            </div>
            <div class="col-sm-6 inpusrach">
                <label> {{ __('forms.image') }}<em>*</em></label>
                <div class="input-group">
                  <label class="input-group-btn"><span class="btn btn-primary">{{ __('forms.image') }}
                      <input type="file" name="img"  style="display: none;" ></span></label>
                  <input class="form-control" type="text"  readonly>
                </div>
            </div>
            <div class="col-sm-6 inpusrach">
                <div class="select">
                    <label>{{ __('forms.section_service') }}<em>*</em></label><i class="fas fa-sort-down"></i>
                         @if (count($sections))

                         <select name="section_id" class="form-control required" id="service" required="required" >
                         <option value="">{{trans('file.select_category')}}</option>
                           @foreach ($sections as $section)
                               <option value="{{ $section->id }}" @if ($section->id == $result->section_id) selected="" @endif> {{ @$section->title[App::getLocale()] }}</option>
                           @endforeach
                         </select>
                         @endif
                 </div>
            </div>
            <div class="col-sm-6 inpusrach">
                <label>{{ __('forms.cost_2it').' ('.__('forms.cost').')' }}<em>*</em></label>
                <input name="cost" class="form-control required" type="number" min="0" value="{{ $result->cost }}" placeholder="{{ __('forms.cost_2it') }}" required="required">
            </div>
            <div class="col-sm-6 inpusrach">
                <label>{{ __('forms.time_2finish').' ('.__('forms.by_hour').')' }}<em>*</em></label>
                <input name="duration" class="form-control required" type="number" min="0" value="{{ $result->duration }}" placeholder="{{ __('forms.time_2finish') }}" required="required">
            </div>
          </div>
          <div class="text-center">
              <input type="submit" class="bottom" name="submit" value="{{ __('forms.edit') }}" />
          </div>
        </form>
      </div>
    </div>
  </section>

@endsection
