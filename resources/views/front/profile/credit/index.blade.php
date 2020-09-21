@extends('layouts.inner')
@section('title')
  {{__('file.servives_provider_register')}}
@endsection
@section('content')


    <div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    @if(Auth::user() && Auth::user()->isServicesProvider() && Auth::user()->isActive())
                      <h2 class="text-white mb-5">ادارة الخدمات</h2>
                    @else
                      <h2 class="text-white mb-5">ادارة المشاريع</h2>
                    @endif
                </div>

                <div class="col-12">
                    <div class="bg-light mt-5 p-3  wrapper profile rounded">
                        <div class="row">

                            <div class="col-12  profile-head-menu mb-5">
                                @include('front.profile.parts.menu')
                            </div>



                            <div class="col-12 col-sm-8 profile-content mb-5">

                                <ul class="nav nav-pills mb-4">
                                  <li class="nav-item">
                                    <a class="nav-link active" href="#summary">معلومات الرصيد</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" href="#records">العمليات المالية</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" href="#withdraw">سحب المبالغ</a>
                                  </li>
                                </ul>


                                <div id="summary" class="row text-center mb-5">

                                    <div class="col-12 col-sm-4">
                                        <div class="bg-light pt-3 box rounded">
                                            <h2 class="mb-3">الرصيد الكلي</h2>
                                            <p class="price mb-1"><span class="mr-1">200</span>ريال سعودي</p>
                                            <p class="p-3">هو كامل الرصيد الموجود في حسابك الآن يتضمن الأرباح والرصيد المعلق</p>
                                        </div>
                                        
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class=" bg-light pt-3 box rounded">
                                            <h2 class="mb-3">الرصيد المعلّق</h2>
                                            <p class="price mb-1"><span class="red mr-1">200</span>ريال سعودي</p>
                                            <p class="p-3">هو الرصيد المعلق الذي لا يمكن سحبه إلا بعد تأكيد صاحب المشروع بالإستلام</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="bg-light pt-3 box rounded">
                                            <h2 class="mb-3">آرباح ممكن سحبها</h2>
                                            <p class="price mb-1"><span  class="green mr-1">200</span>ريال سعودي</p>
                                            <p class="p-3">هو المبلغ الذي حققتهه من عملك ويمكن سحبه الي حسابك</p>
                                        </div>
                                    </div>

                                </div>

                                <div id="records">
                                  <div class="table-responsive">
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
                                </div>

                                <div id="withdraw" class="col-12">
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

