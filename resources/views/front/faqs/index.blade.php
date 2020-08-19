@extends('layouts.inner')

@section('title')
	{{trans('file.faqs')}}
@endsection


@section('content')
<section class="banner">
	<div class="container">
		<h1 class="title">{{trans('file.faqs')}}</h1>
	</div>
</section>


<section class="faqs">
    <div class="container">

		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="home" aria-selected="true">{{trans('file.all_faqs')}}</a>
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
				@if(count($faqs))
					<div class="vertical">
						@foreach ($faqs as $faq)
							<div class="question"> {{ $faq->question[App::getLocale()]}}</div>
							<div class="answer">{{ $faq->answer[App::getLocale()]}}</div>
						@endforeach
					</div>
				@endif
			</div>

			@if (count($departments))
				@foreach ($departments as $department)
					<div class="tab-pane fade" id="department-{{ $department->id }}" role="tabpanel" aria-labelledby="department-{{ $department->id }}-tab">
            			<div class="vertical">
				  			@if (count($department->faqs))
					      		@foreach ($department->faqs as $faq)
									<div class="question"> {{ $faq->question[App::getLocale()]}}</div>
									<div class="answer">{{ $faq->answer[App::getLocale()]}}</div>
							    @endforeach
						  	@endif
				  	</div>
				@endforeach
			@endif

		</div>



	</div>

</section><!-- #content end -->


@endsection
