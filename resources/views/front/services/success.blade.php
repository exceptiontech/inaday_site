@extends('layouts.register_layout')
@section('title')
{{__('file.servives_provider_register')}}
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
      <a href="{{url('/')}}"> <img src="{{url('assets/images/logo.png')}}" alt="d24" title="d24"></a>
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
                <div class="col-sm-12"><h3  style="text-align: center; color :#053a68; font-size:24px;font-weight:bolder;line-height:2">{{trans('file.thank_you_for_being_ambitious_and_seeking_work')}}</h3></div>
                <div class="col-sm-12"><p  style="text-align: center; color :#4f5153; font-size:24px;line-height:2"> {{trans('file.you_will_achieve_your_dreams_and_the_dreams_of_many_people_around_you..')}}</p></div>
                <div class="col-sm-12"><p  style="text-align: center; color :#59cc4a; font-size:24px;line-height:2">{{trans('file.we_will_contact_you_soon..')}} </p></div>
                <div class="col-sm-12"><p  style="text-align: center; color :#59cc4a; font-size:24px;line-height:3;text-decoration:underline"> <a href="{{ route('home') }}">{{trans('file.return_to_home_page')}}</a> </p></div>

              </div>
            </div>
          </div>
        </section>


          </div>



      </div>
    </section>

@endsection


