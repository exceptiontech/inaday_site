@extends('layouts.inner')

@section('title')
	{{trans('file.service_providers')}}
@endsection


@section('content')
    <!-- Start widget inverse Section -->
    <div  class="widget widget-provider pt-5 pb-5 text-white">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="title">
                        <h2 class="mb-4 pb-4">{{trans('file.service_providers')}}</h2>
                    </div>
                    
                    <p>انت كمقدم خدمة، تعتبر حجر الأساس في المنصة، وأنت سبب نجاحها، عشان كذا، دائماً نبحث عن حلول في إنك تكون مرتاح و مبسوط. كل يوم نفكر، كيف تكون منصة .انادي. هي خيارك الأفضل وخيار كل مبدع و صاحب موهبة، و ابتكرنا حزمة من المميزات اللي ممكن تلفت انتباهك </p>
                    @guest
                        <a class="btn btn-primary mt-5 " href="{{url('/register')}}">سجل الان</a>

                    @else
                        <a class="btn btn-primary mt-5 " href="{{url('/account/profile')}}">لوحة التحكم</a>
                    @endguest
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

                    <a class="btn btn-primary mt-5" href="{{url('/account/services')}}">اضف خدمة</a>
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
                        <h2 class="mb-4 pb-4">الباقات و المزايا</h2>
                    </div>

                    <p>العمل عن بعد هو أسلوب الحياة الجديد، في منصة .انادي. بتكون تشتغل بالوقت اللي يناسبك، وبالقيمة اللي تناسبك، وفي المكان اللي يناسبك. بيكون عملك فيه إجازة، و إجازتك فيها عمل! ممتع؟ إذا تعتقد انك موهوب، وتحب الشغل، جرب احسب دخلك.</p>

                    <a class="btn btn-primary mt-5" href="{{url('/')}}">اضف خلطة</a>

                    <a class="btn btn-primary mt-5" href="#">تعرف على الخلطات</a>
                </div>

                <div class="col-12 col-md-6">
                    <img class="img-fluid" src="images/provider-features.png" alt="">
                </div>

            </div>
        </div>
    </div>
    <!-- widget Section End -->
@endsection
