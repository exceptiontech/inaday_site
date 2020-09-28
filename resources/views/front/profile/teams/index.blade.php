@extends('layouts.inner')
@section('content')


    <div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">ادارة الخدمات</h2>
                </div>

                <div class="col-12">
                    <div class="bg-light mt-5 p-3  wrapper profile rounded">
                        <div class="row">

                            <div class="col-12  profile-head-menu mb-5">

                                @include('front.profile.parts.menu')
                            </div>

                            @if (Session::has('message'))
                            <div class="col-12">
                              <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                                    <h6>{{Session::get('message')}}</h6>
                              </div>
                            </div>
                            @endif


                            <div class="col-12 col-sm-8 profile-content services mb-5">

                                <!-- services -->
                                <div class="col-12 sub-title mt-5">
                                    <h3 class="mb-3">الفرق المشارك بها</h3>
                                </div>
                                

                                @if(count(Auth::user()->teams) > 0 )
                                  @foreach(Auth::user()->teams as $team)
                                    <div class="col-12 service pb-3 pt-2">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <img class="img-fluid" src="{{url($team->image ?? '/assets/images/logo.png')}}">
                                            </div>
                                            <div class="col-sm-10">
                                                <div class="row mb-2">
                                                    <div class="col-9">
                                                        <h2 class="mb-3">{{$team->title ?? 'فريق بدون اسم' }}</h2>
                                                        <div class="dropdown">
                                                            <button class="btn bg-light dropdown-toggle" type="button" id="memberWrapper" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            اعضاء الفريق
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="memberWrapper">
                                                                @if(count($team->users)>0)
                                                                    @foreach($team->users as $user)
                                                                    <a class="dropdown-item" href="#">
                                                                        {{Auth::user()->first_name. ' ' .Auth::user()->last_name}}
                                                                    </a>
                                                                    @endforeach
                                                                @else
                                                                <a class="dropdown-item"  href="#">لم يتم اضافة اي اعضاء للفريق</a>

                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                    @if(Auth::user()->id != $team->user_id)
                                                      @if($team->pivot->is_approved != 1)

                                                          {{ Form::open(['action' => 'Account\TeamController@acceptRequest']) }}
                                                          
                                                          {!! Form::hidden('id',$team->id ) !!}

                                                          {!! Form::submit(trans('profile.accept'), array('class'=>'btn btn-primary btn-block mb-2')) !!}
                                                          {{ Form::close() }}

                                                          {{ Form::open(['action' => 'Account\TeamController@refusedRequest']) }}
                                                          
                                                          {!! Form::hidden('id',$team->id ) !!}

                                                          {!! Form::submit(trans('profile.refused'), array('class'=>'btn btn-danger btn-block ')) !!}
                                                          {{ Form::close() }}


                                                      @else


                                                          {{ Form::open(['action' => 'Account\TeamController@cancelRequest']) }}
                                                          
                                                          {!! Form::hidden('id',$team->id ) !!}

                                                          {!! Form::submit(trans('profile.cancel'), array('class'=>'btn btn-danger btn-block ')) !!}
                                                          {{ Form::close() }}


                                                      @endif 
                                                    </div>
                                                    @endif 

                                                    </div>

                                                </div>


                                            </div>
                                        </div>
                                  @endforeach

                                @else
                                    <p>انت لا تمتلك فريق حتى الان كون فريقك الان </p>
                                @endif



                            </div>




                            <div class="col-12 col-sm-4">
                                <div class="bg-light dark p-3">
                                    <div class="text-center mt-n5">
                                        <img src="{{url('/images/lamp.svg')}}">
                                    </div>
                                    <p class="mt-5">
                                        - أنت مقدم خدمه و تعرف تقدم خدمه و تقدر تحدد كل متطلبات المشروع من وقت و تكلفة. حدد كم مستعد تستثمر في كل مهمة.
                                    </p>
                                    <p class="mt-5">
                                        - أنت مقدم خدمه و تعرف تقدم خدمه و تقدر تحدد كل متطلبات المشروع من وقت و تكلفة. حدد كم مستعد تستثمر في كل مهمة.
                                    </p>
                                    <p class="mt-5">
                                        - أنت مقدم خدمه و تعرف تقدم خدمه و تقدر تحدد كل متطلبات المشروع من وقت و تكلفة. حدد كم مستعد تستثمر في كل مهمة.
                                    </p>
                                </div>
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