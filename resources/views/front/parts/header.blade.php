<header>
  <div class="main-header">
    <div class="container">
      <div class="row">
        <nav class="navbar navbar-expand-lg navbar-light w-100">
          <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{url('images/logo.png') }}" alt="inaday">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse mt-3" id="navbarNavDropdown">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                  <a class="nav-link @if(\Request::route()->getName() == 'home' || \Request::route()->getName() == 'index') active @endif" href="{{ url('/') }}"  title="{{ config('app.name', 'Home') }}">{{trans('file.home')}}</a>
              </li>

                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle @if(\Request::route()->getName() == 'services-provider.index') active @endif" href="{{ url('/services-provider') }}"  id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{trans('file.service_providers')}}
                  </a>

                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      @if(Auth::user() && Auth::user()->isServicesProvider() && Auth::user()->isActive() )
                        <a class="dropdown-item" href="{{ url('/account/services/create') }}">{{trans('file.add_service')}}</a>
                        <a class="dropdown-item" href="{{ url('/account/team') }}">{{trans('file.myteam')}}</a>
                        <a class="dropdown-item" href="{{ url('/account/mixtures') }}">{{trans('file.mixtures')}}</a>
                      @else
                          <a class="dropdown-item" href="{{ url('/services-provider') }}">{{trans('file.about_service_provider')}}</a>
                      @endif
                  </div>

                </li>


                <li class="nav-item dropdown">
                  <a  class="nav-link dropdown-toggle @if(\Request::route()->getName() == 'entrepreneur.index') active @endif" href="{{ url('/entrepreneur') }}" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{trans('file.entrepreneurs')}}
                  </a>

                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      @if(Auth::user() && Auth::user()->isEntrepreneur() && Auth::user()->isActive() )
                            <a class="dropdown-item" href="{{ url('/account/projects/create') }}">{{trans('file.add_project')}}</a>
                      @else
                          <a class="dropdown-item" href="{{ url('/entrepreneur') }}">{{trans('file.about_entrepreneur')}}</a>
                      @endif
                  </div>

                </li>

              <li class="nav-item dropdown">
                  <a  class="nav-link dropdown-toggle @if(\Request::route()->getName() == 'projects.index' || \Request::route()->getName() == 'services.index') active @endif" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.services_list')}}</a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{ url('/projects') }}">{{trans('file.recent_projects')}}</a>
                    <a class="dropdown-item" href="{{ url('/services') }}">{{trans('file.booking_servives')}}</a>
                    <a class="dropdown-item" href="{{ url('/mixtures') }}">{{trans('file.booking_mixtures')}}</a>
                  </div>
              </li>
              <!-- <li class="nav-item">
                <a class="nav-link @if(\Request::route()->getName() == 'faqs.index') active @endif" href="{{ url('/faqs') }}">{{trans('file.faqs')}}</a>
              </li> -->
              @if(Auth::user())
              <li class="nav-item">
                  <a class="nav-link @if(\Request::route()->getName() == 'bookings.index' || \Request::route()->getName() == 'index') active @endif" href="{{ url('/account/bookings' ) }}" >{{trans('file.my_bookings')}}</a>
              </li>
              @endif

              <li class="nav-item">
                <a class="nav-link @if(\Request::route()->getName() == 'contact_us') active @endif" href="{{ url('/contact_us') }}">{{trans('file.contact_us')}}</a>
              </li>
            </ul>
            <ul class="navbar-nav ml-auto login_menu">
              <li class="nav-item">
                <a class="nav-link noborder" data-toggle="modal" data-target="#inadayModal">{{trans('file.how_inaday_work')}}  </a>
                <!-- Inaday -->
                <div class="modal fade" id="inadayModal" tabindex="-1" role="dialog" aria-labelledby="inadayModalLabel" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0 ">
                            <center>
                                <img class="img-fluid" src="{{url('images/Inaday_.jpg') }}" alt="inaday">
                            </center>

                        </div>
                    </div>
                </div>
                </div>

              </li>
              @guest
                <li class="nav-item not-active">
                    <a class="nav-link" href="#" data-toggle="modal"
                    data-target="#exampleModal" >{{trans('file.login')}}</a>
                </li>
                <li class="nav-item not-active">
                    <a class="nav-link" href="{{ url('/register') }}">{{trans('file.register')}}</a>
                </li>
                @else
                  @if(Auth::user()->isAdmin())
                    <li class="nav-item not-active">
                        <a class="nav-link" href="{{ url('/admin') }}">{{trans('file.adminpanel')}}</a>
                    </li>
                    <li class="nav-item not-active">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link" href="#">{{trans('file.logout')}}</a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>

                  @else

                    <li class="nav-item not-active notification-item mr-2">
                      <div class="dropdown">
                        <button class="btn  dropdown-toggle pl-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-bell" aria-hidden="true"></i>
                          @if(count(Auth::user()->unreadNotifications))
                            <span class="count">{{count(Auth::user()->unreadNotifications) ?? '0'}}</span>
                          @endif
                        </button>

                        <div class="dropdown-menu notification-dropdown" aria-labelledby="dropdownMenuButton">
                          @if(count(Auth::user()->unreadNotifications))
                            @foreach(Auth::user()->unreadNotifications->take(10) as $notification)
                              <a class="dropdown-item" href="
                              {{ url($notification->data['url'] ?? 'account/notifications/') }}
                              ">
                                <div class="d-flex">
                                    <div class="d-flex d-inline-block w-100">
                                        <div class="img mr-2">
                                          <img src="{{url($notification->data['image'] ?? 'images/research.png')}}" >
                                        </div>
                                        <div class="w-100">
                                          <h6 class="mb-1">{{ $notification->data['title'] ?? __('notification.undefined') }} <span class="pull-left ml-5">{{ Carbon\Carbon::parse(strtotime( $notification->created_at))->format('Y-m-d H:i') }} </span></h6>
                                          <p class="mb-1 p-0">{{ $notification->data['desc'] ?? __('notification.undefined') }}</p>
                                        </div>
                                    </div>
                                </div>
                              </a>
                            @endforeach
                          @else
                            <a class="dropdown-item disabled text-center" href="#">{{trans('file.no_notifications')}}</a>
                          @endif
                          <div class="d-flex text-center">
                            <a class="dropdown-item col-6 bg text-center" href="{{ url('account/notifications/') }}">
                              <i class="fa fa-bars ml-2" aria-hidden="true"></i>  {{trans('file.notifications')}}
                            </a>
                            <a class="dropdown-item col-6 bg text-center" href="{{ url('account/settings') }}">   <i class="fa fa-cog" aria-hidden="true"></i> {{trans('file.notifications_settings')}}
                            </a>
                          </div>
                        </div>

                      </div>
                    </li>


                    <li class="nav-item not-active mr-1">
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle rounded pt-1 pb-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle img-thumbnail img-icon30 img-fluid" src="{{ url(Auth::user()->userdetail->first()->avater ?? '/assets/images/logo.png' ) }}">
                        {{Auth::user()->first_name. ' ' .Auth::user()->last_name}}
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ url('/user/'.Auth::user()->id ) }}">
                          {{trans('file.profile')}}
                        </a>
                        <a class="dropdown-item" href="{{ url('/account/bookings' ) }}">
                          {{trans('file.my_bookings')}}
                        </a>
                        <a class="dropdown-item" href="{{ url('/account/messages' ) }}">
                          {{trans('file.chat')}}
                        </a>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item" href="#">{{trans('file.logout')}}</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                        </form>

                      </div>
                    </div>
                    </li>
                  @endif

              @endguest
            </ul>
          </div>
        </nav>
      </div>
    </div>
  </div>
</header>
