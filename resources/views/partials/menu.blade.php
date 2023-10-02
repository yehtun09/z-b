<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('zandblogo.jpg') }}" alt="Auth Cover Bg color" width="30" />
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">Z&B</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
            <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <!-- Dashboards -->
        <li class="menu-item {{ request()->is('admin') ? 'active' : '' }}">
            <a href="{{ route('admin.home') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div> {{ trans('global.dashboard') }}</div>
            </a>
        </li>

        {{-- user management --}}
        @can('user_management_access')
            <li
                class="menu-item  {{ request()->is('admin/permissions*') ? 'active open' : '' }} {{ request()->is('admin/roles*') ? 'active open' : '' }} {{ request()->is('admin/users*') ? 'active open' : '' }} {{ request()->is('admin/audit-logs*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Dashboards">User management</div>
                </a>
                <ul class="menu-sub">
                    @can('permission_access')
                        <li
                            class="menu-item  {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.permissions.index') }}" class="menu-link">
                                <div data-i18n="Analytics"> {{ trans('cruds.permission.title') }}</div>
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li
                            class="menu-item {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.roles.index') }}" class="menu-link">
                                <div data-i18n="eCommerce"> {{ trans('cruds.role.title') }}</div>
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li
                            class="menu-item {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.index') }}" class="menu-link">
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li
                            class="menu-item {{ request()->is('admin/audit-logs') || request()->is('admin/audit-logs/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.audit-logs.index') }}" class="menu-link">
                                <div data-i18n="eCommerce"> {{ trans('cruds.auditLog.title') }}</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan


        {{-- branches --}}
        {{-- @can('branch_access')
            <li
                class="menu-item {{ request()->is('admin/branches') || request()->is('admin/branches/*') ? 'active' : '' }}">
                <a href="{{ route('admin.branches.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-sitemap"></i>
                    <div> {{ trans('cruds.branch.title') }}</div>
                </a>
            </li>
        @endcan --}}


        {{-- products --}}
        @can('product_access')
            <li
                class="menu-item {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'active' : '' }}">
                <a href="{{ route('admin.products.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cart"></i>
                    <div> {{ trans('cruds.product.title_singular') }} {{ trans('cruds.product.fields.management') }}</div>
                </a>
            </li>
        @endcan

        {{-- service_types --}}
        @can('service_type_access')
            <li
                class="menu-item {{ request()->is('admin/serviceTypes') || request()->is('admin/serviceTypes/*') ? 'active' : '' }}">
                <a href="{{ route('admin.service-types.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cart"></i>
                    <div>{{ trans('cruds.customer.fields.service_type') }}</div>
                </a>
            </li>
        @endcan

        {{-- township --}}
        @can('township_access')
            <li
                class="menu-item {{ request()->is('admin/Townships') || request()->is('admin/Townships/*') ? 'active' : '' }}">
                <a href="{{ route('admin.townships.index') }}" class="menu-link">
                    <i class="menu-icon fa-solid fa-city"></i>
                    <div>{{ trans('cruds.customer.fields.township') }}</div>
                </a>
            </li>
        @endcan

        {{-- service_plan --}}
        @can('service_plan_access')
            <li
                class="menu-item {{ request()->is('admin/servicePlans') || request()->is('admin/servicePlans/*') ? 'active' : '' }}">
                <a href="{{ route('admin.service_plans.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cart"></i>
                    <div>{{ trans('cruds.customer.fields.service_plan') }}</div>
                </a>
            </li>
        @endcan

        {{-- customers --}}
        @can('customer_access')
            <li
                class="menu-item {{ request()->is('admin/customers') || request()->is('admin/customers/*') ? 'active' : '' }}">
                <a href="{{ route('admin.customers.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div> {{ trans('cruds.site.title') }}</div>
                </a>
            </li>
        @endcan

        {{-- invoice --}}
        @can('invoice_access')
            <li
                class="menu-item {{ request()->is('admin/invoices') || request()->is('admin/invoices/*') ? 'active' : '' }}">
                <a href="{{ route('admin.invoices.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-file"></i>
                    <div> {{ trans('cruds.invoice.title') }}</div>
                </a>
            </li>
        @endcan

        {{-- customer assign --}}
        @can('customer_assign_access')
            <li
                class="menu-item  {{ request()->is('admin/customer-assigns*') ? 'active open' : '' }} {{ request()->is('admin/roles*') ? 'active open' : '' }} {{ request()->is('admin/users*') ? 'active open' : '' }} ">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-cog"></i>
                    <div>{{ trans('cruds.customerAssign.title') }}</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item  {{ request()->is('admin/customer-assigns') ? 'active' : '' }}">
                        <a href="{{ route('admin.customer-assigns.index') }}" class="menu-link">
                            <div data-i18n="Analytics"> All Services </div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('admin/customer-assigns/action/suspend') ? 'active' : '' }}">
                        <a href="{{ route('admin.customer.assign.suspend') }}" class="menu-link">
                            Suspend
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('admin/customer-assigns/action/pending') ? 'active' : '' }}">
                        <a href="{{ route('admin.customer.assign.pending') }}" class="menu-link">
                            Pending
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('admin/customer-assigns/action/completed') ? 'active' : '' }}">
                        <a href="{{ route('admin.customer.assign.completed') }}" class="menu-link">
                            <div data-i18n="eCommerce"> Completed </div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('admin/customer-assigns/action/cancel') ? 'active' : '' }}">
                        <a href="{{ route('admin.customer.assign.cancel') }}" class="menu-link">
                            Cancel
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        {{-- expense management --}}
        {{-- @can('expense_management_access')
            <li
                class="menu-item  {{ request()->is('admin/expense-categories*') ? 'active open' : '' }} {{ request()->is('admin/income-categories*') ? 'active open' : '' }} {{ request()->is('admin/expenses*') ? 'active open' : '' }} {{ request()->is('admin/incomes*') ? 'active open' : '' }} {{ request()->is('admin/expense-reports*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons fa-solid fa-money-bill-trend-up"></i>
                    <div data-i18n="Dashboards">{{ trans('cruds.expenseManagement.title') }}</div>
                </a>
                <ul class="menu-sub">
                    @can('expense_category_access')
                        <li
                            class="menu-item  {{ request()->is('admin/expense-categories') || request()->is('admin/expense-categories/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.expense-categories.index') }}" class="menu-link">
                                {{ trans('cruds.expenseCategory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('income_category_access')
                        <li
                            class="menu-item {{ request()->is('admin/income-categories') || request()->is('admin/income-categories/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.income-categories.index') }}" class="menu-link">
                                {{ trans('cruds.incomeCategory.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('expense_access')
                        <li
                            class="menu-item {{ request()->is('admin/expenses') || request()->is('admin/expenses/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.expenses.index') }}" class="menu-link">
                                {{ trans('cruds.expense.title') }}
                            </a>
                        </li>
                    @endcan

                    @can('income_access')
                        <li
                            class="menu-item  {{ request()->is('admin/incomes') || request()->is('admin/incomes/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.incomes.index') }}" class="menu-link">
                                <div data-i18n="Analytics"> {{ trans('cruds.income.title') }} </div>
                            </a>
                        </li>
                    @endcan
                    @can('expense_report_access')
                        <li
                            class="menu-item {{ request()->is('admin/expense-reports') || request()->is('admin/expense-reports/*') ? 'active' : '' }}">
                            <a href="{{ route('admin.expense-reports.index') }}" class="menu-link">
                                <div data-i18n="eCommerce"> {{ trans('cruds.expenseReport.title') }}</div>
                            </a>
                        </li>
                    </ul>
                @endcan
            </li>
        @endcan --}}


        {{-- profile password --}}
        @if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li
                    class="menu-item  {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}">
                    <a href="{{ route('profile.password.edit') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-key"></i>
                        <div> {{ trans('global.change_password') }}</div>
                    </a>
                </li>
            @endcan
        @endif

        {{-- logout --}}
        <li class="menu-item d-none">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();"
                class="menu-link">
                <i class="menu-icon tf-icons bx bx-key"></i>
                <div> {{ trans('global.logout') }}</div>
            </a>
        </li>

    </ul>
</aside>
