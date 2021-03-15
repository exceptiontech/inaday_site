@extends('layouts.admin')

@section('content')

<section class="content">
    <div class="row">
        <div class="col-12">

        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">{{trans('admin.editstage')}}</h3>
            </div>
            <div class="box-body">

                {{ Form::model($stage, array('route' => array('stages.update', $stage->id), 'method' => 'PUT')) }}


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
                            <h4 class="card-title mb-3">{{trans('admin.editstage')}}</h4>
                            <ul class="nav nav-pills" id="myPillTab" role="tablist">

                                @foreach (Config::get('languages') as $lang => $language)
                                    

                                    <li class="nav-item"><a class="nav-link @if ($lang  == App::getLocale()) active show @endif " id="{{$lang}}-icon-pill" data-toggle="pill" href="#{{$lang}}" role="tab" aria-controls="homePIll" aria-selected="true">{{$language}}</a></li>

                                @endforeach

                                
                            </ul>
                            <div class="tab-content" id="myPillTabContent">
                                @foreach (Config::get('languages') as $lang => $language)

                                <div class="tab-pane  @if ($lang == App::getLocale()) fade active show @endif " id="{{$lang}}" role="tabpanel" aria-labelledby="{{$lang}}-icon-pill">
                                    <div class="form-group">
                                        {!! Form::label('title-'.$lang, trans('admin.title').' - '.$language ) !!}
                                        {!! Form::text('title['.$lang.']', $stage->title[$lang], ['required','class' => 'form-control','autocomplete'=>'off','id'=>'title_'.$lang]) !!}
                                    </div>


                                </div>
                               @endforeach
                            </div>

                            <div class="form-group">
                                {!! Form::label('slug', trans('admin.slug')) !!}
                                {!! Form::text('slug', $stage->slug, ['required', 'class' => 'form-control', 'readonly' => 'readonly']) !!}
                            </div>




                            <div class="form-group">
                                {!! Form::label('is_active', trans('admin.status')) !!}
                                {!!Form::select('is_active', ['1' => trans('admin.yes'), '0' => trans('admin.no')], $stage->is_active, ['required', 'class' => 'form-control']) !!}
                            </div>

                            <div class="box-footer">
                                <div class="form-group">
                                    {!! Form::submit(trans('admin.save'), 
                                      array('class'=>'btn btn-primary')) !!}
                                </div>
                            </div>


                        </div>
                        {{ Form::close() }}
                        </div>
                    </div>

                    </div>


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