@extends('layouts.inner')

@section('title')
	{{trans('file.search')}}
@endsection


@section('content')
<section class="banner">
	<div class="container">
		<h1 class="title">{{trans('file.search')}}</h1>
	</div>
</section>


<section class="interview p-5">
    <div class="container">

        <div class="row">


            @if(!count($users) && !count($services) && !count($projects))
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-body">

                            {!! trans('file.no_results')!!}
                        </div>
                    </div>                          
                </div>
            @else 
                <div class="col-12 text-center">
                    <h2 class="text-center">{!! trans('file.results')!!}</h2>
                </div>
            @endif

            @if(count($users))
                @foreach($users as $user)
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-body">
                            <a href="#">{{ $user->first_name .' '.$user->last_name }}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif

            @if(count($projects))
                @foreach($projects as $project)
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-body">
                            <a href="{{ url('/projects/'.$project->id) }}">{{$project->title}}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif

            @if(count($services))
                @foreach($services as $service)
                <div class="col-12">
                    <div class="card mt-3">
                    <div class="card-body">
                        <a href="{{ url('/services/'.$service->id) }}">{{$service->title}}</a>
                    </div>
                    </div>
                </div>
                @endforeach
            @endif

        </div>

	</div>

</section>


@endsection
