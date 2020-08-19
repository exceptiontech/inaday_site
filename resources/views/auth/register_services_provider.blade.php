@extends('layouts.register_layout')
@section('title')
{{__('file.servives_provider_register')}}
@endsection
@section('content')

<style>
  .steps
  {
    display: none !important;
    visibility: hidden;
  }
</style>
<section class="signup new-item">
  <div class="step-app">
    <div class="logo">
      <a href="{{ url('/') }}"> <img src="{{url('assets/images/logo.png') }}" alt="Inaday" title="Inaday"></a>
    </div>
    <form class="formsignup" id="contact" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
      <div>
        <h3 style="display:none !important;"></h3>
        <section>
          <div class="row">
            <div class="col-sm-5 rightbox">
              <div class="contant-item">
                <h4 class="titletext">  {{__('file.servives_provider_register')}}</h4>
              </div>
            </div>
            <div class="col-sm-7 leftbox">
              <div class="row">



                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @csrf

                @guest

                <a class="btn btn-block btn-danger p-3" href="{{url('/services_provider/google')}}"><i class="fab fa-google"></i>  {{__('file.register_with_google')}}</a>

                <input class="form-control" type="hidden" name="name" value="service provider">
                <div class="col-sm-6 inpusrach {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label>{{ __('register_lang.f_name_t') }}<em>*</em></label>
                    <input name="first_name" class="form-control required {{ $errors->has('name') ? ' is-invalid' : '' }}"  id="firstname"  value="{{ old('first_name') }}" type="text" placeholder="{{ __('register_lang.f_name_t') }}" autofocus required="">
                    @if ($errors->has('name'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                  </div>
                  <div class="col-sm-6 inpusrach   {{ $errors->has('last_name') ? ' has-error' : '' }}">
                    <label>{{ __('register_lang.l_name_t') }}<em>*</em></label>
                    <input class="form-control required   {{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" id="lastname" type="text" placeholder="{{ __('register_lang.l_name_t') }}" required="">
                    @if ($errors->has('last_name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                    @endif
                  </div>
                  <div class="col-sm-6 inpusrach">
                    <label>{{ __('register_lang.email') }}<em>*</em></label>
                    <input  id="email" type="email" name="email" value="{{ old('email') }}"  class="form-control required {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email"  placeholder="{{ __('register_lang.email') }}"  required="">
                    @if ($errors->has('email'))
                      <span class="invalid-feedback">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class="col-sm-6 inpusrach">
                    <label>{{ __('register_lang.mobile') }}<em>*</em></label>
                    <input class="form-control required" type="tel" name="mobile"  id="phonenumber" required="" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                  </div>
                  <div class="col-sm-6 inpusrach  {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label>{{ __('register_lang.password') }}<em>*</em></label>
                    <input
                      id="password"
                      name="password"
                      type="password"
                      class="form-control required {{ $errors->has('password') ? ' is-invalid' : '' }}"
                      aria-required="true"
                      placeholder="{{ __('register_lang.password') }}"
                    />
                    <span>{{trans('file.password_is_not_less_than_8_characters')}}</span>
                    @if ($errors->has('password'))
                      <span class="invalid-feedback">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
                  </div>
                  <div class="col-sm-6 inpusrach">
                    <label>{{ __('register_lang.co_password') }}<em>*</em></label>
                    <input
                      id="confirm"
                      name="password_confirmation"
                      type="password"
                      class="form-control required"
                      aria-required="true"
                    />
                </div>
                @else
                  {{__('file.you_already_registered_please_fill_following_steps')}}
                @endguest
              </div>
            </div>
          </div>
        </section>

        <!-- ----------------------- 2 ------------------ -->
        <h3></h3>
        <section>
          <div class="row">
            <div class="col-sm-5 rightbox">
              <div class="contant-item">
                <h4 class="titletext">ليش؟</h4>
                <p>
                  في عصر مابعد "الكارونا" راح يتغير مفهوم الشركات، و الوظيفة
                  وتقديم الخدمات، بيكون فيه معايير أكثر دقة لتحقيق الأهداف،
                  و إنجاز المهام، الوجود الفعلي بمقر العمل راح يكون أقل
                  قيمة، وتكلفة مهدرة، عشان كذا راح يكون العمل عن بعد هو
                  الأساس، وجودة عملك وسرعتك في الإنجاز هي أساس نجاحك وتقدمك.
                  من منظور آخر، أنت بتكون حجر الأساس في تأسيس كثير من
                  المشاريع اللي راح تفيدك بشكل مباشر و غير مباشر، وبتساعد في
                  تحقيق رؤية ٢٠٣٠ وجعل المملكة في مقدمة العالم.
                </p>
              </div>
            </div>
            <!-- End rightbox -->
            <div class="col-sm-7 leftbox">
              <div class="row">
                  <div class="col-sm-12 inpusrach">
                    <div class="select">
                      <label>كيف تبغى تكون مقدم خدمة؟ <em>*</em></label><i class="fas fa-sort-down"></i>

                      @if (count($jobtypes))
                        <select name="jobtype_id" class="form-control required" id="service" >
                          @foreach ($jobtypes as $jobtype)
                              <option value="{{$jobtype->id}}">{{@$jobtype->title[App::getLocale()]}}</option>
                          @endforeach
                        </select>
                      @endif

                    </div>
                  </div>
                </div>
            </div>
          </div>
        </section>
        <!-- -----------------------3 ------------------ -->
        <h3></h3>
        <section>
          <div class="row">
            <div class="col-sm-5 rightbox">
              <div class="contant-item">
                <h4 class="titletext">الخبرة والمهارة</h4>
                    <p>أيش هي الخدمات اللي تقدر تقدمها، سواء كانت كخبرة في عمل سابق، أو مهارة معينة تجيدها وتحس أنك مبدع فيها؟</p>




              </div>
            </div>
            <!-- End rightbox -->
            <div class="col-sm-7 leftbox">
                <div class="row">
                  <div class="col-sm-6 inpusrach">

                    <div class="select">
                       <label>الخدمة اللي ممكن تقدمها<em>*</em></label><i class="fas fa-sort-down"></i>

                      @if (count($skills))
                        <select name="skills[]" class="form-control required" id="service" >
                          @foreach ($skills as $skill)
                              <option value="{{$skill->id}}">{{@$skill->title[App::getLocale()]}}</option>
                          @endforeach
                        </select>
                      @endif

                    </div>
                  </div>
                  <div class="col-sm-6 inpusrach">
                    <label>مهارة أخرى تجيدها</label>
                    <input name="skills[]" class="form-control" type="text" placeholder="مهارة أخرى تجيدها">
                  </div>
                </div>
            </div>
          </div>
        </section>
        <!-- ----------------------- 4 ------------------ -->
        <h3></h3>
        <section>
          <div class="row">
            <div class="col-sm-5 rightbox">
              <div class="contant-item">
                <h4 class="titletext">التدريب</h4>
                <p>هل تشوف نفسك جاهز لتقديم الخدمات أو تحتاج تدريب وخبرة؟ لا تشيل هم، حتى لو كان ماعندك خبرة نهائياً لكن عندك الرغبة في التعلم والتطور، راح نسعى جاهدين أننا نعلمك و ندربك ونحقق حلمك اللي تبغى توصله، وبنعطيك شهادات حضور للدورات و ورش العمل اللي حضرتها. لكن بكل ساعة تدريب تحصل عليها ودنا انك تقدم مقابلها ساعة تطوع لرواد الأعمال وتساعدهم في تحقيق أحلامهم.</p>
              </div>
            </div>
            <!-- End rightbox -->
            <div class="col-sm-7 leftbox">
              <div class="row">
                  <div class="col-sm-12 inpusrach">

                    <div class="select">
                      <label>حاجتك للتدريب<em>*</em></label><i class="fas fa-sort-down"></i>
                      @if (count($levels))
                        <select name="level_id" class="form-control required" id="level_id" >
                          @foreach ($levels as $level)
                              <option value="{{$level->id}}">{{@$level->title[App::getLocale()]}}</option>
                          @endforeach
                        </select>
                      @endif

                    </div>
                  </div>
                </div>
            </div>
          </div>
        </section>
        <!-- ----------------------- 6 ------------------ -->
        <h3></h3>
        <section>
          <div class="row">
            <div class="col-sm-5 rightbox">
              <div class="contant-item">
                <h4 class="titletext">فردي أم فريق؟</h4>
                <p>كل خطوة ومهمة وخدمة مرتبطة بمرحلة سابقة أو لاحقة، و بعض الخطوات ممكن تسويها بنفس الوقت، أيضاً قدرتك على التركيز و الإنجاز، كلها عوامل تحدد، هل تفضل تشتغل لحالك أو مع فريق ؟</p>
              </div>
            </div>
            <!-- End rightbox -->
            <div class="col-sm-7 leftbox">
              <div class="row">
                  <div class="col-sm-12 inpusrach">

                    <div class="select">
                      <label>فردي أم فريق<em>*</em></label><i class="fas fa-sort-down"></i>

                      @if (count($prefers))
                        <select name="prefer_id" class="form-control required" id="prefer_id" >

                          @foreach ($prefers as $prefer)
                            <option value="{{$prefer->id}}">{{@$prefer->title[App::getLocale()]}}</option>
                          @endforeach

                            <option value="0">{{trans('admin.all')}}</option>

                        </select>
                      @endif

                    </div>
                  </div>
                </div>
            </div>
          </div>
        </section>
        <!-- ----------------------- 7 ------------------ -->
        <h3></h3>
        <section>
          <div class="row">
            <div class="col-sm-5 rightbox">
              <div class="contant-item">
                <h4 class="titletext">طريقة العمل</h4>
                <p>فيه خيارات كثير لطريقة تعيين الفريق للمشاريع،أهمها: خاص: يظهر المشروع فقط للأعضاء اللي يتم إرسال دعوات خاصة لهم من صاحب المشروع، بالطريقة هذي أصحاب المشاريع لا يسمحون بنشر أعمالهم و يفضلون بقائها سرية. عام: لجميع الأعضاء، نوعية المشاريع هذي بيكون مسموح عرضها كأعمال سابقة، و راح  تكون مذكورة في شهادات الخبرة الخاصة بأعضاء المنصة.</p>
              </div>
            </div>
            <!-- End rightbox -->
            <div class="col-sm-7 leftbox">
              <div class="row">
                  <div class="col-sm-6 inpusrach">

                    <div class="select">
                      <label>التكلفة<em>*</em></label><i class="fas fa-sort-down"></i>

                      @if (count($costkinds))
                        <select name="costkind_id" class="form-control required" id="prefer_id" >

                          @foreach ($costkinds as $costkind)
                            <option value="{{$costkind->id}}">{{@$costkind->title[App::getLocale()]}}</option>
                          @endforeach

                            <option value="0">{{trans('admin.all')}}</option>

                        </select>
                      @endif

                    </div>
                  </div>
                </div>
            </div>
          </div>
        </section>


        <!-- ----------------------- 11 ------------------ -->
        <h3></h3>
        <section>
          <div class="row">
            <div class="col-sm-5 rightbox">
              <div class="contant-item">
                <h4 class="titletext">معلوماتك الأساسية</h4>
                <p>زودنا بمعلوماتك الأساسية عشان نقدر نتواصل معك بسهولة</p>
              </div>
            </div>
            <!-- End rightbox -->
            <div class="col-sm-7 leftbox">
              <div class="row">
                  <div class="col-sm-6 inpusrach">
                    <label> تاريخ الميلاد<em>*</em></label>
                    <div class="row">
                      <div class="col-4"><select class="form-control" name="day" id="days"></select></div>
                      <div class="col-4"><select class="form-control" name="month" id="months"></select></div>
                      <div class="col-4"><select class="form-control" name="year" id="years"></select></div>
                    </div>

                  </div>
                  <div class="col-sm-6 inpusrach">

                    <div class="select">
                      <label> مكان الاقامة<em>*</em></label><i class="fas fa-sort-down"></i>
                        @if (count($countries))
                          <select name="country_id" class="form-control" required>
                            @foreach ($countries as $country)
                                <option value="{{$country->id}}">{{$country->title[App::getLocale()]}}</option>
                            @endforeach
                          </select>
                        @endif
                    </div>
                  </div>
<!--                   <div class="col-sm-6 inpusrach">

                    <div class="select">
                      <label> العضوية</label><i class="fas fa-sort-down"></i>
                      <select class="form-control">
                        <option>مقدم خدمة</option>
                      </select>
                    </div>
                  </div>
 -->
                  <div class="col-sm-6 inpusrach">
                    <label> المهنة<em>*</em></label>
                    <div class="select">
                      <input name="position" class="form-control" type="text" placeholder="" required>
                    </div>
                  </div>
                  <div class="col-sm-12 inpusrach">
                    <label> ملاحظات</label>
                    <textarea class="form-control" name="notes" placeholder=" حلمك من خلال عملك في منصة .انادي."> </textarea>
                  </div>
                  <div class="col-sm-6 inpusrach">
                    <label> تحميل صورة العرض<em>*</em></label>
                    <div class="input-group">
                      <label class="input-group-btn"><span class="btn btn-primary">تصفح
                          <input type="file" name="avater" style="display: none;" required></span></label>
                      <input class="form-control" type="text" readonly>
                    </div>
                  </div>
                  <div class="col-sm-6 inpusrach">
                    <label> تحميل السيرة الذاتية<em>*</em></label>
                    <div class="input-group">
                      <label class="input-group-btn"><span class="btn btn-primary">تصفح
                          <input type="file" name="cv_file"  style="display: none;" required></span></label>
                      <input class="form-control" type="text" readonly>
                    </div>
                  </div>
                </div>
                <div class="chicksign">
                  <label class="che-box">
                    <input type="checkbox" id="accepted1" name="check" ><span class="label-text"> أتعهد أن أعمل بإخلاص وأحافظ على خصوصية واحترام الجميع</span>
                  </label>
                </div>
                <div class="chicksign">
                  <label class="che-box">
                    <input type="checkbox" id="accepted2" name="check"><span class="label-text"><em>*</em> قرأت وقبلت سياسة عدم الإفشاء وكافة بنود العقد الخاص بها
                      <a href="#" target="_blank"><em>*</em>الرجاء الإطلاع في حالة عدم التوقيع</a>
                    </span>
                  </label>
                </div>
            </div>
          </div>
        </section>

<!--script>
    $('#accepted1,#accepted2').click(function () {
      if ($('#accepted1:checked,#accepted2:checked').length == 2)
        $('#id_complete').removeAttr('disabled').css( "background-color", "#00e689" );

      else
        $('#id_complete').attr('disabled','disabled').css( "background-color", "silver" );

    });
</script-->
            <!--div class="step-footer">
              <button class="bottom previous" data-direction="prev"> <i class="fas fa-chevron-right"></i> <span>السابق</span> </button-->
              <!--input type="submit" class="bottom" value="حفظ"  id="id_complete" disabled="disabled" style="background-color:silver"/-->
              <!--button class="bottom next" data-direction="next"> <span>التالى</span> <i class="fas fa-chevron-left"></i></button>
              <button class="bottom" data-direction="finish">انهاء  </button>
            </div-->
          </div>
        </form>



      </div>
    </section>

@endsection

@section('jquery')
  <script type="text/javascript">



    var monthNames = [ "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December" ];

    for (i = new Date().getFullYear(); i > 1900; i--){
        $('#years').append($('<option />').val(i).html(i));
    }

    for (i = 1; i < 13; i++){
        $('#months').append($('<option />').val(i).html(i));
    }
     updateNumberOfDays();

    $('#years, #months').on("change", function(){
        updateNumberOfDays();
    });



    function updateNumberOfDays(){
        $('#days').html('');
        month=$('#months').val();
        year=$('#years').val();
        days=daysInMonth(month, year);

        for(i=1; i < days+1 ; i++){
                $('#days').append($('<option />').val(i).html(i));
        }
    }

    function daysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }

    $('#readiness_date').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    });


  $(document).ready(function() {

    jq = jQuery.noConflict();

    jq("#phonenumber").intlTelInput({
      localizedCountries: { 'sa': 'saudi arabia' },
      preferredCountries: ['sa', 'eg','ae','kw','om','sd'],
      excludeCountries: ["il"],
    }
    );

  });

  </script>
@endsection
