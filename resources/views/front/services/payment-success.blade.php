@extends('layouts.register_layout')
@section('title')
{{__('file.thanks')}}
@endsection
@section('content')

<style>
  .steps
  {
    display: none !important;
    visibility: hidden;
  }
</style>
<section class="signup new-item">
  <div class="step-app">
    <div class="logo">
      <a href="{{url('/')}}"> <img src="{{url('assets/images/logo.png')}}" alt="Inaday" title="Inaday"></a>
    </div>
      <div>
        <h3 style="display:none !important;"></h3>
        <section>
          <div class="row">
            <div class="col-sm-5 rightbox">
              <div class="contant-item">
                <h4 class="titletext">  {{__('forms.thank_u')}}</h4>
              </div>
            </div>
            <div class="col-sm-7 leftbox">
              <div class="row center">
                <div class="col-sm-12">
                  <h1>
                  {{trans('file.your_payment_id')}} {{$payment->payment_id}} , {{trans('file.your_booking_id')}} {{$booking->id}} {{trans('file.please_wait_service_provider')}}
                  </h1>
                </div>


                <div class="col-sm-12"><p  style="text-align: center; color :#59cc4a; font-size:24px;line-height:3;text-decoration:underline"> <a href="{{ route('home') }}">{{trans('file.return_to_home_page')}}</a> </p></div>

              </div>
            </div>
          </div>
        </section>


          </div>



      </div>
    </section>

@endsection


