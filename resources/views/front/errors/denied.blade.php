@extends('layouts.inner')
@section('content')


    <div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">{{trans('file.nothavepermissions')}}</h2>
                </div>

                <div class="col-12">
                    <div class="bg-light mt-5 p-3  wrapper profile rounded">
                        <div class="row">
                        	<div class="col-12">
							    <h2 class="title"> {{trans('file.nothavepermissions')}}</h2>
							    <p class="text">  في حال عدم تفعيل الحساب يرجي تفعيل الحساب عن طريق الرابط التالي  <a href="{{url('/mobile/verify')}}">بالضغط هنا </a> </p>
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

