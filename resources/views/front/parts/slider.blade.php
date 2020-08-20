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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2>تسجيل الدخول </h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label> البريد الإلكتروني *</label>
                        <input type="email" class="form-control d-block" aria-label="Username"
                               aria-describedby="basic-addon1">
                    </div>
                    <div class="form-group">
                        <label> كلمة المرور *</label>
                        <input type="password" class="form-control d-block" aria-label="Username"
                               aria-describedby="basic-addon1">
                    </div>
                    <div class="col-12">
                        <input type="checkbox">
                        <label class="col-6">تذكرني</label>
                        <u class="col-6 mr-2" ><a href="#">نسيت كلمة المرور؟</a></u>
                    </div>
                    <a class="btn btn-modal text-center mt-4" href="#">تسجيل </a>
                    <h5 class="or">أو</h5>
                    <div class="text-center google-login mt-4">
                        <a class="btn" href="#"> <i class="fa fa-google fa-lg"></i> التسجيل عن طريق جوجل</a>
                    </div>
                    <p class="paragrapgh-login">هذه الخاصية للاعضاء المسجلين بالفعل. في حالة التسجيل يرجي استخدام صفحات التسجيل بالاعلي . في
                        حالة الدخول من خلال جوجل هنا ستكون صاحب عضوية بلا اي صلاحيات </p>
                    <p>ليس لديك حساب مسجل! يمكنك <u><a href="#">تسجيل حساب جديد</a></u></p>
                </form>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Send message</button>
            </div> -->
        </div>
    </div>
</div>
<!-- Model Ended -->
<!-- Start Search Section -->
<div id="search-bar" class="col-12 mt-n5">
    <div class="container p-1 pr-0 pl-0">
{{--        <form method="GET" action="https://inaday.cloud/search" accept-charset="UTF-8" class="formsearch">--}}
        {{ Form::open(['action' => 'FrontController@SearchIndex','method' => 'get','class'=>'formsearch']) }}
            <div class="row m-1 ">
                <div class="col-12 col-md-4 pt-1 pb-1">
                    <img class="icon-search-bar" src="images/search.svg" />
                    {!! Form::text('query', null, ['required','class' => 'form-control search search-bar-field','id'=>'search','placeholder'=>trans('file.search_for')]) !!}
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
