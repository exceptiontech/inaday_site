@extends('layouts.inner')

@section('title')
	{{trans('file.entrepreneurs')}}
@endsection


@section('content')
     <!-- Start widget inverse Section -->
     <div  class="widget widget-entrepreneur pt-5 pb-5 text-white">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 pb-5 pb-sm-0 mb-5 mb-sm-0">
                    <div class="title">
                        <h2 class="mb-4 pb-4">{{trans('file.entrepreneurs')}}</h2>
                    </div>
                    
                    <p>كثير من رواد الأعمال يأخرون بدء مشاريعهم من أجل مهام ليس لها علاقة حقيقة بنجاح المشروع، فالانتظار أشهر من أجل اختيار اسم أو شعار أو بناء موقع الكتروني، أو انتظار تمويل هي أهم أسباب تعطل كثير من المشاريع وإصابة أصحابها بالإحباط قبل البدء. </p>

                    @guest
                        <a class="btn btn-primary mt-3 mb-3 " href="{{url('/register?type=entrepreneur')}}">{{trans('file.register_now')}}</a>

                    @else
                        @if(Auth::user() && Auth::user()->isEntrepreneur())

                            <a class="btn btn-primary  mt-3 mb-5" href="{{url('/account/profile')}}">{{ __('file.profile') }}</a>
                        @else
                            <a class="btn btn-primary  mt-3 mb-5" href="{{url('/errors/denied')}}">{{trans('file.register_now')}}</a>
                            
                        @endif
                    @endguest

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
                    <img class="img-fluid" src="images/projectDependent.svg" alt="">
                </div>

                <div class="col-12 col-md-6">
                    
                    <div class="title">
                        <h2 class="mb-4 pb-4">نفّذ مشروعك الآن</h2>
                    </div>

                    <p>العمل عن بعد هو أسلوب الحياة الجديد، في منصة .IN.A.DAY. بتكون تشتغل بالوقت اللي يناسبك، وبالقيمة اللي تناسبك، وفي المكان اللي يناسبك. بيكون عملك فيه إجازة، و إجازتك فيها عمل! ممتع؟ إذا تعتقد انك موهوب، وتحب الشغل، جرب احسب دخلك.</p>

                    @if(Auth::user() && Auth::user()->isEntrepreneur())

                        <a class="btn btn-primary  mt-3 mb-3 " href="{{url('account/projects/create')}}">{{ __('file.add_newـproject') }}</a>
                    @else
                        <a class="btn btn-primary  mt-3 mb-3  " href="{{url('/projects')}}">{{ __('file.knowـprojects') }}</a>
                        
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- widget Section End -->


    <!-- widget begin-->
    <!-- <div class="widget pt-5 pb-5">
        <div class="container">
            <div  class="row">
                <div class="col-12 col-md-6">
                    <div class="title">
                        <h2 class="mb-4 pb-4">خدمة دراسة المشاريع</h2>
                    </div>
                    
                    <p>يعتبر تحليل المشروع من الأمور التى لا غنى عنها دائماً أثناء العمل وهى خطوة شديدة الأهمية فى مراحل بناء أى مشروع ناجح ، وتكمن أهميتها فى أنها تعطيك الفرصة لمعرفة أين أنت بالتحديد ونقاط الضعف والقوة لديك وكيف تتعامل مع العمل مدى ملائمة مشروعك للواقع الحالى.</p>

                    <a class="btn btn-primary mt-5" href="{{url('/mixtures')}}">تعرف على الخلطات</a>
                </div>

                <div class="col-12 col-md-6">
                    <img class="img-fluid" src="images/project_study.png" alt="">
                </div>

            </div>
        </div>
    </div> -->
    <!-- widget Section End -->
@endsection
