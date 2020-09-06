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
                    <div class="bg-light rounded pt-3 pb-3 p-2">
                      <div class="col-12">
                      <h2>صوتك مسموع</h2>
                      <p>كيف نقدر نخدمك، من خلال هذة الصفحة يمكنك التواصل معنا وابلاغنا بالمقترحات او الاستفسارات او المشاكل التي تواجهك، وسوف نتواصل معك في اقرب وقت ممكن.</p>

                    {{ Form::open(['action' => 'ContactusController@store']) }}

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
                        <div class="col-sm-6 form-group">
                          {!! Form::text('name', null, ['required', 'class' => 'form-control required','placeholder'=>trans('file.name')]) !!}

                        </div>
                        <div class="col-sm-6 form-group">
                          {!! Form::email('email', null, ['required', 'class' => 'form-control required','placeholder'=>trans('file.email')]) !!}
                        </div>
                        <div class="col-sm-6 form-group">
                          {!! Form::text('mobile', null, ['required', 'class' => 'form-control required','placeholder'=>trans('file.mobile')]) !!}
                        </div>
                        <div class="col-sm-6 form-group">
                          {!! Form::text('subject', null, ['required', 'class' => 'form-control required','placeholder'=>trans('file.subject')]) !!}
                        </div>
                        <div class="col-sm-12 form-group">
                          {!! Form::textarea('message', null, array('required','class'=>'textarea form-control','placeholder'=>trans('file.message'),'row'=>3)) !!}

                        </div>
                        <div class="col-sm-12 form-group">
                          {!! Form::submit(trans('file.send'), array('class'=>'btn btn-primary')) !!}

                        </div>
                      </div>
                      {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection



@section('jquery')

@endsection