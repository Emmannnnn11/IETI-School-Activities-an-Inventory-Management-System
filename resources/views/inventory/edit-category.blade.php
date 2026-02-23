@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">
                    <i class="fas fa-folder me-2"></i>
                    Edit Category: {{ ucfirst($category) }}
                </h2>
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Inventory
                </a>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Rename Category
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('inventory.category.update', ['category' => urlencode($category)]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_category" class="form-label">Current Category Name</label>
                            <input type="text" 
                                   id="current_category" 
                                   class="form-control" 
                                   value="{{ $category }}" 
                                   disabled>
                            <small class="text-muted">This category contains {{ $items->count() }} item(s)</small>
                        </div>

                        <div class="mb-3">
                            <label for="new_category" class="form-label">New Category Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="new_category" 
                                   id="new_category" 
                                   class="form-control @error('new_category') is-invalid @enderror" 
                                   value="{{ old('new_category', $category) }}" 
                                   required
                                   maxlength="255"
                                   placeholder="Enter new category name">
                            @error('new_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">All {{ $items->count() }} item(s) in this category will be updated.</small>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Note:</strong> Renaming this category will update the category name for all items in this category.
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Update Category
                            </button>
                            <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Items in this category ({{ $items->count() }})
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($items as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <strong>{{ $item->name }}</strong>
                                @if($item->description)
                                <br><small class="text-muted">{{ Str::limit($item->description, 50) }}</small>
                                @endif
                            </span>
                            <span class="badge {{ $item->status_badge_class }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
