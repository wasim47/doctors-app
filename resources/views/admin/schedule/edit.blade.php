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
                            <li class="breadcrumb-item"><a href="{{ route('schedule.create') }}" class="btn btn-primary btn-sm">Add New Appointment Schedule</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('schedule.create') }}" class="btn btn-success btn-sm">Approve</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('schedule.create') }}" class="btn btn-danger btn-sm">Disapprove</a></li>

                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="form-container col-sm-8 offset-2">

                <form action="{{ route('schedule.update', $schedule->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    @method('PATCH')
                    <div class="card card-success card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Appointment Schedule</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                    <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                    <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="input-group mb-3 row">
                                <label for="doctor_id" class="col-md-3 col-form-label text-md-right">{{ __('Doctor') }}</label>
                                <div class="col-md-8">
                                    <select name="doctor_id" class="form-control" required>
                                        <option value="">Select Doctor</option>
                                        @foreach($doctorList as $doctor)
                                        <option value="{{ $doctor->id }}" {{ $schedule->doctor_id == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->first_name.' '.$doctor->last_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('doctor_id') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="title" class="col-md-3 col-form-label text-md-right">{{ __('Title') }}</label>
                                <div class="col-md-8">
                                    <input id="title" type="text" class="form-control" name="title" value="{{ $schedule->title }}" required>
                                    @error('title') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            @php
                            $selectedDays = json_decode($schedule->days_of_weeks ?? '[]', true);
                            @endphp

                            <div class="input-group mb-3 row">
                                <label for="days_of_weeks" class="col-md-3 col-form-label text-md-right">Days of Week</label>
                                <div class="col-md-8">
                                    <select name="days_of_weeks[]" class="form-control" id="days_of_weeks" multiple="multiple" required>
                                        <option value="Sunday" {{ in_array('Sunday', $selectedDays) ? 'selected' : '' }}>Sunday</option>
                                        <option value="Monday" {{ in_array('Monday', $selectedDays) ? 'selected' : '' }}>Monday</option>
                                        <option value="Tuesday" {{ in_array('Tuesday', $selectedDays) ? 'selected' : '' }}>Tuesday</option>
                                        <option value="Wednesday" {{ in_array('Wednesday', $selectedDays) ? 'selected' : '' }}>Wednesday</option>
                                        <option value="Thursday" {{ in_array('Thursday', $selectedDays) ? 'selected' : '' }}>Thursday</option>
                                        <option value="Friday" {{ in_array('Friday', $selectedDays) ? 'selected' : '' }}>Friday</option>
                                        <option value="Saturday" {{ in_array('Saturday', $selectedDays) ? 'selected' : '' }}>Saturday</option>
                                    </select>
                                    @error('days_of_weeks') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>


                            <div class="input-group mb-3 row">
                                <label for="shift" class="col-md-3 col-form-label text-md-right">{{ __('Shift') }}</label>
                                <div class="col-md-8">
                                    <select name="shift" class="form-control" required>
                                        <option value="Morning" {{ $schedule->shift == 'Morning' ? 'selected' : '' }}>Morning</option>
                                        <option value="Afternoon" {{ $schedule->shift == 'Afternoon' ? 'selected' : '' }}>Afternoon</option>
                                        <option value="Evening" {{ $schedule->shift == 'Evening' ? 'selected' : '' }}>Evening</option>
                                    </select>
                                    @error('shift') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                            <label for="start_time" class="col-md-3 col-form-label text-md-right">Start Time</label>
                            <div class="col-md-8">
                                <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time', $schedule->start_time) }}" required>
                                @error('start_time') <span style="color: red;">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="input-group mb-3 row">
                            <label for="end_time" class="col-md-3 col-form-label text-md-right">End Time</label>
                            <div class="col-md-8">
                                <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time', $schedule->end_time) }}" required>
                                @error('end_time') <span style="color: red;">{{ $message }}</span> @enderror
                            </div>
                        </div>


                            <div class="input-group mb-3 row">
                                <label for="minutes_per_appointment" class="col-md-3 col-form-label text-md-right">{{ __('Minutes Per Appointment') }}</label>
                                <div class="col-md-8">
                                    <input id="minutes_per_appointment" type="number" class="form-control" name="minutes_per_appointment"
                                        value="{{ $schedule->minutes_per_appointment }}" required>
                                    @error('minutes_per_appointment') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="maximum_patients" class="col-md-3 col-form-label text-md-right">{{ __('Maximum Patients') }}</label>
                                <div class="col-md-8">
                                    <input id="maximum_patients" type="number" class="form-control" name="maximum_patients"
                                        value="{{ $schedule->maximum_patients }}" required>
                                    @error('maximum_patients') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            
                            <div class="input-group mb-3 row">
                                <label for="status" class="col-md-3 col-form-label text-md-right">{{ __('Status') }}</label>
                                <div class="col-md-8">
                                    <select name="status" class="form-control">
                                        <option value="1" {{ $schedule->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $schedule->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </main>
    @include('admin/layouts.footer')
</div>

@endsection