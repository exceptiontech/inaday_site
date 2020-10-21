                                @if(Auth::user() && Auth::user()->isServicesProvider() && Auth::user()->isActive())

                                    <ul class="list-inline ">
                                        <li class="list-inline-item">
                                            <a class="@if( \Request::route()->getName() =='account.edit' ) active @endif" href="{{url('/account/profile/edit')}}">
                                               {{ __('file.about_me') }}
                                           </a>
                                        </li>

                                        <li class="list-inline-item "><a class="@if( \Request::route()->getName() =='front_experiences.index' ) active @endif" href="{{url('/account/experiences')}}">{{ __('file.my_experiences') }}</a></li>

                                        <li class="list-inline-item "><a class="@if( \Request::route()->getName() =='front_portfolios.index' ) active @endif" href="{{url('/account/portfolios')}}">{{ __('file.my_portfolios') }}</a></li>
                                        <!-- <li class="list-inline-item "><a class="@if( \Request::route()->getName() =='front_skills.index' ) active @endif" href="{{url('/account/skills')}}">مهاراتي</a></li> -->

                                        <!-- <li class="list-inline-item "><a class="@if( \Request::route()->getName() =='front_reviews.index' ) active @endif" href="{{url('/account/reviews')}}">اراء العملاء</a></li> -->



                                    </ul>
                                @elseif(Auth::user() && Auth::user()->isEntrepreneur() && Auth::user()->isActive())
                                    <ul class="list-inline">
                                        <li class="list-inline-item @if( \Request::route()->getName() =='account.edit' ) active @endif">
                                            <a href="{{url('/account/profile/edit')}}">{{ __('file.about_me') }}</a>
                                        </li>
<!--                                         <li class="list-inline-item @if( \Request::route()->getName() =='front_projects.index' ) active @endif">
                                            <a href="{{url('/account/projects')}}">مشاريعي</a>
                                        </li>
                                        <li class="list-inline-item @if( \Request::route()->getName() =='front_bookings.index' ) active @endif">
                                            <a href="{{url('/account/bookings')}}">الحجوزات</a>
                                        </li>
                                        <li class="list-inline-item @if( \Request::route()->getName() =='front_notifications.index' ) active @endif">
                                            <a href="{{url('/account/notifications')}}">الاشعارات</a>
                                        </li>
                                        <li class="list-inline-item @if( \Request::route()->getName() =='front_settings.index' ) active @endif">
                                            <a href="{{url('/account/settings')}}">الاعدادات</a>
                                        </li>
 -->                                    </ul>
                                @endif