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
                        <h3 class="mb-0">Speciality</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('sepeciality.create') }}" class="btn btn-primary btn-sm">Add New Speciality</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('sepeciality.create') }}" class="btn btn-success btn-sm">Approve</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('sepeciality.create') }}" class="btn btn-danger btn-sm">Disapprove</a></li>

                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="form-container col-sm-8 offset-2">
            
                <form method="POST" action="{{ route('sepeciality.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-success card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Speciality List</h3>
                            <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                        </div>
                        <div class="card-body">

                            <div class="input-group mb-3 row">
                                <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Speciality Name') }}</label>
                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="input-group mb-3 row">
                                <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Image') }}</label>
                                <div class="col-md-8">
                                    <input id="image" type="file" class="form-control" name="image">
                                    @error('image')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                    <br>
                                    <small class="text-danger">Size should be Width: 100 x Height: 100</small>
                                </div>
                            </div>

                            <div class="col-sm-12" style="margin-bottom:10px;">
                                <div class="input-group mb-3 row">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="details">Content </span>
                                    </label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <textarea name="details" class="form-control ckeditor"></textarea>
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