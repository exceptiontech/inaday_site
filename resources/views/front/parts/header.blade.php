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
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
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
                        <a class="dropdown-item" href="{{ url('/account/profile#team') }}">{{trans('file.myteam')}}</a>
                        <a class="dropdown-item" href="{{ url('/account/teams/create') }}">{{trans('file.add_team')}}</a>
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
                  </div>
              </li>
              <li class="nav-item">
                <a class="nav-link @if(\Request::route()->getName() == 'faqs.index') active @endif" href="{{ url('/faqs') }}">{{trans('file.faqs')}}</a>
              </li>
            </ul>
            <ul class="navbar-nav ml-auto login_menu">
              <li class="nav-item">
                  <a class="nav-link noborder" href="#"> كيف يعمل انادي ؟ </a>
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
                  @else
                    <li class="nav-item not-active">
                        <a class="nav-link" href="{{ route('account.profile') }}">{{Auth::user()->first_name. ' ' .Auth::user()->last_name}}</a>
                    </li>
                  @endif
                  <li class="nav-item not-active">
                      <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link" href="#">{{trans('file.logout')}}</a>
                  </li>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
              @endguest
            </ul>
          </div>
        </nav>
      </div>
    </div>
  </div>
</header>
