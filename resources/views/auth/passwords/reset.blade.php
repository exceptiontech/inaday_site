@extends('layouts.inner')

@section('content')
<div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">استرجاع كلمة المرور</h2>
                </div>


                <div class="bg-light mt-5 p-3  wrapper col-12 col-sm-6 offset-sm-3 rounded">

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
                    <label for="login-form-password">كلمة المرور <br/><small style="color:red"> (هنا يتم ادخال كلمة المرور التي تستخدم فقط في الدخول  للموقع الإلكتروني الخاص بمجموعة البعد الفني ‎)</small></label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

                <div class="col_full">
                    <label for="login-form-password">تأكيد كلمة المرور <br/><small style="color:red"> (هنا يتم ادخال تأكيد كلمة المرور التي تستخدم فقط في الدخول  للموقع الإلكتروني الخاص بمجموعة البعد الفني ‎)</small></label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
                <div class="mt-2 text-center">
                    <button type="submit" class="btn btn-primary" >
                        ارسال
                    </button>
                </div>
            </form>


      </div>
    </div>
  </div>
</div>

@endsection
