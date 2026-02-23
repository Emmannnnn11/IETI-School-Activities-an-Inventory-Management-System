@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">
                    <i class="fas fa-user-plus me-2"></i>
                    Create New User
                </h2>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Users
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>
                        User Information
                    </h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" 
                                   value="{{ old('name') }}" 
                                   class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" 
                                   value="{{ old('email') }}" 
                                   class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" id="role" 
                                    class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">Select a role</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="college_head" {{ old('role') === 'college_head' ? 'selected' : '' }}>College Head</option>
                                <option value="senior_head" {{ old('role') === 'senior_head' ? 'selected' : '' }}>Senior Head</option>
                                <option value="junior_head" {{ old('role') === 'junior_head' ? 'selected' : '' }}>Junior Head</option>
                                <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>Teacher</option>
                                <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="Head Maintenance" {{ old('role') === 'Head Maintenance' ? 'selected' : '' }}>Head Maintenance</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee ID</label>
                            <input type="text" name="employee_id" id="employee_id" 
                                   value="{{ old('employee_id') }}" 
                                   class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" name="department" id="department" 
                                   value="{{ old('department') }}" 
                                   class="form-control">
                        </div>

                        <hr>

                        <h6 class="mb-3">Password <span class="text-danger">*</span></h6>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" 
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Enter password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Password must be at least 8 characters long.</small>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="form-control"
                                   placeholder="Confirm password" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
