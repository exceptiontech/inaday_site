@extends('layouts.inner')
@section('title')
@endsection
@section('content')
<div id="innerpage" class="pt-4 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12 title">
                <h2 class="text-white mb-5">الخبرات</h2>
            </div>

            <div class="col-12">
                <div class="bg-light mt-5 p-3  profile rounded">
                    <div class="row">
                        <div class="col-12  profile-head-menu mb-5">

                        @include('front.profile.parts.edit')

                        </div>

                        <div class="col-12 col-sm-8">

                            {{ Form::model($experience, array('route' => array('front_experiences.update', $experience->id), 'method' => 'PUT')) }}

                                @if(count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger alert-dismissable" >
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h4>{{ $error}}</h4>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('position', trans('forms.position'))!!}
                                        {!! Form::text('position', $experience->position, ['required','class' => 'form-control','placeholder'=>'مطور']) !!}
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('company', trans('forms.company'))!!}
                                        {!! Form::text('company', $experience->company, ['required','class' => 'form-control','placeholder'=>'شركة البعد الفني']) !!}
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('start_date', trans('forms.start_date'))!!}
                                        {!! Form::text('start_date', $experience->start_date, ['required','id' => 'start_date','class' => 'form-control','placeholder'=>'تاريخ البداية']) !!}
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('end_date', trans('forms.end_date'))!!}
                                        {!! Form::text('end_date', $experience->end_date, ['id' => 'end_date','class' => 'form-control','placeholder'=>'تاريخ النهاية']) !!}
                                    </div>

                                    <div class="col-12 mt-5">
                                        {!! Form::label('desc', trans('forms.skills'))!!}
                                        {!! Form::textarea('desc',$experience->desc, array('class'=>'textarea form-control', 'rows'=>'3', 'id'=>'desc','placeholder'=>trans('forms.skills'))) !!}
                                    </div>
                                </div>
                                <div class="row mt-5 mb-3">
                                    <div class="col-12">
                                        {!! Form::submit(trans('forms.edit'), array('class'=>'btn btn-primary')) !!}

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


@section('jquery')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.ar.min.js"></script>

<script type="text/javascript">
    $('#start_date').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    });

    $('#end_date').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    });

</script>

@endsection