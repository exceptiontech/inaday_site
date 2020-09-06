@extends('layouts.admin')

@section('content')

<section class="content">
    <div class="row">
        <div class="col-12">

        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">{{trans('admin.editproject')}}</h3>
            </div>
            <div class="box-body">

                {{ Form::model($project, array('route' => array('projects.update', $project->id), 'method' => 'PUT')) }}


                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card text-left">
                        <div class="card-body">
                            <h4 class="card-title mb-3">{{trans('admin.editproject')}}</h4>
                            <div class="form-group">
                                {!! Form::label('title', trans('admin.title')) !!}
                                {!! Form::text('title', $project->title, ['required','class' => 'form-control','autocomplete'=>'off','id'=>'title']) !!}
                            </div>


                            <div class="form-group">
                                {!! Form::label('desc', trans('admin.desc')) !!}
                                {!! Form::textarea('desc', $project->desc, 
                                    array('required', 
                                          'class'=>'textarea form-control', 
                                          'placeholder'=>trans('admin.desc'))) !!}
                            </div>




                            <div class="form-group row">

                              <div class="col-sm-12 inpusrach">
                                <label> {{ __('forms.files') }}<em>*</em></label>
                                
                                @if(count($project->files) > 0)
                                <ul class="list-group mb-3">
                                    @foreach($project->files as $file)
                                        <li class="list-group-item">
                                            <a download="download" href="{{url('/uploads/'.$file->name)}}">{{$file->name}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                @endif
                                <div class="input-group">
                                  <label class="input-group-btn"><span class="btn btn-primary"> {{trans('file.browse')}}
                                      <input type="file" name="files[]"  style="display: none;" multiple ></span></label>
                                  <input class="form-control" type="text" readonly>
                                </div>
                              </div>

                              <div class="col-sm-3 inpusrach">
                                <div class="select">
                                   <label>{{ __('forms.applying_type') }}<em>*</em></label><i class="fas fa-sort-down"></i>
                                    <select name="applykind_id" class="form-control required" id="service" >
                                    @if (count($apply_kinds))
                                      @foreach ($apply_kinds as $apply_kind)
                                        <option value="{{ $apply_kind->id }}">{{ @$apply_kind->title[App::getLocale()]}}</option>
                                      @endforeach
                                    @endif
                                    </select>
                                </div>
                              </div>

                              <div class="col-sm-3 inpusrach">
                                <label>{{ __('forms.num_team') }}<em>*</em></label>
                                <input name="num_team" class="form-control required" type="number" min="1" placeholder="{{ __('forms.num_team') }}" value="{{$project->num_team}}" required>
                              </div>



                            </div>


                            <div class="form-group">
                                {!! Form::label('skills', trans('admin.skills')) !!}
                                <div class="clearfix"></div>
                                @foreach($skills as $value)
                                    <label>{{ Form::checkbox('skills[]', $value->id, in_array($value->id, $userskill) ? true : false, array('class' => 'name')) }}
                                    {{ $value->title[App::getLocale()] }}</label>
                                <br/>
                                @endforeach

                            </div>


                            <div class="form-group">
                                {!! Form::label('averagekind_id', trans('admin.averagekinds')) !!}
                                {!! Form::select('averagekind_id', $averagekinds->pluck('title.'.App::getLocale(),'id'),$project->averagekind_id, array('class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('cost', trans('admin.cost')) !!}
                                {!! Form::text('cost', $project->cost, ['required','class' => 'form-control','id'=>'cost']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('costkind_id', trans('admin.costkinds')) !!}
                                {!! Form::select('costkind_id', $cost_kinds->pluck('title.'.App::getLocale(),'id'),$project->costkind_id, array('class' => 'form-control')) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('reward', trans('admin.reward')) !!}
                                {!! Form::text('reward', $project->reward, ['required','class' => 'form-control','id'=>'reward']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('rewardkind_id', trans('admin.rewardkinds')) !!}
                                {!! Form::select('rewardkind_id', $reward_kinds->pluck('title.'.App::getLocale(),'id'),$project->rewardkind_id, array('class' => 'form-control')) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('rule', trans('admin.rule')) !!}
                                {!! Form::text('rule', $project->rule, ['required','class' => 'form-control','id'=>'rule']) !!}
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                <h1 style="font-size: 24px;line-height: 2;font-weight: bolder;"> {{ __('forms.phase_1text') }}</h1>
                                <p>{{ __('forms.phase_1text2') }}</p>
                                </div>
                                <div class="col-sm-4 inpusrach">
                                    <label>{{ __('forms.target_clients') }}<em>*</em></label>
                                    <input name="target_clients" class="form-control required" type="number" min="1" value="{{$project->phase->target_clients ?? ''}}" required>
                                </div>
                                <div class="col-sm-4 inpusrach">
                                    <label>{{ __('forms.target_sales') }}<em>*</em></label>
                                    <input name="target_sales" class="form-control required" type="number" min="1" value="{{$project->phase->target_sales ?? ''}}"  required>
                                </div>
                                <div class="col-sm-4 inpusrach">
                                    <label>{{ __('forms.target_profits') }}<em>*</em></label>
                                    <input name="target_profits" class="form-control required" type="number" min="0" value="{{$project->phase->target_profits ?? ''}}" required>
                                </div>

                            </div>



                            <div class="form-group">
                                {!! Form::label('section_id', trans('admin.section')) !!}
                                {!!Form::select('section_id', $sections->pluck('title.'.App::getLocale(),'id'), $project->section_id , ['required', 'class' => 'form-control']) !!}
                            </div>


                            <div class="form-group">
                                {!! Form::label('is_active', trans('admin.status')) !!}
                                {!!Form::select('is_active', ['1' => trans('admin.yes'), '0' => trans('admin.no')], $project->is_active, ['required', 'class' => 'form-control']) !!}
                            </div>


                            <div class="form-group">
                                {!! Form::label('is_approved', trans('admin.approved')) !!}
                                {!!Form::select('is_approved', ['1' => trans('admin.yes'), '0' => trans('admin.no')], $project->is_approved, ['required', 'class' => 'form-control']) !!}
                            </div>

                            <div class="box-footer">
                                <div class="form-group">
                                    {!! Form::submit(trans('admin.save'), 
                                      array('class'=>'btn btn-warning')) !!}
                                </div>
                            </div>



                        </div>




                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>
</section>
            
</div>
@endsection

@section('jquery')

<script type="text/javascript">
    
    $("#title").keyup(function(){
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp,'-');
        $("#slug").val(Text);        
    });

</script>
@endsection