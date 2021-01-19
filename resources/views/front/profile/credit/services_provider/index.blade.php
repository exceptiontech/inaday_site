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


                                @if(count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger alert-dismissable" >
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            {{ $error}}
                                        </div>
                                    @endforeach
                                @endif


                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                  <li class="nav-item">
                                    <a class="nav-link active" id="records-tab" data-toggle="tab" href="#records" role="tab" aria-controls="records" aria-selected="true">العمليات المالية</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" id="withdraw-tab" data-toggle="tab" href="#withdraw" role="tab" aria-controls="withdraw" aria-selected="false">سحب المبالغ</a>
                                  </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                  <div class="tab-pane fade show active" id="records" role="tabpanel" aria-labelledby="records-tab">
                                    <div class="row">
                                       <div class="col-12 col-sm-4 ">
                                              <div class="bg-light pt-3 box rounded text-center">
                                                  <h2 class="mb-3">الرصيد الكلي</h2>
                                                  <p class="price mb-1"><span class="mr-1">{{Auth::user()->totalProfit()}}</span>ريال سعودي</p>
                                                  <p class="p-3">هو كامل الرصيد الموجود في حسابك الآن يتضمن الأرباح والرصيد المعلق</p>
                                              </div>
                                              
                                          </div>
                                          <div class="col-12 col-sm-4">
                                              <div class=" bg-light pt-3 box rounded text-center">
                                                  <h2 class="mb-3">الرصيد المعلّق</h2>
                                                  <p class="price mb-1"><span class="red mr-1">{{Auth::user()->pendingProfit()}}</span>ريال سعودي</p>
                                                  <p class="p-3">هو الرصيد المعلق الذي لا يمكن سحبه إلا بعد تأكيد صاحب المشروع بالإستلام</p>
                                              </div>
                                          </div>
                                          <div class="col-12 col-sm-4">
                                              <div class="bg-light pt-3 box rounded text-center">
                                                  <h2 class="mb-3">آرباح ممكن سحبها</h2>
                                                  <p class="price mb-1"><span  class="green mr-1">{{Auth::user()->confirmedProfit()}}</span>ريال سعودي</p>
                                                  <p class="p-3">هو المبلغ الذي حققتهه من عملك ويمكن سحبه الي حسابك</p>
                                              </div>
                                          </div>  
                                          <div class="col-12">



                                            {{ Form::open(['action' => 'Account\CreditController@index','method' => 'get']) }}
                                            <div  id="searchform" class="row mb-3 mt-5">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                      {!! Form::label('title','بحث')!!}
                                                      {!!Form::text('title', Request::get('title'), ['id' => 'title','class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                      {!! Form::label('type', 'نوع العملية')!!}
                                                      {!!Form::select('type', ['plus'=>'ربح','minus'=>'سحب'], Request::get('type'), ['id' => 'type','class' => 'form-control','placeholder'=>'الكل']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                      {!! Form::label('start_date', 'خلال الفترة من')!!}
                                                      {!!Form::text('start_date', Request::get('start_date'), ['id' => 'start_date','class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                      {!! Form::label('end_date', 'إلى')!!}
                                                      {!!Form::text('end_date', Request::get('end_date'), ['id' => 'end_date','class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="col">
                                                      {!! Form::button(trans('admin.search'), 
                                                      array('class'=>'btn btn-block btn-success','id'=>'search-button', 'type'=>'submit')) !!}
                                                </div>

                                              </div>
                                              {{ Form::close() }}


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
                                                        {{$transaction->mount - (($transaction->mount*10)/100) }} ريال</td>
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
                                        </div>
                                  </div>
                                  <div class="tab-pane fade" id="withdraw" role="tabpanel" aria-labelledby="withdraw-tab">
                                    @if(Auth::user()->requestedProfit())
                                        <div class="alert alert-info">
                                          هناك طلب لسحب الارباح ، فريق عمل الموقع يعمل على الطلب حال الانتهاء سيتم تفعيل خاصية السحب مرة اخرى 
                                        </div>
                                    @endif


                                    {{ Form::open(['action' => 'Account\TransactionController@store']) }}
                                                
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
                                              {!! Form::submit('إرسال', array('class'=>'btn btn-primary')) !!}
                                            </div>
                                        </div>
                                    {{ Form::close() }}                  

                                  </div>
                                </div>




                            </div>

                            <div class="col-12 col-sm-4">
                                @include('front.profile.parts.service_provider')
                                
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


