@include('admin.layouts.topbar')
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="./index.html" class="brand-link">
            <img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">Doctor App</span> </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open"> <a href="{{ route('admin.dashboard') }}" class="nav-link active"> <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if(hasAnyPermissionOnResource('doctor'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>Doctor<i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('doctor.list')
                        <li class="nav-item">
                            <a href="{{ route('doctor.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Doctor List</p>
                            </a>
                        </li>
                        @endcan
                        @can('doctor.create')
                        <li class="nav-item">
                            <a href="{{ route('doctor.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New Doctor</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @if(hasAnyPermissionOnResource('hospital'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-building"></i>
                        <p>Hospital <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('hospital.view')
                        <li class="nav-item">
                            <a href="{{ route('hospital.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Hospital List</p>
                            </a>
                        </li>
                        @endcan
                        @can('hospital.create')
                        <li class="nav-item">
                            <a href="{{ route('hospital.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New Hospital</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                {{-- Patient --}}
                @if(hasAnyPermissionOnResource('patient'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>Patient <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('patient.view')
                        <li class="nav-item">
                            <a href="{{ route('patient.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Patient List</p>
                            </a>
                        </li>
                        @endcan
                        @can('patient.create')
                        <li class="nav-item">
                            <a href="{{ route('patient.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New Patient</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                {{-- Specialty --}}
                @if(hasAnyPermissionOnResource('speciality'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-stars"></i>
                        <p>Specialty <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('speciality.view')
                        <li class="nav-item">
                            <a href="{{ route('speciality.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Specialty List</p>
                            </a>
                        </li>
                        @endcan
                        @can('speciality.create')
                        <li class="nav-item">
                            <a href="{{ route('speciality.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New Specialty</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                {{-- Appointment --}}
                @if(hasAnyPermissionOnResource('appointment'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-calendar-check"></i>
                        <p>Appointment <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('appointment.view')
                        <li class="nav-item">
                            <a href="{{ route('appointment.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Appointment List</p>
                            </a>
                        </li>
                        @endcan
                        @can('appointment.create')
                        <li class="nav-item">
                            <a href="{{ route('appointment.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New Appointment</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                {{-- Branch --}}
                @if(hasAnyPermissionOnResource('branch'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-diagram-3"></i>
                        <p>Branch <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('branch.view')
                        <li class="nav-item">
                            <a href="{{ route('branch.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Branch List</p>
                            </a>
                        </li>
                        @endcan
                        @can('branch.create')
                        <li class="nav-item">
                            <a href="{{ route('branch.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New Branch</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                {{-- Appointment Schedule --}}
                @if(hasAnyPermissionOnResource('schedule'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-clock-history"></i>
                        <p>Appointment Schedule <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('schedule.view')
                        <li class="nav-item">
                            <a href="{{ route('schedule.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Schedule List</p>
                            </a>
                        </li>
                        @endcan
                        @can('schedule.create')
                        <li class="nav-item">
                            <a href="{{ route('schedule.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New Schedule</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                {{-- Blog --}}
                @if(hasAnyPermissionOnResource('blog'))
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-journal-text"></i>
                        <p>Blog <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('blog.view')
                        <li class="nav-item">
                            <a href="{{ route('blog.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Blog List</p>
                            </a>
                        </li>
                        @endcan
                        @can('blog.create')
                        <li class="nav-item">
                            <a href="{{ route('blog.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New Blog</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                

                @role('Super Admin')
                <li class="nav-header">SETTINGS</li>
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>User<i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>User List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New User</p>
                            </a>
                        </li>

                    </ul>
                </li>

                
                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>Role<i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Role List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('roles.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New Role</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>Permission<i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('permission.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Permission List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('permission.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New Permission</p>
                            </a>
                        </li>

                    </ul>
                </li>


                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>Assign Permission<i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('roles.permissions.assign') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Assign Permission to Roles</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
            </ul>
        </nav>
    </div>
</aside>