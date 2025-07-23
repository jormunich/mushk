<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        <ul class="nav nav-secondary">
            <li class="nav-item @if(Request::is('dashboard')) active @endif">
                <a href="{{ route('dashboard.index') }}">
                    <i class="fas fa-home"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">{{ __('User management') }}</h4>
            </li>
            <li class="nav-item @if(Request::is('dashboard/users*')) active @endif">
                <a href="{{ route('dashboard.users.index') }}">
                    <i class="fas fa-users"></i>
                    <p>{{ __('Users') }}</p>
                </a>
            </li>
            <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">{{ __('Content management') }}</h4>
            </li>
            <li class="nav-item @if(Request::is('dashboard/categories*')) active @endif">
                <a href="{{ route('dashboard.categories.index') }}">
                    <i class="fas fa-tag"></i>
                    <p>{{ __('Categories') }}</p>
                </a>
            </li>
            <li class="nav-item @if(Request::is('dashboard/products*')) active @endif">
                <a href="{{ route('dashboard.products.index') }}">
                    <i class="fas fa-box"></i>
                    <p>{{ __('Products') }}</p>
                </a>
            </li>
            <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">{{ __('Settings') }}</h4>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#settings">
                    <i class="fas fa-cog"></i>
                    <p>{{ __('Settings') }}</p>
                    <span class="caret"></span>
                </a>
                <div class="collapse" id="settings">
                    <ul class="nav nav-collapse">
                        <li>
                            <a href="#">
                                <span class="sub-item">{{ __('Main settings') }}</span>
                            </a>
                            <a href="#">
                                <span class="sub-item">{{ __('Company settings') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @admin
            <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">{{ __('Admin') }}</h4>
            </li>
            <li class="nav-item @if(Request::is('admin/users*')) active @endif">
                <a href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i>
                    <p>{{ __('Users') }}</p>
                </a>
            </li>
            <li class="nav-item @if(Request::is('admin/companies*')) active @endif">
                <a href="{{ route('admin.companies.index') }}">
                    <i class="fas fa-building"></i>
                    <p>{{ __('Companies') }}</p>
                </a>
            </li>
            @endAdmin
        </ul>
    </div>
</div>
