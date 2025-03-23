@extends('admin.layouts.app')
@section('title', 'Add New Appointment Schedule')
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

                <div class="card card-success card-outline mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Create Appointment Schedule</h3>
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
                        <form action="{{ route('schedule.store') }}" method="POST">
                            @csrf
                            <div class="input-group mb-3 row">
                                <label for="doctor_id" class="col-md-3 col-form-label text-md-right">Doctor</label>
                                <div class="col-md-8">
                                    <select name="doctor_id" class="form-control" required>
                                        <option value="">Select Doctor</option>
                                        @foreach($doctorList as $doctor)
                                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                            {{ $doctor->first_name.' '.$doctor->last_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('doctor_id') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="days_of_weeks" class="col-md-3 col-form-label text-md-right">Days of Week</label>
                                <div class="col-md-8">
                                    <select name="days_of_weeks" class="form-control" required>
                                        @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                        <option value="{{ $day }}" {{ old('days_of_weeks') == $day ? 'selected' : '' }}>{{ $day }}</option>
                                        @endforeach
                                    </select>
                                    @error('days_of_weeks') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="status" class="col-md-3 col-form-label text-md-right">Status</label>
                                <div class="col-md-8">
                                    <select name="status" class="form-control">
                                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <table class="table">
                                <tr>
                                    <td><label for="shift" class="col-form-label text-md-right">Shift</label></td>
                                    <td><label for="start_time" class="col-form-label text-md-right">Start Time</label></td>
                                    <td><label for="end_time" class="col-form-label text-md-right">End Time</label></td>
                                    <td><label for="minutes_per_appointment" class="col-form-label text-md-right">Minutes Per Appointment</label></td>
                                    <td><label for="maximum_patients" class="col-form-label text-md-right">Maximum Patients</label></td>
                                </tr>

                                @for($i = 0; $i <= 2; $i++)
                                    @php
                                    $shiftVal=['Morning', 'Afternoon' , 'Evening' ][$i];
                                    $shiftRequired=$i==0;
                                    @endphp
                                    <tr>
                                    <td>
                                        <select id="shift{{ $i }}" name="shift[]" class="form-control" onchange="formEnable(this.value,'{{ $i }}')"
                                            @if ($shiftRequired) required @endif>
                                            <option value="">Select</option>
                                            <option value="{{ $shiftVal }}" {{ old("shift.$i") == $shiftVal ? 'selected' : '' }}>{{ $shiftVal }}</option>
                                        </select>
                                        @error("shift.$i") <span style="color: red;">{{ $message }}</span> @enderror
                                    </td>
                                    <td>
                                        <input id="start_time{{ $i }}" type="time" class="form-control" name="start_time[]"
                                            value="{{ old("start_time.$i") }}" required disabled>
                                        @error("start_time.$i") <span style="color: red;">{{ $message }}</span> @enderror
                                    </td>
                                    <td>
                                        <input id="end_time{{ $i }}" type="time" class="form-control" name="end_time[]"
                                            value="{{ old("end_time.$i") }}" required disabled>
                                        @error("end_time.$i") <span style="color: red;">{{ $message }}</span> @enderror
                                    </td>
                                    <td>
                                        <input id="minutes_per_appointment{{ $i }}" type="number" class="form-control" name="minutes_per_appointment[]"
                                            value="{{ old("minutes_per_appointment.$i") }}" required disabled>
                                        @error("minutes_per_appointment.$i") <span style="color: red;">{{ $message }}</span> @enderror
                                    </td>
                                    <td>
                                        <input id="maximum_patients{{ $i }}" type="number" class="form-control" name="maximum_patients[]"
                                            value="{{ old("maximum_patients.$i") }}" required disabled>
                                        @error("maximum_patients.$i") <span style="color: red;">{{ $message }}</span> @enderror
                                    </td>
                                    </tr>
                                    @endfor
                            </table>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Create Schedule</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </main>
    @include('admin/layouts.footer')
</div>


<script>
    /* function formEnable(thisvalue, id) {
        if (thisvalue != "") {
            $("#shift" + id).prop('required', true)
            $("#start_time" + id).prop('disabled', false)
            $("#end_time" + id).prop('disabled', false)
            $("#maximum_patients" + id).prop('disabled', false)
            $("#minutes_per_appointment" + id).prop('disabled', false)
        } else {
            if (id != 0) {
                $("#shift" + id).prop('required', false)
            }
            $("#start_time" + id).prop('disabled', true)
            $("#end_time" + id).prop('disabled', true)
            $("#maximum_patients" + id).prop('disabled', true)
            $("#minutes_per_appointment" + id).prop('disabled', true)
        }
    } */


    function formEnable(value, index) {
        let fields = ['start_time', 'end_time', 'minutes_per_appointment', 'maximum_patients'];
        fields.forEach(field => {
            document.getElementById(field + index).disabled = (value === '');
        });
    }
</script>
@endsection