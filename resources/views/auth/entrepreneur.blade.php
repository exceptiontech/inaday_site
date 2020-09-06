@extends('layouts.inner')

@section('title')
	{{trans('file.entrepreneurs')}}
@endsection


@section('content')
     <!-- Start widget inverse Section -->
     <div  class="widget widget-entrepreneur pt-5 pb-5 text-white">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="title">
                        <h2 class="mb-4 pb-4">{{trans('file.entrepreneurs')}}</h2>
                    </div>
                    
                    <p>كثير من رواد الأعمال يأخرون بدء مشاريعهم من أجل مهام ليس لها علاقة حقيقة بنجاح المشروع، فالانتظار أشهر من أجل اختيار اسم او شعار او بناء موقع الكتروني، او انتظار تمويل هي أهم أسباب تعطل كثير من المشاريع وإصابة اصحابها بالإحباط قبل البدء. </p>

                    <a class="btn btn-primary mt-5" href="#">نفّذ مشروعك الآن</a>
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

                    <p>العمل عن بعد هو أسلوب الحياة الجديد، في منصة .انادي. بتكون تشتغل بالوقت اللي يناسبك، وبالقيمة اللي تناسبك، وفي المكان اللي يناسبك. بيكون عملك فيه إجازة، و إجازتك فيها عمل! ممتع؟ إذا تعتقد انك موهوب، وتحب الشغل، جرب احسب دخلك.</p>

                    <a class="btn btn-primary mt-5" href="#">نفّذ مشروعك الآن</a>
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
                        <h2 class="mb-4 pb-4">خدمة دراسة المشاريع</h2>
                    </div>
                    
                    <p>يعتبر تحليل المشروع من الأمور التى لا غنى عنها دائماً أثناء العمل وهى خطوة شديدة الأهمية فى مراحل بناء أى مشروع ناجح ، وتكمن أهميتها فى أنها تعطيك الفرصة لمعرفة أين أنت بالتحديد ونقاط الضعف والقوة لديك وكيف تتعامل مع العمل مدى ملائمة مشروعك للواقع الحالى.</p>

                    <a class="btn btn-primary mt-5" href="#">تعرف على الخلطات</a>
                </div>

                <div class="col-12 col-md-6">
                    <img class="img-fluid" src="images/project_study.png" alt="">
                </div>

            </div>
        </div>
    </div>
    <!-- widget Section End -->
@endsection
