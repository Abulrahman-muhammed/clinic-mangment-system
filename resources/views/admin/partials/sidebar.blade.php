<style>
    .vertnav .navbar-nav .nav-link.active {
        color: #1b68ff !important;
        background-color: rgba(27, 104, 255, 0.1) !important;
        font-weight: bold;
    }

    .vertnav .navbar-nav .nav-link.active i {
        color: #1b68ff !important;
    }

    .vertnav .navbar-nav .nav-link.active:hover {
        color: #1b68ff !important;
        background-color: rgba(27, 104, 255, 0.1) !important;
    }
</style>

<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>

    <nav class="vertnav navbar navbar-light">
        <!-- Logo -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ url('/admin') }}">
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
                <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="{{ url('/admin') }}">
                    <i class="fe fe-home fe-16"></i>
                    <span class="ml-3 item-text">Dashboard</span>
                </a>
            </li>
        </ul>
        @endcan

        <!-- Clinic Management -->
        @canany(['view_doctors', 'view_departments', 'view_schedules'])
            <p class="text-muted nav-heading mt-4 mb-1"><span>Clinic Management</span></p>
        @endcanany

        @can('view_doctors')
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->is('admin/doctor*') ? 'active' : '' }}" href="{{ route('admin.doctor.index') }}">
                    <i class="fe fe-user fe-16"></i>
                    <span class="ml-3 item-text">Doctors</span>
                </a>
            </li>
        </ul>
        @endcan

        @can('view_departments')
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->is('admin/major*') ? 'active' : '' }}" href="{{ route('admin.major.index') }}">
                    <i class="fe fe-layers fe-16"></i>
                    <span class="ml-3 item-text">Departments</span>
                </a>
            </li>
        </ul>
        @endcan

        @can('view_schedules')
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->is('admin/schedule*') ? 'active' : '' }}" href="{{ route('admin.schedule.index') }}">
                    <i class="fe fe-clock fe-16"></i>
                    <span class="ml-3 item-text">Doctor Schedules</span>
                </a>
            </li>
        </ul>
        @endcan

        <!-- Patients & Services -->
        @canany(['view_patients', 'view_appointments', 'view_services'])
            <p class="text-muted nav-heading mt-4 mb-1"><span>Patients & Services</span></p>
        @endcanany

        @can('view_patients')
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->is('admin/patient*') ? 'active' : '' }}" href="{{ route('admin.patient.index') }}">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">Patients</span>
                </a>
            </li>
        </ul>
        @endcan

        @can('view_patients')
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->is('admin/visit*') ? 'active' : '' }}" href="{{ route('admin.visit.index') }}">
                    <i class="fe fe-activity fe-16"></i>
                    <span class="ml-3 item-text">Visits</span>
                </a>
            </li>
        </ul>
        @endcan


        @can('view_appointments')
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->is('admin/booking*') ? 'active' : '' }}" href="{{ route('admin.booking.index') }}">
                    <i class="fe fe-calendar fe-16"></i>
                    <span class="ml-3 item-text">Appointments</span>
                </a>
            </li>
        </ul>
        @endcan

        @can('view_services')
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->is('admin/service*') ? 'active' : '' }}" href="{{ route('admin.service.index') }}">
                    <i class="fe fe-briefcase fe-16"></i>
                    <span class="ml-3 item-text">Services</span>
                </a>
            </li>
        </ul>
        @endcan

        <!-- Finance -->
        @canany(['create_invoices', 'view_invoices'])
            <p class="text-muted nav-heading mt-4 mb-1"><span>Finance</span></p>
        @endcanany

        @can('view_invoices')
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->is('admin/invoice*') ? 'active' : '' }}" href="{{ route('admin.invoice.index') }}">
                    <i class="fe fe-file-text fe-16"></i>
                    <span class="ml-3 item-text">Invoices</span>
                </a>
            </li>
        </ul>
        @endcan

        <!-- Administration -->
        @canany(['view_users', 'view_roles', 'view_contacts', 'view_settings', 'view_receptionists'])
            <p class="text-muted nav-heading mt-4 mb-1"><span>Administration</span></p>
        @endcanany

        @can('view_receptionists')
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->is('admin/receptionist*') ? 'active' : '' }}" href="{{ route('admin.receptionist.index') }}">
                    <i class="fe fe-user-check fe-16"></i>
                    <span class="ml-3 item-text">Receptionists</span>
                </a>
            </li>
        </ul>
        @endcan

        @can('view_users')
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}" href="{{ route('admin.user.index') }}">
                    <i class="fe fe-users fe-16"></i>
                    <span class="ml-3 item-text">Users</span>
                </a>
            </li>
        </ul>
        @endcan

        @can('view_roles')
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->is('admin/role*') ? 'active' : '' }}" href="{{ route('admin.role.index') }}">
                    <i class="fe fe-shield fe-16"></i>
                    <span class="ml-3 item-text">Roles</span>
                </a>
            </li>
        </ul>
        @endcan

        @can('view_contacts')
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->is('admin/contact*') ? 'active' : '' }}" href="{{ route('admin.contact.index') }}">
                    <i class="fe fe-phone fe-16"></i>
                    <span class="ml-3 item-text">Contacts</span>
                </a>
            </li>
        </ul>
        @endcan

        @can('view_settings')
        <ul class="navbar-nav flex-fill w-100 mb-2">
            <li class="nav-item w-100">
                <a class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}" href="{{ route('admin.settings.edit', 1) }}">
                    <i class="fe fe-settings fe-16"></i>
                    <span class="ml-3 item-text">Settings</span>
                </a>
            </li>
        </ul>
        @endcan

    </nav>
</aside>