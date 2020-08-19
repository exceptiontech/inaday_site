@extends('layouts.inner')

@section('content')
<section class="banner">
    <div class="container">
      <h1 class="title"> {{ __('forms.login') }}</h1>
    </div>
  </section>
<section class="login">
<div class="container">
<div class="signupfilde">
      <div class="title-sig">
        <h3 class="titlebold"> {{ __('forms.login') }}</h3>
        <p class="text-center">{{ __('forms.login_txt') }}</p>
      </div>
        <div class="error"> </div>
        <form class="formsignup login-form1 needs-validation"  id="login" action="{{ route('login') }}" method="POST">
          @csrf
          <div class="row">
            @if(count($errors) > 0)
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissable" >
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4>{{ $error}}</h4>
                </div><!-- style="width: 40%;margin-left: 30%;display:"-->
            @endforeach

       @endif
            <div class="col-sm-12 inpusrach">
              <label>{{ __('forms.email') }}<em>*</em></label>
              <input  id="email" type="email" name="email" value="{{ old('email') }}"   class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('forms.email') }}">
              @if ($errors->has('email'))
                <span class="valid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif

            </div>
            <div class="col-sm-12 inpusrach {{ $errors->has('password') ? ' has-error' : '' }}">
                <label>{{ __('forms.password') }}<em>*</em></label>
                <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required  placeholder="{{ __('forms.password') }}">
                @if ($errors->has('password'))
                    <span class="valid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
              </div>
            </div>
            <div class="chicksign">
              <label class="che-box">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="label-text">{{ __('forms.remember') }}  </span>
              </label>
              @if (Route::has('password.request'))
              <a class="forgetlink" href="{{ route('password.request') }}">
                {{ __('forms.forget_pass') }}
              </a>
          @endif
            </div>
          <div class="text-center">
            <button class="bottom submit_ms btn-login1" name="btn-login1" type="submit"  id="id_complete" >تسجيل الدخول    </button>
          </div>
          <!--p class="textsign text-center">إذا لم يكن لديك حساب ،<a href="signup.html">سجل هنا</a></p-->

        </form>
        <div class="titlel-or">
            <p class="text-or">{{ __('forms.or_sign_by') }}</p>
        </div>
        <div class="clearfix"> &nbsp; </div>
        <nav class="form-group row">
        <a class="btn btn-block btn-danger p-3" href="{{url('/user/google')}}"><i class="fab fa-google"></i>  {{__('file.login_with_google')}}</a>
        </nav>
        <p class="mb-4">هذه الخاصية للاعضاء المسجلين بالفعل ، في حالة التسجيل يرجي استخدام صفحات التسجيل  بالاعلى ،في حالة الدخول من خلال جوجل هنا ستكون صاحب عضوية بلا اي صلاحيات</p>

    </div>
</div>
</section>
@endsection
