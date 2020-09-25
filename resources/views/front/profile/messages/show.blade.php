<div class="row pt-2 pb-3 border-bottom">
    <div class="col-md-6">
        <img src="{{ url($other_user->userdetail->first()->avater ?? 'assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid pull-right img-icon50" />

        <div class="pull-right ml-2 pt-2">
            <h2 class="small">{{ $other_user->first_name.' '.$other_user->last_name }}</h2> 
            <div class="small pb-2">
                {{ $other_user->userdetail->first()->position ?? 'غير محدد' }}
            </div>
        </div>                   

    </div>
</div>
<div class="message-wrapper">
    <ul class="messages">
        @foreach($messages as $message)
            <li class="message clearfix">
                {{--if message from id is equal to auth id then it is sent by logged in user --}}
                @if($message->from == Auth::id())
                    <img src="{{ url(Auth::user()->userdetail->first()->avater ?? 'assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid pull-right ml-1 img-icon50" />
                @else
                    <img src="{{ url($other_user->userdetail->first()->avater ?? 'assets/images/logo.png') }}" class="rounded-circle img-thumbnail img-fluid pull-left mr-1 img-icon50" />

                @endif
                <div class="{{ ($message->from == Auth::id()) ? 'sent' : 'received' }}">
                    <div class="message_content p-2">
                        <p>{{ $message->message }}</p>
                    </div>
                    <p class="date">{{ date('d M y, h:i a', strtotime($message->created_at)) }}</p>
                </div>
            </li>
        @endforeach
    </ul>
</div>
<div id="inputArea" class="form-inline p-3">
    <div class="form-group col-1 p-0">
        <div class="voiceNote">
            <a href="#" ><i class="fa fa-microphone" aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="input-text input-text-{{ $other_user->id}} col-9">

        <div class="attach_file">


            <form class="upload_form upload_form_{{ $other_user->id}}" action="{{ route('sendMessage') }}" enctype="multipart/form-data" method="POST">
                <a onclick="addAttach({{ $other_user->id}});"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                {{ csrf_field() }}
                <input class="upload_file file-{{ $other_user->id}}" type="file" name="file">
                <input type="hidden" name="receiver_id" value="{{$other_user->id}}">
                <input type="submit" id="upload_submit_{{ $other_user->id}}" class="upload_submit border-0 btn p-0 d-none">
            </form>
        </div>
        
        <input type="text" name="message" class="submit">
    </div>
    <div class="form-group col-2 p-0">
        <a id="AddMessage" class="btn btn-block btn-secondary rounded text-white" onclick="AddMessage({{ $other_user->id}});">  إرسال</a>
    </div>
</div>