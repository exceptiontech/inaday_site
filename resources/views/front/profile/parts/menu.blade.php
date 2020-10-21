                                @if(Auth::user() && Auth::user()->isServicesProvider() && Auth::user()->isActive())

                                    <ul class="list-inline ">
                                        <li class="list-inline-item "><a class="@if( \Request::route()->getName() =='front_services.index' ) active @endif" href="{{url('/account/services')}}">{{ __('file.my_services') }}</a></li>


                                        <li class="list-inline-item "><a class="@if( \Request::route()->getName() =='front_mixtures.index' ) active @endif" href="{{url('/account/mixtures')}}">{{ __('file.my_mixtures') }}</a></li>

                                        <li class="list-inline-item"><a class="@if( \Request::route()->getName() =='front_team' ) active @endif" href="{{url('/account/team')}}">{{ __('file.my_team') }} </a></li>

                                        <li class="list-inline-item"><a class=" @if( \Request::route()->getName() =='front_teams.index' ) active @endif" href="{{url('/account/teams')}}">{{ __('file.my_teams') }} </a></li>

                                        <li class="list-inline-item "><a class=" @if( \Request::route()->getName() =='front_bookings.index' ) active @endif"   href="{{url('/account/bookings')}}">{{ __('file.my_bookings') }}</a></li>

                                        <li class="list-inline-item"><a class="@if( \Request::route()->getName() =='front_credit.index' ) active @endif" href="{{url('/account/credit')}}">
                                        {{ __('file.my_credit') }}</a></li>

                                        <li class="list-inline-item">
                                            <a class="@if( \Request::route()->getName() =='front_notifications.index' ) active @endif" c href="{{url('/account/')}}">
                                            {{ __('file.notifications') }}
                                            </a>
                                        </li>

                                        <li class="list-inline-item">
                                            <a class="@if( \Request::route()->getName() =='front_settings.index' ) active @endif" href="{{url('/account/settings')}}">
                                            {{ __('file.settings') }}
                                        </a>
                                        </li>

                                    </ul>
                                @elseif(Auth::user() && Auth::user()->isEntrepreneur() && Auth::user()->isActive())
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a class="@if( \Request::route()->getName() =='front_projects.index' ) active @endif" href="{{url('/account/projects')}}">{{ __('file.my_projects') }}</a>
                                        </li>
                                        <li class="list-inline-item ">
                                            <a class="@if( \Request::route()->getName() =='front_bookings.index' ) active @endif" href="{{url('/account/bookings')}}">{{ __('file.my_bookings') }}</a>
                                        </li>
                                        <li class="list-inline-item ">
                                            <a class="@if( \Request::route()->getName() =='front_notifications.index' ) active @endif" href="{{url('/account/notifications')}}">{{ __('file.notifications') }}</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a class="@if( \Request::route()->getName() =='front_credit.index' ) active @endif" href="{{url('/account/credit')}}">{{ __('file.my_credit') }}</a>
                                        </li>
                                        <li class="list-inline-item ">
                                            <a class="@if( \Request::route()->getName() =='front_settings.index' ) active @endif" href="{{url('/account/settings')}}">{{ __('file.settings') }}</a>
                                        </li>
                                    </ul>
                                @endif