@extends('layouts.inner')
@section('title')
  {{__('file.servives_provider_register')}}
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

                            @include('front.profile.parts.menu')

                            </div>



                            <div class="col-12 col-sm-12 profile-content galleries">


                                <div class="sub-title mb-5">
                                    <h2 class="dark mt-5 mb-4">الخبرات المعروضة</h2>
                                </div>

                                    <div class="cv-history">
                                        @if (count(Auth::user()->experiences))
                                            @foreach (Auth::user()->experiences as $experience)

                                            <div class="cv-item pl-3 pb-3">
                                                <h2>{{$experience->position}}</h2>
                                                <p class="date mb-1">
                                                    {{$experience->company}} من <span>{{ Carbon\Carbon::parse($experience->start_date)->format('m-Y') }} </span>  الي <span> {{ Carbon\Carbon::parse(strtotime($experience->end_date))->format('m-Y ') ?? 'الان'}} </span>
                                                </p>
                                                <p class="details">
                                                    {{$experience->desc ?? ''}}
                                                </p>
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        <a href="{{url('/account/experiences/'.$experience->id.'/edit')}}" class="btn btn-primary">تعديل</a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a href="{{url('/account/experiences/delete/'.$experience->id)}}" class="btn btn-danger">حذف</a>
                                                    </li>
                                                </ul>
                                            </div>

                                            @endforeach
                                        @else
                                            <p>لا يوجد اي خبرات مضافة لهذا العضو</p>
                                        @endif
                                    </div>





                                <div class="col-12  pt-4 mb-5">

                                    <div class="bg-light light-dark d-inline p-2">
                                        <i class="fa fa-plus" aria-hidden="true"></i>  اضافة خبرات اخرى
                                    </div>

                                    <div class="sub-title mb-5">
                                        <h2 class="dark mt-5 mb-4">اضافة خبرات اخرى</h2>
                                    </div>

                                    {{ Form::open(['action' => 'Account\ExperienceController@store', 'files'=>true]) }}

                                        @if(count($errors) > 0)
                                            @foreach ($errors->all() as $error)
                                                <div class="alert alert-danger alert-dismissable" >
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <h6>{{ $error}}</h6>
                                                </div>
                                            @endforeach
                                        @endif


                                        <div class="row mb-4">
                                            <div class="col-12 col-sm-4">
                                                {!! Form::label('position', trans('forms.position'))!!}
                                                {!! Form::text('position', null, ['required','class' => 'form-control','placeholder'=>'مطور']) !!}
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                {!! Form::label('company', trans('forms.company'))!!}
                                                {!! Form::text('company', null, ['required','class' => 'form-control','placeholder'=>'شركة البعد الفني']) !!}
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                {!! Form::label('start_date', trans('forms.start_date'))!!}
                                                {!! Form::text('start_date', null, ['required','id' => 'start_date','class' => 'form-control','placeholder'=>'تاريخ البداية']) !!}
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                {!! Form::label('end_date', trans('forms.end_date'))!!}
                                                {!! Form::text('end_date', null, ['id' => 'end_date','class' => 'form-control','placeholder'=>'تاريخ النهاية']) !!}
                                            </div>

                                            <div class="col-12 mt-5">
                                                {!! Form::label('desc', trans('forms.skills'))!!}
                                                {!! Form::textarea('desc',null, array('class'=>'textarea form-control', 'rows'=>'3', 'id'=>'desc','placeholder'=>trans('forms.skills'))) !!}
                                            </div>

                                        </div>
                                        <div class="row mt-5 mb-3">
                                            <div class="col-12">
                                                {!! Form::submit(trans('forms.save'), array('class'=>'btn btn-primary')) !!}
                                            </div>
                                        </div>
                                    {{ Form::close() }}
                                </div>


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

