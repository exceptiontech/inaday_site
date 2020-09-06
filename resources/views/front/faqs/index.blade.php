@extends('layouts.inner')
@section('title')
{{trans('file.faqs')}}

@endsection
@section('content')
<div id="innerpage" class="pt-5 pb-5">
        <div class="container">
            <div class="row">

                <div class="col-12 title">
                    <h2 class="text-white mb-5">{{trans('file.faqs')}}</h2>
                </div>
                <!-- sidebar Begin -->
                <div class="col-12">
                    <div class="bg-light faqs rounded pt-3 pb-3 p-5">

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
									<div id="accordion">
										@foreach ($faqs as $faq)
										  <div class="card">
										    <div class="card-header">
										      <a class="card-link" data-toggle="collapse" href="#collapse{{ $faq->id}}">
										        {{ $faq->question[App::getLocale()]}}
										      </a>
										    </div>
										    <div id="collapse{{ $faq->id}}" class="collapse 
										    @if ($loop->first) show @endif" data-parent="#accordion">
										      <div class="card-body">
										      	{{ $faq->answer[App::getLocale()]}}
										      </div>
										    </div>
										  </div>

										@endforeach
									</div>
								@endif
							</div>

							@if (count($departments))
								@foreach ($departments as $department)
									<div class="tab-pane fade" id="department-{{ $department->id }}" role="tabpanel" aria-labelledby="department-{{ $department->id }}-tab">
				            			<div class="vertical">
								  			@if (count($department->faqs))
												<div id="accordion">
													@foreach ($department->faqs as $faq)
													  <div class="card">
													    <div class="card-header">
													      <a class="card-link" data-toggle="collapse" href="#collapse{{ $faq->id}}">
													        {{ $faq->question[App::getLocale()]}}
													      </a>
													    </div>
													    <div id="collapse{{ $faq->id}}" class="collapse 
													    @if ($loop->first) show @endif" data-parent="#accordion">
													      <div class="card-body">
													      	{{ $faq->answer[App::getLocale()]}}
													      </div>
													    </div>
													  </div>

													@endforeach
												</div>
										  	@endif
								  		</div>
								  	</div>
								@endforeach
							@endif

						</div>

                </div>
                <!-- sidebar End -->

            </div>
        </div>
    </div>

@endsection
@section('jquery')
<script type="text/javascript">

    $( ".collapse" ).each(function() {

    	if ($(this).hasClass('show')) {
    		$(this).parent().find('.card-header').find('a').addClass('colorful');
    		$(this).parent().find('.card-header').find('a').prepend('<i class="fa fa-angle-up" aria-hidden="true"></i>');

    	}else {
    		$(this).parent().find('.card-header').find('a').prepend('<i class="fa fa-angle-left" aria-hidden="true"></i>');
    	}

    	$('.card-header a').click(function() {
    		$('.card-header a').removeClass('colorful');
    		$(this).addClass('colorful');
    	});

    });

</script>

@endsection

