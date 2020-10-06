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
                    @if($message->file)
                            @if(pathinfo($message->file, PATHINFO_EXTENSION)  == 'png' || pathinfo($message->file, PATHINFO_EXTENSION) == 'jpg' || pathinfo($message->file, PATHINFO_EXTENSION) == 'jpeg')
                                <div class="{{ ($message->from == Auth::id()) ? 'sent' : 'received' }}">
                                    <div class="message_content p-2">
                                        <a class="d-flex {{ ($message->from == Auth::id()) ? 'text-white' : '' }} " download="download" href="{{url($message->file)}}">
                                            <img class="img-fluid" src="{{url($message->file)}}">
                                        </a>
                                    </div>
                                    
                                    <p class="date">{{ date('d M y, h:i a', strtotime($message->created_at)) }}</p>
                                </div>
                            @elseif(pathinfo($message->file, PATHINFO_EXTENSION)  == 'mp3')

                                <div class="{{ ($message->from == Auth::id()) ? 'sent' : 'received' }}">
                                    <div class="message_content bg-transparent">
                                    <audio controls style="width: 100%;">
                                        <source src="{{ url($message->file) }}" type="audio/mpeg">
                                    </audio>
                                    </div>
                                </div>
                            @else
                                <div class="{{ ($message->from == Auth::id()) ? 'sent' : 'received' }}">
                                    <div class="message_content p-2">
                                        <a class="d-flex {{ ($message->from == Auth::id()) ? 'text-white' : '' }} " download="download" href="{{url($message->file)}}">
                                            <i class="fa fa-file-o fa-2x mr-2" aria-hidden="true"></i>
                                            حمل هذا الملف
                                        </a>
                                    </div>
                                    
                                    <p class="date">{{ date('d M y, h:i a', strtotime($message->created_at)) }}</p>
                                </div>
                            @endif

                        @else
                            <div class="{{ ($message->from == Auth::id()) ? 'sent' : 'received' }}">
                                <div class="message_content p-2">
                                    <p>{{ $message->message }}</p>
                                </div>

                                <p class="date">{{ date('d M y, h:i a', strtotime($message->created_at)) }}</p>
                            </div>
                        @endif

            </li>
        @endforeach
    </ul>
</div>


<div id="inputArea" class="form-inline p-3">
<form class="upload_form upload_form_{{ $other_user->id}} form-inline col-12" enctype="multipart/form-data" data-id="{{ $other_user->id}}">

    <div class="form-group col-1 p-0">
        <div class="voiceNote">
            <a class="button recordButton" id="recordFor5" href="#" ><i class="fa fa-microphone" aria-hidden="true"></i></a>
        </div>
    </div>

    <div class="input-text input-text-{{ $other_user->id}} col-9">

        <div class="attach_file">
            <a onclick="addAttach({{ $other_user->id}});"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
            {{ csrf_field() }}
            <input class="upload_file file-{{ $other_user->id}}" type="file" name="file">
            <input type="hidden" class="receiver_id_{{ $other_user->id}}" name="receiver_id" value="{{$other_user->id}}">
        </div>
        
        <input autofocus type="text" id="messageBody{{ $other_user->id}}" class="message_{{ $other_user->id}}" name="message" class="submit" autocomplete="off">
    </div>
    <div class="form-group col-2 p-0">
        <button type="submit" id="upload_submit_{{ $other_user->id}}" class="upload_submit btn btn-block btn-secondary rounded text-white" data-id="{{ $other_user->id}}">إرسال</button>
    </div>
</form>

</div>