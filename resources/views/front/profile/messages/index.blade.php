@extends('layouts.inner')
@section('content')
<div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">المحادثات</h2>
                </div>

                <div class="col-12">

                    <div class="bg-light mt-5 messages  wrapper rounded">
                    <div class="d-flex">
                        <div class="col-md-4 p-0">
                            <div class="p-3 border-left">
                                <input class="form-control" id="searchKeywords" type="text" name="search" placeholder="بحث">
                            </div>
                            <div class="user-wrapper">
                                <ul class="users">
                                    @if(count($users) > 0)
                                    @foreach($users as $user)
                                        <li class="user user-{{ $user->id }}" id="{{ $user->id }}">
                                            {{--will show unread count notification--}}
                                            @if($user->unread)
                                                <span class="pending">{{ $user->unread }}</span>
                                            @endif

                                            <div class="media">
                                                <div class="media-left">
                                                    <img src="{{ url($user->userdetail->first()->avater ?? '/assets/images/logo.png' ) }}" alt="" class="media-object rounded-circle">
                                                </div>

                                                <div class="media-body">
                                                    <p class="name">{{$user->first_name. ' ' .$user->last_name}}</p>
                                                    <p class="email">{{ $user->last_messages()->message ?? 'لا يوجد اي رسائل' }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    @else
                                        <li class="user">
                                            <div class="media">
                                                <div class="media-left">
                                                    <img src="{{ url('/assets/images/logo.png' ) }}" alt="" class="media-object">
                                                </div>

                                                <div class="media-body">
                                                    <p class="name">لا يوجد اعضاء للمحادثة</p>
                                                </div>
                                            </div>

                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-8" id="messages">

                        </div>
                    </div>
                    </div>

                </div>
                    
            </div>
        </div>
    </div>
@endsection


@section('jquery')

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>


<script>
    var receiver_id = '';
    var my_id = "{{ Auth::id() }}";


        @if(Request()->user_id) 
            var receiver_id = {{ Request()->user_id }} ;

            setTimeout(function(){
                $('.user-'+receiver_id).trigger('click');
            }, 100);

        @endif

    $(document).ready(function () {

        $("#searchKeywords").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("ul.users li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // ajax setup form csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('7ceb9866972d25486671', {
          cluster: 'ap2'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            //alert(JSON.stringify(data));

            if (my_id == data.from) {
                $('#' + data.to).click();
            } else if (my_id == data.to) {
                if (receiver_id == data.from) {
                    // if receiver is selected, reload the selected user ...
                    $('#' + data.from).click();
                } else {
                    // if receiver is not seleted, add notification for that user
                    var pending = parseInt($('#' + data.from).find('.pending').html());

                    if (pending) {
                        $('#' + data.from).find('.pending').html(pending + 1);
                    } else {
                        $('#' + data.from).append('<span class="pending">1</span>');
                    }
                }
            }
        });



        $('.user').click(function () {
            $('.user').removeClass('active');
            $(this).addClass('active');
            $(this).find('.pending').remove();

            receiver_id = $(this).attr('id');
            $.ajax({
                type: "get",
                url: "/account/messages/" + receiver_id, 
                data: "",
                cache: false,
                success: function (data) {
                    $('#messages').html(data);
                    scrollToBottomFunc();
                }
            });
        });



        $(document).delegate(".upload_form","submit",function(e){ 
            e.preventDefault();

            $('#inputArea').append('<div class="loaderWrapper"><div class="loader">Loading...</div></div>');
            $(this).val(''); 
            var receiver_id = $(this).data('id'); 

            $.ajax({
                url: '{{ route('sendMessage') }}',
                type: 'POST',              
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,

                success: function(result)
                {
                    console.log(result.error);

                    if (result.error.length > 0) {
                        $(".file-"+receiver_id).val('');
                        alert(result.error);
                    }
                    $('#inputArea .loaderWrapper').remove();
                    //$('.user-'+receiver_id).click();

                },
                error: function (jqXHR, status, err) {
                    $('#inputArea .loaderWrapper').remove();
                },
                complete: function () {
                    scrollToBottomFunc();
                }
            });

        });


    });



    function addAttach(id) {

        $(".file-"+id).trigger('click');

        $(".file-"+id).on('change', function() {
            $("#upload_submit_"+id).trigger('click');
            //var message = $(this).val();

        });
    }


    // make a function to scroll down auto
    function scrollToBottomFunc() {
        $('.message-wrapper').animate({
            scrollTop: $('.message-wrapper').get(0).scrollHeight
        }, 50);

        $('#messageBody'+receiver_id).focus();

    }



    $(document).on("click", "#recordFor5:not(.disabled)", function(e){
        e.preventDefault();
        Fr.voice.record($("#live").is(":checked"), function(){
            $(".recordButton").addClass("disabled");

            $("#live").addClass("disabled");
            $(".one").removeClass("disabled");

            //makeWaveform();


        });

        Fr.voice.stopRecordingAfter(10000, function(){
            Fr.voice.export(function(blob){
              var data = new FormData();
              data.append('audio', blob);
              data.append('receiver_id', receiver_id);
              
              $.ajax({
                url: '{{ route('sendMessage') }}',
                type: 'POST',
                data: data,
                contentType: false,
                processData: false,
                success: function(data) {
                  // Sent to Server
                }
              });
            }, "blob");

            Fr.voice.stop();

            //alert("Recording stopped after 10 seconds");
        });
    });



</script>

@endsection