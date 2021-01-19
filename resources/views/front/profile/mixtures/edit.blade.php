@extends('layouts.inner')

@section('content')
<div id="innerpage" class="pt-4 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12 title">
                <h2 class="text-white mb-5">{{ __('file.services_managment') }}</h2>
            </div>

            <div class="col-12">

                <div class="bg-light mt-5 p-3  profile rounded">
                    <div class="row">
                        <div class="col-12  profile-head-menu mb-5">

                            @include('front.profile.parts.menu')

                        </div>

                        <div class="col-12 title mb-5">
                            <h2>{{__('forms.edit')}}</h2>
                        </div>

                        <div class="col-12 col-sm-8">

                            {{ Form::model($mixture, array('route' => array('front_mixtures.update', $mixture->id), 'method' => 'PUT', 'files'=>true)) }}

                                @if(count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger alert-dismissable" >
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h4>{{ $error}}</h4>
                                        </div>
                                    @endforeach
                                @endif



                                <div class="row mb-3">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('title', trans('forms.mixture_name'))!!}
                                        {!! Form::text('title', $mixture->title, ['required','class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('title', trans('forms.mixture_section'))!!}
                                        {!! Form::select('section_id',$sections->pluck('title.'.App::getLocale(),'id'), $mixture->section_id,['required', 'class' => 'form-control']) !!} 
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-12 col-sm-12">
                                        {!! Form::label('img', trans('forms.mixture_image'))!!}
                                        @if($mixture->image)
                                        <div class="row">
                                            <div class="col-10">
                                                {!! Form::file('image', array( 'class' => 'form-control')) !!}
                                            </div>
                                            <div class="col-2">
                                                <img src="{{url($mixture->image)}}" class="img-fluid">
                                            </div>
                                        </div>
                                        @else
                                            {!! Form::file('image', array( 'class' => 'form-control')) !!}
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12 mt-5">
                                        {!! Form::label('desc', trans('forms.mixture_desc'))!!}
                                        {!! Form::textarea('desc',$mixture->desc, array('class'=>'textarea form-control', 'rows'=>'3', 'id'=>'desc')) !!}
                                    </div>
                                </div>



                                <div class="row mb-4">
                                    <div class="col-12 col-sm-12">
                                        {!! Form::label('team_members', trans('forms.team_members'))!!} <em class="text-danger">*</em>

                                        @if(count($mixture->team->users) > 0 )

                                        <div class="col-12 form-control" style="min-height: 60px">
                                            <ul class="list-inline m-0 flex-shrink-1">
                                                @foreach($mixture->team->users as $user)
                                                    <li class="list-inline-item">
                                                        <div class="bg-light rounded p-1 pb-0"> <img src="{{ url($user->userdetail->first()->avater ?? '/assets/images/logo.png' ) }}" class="rounded-circle img-thumbnail img-icon30 img-fluid" /> {{$user->first_name. ' ' .$user->last_name}}</div>
                                                    </li>
                                                @endforeach
                                            </ul> 

                                        </div>
                                        @endif

                                        
                                    </div>
                                </div>



                                <div class="row mb-4">
                                    <div class="col-12 col-sm-12">
                                        {!! Form::label('team_services', trans('forms.team_services'))!!} <em class="text-danger">*</em>


                                        @if(count($mixture->team->users) > 0 )
                                            @foreach($mixture->team->users as $user)
                                                @foreach($user->confirmServices() as $service)
                                                <div class="d-flex border-bottom pb-3  mb-3 @if(in_array($service->id, $mixture->services->pluck('id')->toArray() )) bg-primary border-0 @endif">
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

                                            @if(count($mixture->team->user->services) > 0)
                                                @foreach($mixture->team->user->services as $service)
                                                <div class="d-flex border-bottom pb-3  mb-3 @if(in_array($service->id, $mixture->services->pluck('id')->toArray() )) bg-primary border-0 @endif">
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
                                    {!! Form::label('skills', trans('forms.skills'))!!}
                                    @if (count($skills))
                                        @foreach($skills as $skill)
                                        <div class="check-item">
                                            <div class="chicksign">
                                                <label class="che-box">
                                                <input @if($mixture->skills->contains($skill->id)) checked="checked" @endif  name="skills[]" type="checkbox" value="{{$skill->id}}"> <span class="label-text">
                                                  {{$skill->title[App::getLocale()]}} <em>*</em></span>
                                                </label>
                                            </div>
                                        </div>

                                        @endforeach
                                    @endif
                                    </div>
                                </div>

                                <div class="row mt-5 mb-3">
                                    <div class="col-12">
                                        {!! Form::submit(trans('file.edititem'), array('class'=>'btn btn-primary')) !!}

                                    </div>
                                </div>
                            {{ Form::close() }}




                        </div>
                        <div class="col-12 col-sm-4">
                            @include('front.profile.parts.service_provider')
                            
                            @if(Auth::user())
                                @if(count($mixture->ModelLogs) > 0 && Auth::user()->id == $mixture->team->user->id || Auth::user()->isAdmin())
                                <div class="list-group p-0 mt-5 mb-5">
                                    @foreach($mixture->ModelLogs as $log)
                                        @include('front.mixtures.parts.log')
                                    @endforeach
                                </div>
                                @endif
                            @endif


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