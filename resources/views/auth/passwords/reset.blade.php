@extends('layouts.inner')

@section('content')
<section class="banner">
    <div class="container">
      <h1 class="title">نسيت كلمة المرور</h1>
    </div>
  </section><!-- End Section panner Top -->

  <section class="login">
    <div class="container">
      <div class="signupfilde">
        <div class="title-sig">
            <h3 class="titlebold"> استرجاع كلمة المرور</h3>
            <p class="text-center">  الرجاء إدخال كلمه المرور الجديده</p>
          </div>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                @if (session('status'))

                        <div class="alert alert-success" role="alert"><i class="fa fa-check"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="col_full " style="display:none">
                    <label for="login-form-password">  {{ __('ms_lang.email_t') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus  placeholder="Type your E-mail adress">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col_full">
                    <label for="login-form-password">{{ __('ms_lang.pass_t') }} <br/><small style="color:red"> (هنا يتم ادخال كلمة المرور التي تستخدم فقط في الدخول  للموقع الإلكتروني الخاص بمجموعة البعد الفني ‎)</small></label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

                <div class="col_full">
                    <label for="login-form-password">{{ __('ms_lang.repass_t') }}  <br/><small style="color:red"> (هنا يتم ادخال تأكيد كلمة المرور التي تستخدم فقط في الدخول  للموقع الإلكتروني الخاص بمجموعة البعد الفني ‎)</small></label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
                <div class="col_full">
                    <button type="submit" class="button button-rounded si-google si-colored" >
                        {{ __('ms_lang.btn_edit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
