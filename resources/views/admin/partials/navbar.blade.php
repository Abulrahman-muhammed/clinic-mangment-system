      <nav class="topnav navbar navbar-light">
        <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
          <i class="fe fe-menu navbar-toggler-icon"></i>
        </button>
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="light">
              <i class="fe fe-sun fe-16"></i>
            </a>
          </li>
          <li class="nav-item nav-notif">
            <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-notif">
              <span class="fe fe-bell fe-16"></span>
              <span class="dot dot-md bg-success"></span>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="avatar avatar-sm mt-2">
                @role('admin')
                <img src="{{asset('admin-assets')}}/assets/avatars/face-1.jpg" alt="..." class="avatar-img rounded-circle">
                @endrole
                @role('doctor')
                @php
                  $user = Auth::user();
                  $doctor = App\Models\Doctor::where('user_id', $user->id)->first();
                @endphp
                @if($doctor->image)
                <img src="{{asset('images/doctors')}}/{{ $doctor->image }}" alt="..." class="avatar-img rounded-circle">
                @else
                <img src="{{asset('admin-assets')}}/assets/avatars/face-1.jpg" alt="..." class="avatar-img rounded-circle">
                @endif
                @endrole
                @role('receptionist')
                @php
                  $user = Auth::user();
                  $receptionist = App\Models\Receptionist::where('user_id', $user->id)->first();  
                @endphp
                @if($receptionist->image)
                <img src="{{asset('images/receptionists')}}/{{ $receptionist->image }}" alt="..." class="avatar-img rounded-circle">
                @else
                <img src="{{asset('admin-assets')}}/assets/avatars/face-1.jpg" alt="..." class="avatar-img rounded-circle">
                @endif
                @endrole
              </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <div class="dropdown-header">Hello, {{ Auth::user()->name }}</div>
              {{-- SPATIE ROLES --}}
              @role('admin')
                <a class="dropdown-item" href="{{ route('admin.profile.admin') }}">My Profile</a>
              @endrole
              @role('doctor')
                <a class="dropdown-item" href="{{ route('admin.profile.doctor') }}">My Profile</a>
              @endrole
              @role('receptionist')
                <a class="dropdown-item" href="{{ route('admin.profile.receptionist') }}">My Profile</a>
              @endrole
              <!-- logout -->
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="dropdown-item text-danger" href="{{ route('logout') }}" 
                onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
              </form>
            </div>
          </li>
        </ul>
      </nav>
