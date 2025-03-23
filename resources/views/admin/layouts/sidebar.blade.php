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

                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>Doctor<i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('doctor.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Doctor List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('doctor.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New Doctor</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>Hospital<i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('hospital.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Hospital List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hospital.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New Hospital</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>Patient<i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('patient.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Patient List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('patient.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New Patient</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>Specialty<i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('sepeciality.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Specialty List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sepeciality.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New Specialty</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>Appointment<i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Appointment List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New Appointment</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>Branch<i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('branch.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Branch List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('branch.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New Branch</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>Appointment Schedule<i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('schedule.index') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Appointment Schedule List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('schedule.create') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New Appointment Schedule</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-box-seam-fill"></i>
                        <p>Blog<i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="nav-icon bi bi-list"></i>
                                <p>Blog List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="nav-icon bi bi-plus-circle"></i>
                                <p>New Blog</p>
                            </a>
                        </li>

                    </ul>
                </li>


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
            </ul>
        </nav>
    </div>
</aside>