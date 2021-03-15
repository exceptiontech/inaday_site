@extends('layouts.admin')

@section('content')

<section class="content">
    <div class="row">
        <div class="col-xs-12">

        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">{{trans('admin.editsection')}}</h3>
            </div>
            <div class="box-body">

                {{ Form::model($section, array('route' => array('sections.update', $section->id), 'method' => 'PUT')) }}

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                        @foreach (Config::get('languages') as $lang => $language)
                            
                            <li class="@if ($lang == App::getLocale()) active @endif"><a data-toggle="tab" href="#{{$lang}}">{{$language}}</a></li>

                        @endforeach
                        </ul>

                        <div class="tab-content">

                        @foreach (Config::get('languages') as $lang => $language)

                                <div id="{{$lang}}" class="tab-pane fade  @if ($lang == App::getLocale()) in active @endif">

                                    <div class="form-group">
                                        {!! Form::label('title-'.$lang, trans('admin.title').' - '.$language ) !!}
                                        {!! Form::text('title['.$lang.']', $section->title[$lang], ['required','class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('desc-'.$lang, trans('admin.desc').' - '.$language) !!}
                                        {!! Form::textarea('desc['.$lang.']', $section->desc[$lang], 
                                            array('required', 
                                                  'class'=>'textarea form-control', 
                                                  'placeholder'=>trans('admin.desc'))) !!}
                                    </div>
                                </div>
                        @endforeach

                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                {!! Form::label('slug', trans('admin.slug')) !!}
                                {!! Form::text('slug', $section->slug, ['required', 'class' => 'form-control', 'readonly' => 'readonly']) !!}
                            </div>
                            <div class="col-sm-6">
                                <div class="@if($section->image) col-sm-9  @endif"> 
                                    {!! Form::label('image', trans('admin.image')) !!}
                                    {!! Form::file('image', array( 'class' => 'form-control')) !!}
                                </div>
                                @if($section->image)
                                <div class="col-sm-3"> 
                                    <img src="{{ url('/'.$section->image) }}" class="img-responsive img-circle" >
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('is_active', trans('admin.status')) !!}
                        {!! Form::select('is_active', ['1' => trans('admin.yes'), '0' => trans('admin.no')], $section->is_active, array( 'class' => 'form-control')) !!}
                    </div>

                </div>
                <div class="box-footer">
                    <div class="form-group">
                        {!! Form::submit(trans('admin.save'), 
                          array('class'=>'btn btn-warning')) !!}
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