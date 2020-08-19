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


<section class="blogs-details">
  <div class="container">
    <div class="row">
      <div class="col-sm-8 blogs-in">
        <div class="blog-det">
          <h3 class="title">{{ $article->getTitle()}}</h3><span class="calendar"> <i class="far fa-calendar-alt"></i>{{ $article->created_at}}</span>
          <div class="photo"><img src="{{$article->image}}" alt="{{ $article->getTitle()}}" title="{{ $article->getTitle()}}"></div>
          <p class="text">{!! $article->getDesc() !!}</p>
          <div class="social-shear">
            <h4 class="title">{{trans('file.share')}}:</h4>

            <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
              <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
              <a class="a2a_button_facebook"></a>
              <a class="a2a_button_twitter"></a>
              <a class="a2a_button_email"></a>
              <a class="a2a_button_whatsapp"></a>
              <a class="a2a_button_linkedin"></a>
              <a class="a2a_button_pinterest"></a>
            </div>
            <script src="https://static.addtoany.com/menu/page.js"></script><!-- AddToAny END -->
          </div>
        </div>

      </div>
      <div class="col-sm-4 blogs-in">
        <div class="blog-det">
          <h3 class="title">{{trans('file.service_providers')}} </h3>
          <nav class="navprogram"><a href="#">{{trans('file.recent_projects')}} </a><a href="#"> {{trans('file.servives_provider_training')}}</a><a href="#"> {{trans('file.feature_packages')}}</a><a href="#"> {{trans('file.calculator')}}</a><a href="#"> {{trans('file.forms_awards')}}</a></nav>
        </div>
        <div class="blog-det">
          <h3 class="title">{{trans('file.other_articles')}}</h3>
          <nav class="feabox">
            @if (count($random))
                @foreach ($random as $random_article)
                    <a href="{{url('/blog/'.$article->slug)}}">
                      <div class="imgblog"> <img src="{{$random_article->image}}" alt="{{$random_article->getTitle()}}" title="{{$random_article->getTitle()}}"></div>
                      <div class="textcontant">
                        <h3 class="title">{{$random_article->getTitle()}}</h3><span class="calendar"> <i class="far fa-calendar-alt"></i> {{$random_article->created_at}}</span>
                      </div>
                    </a>
                @endforeach
            @endif
          </nav>
        </div>
      </div>
    </div>
  </div>
</section>



@endsection