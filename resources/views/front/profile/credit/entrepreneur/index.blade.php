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

                                <ul class="nav nav-pills mb-4">
                                  <li class="nav-item">
                                    <a class="nav-link active rounded" href="#records">العمليات المالية</a>
                                  </li>
                                </ul>


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
                                        {!!Form::select('type', ['sell'=>'شراء','refund'=>'ارجاع'], Request::get('type'), ['id' => 'type','class' => 'form-control','placeholder'=>'الكل']) !!}
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

                                <div id="records">
                                  <div class="table-responsive">
                                    <table class="table table-bordered mt-4 mb-5">
                                      <thead class="thead-light">
                                        <tr>
                                          <th scope="col">رقم العملية</th>
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
                                              <td>{{$transaction->id}}</td>
                                              <td>{{$transaction->title}}</td>
                                              <td>
                                                @if($transaction->booking)
                                                {{$transaction->booking->getModel()->title}}
                                                @else
                                                  سحب ارباح
                                                @endif
                                              </td>
                                              <td>{{$transaction->mount}} ريال</td>
                                              <td dir="ltr">{{$transaction->created_at}}</td>
                                            </tr>
                                          @endforeach
                                        @else
                                        <tr>
                                          <td colspan="5"> لا يوجد اي عمليات</td>
                                        </tr>

                                        @endif

                                      </tbody>
                                    </table>
                                  </div>
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

