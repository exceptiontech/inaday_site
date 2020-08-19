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
                        <div class="img mb-3" >
                        @if($service->user->userdetail->first())
                  <img class="img-fluid" src="{{ url('/'.$service->user->userdetail->first()->avater) ?? '/assets/images/logo.png' }}" alt="" title="" />
                @else
                  <img class="img-fluid" src="{{ url('/assets/images/logo.png') }}" alt="" title="" />
                @endif
                         
                        </div>

                        <div class="project-info mb-5">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark">مقدم الخدمة</div>
                                    <div class="col-6 p-0"> {{ $service->user->first_name.' '.$service->user->last_name }} </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark">تصنيف القسم</div>
                                    <div class="col-6 p-0"><span class="bg-light">تصميم المواقع</span> </div>
                                </li>
                                <li class="list-group-item d-flex">
                                    <div class="col-6 p-0 text-dark">ميزانية المشروع</div>
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
                            <a href="#" class="btn btn-primary btn-block mb-2">تواصل مع صاحب المشروع</a>
                            <p class="small">يتوجب عليك تسجيل الدخول أولاً للإستفادة من خدمات المنصة</p>
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
                                       <p>{{$service->user->userdetail->first()->notes}}</p>
                                    </div>
                                    <div class="col-sm-2 text-right">
                                        <ul class="list-inline">
                                            <li class="list-inline-item"><i class="fa fa-share-alt" aria-hidden="true"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star-o" aria-hidden="true"></i></li>
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


                            <div class="block col-12 pt-3 pb-5 mb-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h2 class="mb-3">تقييمات العملاء</h2> 
                                    </div>
                                </div>
                                <div class="row comments">
                                    
                                    <div class="col-12 comment">
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="images/19571f92333dd5fba2598f637b68739c.png" class="rounded-circle img-thumbnail img-fluid ">

                                            <div class="ml-2">
                                                <div class="mt-2 small">
                                                    <h2>محمد المأمون</h2>
                                                </div>
                                                <span class="small">صاحب المشروع بتاريخ 10/11/2019</span> 
                                            </div>
                                        </div>

                                        <div class="comment-body">
                                            <p>انجز العمل بكل احترافيه تعامل وجوده وتواصل كل شي بكل دقه واحتراف ليس فقط انجز العمل بل استفدت الكثير من نصائحه ومعلوماته القيمه مليار شكر والله يوفقك ان شاءالله</p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 comment">
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="images/19571f92333dd5fba2598f637b68739c.png" class="rounded-circle img-thumbnail img-fluid ">

                                            <div class="ml-2">
                                                <div class="mt-2 small">
                                                    <h2>محمد المأمون</h2>
                                                </div>
                                                <span class="small">صاحب المشروع بتاريخ 10/11/2019</span> 
                                            </div>
                                        </div>

                                        <div class="comment-body">
                                            <p>انجز العمل بكل احترافيه تعامل وجوده وتواصل كل شي بكل دقه واحتراف ليس فقط انجز العمل بل استفدت الكثير من نصائحه ومعلوماته القيمه مليار شكر والله يوفقك ان شاءالله</p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 comment">
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="images/19571f92333dd5fba2598f637b68739c.png" class="rounded-circle img-thumbnail img-fluid ">

                                            <div class="ml-2">
                                                <div class="mt-2 small">
                                                    <h2>محمد المأمون</h2>
                                                </div>
                                                <span class="small">صاحب المشروع بتاريخ 10/11/2019</span> 
                                            </div>
                                        </div>

                                        <div class="comment-body">
                                            <p>انجز العمل بكل احترافيه تعامل وجوده وتواصل كل شي بكل دقه واحتراف ليس فقط انجز العمل بل استفدت الكثير من نصائحه ومعلوماته القيمه مليار شكر والله يوفقك ان شاءالله</p>
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
