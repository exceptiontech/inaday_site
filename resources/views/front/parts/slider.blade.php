<!-- Start Hero Section -->
<div class="slider d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="hero-content text-white col-12 col-md-6">
                <h2 class="pb-5 mb-5">{!!trans('file.slider_title')!!}</h2>
                <p  class="mb-5">{!!trans('file.slider_desc')!!}</p>
                <a class="btn btn-primary" href="{{ url('register/services_provider') }}">{{trans('file.free_start')}}</a>
            </div>
        </div>
    </div>
</div>
<!-- Hero Section End -->

<!-- Start Search Section -->
<div id="search-bar" class="col-12 mt-n5">
    <div class="container p-1 pr-0 pl-0">
        <form method="GET" action="https://inaday.cloud/search" accept-charset="UTF-8" class="formsearch">
            <div class="row m-1 ">
                <div class="col-12 col-md-4 pt-1 pb-1">
                    {{ Form::open(['action' => 'FrontController@SearchIndex','method' => 'get','class'=>'formsearch']) }}
                    {!! Form::text('query', null, ['required','class' => 'form-control search','id'=>'search','placeholder'=>trans('file.search_for')]) !!}
                    {{ Form::close() }}
                </div>
                <div class="col-12 col-md-3  pt-1 pb-1">
                    <select name="section_id" class="form-control required" id="service" required="required" aria-required="true">
                        <option value="">اختر المدينة</option>
                        <option value="1">الرياض</option>
                  </select>
                </div>
                <div class="col-12 col-md-3  pt-1 pb-1">
                    <select name="section_id" class="form-control required" id="service" required="required" aria-required="true">
                        <option value="">اختر التصنيف</option>
                        <option value="1"> خدمات متقدمة</option>
                  </select>
                </div>
                <div class="col-12 col-md-2 p-0">
                    <button class="btn btn-block btn-primary h-100" type="submit">أبحث الآن </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Search Section End -->
