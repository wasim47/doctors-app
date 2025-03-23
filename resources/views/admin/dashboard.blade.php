    @extends('admin.layouts.app')
    @section('title', 'Dashboard')
    @section('content')
    <div class="app-wrapper">
        @include('admin.layouts.sidebar')
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Dashboard</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Dashboard
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box"> <span class="info-box-icon text-bg-primary shadow-sm"> <i class="bi bi-gear-fill"></i> </span>
                                <div class="info-box-content"> <span class="info-box-text">Hospital</span> <span class="info-box-number">
                                        10
                                        <small>%</small> </span> </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box"> <span class="info-box-icon text-bg-danger shadow-sm"> <i class="bi bi-hand-thumbs-up-fill"></i> </span>
                                <div class="info-box-content"> <span class="info-box-text">Branch</span> <span class="info-box-number">41,410</span> </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box"> <span class="info-box-icon text-bg-success shadow-sm"> <i class="bi bi-cart-fill"></i> </span>
                                <div class="info-box-content"> <span class="info-box-text">Doctor</span> <span class="info-box-number">760</span> </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box"> <span class="info-box-icon text-bg-warning shadow-sm"> <i class="bi bi-people-fill"></i> </span>
                                <div class="info-box-content"> <span class="info-box-text">Doctor Speciality</span> <span class="info-box-number">2,000</span> </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box"> <span class="info-box-icon text-bg-warning shadow-sm"> <i class="bi bi-people-fill"></i> </span>
                                <div class="info-box-content"> <span class="info-box-text">Patient</span> <span class="info-box-number">2,000</span> </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box"> <span class="info-box-icon text-bg-warning shadow-sm"> <i class="bi bi-people-fill"></i> </span>
                                <div class="info-box-content"> <span class="info-box-text">Appointment</span> <span class="info-box-number">2,000</span> </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box"> <span class="info-box-icon text-bg-warning shadow-sm"> <i class="bi bi-people-fill"></i> </span>
                                <div class="info-box-content"> <span class="info-box-text">Blog</span> <span class="info-box-number">2,000</span> </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">Monthly Appointment Report</h5>
                                    <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button>
                                        <div class="btn-group"> <button type="button" class="btn btn-tool dropdown-toggle" data-bs-toggle="dropdown"> <i class="bi bi-wrench"></i> </button>
                                            <div class="dropdown-menu dropdown-menu-end" role="menu"> <a href="#" class="dropdown-item">Action</a> <a href="#" class="dropdown-item">Another action</a> <a href="#" class="dropdown-item">
                                                    Something else here
                                                </a> <a class="dropdown-divider"></a> <a href="#" class="dropdown-item">Separated link</a> </div>
                                        </div> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p class="text-center"> <strong>Sales: 1 Jan, 2023 - 30 Jul, 2023</strong> </p>
                                            <div id="sales-chart"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="text-center"> <strong>Hostipal Appointment Statistic</strong> </p>

                                            <div class="progress-group">
                                                Apollo Hospital
                                                <span class="float-end"><b>310</b>/400</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar text-bg-danger" style="width: 75%"></div>
                                                </div>
                                            </div>
                                            <div class="progress-group">
                                                Burdem Hospital
                                                <span class="float-end"><b>250</b>/500</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar text-bg-info" style="width: 50%"></div>
                                                </div>
                                            </div>
                                            <div class="progress-group"> <span class="progress-text">Islamic Bank Hospital</span> <span class="float-end"><b>480</b>/800</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar text-bg-success" style="width: 60%"></div>
                                                </div>
                                            </div>
                                            <div class="progress-group">
                                                Labaid Hospital
                                                <span class="float-end"><b>250</b>/500</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar text-bg-warning" style="width: 50%"></div>
                                                </div>
                                            </div>
                                            <div class="progress-group">
                                                United Hospital
                                                <span class="float-end"><b>160</b>/200</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar text-bg-primary" style="width: 80%"></div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-3 col-6">
                                            <div class="text-center border-end"> <span class="text-warning"> <i class="bi bi-caret-up-fill"></i> 17%
                                                </span>
                                                <h5 class="fw-bold mb-0">35,210</h5> <span class="text-uppercase">TOTAL APPOINTMENT</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="text-center border-end"> <span class="text-info"> <i class="bi bi-caret-left-fill"></i> 0%
                                                </span>
                                                <h5 class="fw-bold mb-0">10,39</h5> <span class="text-uppercase">APPOINTMENT PENDING</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="text-center border-end"> <span class="text-success"> <i class="bi bi-caret-up-fill"></i> 20%
                                                </span>
                                                <h5 class="fw-bold mb-0">24,81</h5> <span class="text-uppercase">APPOINTMENT SUCCESS</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="text-center"> <span class="text-danger"> <i class="bi bi-caret-down-fill"></i> 18%
                                                </span>
                                                <h5 class="fw-bold mb-0">1200</h5> <span class="text-uppercase">APPOINTMENT CANCELLED</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row g-4 mb-4">

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Top Doctors</h3>
                                            <div class="card-tools"> <span class="badge text-bg-danger">
                                                    8 New Doctors
                                                </span> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="row text-center m-1">
                                                <div class="col-3 p-2"> <img class="img-fluid rounded-circle" src="{{ asset('assets/img/user1-128x128.jpg') }}" alt="User Image"> <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                                        Alexander Pierce
                                                    </a>
                                                    <div class="fs-8">Today</div>
                                                </div>
                                                <div class="col-3 p-2"> <img class="img-fluid rounded-circle" src="{{ asset('assets/img/user1-128x128.jpg') }}" alt="User Image"> <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                                        Norman
                                                    </a>
                                                    <div class="fs-8">Yesterday</div>
                                                </div>
                                                <div class="col-3 p-2"> <img class="img-fluid rounded-circle" src="{{ asset('assets/img/user7-128x128.jpg') }}" alt="User Image"> <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                                        Jane
                                                    </a>
                                                    <div class="fs-8">12 Jan</div>
                                                </div>
                                                <div class="col-3 p-2"> <img class="img-fluid rounded-circle" src="{{ asset('assets/img/user6-128x128.jpg') }}" alt="User Image"> <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                                        John
                                                    </a>
                                                    <div class="fs-8">12 Jan</div>
                                                </div>
                                                <div class="col-3 p-2"> <img class="img-fluid rounded-circle" src="{{ asset('assets/img/user2-160x160.jpg') }}" alt="User Image"> <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                                        Alexander
                                                    </a>
                                                    <div class="fs-8">13 Jan</div>
                                                </div>
                                                <div class="col-3 p-2"> <img class="img-fluid rounded-circle" src="{{ asset('assets/img/user5-128x128.jpg') }}" alt="User Image"> <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                                        Sarah
                                                    </a>
                                                    <div class="fs-8">14 Jan</div>
                                                </div>
                                                <div class="col-3 p-2"> <img class="img-fluid rounded-circle" src="{{ asset('assets/img/user4-128x128.jpg') }}" alt="User Image"> <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                                        Nora
                                                    </a>
                                                    <div class="fs-8">15 Jan</div>
                                                </div>
                                                <div class="col-3 p-2"> <img class="img-fluid rounded-circle" src="{{ asset('assets/img/user3-128x128.jpg') }}" alt="User Image"> <a class="btn fw-bold fs-7 text-secondary text-truncate w-100 p-0" href="#">
                                                        Nadia
                                                    </a>
                                                    <div class="fs-8">15 Jan</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-center"> <a href="javascript:" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">View All Users</a> </div>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="info-box mb-3 text-bg-default"> <span class="info-box-icon"> <i class="bi bi-tag-fill"></i> </span>
                                        <div class="info-box-content"> <span class="info-box-text">Neurologist</span> <span class="info-box-number">5,200</span> </div>
                                    </div>
                                    <div class="info-box mb-3 text-bg-default"> <span class="info-box-icon"> <i class="bi bi-heart-fill"></i> </span>
                                        <div class="info-box-content"> <span class="info-box-text">General Surgery</span> <span class="info-box-number">92,050</span> </div>
                                    </div>
                                    <div class="info-box mb-3 text-bg-default"> <span class="info-box-icon"> <i class="bi bi-cloud-download"></i> </span>
                                        <div class="info-box-content"> <span class="info-box-text">Dentist</span> <span class="info-box-number">114,381</span> </div>
                                    </div>
                                    <div class="info-box mb-3 text-bg-default"> <span class="info-box-icon"> <i class="bi bi-chat-fill"></i> </span>
                                        <div class="info-box-content"> <span class="info-box-text">Cardiology</span> <span class="info-box-number">163,921</span> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Latest Appointment</h3>
                                    <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table m-0">
                                            <thead>
                                                <tr>
                                                    <th>Booking ID</th>
                                                    <th>Doctor Name</th>
                                                    <th>Appointment Time</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a> </td>
                                                    <td>Dr. Zillur Rahman</td>
                                                    <td>Sunday, 02 Dec 2024, 08:30 PM - 10:00 PM</td>
                                                    <td> <span class="badge text-bg-success">Success</span> </td>
                                                </tr>
                                                <tr>
                                                    <td> <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a> </td>
                                                    <td>Dr. Zillur Rahman</td>
                                                    <td>Sunday, 02 Dec 2024, 08:30 PM - 10:00 PM</td>
                                                    <td> <span class="badge text-bg-success">Success</span> </td>
                                                </tr>
                                                <tr>
                                                    <td> <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a> </td>
                                                    <td>Dr. Zillur Rahman</td>
                                                    <td>Sunday, 02 Dec 2024, 08:30 PM - 10:00 PM</td>
                                                    <td> <span class="badge text-bg-success">Success</span> </td>
                                                </tr>
                                                <tr>
                                                    <td> <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a> </td>
                                                    <td>Dr. Zillur Rahman</td>
                                                    <td>Sunday, 02 Dec 2024, 08:30 PM - 10:00 PM</td>
                                                    <td> <span class="badge text-bg-success">Success</span> </td>
                                                </tr>
                                                <tr>
                                                    <td> <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a> </td>
                                                    <td>Dr. Zillur Rahman</td>
                                                    <td>Sunday, 02 Dec 2024, 08:30 PM - 10:00 PM</td>
                                                    <td> <span class="badge text-bg-success">Success</span> </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> <!-- /.table-responsive -->
                                </div> <!-- /.card-body -->
                                <div class="card-footer clearfix"> <a href="javascript:void(0)" class="btn btn-sm btn-primary float-start">
                                        New Appointment
                                    </a> <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-end">
                                        View All Appointments
                                    </a> </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box mb-3 text-bg-default"> <span class="info-box-icon"> <i class="bi bi-tag-fill"></i> </span>
                                <div class="info-box-content"> <span class="info-box-text">Medicine Doctor</span> <span class="info-box-number">5,200</span> </div>
                            </div>
                            <div class="info-box mb-3 text-bg-default"> <span class="info-box-icon"> <i class="bi bi-heart-fill"></i> </span>
                                <div class="info-box-content"> <span class="info-box-text">Gunacologist</span> <span class="info-box-number">92,050</span> </div>
                            </div>
                            <div class="info-box mb-3 text-bg-default"> <span class="info-box-icon"> <i class="bi bi-cloud-download"></i> </span>
                                <div class="info-box-content"> <span class="info-box-text">ENT Doctor</span> <span class="info-box-number">114,381</span> </div>
                            </div>
                            <div class="info-box mb-3 text-bg-default"> <span class="info-box-icon"> <i class="bi bi-chat-fill"></i> </span>
                                <div class="info-box-content"> <span class="info-box-text">Dermatologist</span> <span class="info-box-number">163,921</span> </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Speciality Wise Appointment</h3>
                                    <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div id="pie-chart" style="min-height: 250px !important;"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div> 
            </div>
        </main>
        @include('admin/layouts.footer')
    </div>

    @endsection