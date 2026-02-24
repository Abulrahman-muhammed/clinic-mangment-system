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
                    <a href="{{ route('front.home') }}" class="nav-link @if (request()->routeIs('front.home')) active @endif">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('front.home') }}#features" class="nav-link">Features</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('front.majors') }}" class="nav-link @if (request()->routeIs('front.majors')) active @endif">Specialties</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('front.services.index') }}" class="nav-link @if (request()->routeIs('front.services.index')) active @endif">Services</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('front.doctors') }}" class="nav-link @if (request()->routeIs('front.doctors')) active @endif">Doctors</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('front.about') }}" class="nav-link @if (request()->routeIs('front.about')) active @endif">About Us</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('front.contact') }}" class="nav-link @if (request()->routeIs('front.contact')) active @endif">Contact Us</a>
                </li>
            </ul>

            <div class="header-icons d-flex align-items-center gap-2">
                @auth
                    <a href="{{ route('front.profile.my-appointments') }}" class="nav-icon-btn me-1" title="My Bookings">
                        <i class="fa-solid fa-calendar-check"></i>
                    </a>

                    <div class="user-profile-info d-flex align-items-center me-1">
                        <div class="user-avatar-mini me-2 d-none d-sm-flex">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="d-flex flex-column text-start">
                            <span class="welcome-text">Welcome,</span>
                            <span class="user-name fw-bold">{{ Auth::user()->name }}</span>
                        </div>
                    </div>

                    {{-- Logout --}}
                    <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                        @csrf
                        <button type="submit" class="nav-icon-btn nav-icon-btn--logout" title="Logout">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                @else
                    {{-- Register --}}
                    <a href="{{ route('register') }}" class="nav-icon-btn" title="Register">
                        <i class="fa-solid fa-user-plus"></i>
                    </a>
                    {{-- Login --}}
                    <a href="{{ route('login') }}" class="nav-icon-btn nav-icon-btn--filled" title="Sign In">
                        <i class="fa-solid fa-right-to-bracket"></i>
                    </a>
                @endauth
            </div>
        </nav>
    </div>
</header>