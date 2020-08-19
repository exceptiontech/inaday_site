@extends('layouts.inner')

@section('title')
  {{trans('file.contactus')}}
@endsection


@section('content')
<section class="banner">
  <div class="container">
    <h1 class="title">{{trans('file.contact_us')}}</h1>
  </div>
</section>


<section class="contactus">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 contac-ti">
        <div class="innercont">
          <h3 class="title">{{trans('file.contact_us')}}</h3>

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
              <div class="col-sm-6 inpudata">
                {!! Form::text('name', null, ['required', 'class' => 'form-control required','placeholder'=>trans('file.name')]) !!}

              </div>
              <div class="col-sm-6 inpudata">
                {!! Form::email('email', null, ['required', 'class' => 'form-control required','placeholder'=>trans('file.email')]) !!}
              </div>
              <div class="col-sm-6 inpudata">
                {!! Form::text('mobile', null, ['required', 'class' => 'form-control required','placeholder'=>trans('file.mobile')]) !!}
              </div>
              <div class="col-sm-6 inpudata">
                {!! Form::text('subject', null, ['required', 'class' => 'form-control required','placeholder'=>trans('file.subject')]) !!}
              </div>
              <div class="col-sm-12 inpudata">
                {!! Form::textarea('message', null, array('required','class'=>'textarea form-control','placeholder'=>trans('file.message'))) !!}

              </div>
              <div class="col-sm-12 inpudata">
                {!! Form::submit(trans('file.send'), array('class'=>'bottom')) !!}

          </div>
            </div>
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
