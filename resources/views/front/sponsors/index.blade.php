@extends('layouts.inner')

@section('title')
	{{trans('file.sponsors')}}
@endsection


@section('content')
<section class="banner">
	<div class="container">
		<h1 class="title">{{trans('file.sponsors')}}</h1>
	</div>
</section>


@if(count($departments))
	@foreach ($departments as $department)

	    <section class="sponsors">
	      <div class="container">
	        <h2 class="title">{{$department->title[App::getLocale()]}}</h2>
	        <nav class="row">

				@if(count($department->sponsors))
					@foreach ($department->sponsors as $sponsor)

			          <div class="col-sm-2 pr-item"><a class="logo-cast" href="#" target="_blank"><img src="{{$sponsor->image}}" alt="{{$sponsor->title[App::getLocale()]}}"></a></div>

			        @endforeach
			    @endif
	        </nav>
	      </div>
	    </section>

	@endforeach
@else
	    <section class="sponsors">
	      	<div class="container">
	        	<h2 class="title">{{trans('file.no_results_found')}}</h2>
	    	</div>
	    </section>

@endif


@endsection
