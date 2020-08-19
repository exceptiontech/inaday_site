@extends('layouts.admin')

@section('content')
<section class="content">
    <div class="row">
        
        <div class="col-12">

        <div class="box box-warning">
            <div class="box-body">

                {{ Form::open(['action' => 'Admin\QuestionController@store', 'files'=>true,'novalidate'=>'novalidate']) }}

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
                            <h4 class="card-title mb-3">{{trans('admin.addquestion')}}</h4>
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
                                        {!! Form::text('title['.$lang.']', null, ['required','class' => 'form-control','autocomplete'=>'off','id'=>'title_'.$lang]) !!}
                                    </div>


                                    <div class="form-group">
                                        {!! Form::label('desc-'.$lang, trans('admin.desc').' - '.$language) !!}
                                        {!! Form::textarea('desc['.$lang.']', null, 
                                            array('required', 
                                                  'class'=>'textarea form-control', 
                                                  'placeholder'=>trans('admin.desc'))) !!}
                                    </div>
                                </div>
                               @endforeach
                            </div>


                    <div class="form-group">
                        {!! Form::label('value', trans('admin.value')) !!}
                        {!! Form::text('value', 10, ['required','class' => 'form-control','id'=>'title']) !!}
                    </div>


                    <div class="form-group">
                        {!! Form::label('skill_id', trans('admin.department')) !!}
                        {!!Form::select('skill_id', $skills->pluck('title.'.App::getLocale(),'id'), null , ['required', 'class' => 'form-control']) !!}
                    </div>


                    <div class="form-group">
                        {!! Form::label('qtype_id', trans('admin.qtype')) !!}
                        {!!Form::select('qtype_id', $qtypes->pluck('title.'.App::getLocale(),'id'), null , ['required', 'class' => 'form-control']) !!}
                    </div>

                    <div id="options" style="display: none">
                        <div class="form-group">
                            <div class="options-rows">
                            </div>
                        </div>
                        <div class="form-group">
                            <a id="add-row" class="btn btn-info text-white">{{trans('admin.addoption')}}</a>
                        </div>  
                    </div>                    



                    <div class="form-group mt-3">
                        {!! Form::submit(trans('admin.add'), array('class'=>'btn btn-primary')) !!}
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
    
    $("#qtype_id").change(function() {

        if ($( "#qtype_id option:selected" ).val() == 2) {
            $('#options').fadeIn();
        }else {
            $('#options').empty();
            $('#options').fadeOut();
        }
    
  });


    $('#add-row').click(function(){
        var count = $('.options-rows .item').length + 1;
        /* value */
        var row = '<div class="item '+count+' row" ><div class="col-sm-1 align-middle"><a class="btn btn-danger text-left" id="remove'+count+'">حذف</a></div>';
        /* option name */            
        row +='<div class="col-sm-6 form-group"><input class="form-control mb-1" name="options['+count+'][title][ar]" type="text" placeholder="الخيار باللغة العربية" value=""><input class="form-control" name="options['+count+'][title][en]" type="text" placeholder="option in English" value=""></div>';



        /* option is_true */         
        row += '<div class="col-sm-4 form-group"><select required="required" id="type_id'+count+'" class="form-control option_correct" name="options['+count+'][is_true]"><option selected="selected" value="">اختر  </option><option value="1">صحيحة</option><option value="0">غير صحيحة</option></select></div>';

        /* level close */
        row += '<div id="options'+count+'"></div></div>';
        $('.options-rows').append(row);
        $('#remove'+count).click(function(){
            $(this).parent().parent().remove();
        });

    });


</script>
@endsection