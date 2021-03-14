<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item {{ request()->is('articles/*') ? 'active' : '' }}" data-item="articles">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">{{trans('admin.cms')}}</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('users/*') ? 'active' : '' }}" data-item="users">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">{{trans('admin.services_provider')}}</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->is('users/*') ? 'active' : '' }}" data-item="users2">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">{{trans('admin.entrepreneur')}}</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->is('market/*') ? 'active' : '' }}" data-item="market">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">{{trans('admin.market')}}</span>
                </a>
                <div class="triangle"></div>
            </li>

            <li class="nav-item {{ request()->is('user/*') ? 'active' : '' }}" data-item="workteam">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">{{trans('admin.workteam')}}</span>
                </a>
                <div class="triangle"></div>
            </li>
            <li class="nav-item {{ request()->is('reports/*') ? 'active' : '' }}" data-item="reports">
                <a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Bar-Chart"></i>
                    <span class="nav-text">{{trans('admin.reports')}}</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>

    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
        <!-- Submenu Dashboards -->
        <ul class="childNav" data-parent="articles">
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='departments.index' ? 'open' : '' }}"
                    href="{{ url('/admin/departments?type=blog') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.blog_departments')}}</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='articles.index' ? 'open' : '' }}"
                    href="{{ url('/admin/articles') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.articles')}}</span>
                </a>
            </li>


            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='departments.index' ? 'open' : '' }}"
                    href="{{ url('/admin/departments?type=sponsors') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.sponsors_departments')}}</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='sponsors.index' ? 'open' : '' }}"
                    href="{{ url('/admin/sponsors') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.sponsors')}}</span>
                </a>
            </li>

            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='departments.index' ? 'open' : '' }}"
                    href="{{ url('/admin/departments?type=sponsors') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.faqs_departments')}}</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='faqs.index' ? 'open' : '' }}"
                    href="{{ url('/admin/faqs') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.faqs')}}</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='surveys.index' ? 'open' : '' }}"
                    href="{{ url('/admin/surveys') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.surveys')}}</span>
                </a>
            </li>

        </ul>
        <ul class="childNav" data-parent="users">
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='users.index' ? 'open' : '' }}"
                    href="{{ url('/admin/users?type=services_provider') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.services_provider')}}</span>
                </a>
            </li>


            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='services.index' ? 'open' : '' }}"
                    href="{{ url('/admin/services') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.services')}}</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='mixtures.index' ? 'open' : '' }}"
                    href="{{ url('/admin/mixtures') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.mixtures')}}</span>
                </a>
            </li>

            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='sections.index' ? 'open' : '' }}"
                    href="{{ url('/admin/sections') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.sections')}}</span>
                </a>
            </li>


            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='interviews.index' ? 'open' : '' }}"
                    href="{{ url('/admin/interviews') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.interviews')}}</span>
                </a>
            </li>

            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='questions.index' ? 'open' : '' }}"
                    href="{{ url('/admin/questions') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.interviews_questions')}}</span>
                </a>
            </li>

            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='jobtypes.index' ? 'open' : '' }}"
                    href="{{ url('/admin/jobtypes') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.jobtypes')}}</span>
                </a>
            </li>


            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='prefers.index' ? 'open' : '' }}"
                    href="{{ url('/admin/prefers') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.prefers')}}</span>
                </a>
            </li>


            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='levels.index' ? 'open' : '' }}"
                    href="{{ url('/admin/levels') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.levels')}}</span>
                </a>
            </li>

            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='costkinds.index' ? 'open' : '' }}"
                    href="{{ url('/admin/costkinds') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.costkinds')}}</span>
                </a>
            </li>


            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='averagekinds.index' ? 'open' : '' }}"
                    href="{{ url('/admin/averagekinds') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.averagekinds')}}</span>
                </a>
            </li>



            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='applykinds.index' ? 'open' : '' }}"
                    href="{{ url('/admin/applykinds') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.applykinds')}}</span>
                </a>
            </li>



            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='rewardkinds.index' ? 'open' : '' }}"
                    href="{{ url('/admin/rewardkinds') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.rewardkinds')}}</span>
                </a>
            </li>



            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='readinesskinds.index' ? 'open' : '' }}"
                    href="{{ url('/admin/readinesskinds') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.readinesskinds')}}</span>
                </a>
            </li>

        </ul>

        <ul class="childNav" data-parent="users2">
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='users.index' ? 'open' : '' }}"
                    href="{{ url('/admin/users?type=entrepreneur') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.entrepreneur')}}</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='projects.index' ? 'open' : '' }}"
                    href="{{ url('/admin/projects') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.projects')}}</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='stages.index' ? 'open' : '' }}"
                    href="{{ url('/admin/stages') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.stages')}}</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='stages.create' ? 'open' : '' }}"
                    href="{{ url('/admin/stages/create') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.addstage')}}</span>
                </a>
            </li>
        </ul>

        <ul class="childNav" data-parent="market">
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='bookings.index' ? 'open' : '' }}"
                    href="{{ url('/admin/bookings') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.bookings')}}</span>
                </a>
            </li>
        </ul>


        <ul class="childNav" data-parent="workteam">
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='user.index' ? 'open' : '' }}"
                    href="{{ url('/admin/users?type=admin') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.admins')}}</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='user.index' ? 'open' : '' }}"
                    href="{{ url('/admin/users?type=Manager') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.managers')}}</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='user.index' ? 'open' : '' }}"
                    href="{{ url('/admin/users?type=employee') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.employees')}}</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='user.index' ? 'open' : '' }}"
                    href="{{ url('/admin/users?type=content_editor') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.content_editors')}}</span>
                </a>
            </li>
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='roles.index' ? 'open' : '' }}"
                    href="{{ url('/admin/roles') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.roles')}}</span>
                </a>
            </li>
        </ul>


        <ul class="childNav" data-parent="reports">
            <li class="nav-item ">
                <a class="{{ Route::currentRouteName()=='reports.users' ? 'open' : '' }}"
                    href="{{ url('/admin/reports/users') }}">
                    <i class="nav-icon i-Clock-3"></i>
                    <span class="item-name">{{trans('admin.reports')}}</span>
                </a>
            </li>
        </ul>

    </div>
    <div class="sidebar-overlay"></div>
</div>
<!--=============== Left side End ================-->