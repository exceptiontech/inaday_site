(function () {

    var HeroHeight = $(window).height()-$('header').height();

    $('.slider').css("min-height" , HeroHeight-100 +'px');
    //$('.hero-section .hero-content').css("min-height" , WindowHeight-300);


})();
$(document).ready(function(){
    $(".service_provider").click(function(){
        $("#service_provider").prop("checked", true);
    });
    $(".project_owner").click(function(){
        $("#service_provider").prop("checked", false);
        $("#service_provider2").prop("checked", true);
    });

    if ($("ul.pagination").length > 0) {
        $("ul.pagination").addClass('justify-content-center');
    }

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


});