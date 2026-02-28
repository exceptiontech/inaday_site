@extends('layouts.inner')
@section('title')
{{__('file.services_providers')}}

@endsection
@section('content')
<section class="banner">
    <div class="container">
      <h1 class="title">{{__('file.services_providers')}}</h1>
    </div>
  </section>


<section class="book-online">
    <div class="container">


      @if (Session::has('message'))
        <div class="alert alert-dismissible alert-{{Session::get('status')}}">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
              <h4>{{Session::get('message')}}</h4>
        </div>
      @endif

      <div class="col-12">
        {{ Form::open(['action' => 'TeamController@listServicesProvider','method' => 'get']) }}
          <div id="searchform" class="row bg-white rounded pt-3 pb-3 mb-5 mt-5">
              <div class="col-sm-5">
                  <div class="form-group">
                    {!! Form::label('skill_id', trans('file.skills'))!!}
                      {!!Form::select('skill_id',$skills->pluck('title.'.App::getLocale(),'id'), Request::get('skill_id'), ['class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="col-sm-5">
                  <div class="form-group">
                    {!! Form::label('name', trans('file.user_name'))!!}
                      {!!Form::text('name', Request::get('name'), ['id' => 'name','class' => 'form-control']) !!}
                  </div>
              </div>

              <div class="col-sm-2">  
                  <div class="form-group">
                  <label for="title">&nbsp;</label>
                  {!! Form::button(trans('admin.search'), 
                                array('class'=>'btn btn-block btn-success','id'=>'search-button', 'type'=>'submit')) !!}
                  </div>
              </div>

          </div>
        {{ Form::close() }}
      </div>

      <div class="col-sm-12 beneficiary pt-0">
          @if (count($users))

            <div class="row">
              @foreach ($users as $user)
                <div class="col-sm-4 bene">
                  <div class="itme">
                    <div class="photo"><img src="{{ url($user->userdetail->first()->avater ?? 'assets/images/logo.png') }}" alt="d24" title="d24"></div>
                    <div class="detas-item"> <span class="text-it">قصة نجاح</span><a class="bottom" href="#">{{$user->first_name .' '. $user->last_name}}</a>
                      <div class="calande"><strong>{{$user->userdetail->first()->average_cost ?? '0'}}</strong><span class="text-it">ريال / بالساعة</span></div>
                    </div>
                    <h3>{{$user->first_name .' '. $user->last_name}}</h3>
                    <p>{{$user->userdetail->first()->notes ?? ''}}</p>
                    <div class="serves-it">
                      <h3>خدماتى</h3>

                        @if(count($user->skills))
                          <div class="papers">
                          @foreach($user->skills as $skill)
                            {{$skill->title[App::getLocale()]}} , 
                          @endforeach
                          </div>
                        @else
                          <div class="papers">
                            {{__('file.no_skills')}}
                          </div>
                        @endif
                      
                    </div>
                    <div class="row bot-red">
                      <div class="col">
                        {{ Form::open(['action' => 'TeamController@addUserToTeam']) }}
                                                    
                          {!! Form::hidden('id',$user->id , []) !!}

                          {!! Form::submit(trans('file.add_user_to_your_team'), array('class'=>'bottom')) !!}
                        {{ Form::close() }}

                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>

              {{ $users->appends(request()->input())->links() }}
          @else
              <div class="alert alert-danger">
                  <i class="fa fa-exclamation-triangle"></i> {{trans('file.no_services_providers_right_now')}}
              </div>
          @endif
        </div>



      </div>
    </div>
  </section>

@endsection
