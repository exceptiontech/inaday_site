@extends('layouts.inner')

@section('title')
  {{$page->title[App::getLocale()]}}
@endsection


@section('content')
<section class="banner">
  <div class="container">
    <h1 class="title">{{$page->title[App::getLocale()]}}</h1>
  </div>
</section>


<section class="terms-conditions">
  <div class="container">
    <h2 class="title"> {{$page->title[App::getLocale()]}}</h2>
    <p class="text">  {{$page->desc[App::getLocale()]}} </p>
  </div>
</section>


@endsection
