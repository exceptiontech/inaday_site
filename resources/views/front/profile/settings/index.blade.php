@extends('layouts.inner')
@section('title')
@endsection
@section('content')


    <div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">{{__('profile.settings')}}</h2>
                </div>

                <div class="col-12">
                    <div class="bg-light mt-5 p-3  profile rounded">
                        <div class="row">
                            <div class="col-12  profile-head-menu mb-5">

                                @include('front.profile.parts.menu')
                            </div>

                            <div class="col-12 profile-content mb-5">

                              @if ($errors->any())
                                  <div class="alert alert-danger">
                                      <ul>
                                          @foreach ($errors->all() as $error)
                                              <li>{{ $error }}</li>
                                          @endforeach
                                      </ul>
                                  </div>
                              @endif


                              @if(!Auth::user()->usersettings)

                              {{ Form::open(['action' => 'Account\UsersettingsController@store']) }}



                                <div class="row mb-4">                                        
                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات المدونة والاخبار</label>

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input name="blog_notifications" type="checkbox" class="custom-control-input" id="blog_notifications" checked="checked">
                                          <label class="custom-control-label" for="blog_notifications">استلم رسائل البريد الإلكتروني بشأن التحديثات والمنشورات الجديدة.</label>
                                      </div>

                                    </div>

                                        
                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات العروض</label>

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input name="offer_notifications" type="checkbox" class="custom-control-input" id="offer_notifications"  checked="checked">
                                          <label class="custom-control-label" for="offer_notifications">استلم رسائل البريد الإلكتروني بشأن العروض.</label>
                                      </div>

                                    </div>
                                </div>

                                <div class="row mb-4">                                        
                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات الطلبات</label>

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input name="booking_notifications" type="checkbox" class="custom-control-input" id="booking_notifications"  checked="checked">
                                          <label class="custom-control-label" for="booking_notifications">استلم رسائل البريد الإلكتروني بشأن الحجوزات.</label>
                                      </div>

                                    </div>                                        

                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات التقييم والاراء</label>

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input  name="review_notifications"  type="checkbox" class="custom-control-input" id="review_notifications"  checked="checked">
                                          <label class="custom-control-label" for="review_notifications">استلم رسائل البريد الإلكتروني بشأن التقييمات</label>
                                      </div>

                                    </div>
                                </div>


                                <div class="row mb-4">
                                        
                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات الفرق</label>

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input name="team_notifications" type="checkbox" class="custom-control-input" id="team_notifications"  checked="checked">
                                          <label class="custom-control-label" for="team_notifications">استلم رسائل البريد الإلكتروني بشأن دعوات الفرق.</label>
                                      </div>

                                    </div>

                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات الملف الشخصي</label>
                                      

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input name="profile_notifications" type="checkbox" class="custom-control-input" id="profile_notifications"  checked="checked">
                                          <label class="custom-control-label" for="profile_notifications" >استلم رسائل البريد الإلكتروني بشأن تحديثات الملف الشخصي .</label>
                                      </div>

                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات الرسائل والمحادثات</label>
                                        

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input  name="message_notifications" type="checkbox" class="custom-control-input" id="message_notifications"  checked="checked">
                                          <label class="custom-control-label" for="message_notifications">استلم رسائل البريد الإلكتروني بشأن المحادثات.</label>
                                      </div>

                                    </div>

                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات الدعم الفني</label>
                                        

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input name="support_notifications" type="checkbox" class="custom-control-input" id="support_notifications"  checked="checked">
                                          <label class="custom-control-label" for="support_notifications">استلم رسائل البريد الإلكتروني بشأن تذاكر الدعم الفني.</label>
                                      </div>

                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات التفضيل للخدمات والمشاريع</label>
                                        

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input name="favorite_notifications"  type="checkbox" class="custom-control-input" id="favorite_notifications"  checked="checked" >
                                          <label class="custom-control-label" for="favorite_notifications" >استلم رسائل البريد الإلكتروني بشأن التحديثات والمنشورات الجديدة.</label>
                                      </div>

                                    </div>

                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات التعليقات</label>

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input name="replay_notifications" type="checkbox" class="custom-control-input" id="replay_notifications" checked="checked">
                                          <label class="custom-control-label" for="replay_notifications">استلم رسائل البريد الإلكتروني بشأن التحديثات والمنشورات الجديدة.</label>
                                      </div>

                                    </div>
                                </div>

                                <div class="row mt-5 mb-3">
                                    <div class="col-12">
                                        {!! Form::submit(trans('forms.save'), array('class'=>'btn btn-primary')) !!}
                                    </div>
                                </div>
                              {{ Form::close() }}


                              @else

                              {{ Form::model(Auth::user()->usersettings, array('route' => array('front_settings.update', Auth::user()->usersettings->id), 'method' => 'PUT')) }}

                                @if(count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger alert-dismissable" >
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h4>{{ $error}}</h4>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="row mb-4">                                        
                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات المدونة والاخبار</label>

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input name="blog_notifications" type="checkbox" class="custom-control-input" id="blog_notifications" 
                                          @if(Auth::user()->usersettings->blog_notifications == 1) checked="checked" @endif >
                                          <label class="custom-control-label" for="blog_notifications">استلم رسائل البريد الإلكتروني بشأن التحديثات والمنشورات الجديدة.</label>
                                      </div>

                                    </div>

                                        
                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات العروض</label>

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input name="offer_notifications" type="checkbox" class="custom-control-input" id="offer_notifications"
                                          @if(Auth::user()->usersettings->offer_notifications == 1) checked="checked" @endif >
                                          <label class="custom-control-label" for="offer_notifications">استلم رسائل البريد الإلكتروني بشأن العروض.</label>
                                      </div>

                                    </div>
                                </div>

                                <div class="row mb-4">                                        
                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات الطلبات</label>

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input name="booking_notifications" type="checkbox" class="custom-control-input" id="booking_notifications"  
                                          @if(Auth::user()->usersettings->booking_notifications == 1) checked="checked" @endif >

                                          <label class="custom-control-label" for="booking_notifications">استلم رسائل البريد الإلكتروني بشأن الحجوزات.</label>
                                      </div>

                                    </div>                                        

                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات التقييم والاراء</label>

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input  name="review_notifications"  type="checkbox" class="custom-control-input" id="review_notifications" 
                                          @if(Auth::user()->usersettings->review_notifications == 1) checked="checked" @endif >

                                          <label class="custom-control-label" for="review_notifications">استلم رسائل البريد الإلكتروني بشأن التقييمات</label>
                                      </div>

                                    </div>
                                </div>


                                <div class="row mb-4">
                                        
                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات الفرق</label>

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input name="team_notifications" type="checkbox" class="custom-control-input" id="team_notifications" 
                                          @if(Auth::user()->usersettings->team_notifications == 1) checked="checked" @endif >
                                          <label class="custom-control-label" for="team_notifications">استلم رسائل البريد الإلكتروني بشأن دعوات الفرق.</label>
                                      </div>

                                    </div>

                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات الملف الشخصي</label>
                                      

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input name="profile_notifications" type="checkbox" class="custom-control-input" id="profile_notifications"
                                          @if(Auth::user()->usersettings->profile_notifications == 1) checked="checked" @endif >

                                          <label class="custom-control-label" for="profile_notifications" >استلم رسائل البريد الإلكتروني بشأن تحديثات الملف الشخصي .</label>
                                      </div>

                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات الرسائل والمحادثات</label>
                                        

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input  name="message_notifications" type="checkbox" class="custom-control-input" id="message_notifications" @if(Auth::user()->usersettings->message_notifications == 1) checked="checked" @endif >

                                          <label class="custom-control-label" for="message_notifications">استلم رسائل البريد الإلكتروني بشأن المحادثات.</label>
                                      </div>

                                    </div>

                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات الدعم الفني</label>
                                        

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input name="support_notifications" type="checkbox" class="custom-control-input" id="support_notifications"  @if(Auth::user()->usersettings->support_notifications == 1) checked="checked" @endif >
                                          <label class="custom-control-label" for="support_notifications">استلم رسائل البريد الإلكتروني بشأن تذاكر الدعم الفني.</label>
                                      </div>

                                    </div>
                                </div>


                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات التفضيل للخدمات والمشاريع</label>
                                        

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input name="favorite_notifications"  type="checkbox" class="custom-control-input" id="favorite_notifications"  @if(Auth::user()->usersettings->favorite_notifications == 1) checked="checked" @endif >
                                          <label class="custom-control-label" for="favorite_notifications" >استلم رسائل البريد الإلكتروني بشأن التحديثات والمنشورات الجديدة.</label>
                                      </div>

                                    </div>

                                    <div class="col-12 col-sm-6 form-group">
                                      <label class="mb-1 font-weight-bold">تنبيهات التعليقات</label>

                                      <div class="custom-control custom-control-right custom-switch">
                                          <input name="replay_notifications" type="checkbox" class="custom-control-input" id="replay_notifications" @if(Auth::user()->usersettings->replay_notifications == 1) checked="checked" @endif > 
                                          <label class="custom-control-label" for="replay_notifications">استلم رسائل البريد الإلكتروني بشأن التحديثات والمنشورات الجديدة.</label>
                                      </div>

                                    </div>
                                </div>

                                <div class="row mt-5 mb-3">
                                    <div class="col-12">
                                        {!! Form::submit(trans('forms.save'), array('class'=>'btn btn-primary')) !!}
                                    </div>
                                </div>
                            {{ Form::close() }}

                            @endif





                        </div>
                    </div>
                </div>
                    
            </div>
        </div>
    </div>



@endsection

@section('jquery')
@endsection

