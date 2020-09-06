

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
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="login-form-password">{{trans('file.password')}}</label>
                            <input type="password" name="password" id="password" id="login-form-password" class="form-control d-block @error('password') is-invalid @enderror" required autocomplete="current-password"  >
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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


</script>