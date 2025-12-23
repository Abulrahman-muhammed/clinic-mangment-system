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
                    <a class="nav-link" href="{{ url('/admin') }}">
                        <i class="fe fe-home fe-16"></i>
                        <span class="ml-3 item-text">Dashboard</span>
                    </a>
                </li>
            </ul>
        @endcan

        <!-- ==================== CLINIC MANAGEMENT ==================== -->
        @canany(['view_doctors', 'view_departments', 'view_schedules'])
            <p class="text-muted nav-heading mt-4 mb-1"><span>Clinic Management</span></p>
        @endcanany

        <!-- Doctors -->
        @can('view_doctors')
            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#doctors" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        <i class="fe fe-user fe-16"></i>
                        <span class="ml-3 item-text">Doctors</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="doctors">
                        <li><a class="nav-link pl-3" href="{{ route('admin.doctor.index') }}">List of Doctors</a></li>
                        @can('create_doctors')
                            <li><a class="nav-link pl-3" href="{{ route('admin.doctor.create') }}">Add Doctor</a></li>
                        @endcan
                    </ul>
                </li>
            </ul>
        @endcan

        <!-- Departments -->
        @can('view_departments')
            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#departments" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        <i class="fe fe-layers fe-16"></i>
                        <span class="ml-3 item-text">Departments</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="departments">
                        <li><a class="nav-link pl-3" href="{{ route('admin.major.index') }}">List of Departments</a></li>
                        @can('create_departments')
                            <li><a class="nav-link pl-3" href="{{ route('admin.major.create') }}">Add Department</a></li>
                        @endcan
                    </ul>
                </li>
            </ul>
        @endcan

        <!-- Doctor Schedules -->
        @can('view_schedules')
            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#schedules" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        <i class="fe fe-clock fe-16"></i>
                        <span class="ml-3 item-text">Doctor Schedules</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="schedules">
                        <li><a class="nav-link pl-3" href="{{ route('admin.schedule.index') }}">List of Schedules</a></li>
                        @can('create_schedules')
                            <li><a class="nav-link pl-3" href="{{ route('admin.schedule.create') }}">Add Schedule</a></li>
                        @endcan
                    </ul>
                </li>
            </ul>
        @endcan

        <!-- ==================== PATIENTS & SERVICES ==================== -->
        @canany(['view_patients', 'view_appointments', 'view_services'])
            <p class="text-muted nav-heading mt-4 mb-1"><span>Patients & Services</span></p>
        @endcanany

        <!-- Patients -->
        @can('view_patients')
            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#patients" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        <i class="fe fe-users fe-16"></i>
                        <span class="ml-3 item-text">Patients</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="patients">
                        <li><a class="nav-link pl-3" href="{{ route('admin.patient.index') }}">List of Patients</a></li>
                        @can('create_patients')
                            <li><a class="nav-link pl-3" href="{{ route('admin.patient.create') }}">Add Patient</a></li>
                        @endcan
                    </ul>
                </li>
            </ul>
        @endcan
        <!-- Appointments -->
        @can('view_appointments')
            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#appointments" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        <i class="fe fe-calendar fe-16"></i>
                        <span class="ml-3 item-text">Appointments</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="appointments">
                        <li><a class="nav-link pl-3" href="{{ route('admin.booking.index') }}">List of Appointments</a>
                        </li>
                    </ul>
                </li>
            </ul>
        @endcan
        <!-- Services -->
        @can('view_services')
            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#services" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        <i class="fe fe-briefcase fe-16"></i>
                        <span class="ml-3 item-text">Services</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="services">
                        <li><a class="nav-link pl-3" href="{{ route('admin.service.index') }}">List of Services</a></li>
                        @can('create_services')
                            <li><a class="nav-link pl-3" href="{{ route('admin.service.create') }}">Add Service</a></li>
                        @endcan
                    </ul>
                </li>
            </ul>
        @endcan
        <!-- ==================== FINANCE ==================== -->
        @canany(['create_invoices', 'view_invoices'])
            <p class="text-muted nav-heading mt-4 mb-1"><span>Finance</span></p>
        @endcanany
        @can('view_invoices')
            <!-- Invoices -->
            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#invoices" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        <i class="fe fe-file-text fe-16"></i>
                        <span class="ml-3 item-text">Invoices</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="invoices">
                        <li><a class="nav-link pl-3" href="{{ route('admin.invoice.index') }}">List of Invoices</a></li>
                        @can('create_invoices')
                            <li><a class="nav-link pl-3" href="{{ route('admin.invoice.create') }}">Add Invoice</a></li>
                        @endcan
                    </ul>
                </li>
            </ul>
        @endcan
        <!-- Receptionists -->
        @can('view_receptionists')
            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#receptionists" data-toggle="collapse" aria-expanded="false"
                        class="dropdown-toggle nav-link">
                        <i class="fe fe-user-check fe-16"></i>
                        <span class="ml-3 item-text">Receptionists</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="receptionists">
                        <li><a class="nav-link pl-3" href="{{ route('admin.receptionist.index') }}">List of
                                Receptionists</a></li>
                        @can('create_receptionists')
                            <li><a class="nav-link pl-3" href="{{ route('admin.receptionist.create') }}">Add Receptionist</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            </ul>
        @endcan
        <!-- ==================== ADMINISTRATION ==================== -->
        {{-- if user has view user permission or view admin permission, show this --}}
        @canany(['view_users', 'view_roles', 'view_contacts', 'view_settings'])
            <p class="text-muted nav-heading mt-4 mb-1"><span>Administration</span></p>
        @endcanany

        @can('view_users')
            <!-- Users -->
            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#users" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        <i class="fe fe-users fe-16"></i>
                        <span class="ml-3 item-text">Users</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="users">
                        <li><a class="nav-link pl-3" href="{{ route('admin.user.index') }}">List of Users</a></li>
                        <li><a class="nav-link pl-3" href="{{ route('admin.user.create') }}">Add User</a></li>
                    </ul>
                </li>
            </ul>
        @endcan
        <!-- Roles -->
        @can('view_roles')
            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                    <a href="#roles" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                        <i class="fe fe-user-check fe-16"></i>
                        <span class="ml-3 item-text">Roles</span>
                    </a>
                    <ul class="collapse list-unstyled pl-4 w-100" id="roles">
                        <li><a class="nav-link pl-3" href="{{ route('admin.role.index') }}">List of Roles</a></li>
                        <li><a class="nav-link pl-3" href="{{ route('admin.role.create') }}">Add Role</a></li>
                    </ul>
                </li>
            </ul>
        @endcan
        <!-- Contacts -->
        @can('view_contacts')
            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.contact.index') }}">
                        <i class="fe fe-phone fe-16"></i>
                        <span class="ml-3 item-text">Contacts</span>
                    </a>
                </li>
            </ul>
        @endcan

        <!-- Settings -->
        @can('view_settings')
            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.settings.edit', 1) }}">
                        <i class="fe fe-settings fe-16"></i>
                        <span class="ml-3 item-text">Settings</span>
                    </a>
                </li>
            </ul>
        @endcan
    </nav>
</aside>
