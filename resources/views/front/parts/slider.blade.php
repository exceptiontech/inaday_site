<!-- Start Hero Section -->
<div class="slider d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="hero-content text-white col-12 col-md-6">
                <h2 class="pb-5 mb-5">{!!trans('file.slider_title')!!}</h2>
                <p  class="mb-5">{!!trans('file.slider_desc')!!}</p>
                <a class="btn btn-primary" href="{{ url('register') }}">{{trans('file.free_start')}}</a>
            </div>
        </div>
    </div>
</div>
<!-- Hero Section End -->

<!-- Start Search Section -->
<div id="search-bar" class="col-12 mt-n5">
    <div class="container p-1 pr-0 pl-0">

        {{ Form::open(['action' => 'FrontController@SearchIndex','method' => 'get','class'=>'formsearch']) }}
            <div class="row m-1 ">
                <div class="col-12 col-md-4 pt-1 pb-1">
                    <img class="icon-search-bar" src="images/search.svg" />
                    {!! Form::text('title', null, ['required','class' => 'form-control search search-bar-field','id'=>'title','placeholder'=>trans('file.search_for')]) !!}
                </div>
                <div class="col-12 col-md-3  pt-1 pb-1">
                    <img class="icon-search-bar" src="images/placeholder.svg" />
                    <select name="city" class="form-control required search-bar-field" id="service" required="required" aria-required="true">
                        <option value="all">كل المدن</option>
                        @foreach($cities as $city)
                            <option value="{{$city->slug}}"> {{$city->title['ar']}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="col-12 col-md-3  pt-1 pb-1">
                    <img class="icon-search-bar" src="images/layers.svg" />

                    <select name="skill" class="form-control required search-bar-field" id="service"
                            required="required" aria-required="true">
                        <option value="all">في كل الاقسام</option>
                        @foreach($skills as $skill)
                            <option value="{{$skill->id}}"> {{$skill->title['ar']}}</option>
                        @endforeach
                    </select>

                </div>
                <div class="col-12 col-md-2 p-0">
                    <button class="btn btn-block btn-primary h-100" type="submit">أبحث الآن </button>
                </div>
            </div>
        {{ Form::close() }}
    </div>
</div>
<!-- Search Section End -->
