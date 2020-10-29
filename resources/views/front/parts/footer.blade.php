<!-- Footer begin-->
<footer id="footer" class="mt-5 pt-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col-12 col-md-6 widget">
                        <h2>{{trans('file.important_links')}}</h2>
                        <ul class="list-unstyled">
                            <li>
                                <a href="{{url('pages/1')}}">{{trans('file.privacy_policy')}}</a>
                            </li>
<!--                             <li>
                                <a href="{{url('pages/2')}}">{{trans('file.usage_policy')}}</a>
                            </li>
 -->                            <!-- <li>
                                <a href="{{url('pages/3')}}">{{trans('file.refund_and_cancellation_policy')}}</a>
                            </li> -->
                            <li>
                                <a href="{{ url('/faqs') }}">{{trans('file.faqs')}}</a>
                            </li>
                            <li>
                                <a href="{{ url('/contact_us') }}">{{trans('file.contact_us')}}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-6 widget">
                        <h2>{{trans('file.site_map')}}</h2>
                        <ul class="list-unstyled">
                            @guest
                            <li>
                                <a href="{{url('/register?type=services_provider')}}">{{trans('file.servives_provider_register')}}</a>
                            </li>
                            <li>
                                <a href="{{url('/register?type=entrepreneur')}}">{{trans('file.entrepreneur_register')}}</a>
                            </li>
                            @endguest
                            <li>
                                <a href="{{ url('/projects') }}">{{trans('file.recent_projects')}}</a>
                            </li>
                            <li>
                                <a href="{{ url('/services') }}">{{trans('file.booking_servives')}}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="widget">
                    <h2>{{trans('file.available_payment_methods')}}</h2>
                    <ul class="list-inline">
                        <li class="list-inline-item"><img class="mr-2" style="height:26px;" src="{{url('images/paypal-logo.png') }}"></li>
<!--                         <li class="list-inline-item"><img class="mr-2" style="height:26px;" src="{{url('images/paytabs-logo.png') }}"></li>
                        <li class="list-inline-item"><img class="mr-2" style="height:20px" src="{{url('images/visa.svg') }}"></li>
                        <li class="list-inline-item"><img class="mr-2" style="height:20px" src="{{url('images/mastercard.svg') }}"></li>
 -->
                    </ul>
                </div>
                <div class="widget mt-5 mb-4">
                    <h2>{{trans('file.newsleter_register')}}</h2>
                    <p >{{trans('file.register_your_email_to_subscribe_to_the_mailing_list_to_receive_all_new')}}</p>
                    <form method="GET" action="#" id="subscribe-form">
                        <div class="col-12 col-md-9">
                            <div class="row">
                            <div class="col-8 col-md-8  p-0">
                                <input required="required" class="form-control h-100" id="search" placeholder="{{trans('file.email')}}" name="email" type="text">
                            </div>
                            <div class="col-4 col-md-4 p-0 mr-n1">
                                <button id="subscribe" class="btn btn-block btn-primary h-100" type="submit">{{trans('file.subscribe_now')}}</button>
                            </div>
                            <div class="col-12 result mt-2"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="copyrights pb-2 pt-3">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <p class="copyright font-weight-bolder mb-2">© 2020 {{trans('file.byـinـaـdayـteam')}}</p>
                    <!-- <p class="mb-1"><span class="font-weight-bolder">مؤسسة حقل الورود للتجارة |</span> رقم السجل المدني : 1008367383</p> -->
                </div>
                <div class="col-12 col-sm-6 text-right">
                    <ul class="list-inline sociel">
                        <li class="list-inline-item">
                            {{trans('file.folow_us')}}
                        </li>
                        <li class="list-inline-item">
                            <a href="https://www.instagram.com/inaday.biz/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://twitter.com/inadaybiz" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="https://www.instagram.com/inaday.biz/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

