@extends('admin.layouts.app')
@section('title', 'Add New Branch')
@section('content')
<div class="app-wrapper">
    @include('admin.layouts.sidebar')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Branch</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('branch.index') }}" class="btn btn-primary btn-sm">View Branch List</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('branch.create') }}" class="btn btn-success btn-sm">Approve</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('branch.create') }}" class="btn btn-danger btn-sm">Disapprove</a></li>

                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="form-container col-sm-8 offset-2">

                <form method="POST" action="{{ route('branch.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-success card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Branch List</h3>
                            <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                        </div>
                        <div class="card-body">

                            <div class="input-group mb-3 row">
                                <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Branch Name') }}</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Hospital') }}</label>
                                <div class="col-md-8">
                                    <select name="hospital_id" id="hospital_id" class="form-control" required>
                                        <option value="">Select Hospital</option>
                                        @foreach($hospitalList as $hospital)
                                        <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('hospital_id')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="contact" class="col-md-3 col-form-label text-md-right">{{ __('Contact No') }}</label>
                                <div class="col-md-8">
                                    <input id="contact" type="tel" class="form-control" name="contact" value="{{ old('contact') }}" required>
                                    @error('contact')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="input-group mb-3 row">
                                <label for="hotline" class="col-md-3 col-form-label text-md-right">{{ __('Hotline Number') }}</label>
                                <div class="col-md-8">
                                    <input id="hotline" type="tel" class="form-control" name="hotline" value="{{ old('hotline') }}" required>
                                    @error('hotline')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="latitude" class="col-md-3 col-form-label text-md-right">{{ __('Latitude') }}</label>
                                <div class="col-md-8">
                                    <input id="latitude" type="tel" class="form-control" name="latitude" value="{{ old('latitude') }}" required>
                                    @error('latitude')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="longitude" class="col-md-3 col-form-label text-md-right">{{ __('Longitude') }}</label>
                                <div class="col-md-8">
                                    <input id="longitude" type="tel" class="form-control" name="longitude" value="{{ old('longitude') }}" required>
                                    @error('longitude')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12" style="margin-bottom:10px;">
                                <div class="input-group mb-3 row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="address">Address </span>
                                    </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <textarea name="address" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Status') }}</label>
                                <div class="col-md-8">
                                    <select name="status" class="form-control">
                                        <option value="1">Display</option>
                                        <option value="0">Not Display</option>
                                    </select>
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