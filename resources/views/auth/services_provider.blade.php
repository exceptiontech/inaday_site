@extends('layouts.inner')

@section('title')
	{{trans('file.service_providers')}}
@endsection


@section('content')
    <!-- Start widget inverse Section -->
    <div  class="widget widget-provider pt-5 pb-5 text-white">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 pb-5 pb-sm-0 mb-5 mb-sm-0">
                    <div class="title">
                        <h2 class="mb-4 pb-4">{{trans('file.service_providers')}}</h2>
                    </div>
                    
                    <p>انت كمقدم خدمة، تعتبر حجر الأساس في المنصة، وأنت سبب نجاحها، عشان كذا، دائماً نبحث عن حلول في إنك تكون مرتاح و مبسوط. كل يوم نفكر، كيف تكون منصة .IN.A.DAY. هي خيارك الأفضل وخيار كل مبدع و صاحب موهبة، و لذلك ابتكرنا حزمة من المميزات اللي ممكن تلفت انتباهك </p>

                    @guest
                        <a class="btn btn-primary mt-3 mb-3 " href="{{url('/register?type=services_provider')}}">
                        {{trans('file.register_now')}}
                    </a>

                    @else
                        @if(Auth::user() && Auth::user()->isServicesProvider())

                            <a class="btn btn-primary mt-3 mb-5 " href="{{url('/account/profile')}}">{{ __('file.profile') }}</a>
                        @else
                            <a class="btn btn-primary mt-3 mb-5" href="{{url('/errors/denied')}}">
                                {{trans('file.register_now')}}
                            </a>
                            
                        @endif

                    @endguest
                    <div class="mb-5 mb-sm-0 pb-5 pb-sm-0"></div>
                    <div class="mb-5 mb-sm-0 pb-5 pb-sm-0"></div>


                </div>

            </div>
        </div>
    </div>
    <!-- Hero Section End -->
  

    <!-- widget begin-->
    <div class="widget pt-5 pb-5">
        <div class="container">
            <div  class="row">

                <div class="col-12 col-md-6">
                    <img class="img-fluid" src="images/dreams.svg" alt="">
                </div>

                <div class="col-12 col-md-6">
                    
                    <div class="title">
                        <h2 class="mb-4 pb-4">حقق أهدافك</h2>
                    </div>

                    <p>العمل عن بعد هو أسلوب الحياة الجديد، في منصة .انادي. بتكون تشتغل بالوقت اللي يناسبك، وبالقيمة اللي تناسبك، وفي المكان اللي يناسبك. بيكون عملك فيه إجازة، و إجازتك فيها عمل! ممتع؟ إذا تعتقد انك موهوب، وتحب الشغل، جرب احسب دخلك.</p>

                    <a class="btn btn-primary mt-5" href="{{url('/account/services')}}">{{ __('file.add_newـservice') }}</a>
                </div>
            </div>
        </div>
    </div>
    <!-- widget Section End -->


    <!-- widget begin-->
    <div class="widget pt-5 pb-5">
        <div class="container">
            <div  class="row">
                <div class="col-12 col-md-6">
                    <div class="title">
                        <h2 class="mb-4 pb-4">باقات ومزايا</h2>
                    </div>

                    <p>العمل عن بعد هو أسلوب الحياة الجديد، في منصة .انادي. بتكون تشتغل بالوقت اللي يناسبك، وبالقيمة اللي تناسبك، وفي المكان اللي يناسبك. بيكون عملك فيه إجازة، و إجازتك فيها عمل! ممتع؟ إذا تعتقد انك موهوب، وتحب الشغل، جرب احسب دخلك.</p>

                        @if(Auth::user() && Auth::user()->isServicesProvider())

                            <a class="btn btn-primary mt-3 mb-3" href="{{url('/account/mixtures/create')}}">{{ __('file.add_newـmixture') }}</a>
                        @else
                            <a class="btn btn-primary mt-3 mb-3 " href="{{url('/mixtures')}}">
                                {{ __('file.knowـmixtures') }}
                            </a>
                            
                        @endif



                </div>

                <div class="col-12 col-md-6">
                    <img class="img-fluid" src="images/provider-features.png" alt="">
                </div>

            </div>
        </div>
    </div>
    <!-- widget Section End -->
@endsection
