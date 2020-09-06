@extends('layouts.inner')

@section('content')

<div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12 title">
                    <h2 class="text-white mb-5">نسيت كلمة المرور</h2>
                </div>


                <div class="bg-light mt-5 p-3  wrapper col-12 col-sm-6 offset-sm-3 rounded">

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
          <div class="text-center mt-2">
            <button class="btn btn-primary" type="submit">استرجاع الان</button>
          </div>
        </form>



      </div>
    </div>
  </div>
</div>
@endsection
