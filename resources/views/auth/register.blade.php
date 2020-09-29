@extends('layouts.inner')
@section('title')
{{__('file.register')}}
@endsection

@section('content')
<form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="pt-4 pb-4 login">
            <div class="container">
                <div class="info-login text-center">
                    <h2 class="pb-4">{{trans('file.register')}}</h2>
                    <p class="pb-3">مرحبا بك يمكنك الآن اختيار الدور الذي ترغب به للإشتراك معنا لتكون من ضمن المساهمين في تحقيق
                        النفع
                        والإستفادة المتبادلة</p>
                </div>
                <div class="row justify-content-center">
                    <div class=" col-md-4 service_provider @if(Request()->type == 'services_provider') active  @endif ">
                        <input type="radio" id="TypeUser" name="user_type" value="services_provider"  
                        @if(Request()->type == 'services_provider') checked="checked"  @endif
                         @if(old('user_type') == 'services_provider') checked="checked"  @endif 

                         > <span>مقدم خدمة</span>
{{--                        <a href="{{ url('register/services_provider') }}" class="bottom" > {{trans('file.free_start')}} </a>--}}
                        <p> باحث عن عمل و تريدالمساعدة في تنفيذ المشاريع</p>
                    </div>
                    <div class="col-md-4 project_owner @if(Request()->type == 'entrepreneur') active  @endif">
                        <input type="radio"
                         @if(Request()->type == 'entrepreneur') checked="checked"  @endif 
                         @if(old('user_type') == 'entrepreneur') checked="checked"  @endif 

                         id="TypeUser2" name="user_type" value="entrepreneur"> <span>صاحب مشروع</span>
{{--                        <a href="{{ url('register/entrepreneur') }}" class="bottom" > {{trans('file.free_start')}} </a>--}}
                        <p>صاحب فكرة وعزيمة لديه حلم في بدء أعمال تجارية</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-5 text-left features">
            <div class="container">
                    @if (Session::has('message'))
                      <div class="alert alert-dismissible alert-{{Session::get('status')}}">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>    
                            {{Session::get('message')}}
                      </div>
                    @endif


                
                <div class="text-center google-login">
{{--                    <form method="POST" action="{{route('google')}}">--}}
{{--                        @csrf--}}
{{--                        <input type="hidden" name="type" id="Type" value="services_provider">--}}
{{--                        <button class="btn" type="submit" style="background-color: #DD4B39;border-radius: 0;padding-right: 30px;padding-left: 30px;padding-top: 5px;padding-bottom: 10px;color: #fff;margin-bottom: 50px;">--}}
{{--                            <i class="fa fa-google fa-lg"></i> {{__('file.register_with_google')}}--}}
{{--                        </button>--}}
{{--                    </form>--}}

                    @if(Request()->type == 'entrepreneur') 
                        <a class="btn" href="{{url('/entrepreneur/google')}}" id="Type"> <i class="fa fa-google fa-lg"></i> {{__('file.register_with_google')}}</a>
                    @elseif(Request()->type == 'services_provider') 
                        <a class="btn" href="{{url('/services_provider/google')}}" id="Type"> <i class="fa fa-google fa-lg"></i> {{__('file.register_with_google')}}</a>
                    @else
                        <a class="btn disabled" href="{{url('/services_provider/google')}}" id="Type"> <i class="fa fa-google fa-lg"></i> {{__('file.register_with_google')}}</a>
                    @endif
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row form-inputs">
                    <div class="col-md-4 {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label>{{ __('register_lang.f_name_t') }} <em>*</em></label>
                        <input name="first_name" class="form-control required {{ $errors->has('name') ? ' is-invalid' : '' }}"  id="firstname"  value="{{ old('first_name') }}" type="text" placeholder="{{ __('register_lang.f_name_t') }}" autofocus required="">
                        @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-4 {{ $errors->has('last_name') ? ' has-error' : '' }}">
                        <label>{{ __('register_lang.l_name_t') }} <em>*</em></label>
                        <input class="form-control required   {{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" id="lastname" type="text" placeholder="{{ __('register_lang.l_name_t') }}" required="">
                        @if ($errors->has('last_name'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <label>{{ __('register_lang.mobile') }} <em>*</em></label>
                        <input class="form-control required" type="tel" name="mobile" value="{{ old('mobile') }}"  id="phonenumber" required="" onkeyup="this.value=this.value.replace(/[^\d]/,'')" placeholder="05xxxxxxxx">
                    </div>
                    <div class="col-md-4">
                        <label>{{ __('register_lang.email') }} <em>*</em></label>
                        <input  id="email" type="email" name="email" value="{{ old('email') }}"  class="form-control required {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email"  placeholder="{{ __('register_lang.email') }}"  required="">
                        @if ($errors->has('email'))
                          <span class="invalid-feedback">
                              <strong>{{ $errors->first('email') }}</strong>
                          </span>
                        @endif
                    </div>
                    <div class="col-md-4 {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label>{{ __('register_lang.password') }} <em>*</em></label>
                        <input
                          id="password"
                          name="password"
                          type="password"
                          class="form-control required {{ $errors->has('password') ? ' is-invalid' : '' }}"
                          aria-required="true"
                          placeholder="{{ __('register_lang.password') }}"
                        />
                        <span class="text-danger">{{trans('file.password_is_not_less_than_8_characters')}}</span>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <label>{{ __('register_lang.co_password') }} <em>*</em></label>
                        <input
                          id="confirm"
                          name="password_confirmation"
                          type="password"
                          class="form-control required"
                          aria-required="true"
                        />
                    </div>
                </div>

                <div class="py-4">
                    <input type="checkbox" id="accepted1" name="accepted1">
                    <label>أتعهد أن أعمل بإخلاص وأحافظ على خصوصية واحترام الجميع</label>
                </div>
                <div class="pb-3">
                    <input type="checkbox" id="accepted2" name="accepted12">
                    <label>قرأت وقبلت سياسة عدم الإفشاء وكافة بنود العقد الخاص بها <u> الشروط والأحكام</u>
                        <u>وسياسة
                            الخصوصية</u></label>
                </div>
                <button class="btn btn-primary" type="submit" id="id_complete" disabled="disabled" style="background-color:silver !important">تسجيل </button>
            </div>
        </div>
    </form>

@endsection
