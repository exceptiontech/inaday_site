@extends('layouts.inner')
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
                        	<div class="col-12">
							    <h2 class="title"> {{trans('file.nothavepermissions')}}</h2>
							    <p class="text">  {{trans('file.please_contact_us')}} </p>
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

