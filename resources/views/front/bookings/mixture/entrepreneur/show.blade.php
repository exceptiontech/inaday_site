@extends('layouts.inner')
@section('title')
@endsection
@section('content')
<div id="innerpage" class="pt-5 pb-5">
        <div class="container">
            <div class="row">

                <div class="col-12 title">
                    <h2 class="text-white mb-5"> {{$booking->service->title}}</h2>
                </div>

                <!-- sidebar Begin -->
                <div class="col-12 col-md-4 sidaber">
                    <div class="bg-light rounded pt-3 pb-3 p-2">
                        <div class="author">
                            <div class="col-sm-12 d-flex align-items-center mb-5">
                                @if($booking->service->user )
                                    @if(count($booking->service->user->userdetail) > 0)
                                        @if($booking->service->user->userdetail->first()->avater)
                                          <img src="{{ url($booking->service->user->userdetail->first()->avater) }}" class="rounded-circle img-thumbnail img-fluid pull-right img-icon80" alt="{{$booking->service->title}}" title="{{$booking->service->title}}" />
                                        @else
                                          <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid pull-right img-icon80" alt="{{$booking->service->title}}" title="{{$booking->service->title}}" />
                                        @endif
                                    @else
                                      <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid pull-right img-icon80" alt="{{$booking->service->title}}" title="{{$booking->service->title}}" />
                                    @endif
                                @else
                                  <img src="{{ url('assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid pull-right img-icon80" alt="{{$booking->service->title}}" title="{{$booking->service->title}}" />
                                @endif  


                                <div class="ml-2">
                                    <span class="small">فريق الخطلة</span> 
                                    <div class="mt-2 small">
                                        <h2>{{ $booking->service->team->title }}</h2>                                    
                                    </div>
                                </div>                   
                            </div>
                        </div>

                        <div class="project-info mb-5">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark font-weight-bolder">{{__('file.status')}}</div>
                                    <div class="col-6 p-0">
                                    <span class="bg-light bg-info">{{$booking->status->title[App::getLocale()] ?? 'الحالة غير محددة'}}</span>  </div>
                                </li>

                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark font-weight-bolder">تصنيف القسم</div>
                                    <div class="col-6 p-0"><span class="bg-light">{{ $booking->service->section->title[App::getLocale()] }}</span> </div>
                                </li>

                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark font-weight-bolder">ميزانية المتوقعة</div>
                                    <div class="col-6 p-0">{{ $booking->service->cost}} {{__('file.riyal')}}</div>
                                </li>

                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark font-weight-bolder">{{__('file.duration')}}</div>
                                    <div class="col-6 p-0">{{ $booking->service->duration}} يوم </div>
                                </li>

                            </ul>


                            <div class="col-12 mt-5 mb-4 small">
                                <h2>تفاصيل الدفع</h2>                                    
                            </div>

                            <ul class="list-group list-group-flush">

                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark font-weight-bolder">المبلغ</div>
                                    <div class="col-6 p-0">{{$booking->payment->amount .' '.$booking->payment->currency}}</div>
                                </li>

                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark font-weight-bolder">التاريخ</div>
                                    <div class="col-6 p-0">{{ Carbon\Carbon::parse(strtotime($booking->created_at))->format('d-m-Y') }}</div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 contact_author align-bottom">

                            @if(Auth::user()->id == $booking->user->id)
                                <a href="{{url('/messages/'.$booking->service->user->id)}}" class="btn btn-primary btn-block mb-2">تواصل مع صاحب المشروع</a>
                            @else
                                <a href="{{url('/messages/'.$booking->user->id)}}" class="btn btn-primary btn-block mb-2">تواصل مع مقدم الخدمة</a>
                            @endif

                            @guest
                                <p class="small">يتوجب عليك تسجيل الدخول أولاً للإستفادة من خدمات المنصة</p>
                            @endguest
                        </div>
                        


                    </div>
                </div>
                <!-- sidebar End -->


                <!-- Content Begin -->
                <div class="col-12 col-md-8">
                    <div class="bg-light rounded pt-2 pb-3 p-2">
                        <div class="project">

                            <!-- service -->
                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-10">
                                       <h2 class="mb-3">أسم الخلطة</h2> 
                                       <p>{{ $booking->mixture->title}}</p>
                                    </div>
                                    <div class="col-sm-2 text-right">
                                    </div>
                                </div>
                            </div>


                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h2 class="mb-3">تفاصيل الخلطة</h2> 
                                        <p>{{ $booking->service->desc}}</p>
                                    </div>
                                </div>
                            </div>


                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h2 class="mb-4">{{trans('file.targeted_skills')}}</h2> 
                                        <div class="clearfix">
                                        @if(count($booking->service->skills))
                                            <ul class="list-inline">
                                                @foreach($booking->service->skills as $skill)
                                                    <li class="list-inline-item">
                                                        <span class="bg-light p-2 rounded">{{@$skill->title[App::getLocale()]}}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="block col-12 pt-3 pb-5 mb-1 border-0">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h2 class="mb-3">مسار الخلطة والتعليقات</h2> 
                                    </div>
                                </div>
                                <div class="row comments">

                                    @if(count($booking->replays) > 0)

                                    @foreach($booking->replays as $replay)
                                    <div class="col-12 pt-3 pb-3 comment mb-4">
                                        <div class="row info">
                                            <div class="col-sm-8 d-flex align-items-center">

                                                <img src="{{url($replay->user->userdetail->first()->avater ?? '/assets/images/logo.png')}}" class="rounded-circle img-thumbnail img-fluid pull-right">

                                                <div class="ml-2">
                                                    <span>{{ $replay->user->first_name.' '.$replay->user->last_name }}</span> 
                                                    <div class="m-0 small">
                                                        <span class="mr-2">مقدم خدمة</span>
                                                        <span>بتاريخ  {{ Carbon\Carbon::parse(strtotime($replay->created_at))->format('m-Y ') ?? 'الان'}} </span>
                                                    
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-4 text-right">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        <span class="bg-light rounded p-1 border-primary text-primary">{{ $replay->replaykind->title[App::getLocale()] ?? 'بدون' }} </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <p>{{$replay->replay}}</p>

                                        @if($replay->file)

                                        <a class="d-flex" download="download" href="{{url($replay->file)}}">
                                            <div class="col-3  bg-light shadow-sm text-center p-2 align-middle">
                                                @if(pathinfo($replay->file, PATHINFO_EXTENSION)  == 'png' || pathinfo($replay->file, PATHINFO_EXTENSION) == 'jpg' || pathinfo($replay->file, PATHINFO_EXTENSION) == 'jpeg')
                                                    <img class="img-fluid" src="{{url($replay->file)}}">
                                                @else
                                                    <i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i>
                                                @endif
                                            </div>
                                        </a>

                                        @endif

                                        @if(count($replay->replays) > 0)
                                            @foreach($replay->replays as $replay)
                                                @if($replay->parent->is_confirmed == 1)
                                                <div class="alert alert-info mt-4">
                                                        تم تمديد الطلب {{$replay->duration}} بالملاحظات التالية : 
                                                        <br>
                                                        {{$replay->replay}}
                                                </div>
                                                @else
                                                <div class="alert alert-danger mt-4">
                                                    تم رفض طلب التمديد
                                                </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>


                                    @endforeach
                                    @else
                                        <div class="col-12">
                                            <p>لا يوجد اي رسائل لهذا الطلب</p>
                                        </div>
                                    @endif

                                    @if($booking->status_id == 3)
                                    <div class="col-12">
                                        <div class="alert alert-success">
                                            المشروع مكتمل
                                        </div>
                                    </div>
                                    @elseif($booking->status_id == 4)
                                    <div class="col-12">
                                        <div class="alert alert-danger">
                                            المشروع غير مكتمل او ملغي
                                        </div>
                                    </div>
                                    @else

                                    <div class="block col-12 pt-3 pb-2 mb-3 border-0">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h2 class="mb-3 dark">اضف تعليق</h2> 
                                            </div>
                                            <div class="col-sm-12">
                                                {{ Form::open(['action' => 'ReplayController@store','files'=>true]) }}
                                                
                                                {!! Form::hidden('booking_id', $booking->id, ['required', 'class' => 'form-control', 'readonly' => 'readonly']) !!}

                                                @if(count($errors) > 0)
                                                    @foreach ($errors->all() as $error)
                                                        <div class="alert alert-danger alert-dismissable" >
                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                            {{ $error}}
                                                        </div>
                                                    @endforeach
                                                @endif
                                                    <div class="row mb-4">
                                                        <div class="col-12">
                                                            <label><b>التعليق</b></label>
                                                            {!! Form::textarea('replay', null,  array('required', 'class'=>'textarea form-control', 'placeholder'=>trans('file.replay'), 'rows'=>'3')) !!}
                                                        </div>
                                                    </div>

                                                    <div class="row mb-4">
                                                        <div class="col-6">
                                                            {!! Form::label('files', trans('forms.files'))!!} 
                                                            <div class="input-group">
                                                                <span class="form-control overflow-hidden"></span>
                                                                <span class="input-group-btn">
                                                                    <input name="file" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
                                                                    <span class="btn btn-light h-100 shadow" onclick="$(this).parent().find('input[type=file]').click();">تحميل المرفق</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                          {!! Form::submit('إرسال', array('class'=>'btn btn-primary')) !!}
                                                        </div>
                                                    </div>
                                                {{ Form::close() }}                  
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                 
                                    @if($booking->requestDuration())
                                    {{ Form::open(['action' => 'ReplayController@store','files'=>true]) }}
                                    
                                    {!! Form::hidden('booking_id', $booking->id, ['required', 'class' => 'form-control', 'readonly' => 'readonly']) !!}

                                    {!! Form::hidden('replay_id', $booking->requestDuration()->id, ['required', 'class' => 'form-control', 'readonly' => 'readonly']) !!}

                                    
                                    @if(count($errors) > 0)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger alert-dismissable" >
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                {{ $error}}
                                            </div>
                                        @endforeach
                                    @endif

                                    @if($booking->status_id != 4)
                                    <div class="block col-12 pt-3 pb-2 mb-3 border-0">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h2 class="mb-3 dark">الاجراء</h2> 
                                            </div>
                                            <div class="col-sm-12 mb-4">
                                                <div class="col-12 mb-4">طلب تمديد مهلة لمدة {{$replay->duration}} ساعة</div>

                                                <div class="col-12">
                                                <div class="form-check form-check-inline ml-4">
                                                  <input class="form-check-input" type="radio" name="is_confirmed" id="approve" value="1">
                                                  <label class="form-check-label" for="approve">موافق على طلب المهلة</label>
                                                </div>
                                                <div class="form-check form-check-inline ml-4">
                                                  <input class="form-check-input" type="radio" name="is_confirmed" id="refuse" value="-1">
                                                  <label class="form-check-label" for="refuse">غير موافق</label>
                                                </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 mb-4">
                                                <label><b>ملاحظات</b></label>
                                                {!! Form::textarea('replay', null,  array('required', 'class'=>'textarea form-control', 'rows'=>'2')) !!}
                                            </div>


                                        </div>
                                    </div>

                                    @endif

                                    <div class=" mb-3">
                                        <div class="col-12">
                                          {!! Form::submit(trans('file.addreplay'), array('class'=>'btn btn-primary')) !!}
                                        </div>
                                    </div>
                                    {{ Form::close() }}                  
                                    @endif

                                    @if($booking->requestConfirm() && $booking->status_id != 3 && $booking->status_id != 4)
                                    {{ Form::open(['action' => 'Account\ReviewController@store']) }}
                                    
                                    {!! Form::hidden('booking_id', $booking->id, ['required', 'class' => 'form-control', 'readonly' => 'readonly']) !!}

                                    
                                    @if(count($errors) > 0)
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger alert-dismissable" >
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                {{ $error}}
                                            </div>
                                        @endforeach
                                    @endif

                                    <div class="block col-12 pt-3 pb-2 mb-3 border-0">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h2 class="mb-3 dark">الاجراء</h2> 
                                            </div>
                                            <div class="col-sm-12 mb-4">
                                                <div class="col-12 mb-4">طلب إتمام تسليم المشروع </div>

                                                <div class="col-12">
                                                <div class="form-check form-check-inline ml-4">
                                                  <input class="form-check-input" type="radio" name="is_confirmed" id="approve" value="1">
                                                  <label class="form-check-label" for="approve">تم الاستلام</label>
                                                </div>
                                                <div class="form-check form-check-inline ml-4">
                                                  <input class="form-check-input" type="radio" name="is_confirmed" id="refuse" value="0">
                                                  <label class="form-check-label" for="refuse">التقدم بشكوى للإدارة</label>
                                                </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 mb-4">
                                                <label><b>تقييم الخدمة</b></label>
                                                {!! Form::textarea('review', null,  array('required', 'class'=>'textarea form-control', 'rows'=>'2','placeholder'=>'هنا يمكنك كتابة ملاحظات في مرحلة تسلم المشروع')) !!}
                                            </div>


                                        </div>
                                    </div>

                                    <div class=" mb-3">
                                        <div class="col-12">
                                          {!! Form::submit(trans('file.addreplay'), array('class'=>'btn btn-primary')) !!}
                                        </div>
                                    </div>
                                    {{ Form::close() }}                  
                                    @endif




                                </div>
                            </div>
                            
                        </div> 

                    </div>
                </div>
                <!-- sidebar End -->

            </div>
        </div>
    </div>






@endsection


@section('jquery')
<script type="text/javascript">


    $("#replaykind_id").change(function() {

        var id = $("#replaykind_id option:selected").val();

        if (id == 3) {
            $('#duration').fadeIn();
        }else {
            $('#duration').fadeOut();
        }

    });


    $(".updateFav").click(function(event) {
        event.preventDefault();

        var data = {'id' : $(this).data("id")};

        $.ajax({    
            type  : 'get',
            url   : '{!!URL::route('updateFavorite')!!}',
            data  : data ,      
            success:function(data){

                console.log(data.result);

                if (data.result == 'done') {
                    $('.updateFav .fa').addClass('starred');
                }else {
                    $('.updateFav .fa').removeClass('starred');
                }
            },
        error:function(data){
            console.log(data.err)
        }
      });
    });   


</script>

@endsection
