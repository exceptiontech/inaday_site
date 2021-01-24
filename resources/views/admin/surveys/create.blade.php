@extends('layouts.admin')

@section('content')
<section class="content">
    <div class="row">
        
        <div class="col-12">

        <div class="box box-warning">
            <div class="box-body">

                {{ Form::open(['action' => 'Admin\SurveyController@store', 'files'=>true,'novalidate'=>'novalidate']) }}

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
                        <h4 class="card-title mb-3">{{trans('admin.addsurvey')}}</h4>
                                

                            
                        <div class="form-group">
                            {!! Form::label('title', trans('admin.title') ) !!}
                            {!! Form::text('title', null, ['required','class' => 'form-control','autocomplete'=>'off','id'=>'title']) !!}
                        </div>


                        <div class="form-group">
                            {!! Form::label('desc', trans('admin.desc')) !!}
                            {!! Form::textarea('desc', null, 
                                array('required', 
                                      'class'=>'textarea form-control', 
                                      'placeholder'=>trans('admin.desc'))) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('role_id', trans('admin.roles')) !!}
                            {!! Form::select('role_id', $roles->pluck('name','id'),null, array('class' => 'form-control')) !!}
                        </div>


                        <div class="form-group">
                            {!! Form::label('start_date', trans('admin.start_date')) !!}
                            {!! Form::text('start_date', null, ['required','class' => 'form-control','id'=>'start_date']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('end_date', trans('admin.end_date')) !!}
                            {!! Form::text('end_date', null, ['required','class' => 'form-control','id'=>'end_date']) !!}
                        </div>


                        <div class="form-group">
                            {!! Form::label('is_active', trans('admin.status')) !!}
                            {!!Form::select('is_active', ['1' => trans('admin.yes'), '0' => trans('admin.no')], '1', ['required', 'class' => 'form-control']) !!}
                        </div>

                        <div id="questions">

                            <div class="questions">

                            </div>

                            <div class="form-group">
                                <a id="add_question" class="btn btn-secondary" href="#">اضف سؤال</a>
                            </div>
                        </div>

                        <div class="box-footer">
                            <div class="form-group">
                                {!! Form::submit(trans('admin.add'), array('class'=>'btn btn-warning')) !!}
                            </div>
                        </div>

                    </div>


    
                </div>

                {{ Form::close() }}
            </div>
        </div>
</section>
@endsection

@section('jquery')

<script type="text/javascript">
    
    $("#title_en").keyup(function(){
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp,'-');
        $("#slug").val(Text);        
    });

    $("#title_en").dblclick(function(){
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp,'-');
        $("#slug").val(Text);        
    });

    $('#add_question').click(function(event){

        event.preventDefault();

        var html =  '';
            html += '{!! Form::label('question_title', trans('admin.question_title')) !!}';
            html += '{!! Form::text('questions[][question_title]', null, ['required', 'class' => 'form-control',]) !!}';
            html += '{!! Form::text('[questions]question_desc', null, ['required', 'class' => 'form-control',]) !!}';

        $('#questions .questions').append(html);

        console.log('Done');

    });



</script>
@endsection