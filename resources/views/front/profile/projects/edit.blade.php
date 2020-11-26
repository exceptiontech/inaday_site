
@extends('layouts.inner')
@section('title')
@endsection
@section('content')
<div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">{{ __('file.project_managment') }}</h2>
                </div>


                <div class="bg-light mt-5 p-3 profile  wrapper rounded">
                    <div class="row">
                        <div class="col-12  profile-head-menu mb-5">

                                @include('front.profile.parts.menu')
                        </div>


                        <div class="col-12 title mb-5">
                            <h2>{{__('forms.edit')}}</h2>
                        </div>

                        <div class="col-12 col-sm-8">


                            @if (Session::has('message'))
                              <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                                    {{Session::get('message')}}
                              </div>
                            @endif

                            {{ Form::model($project, array('route' => array('front_projects.update', $project->id), 'method' => 'PUT', 'files'=>true)) }}

                                @if(count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger alert-dismissable" >
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h6>{{ $error}}</h6>
                                        </div>
                                    @endforeach
                                @endif



                                <div class="row mb-4">
                                    <div class="col-6">
                                        {!! Form::label('title', trans('forms.project_name'))!!}
                                        {!! Form::text('title', $project->title, ['required','class' => 'form-control']) !!}
                                    </div>
                                    <div class="col-6">
                                        {!! Form::label('title', trans('forms.section'))!!}
                                        {!! Form::select('section_id',$sections->pluck('title.'.App::getLocale(),'id'), $project->section_id,['required', 'class' => 'form-control']) !!} 
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        {!! Form::label('desc', trans('forms.project_desc'))!!}
                                        {!! Form::textarea('desc',$project->desc, array('class'=>'textarea form-control', 'rows'=>'3', 'id'=>'desc')) !!}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        {!! Form::label('files', trans('forms.files'))!!}
                                        {!! Form::file('files', array( 'class' => 'form-control')) !!}
                                    </div>

                                    <div class="col-12 mt-3">
                                      @if(count($project->files) > 0)
                                          @foreach($project->files as $file)
                                              <p class="p-0">
                                                  <a download="download" href="{{url($file->url)}}">
                                                      <i class="fa fa-file-word-o" aria-hidden="true"></i> {{$file->name}}
                                                  </a>

                                                  <a class="float-left text-danger" href="{{url('/files/delete/'.$file->id)}}">
                                                      <i class="fa fa-trash"></i>
                                                  </a>
                                              </p>
                                          @endforeach
                                      @endif
                                    </div>

                                </div>


                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6 d-none">
                                        {!! Form::label('applykind_id', trans('forms.applying_type'))!!}
                                        {!! Form::select('applykind_id',$applykinds->pluck('title.'.App::getLocale(),'id'), $project->applykind_id,['required', 'class' => 'form-control']) !!} 
                                    </div>
                                    <div class="col-12 col-sm-12" style="display: none;">
                                        {!! Form::label('num_team', trans('forms.num_team'))!!}
                                        {!! Form::text('num_team', $project->num_team, ['required','class' => 'form-control','onkeyup'=>'this.value=this.value.replace(/[^\d]/,"")']) !!}
                                    </div>

                                </div>


                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('cost', trans('forms.cost'))!!} <sub>(تكلفة المشروع المتوقعة)</sub>
                                        {!! Form::text('cost', $project->cost, ['required','class' => 'form-control','onkeyup'=>'this.value=this.value.replace(/[^\d]/,"")']) !!}
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('duration', trans('forms.duration'))!!}
                                        {!! Form::text('duration', $project->duration, ['required','class' => 'form-control','onkeyup'=>'this.value=this.value.replace(/[^\d]/,"")']) !!}
                                    </div>
                                </div>


<!-- 
                                <div class="row mb-4">
                                    <div class="col-12">
                                    {!! Form::label('skills', trans('forms.skills'))!!}
                                    @if (count($skills))
                                        @foreach($skills as $skill)
                                        <div class="check-item">
                                            <div class="chicksign">
                                                <label class="che-box">
                                                <input @if($project->skills->contains($skill->id)) checked="checked" @endif  name="skills[]" type="checkbox" value="{{$skill->id}}"> <span class="label-text">
                                                  {{$skill->title[App::getLocale()]}} <em>*</em></span>
                                                </label>
                                            </div>
                                        </div>

                                        @endforeach
                                    @endif
                                    </div>
                                </div>
 -->
                                <div class="row mt-5 mb-3">
                                    <div class="col-12">
                                        {!! Form::submit(trans('forms.edit'), array('class'=>'btn btn-primary')) !!}

                                    </div>
                                </div>
                            {{ Form::close() }}




                        </div>
                        <div class="col-12 col-sm-4">
                            @include('front.profile.parts.entrepreneur')
                            
                            @if(Auth::user())
                                @if(count($project->ModelLogs) > 0 && Auth::user()->id == $project->user->id || Auth::user()->isAdmin())
                                <div class="list-group p-0 mt-5 mb-5">
                                    @foreach($project->ModelLogs as $log)
                                        @include('front.projects.parts.log')
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
@endsection