@extends('layouts.admin')

@section('content')

<section class="content">
    <div class="row">
        <div class="col-12">

        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">{{trans('admin.editservice')}}</h3>
            </div>
            <div class="box-body">

                {{ Form::model($service, array('route' => array('services.update', $service->id), 'method' => 'PUT')) }}


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
                            <h4 class="card-title mb-3">{{trans('admin.editservice')}}</h4>
                            <div class="form-group">
                                {!! Form::label('title', trans('admin.title')) !!}
                                {!! Form::text('title', $service->title, ['required','class' => 'form-control','autocomplete'=>'off','id'=>'title']) !!}
                            </div>


                            <div class="form-group">
                                {!! Form::label('desc', trans('admin.desc')) !!}
                                {!! Form::textarea('desc', $service->desc, 
                                    array('required', 
                                          'class'=>'textarea form-control', 
                                          'placeholder'=>trans('admin.desc'))) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('cost', trans('admin.cost')) !!}
                                {!! Form::text('cost', $service->cost, ['required','class' => 'form-control','id'=>'cost']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('duration', trans('admin.duration')) !!}
                                {!! Form::text('duration', $service->duration, ['required','class' => 'form-control','id'=>'duration']) !!}
                            </div>


                            <div class="form-group">
                                {!! Form::label('section_id', trans('admin.section')) !!}
                                {!!Form::select('section_id', $sections->pluck('title.'.App::getLocale(),'id'), $service->section_id , ['required', 'class' => 'form-control']) !!}
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

                                <div class="@if($service->image) col-sm-9  @endif"> 
                                    {!! Form::label('image', trans('admin.image')) !!}
                                    {!! Form::file('image', array( 'class' => 'form-control')) !!}
                                </div>
                                @if($service->image)
                                <div class="col-sm-3"> 
                                    <img src="{{ url('/'.$service->image) }}" class="img-responsive img-circle" >
                                </div>
                                @endif

                            </div>




                            <div class="form-group">
                                {!! Form::label('is_active', trans('admin.status')) !!}
                                {!!Form::select('is_active', ['1' => trans('admin.yes'), '0' => trans('admin.no')], $service->is_active, ['required', 'class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('approved', trans('admin.approved')) !!}
                                {!!Form::select('is_approved', ['1' => trans('admin.yes'), '0' => trans('admin.no')], $service->is_approved, ['required', 'class' => 'form-control']) !!}
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