<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4 text-muted" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header d-flex  align-items-center">
            <a class="text-black-50 fw-bold text-left h3 fw-bolder" href="{{ route('admin.home') }}">
                {{ trans('panel.site_title') }}</a>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">

                <li class=" nav-item">
                    <a href="{{ route('admin.home') }}">
                        <i class="menu-livicon livicon-evo-holder" data-icon="dashboard"></i>
                        <span class="menu-title text-truncate" data-i18n="Dashboard">
                            {{ trans('global.dashboard') }}
                        </span>
                    </a>
                </li>

                {{-- user management --}}
                @can('user_management_access')
                <li class="nav-item has-sub {{ request()->is('admin/permissions*') ? 'open' : '' }} {{ request()->is('admin/roles*') ? 'open' : '' }} {{ request()->is('admin/users*') ? 'open' : '' }} {{ request()->is('admin/audit-logs*') ? 'open' : '' }}">
                    <a href="#" class="custom-a">
                        <i class="menu-livicon livicon-evo-holder" data-icon="users"></i>
                        <span class="menu-title text-truncate" data-i18n="Icons">
                            {{ trans('cruds.userManagement.title') }}
                        </span>
                    </a>
                    <ul class="menu-content" style="">
                        @can('permission_access')
                        <li class="{{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.permissions.index') }}">
                                <i class="menu-livicon livicon-evo-holder" data-icon="morph-lock"></i>
                                <span class="menu-item text-truncate" data-i18n="LivIcons">
                                    {{ trans('cruds.permission.title') }}</span></a>
                        </li>
                        @endcan
                        @can('role_access')
                        <li class="{{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.roles.index') }}">
                                <i class="menu-livicon livicon-evo-holder" data-icon="briefcase"></i>
                                <span class="menu-item text-truncate" data-i18n="BoxIcons">
                                    {{ trans('cruds.role.title') }}
                                </span></a>
                        </li>
                        @endcan
                        @can('user_access')
                        <li class="{{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.users.index') }}">
                                <i class="menu-livicon livicon-evo-holder" data-icon="user"></i>
                                <span class="menu-item text-truncate" data-i18n="BoxIcons">
                                    {{ trans('cruds.user.title') }}
                                </span></a>
                        </li>
                        @endcan
                        @can('audit_log_access')
                        <li class=" {{ request()->is('admin/audit-logs') || request()->is('admin/audit-logs/*') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.audit-logs.index') }}">
                                <i class="menu-livicon livicon-evo-holder" data-icon="morph-doc"></i>
                                <span class="menu-item text-truncate" data-i18n="BoxIcons">
                                    {{ trans('cruds.auditLog.title') }}
                                </span></a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @can('branch_access')
                <li class=" nav-item {{ request()->is('admin/branches') || request()->is('admin/branches/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.branches.index') }}">
                        <i class="menu-livicon livicon-evo-holder" data-icon="diagram"></i>
                        <span class="menu-title text-truncate">
                            {{ trans('cruds.branch.title') }}
                        </span>
                    </a>
                </li>
                @endcan
                @can('customer_access')
                <li class=" nav-item {{ request()->is('admin/customers') || request()->is('admin/customers/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.customers.index') }}">
                        <i class="menu-livicon livicon-evo-holder" data-icon="users"></i>
                        <span class="menu-title text-truncate">
                            {{ trans('cruds.customer.title') }}
                        </span>
                    </a>
                </li>
                @endcan
                @can('category_access')
                <li class=" nav-item {{ request()->is('admin/categories') || request()->is('admin/categories/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.categories.index') }}">
                        <i class="menu-livicon livicon-evo-holder" data-icon="grid"></i>
                        <span class="menu-title text-truncate">
                            {{ trans('cruds.category.title') }}
                        </span>
                    </a>
                </li>
                @endcan
                @can('product_access')
                <li class=" nav-item {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.products.index') }}">
                        <i class="menu-livicon livicon-evo-holder" data-icon="shoppingcart"></i>
                        <span class="menu-title text-truncate">
                            {{ trans('cruds.product.title') }}
                        </span>
                    </a>
                </li>
                @endcan
                @can('invoice_access')
                <li class=" nav-item {{ request()->is('admin/invoices') || request()->is('admin/invoices/*') ? 'active' : '' }}">
                    <a href="{{ route('admin.invoices.index') }}">
                        <i class="menu-livicon livicon-evo-holder" data-icon="file-import"></i>
                        <span class="menu-title text-truncate">
                            {{ trans('cruds.invoice.title') }}
                        </span>
                    </a>
                </li>
                @endcan

                @can('customer_assign_access')
                <li class="nav-item has-sub {{ request()->is('admin/customer_assign*') ? 'open' : '' }}">
                    <a href="#" class="custom-a">
                        <i class="menu-livicon livicon-evo-holder" data-icon="users"></i>
                        <span class="menu-title text-truncate" data-i18n="Icons">
                            {{ trans('cruds.customerAssign.title') }}
                        </span>
                    </a>
                    <ul class="menu-content">
                        <li class="{{ request()->is('admin/customer-assigns') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.customer-assigns.index') }}">
                                <i class="menu-livicon livicon-evo-holder" data-icon="gear"></i>
                                <span class="menu-item text-truncate" data-i18n="LivIcons">
                                    All Services
                                </span></a>
                        </li>
                        <li class="{{ request()->is('admin/customer-assigns/action/completed') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.customer.assign.completed') }}">
                                <i class="menu-livicon livicon-evo-holder" data-icon="check-alt"></i>
                                <span class="menu-item text-truncate" data-i18n="LivIcons">
                                    Completed
                                </span></a>
                        </li>
                        <li class="{{ request()->is('admin/customer-assigns/action/suspend') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.customer.assign.suspend') }}">
                                <i class="menu-livicon livicon-evo-holder" data-icon="timer"></i>
                                <span class="menu-item text-truncate" data-i18n="LivIcons">
                                    Suspend
                                </span></a>
                        </li>

                    </ul>
                </li>
                @endcan

                {{-- changepassword --}}
                @if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                @can('profile_password_edit')
                <li class=" nav-item {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                    <a href="{{ route('profile.password.edit') }}">
                        <i class="menu-livicon livicon-evo-holder" data-icon="unlock"></i>
                        <span class="menu-title text-truncate" data-i18n="Dashboard">
                            {{ trans('global.change_password') }}
                        </span>
                    </a>
                </li>
                @endcan
                @endif

                {{-- logout --}}
                <li class=" nav-item">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <i class="menu-livicon livicon-evo-holder" data-icon="morph-login"></i>
                        <span class="menu-title text-truncate" data-i18n="Dashboard">
                            {{ trans('global.logout') }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>
