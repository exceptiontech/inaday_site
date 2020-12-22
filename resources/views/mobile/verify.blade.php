@extends('layouts.inner')
@section('content')
	<div id="innerpage" class="pt-5 pb-5">
        <div class="container">
            <div class="row">

                <div class="col-12 title">
                    <h2 class="text-white mb-5">{{trans('file.verify')}}</h2>
                </div>



                <div class="col-12 ">
                    <div class="bg-light contact_us rounded pt-3 pb-3 p-2">

                    {{ Form::open(['action' => 'FrontController@mobileVerifyStore']) }}

						@if (Session::has('message'))
							<div class="alert alert-dismissible alert-{{Session::get('status')}}">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
								{{Session::get('message')}}
							</div>
						@endif
						@if (count($errors) > 0)
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->all() as $error)
									  <li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif

						<div class="col-12 offset-0 col-sm-6 offset-sm-3">
	                      	<div class="row">
		                        <div class="col-sm-9 form-group">
		                            {!! Form::text('code', null, ['required', 'class' => 'form-control required','placeholder'=>trans('file.code'),'onkeyup'=>'this.value=this.value.replace(/[^\d]/,"")']) !!}
		                        </div>
								<div class="col-sm-3 form-group">
								  {!! Form::submit(trans('file.send_message'), array('class'=>'btn btn-primary')) !!}

								</div>
							</div>
						</div>
					{{ Form::close() }}

					في حال عدم وصول الكود يرجى التأكد من تحديث الملف الشخصي برقم جوال صحيح واعادة الارسال من خلال هذا <a href="{{url('/mobile/resend')}}">الزر</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection