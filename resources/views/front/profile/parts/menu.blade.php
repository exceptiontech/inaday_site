                                @if(Auth::user() && Auth::user()->isServicesProvider() && Auth::user()->isActive())

                                    <ul class="list-inline ">
                                        <li class="list-inline-item">
                                            <a class="@if( \Request::route()->getName() =='account.edit' ) active @endif" href="{{url('/account/profile/edit')}}">
                                               نبذة عني
                                           </a>
                                        </li>
                                        <li class="list-inline-item "><a class="@if( \Request::route()->getName() =='front_services.index' ) active @endif" href="{{url('/account/services')}}">خدماتي</a></li>

                                        <li class="list-inline-item "><a class="@if( \Request::route()->getName() =='front_experiences.index' ) active @endif" href="{{url('/account/experiences')}}">خبراتي</a></li>

                                        <li class="list-inline-item "><a class="@if( \Request::route()->getName() =='front_portfolios.index' ) active @endif" href="{{url('/account/portfolios')}}">معرض الاعمال</a></li>
                                        <li class="list-inline-item "><a class="@if( \Request::route()->getName() =='front_skills.index' ) active @endif" href="{{url('/account/skills')}}">مهاراتي</a></li>

                                        <li class="list-inline-item "><a class="@if( \Request::route()->getName() =='front_reviews.index' ) active @endif" href="{{url('/account/reviews')}}">اراء العملاء</a></li>

                                        <li class="list-inline-item "><a class="@if( \Request::route()->getName() =='front_teams.index' ) active @endif" href="#">خلطاتي</a></li>

                                        <li class="list-inline-item"><a class="@if( \Request::route()->getName() =='front_team' ) active @endif" href="{{url('/account/team')}}">فريقي</a></li>

                                        <li class="list-inline-item"><a class=" @if( \Request::route()->getName() =='front_teams.index' ) active @endif" href="{{url('/account/teams')}}">الفرق المشارك بها</a></li>

                                        <li class="list-inline-item "><a class="disabled @if( \Request::route()->getName() =='front_bookings.index' ) active @endif"   href="#">الطلبات</a></li>

                                        <li class="list-inline-item"><a class="@if( \Request::route()->getName() =='front_credit.index' ) active @endif" href="{{url('/account/credit')}}">محفظتي</a></li>

                                        <li class="list-inline-item">
                                            <a class="@if( \Request::route()->getName() =='front_settings.index' ) active @endif" href="{{url('/account/settings')}}">الاعدادات</a>
                                        </li>

                                    </ul>
                                @elseif(Auth::user() && Auth::user()->isEntrepreneur() && Auth::user()->isActive())
                                    <ul class="list-inline">
                                        <li class="list-inline-item @if( \Request::route()->getName() =='account.edit' ) active @endif">
                                            <a href="{{url('/account/profile/edit')}}">نبذة عني</a>
                                        </li>
                                        <li class="list-inline-item @if( \Request::route()->getName() =='front_projects.index' ) active @endif">
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
                                    </ul>
                                @endif