@guest

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2>{{trans('file.signin')}}</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="error" > </div>
                <form  method="post" name="login-form" class="login-form"  id="login">
                    @csrf
                    <div class="form-group">
                        <label> {{trans('file.email')}} *</label>
                        <input type="email"  name="email" id="email" id="login-form-username"  class="form-control d-block  @error('email') is-invalid @enderror"  value="{{ old('email') }}" required autocomplete="email" autofocus aria-label="Username" aria-describedby="basic-addon1">
<!--                             @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
 -->                    </div>
                    <div class="form-group">
                        <label for="login-form-password">{{trans('file.password')}}</label>
                            <input type="password" name="password" id="password" id="login-form-password" class="form-control d-block @error('password') is-invalid @enderror" required autocomplete="current-password"  >
<!--                             @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror -->
                    </div>
                    <div class="col-12">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="col-6">تذكرني</label>
                        <u class="col-6 mr-2" >
                            @if (Route::has('password.request'))
                                <a class="forgot" href="{{ route('password.request') }}">
                                    {{trans('file.forgot_your_password?')}}
                                    {{-- __('ForgotYourPassword?') --}}
                                </a>
                            @endif
                        </u>
                    </div>
                    <button  class="btn btn-modal text-center mt-4 btn-login" name="btn-login" id="login-form-submit"  value="login">{{trans('file.signin')}}</button>
                    <h5 class="or">أو</h5>
                    <div class="text-center google-login mt-4">
                        <a class="btn" href="{{url('/user/google')}}">
                            <i class="fa fa-google fa-lg"></i>  {{__('file.login_with_google')}}</a>
                    </div>
                    <p class="paragrapgh-login">هذه الخاصية للاعضاء المسجلين بالفعل. في حالة التسجيل يرجي استخدام صفحات التسجيل بالاعلي . في
                        حالة الدخول من خلال جوجل هنا ستكون صاحب عضوية بلا اي صلاحيات </p>
                        <p>ليس لديك حساب مسجل! يمكنك <u><a href="{{ route('register') }}">تسجيل حساب جديد</a></u></p>
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
<script type="text/javascript">




    /// login by jquery ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('document').ready(function()
    {
        $('#accepted1,#accepted2').click(function () {
            if ($('#accepted1:checked,#accepted2:checked').length == 2)
                $('#id_complete').removeAttr('disabled').css( "background-color", "#00e689" );

            else
                $('#id_complete').attr('disabled','disabled').css( "background-color", "silver" );

        });
        $("input[type='radio']").change(function () {
            var newType = $("input[name='user_type']:checked").val();

            // var oldUrl = $(this).attr("href"); // Get current url
            if(newType == 'services_provider'){

                var newUrl = '{!! url("services_provider/google") !!}'
            }else{
                var newUrl = '{!! url("entrepreneur/google") !!}'
            }

            $("#Type").attr("href", newUrl);

        });






            /* validation */
        $(".login-form").validate({
            rules:
            {
                password: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
            },
            messages:
            {
                password:{
                    required: "{{trans('file.please_enter_the_password?')}}"
                },
                email: "{{trans('file.please_enter_your_e_mail?')}}",
            },
            submitHandler: submitForm
        });
        /* validation */
        /* login submit */
        function submitForm()
        {
            var data = $(".login-form").serialize();
            $.ajax({
                type : 'POST',
                url  : "{{route("login")}}",
                data : data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function()
                {
                    $(".error").fadeOut();
                    $(".btn-login").html('<i class="icon-danger" ></i> {{trans("file.processing_is_in_progress")}} ');
                },
                success: function (data) {
                    //console.log(data);
                    $(".error").fadeIn(2000, function(){
                        $(".error").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-info-sign"></span> {{trans("file.sign_in_successful")}} </div>');
                    });
                    $(".btn-login").html('<img src="{{url("btn-ajax-loader.gif")}}" /> {{trans("file.signing_in")}} ');
                    setTimeout('location.reload()',2000);
                },
                error: function (jqXHR) {
                    var response = $.parseJSON(jqXHR.responseText);
                    //console.log(response);
                    $(".error").fadeIn(1000, function(){
                            $(".error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> {{trans("file.sorry_the_email_or_password_are_incorrect")}}  </div>');
                            $(".btn-login").html('<i class="icon-signin"></i> {{trans("file.signin")}} ');
                        });
                }
            });
            return false;
        }
            /* login submit */
    });
    //// end login



    $("#subscribe-form button").click(function(event) {
        event.preventDefault();

        var data = {'email' : $('#subscribe-form input').val()};

        $.ajax({
            type  : 'post',
            url   : '{!!URL::route('subscribe')!!}',
            data  : data ,
            success:function(data){


                if (data.result == 'done') {
                    $('#subscribe-form .result').html('<p class="text-success">تم الاشتراك بنجاح</p>');
                }else {
                    $('#subscribe-form .result').html('<p class="text-danger">البريد المدخل غير صحيح</p>');
                }
            },
        error:function(data){
            console.log(data.err)
        }
      });
    });

    </script>

