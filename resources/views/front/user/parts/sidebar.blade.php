<div class="col-12 col-md-4 sidaber">
    <div class="bg-light rounded pt-3 pb-3 p-2 text-center">

        <div class="mt-n5 ">
            <div class="row">
                <div class="col-4 pt-2">
                    @if(Auth::user())
                        @if($user->id == Auth::user()->id)
                        <a class="btn btn-light small" href="{{url('/account/profile/edit')}}"><i class="fa fa-pencil" aria-hidden="true"></i> تعديل</a>
                        @endif
                    @endif
                </div>
                <div class="col-3 p-0">
                    <img src="{{ url($user->userdetail->first()->avater ?? '/assets/images/logo.png' ) }}" class="rounded-circle img-thumbnail img-icon80 img-fluid">
                </div>
                <div class="col-5 pt-2">
                    @if(Auth::user())
                    @if($user->id == Auth::user()->id)
                        @if(Auth::user() && Auth::user()->isServicesProvider() && Auth::user()->isActive() )
                            <a class="btn btn-light small" href="{{url('/account/services')}}"><i class="fa fa-gear" aria-hidden="true"></i> ادارة الخدمات</a>
                        @else
                            <a class="btn btn-light small" href="{{url('/account/projects')}}"><i class="fa fa-gear" aria-hidden="true"></i> ادارة المشاريع</a>
                        @endif

                    @endif
                    @endif
                </div>
            </div>
        </div>

        <h2 class="mt-5">{{$user->first_name. ' ' .$user->last_name}}</h2>

        <ul class="list-inline info">
            <li class="list-inline-item">
                @if(Auth::user() && Auth::user()->isServicesProvider())
                    {{ $user->userdetail->first()->position ?? 'غير محدد الوظيفة' }}
                @elseif(Auth::user() && Auth::user()->isEntrepreneur())
                    رائد أعمال
                @else
                    غير محدد
                @endif

            </li>
            <li class="list-inline-item">
                {{ $user->userdetail->first()->country->title[App::getLocale()] ?? 'دولة غير محددة'}} / {{ $user->userdetail->first()->city->title[App::getLocale()] ?? 'مدينة غير محددة '}}</li>
        </ul>


        <div class="project-info mb-5 mt-5">
            <ul class="list-group list-group-flush">

                @if(count($user->roles) > 0)
                    @if($user->isServicesProvider())
                        <li class="list-group-item d-flex">
                            <a href="{{url('/user/'.$user->id.'/about')}}">نبذة عني</a>
                        </li>

                        <li class="list-group-item d-flex">
                            <a href="{{url('/user/'.$user->id.'/services')}}">خدماتي</a>
                        </li>
                        <li class="list-group-item d-flex">
                            <a href="{{url('/user/'.$user->id.'/skills')}}">مهاراتي</a>
                        </li>
                        <li class="list-group-item d-flex">
                            <a href="{{url('/user/'.$user->id.'/portfolios')}}">معرض الأعمال</a>
                        </li>
                        <li class="list-group-item d-flex">
                            <a href="{{url('/user/'.$user->id.'/experiences')}}">خبراتي</a>
                        </li>
                        <li class="list-group-item d-flex">
                            <a href="{{url('/user/'.$user->id.'/reviews')}} ">تقييمات العملاء</a>
                        </li>

                    @elseif($user->isEntrepreneur())
                        <li class="list-group-item d-flex">
                            <a href="{{url('/user/'.$user->id.'/about')}}">نبذة عني</a>
                        </li>

                        <li class="list-group-item d-flex">
                            <a href="{{url('/user/'.$user->id.'/projects')}}">مشاريعي</a>
                        </li>

                    @else
                        <li class="list-group-item d-flex">
                            <a href="#" class="disabled">عضويتك غير محددة راجع الادارة</a>
                        </li>
                    @endif
                @endif


            </ul>
        </div>


        <div class="col-12 contact_author align-bottom">
            <a href="{{url('/messages/'.$user->id)}}" class="btn btn-primary btn-block mb-2">تواصل معي</a>
        </div>

    </div>
</div>
<!-- sidebar End -->
