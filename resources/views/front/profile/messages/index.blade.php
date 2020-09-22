
@extends('layouts.inner')
@section('content')
<div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">ادارة المشاريع</h2>
                </div>


                <div class="col-12">

                    <div class="bg-light mt-5 p-3 messages  wrapper rounded">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="user-wrapper">
                                <ul class="users">
                                    @foreach($users as $user)
                                        <li class="user user-{{ $user->id }}" id="{{ $user->id }}">
                                            {{--will show unread count notification--}}
                                            @if($user->unread)
                                                <span class="pending">{{ $user->unread }}</span>
                                            @endif

                                            <div class="media">
                                                <div class="media-left">
                                                    <img src="{{ url($user->userdetail->first()->avater ?? '/assets/images/logo.png' ) }}" alt="" class="media-object">
                                                </div>

                                                <div class="media-body">
                                                    <p class="name">{{ $user->name }}</p>
                                                    <p class="email">{{ $user->email }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
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
    $(document).ready(function () {
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
          alert(JSON.stringify(data));
        });


        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            alert(JSON.stringify(data));

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
                url: "/account/messages/" + receiver_id, // need to create this route
                data: "",
                cache: false,
                success: function (data) {
                    $('#messages').html(data);
                    scrollToBottomFunc();
                }
            });
        });

        $(document).on('keyup', '.input-text input', function (e) {
            var message = $(this).val();

            // check if enter key is pressed and message is not null also receiver is selected
            if (e.keyCode == 13 && message != '' && receiver_id != '') {
                $(this).val(''); // while pressed enter text box will be empty

                var datastr = "receiver_id=" + receiver_id + "&message=" + message;
                $.ajax({
                    type: "post",
                    url: "/account/message", // need to create this post route
                    data: datastr,
                    cache: false,
                    success: function (data) {
                        $('.user-'+receiver_id).click();
                    },
                    error: function (jqXHR, status, err) {
                    },
                    complete: function () {
                        scrollToBottomFunc();
                    }
                })
            }
        });
    });

    // make a function to scroll down auto
    function scrollToBottomFunc() {
        $('.message-wrapper').animate({
            scrollTop: $('.message-wrapper').get(0).scrollHeight
        }, 50);
    }
</script>

@endsection