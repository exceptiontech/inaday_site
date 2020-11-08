@extends('layouts.app')
@section('content')
<!-- Features begin-->
<div id="features" class="mt-5 mb-5">
    <div class="container">
        <div class=" title text-center mb-5">
            <h1 class="pb-5">{{trans('file.in_a_day_features')}}</h1>
        </div>
        <div  class="row mb-4">
            <!-- <div class="col-12 col-md-4">
                <div class="row d-flex align-items-start">
                    <div class="col-3 ">
                        <div class="image p-3">
                            <img src="images/team-management.jpg" alt="" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-9">
                        <h2>{{trans('file.practical_training')}}</h2>
                        <p>{{trans('file.the_possibility_of_forming_a_team_and_shop_to_enter_desc')}}</p>
                    </div>
                </div>
            </div> -->
            <div class="col-12 col-md-4">
                <div class="row d-flex align-items-start">
                    <div class="col-3">
                        <div class="image p-3">
                            <img src="images/support.png" alt="" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-9">
                        <h2>{{trans('file.the_possibility_of_forming_a_team_and_shop_to_enter')}}</h2>
                        <p>{{trans('file.the_possibility_of_forming_a_team_and_shop_to_enter_desc')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="row d-flex align-items-start">
                    <div class="col-3">
                        <div class="image p-3">
                            <img src="images/Page-1.png" alt="" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-9">
                        <h2>{{trans('file.comprehensive_certification')}}</h2>
                        <p>{{trans('file.comprehensive_certification_desc')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="row d-flex align-items-start">
                    <div class="col-3">
                        <div class="image p-3">
                            <img src="images/offer.png" alt="" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-9">
                        <h2>{{trans('file.feature_packages')}}</h2>
                        <p>{{trans('file.the_possibility_of_forming_a_team_and_shop_to_enter_desc')}}</p>
                    </div>
                </div>
            </div>


        </div>

        <div  class="row mb-4">
            <div class="col-12 col-md-4">
                <div class="row d-flex align-items-start">
                    <div class="col-3">
                        <div class="image p-3">
                            <img src="images/XMLID_806_.png" alt="" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-9">
                        <h2>{{trans('file.the_speed')}}</h2>
                        <p>{{trans('file.the_possibility_of_forming_a_team_and_shop_to_enter_desc')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="row d-flex align-items-start">
                    <div class="col-3">
                        <div class="image p-3">
                            <img src="images/research.png" alt="" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-9">
                        <h2>{{trans('file.ease')}}</h2>
                        <p>{{trans('file.the_possibility_of_forming_a_team_and_shop_to_enter_desc')}}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Features Section End -->

<!-- MemberShip begin-->
<div id="memberships">
    <div class="container-fluid text-center text-white">
        <div class="row">
            <div class="col-12 col-md-6 inverse pt-5 pb-5">
                <div class="col-8 offset-2">
                    <img class="mb-2 bg-white rounded-circle" src="{{url('images/service_provider.png') }}" alt="profile-image">
                    <p class="job-title mb-2">{{trans('file.job_seekers')}}</p>
                    <h2 class="profile-name mb-3">{{trans('file.service_providers')}}</h2>
                    <p class="profile-descrition mb-5 text-left">{{trans('file.service_provider_desc')}}</p>
                    <a class="btn btn-primary mb-5 btn-group-lg" href="{{ url('/register?type=services_provider') }}">{{trans('file.start_now')}}</a>
                </div>
            </div>
            <div class="col-12 col-md-6 pt-5 pb-5">
                <div class="col-8 offset-2">
                    <img class="mb-2 bg-white rounded-circle" src="{{url('images/entrepreneur.png') }}" alt="profile-image">
                    <p class="job-title mb-2">{{trans('file.new_entrepreneurs')}}</p>
                    <h2 class="profile-name mb-3">{{trans('file.owne_entrepreneurs')}}</h2>
                    <p class="profile-descrition mb-5 text-left">{{trans('file.entrepreneur_desc')}}</p>
                    <a class="btn btn-primary mb-5" href="{{ url('/register?type=entrepreneur') }}">{{trans('file.start_your_project')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MemberShip Section End -->

<!-- Mix begin-->
<div id="mix" class="pt-5 pb-5">
    <div class="container">
        <div class=" title text-center mb-4">
            <h1 class="pb-5">{{trans('file.ready_mixes')}}</h1>
        </div>
        <div  class="row">
            <div class="col-12 col-md-6">
                <h2 class="mb-4">{{trans('file.we_offer_you_complete_solutions')}}</h2>
                <p>{{trans('file.we_offer_you_complete_solutions_desc1')}}</p>
                <p>{{trans('file.we_offer_you_complete_solutions_desc2')}}</p>
                <p>{!! trans('file.we_offer_you_complete_solutions_desc3') !!}</p>
                <a class="btn btn-primary mt-5" href="{{url('/mixtures')}}">{{trans('file.more_mixes')}}</a>
            </div>
            <div class="col-12 col-md-6">
                <img class="img-fluid" src="{{url('images/mix.png') }}" alt="">
            </div>

        </div>
    </div>
</div>
<!-- Mix Section End -->

<!-- Stories begin-->
<!-- <div id="stories"  class="pt-5 pb-5" >
    <div class="container">
        <div class=" title text-center mb-5">
            <h1 class="pb-5">قصص نجاح ملهمة</h1>
        </div>
        <div class="row mt-5 pt-4">
            <div class="col-12 col-md-4 mb-5 mt-3">
                <div class="story text-center">
                    <img class="mt-n5" src="images/19571f92333dd5fba2598f637b68739c.png" alt="" class="rounded-circle" >
                    <div class="text p-4 pt-0">
                        <h2 class="mb-3">  محمد المأمون</h2>
                        <p>  يمكنك من خلال المنصة التدريب العملى الذي يؤهلك فيما بعد الى التوظيف وممارسة ما قمت بالتدرب علية يمكنك من خلال المنصة التدريب العملى الذي يؤهلك فيما بعد الى التوظيف وممارسة ما قمت بالتدرب علية</p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4 mb-5 mt-3">
                <div class="story text-center">
                    <img class="mt-n5" src="images/bd205a13adc1eee8654572d1082dd3da.png" alt="" class="rounded-circle" >
                    <div class="text p-4 pt-0">
                        <h2 class="mb-3">  مهند بازرباشي</h2>
                        <p>  يمكنك من خلال المنصة التدريب العملى الذي يؤهلك فيما بعد الى التوظيف وممارسة ما قمت بالتدرب علية يمكنك من خلال المنصة التدريب العملى الذي يؤهلك فيما بعد الى التوظيف وممارسة ما قمت بالتدرب علية</p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4 mb-5 mt-3">
                <div class="story text-center">
                    <img class="mt-n5" src="images/unnamed.png" alt="" class="rounded-circle" >
                    <div class="text p-4 pt-0">
                        <h2 class="mb-3">  يوسف مصطفي</h2>
                        <p>  يمكنك من خلال المنصة التدريب العملى الذي يؤهلك فيما بعد الى التوظيف وممارسة ما قمت بالتدرب علية يمكنك من خلال المنصة التدريب العملى الذي يؤهلك فيما بعد الى التوظيف وممارسة ما قمت بالتدرب علية</p>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-2 text-center">
                <a  class="btn btn-primary" href="#">المزيد من قصص النجاح</a>
            </div>
        </div>
    </div>
</div> -->
<!-- Stories Section End -->
@endsection

