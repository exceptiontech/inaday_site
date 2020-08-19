@extends('layouts.inner')

@section('title')

@endsection

@section('content')

<section class="banner">
  <div class="container">
    <h1 class="title">{{$booking->project->title}}</h1>
  </div>
</section>

<section class="checkout blogs-details">
      <div class="container">


          
          <div class="row">

            <div class="col-sm-8"> 
              <div class="chek-item">
                <div class="innerbox">
                  <h2 class="title">{{$booking->project->title}}</h2>
                    <p>{!! $booking->project->desc !!}</p>

                    <ul>
                      <li>{{trans('file.mount')}} : {{$booking->payment->amount .' '.$booking->payment->currency}} </li>
                      <li>{{trans('file.user')}} : {{$booking->user->first_name}} </li>
                      <li>{{trans('file.date')}} : {{$booking->created_at}} </li>
                      <li>{{trans('file.status')}} : {{$booking->status->title[App::getLocale()]}} </li>
                    </ul>

                </div>
              </div>
              <div class="chek-item">

                  <div class="blogs-in"> 

                    <div class="blog-det">
                      <h3 class="title">{{trans('file.replays')}}</h3>

                      @if (Session::has('message'))
                        <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                              {{Session::get('message')}}
                        </div>
                      @endif

                      @if(count($booking->replays) > 0)

                        @foreach($booking->replays as $replay)
                          <div class="commant"><i class="fas fa-user"> </i>
                            <div class="textcomant">
                              <h5 class="nameuser">{{$replay->user->first_name .' '. $replay->user->last_name}}</h5><span class="calendar"> <i class="far fa-calendar-alt"></i>  {{$replay->created_at}}</span>
                              <p> {{$replay->replay}}</p>
                            </div>
                          </div>

                        @endforeach

                      @else
                      <div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> {{trans('file.no_replays')}}</div>

                      @endif
                    </div>

                  


                    <div class="blog-det">
                      <h3 class="title mb-2">{{trans('file.addreplay')}}</h3>
                      {{ Form::open(['action' => 'ReplayController@store']) }}
                        <div class="row">
                          <div class="col-sm-12 inpudata">
                              {!! Form::hidden('booking_id', $booking->id, ['required', 'class' => 'form-control', 'readonly' => 'readonly']) !!}

                              {!! Form::textarea('replay', null, 
                                  array('required', 
                                        'class'=>'textarea form-control', 
                                        'placeholder'=>trans('file.replay'))) !!}
                          </div>
                          <div class="col-sm-12 inpudata">
                            {!! Form::submit(trans('file.addreplay'), array('class'=>'bottom')) !!}
                          </div>
                        </div>
                      {{ Form::close() }}
                    </div>

                  </div>
                </div>
            </div>

            <div class="col-sm-4 chek-item">
              <div class="innerbox text-center">
                <h2 class="title">{{$booking->project->title}}</h2>
                  <p>{!! \Illuminate\Support\Str::words($booking->project->desc,350,'....')  !!}</p>
                
                <div class="data-item">
                  <p>{{trans('file.date')}} : {{$booking->project->created_at}}</p>
                  <p>{{trans('file.section')}} : 
                    @if($booking->project->section)
                      {{@$booking->project->section->title[App::getLocale()]}} 
                    @else 
                      {{trans('file.without_section')}}
                    @endif</p>
                </div>
              </div>
            </div>

          </div>
        
      </div>
    </section>






@endsection
