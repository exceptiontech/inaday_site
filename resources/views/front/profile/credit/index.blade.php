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

                                @if(Auth::user() && Auth::user()->isServicesProvider() && Auth::user()->isActive())
                                    <ul class="list-inline ">
                                        <li class="list-inline-item"><a href="{{url('/account/services')}}">خدماتي</a></li>
                                        <li class="list-inline-item"><a href="{{url('/account/experiences')}}">خبراتي</a></li>
                                        <li class="list-inline-item"><a class="active" href="{{url('/account/portfolios')}}">معرض الاعمال</a></li>
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



                            <div class="col-12 col-sm-8 profile-content mb-5">

                                <ul class="nav nav-pills mb-4">
                                  <li class="nav-item">
                                    <a class="nav-link active" href="#">معلومات الرصيد</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" href="#">العمليات المالية</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" href="#">سحب المبالغ</a>
                                  </li>
                                </ul>


                                <div class="row text-center mb-5">

                                    <div class="col-12 col-sm-4">
                                        <div class="bg-light pt-3 box rounded">
                                            <h2 class="mb-3">الرصيد الكلي</h2>
                                            <p class="price mb-1"><span class="mr-1">200</span>ريال سعودي</p>
                                            <p class="p-3">هو كامل الرصيد الموجود في حسابك الآن يتضمن الأرباح والرصيد المعلق</p>
                                        </div>
                                        
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class=" bg-light pt-3 box rounded">
                                            <h2 class="mb-3">الرصيد الكلي</h2>
                                            <p class="price mb-1"><span class="red mr-1">200</span>ريال سعودي</p>
                                            <p class="p-3">هو كامل الرصيد الموجود في حسابك الآن يتضمن الأرباح والرصيد المعلق</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="bg-light pt-3 box rounded">
                                            <h2 class="mb-3">الرصيد الكلي</h2>
                                            <p class="price mb-1"><span  class="green mr-1">200</span>ريال سعودي</p>
                                            <p class="p-3">هو كامل الرصيد الموجود في حسابك الآن يتضمن الأرباح والرصيد المعلق</p>
                                        </div>
                                    </div>

                                </div>


                                <div class="table-responsive ">
                                    <table class="table mt-4 mb-5">
                                      <thead class="thead-light">
                                        <tr>
                                          <th scope="col">نوع العملية</th>
                                          <th scope="col">الوصف</th>
                                          <th scope="col">المبلغ</th>
                                          <th scope="col">تاريخ العملية</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr>
                                          <th scope="row">ايداع</th>
                                          <td>تنفيذ الخدمة - تصميم شعار</td>
                                          <td>200 ريال</td>
                                          <td>10/07/2020 | 03:45 PM</td></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">ايداع</th>
                                          <td>تنفيذ الخدمة - تصميم شعار</td>
                                          <td>200 ريال</td>
                                          <td>10/07/2020 | 03:45 PM</td></td>
                                        </tr>
                                        <tr>
                                          <th scope="row">ايداع</th>
                                          <td>تنفيذ الخدمة - تصميم شعار</td>
                                          <td>200 ريال</td>
                                          <td>10/07/2020 | 03:45 PM</td></td>
                                        </tr>

                                      </tbody>
                                    </table>

                                </div>

                                <div class="col-12">
                                    <form>
                                        <div class="row mb-4">
                                            <div class="col-12 col-sm-6">
                                                <label class="mb-3" for="inputEmail4">ادخال المبلغ المراد سحبه</label>
                                                <input type="text" class="form-control" placeholder="100">
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <label class="mb-3" for="inputEmail4">ملاحظات</label>
                                                <textarea class="form-control" placeholder="مثال: يمكنك كتابة ملاحظات تذكيرة للمبلغ الذي قمت بسحبة"></textarea> 
                                            </div>
                                        </div>

                                        <div class="row mt-5 mb-3">
                                            <div class="col-12">
                                                <button class="btn btn-primary">سحب المبلغ</button>
                                            </div>
                                        </div>
                                    </form>


                                </div>



                            </div>

                            <div class="col-12 col-sm-4">
                                <div class="bg-light dark p-3">
                                    <div class="text-center mt-n5">
                                        <img src="{{url('images/lamp.svg')}}">
                                    </div>
                                    <p class="mt-5">
                                        - أنت مقدم خدمه و تعرف تقدم خدمه و تقدر تحدد كل متطلبات المشروع من وقت و تكلفة. حدد كم مستعد تستثمر في كل مهمة.
                                    </p>
                                    <p class="mt-5">
                                        - أنت مقدم خدمه و تعرف تقدم خدمه و تقدر تحدد كل متطلبات المشروع من وقت و تكلفة. حدد كم مستعد تستثمر في كل مهمة.
                                    </p>
                                    <p class="mt-5">
                                        - أنت مقدم خدمه و تعرف تقدم خدمه و تقدر تحدد كل متطلبات المشروع من وقت و تكلفة. حدد كم مستعد تستثمر في كل مهمة.
                                    </p>
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

