@extends('layouts.inner')

@section('title')
  {{trans('file.notfound')}}
@endsection


@section('content')
<section class="banner">
  <div class="container">
    <h1 class="title">{{trans('file.notfound')}}</h1>
  </div>
</section>


<section class="terms-conditions">
  <div class="container">
    <h2 class="title"> {{trans('file.notfound')}}</h2>
    <p class="text">  {{trans('file.please_contact_us')}} </p>
  </div>
</section>


@endsection
