@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">
                    <i class="fas fa-plus me-2"></i>
                    Add New Inventory Item
                </h2>
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Inventory
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-box-plus me-2"></i>
                        Item Information
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

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('inventory.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Item Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" 
                                   value="{{ old('name') }}" 
                                   class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <input type="text" name="category" id="category" 
                                   value="{{ old('category') }}" 
                                   class="form-control @error('category') is-invalid @enderror" required
                                   placeholder="e.g., Electronics, Furniture, Equipment">
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quantity_total" class="form-label">Total Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="quantity_total" id="quantity_total" 
                                           value="{{ old('quantity_total') }}" 
                                           class="form-control @error('quantity_total') is-invalid @enderror" 
                                           min="0" required>
                                    @error('quantity_total')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">The total number of items available.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" name="location" id="location" 
                                           value="{{ old('location') }}" 
                                           class="form-control @error('location') is-invalid @enderror"
                                           placeholder="e.g., Room 101, Storage A">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" 
                                      class="form-control @error('notes') is-invalid @enderror" 
                                      rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Additional notes or information about this item.</small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('inventory.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Save Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

