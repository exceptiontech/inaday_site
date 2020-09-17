
@extends('layouts.inner')
@section('title')
@endsection
@section('content')
<div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">ادارة المشاريع</h2>
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
                                              </p>
                                          @endforeach
                                      @endif
                                    </div>

                                </div>


                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('applykind_id', trans('forms.applying_type'))!!}
                                        {!! Form::select('applykind_id',$applykinds->pluck('title.'.App::getLocale(),'id'), $project->applykind_id,['required', 'class' => 'form-control']) !!} 
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('num_team', trans('forms.num_team'))!!}
                                        {!! Form::text('num_team', $project->num_team, ['required','class' => 'form-control','placeholder'=>'1']) !!}
                                    </div>

                                </div>


                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('cost', trans('forms.cost'))!!} <sub>(تكلفة المشروع المتوقعة)</sub>
                                        {!! Form::text('cost', $project->cost, ['required','class' => 'form-control','onkeyup'=>'this.value=this.value.replace(/[^\d]/,"")']) !!}
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        {!! Form::label('duration', trans('forms.duration'))!!}
                                        {!! Form::text('duration', $project->duration, ['required','class' => 'form-control','onkeyup'=>'this.value=this.value.replace(/[^\d]/,"")']) !!}
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        {!! Form::label('duration_type', trans('forms.duration_type'))!!}
                                        {!! Form::select('costkind_id',$costkinds->pluck('title.'.App::getLocale(),'id') , $project->costkind_id,['required', 'class' => 'form-control']) !!} 
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('reward', trans('forms.reward'))!!}
                                        {!! Form::text('reward', $project->reward, ['class' => 'form-control','onkeyup'=>'this.value=this.value.replace(/[^\d]/,"")']) !!}
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        {!! Form::label('rewardkind_id', trans('forms.rewardkind'))!!}
                                        {!! Form::select('rewardkind_id',$rewardkinds->pluck('title.'.App::getLocale(),'id'), $project->rewardkind_id,['required', 'class' => 'form-control']) !!} 
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                      {!! Form::label('skills', trans('forms.skills'))!!}
                                      {{ Form::select('skills[]', $skills->pluck('title.'.App::getLocale(),'id'), array_pluck($project->skills, 'id'), ['required'=>'required','multiple', 'class' => 'form-control']) }}

                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <div class="col-12">
                                        {!! Form::label('rule', trans('forms.rule'))!!}
                                        {!! Form::textarea('rule',$project->rule, array('class'=>'textarea form-control', 'rows'=>'3', 'placeholder'=>'مثال: عند الانتهاء من المشروع في اقل من اسبوع')) !!}
                                    </div>
                                </div>

                                <div class="row mt-5 mb-3">
                                    <div class="col-12">
                                        {!! Form::submit(trans('forms.edit'), array('class'=>'btn btn-primary')) !!}

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
                                  <!-- <p class="mt-5">
                                      - أنت مقدم خدمه و تعرف تقدم خدمه و تقدر تحدد كل متطلبات المشروع من وقت و تكلفة. حدد كم مستعد تستثمر في كل مهمة.
                                  </p>
                                  <p class="mt-5">
                                      - أنت مقدم خدمه و تعرف تقدم خدمه و تقدر تحدد كل متطلبات المشروع من وقت و تكلفة. حدد كم مستعد تستثمر في كل مهمة.
                                  </p> -->
                            </div>
                        </div>
                    </div>
                </div>
                    
            </div>
        </div>
    </div>
@endsection