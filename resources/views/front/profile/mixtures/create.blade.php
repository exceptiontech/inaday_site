@extends('layouts.inner')
@section('content')
<div id="innerpage" class="pt-4 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12 title">
                <h2 class="text-white mb-5">ادارة الخدمات</h2>
            </div>

            <div class="col-12">

                <div class="bg-light mt-5 p-3  profile rounded">
                    <div class="row">
                        <div class="col-12  profile-head-menu mb-5">

                        @include('front.profile.parts.menu')

                        </div>

                        <div class="col-12 title mb-5">
                            <h2>{{trans('forms.add_mixture')}}</h2>
                        </div>

                        <div class="col-12 col-sm-8">
                            
                            {{ Form::open(['action' => 'Account\MixtureController@store', 'files'=>true]) }}
                            
                            @if(count($errors) > 0)
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissable" >
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        {{ $error}}
                                    </div>
                                @endforeach
                            @endif

                                <div class="row mb-4">
                                    <div class="col-12 col-sm-12">
                                        {!! Form::label('title', trans('forms.mixture_name'))!!} <em class="text-danger">*</em>
                                        {!! Form::text('title', null, ['required','class' => 'form-control']) !!}
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('title', trans('forms.mixture_section'))!!} <em class="text-danger">*</em>
                                        {!! Form::select('section_id',$sections->pluck('title.'.App::getLocale(),'id'), null,['required', 'class' => 'form-control']) !!} 
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('img', trans('forms.mixture_image'))!!} <em class="text-danger">*</em>
                                        {!! Form::file('image', array( 'class' => 'form-control')) !!}
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12 mt-5">
                                        {!! Form::label('mixture_desc', trans('forms.mixture_desc'))!!} <em class="text-danger">*</em>
                                        {!! Form::textarea('desc',null, array('required','class'=>'textarea form-control', 'rows'=>'3', 'id'=>'desc')) !!}
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12 col-sm-12">
                                        {!! Form::label('team_members', trans('forms.team_members'))!!} <em class="text-danger">*</em>


                                        @if(count($team->users) > 0 )

                                        <div class="col-12 form-control" style="height: 60px">
                                            <ul class="list-inline m-0 flex-shrink-1">
                                                @foreach($team->users as $user)
                                                    <li class="list-inline-item">
                                                        <div class="bg-light rounded p-1 pb-0"> <img src="{{ url($user->userdetail->first()->avater ?? '/assets/images/logo.png' ) }}" class="rounded-circle img-thumbnail img-icon30 img-fluid" /> {{$user->first_name. ' ' .$user->last_name}}</div>
                                                    </li>
                                                @endforeach
                                            </ul> 

                                        </div>
                                        @endif

                                        <div class="d-none">
                                        @if(count($team->users) > 0 )
                                            <div class="d-flex">
                                            @foreach($team->users as $user)
                                                <div class="col-md-4">
                                                  <div class="gallery-card">
                                                    <div class="gallery-card-body">
                                                      <label class="block-check">
                                                     <img src="{{ url($user->userdetail->first()->avater ?? '/assets/images/logo.png' ) }}" class="img-fluid" />
                                                     <input type="checkbox" name="users[]" value="{{$user->id}}" checked="checked" >
                                                      <span class="checkmark"></span>
                                                      </label>
                                                       <div class="bg-secondary p-2 text-white text-center">{{$user->first_name. ' ' .$user->last_name}}
                                                        </div>
                                                    </div>
                                                  </div>
                                                </div>
                                            @endforeach
                                            </div>
                                        @endif
                                        </div>

                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12 col-sm-12">
                                        {!! Form::label('team_services', trans('forms.team_services'))!!} <em class="text-danger">*</em>


                                        @if(count($team->users) > 0 )
                                            @foreach($team->users as $user)
                                                @foreach($user->services as $service)
                                                <div class="d-flex border-bottom pb-3  mb-3">
                                                    <div class="col-2 align-middle">
                                                        {!! Form::label('service_name', trans('forms.service_name'))!!}
                                                        <p class="mt-2">{{$service->title}}</p>
                                                        <input class="form-control" readonly="readonly" type="hidden" name="services[{{$service->id}}][id]" value="{{$service->id}}">
                                                    </div>
                                                    <div class="col-4">
                                                        {!! Form::label('service_cost', trans('forms.service_cost'))!!}
                                                        <input class="form-control"  type="text" name="services[{{$service->id}}][cost]" value="{{$service->cost}}" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                                                    </div>
                                                    <div class="col-4">
                                                        {!! Form::label('service_duration', trans('forms.service_duration'))!!}
                                                        <input class="form-control"  type="text" name="services[{{$service->id}}][duration]" value="{{$service->duration}}" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                                                    </div>
                                                    <div class="col-2">
                                                        {!! Form::label('service_duration', 'خيارات')!!}
                                                        <div class="clearfix">
                                                        <a class="btn-sm btn btn-danger remove-row" href="#">الغاء </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endforeach

                                            @if(count($team->user->services) > 0)
                                                @foreach($team->user->services as $service)
                                                <div class="d-flex border-bottom pb-3  mb-3">
                                                    <div class="col-2 align-middle">
                                                        {!! Form::label('service_name', trans('forms.service_name'))!!}
                                                        <p class="mt-2">{{$service->title}}</p>
                                                        <input class="form-control" readonly="readonly" type="hidden" name="services[{{$service->id}}][id]" value="{{$service->id}}">
                                                    </div>
                                                    <div class="col-4">
                                                        {!! Form::label('service_cost', trans('forms.service_cost'))!!}
                                                        <input class="form-control"  type="text" name="services[{{$service->id}}][cost]" value="{{$service->cost}}" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                                                    </div>
                                                    <div class="col-4">
                                                        {!! Form::label('service_duration', trans('forms.service_duration'))!!}
                                                        <input class="form-control"  type="text" name="services[{{$service->id}}][duration]" value="{{$service->duration}}" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                                                    </div>
                                                    <div class="col-2">
                                                        {!! Form::label('service_duration', 'خيارات')!!}
                                                        <div class="clearfix">
                                                        <a class="btn-sm btn btn-danger remove-row" href="#">الغاء </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach

                                            @endif
                                        @endif
                                    </div>
                                </div>



                                <div class="row mb-4">
                                    <div class="col-12">
                                      الخبرات 
                                      <div class="row">
                                        @if (count($skills))
                                          @foreach ($skills as $skill)
                                          <div class="col-sm-6 check-item">
                                            <div class="chicksign">
                                              <label class="che-box">
                                                <input
                                                  class="required"
                                                  type="checkbox"
                                                  name="skills[]"
                                                  value="{{$skill->id}}"
                                                /><span class="label-text">
                                                    {{ @$skill->title[App::getLocale()] }}<em>*</em></span
                                                >
                                              </label>
                                            </div>
                                          </div>
                                          @endforeach
                                        @endif

                                        {!! Form::hidden('team_id', $team->id, ['class' => 'form-control']) !!}
                                      </div>
                                    </div>
                                </div>


                                <div class="row mt-5 mb-3">
                                    <div class="col-12">
                                        <button class="btn btn-primary">اضافة خلطة</button>
                                    </div>
                                </div>

                            {{ Form::close() }}

                        </div>

                        <div class="col-12 col-sm-4">
                            <div class="bg-light dark p-3">
                                <div class="text-center mt-n5">
                                    <img src="{{url('images/lamp.svg')}}">
                                </div>
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
    <script type="text/javascript">
        $('.remove-row').click(function(e) {
            e.preventDefault();
            $(this).parent().parent().parent().remove();
        });
    </script>
@endsection