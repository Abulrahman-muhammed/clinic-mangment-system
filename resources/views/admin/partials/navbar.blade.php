@php
    $unreadCount         = auth()->user()->unreadNotifications->count();
    $recentNotifications = auth()->user()->notifications()->latest()->take(8)->get();
@endphp

<nav class="topnav navbar navbar-light">
    <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
        <i class="fe fe-menu navbar-toggler-icon"></i>
    </button>

    <ul class="nav">

        {{-- Dark/Light mode --}}
        <li class="nav-item">
            <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="light">
                <i class="fe fe-sun fe-16"></i>
            </a>
        </li>

        {{-- 🔔 Notification Bell --}}
        <li class="nav-item dropdown">
            <a class="nav-link text-muted my-2 position-relative"
               href="#"
               id="notifDropdown"
               role="button"
               data-toggle="dropdown"
               aria-haspopup="true"
               aria-expanded="false">

                {{-- ✅ مهم --}}
                <i class="fe fe-bell fe-16" id="notif-bell-icon"></i>

                @if($unreadCount > 0)
                    {{-- ✅ مهم --}}
                    <span id="notif-badge"
                          class="badge badge-danger badge-pill position-absolute"
                          style="top:2px;right:2px;font-size:.55rem;min-width:15px;height:15px;line-height:15px;padding:0 3px;">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                @endif
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow-lg border-0 p-0"
                 aria-labelledby="notifDropdown"
                 style="width:360px;max-height:500px;overflow:hidden;">

                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom bg-light">
                    <strong class="text-dark small">
                        Notifications
                        @if($unreadCount > 0)
                            <span class="badge badge-primary ml-1">{{ $unreadCount }}</span>
                        @endif
                    </strong>

                    <div>
                        @if($unreadCount > 0)
                            <form action="{{ route('admin.notifications.markAllRead') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-link btn-sm text-primary p-0 mr-2" style="font-size:.75rem;">
                                    Mark all read
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('admin.notifications.index') }}"
                           class="btn btn-link btn-sm text-muted p-0"
                           style="font-size:.75rem;">
                            View all
                        </a>
                    </div>
                </div>

                {{-- List --}}
                {{-- ✅ مهم --}}
                <div id="notif-list" style="max-height:380px;overflow-y:auto;">
                    @forelse($recentNotifications as $notification)
                        @php
                            $data   = $notification->data;
                            $isRead = ! is_null($notification->read_at);
                            $color  = $data['color'] ?? 'primary';
                            $icon   = $data['icon']  ?? 'fe-bell';
                        @endphp

                        <div class="d-flex align-items-start px-3 py-2 border-bottom {{ $isRead ? '' : 'bg-soft-primary' }} notif-item">
                            
                            <div class="mr-2 mt-1">
                                <span class="fe {{ $icon }} text-{{ $color }}" style="font-size:1rem;"></span>
                            </div>

                            <div class="flex-grow-1" style="min-width:0;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <strong class="small text-dark">
                                        <a href="{{ $data['url'] ?? '#' }}"
                                           class="text-dark"
                                           style="text-decoration:underline;">
                                            {{ $data['title'] ?? 'No Title' }}
                                        </a>
                                    </strong>

                                    @if(! $isRead)
                                        <span class="badge badge-{{ $color }} ml-1" style="font-size:.5rem;">New</span>
                                    @endif
                                </div>

                                <p class="small text-muted mb-0 text-truncate" style="font-size:.75rem;">
                                    {{ $data['message'] ?? '' }}
                                </p>

                                <small class="text-muted" style="font-size:.7rem;">
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>

                            <div class="ml-2 d-flex flex-column align-items-end" style="gap:2px;">
                                @if(! $isRead)
                                    <a href="{{ route('admin.notifications.read', $notification->id) }}"
                                       class="btn btn-link btn-sm p-0 text-primary"
                                       style="font-size:.65rem;"
                                       title="Mark as read">
                                        <i class="fe fe-check"></i>
                                    </a>
                                @endif

                                <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-link btn-sm p-0 text-danger"
                                            style="font-size:.65rem;"
                                            title="Remove">
                                        <i class="fe fe-x"></i>
                                    </button>
                                </form>
                            </div>

                        </div>

                    @empty
                        <div class="text-center py-4 notif-empty">
                            <i class="fe fe-bell-off fe-20 text-muted"></i>
                            <p class="text-muted small mt-2 mb-0">No notifications yet</p>
                        </div>
                    @endforelse
                </div>

                {{-- Footer --}}
                @if($recentNotifications->count() > 0)
                <div class="text-center py-2 border-top bg-light">
                    <form action="{{ route('admin.notifications.clearAll') }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-link btn-sm text-danger p-0" style="font-size:.75rem;">
                            <i class="fe fe-trash-2 mr-1"></i>Clear all
                        </button>
                    </form>
                </div>
                @endif

            </div>
        </li>

        {{-- Avatar Dropdown --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-muted pr-0"
               href="#"
               id="navbarDropdownMenuLink"
               role="button"
               data-toggle="dropdown"
               aria-haspopup="true"
               aria-expanded="false">

                <span class="avatar avatar-sm mt-2">

                    @role('admin')
                        <img src="{{ asset('admin-assets') }}/assets/avatars/face-1.jpg"
                             class="avatar-img rounded-circle">
                    @endrole

                    @role('doctor')
                        @php
                            $doctor = App\Models\Doctor::where('user_id', auth()->id())->first();
                        @endphp

                        <img src="{{ $doctor?->image
                            ? asset('images/doctors/'.$doctor->image)
                            : asset('admin-assets/assets/avatars/face-1.jpg') }}"
                             class="avatar-img rounded-circle">
                    @endrole

                    @role('receptionist')
                        @php
                            $receptionist = App\Models\Receptionist::where('user_id', auth()->id())->first();
                        @endphp

                        <img src="{{ $receptionist?->image
                            ? asset('images/receptionists/'.$receptionist->image)
                            : asset('admin-assets/assets/avatars/face-1.jpg') }}"
                             class="avatar-img rounded-circle">
                    @endrole

                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header">Hello, {{ Auth::user()->name }}</div>

                @role('admin')
                    <a class="dropdown-item" href="{{ route('admin.profile.admin') }}">My Profile</a>
                @endrole

                @role('doctor')
                    <a class="dropdown-item" href="{{ route('admin.profile.doctor') }}">My Profile</a>
                @endrole

                @role('receptionist')
                    <a class="dropdown-item" href="{{ route('admin.profile.receptionist') }}">My Profile</a>
                @endrole

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="dropdown-item text-danger"
                       href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();">
                        Logout
                    </a>
                </form>
            </div>
        </li>

    </ul>
</nav>