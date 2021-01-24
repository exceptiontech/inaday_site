@extends('layouts.admin')

@section('content')

<section class="content">
    <div class="row">
        <div class="col-12">

        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">{{trans('admin.editsurvey')}}</h3>
            </div>
            <div class="box-body">

                {{ Form::model($survey, array('route' => array('surveys.update', $survey->id), 'method' => 'PUT')) }}


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
                        <h4 class="card-title mb-3">{{trans('admin.editsurvey')}}</h4>
                        <div class="form-group">
                            {!! Form::label('title', trans('admin.title')) !!}
                            {!! Form::text('title', $survey->title, ['required','class' => 'form-control','autocomplete'=>'off','id'=>'title']) !!}
                        </div>


                        <div class="form-group">
                            {!! Form::label('desc', trans('admin.desc')) !!}
                            {!! Form::textarea('desc', $survey->desc, 
                                array('required', 
                                      'class'=>'textarea form-control', 
                                      'placeholder'=>trans('admin.desc'))) !!}
                        </div>


                        <div class="form-group">
                            {!! Form::label('role_id', trans('admin.roles')) !!}
                            {!! Form::select('role_id', $roles->pluck('name','id'),$survey->role_id, array('class' => 'form-control')) !!}
                        </div>


                        <div class="form-group">
                            {!! Form::label('start_date', trans('admin.start_date')) !!}
                            {!! Form::text('start_date', $survey->start_date, ['required','class' => 'form-control','id'=>'start_date']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('end_date', trans('admin.end_date')) !!}
                            {!! Form::text('end_date', $survey->end_date, ['required','class' => 'form-control','id'=>'end_date']) !!}
                        </div>


                        <div class="form-group">
                            {!! Form::label('is_active', trans('admin.status')) !!}
                            {!!Form::select('is_active', ['1' => trans('admin.yes'), '0' => trans('admin.no')], $survey->is_active, ['required', 'class' => 'form-control']) !!}
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