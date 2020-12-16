
<p>العنوان : {{$contactus->subject}}</p>

<p>الايميل : {{$contactus->email}}</p>

<p>الجوال : {{$contactus->mobile}}</p>

@if($contactus->file)
<p>الملف : <a href="{{url($contactus->file)}}">تحميل</a> </p>
@endif

<p>الرسالة : {{$contactus->message}}</p>
