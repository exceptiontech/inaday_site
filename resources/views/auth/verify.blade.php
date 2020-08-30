@extends('layouts.inner')

@section('content')


<div id="innerpage" class="pt-4 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <div class="activation text-center text-white">

                    @if (session('resent'))
                        <div class="alert alert-success mb-3" role="alert">
                            {{ __('file.fresh_verify') }}
                        </div>
                    @endif

                        <div class="title">
                            <h1 class="mb-4 pb-5">مرحبا بك/  {{ Auth::user()->first_name.' '.Auth::user()->last_name }}</h1>
                        </div>

                        <p>{{ __('file.before_verify') }} {{ __('file.verifyـno_email') }}</p>
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button class="btn btn-primary mt-1" type="submit">{{ __('file.verifyـnew_email') }}</button>
                    </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
