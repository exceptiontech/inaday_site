@extends('layouts.inner')
@section('title')
{{trans('file.contact_us')}}

@endsection
@section('content')
<div id="innerpage" class="pt-5 pb-5">
        <div class="container">
            <div class="row">

                <div class="col-12 title">
                    <h2 class="text-white mb-5">{{trans('file.contact_us')}}</h2>
                </div>



                <div class="col-12 ">
                    <div class="bg-light contact_us rounded pt-3 pb-3 p-2">
                      <div class="p-4 project">
                      <div class="block">
                      <h2 class="mb-3">{{trans('file.voice_heared')}}</h2>
                      <p>{{trans('file.voice_heared_desc')}} </p>

                    {{ Form::open(['action' => 'ContactusController@store','files'=>true]) }}

                      @if (Session::has('message'))
                        <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                              {{Session::get('message')}}
                        </div>
                      @endif


                      @if (count($errors) > 0)
                          <div class="alert alert-danger">
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif


                      <div class="row">
                        <div class="col-sm-4 form-group">
                            <label class="font-weight-bold mb-3">{{trans('file.message_department')}}  <em class="text-danger">*</em> </label>
                            {!! Form::select('department_id',$departments->pluck('title.'.App::getLocale(),'id'), null,['required', 'class' => 'form-control']) !!} 

                        </div>
                        <div class="col-sm-4 form-group">
                            <label class="font-weight-bold mb-3">{{trans('file.subject')}} <em class="text-danger">*</em> </label>
                            {!! Form::text('subject', null, ['required', 'class' => 'form-control required','placeholder'=>trans('file.subject')]) !!}
                        </div>

                        <div class="col-sm-12 form-group">
                            <label class="font-weight-bold mb-3">{{trans('file.message_content')}}  <em class="text-danger">*</em> </label>
                          {!! Form::textarea('message', null, array('required','class'=>'textarea form-control','placeholder'=>trans('file.message_type') ,'rows'=>3)) !!}

                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4 form-group">
                          <label class="font-weight-bold mb-3">{{trans('file.email')}} <em class="text-danger">*</em> </label>
                          {!! Form::email('email', null, ['required', 'class' => 'form-control required','placeholder'=>trans('file.email')]) !!}
                        </div>

                        <div class="col-sm-4 form-group">
                            <label class="font-weight-bold mb-3">{{trans('file.mobile')}} <em class="text-danger">*</em> </label>

                            {!! Form::text('mobile', null, ['required', 'class' => 'form-control required','placeholder'=>trans('file.mobile'),'onkeyup'=>'this.value=this.value.replace(/[^\d]/,"")']) !!}
                        </div>
                        <div class="col-sm-4 form-group">
                          <label class="font-weight-bold mb-3">{{trans('file.downloads')}}  </label>

                          <div class="input-group">
                            <span class="form-control overflow-hidden"></span>
                            <span class="input-group-btn">
                              <input name="file" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                              <span class="btn btn-light h-100 shadow" onclick="$(this).parent().find('input[type=file]').click();">{{trans('file.download')}}</span>
                            </span>
                          </div>
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-sm-12 form-group">
                          {!! Form::submit(trans('file.send_message'), array('class'=>'btn btn-primary')) !!}

                        </div>
                      </div>
                      {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection



@section('jquery')

@endsection