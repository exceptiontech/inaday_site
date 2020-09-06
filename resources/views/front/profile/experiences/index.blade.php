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
                    <div class="bg-light mt-5 p-3  wrapper profile rounded">
                        <div class="row">

                            <div class="col-12  profile-head-menu mb-5">

                                @if(Auth::user() && Auth::user()->isServicesProvider() && Auth::user()->isActive())
                                    <ul class="list-inline ">
                                        <li class="list-inline-item"><a href="{{url('/account/services')}}">خدماتي</a></li>
                                        <li class="list-inline-item"><a class="active" href="{{url('/account/experiences')}}">خبراتي</a></li>
                                        <li class="list-inline-item"><a href="{{url('/account/portfolios')}}">معرض الاعمال</a></li>
                                        <li class="list-inline-item"><a  href="{{url('/account/skills')}}">مهاراتي</a></li>
                                        <li class="list-inline-item"><a href="{{url('/account/reviews')}}">اراء العملاء</a></li>
                                        <li class="list-inline-item"><a href="{{url('/account/packages')}}">خلطاتي</a></li>
                                        <li class="list-inline-item"><a href="{{url('/account/team')}}">فريقي</a></li>
                                        <li class="list-inline-item"><a href="{{url('/account/teams')}}">الفرق المشارك بها</a></li>
                                        <li class="list-inline-item"><a  href="{{url('/account/bookings')}}">الطلبات</a></li>
                                        <li class="list-inline-item"><a href="{{url('/account/credit')}}">محفظتي</a></li>
                                    </ul>
                                @elseif(Auth::user() && Auth::user()->isEntrepreneur() && Auth::user()->isActive())
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="{{url('/account/profile/edit')}}">نبذة عني</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{url('/account/projects')}}">مشاريعي</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{url('/account/bookings')}}">الحجوزات</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{url('/account/notifications')}}">الاشعارات</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{url('/account/')}}">الاعدادات</a>
                                        </li>
                                    </ul>
                                @endif
                            </div>



                            <div class="col-12 col-sm-12 profile-content galleries">


                                <div class="sub-title mb-5">
                                    <h2 class="dark mt-5 mb-4">الخبرات المعروضة</h2>
                                </div>


                                @if(count(Auth::user()->experiences))
                                    @foreach(Auth::user()->experiences as $experience)

                                    <div class="col-12 bg-light light-dark pt-4 mb-5">

                                        <div class="row mb-4">
                                            <div class="col-12 col-sm-4">
                                                <label class="col-12 mb-3" for="inputEmail4">اسم المهنة</label>
                                                <input type="text" class="form-control" placeholder=" UI/ UX Designer">
                                            </div>
                                            <div class="col-12 col-sm-4">
                                                <label class="col-12 mb-3" for="inputEmail4">اسم الشركة</label>
                                                <input type="text" class="form-control" placeholder=" شركة البعد الفني">
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                <label class="col-12 mb-3" for="inputEmail4">خلال الفترة من</label>
                                                <input type="text" class="form-control" placeholder=" July 2018">
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                <label class="col-12 mb-3" for="inputEmail4">الي</label>
                                                <input type="text" class="form-control" placeholder=" July 2020">
                                            </div>

                                            <div class="col-12 mt-5">
                                                <label class="col-12 mb-3" for="inputEmail4">المهارات التى تؤديها</label>
                                                <textarea class="form-control" placeholder="المهارات التى تؤديها">خبرة بتصميم واجهات استخدام متجاوبة ومتوافقة مع جميع الاجهزة. تقديم الاقتراحات والافكار لانجاز العمل بطريقة مختلفة اذا كانت الآلية المقترحة لاتتناسب مع نوع التطبيق. دراسة المشروع وتقديم جدول زمني واضح المهام.</textarea> 
                                            </div>

                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    <p>لم تقم باضافة اي خبرات في الوقت الحالي</p>
                                @endif




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
                                                    <h4>{{ $error}}</h4>
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
                                                {!! Form::text('start_date', null, ['required','class' => 'form-control','placeholder'=>'تاريخ البداية']) !!}
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                {!! Form::label('end_date', trans('forms.end_date'))!!}
                                                {!! Form::text('start_date', null, ['class' => 'form-control','placeholder'=>'تاريخ النهاية']) !!}
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

@endsection

