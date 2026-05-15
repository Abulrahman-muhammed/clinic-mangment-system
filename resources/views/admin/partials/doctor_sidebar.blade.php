 <style>
    /* تثبيت اللون الأزرق والخلفية عند النشاط (Active) بدون هوفر */
    .vertnav .navbar-nav .nav-link.active {
        color: #1b68ff !important;
        background-color: rgba(27, 104, 255, 0.1) !important;
        font-weight: bold;
    }

    /* تلوين الأيقونة عند النشاط */
    .vertnav .navbar-nav .nav-link.active i {
        color: #1b68ff !important;
    }

    /* Parent dropdown active when child is active */
    .vertnav .navbar-nav .dropdown-toggle.active {
        color: #1b68ff !important;
        background-color: rgba(27, 104, 255, 0.1) !important;
    }

    /* Prevent hover from overriding active state */
    .vertnav .navbar-nav .nav-link.active:hover {
        color: #1b68ff !important;
        background-color: rgba(27, 104, 255, 0.1) !important;
    }

    /* تنسيق الروابط الداخلية النشطة داخل القوائم المنسدلة */
    .collapse.show .nav-link.active {
        color: #1b68ff !important;
        background-color: transparent !important;
        border-left: 3px solid #1b68ff;
    }
</style>
<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>

    <nav class="vertnav navbar navbar-light">
        <!-- Logo -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ url('/admin/doctor/dashboard') }}">
                <svg version="1.1" id="logo" class="navbar-brand-img brand-sm" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 120 120" xml:space="preserve">
                    <g>
                        <polygon class="st0" points="78,105 15,105 24,87 87,87" />
                        <polygon class="st0" points="96,69 33,69 42,51 105,51" />
                        <polygon class="st0" points="78,33 15,33 24,15 87,15" />
                    </g>
                </svg>
            </a>
        </div>

        <!-- Dashboard -->
        @can('view_dashboard')
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span>
                </a>
            </li>
        </ul>
        @endcan

        <!-- Clinic Management -->
        <p class="text-muted nav-heading mt-4 mb-1"><span>Clinic Management</span></p>

        <!-- Doctor Schedules -->
        @can('view_schedules')
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
                <a href="{{ route('admin.doctor.mySchedule') }}" class="nav-link {{ request()->is('admin/schedule*') ? 'active' : '' }}">
                    <i class="fe fe-clock fe-16"></i>
                    <span class="ml-3 item-text">My Schedules</span>
                </a>
            </li>
        </ul>
        @endcan

        <p class="text-muted nav-heading mt-4 mb-1"><span>Patients & Services</span></p>

        <!-- Patients -->
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
                <a href="{{ route('admin.doctor.myPatients') }}" class="nav-link {{ request()->is('admin/patient*') ? 'active' : '' }}">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">My Patients</span>
                </a>
            </li>
        </ul>
            
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
                <a href="{{ route('admin.doctor.myVisits') }}" class="nav-link {{ request()->is('admin/doctor/myVisits*') ? 'active' : '' }}">
                    <i class="fe fe-calendar fe-16"></i>
                    <span class="ml-3 item-text">My Visits</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item">
                <a href="{{ route('admin.doctor.myBookings') }}" class="nav-link {{ request()->is('admin/doctor/myBookings*') ? 'active' : '' }}">
                    <i class="fe fe-calendar fe-16"></i>
                    <span class="ml-3 item-text">My Appointments</span>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->is('admin/service*') ? 'active' : '' }}" href="{{ url('/admin/service') }}">
                    <i class="fe fe-briefcase fe-16"></i>
                    <span class="ml-3 item-text">Services</span>
                </a>
            </li>
        </ul>


        <p class="text-muted nav-heading mt-4 mb-1"><span>Finance</span></p>

        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a href="{{ route('admin.doctor.myInvoices') }}" class="nav-link {{ request()->is('admin/doctor/myInvoices*') ? 'active' : '' }}">
                    <i class="fe fe-file-text fe-16"></i>
                    <span class="ml-3 item-text">My Invoices</span>
                </a>
            </li>
        </ul>

    </nav>
</aside>