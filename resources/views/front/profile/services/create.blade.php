@extends('layouts.inner')
@section('title')
تعديل البيانات
@endsection
@section('content')
<div id="innerpage" class="pt-4 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12 title">
                <h2 class="text-white mb-5">{{ __('file.services_managment') }}</h2>
            </div>

            <div class="col-12">

                <div class="bg-light mt-5 p-3  profile rounded">
                    <div class="row">
                        <div class="col-12  profile-head-menu mb-5">

                        @include('front.profile.parts.menu')

                        </div>

                        <div class="col-12 title mb-5">
                            <h2>{{ __('file.add_newـservice') }}</h2>
                        </div>

                        <div class="col-12 col-sm-8">
                            @if (Session::has('message'))
                              <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                                    {{Session::get('message')}}
                              </div>
                            @endif

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
                                        {!! Form::select('section_id',$sections->pluck('title.'.App::getLocale(),'id'), null,['required', 'class' => 'form-control','placeholder'=>trans('file.choose')]) !!} 
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12 col-sm-3">
                                        {!! Form::label('cost', trans('forms.service_cost'))!!} <em class="text-danger">*</em>
                                        {!! Form::text('cost', null, ['required','class' => 'form-control','onkeyup'=>'this.value=this.value.replace(/[^\d]/,"")']) !!}
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        {!! Form::label('duration', trans('forms.service_duration'))!!}
                                        {!! Form::text('duration', null, ['required','class' => 'form-control','onkeyup'=>'this.value=this.value.replace(/[^\d]/,"")']) !!}

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
                                    {!! Form::label('skills', trans('forms.skills'))!!}
                                    @if (count($skills))
                                      <div class="row">
                                        @foreach($skills as $skill)
                                          <div class="col-sm-6 check-item">
                                            <div class="chicksign">
                                                <label class="che-box">
                                                <input @if(is_array(old('skills')) && in_array($skill->id,old('skills'))) checked @endif
                                                  name="skills[]" type="checkbox" value="{{$skill->id}}"> <span class="label-text">
                                                  {{$skill->title[App::getLocale()]}} <em>*</em></span>
                                                </label>
                                            </div>
                                        </div>

                                        @endforeach
                                    </div>
                                    @endif
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                      {!! Form::label('skills[]', trans('forms.other_skills'))!!}
                                      {!! Form::text('other_skill', null, ['class' => 'form-control']) !!}
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
                            @include('front.profile.parts.service_provider')

                        </div> 

                    </div>
                </div>
            </div>     
        </div>
    </div>
</div>
@endsection