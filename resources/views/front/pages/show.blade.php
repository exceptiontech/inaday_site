@extends('layouts.inner')

@section('title')
  {{$page->title[App::getLocale()]}}
@endsection


@section('content')

<div id="innerpage" class="pt-5 pb-5">
        <div class="container">
            <div class="row">

                <div class="col-12 title">
                    <h2 class="text-white mb-5">{{$page->title[App::getLocale()]}}</h2>
                </div>
                <div class="col-12">
                    <div class="bg-light faqs rounded pt-3 pb-3 p-5">
                    	{!!$page->desc[App::getLocale()]!!}
                	</div>
            	</div>
        </div>
    </div>
</div>



@endsection
