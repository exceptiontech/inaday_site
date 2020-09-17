@extends('layouts.inner')

@section('title')
   {{$service->title}}
@endsection

@section('content')

<div id="innerpage" class="pt-5 pb-5">
        <div class="container">
            <div class="row">
                <!-- sidebar Begin -->
                <div class="col-12 col-md-4">
                    <div class="bg-light rounded pt-3 pb-3 p-2">
                        <div class="img mb-3 text-center" >
                          <img class="img-fluid" src="{{ url($service->img ?? '/assets/images/logo.png' )}}" alt="" title="" />
                         
                        </div>

                        <div class="project-info mb-5">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark">مقدم الخدمة</div>
                                    <div class="col-6 p-0"> {{ $service->user->first_name.' '.$service->user->last_name }} </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark">تصنيف القسم</div>
                                    <div class="col-6 p-0"><span class="bg-light">{{ $service->section->title[App::getLocale()] }}</span> </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark">تكلفة الخدمة</div>
                                    <div class="col-6 p-0">{{$service->cost}} {{__('file.riyal')}}</div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark">{{__('file.duration')}}</div>
                                    <div class="col-6 p-0">{{$service->duration}} يوم </div>
                                </li>

                            </ul>
                        </div>
                        <div class="col-12 contact_author align-bottom">
                          
                              <form action="{{ url('paypal/'.$service->title.'/'.$service->id.'/charge') }}" method="post">
                                  <input type="hidden" name="amount" value="{{ $service->cost}}" />
                                  {{ csrf_field() }}
                                  <button class="btn btn-primary btn-block mb-2">{{__('file.book_service')}}</button>
                              </form>

                          
                        </div>

                        
                        <div class="col-12 contact_author align-bottom">
                            <a href="{{url('/messages/'.$service->user->id)}}" class="btn btn-primary btn-block mb-2">تواصل معي</a>
                            
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


                            <!-- service -->
                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-10">
                                       <h2 class="mb-3">{{$service->title}}</h2> 
                                       <p>{{$service->desc}}</p>
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
                                                        <a target="_blank" data-original-title="Twitter" rel="tooltip"  href="https://twitter.com/share?url={{url('/services/'.$service->title)}}&amp;text=Simple%20Share%20Buttons&amp;hashtags=simplesharebuttons" class="btn btn-twitter" >
                                                      <i class="fa fa-twitter"></i>
                                                    </a>
                                                    </li>
                                                    <li>
                                                      <a target="_blank"  href="http://www.facebook.com/sharer.php?u={{url('/services/'.$service->title)}}" class="btn btn-facebook" >
                                                      <i class="fa fa-facebook"></i>
                                                    </a>
                                                    </li>         
                                                      <li>
                                                      <a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{url('/services/'.$service->title)}}" class="btn btn-linkedin" data-placement="left">
                                                      <i class="fa fa-linkedin"></i>
                                                    </a>
                                                    </li>
                                                    <li>
                                                      <a  class="btn btn-mail" href="mailto:?Subject=Simple Share Buttons&amp;Body=I%20saw%20this%20and%20thought%20of%20you!%20 {{url('/services/'.$service->title)}}">
                                                      <i class="fa fa-envelope"></i>
                                                    </a>
                                                    </li>
                                                  </ul>
                                                </div>
                                              </div>

                                            </li>

                                             <li class="list-inline-item">
                                                @if(Auth::user())
                                                @if(Auth::user()->ServicehasFavorite($service->id))
                                                    <a id="RemoveFromFav" class="updateFav updateFav{{$service->id}}" data-id="{{$service->id}}" data-type="service" href="#">
                                                    <i class="fa fa-star starred" aria-hidden="true"></i></a>
                                                @else
                                                    <a id="AddToFav" class="updateFav updateFav{{$service->id}}" data-id="{{$service->id}}" data-type="service"  href="#">
                                                    <i class="fa fa-star" aria-hidden="true"></i></a>
                                                @endif
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>


                            <div class="block col-12 pt-3 pb-2 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h2 class="mb-3">تفاصيل الخدمة</h2> 
                                        <p>{{$service->desc}}</p>
                                    </div>
                                </div>
                            </div>

                            @if(1 == 2)
                                <div class="block col-12 pt-3 pb-5 mb-1">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h2 class="mb-3">باقات اضافة للخدمة</h2> 
                                        </div>

                                        <div class="col-8">
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                            <label class="form-check-label" for="defaultCheck1">
                                              بنر إعلاني متحرك
                                            </label>
                                          </div>
                                        </div>
                                        <div class="col-2">
                                          <span>2 ساعات</span>
                                        </div>
                                        <div class="col-2">
                                          <span>30 ريال</span>
                                        </div>

                                    </div>
                                </div>
                            @endif


                            <div class="block col-12 pt-3 pb-5 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h2 class="mb-3">تقييمات العملاء</h2> 
                                    </div>
                                </div>
                                <div class="row comments">

                                    @if(count($service->reviews) > 0)

                                    @foreach($service->reviews as $review)
                                    
                                    <div class="col-12 comment">
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="{{url($review->user->userdetail->first()->avater ?? '/assets/images/logo.png')}}" class="rounded-circle img-thumbnail img-fluid ">

                                            <div class="ml-2">
                                                <div class="mt-2 small">
                                                    <h2>{{ $review->user->first_name.' '.$review->user->last_name }}</h2>
                                                </div>
                                                <span class="small"> 10/11/2019</span> 
                                            </div>
                                        </div>

                                        <div class="comment-body">
                                            <p>{{$review->review}}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                        <p>لا يوجد اي تقييمات لهذة الخدمة</p>


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
    $(".updateFav").click(function(event) {
        event.preventDefault();


        var data = {'id' : $(this).data("id"),'type' : $(this).data("type")};

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

