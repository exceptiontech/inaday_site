@extends('layouts.inner')
@section('title')
  {{__('file.servives_provider_register')}}
@endsection
@section('content')


    <div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">ادارة المشاريع</h2>
                </div>

                <div class="col-12">
                    <div class="bg-light mt-5 p-3  wrapper profile rounded">
                        <div class="row">

                            <div class="col-12  profile-head-menu mb-5">

                                @include('front.profile.parts.edit')
                            </div>



                            <div class="col-12 col-sm-12 profile-content galleries">
                                <div class="sub-title mb-5">
                                    <h2 class="dark mt-5 mb-4">الاعمال المعروضة</h2>
                                </div>

                                <div class="d-flex d-inline-flex mb-5">

                                @if(count(Auth::user()->portfolios))
                                    @foreach(Auth::user()->portfolios as $portfolio)
                                        <div class="position-relative">
                                            <a href="{{url('account/portfolios/delete/'.$portfolio->id)}}">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                            <img class="mr-2 img-icon120" src="{{url($portfolio->image)}}">
                                        </div>
                                    @endforeach
                                @else
                                    <p>لم تقم باضافة اي اعمال في الوقت الحالي</p>
                                @endif


                                </div>

                                <div class="sub-title mb-5">
                                    <h2 class="dark mt-5 mb-4">اضافة أعمال اخرى</h2>
                                </div>

                                <div class="col-12 mb-5">

                                    {{ Form::open(['action' => 'Account\PortfolioController@store', 'files'=>true]) }}

                                        @if(count($errors) > 0)
                                            @foreach ($errors->all() as $error)
                                                <div class="alert alert-danger alert-dismissable" >
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <h4>{{ $error}}</h4>
                                                </div>
                                            @endforeach
                                        @endif


                                        <div class="row mb-4">
                                            <div class="col-12 col-sm-6">
                                                {!! Form::label('title', trans('forms.title'))!!}
                                                {!! Form::text('title', null, ['class' => 'form-control']) !!}
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                {!! Form::label('url', trans('forms.url'))!!}
                                                {!! Form::text('url', null, ['class' => 'form-control','placeholder' => 'http://inaday.cloud']) !!}
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-12">
                                                {!! Form::label('image', trans('forms.image'))!!}
                                                {!! Form::file('image', array( 'class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-12">
                                                {!! Form::label('desc', trans('forms.desc'))!!}
                                                {!! Form::textarea('desc',null, array('class'=>'textarea form-control', 'rows'=>'3', 'id'=>'desc')) !!}
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

@endsection

