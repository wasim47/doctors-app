@extends('admin.layouts.app')
@section('title', 'Add New Hospital')
@section('content')
<div class="app-wrapper">
    @include('admin.layouts.sidebar')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Hospital</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('hospital.index') }}" class="btn btn-primary btn-sm">Hospital List</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="form-container col-sm-10 offset-1">

                <form method="POST" action="{{ route('hospital.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-success card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Hospital List</h3>
                            <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                        </div>
                        <div class="card-body">

                            <div class="input-group mb-3 row">
                                <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Hospital Name') }}</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="phone_no" class="col-md-2 col-form-label text-md-right">{{ __('Phone No') }}</label>
                                <div class="col-md-8">
                                    <input id="phone_no" type="tel" class="form-control" name="phone_no" value="{{ old('phone_no') }}" required>
                                    @error('phone_no')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('Email') }}</label>
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="latitude" class="col-md-2 col-form-label text-md-right">{{ __('Latitude') }}</label>
                                <div class="col-md-8">
                                    <input id="latitude" type="number" step="0.00000001" min="-90" max="90" class="form-control" name="latitude" value="{{ old('latitude') }}">
                                    @error('latitude')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="longitude" class="col-md-2 col-form-label text-md-right">{{ __('Longitude') }}</label>
                                <div class="col-md-8">
                                    <input id="longitude" type="number" step="0.00000001" min="-180" max="180" class="form-control" name="longitude" value="{{ old('longitude') }}">
                                    @error('longitude')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-sm-12" style="margin-bottom:10px;">
                                <div class="input-group mb-3 row">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="address">Address </span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <textarea name="address" class="form-control ckeditor"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12" style="margin-bottom:10px;">
                                <div class="input-group mb-3 row">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="description">About </span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <textarea name="description" class="form-control ckeditor"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12" style="margin-bottom:10px;">
                                <div class="input-group mb-3 row">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="services">Services </span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <textarea name="services" class="form-control ckeditor"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12" style="margin-bottom:10px;">
                                <div class="input-group mb-3 row">
                                    <label class="control-label col-md-2 col-sm-2 col-xs-12" for="contact">Contact </span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <textarea name="contact" class="form-control ckeditor"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group mb-3 row">
                                <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Status') }}</label>
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