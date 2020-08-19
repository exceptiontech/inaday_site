@extends('layouts.inner')

@section('title')
	{{trans('file.blog')}}
@endsection


@section('content')
<section class="banner">
	<div class="container">
		<h1 class="title">{{trans('file.blog')}}</h1>
	</div>
</section>


 <section class="blogs">
    <div class="container">

		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="home" aria-selected="true">{{trans('file.all_posts')}}</a>
			</li>

			@if (count($departments))
				@foreach ($departments as $department)
					<li class="nav-item">
					<a class="nav-link" id="department-{{ $department->id }}-tab" data-toggle="tab" href="#department-{{ $department->id }}" role="tab" aria-controls="profile" aria-selected="false">{{ $department->title[App::getLocale()] }}</a>
					</li>
				@endforeach
			@endif
		</ul>
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
				@if(count($articles))
					@foreach ($articles as $article)
						<div class="blog-itme">
			                <a class="photo" href="{{url('/blog/'.$article->slug)}}"> <img src="{{$article->image}}" alt="{{ $article->title[App::getLocale()]}}" title="{{ $article->getTitle()}}"></a>
			                <div class="contant"> 
			                  <a class="title" href="{{url('/blog/'.$article->slug)}}">{{ $article->title[App::getLocale()]}}</a>
			                  <span class="calendar"> <i class="far fa-calendar-alt"></i> {{$article->created_at }}</span>
			                  <p>{!! \Illuminate\Support\Str::words($article->desc[App::getLocale()],200,'....') !!}</p><a class="more" href="{{url('/blog/'.$article->slug)}}">  {{trans('file.readmore')}}  </a>
			                </div>
		              	</div>

					@endforeach
				@endif
			</div>

			@if (count($departments))
				@foreach ($departments as $department)
					<div class="tab-pane fade" id="department-{{ $department->id }}" role="tabpanel" aria-labelledby="department-{{ $department->id }}-tab">

			  			@if (count($department->articles))
				      		@foreach ($department->articles as $article)

								<div class="blog-itme">
					                <a class="photo" href="{{url('/blog/'.$article->slug)}}"> <img src="{{$article->image}}" alt="{{ $article->getTitle()}}" title="{{ $article->title[App::getLocale()]}}"></a>
					                <div class="contant"> 
					                  <a class="title" href="{{url('/blog/'.$article->slug)}}">{{ $article->title[App::getLocale()]}}</a>
					                  <span class="calendar"> <i class="far fa-calendar-alt"></i> {{$article->created_at }}</span>
					                  <p>{!! \Illuminate\Support\Str::words($article->desc[App::getLocale()],200,'....') !!}</p><a class="more" href="{{url('/blog/'.$article->slug)}}">  {{trans('file.readmore')}}  </a>
					                </div>
				              	</div>

						    @endforeach
					  	@endif
				  	</div>
				@endforeach
			@endif

		</div>



	</div>

</section><!-- #content end -->


@endsection
