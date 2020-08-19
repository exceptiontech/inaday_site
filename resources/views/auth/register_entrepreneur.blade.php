@extends('layouts.register_layout')

@section('title')
{{ __('file.entrepreneur_register') }}
@endsection
@section('content')

<style>
  .steps
  {
    display: none !important;
    visibility: hidden;
  }
</style>
<section class="signup new-item">
  <div class="step-app">
    <div class="logo">
      <a href="{{ url('/') }}"> <img src="{{url('assets/images/logo.png') }}" alt="Inaday" title="Inaday"></a>
    </div>
    <form class="formsignup" id="contact" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
      <div>
          <!-- ----------------------- 1 ------------------ -->
        <h3></h3>
        <section>
          <div class="row">
            <div class="col-sm-5 rightbox">
              <div class="contant-item">
                <h4 class="titletext">أهلاً بالخير</h4>

              </div>
            </div>
            <!-- End rightbox -->
            <div class="col-sm-7 leftbox">
              <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                  <div class="col-sm-12 inpusrach">
                      <p>الاستمرار
                        أنت كرائد أعمال تتصف بصفات تميزك عن كثير من الناس، لأنك مبدع، و تفكر بطريقة مختلفة، وعندك رؤية، ودايم تشوف المشاكل كفرص ممكن تستغلها لحل المشكلة من جهة وتكون مصدر دخل لك و لفريقك.
                        معك، الجميع يفوز!
                        بنمشي مع بعض برحلة، عشان فهم حاجاتك والعقبات اللي تواجهك بشكل أكثر، عشان نقدر نساعدك بأكثر شي نقدر عليه.
                        استمتع بالرحلة، وابدء بكتابة قصة نجاحك اليوم.</p>

                    </div>
                </div>
            </div>
          </div>
        </section>
        <!-- ----------------------- 1 ------------------ -->
        <h3 style="display:none !important;"></h3>
        <section>
          <div class="row">
            <div class="col-sm-5 rightbox">
              <div class="contant-item">
                <h4 class="titletext">معلوماتك</h4>
                <p>زودنا بمعلوماتك الأساسية عشان نقدر نتواصل معك بسهولة</p>
              </div>
            </div>
            <div class="col-sm-7 leftbox">
              <div class="row">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @csrf


                <a class="btn btn-block btn-danger p-3" href="{{url('/entrepreneur/google')}}"><i class="fab fa-google"></i>  {{__('file.register_with_google')}}</a>

                <input class="form-control" type="hidden" name="name" value="businessman">
                <div class="col-sm-6 inpusrach {{ $errors->has('name') ? ' has-error' : '' }}">
                  <label>{{ __('register_lang.f_name_t') }}<em>*</em></label>
                  <input name="first_name" class="form-control required {{ $errors->has('name') ? ' is-invalid' : '' }}"  id="firstname"  value="{{ old('first_name') }}" type="text" placeholder="{{ __('register_lang.f_name_t') }}" autofocus required="">
                  @if ($errors->has('name'))
                      <span class="invalid-feedback">
                          <strong>{{ $errors->first('name') }}</strong>
                      </span>
                  @endif
                </div>
                <div class="col-sm-6 inpusrach   {{ $errors->has('last_name') ? ' has-error' : '' }}">
                  <label>{{ __('register_lang.l_name_t') }}<em>*</em></label>
                  <input class="form-control required   {{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" id="lastname" type="text" placeholder="{{ __('register_lang.l_name_t') }}" required="">
                  @if ($errors->has('last_name'))
                  <span class="invalid-feedback">
                      <strong>{{ $errors->first('last_name') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="col-sm-6 inpusrach">
                  <label>{{ __('register_lang.email') }}<em>*</em></label>
                  <input  id="email" type="email" name="email" value="{{ old('email') }}"  class="form-control required {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email"  placeholder="{{ __('register_lang.email') }}"  required="">
                  @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="col-sm-6 inpusrach">
                  <label>{{ __('register_lang.mobile') }}<em>*</em></label>
                  <input class="form-control required" type="tel" name="mobile" placeholder="{{ __('register_lang.mobile') }}" id="phonenumber" required="" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                </div>
                <div class="col-sm-6 inpusrach  {{ $errors->has('password') ? ' has-error' : '' }}">
                  <label>{{ __('register_lang.password') }}<em>*</em></label>
                  <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control required {{ $errors->has('password') ? ' is-invalid' : '' }}"
                    aria-required="true"
                    placeholder="{{ __('register_lang.password') }}"
                  />
                  <span>{{trans('file.password_is_not_less_than_8_characters')}}</span>
                  @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                </div>
                <div class="col-sm-6 inpusrach">
                  <label>{{ __('register_lang.co_password') }}<em>*</em></label>
                  <input
                    id="confirm"
                    name="password_confirmation"
                    type="password"
                    class="form-control required"
                    aria-required="true"
                  />
                </div>
              </div>
            </div>
          </div>
        </section>






          </div>
        </form>



      </div>
    </section>

@endsection

@section('jquery')
<script type="text/javascript">

    $(document).ready(function() {

      jq = jQuery.noConflict();

      jq("#phonenumber").intlTelInput({
          localizedCountries: { 'sa': 'saudi arabia' },
          preferredCountries: ['sa', 'eg','ae','kw','om','sd'],
          excludeCountries: ["il"],
        }
      );
    });


</script>

@endsection
