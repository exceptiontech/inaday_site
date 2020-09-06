@extends('layouts.inner')

@section('content')
<div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">{{ __('forms.login') }}</h2>
                </div>


                <div class="bg-light mt-5 p-3  wrapper col-12 col-sm-6 offset-sm-3 rounded">
                    <div class="">

                          <form class="formsignup login-form1 needs-validation"  id="login" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="row">
                              @if(count($errors) > 0)
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissable" >
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4>{{ $error}}</h4>
                                    </div>
                                @endforeach
                              @endif
                              <div class="col-sm-12 inpusrach">
                                <label class="label">{{ __('forms.email') }}<em>*</em></label>
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
                              <div class="chicksign mt-2">
                                <label class="che-box">
                                  <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                  <span class="label-text">{{ __('forms.remember') }}  </span>
                                </label>
                                @if (Route::has('password.request'))
                                <a class="forgetlink pull-left" href="{{ route('password.request') }}">
                                  {{ __('forms.forget_pass') }}
                                </a>
                            @endif
                              </div>
                            <div class="text-center">
                              <button class="btn btn-primary btn-login1" name="btn-login1" type="submit"  id="id_complete" >تسجيل الدخول    </button>
                            </div>
                            <!--p class="textsign text-center">إذا لم يكن لديك حساب ،<a href="signup.html">سجل هنا</a></p-->

                          </form>
                          <div class="titlel-or text-center mt-2">
                              <p class="text-or ">{{ __('forms.or_sign_by') }}</p>
                          </div>
                          <div class="form-group">
                            <a class="btn btn-block btn-danger p-3" href="{{url('/user/google')}}"><i class="fa fa-google"></i>  {{__('file.login_with_google')}}</a>
                          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
