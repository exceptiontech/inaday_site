@extends('layouts.admin')
@section('content')
<section class="content">
    <div class="row">
        
        <div class="col-12">

        <div class="box box-warning">
            <div class="box-body">

				    <div class="box-header">
				    	<h3 class="box-title">{{trans('admin.addsection')}}</h3>
				    </div>
              		<div class="box-body">
					{{ Form::open(['action' => 'Admin\SectionController@store', 'files'=>true]) }}
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
                                    {!! Form::text('title['.$lang.']', null, ['required','class' => 'form-control','autocomplete'=>'off','id'=>'title']) !!}
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
                        </div>
                    </div>

                    </div>

                    
				    <div class="form-group">
				        {!! Form::label('slug',trans('admin.slug')) !!}
				        {!! Form::text('slug', null, ['required', 'class' => 'form-control']) !!}
				    </div>





				    <div class="form-group">
				        {!! Form::label('image', trans('admin.image')) !!}
				        {!! Form::file('image', null, ['required','class' => 'form-control']) !!}
				    </div>
                    
				    <div class="form-group">
				        {!! Form::label('icon',trans('admin.icon')) !!}
				        {!! Form::text('icon', null, ['class' => 'form-control']) !!}
				    </div>


				    <div class="form-group">
				        {!! Form::label('is_active', trans('admin.status')) !!}
					    {!!Form::select('is_active', ['1' => trans('admin.yes'), '0' => trans('admin.no')], '1', ['required', 'class' => 'form-control']) !!}
				    </div>


	              	</div>
					<div class="box-footer">
						<div class="form-group">
						    {!! Form::submit(trans('admin.add'), 
						      array('class'=>'btn btn-warning')) !!}
						</div>
					</div>

					{{ Form::close() }}

				</div>

			</div>
		</div>
	</div>
</section>





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

    $("#title").dblclick(function(){
        var Text = $(this).val();
        Text = Text.toLowerCase();
        var regExp = /\s+/g;
        Text = Text.replace(regExp,'-');
        $("#slug").val(Text);        
    });

  </script>

@endsection
