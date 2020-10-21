<div class="col-12 col-md-4 sidaber">
    <div class="bg-light rounded pt-3 pb-3 p-2 text-center">

        <div class="mt-n5 ">
            <div class="row">
                <div class="col-4 pt-2">
                    @if(Auth::user())
                        @if($user->id == Auth::user()->id)
                        <a class="btn btn-light small" href="{{url('/account/profile/edit')}}"><i class="fa fa-pencil" aria-hidden="true"></i> {{ __('file.edit') }}</a>
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
                            <a class="btn btn-light small" href="{{url('/account/services')}}"><i class="fa fa-gear" aria-hidden="true"></i> {{ __('file.services_managment') }}</a>
                        @else
                            <a class="btn btn-light small" href="{{url('/account/projects')}}"><i class="fa fa-gear" aria-hidden="true"></i> {{ __('file.project_managment') }}</a>
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
                    {{ $user->userdetail->first()->position ?? __('file.undefined') }}
                @elseif(Auth::user() && Auth::user()->isEntrepreneur())
                    {{__('file.entrepreneurs')}}
                @else
                    {{__('file.undefined')}}
                @endif

            </li>
            <li class="list-inline-item">
                {{ $user->userdetail->first()->country->title[App::getLocale()] ?? __('file.undefined') }} / {{ $user->userdetail->first()->city->title[App::getLocale()] ?? __('file.undefined')}}</li>
        </ul>


        <div class="project-info mb-5 mt-5">
            <ul class="list-group list-group-flush">

                @if(count($user->roles) > 0)
                    @if($user->isServicesProvider())
                        <li class="list-group-item d-flex">
                            <a href="{{url('/user/'.$user->id.'/about')}}">{{ __('file.about_me') }}</a>
                        </li>

                        <li class="list-group-item d-flex">
                            <a href="{{url('/user/'.$user->id.'/services')}}">{{ __('file.my_services') }}</a>
                        </li>

                        <!-- <li class="list-group-item d-flex">
                            <a href="{{url('/user/'.$user->id.'/mixtures')}}">خلطاتي</a>
                        </li> -->
                        <li class="list-group-item d-flex">
                            <a href="{{url('/user/'.$user->id.'/skills')}}">{{ __('file.my_skills') }}</a>
                        </li>
                        <li class="list-group-item d-flex">
                            <a href="{{url('/user/'.$user->id.'/portfolios')}}">{{ __('file.my_portfolios') }} </a>
                        </li>
                        <li class="list-group-item d-flex">
                            <a href="{{url('/user/'.$user->id.'/experiences')}}">{{ __('file.my_experiences') }} </a>
                        </li>
                        <li class="list-group-item d-flex">
                            <a href="{{url('/user/'.$user->id.'/reviews')}} ">{{ __('file.my_reviews') }} </a>
                        </li>

                    @elseif($user->isEntrepreneur())
                        <li class="list-group-item d-flex">
                            <a href="{{url('/user/'.$user->id.'/about')}}">{{ __('file.about_me') }} </a>
                        </li>

                        <li class="list-group-item d-flex">
                            <a href="{{url('/user/'.$user->id.'/projects')}}">{{ __('file.my_projects') }} </a>
                        </li>

                    @else
                        <li class="list-group-item d-flex">
                            <a href="#" class="disabled"> {{ __('file.undefined') }}</a>
                        </li>
                    @endif
                @endif


            </ul>
        </div>


<!-- 
        <div class="col-12 contact_author align-bottom">
            <a href="{{url('/messages/'.$user->id)}}" class="btn btn-primary btn-block mb-2">تواصل معي</a>
        </div> -->

    </div>
</div>
<!-- sidebar End -->
