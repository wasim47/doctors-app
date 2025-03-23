@extends('admin.layouts.app')
@section('title', 'Add New Doctor')
@section('content')
<div class="app-wrapper">
    @include('admin.layouts.sidebar')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Doctor</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('doctor.create') }}" class="btn btn-primary btn-sm">Add New Doctor</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('doctor.create') }}" class="btn btn-success btn-sm">Approve</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('doctor.create') }}" class="btn btn-danger btn-sm">Disapprove</a></li>

                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="form-container col-sm-8 offset-2">

                <form method="POST" action="{{ route('doctor.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-success card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Doctor List</h3>
                            <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                        </div>
                        <div class="card-body">

                            <div class="input-group mb-3 row">
                                <label for="first_name" class="col-md-3 col-form-label text-md-right">{{ __('First Name') }}</label>
                                <div class="col-md-8">
                                    <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
                                    @error('first_name') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="last_name" class="col-md-3 col-form-label text-md-right">{{ __('Last Name') }}</label>
                                <div class="col-md-8">
                                    <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
                                    @error('last_name') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="designation" class="col-md-3 col-form-label text-md-right">{{ __('Designation') }}</label>
                                <div class="col-md-8">
                                    <input id="designation" type="text" class="form-control" name="designation" value="{{ old('designation') }}" required>
                                    @error('designation') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="input-group mb-3 row">
                                <label for="bmdc" class="col-md-3 col-form-label text-md-right">{{ __('BMDC NO.') }}</label>
                                <div class="col-md-8">
                                    <input id="bmdc" type="text" class="form-control" name="bmdc" value="{{ old('bmdc') }}" required>
                                    @error('bmdc') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="image" class="col-md-3 col-form-label text-md-right">{{ __('Doctor Photo') }}</label>
                                <div class="col-md-8">
                                    <input id="image" type="file" class="form-control" name="image">
                                    @error('image') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="speciality_id" class="col-md-3 col-form-label text-md-right">{{ __('Specialization') }}</label>
                                <div class="col-md-8">
                                    <select name="speciality_id[]" class="form-control select2Data" required multiple>
                                        <option value="">Select Specialization</option>
                                        @foreach($specialityList as $speciality)
                                        <option value="{{ $speciality->id }}">{{ $speciality->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('speciality_id') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="hospital_id" class="col-md-3 col-form-label text-md-right">{{ __('Hospital') }}</label>
                                <div class="col-md-8">
                                    <select name="hospital_id" class="form-control">
                                        <option value="">Select Hospital</option>
                                        @foreach($hospitalList as $hospital)
                                        <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('hospital_id') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="branch_id" class="col-md-3 col-form-label text-md-right">{{ __('Branch') }}</label>
                                <div class="col-md-8">
                                    <select name="branch_id[]" class="form-control select2Data" multiple>
                                        <option value="">Select Branch</option>
                                        @foreach($branchList as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('branch_id') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="experience" class="col-md-3 col-form-label text-md-right">{{ __('Experience (years)') }}</label>
                                <div class="col-md-8">
                                    <input id="experience" type="number" class="form-control" name="experience" value="{{ old('experience') }}" required>
                                    @error('experience') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="degree" class="col-md-3 col-form-label text-md-right">{{ __('Qualification/Degree') }}</label>
                                <div class="col-md-8">
                                    <input id="degree" type="text" class="form-control" name="degree" value="{{ old('degree') }}" required>
                                    @error('degree') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="input-group mb-3 row">
                                <label for="phone_no" class="col-md-3 col-form-label text-md-right">{{ __('Phone No') }}</label>
                                <div class="col-md-8">
                                    <input id="phone_no" type="tel" class="form-control" name="phone_no" value="{{ old('phone_no') }}" required>
                                    @error('phone_no') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="input-group mb-3 row">
                                <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('Email') }}</label>
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                    @error('email') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="about" class="col-md-3 col-form-label text-md-right">{{ __('About Doctor') }}</label>
                                <div class="col-md-8">
                                    <textarea name="about" class="form-control">{{ old('about') }}</textarea>
                                    @error('about') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="gender" class="col-md-3 col-form-label text-md-right">{{ __('Gender') }}</label>
                                <div class="col-md-8">
                                    <select name="gender" class="form-control">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Not Declare">Not Declare</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    @error('gender') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="date_of_birth" class="col-md-3 col-form-label text-md-right">{{ __('Date of Birth') }}</label>
                                <div class="col-md-8">
                                    <input id="date_of_birth" type="date" class="form-control" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                    @error('date_of_birth') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="regular_fee" class="col-md-3 col-form-label text-md-right">{{ __('Regular Fee') }}</label>
                                <div class="col-md-8">
                                    <input id="regular_fee" type="number" class="form-control" name="regular_fee" value="{{ old('regular_fee') }}" required>
                                    @error('regular_fee') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="report_fee_applicable" class="col-md-3 col-form-label text-md-right">{{ __('Report Fee Applicable') }}</label>
                                <div class="col-md-8">
                                    <select name="report_fee_applicable" class="form-control">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                    @error('report_fee_applicable') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="report_fee" class="col-md-3 col-form-label text-md-right">{{ __('Report Fee') }}</label>
                                <div class="col-md-8">
                                    <input id="report_fee" type="number" class="form-control" name="report_fee" value="{{ old('report_fee') }}" required>
                                    @error('report_fee') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="start_date" class="col-md-3 col-form-label text-md-right">Schedule Start Date</label>
                                <div class="col-md-8">
                                    <input id="start_date" type="date" class="form-control" name="start_date" required>
                                    @error('start_date') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="end_date" class="col-md-3 col-form-label text-md-right">Schedule End Date (Optional)</label>
                                <div class="col-md-8">
                                    <input id="end_date" type="date" class="form-control" name="end_date">
                                    @error('end_date') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>


                            <div class="input-group mb-3 row">
                                <label for="status" class="col-md-3 col-form-label text-md-right">{{ __('Status') }}</label>
                                <div class="col-md-8">
                                    <select name="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    @error('status') <span style="color: red;">{{ $message }}</span> @enderror
                                </div>
                            </div>                            
                        </div>

                        <div class="card-footer"> <button type="submit" class="btn btn-success">Submit</button> </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
    @include('admin/layouts.footer')
</div>

@endsection