@endguest



@guest
<!-- Hotjar Tracking Code for inaday.cloud -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:1904541,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>

@endguest


@section('jquery')
<script type="text/javascript">

    $("#subscribe-form button").click(function(event) {
        event.preventDefault();

        var data = {'email' : $('#subscribe-form input').val()};

        $.ajax({
            type  : 'post',
            url   : '{!!URL::route('subscribe')!!}',
            data  : data ,
            success:function(data){


                if (data.result == 'done') {
                    $('#subscribe-form .result').html('<p class="text-success">تم الاشتراك بنجاح</p>');
                }else {
                    $('#subscribe-form .result').html('<p class="text-danger">البريد المدخل غير صحيح</p>');
                }
            },
        error:function(data){
            console.log(data.err)
        }
      });
    });


        /// login by jquery ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('document').ready(function()
        {
            $('#accepted1,#accepted2').click(function () {
                if ($('#accepted1:checked,#accepted2:checked').length == 2)
                    $('#id_complete').removeAttr('disabled').css( "background-color", "#00e689" );

                else
                    $('#id_complete').attr('disabled','disabled').css( "background-color", "silver" );

            });
            $("input[type='radio']").change(function () {
                var newType = $("input[name='user_type']:checked").val();

                // var oldUrl = $(this).attr("href"); // Get current url
                if(newType == 'services_provider'){

                    var newUrl = '{!! url("services_provider/google") !!}'
                }else{
                    var newUrl = '{!! url("entrepreneur/google") !!}'
                }

                $("#Type").attr("href", newUrl);

            });



                /* validation */
            $(".login-form").validate({
                rules:
                {
                    password: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                },
                messages:
                {
                    password:{
                        required: "{{trans('file.please_enter_the_password?')}}"
                    },
                    email: "{{trans('file.please_enter_your_e_mail?')}}",
                },
                submitHandler: submitForm
            });
            /* validation */
            /* login submit */
            function submitForm()
            {
                var data = $(".login-form").serialize();
                $.ajax({
                    type : 'POST',
                    url  : "{{route("login")}}",
                    data : data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function()
                    {
                        $(".error").fadeOut();
                        $(".btn-login").html('<i class="icon-danger" ></i> {{trans("file.processing_is_in_progress")}} ');
                    },
                    success: function (data) {
                        //console.log(data);
                        $(".error").fadeIn(2000, function(){
                            $(".error").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-info-sign"></span> {{trans("file.sign_in_successful")}} </div>');
                        });
                        $(".btn-login").html('<img src="{{url("btn-ajax-loader.gif")}}" /> {{trans("file.signing_in")}} ');
                        setTimeout('location.reload()',2000);
                    },
                    error: function (jqXHR) {
                        var response = $.parseJSON(jqXHR.responseText);
                        //console.log(response);
                        $(".error").fadeIn(1000, function(){
                                $(".error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> {{trans("file.sorry_the_email_or_password_are_incorrect")}}  </div>');
                                $(".btn-login").html('<i class="icon-signin"></i> {{trans("file.signin")}} ');
                            });
                    }
                });
                return false;
            }
                /* login submit */
        });
        //// end login
</script>
@endsection
@yield('footer')
