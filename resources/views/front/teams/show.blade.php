@extends('layouts.inner')

@section('title')
  {{$service->title}}
@endsection

@section('content')

<section class="banner">
  <div class="container">
    <h1 class="title">{{$service->title}}</h1>
  </div>
</section>
  <section class="profile">
    <div class="container">
      <div class="row">
        <div class="col-sm-3 information">
          <div class="contant text-center">
            <div class="canditate-des">
              <div class="imgcent">
                @if($service->user->userdetails->first()->avater)
                  <img class="img_prev" src="{{ url('/'.$service->user->userdetails->first()->avater) }}" alt="" title="" />
                @else
                  <img class="img_prev" src="{{ url('assets/images/img2.jpg') }}" alt="" title="" />
                @endif

              </div>
              <h3 class="title">{{ $service->user->first_name.' '.$service->user->last_name }}</h3>
              <p class="namejob">{{$service->user->userdetails->first()->position}}</p>

              <p>
                {{$service->user->userdetails->first()->notes}}
              </p>
            </div>
          </div>

        </div>
        <div class="col-sm-9 information">
          <div class="contant">
            <h3 class="title">{{$service->title}} <span class="float-left">{{$service->cost}} {{__('file.riyal')}}  | {{__('file.duration')}} : {{$service->duration}} </span></h3>

            @if($service->img)
              <div class="col-12 mt-4 h-50">
                <img class="img-fluid w-100" style="height: 400px" src="{{url('/uploads/'.$service->img)}}">
              </div>
            @endif

            <div class="service-item">
              <div class="row">
                <div class="col-sm-12 desc">
                  <div class="p-3 pt-5">
                    <p>{{$service->desc}}</p>
                  </div>
              </div>
            </div>
          </div>

          <div class="book d-flex justify-content-center ">
            <div class="col-4">
                <form action="{{ url('paypal/'.$service->title.'/'.$service->id.'/charge') }}" method="post">
                    <input type="hidden" name="amount" value="{{ $service->cost}}" />
                    {{ csrf_field() }}
                    <button class="btn btn-secondary btn-block">{{__('file.book_service')}}</button>
                </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>



@endsection
