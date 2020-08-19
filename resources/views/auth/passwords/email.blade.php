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
          <p class="text-center">هل تواجه مشكلة في تذكر كلمة مرور الخاصة بك؟<br/>  الرجاء إدخال عنوان البريد الإلكتروني الخاص بك</p>
        </div>
        <form class="formsignup" method="POST" action="{{ route('password.email') }}">
            @csrf
            @if (session('status'))

                        <div class="alert alert-success" role="alert"><i class="fa fa-check"></i>
                            {{ session('status') }}
                        </div>
                    @endif

          <div class="row">
            <div class="col-sm-12 inpusrach">
              <label>ادخل البريد الإلكترونى<em>*</em></label>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="ضع ايميلك هنا">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
          </div>
          <div class="text-center">
            <button class="bottom" type="submit">استرجاع الان</button>
          </div>
        </form>
      </div>
    </div>
  </section>
@endsection
