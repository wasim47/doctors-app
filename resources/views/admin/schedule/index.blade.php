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
                            <h3 class="mb-0">Appointment Schedule</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <a href="javascript:void()" onclick="permissions('schedules','1');" style="color:#000; " class="btn btn-success btn-sm m-2"><i class="fa fa-check"></i> Approved</a>
                                <a href="javascript:void()" onclick="permissions('schedules','0');" style="color:#000; " class="btn btn-warning btn-sm m-2"><i class="fa fa-times"></i> Disapproved</a>
                                <a href="javascript:void()" onclick="deletedata('masterdelete','schedules');" style="color:#fff; " class="btn btn-danger btn-sm m-2"><i class="fa fa-times"></i> Multiple Delete</a>
                                <a href="{{ route('schedule.create') }}" style="color:#fff; margin-right:20px" class="btn btn-primary btn-sm m-2"><i class="fa fa-plus"></i> Add New</a>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Appointment Schedule List</h3>
                            <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <form id="form_check">
                                    <table class="table m-0">
                                        <thead>
                                            <tr>
                                                <th width="4%">
                                                    <input name="checkbox" onclick="checkedAll();" type="checkbox" readonly="readonly" />
                                                </th>
                                                <th>SI</th>
                                                <th>Doctor</th>
                                                <th>Title</th>
                                                <th>Days of Week</th>
                                                <th>Shift</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($listData as $data)
                                            <tr id="tablerow{{ $data->id }}" class="tablerow">
                                                <td>
                                                    <input type="checkbox" name="summe_code[]" id="summe_code{{ $data->id }}" value="{{ $data->id }}" />
                                                </td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->doctor->first_name.' '.$data->doctor->last_name ?? 'N/A' }}</td> <!-- Fetch doctor's name -->
                                                <td>{{ $data->title }}</td>
                                                <td>{{ $data->days_of_weeks }}</td>
                                                <td>
                                                    <table class="table">
                                                            <tr>
                                                                <td>Shift</td>
                                                                <td>Start Time</td>
                                                                <td>End Time</td>
                                                                <td>Min. Interval</td>
                                                                <td>Max Patiend visit</td>
                                                            </tr>
                                                        @foreach($data->shift as $shift)
                                                            <tr>
                                                                <td>{{ $shift->shift }}</td>
                                                                <td>{{ $shift->start_time }}</td>
                                                                <td>{{ $shift->end_time }}</td>
                                                                <td>{{ $shift->minutes_per_appointment }} min</td>
                                                                <td>{{ $shift->maximum_patients }} person</td>
                                                            </tr>
                                                            @endforeach
                                                        </table>
                                                </td>
                                                <td>
                                                    {!! $data->status ? '<span class="badge text-bg-success">Active</span>' : '<span class="badge text-bg-danger">Inactive</span>' !!}
                                                </td>
                                                <td align="right">
                                                    <div style="display: flex; gap: 5px;">
                                                        <a href="{{ route('schedule.edit', $data->id) }}" class="btn btn-warning btn-sm">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="deleteSingle('{{ $data->id }}', 'masterdelete', 'schedules')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </form>
                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            {{ $listData->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </main>
        @include('admin/layouts.footer')
    </div>

    @endsection