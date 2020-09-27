@extends('layouts.inner')
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

                                @if (Session::has('message'))
                                  <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                                        {{Session::get('message')}}
                                  </div>
                                @endif

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
                                            <p class="price mb-1"><span class="mr-1">{{Auth::user()->totalProfit()}}</span>ريال سعودي</p>
                                            <p class="p-3">هو كامل الرصيد الموجود في حسابك الآن يتضمن الأرباح والرصيد المعلق</p>
                                        </div>
                                        
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class=" bg-light pt-3 box rounded">
                                            <h2 class="mb-3">الرصيد المعلّق</h2>
                                            <p class="price mb-1"><span class="red mr-1">{{Auth::user()->pendingProfit()}}</span>ريال سعودي</p>
                                            <p class="p-3">هو الرصيد المعلق الذي لا يمكن سحبه إلا بعد تأكيد صاحب المشروع بالإستلام</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="bg-light pt-3 box rounded">
                                            <h2 class="mb-3">آرباح ممكن سحبها</h2>
                                            <p class="price mb-1"><span  class="green mr-1">{{Auth::user()->confirmedProfit()}}</span>ريال سعودي</p>
                                            <p class="p-3">هو المبلغ الذي حققتهه من عملك ويمكن سحبه الي حسابك</p>
                                        </div>
                                    </div>

                                </div>

                                <div id="records">
                                  <div class="table-responsive">
                                    <table class="table table-bordered mt-4 mb-5">
                                      <thead class="thead-light">
                                        <tr>
                                          <th scope="col">نوع العملية</th>
                                          <th scope="col">الوصف</th>
                                          <th scope="col">المبلغ</th>
                                          <th scope="col">تاريخ العملية</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @if(count($transactions)> 0)
                                          @foreach($transactions as $transaction)


                                            <tr>
                                              <td>{{$transaction->title}}</td>
                                              <td>
                                                @if($transaction->booking)
                                                {{$transaction->booking->getModel()->title}}
                                                @else
                                                  سحب ارباح
                                                @endif
                                              </td>
                                              <td>@if($transaction->type == 'minus') - @endif
                                                {{$transaction->mount}} ريال</td>
                                              <td dir="ltr">{{$transaction->created_at}}</td>
                                            </tr>
                                          @endforeach
                                        @else
                                        <tr>
                                          <td colspan="4"> لا يوجد اي عمليات</td>
                                        </tr>

                                        @endif

                                      </tbody>
                                    </table>
                                  </div>

                                </div>


                                <div id="withdraw" class="col-12">

                                    @if(Auth::user()->requestedProfit())
                                        <div class="alert alert-info">
                                          هناك طلب لسحب الارباح ، فريق عمل الموقع يعمل على الطلب حال الانتهاء سيتم تفعيل خاصية السحب مرة اخرى 
                                        </div>
                                    @endif


                                    {{ Form::open(['action' => 'Account\TransactionController@store']) }}
                                                

                                        @if(count($errors) > 0)
                                            @foreach ($errors->all() as $error)
                                                <div class="alert alert-danger alert-dismissable" >
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    {{ $error}}
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="row mb-4">
                                            <div class="col-12 col-sm-6">
                                                <label class="mb-3" for="">ادخال المبلغ المراد سحبه</label>
                                                {!! Form::text('mount', null, ['required','class' => 'form-control','onkeyup'=>'this.value=this.value.replace(/[^\d]/,"")']) !!}
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <label class="mb-3" for="">ملاحظات</label>
                                                {!! Form::textarea('desc', null,  array('required', 'class'=>'textarea form-control', 'rows'=>'3')) !!}
                                            </div>
                                        </div>

                                        <div class="row mt-5 mb-3">
                                            <div class="col-12">
                                              {!! Form::submit(trans('file.addreplay'), array('class'=>'btn btn-primary')) !!}
                                            </div>
                                        </div>
                                  {{ Form::close() }}                  
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

