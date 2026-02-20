<header class="main-header navbar navbar-expand-lg">
    <div class="custom-container container-fluid">
        <a class="navbar-brand logo" href="{{ route('front.home') }}">
            {{ config('app.name') }}
        </a>

        <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#mainNavbar">
            <span class="fa-solid fa-bars-staggered" style="color: #00a8e8; font-size: 24px"></span>
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

            <div class="header-icons d-flex align-items-center gap-3">
                @auth
                    <div class="user-profile-info d-flex align-items-center me-1">
                        <div class="user-avatar-mini me-2 d-none d-sm-flex">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="d-flex flex-column">
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

@push('style')
<style>
    /* User Profile Styling */
    .user-profile-info {
        line-height: 1.2;
    }
    
    .welcome-text {
        font-size: 0.75rem;
        color: #6c757d;
        display: block;
    }

    .user-name {
        font-size: 0.9rem;
        color: #00a8e8;
    }

    .user-avatar-mini {
        width: 32px;
        height: 32px;
        background-color: rgba(0, 168, 232, 0.1);
        color: #00a8e8;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        border: 1px solid rgba(0, 168, 232, 0.2);
    }

    /* Buttons Styling */
    .nav-icon-btn {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        border: 1.5px solid rgba(0, 168, 232, 0.2);
        background: #fff;
        color: #00a8e8;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .nav-icon-btn:hover {
        background: #00a8e8;
        border-color: #00a8e8;
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 168, 232, 0.3);
    }

    .nav-icon-btn--filled {
        background: linear-gradient(135deg, #00a8e8, #0077b6);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 4px 12px rgba(0, 120, 182, 0.2);
    }

    .nav-icon-btn--filled:hover {
        background: linear-gradient(135deg, #0077b6, #005f99);
        color: #fff;
    }

    .nav-icon-btn--logout:hover {
        background: #dc3545;
        border-color: #dc3545;
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    }

    /* Responsive Adjustments */
    @media (max-width: 991.98px) {
        .header-icons {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
            justify-content: space-between;
        }
    }
</style>
@endpush