                                @if(Auth::user() && Auth::user()->isServicesProvider() && Auth::user()->isActive())

                                    <ul class="list-inline ">
                                        <li class="list-inline-item "><a class="@if( \Request::route()->getName() =='front_services.index' ) active @endif" href="{{url('/account/services')}}">خدماتي</a></li>


                                        <li class="list-inline-item "><a class="@if( \Request::route()->getName() =='front_mixtures.index' ) active @endif" href="{{url('/account/mixtures')}}">خلطاتي</a></li>

                                        <li class="list-inline-item"><a class="@if( \Request::route()->getName() =='front_team' ) active @endif" href="{{url('/account/team')}}">فريقي</a></li>

                                        <li class="list-inline-item"><a class=" @if( \Request::route()->getName() =='front_teams.index' ) active @endif" href="{{url('/account/teams')}}">الفرق المشارك بها</a></li>

                                        <li class="list-inline-item "><a class=" @if( \Request::route()->getName() =='front_bookings.index' ) active @endif"   href="{{url('/account/bookings')}}">الطلبات</a></li>

                                        <li class="list-inline-item"><a class="@if( \Request::route()->getName() =='front_credit.index' ) active @endif" href="{{url('/account/credit')}}">محفظتي</a></li>

                                        <li class="list-inline-item">
                                            <a class="@if( \Request::route()->getName() =='front_notifications.index' ) active @endif" c href="{{url('/account/notifications')}}">الاشعارات</a>
                                        </li>

                                        <li class="list-inline-item">
                                            <a class="@if( \Request::route()->getName() =='front_settings.index' ) active @endif" href="{{url('/account/settings')}}">الاعدادات</a>
                                        </li>

                                    </ul>
                                @elseif(Auth::user() && Auth::user()->isEntrepreneur() && Auth::user()->isActive())
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a class="@if( \Request::route()->getName() =='front_projects.index' ) active @endif" href="{{url('/account/projects')}}">مشاريعي</a>
                                        </li>
                                        <li class="list-inline-item ">
                                            <a class="@if( \Request::route()->getName() =='front_bookings.index' ) active @endif" href="{{url('/account/bookings')}}">الحجوزات</a>
                                        </li>
                                        <li class="list-inline-item ">
                                            <a class="@if( \Request::route()->getName() =='front_notifications.index' ) active @endif" href="{{url('/account/notifications')}}">الإشعارات</a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a class="@if( \Request::route()->getName() =='front_credit.index' ) active @endif" href="{{url('/account/credit')}}">محفظتي</a>
                                        </li>
                                        <li class="list-inline-item ">
                                            <a class="@if( \Request::route()->getName() =='front_settings.index' ) active @endif" href="{{url('/account/settings')}}">الإعدادات</a>
                                        </li>
                                    </ul>
                                @endif