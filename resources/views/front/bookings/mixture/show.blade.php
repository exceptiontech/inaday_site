@extends('layouts.inner')
@section('title')
{{__('file.bookings')}}

@endsection
@section('content')
<div id="innerpage" class="pt-5 pb-5">
        <div class="container">
            <div class="row">

                <div class="col-12 title">
                    <h2 class="text-white mb-5">طلب {{$booking->mixture->title}}</h2>
                </div>

                <!-- sidebar Begin -->
                <div class="col-12 col-md-4">
                    <div class="bg-light rounded pt-3 pb-3 p-2">
                        <div class="img mb-3 text-center" >
                          <img class="img-fluid" src="{{ url($mixture->image ?? '/assets/images/logo.png' )}}" alt="" title="" />
                         
                        </div>

                        <div class="project-info mb-5">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark">الفريق </div>
                                    <div class="col-6 p-0"> {{ $booking->mixture->team->title }} </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark">مدير الفريق </div>
                                    <div class="col-6 p-0"> {{ $booking->mixture->team->user->first_name.' '.$booking->mixture->team->user->last_name }} </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark">صاحب الطلب</div>
                                    <div class="col-6 p-0"> {{ $booking->user->first_name.' '.$booking->user->last_name }} </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark">تصنيف القسم</div>
                                    <div class="col-6 p-0"><span class="bg-light">{{ $booking->mixture->section->title[App::getLocale() ?? ''] }}</span> </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark">ميزانية المشروع</div>
                                    <div class="col-6 p-0">{{ $booking->mixture->cost}} {{__('file.riyal')}}</div>
                                </li>


                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark">{{__('file.duration')}}</div>
                                    <div class="col-6 p-0">{{ $booking->mixture->duration}} يوم </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark">{{__('file.status')}}</div>
                                    <div class="col-6 p-0">
                                    {{$booking->status->title[App::getLocale()] ?? 'الحالة غير محددة'}}  </div>
                                </li>

                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark">المدفوع</div>
                                    <div class="col-6 p-0">{{$booking->payment->amount .' '.$booking->payment->currency}}</div>
                                </li>

                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark">تاريخ حجز الطلب</div>
                                    <div class="col-6 p-0">{{ $booking->created_at }}</div>
                                </li>


                            </ul>
                        </div>
                        <div class="col-12 contact_author align-bottom">
                          
                            <a href="{{url('/messages/'.$booking->mixture->team->user->id)}}" class="btn btn-primary btn-block mb-2">تواصل مع مدير الفريق</a>
                            
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
                        <div class="service">


                            <!-- mixture -->
                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-10">
                                       <h2 class="mb-3">{{ $booking->mixture->title}}</h2> 
                                       <p>{!! \Illuminate\Support\Str::words($booking->mixture->desc,350,'....')  !!}</p>
                                    </div>
                                    <div class="col-sm-2 text-right">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                              
                                              <div id="socialHolder">
                                                <div id="socialShare" class=" share-group">
                                                  <a data-toggle="dropdown" class="btn">
                                                       <i class="fa fa-share-alt"></i>
                                                  </a>
                                                  <ul class="dropdown-menu">
                                                      <li>
                                                        <a data-original-title="Twitter" rel="tooltip"  href="https://twitter.com/share?url={{url('/mixtures/'.$booking->mixture->title)}}&amp;text=Simple%20Share%20Buttons&amp;hashtags=simplesharebuttons" class="btn btn-twitter" >
                                                      <i class="fa fa-twitter"></i>
                                                    </a>
                                                    </li>
                                                    <li>
                                                      <a target="_blank"  href="http://www.facebook.com/sharer.php?u={{url('/mixtures/'.$booking->mixture->title)}}" class="btn btn-facebook" >
                                                      <i class="fa fa-facebook"></i>
                                                    </a>
                                                    </li>         
                                                    <li>
                                                      <a  rel="tooltip"  href="https://plus.google.com/share?url={{url('/mixtures/'.$booking->mixture->title)}}" class="btn btn-google" >
                                                      <i class="fa fa-google-plus"></i>
                                                    </a>
                                                    </li>
                                                      <li>
                                                      <a hhref="http://www.linkedin.com/shareArticle?mini=true&amp;url={{url('/mixtures/'.$booking->mixture->title)}}" class="btn btn-linkedin" data-placement="left">
                                                      <i class="fa fa-linkedin"></i>
                                                    </a>
                                                    </li>
                                                    <li>
                                                      <a class="btn btn-pinterest" href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());" >
                                                      <i class="fa fa-pinterest"></i>
                                                    </a>
                                                    </li>
                                                    <li>
                                                      <a  class="btn btn-mail" href="mailto:?Subject=Simple Share Buttons&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 {{url('/mixtures/'.$booking->mixture->title)}}">
                                                      <i class="fa fa-envelope"></i>
                                                    </a>
                                                    </li>
                                                  </ul>
                                                </div>
                                              </div>

                                            </li>

                                            <li class="list-inline-item">
                                                @if(Auth::user()->mixturehasFavorite($booking->mixture->id))
                                                    <a id="RemoveFromFav" class="updateFav updateFav{{$booking->mixture->id}}" data-id="{{ $booking->mixture->id}}" href="#" >
                                                    <i class="fa fa-star starred" aria-hidden="true"></i></a>
                                                @else
                                                    <a id="AddToFav" class="updateFav updateFav{{ $booking->mixture->id}}" data-id="{{ $booking->mixture->id}}" href="#" >
                                                    <i class="fa fa-star-o" aria-hidden="true"></i></a>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>


                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h2 class="mb-3">تفاصيل الخلطة</h2> 
                                        <p>{{ $booking->mixture->desc}}</p>
                                    </div>
                                </div>
                            </div>



                            <div class="block col-12 pt-3 pb-5 mb-1 border-0">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h2 class="mb-3">تعليقات الطلب</h2> 
                                    </div>
                                </div>
                                <div class="row comments">

                                    @if(count($booking->replays) > 0)

                                    @foreach($booking->replays as $replay)
                                    
                                    <div class="col-12 comment mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="{{url($replay->user->userdetail->first()->avater ?? '/assets/images/logo.png')}}" class="rounded-circle img-thumbnail img-fluid ">

                                            <div class="ml-2">
                                                <div class="mt-2 small">
                                                    <h2>{{ $replay->user->first_name.' '.$replay->user->last_name }}</h2>
                                                </div>
                                                <span class="small">{{ $replay->created_at }}</span> 
                                            </div>
                                        </div>

                                        <div class="comment-body">
                                            <p>{{$replay->replay}}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                        <p>لا يوجد اي رسائل لهذا الطلب</p>


                                    @endif

                                    <div class="block col-12 pt-3 pb-2 mb-3 border-0">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h2 class="mb-3 dark">اضف تعليق</h2> 
                                            </div>
                                            <div class="col-sm-12">
                                                {{ Form::open(['action' => 'ReplayController@store']) }}
                                                
                                                {!! Form::hidden('booking_id', $booking->id, ['required', 'class' => 'form-control', 'readonly' => 'readonly']) !!}

                                                @if(count($errors) > 0)
                                                    @foreach ($errors->all() as $error)
                                                        <div class="alert alert-danger alert-dismissable" >
                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                            <h4>{{ $error}}</h4>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                          {!! Form::textarea('replay', null,  array('required', 'class'=>'textarea form-control', 'placeholder'=>trans('file.replay'), 'rows'=>'3')) !!}
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                          {!! Form::submit(trans('file.addreplay'), array('class'=>'btn btn-primary')) !!}
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
                <!-- sidebar End -->

            </div>
        </div>
    </div>






@endsection


@section('jquery')
<script type="text/javascript">
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
