<aside class="main-sidebar elevation-4 sidebar-light-primary">
    <!-- Brand Logo -->
    <a href="{{ route('welcome') }}" class="brand-link brand-link bg-primary">
        <img src="{{ Storage::disk('public')->url(settings('logo')) }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ Storage::disk('public')->url('users/'.Auth::user()->image) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('users.profile') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                @if (Auth::user()->hasPermissionTo('dashboard'))
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->hasPermissionTo('branches.index'))
                    <li class="nav-item">
                        <a href="{{ route('branches.index') }}" class="nav-link {{ Request::is('branches*') ? 'active' : '' }}">
                            <i class="fas fa-code-branch"></i>
                            <p>
                                Branches
                            </p>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->hasPermissionTo('departments.index'))
                    <li class="nav-item">
                        <a href="{{ route('departments.index') }}" class="nav-link {{ Request::is('departments*') ? 'active' : '' }}">
                            <i class="fas fa-project-diagram"></i>
                            <p>
                                Departments
                            </p>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->hasPermissionTo('designations.index'))
                    <li class="nav-item">
                        <a href="{{ route('designations.index') }}" class="nav-link {{ Request::is('designations*') ? 'active' : '' }}">
                            <i class="far fa-id-card"></i>
                            <p>
                                Designation
                            </p>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->hasPermissionTo('employees.index'))
                    <li class="nav-item">
                        <a href="{{ route('employees.index') }}" class="nav-link {{ Request::is('employees*') ? 'active' : '' }}">
                            <i class="fas fa-user-tie"></i>
                            <p>
                                Employees
                            </p>
                        </a>
                    </li>
                @endif
                {{--leave menu--}}
                @unlessrole('employee')
                    @if (Auth::user()->hasAnyPermission(['leave.types.index','leave.applications.index']))
                        <li class="nav-item has-treeview {{ Request::is('leave*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ Request::is('leave*') ? 'active' : '' }}">
                                <i class="fas fa-rocket"></i>
                                <p>
                                    Leave Menagement
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: {{ Request::is('leave*') ? 'block' : '' }};">
                                @if (Auth::user()->hasPermissionTo('leave.types.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('leave.types.index') }}" class="nav-link {{ Request::is('leave/types*') ? 'active' : '' }}">
                                            <i class="fas fa-bars"></i>
                                            <p>
                                            Leave Types
                                            </p>
                                        </a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermissionTo('leave.applications.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('leave.applications.index') }}" class="nav-link {{ Request::is('leave/applications*') ? 'active' : '' }}">
                                        <i class="fas fa-poll-h"></i>
                                            <p>
                                            Leave Applications
                                            </p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @else
                    @if (Auth::user()->hasPermissionTo('leave.applications.index'))
                        <li class="nav-item">
                            <a href="{{ route('leave.applications.index') }}" class="nav-link {{ Request::is('leave/applications*') ? 'active' : '' }}">
                            <i class="fas fa-poll-h"></i>
                                <p>
                                Leave Applications
                                </p>
                            </a>
                        </li>
                    @endif
                @endunlessrole

                @if (Auth::user()->hasPermissionTo('attendances.index'))
                    <li class="nav-item">
                        <a href="{{ route('attendances.index') }}" class="nav-link {{ Request::is('attendances*') ? 'active' : '' }}">
                            <i class="fas fa-user-check"></i>
                            <p>
                                Attendance
                            </p>
                        </a>
                    </li>
                @endif

                {{--award menu--}}
                @unlessrole('employee')
                    @if (Auth::user()->hasAnyPermission(['award.types.index','awards.index']))
                        <li class="nav-item has-treeview {{ Request::is('award*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ Request::is('award*') ? 'active' : '' }}">
                                <i class="fas fa-trophy"></i>
                                <p>
                                    Award Menagement
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: {{ Request::is('award*') ? 'block' : '' }};">
                                @if (Auth::user()->hasPermissionTo('award.types.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('award.types.index') }}" class="nav-link {{ Request::is('award/types*') ? 'active' : '' }}">
                                            <i class="fas fa-bars"></i>
                                            <p>Award Types</p>
                                        </a>
                                    </li>
                                @endif

                                @if (Auth::user()->hasPermissionTo('awards.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('awards.index') }}" class="nav-link {{ Request::is('awards*') ? 'active' : '' }}">
                                        <i class="fas fa-award"></i>
                                            <p>Awards</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @else
                    @if (Auth::user()->hasPermissionTo('awards.index'))
                        <li class="nav-item">
                            <a href="{{ route('awards.index') }}" class="nav-link {{ Request::is('award*') ? 'active' : '' }}">
                             <i class="fas fa-award"></i>
                                <p>Awards</p>
                            </a>
                        </li>
                    @endif
                @endunlessrole

                @unlessrole('employee')
                    @if (Auth::user()->hasAnyPermission(['payroll.salary.manager.index','leave.applications.index']))
                        <li class="nav-item has-treeview {{ Request::is('payroll*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ Request::is('payroll*') ? 'active' : '' }}">
                                <i class="fas fa-money-bill"></i>
                                <p>
                                    Payroll
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: {{ Request::is('leave*') ? 'block' : '' }};">
                                @if (Auth::user()->hasPermissionTo('payroll.salary.manager.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('payroll.salary.manager.index') }}" class="nav-link {{ Request::is('payroll/salary-manager*') ? 'active' : '' }}">
                                            <i class="fas fa-bars"></i>
                                            <p>Salary Manager</p>
                                        </a>
                                    </li>
                                @endif

                                @if (Auth::user()->hasPermissionTo('payroll.payslips.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('payroll.salary.increment.index') }}" class="nav-link {{ Request::is('payroll/salary-increment*') ? 'active' : '' }}">
                                        <i class="fas fa-poll-h"></i>
                                        <p>Salary Increment</p>
                                        </a>
                                    </li>
                                @endif

                                @if (Auth::user()->hasPermissionTo('payroll.payslips.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('payroll.payslips.index') }}" class="nav-link {{ Request::is('payroll/payslips*') ? 'active' : '' }}">
                                            <i class="fas fa-hand-holding-usd"></i>
                                            <p>Payslips</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @else
                    @if (Auth::user()->hasPermissionTo('payroll.salary.manager.manage'))
                        <li class="nav-item">
                            <a href="{{ route('payroll.salary.manager.manage',Auth::user()->employee->employee_code) }}" class="nav-link {{ Request::is('payroll/salary-manager*') ? 'active' : '' }}">
                                <i class="fas fa-bars"></i>
                                <p>Salary Manager</p>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->hasPermissionTo('payroll.payslips.index'))
                        <li class="nav-item">
                            <a href="{{ route('payroll.payslips.index') }}" class="nav-link {{ Request::is('payroll/payslips*') ? 'active' : '' }}">
                                <i class="fas fa-hand-holding-usd"></i>
                                <p>Payslips</p>
                            </a>
                        </li>
                    @endif
                @endunlessrole

                @if (Auth::user()->hasPermissionTo('expenses.index'))
                    <li class="nav-item">
                        <a href="{{ route('expenses.index') }}" class="nav-link {{ Request::is('expenses*') ? 'active' : '' }}">
                        <i class="far fa-credit-card"></i>
                            <p>
                                Expenses
                            </p>
                        </a>
                    </li>
                @endif

                @unlessrole('employee')
                    @if (Auth::user()->hasAnyPermission(['events.index','events.calendar']))
                        <li class="nav-item has-treeview {{ Request::is('events*','calendar') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ Request::is('events*','calendar') ? 'active' : '' }}">
                            <i class="fas fa-calendar-check"></i>
                                <p>
                                    Events and Holiday
                                    <i class="right fa fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview" style="display: {{ Request::is('events*') ? 'block' : '' }};">
                                @if (Auth::user()->hasPermissionTo('events.index'))
                                    <li class="nav-item">
                                        <a href="{{ route('events.index') }}" class="nav-link {{ Request::is('events*') ? 'active' : '' }}">
                                            <i class="fas fa-calendar-week"></i>
                                            <p>
                                            Events
                                            </p>
                                        </a>
                                    </li>
                                @endif

                                @if (Auth::user()->hasPermissionTo('events.calendar'))
                                    <li class="nav-item">
                                        <a href="{{ route('events.calendar') }}" class="nav-link {{ Request::is('calendar*') ? 'active' : '' }}">
                                        <i class="fas fa-calendar-alt"></i>
                                        <p>Calendar</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @else
                    @if (Auth::user()->hasPermissionTo('events.calendar'))
                        <li class="nav-item">
                            <a href="{{ route('events.calendar') }}" class="nav-link {{ Request::is('calendar*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt"></i>
                            <p>Events and Holiday</p>
                            </a>
                        </li>
                    @endif
                @endunlessrole
                @if (Auth::user()->hasPermissionTo('noticeboard.index'))
                    <li class="nav-item">
                        <a href="{{ route('noticeboard.index') }}" class="nav-link {{ Request::is('noticeboard*') ? 'active' : '' }}">
                        <i class="fas fa-sticky-note"></i>
                            <p>
                                Noticeboard
                            </p>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->hasAnyPermission(['permissions.index','roles.index','users.index',]))
                    <li class="nav-item has-treeview {{ Request::is('permissions*','roles*','users*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::is('permissions*','roles*','users*') ? 'active' : '' }}">
                            <i class="fas fa-fingerprint"></i>
                            <p>
                                 Access Control
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview" style="display: {{ Request::is('permissions*','roles*','users*') ? 'block' : '' }};">
                            {{-- only for devloper --}}
                            {{-- @if (Auth::user()->hasPermissionTo('permissions.index'))
                                <li class="nav-item">
                                    <a href="{{ route('permissions.index') }}" class="nav-link {{ Request::is('permissions*') ? 'active' : '' }}">
                                        <i class="fas fa-key"></i>
                                        <p>
                                            Permissions
                                        </p>
                                    </a>
                                </li>
                            @endif --}}

                            @if (Auth::user()->hasPermissionTo('roles.index'))
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link {{ Request::is('roles*') ? 'active' : '' }}">
                                        <i class="fas fa-user-lock"></i>
                                        <p>
                                            Roles
                                        </p>
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->hasPermissionTo('users.index'))
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
                                        <i class="fas fa-users"></i>
                                        <p>
                                            User
                                        </p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (Auth::user()->hasPermissionTo('settings.index'))
                    <li class="nav-item">
                        <a href="{{ route('settings.index') }}" class="nav-link {{ Request::is('settings*') ? 'active' : '' }}">
                            <i class="fas fa-cog"></i>
                            <p>
                                Settings
                            </p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
