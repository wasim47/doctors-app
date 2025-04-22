@extends('admin.layouts.app')
@section('title', 'Assign Permissions to Role')

@section('content')
<div class="app-wrapper">
    @include('admin.layouts.sidebar')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <h3 class="fw-bold">Assign Permissions to Role</h3>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('roles.permissions.save') }}">
                    @csrf

                    <!-- Row for Role & Module Selection -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="role" class="form-label fw-semibold">Select Role</label>
                            <select name="role_id" id="role_id" class="form-select shadow-sm" required>
                                <option value="">-- Choose Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="module" class="form-label fw-semibold">Select Module</label>
                            <select name="module_id" id="module_id" class="form-select shadow-sm" required>
                                <option value="">-- Choose Module --</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}">{{ $module->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Card for Permissions -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0 fw-bold text-primary">Module Permissions</h5>
                            <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="select-all">
                                        <label class="form-check-label text-dark fw-medium" for="select-all">
                                            Select All
                                        </label>
                                    </div>
                        </div>

                        <div class="card-body">
                            <div id="permission-checkboxes" class="row gy-2"></div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4 py-2">Assign Permissions</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    @include('admin.layouts.footer')
</div>
@endsection

@section('page-script')
<script>
    document.getElementById('module_id').addEventListener('change', function () {
        const moduleId = this.value;
        const container = document.getElementById('permission-checkboxes');
        const selectAllCheckbox = document.getElementById('select-all');

        container.innerHTML = '';
        selectAllCheckbox.checked = false;

        if (moduleId) {
            fetch(`/admin/get-permissions-by-module/${moduleId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        container.innerHTML = '<p class="text-danger">No permissions found for this module.</p>';
                    } else {
                        data.forEach(permission => {
                            const col = document.createElement('div');
                            col.className = 'col-md-4';
                            col.innerHTML = `
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="${permission.id}" id="perm-${permission.id}">
                                    <label class="form-check-label" for="perm-${permission.id}">
                                        ${permission.slug}
                                    </label>
                                </div>
                            `;
                            container.appendChild(col);
                        });
                    }
                });
        }
    });

    document.getElementById('select-all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('#permission-checkboxes input[type="checkbox"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
@endsection
