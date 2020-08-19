@extends('layouts.inner')
@section('title')
{{__('file.services')}}

@endsection
@section('content')
<section class="banner">
    <div class="container">
      <h1 class="title">{{__('file.services')}}</h1>
    </div>
  </section>


<section class="book-online">
    <div class="container">
        @if (count($sections))
            @foreach ($sections as $section)
                <div class="col-sm-4">
                  <a class="btn btn-primary" href="{{ url('services?section_id='.$section->id) }}" >{{ @$section->title[App::getLocale()] }}</a>
                </div>
            @endforeach
        @endif


      <div class="col-sm-12">
          @if (count($services))
              @foreach ($services as $service)
                <div class="book-item">
                  <div class="row">
                    <div class="col-sm-8 item"><img src="{{ url('uploads/'.$service->img) }}" alt="{{ $service->user->first_name.' '.$service->user->last_name }}" title="{{ $service->user->first_name.' '.$service->user->last_name }}">
                      <div class="contant"><a class="title" >{{$service->title}}</a>
                        <p>{{$service->desc}}</p>
                      </div>
                    </div>
                    <div class="col-sm-2 item">
                      <div class="contant">
                        <p>{{ $service->duration}} {{trans('file.hour')}}</p>
                        <p>{{ $service->cost}} {{trans('file.sr')}}</p>
                      </div>
                    </div>
                    <div class="col-sm-2 align-middle align-items-center pt-3">
                      <a class="btn btn-primary btn-block mb-1" href="{{url('/services/'.$service->title)}}" >{{__('file.service_details')}}</a>

                      <form action="{{ url('paypal/'.$service->title.'/'.$service->id.'/charge') }}" method="post">
                          <input type="hidden" name="amount" value="{{ $service->cost}}" />
                          {{ csrf_field() }}
                          <button class="btn btn-secondary btn-block">{{__('file.book_service')}}</button>
                      </form>

                    </div>
                  </div>
                </div>
              @endforeach
              {{ $services->appends(request()->input())->links() }}
          @else
              <div class="alert alert-danger">
                  <i class="fa fa-exclamation-triangle"></i> {{trans('file.no_services')}}
              </div>
          @endif
        </div>



      </div>
    </div>
  </section>

@endsection
