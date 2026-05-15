<header class="main-header navbar navbar-expand-lg">
    <div class="custom-container container-fluid">
        <a class="navbar-brand logo" href="{{ route('front.home') }}">
            Care<span>Point</span>
        </a>

        <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#mainNavbar">
            <span class="fa-solid fa-bars-staggered" style="color: var(--blue); font-size: 24px"></span>
        </button>

        <nav class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a href="{{ route('front.home') }}" class="nav-link @if(request()->routeIs('front.home')) active @endif">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('front.home') }}#features" class="nav-link">Features</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('front.majors') }}" class="nav-link @if(request()->routeIs('front.majors')) active @endif">Specialties</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('front.services.index') }}" class="nav-link @if(request()->routeIs('front.services.index')) active @endif">Services</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('front.doctors') }}" class="nav-link @if(request()->routeIs('front.doctors')) active @endif">Doctors</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('front.about') }}" class="nav-link @if(request()->routeIs('front.about')) active @endif">About Us</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('front.contact') }}" class="nav-link @if(request()->routeIs('front.contact')) active @endif">Contact Us</a>
                </li>
            </ul>

            <div class="header-icons d-flex align-items-center gap-2">
                @auth
                    @php
                        $unreadCount   = auth()->user()->unreadNotifications->count();
                        $notifications = auth()->user()->notifications->take(4);
                    @endphp

                    {{-- Bell --}}
                    <div class="notif-wrapper dropdown">
                        <button class="nav-icon-btn notif-btn"
                                type="button"
                                id="notifDropdown"
                                data-bs-toggle="dropdown"
                                data-bs-auto-close="outside"
                                aria-expanded="false">
                            <i class="fa-solid fa-bell"></i>
                            @if($unreadCount > 0)
                                <span class="notif-badge">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                            @endif
                        </button>

                        <div class="notif-dropdown dropdown-menu dropdown-menu-end p-0"
                             aria-labelledby="notifDropdown">

                            <div class="notif-inner">

                                {{-- Header --}}
                                <div class="notif-head">
                                    <div class="notif-head-left">
                                        <div class="notif-head-icon">
                                            <i class="fa-solid fa-bell"></i>
                                        </div>
                                        <span class="notif-title">Notifications</span>
                                        @if($unreadCount > 0)
                                            <span class="notif-count-pill">{{ $unreadCount }}</span>
                                        @endif
                                    </div>
                                    @if($unreadCount > 0)
                                    <form action="{{ route('front.notifications.markAllRead') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="notif-mark-read">
                                            Mark all read
                                        </button>
                                    </form>
                                    @endif
                                </div>

                                {{-- List --}}
                                <div class="notif-list">
                                    @forelse($notifications as $notification)
                                        @php
                                            $status   = $notification->data['status']  ?? 'pending';
                                            $message  = $notification->data['message'] ?? 'Your appointment has been updated.';
                                            $isUnread = is_null($notification->read_at);

                                            $iconMap = [
                                                'confirmed' => ['fa-circle-check',   '#16a34a', '#dcfce7'],
                                                'cancelled' => ['fa-circle-xmark',   '#dc2626', '#fee2e2'],
                                                'completed' => ['fa-flag-checkered', '#006aff', '#eff4ff'],
                                                'pending'   => ['fa-clock',          '#d97706', '#fef3c7'],
                                            ];
                                            [$ico, $clr, $bg] = $iconMap[$status] ?? ['fa-calendar-check', '#006aff', '#eff4ff'];
                                        @endphp

<form action="{{ route('front.notifications.markAsRead', $notification->id) }}" method="POST">
    @csrf
    <button type="submit" class="notif-item {{ $isUnread ? 'notif-unread' : '' }}">
        
        <div class="notif-ico-wrap" style="background:{{ $bg }};">
            <i class="fa-solid {{ $ico }}" style="color:{{ $clr }};font-size:17px;"></i>
        </div>

        <div class="notif-body">
            <p class="notif-text">{{ $message }}</p>
            <span class="notif-time">
                {{ $notification->created_at->diffForHumans() }}
            </span>
        </div>

        @if($isUnread)
            <span class="notif-dot"></span>
        @endif

    </button>
</form>
                                    @empty
                                        <div class="notif-empty">
                                            <i class="fa-solid fa-bell-slash notif-empty-ico"></i>
                                            <p>No notifications yet</p>
                                        </div>
                                    @endforelse
                                </div>

                                {{-- Footer --}}
                                @if($notifications->count() > 0)
                                    <div class="notif-foot">
                                        <a href="{{ route('front.notifications.index') }}" class="notif-view-all">
                                            View all notifications
                                        </a>
                                    </div>
                                @endif

                            </div>{{-- end .notif-inner --}}
                        </div>{{-- end .notif-dropdown --}}
                    </div>{{-- end .notif-wrapper --}}

                    {{-- My Bookings --}}
                    <a href="{{ route('front.profile.my-appointments') }}" class="nav-icon-btn me-1" title="My Bookings">
                        <i class="fa-solid fa-calendar-check"></i>
                    </a>

                    {{--  User Info --}}
                    <div class="user-profile-info d-flex align-items-center me-1">
                        <div class="user-avatar-mini me-2 d-none d-sm-flex">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="d-flex flex-column text-start">
                            <span class="welcome-text">Welcome,</span>
                            <span class="user-name fw-bold">{{ Auth::user()->name }}</span>
                        </div>
                    </div>

                    {{--  Logout --}}
                    <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                        @csrf
                        <button type="submit" class="nav-icon-btn nav-icon-btn--logout" title="Logout">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>

                @else
                    <a href="{{ route('register') }}" class="nav-icon-btn" title="Register">
                        <i class="fa-solid fa-user-plus"></i>
                    </a>
                    <a href="{{ route('login') }}" class="nav-icon-btn nav-icon-btn--filled" title="Sign In">
                        <i class="fa-solid fa-right-to-bracket"></i>
                    </a>
                @endauth
            </div>
        </nav>
    </div>
</header>

    