<nav class="main-header navbar navbar-expand border-bottom navbar-dark bg-primary bg-gradient-blue">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell fa-2x"></i>
                @if (auth()->user()->unreadNotifications->count() > 0)
                    <span class="badge badge-warning navbar-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @if (auth()->user()->unreadNotifications->count() > 0)
                    <span class="dropdown-header">{{ auth()->user()->unreadNotifications->count() }} Notifications</span>
                    <div class="dropdown-divider"></div>
                @endif


                @forelse (auth()->user()->unreadNotifications as $notification)
                <a href="{{ $notification->data['action'] }}" class="dropdown-item">
                    {{ str_limit($notification->data['title'], 20) }}
                    <span class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                </a>
                <div class="dropdown-divider"></div>
                @empty
                <span class="dropdown-header">All caught up!</span>
                @endforelse

                <a href="{{ route('notifications.index') }}" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <!-- profile Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-user-circle fa-2x"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-header">{{ Auth::user()->name }}</span>
                <div class="dropdown-divider"></div>
                <a href="{{ route('users.profile') }}" class="dropdown-item">
                    <i class="fa fa-user mr-2"></i> Profile
                </a>
                <a href="{{ route('users.password.change') }}" class="dropdown-item">
                    <i class="fa fa-key mr-2"></i> Change Password
                </a>
                @role('admin')
                    @if (Auth::user()->hasPermissionTo('settings.index'))
                        <a  href="{{ route('settings.index') }}" class="dropdown-item">
                            <i class="fas fa-cog mr-2"></i> Settings
                        </a>
                    @endif
                @endrole
                <div class="dropdown-divider"></div>
                <a onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" href="{{ route('logout') }}" class="dropdown-item">
                    <i class="fa fa-lock mr-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
