@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">
                    <i class="fas fa-edit me-2"></i>
                    Edit Event
                </h2>
                <a href="{{ route('events.show', $event) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Event
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-edit me-2"></i>
                        Event Details
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

                    <form id="edit-event-form" action="{{ route('events.update', $event) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Event Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title', $event->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                           id="location" name="location" value="{{ old('location', $event->location) }}" required>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                           id="start_date" name="start_date" 
                                           value="{{ old('start_date', optional($event->effective_start_date)->format('Y-m-d')) }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                           id="end_date" name="end_date" 
                                           value="{{ old('end_date', optional($event->effective_end_date)->format('Y-m-d')) }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="start_time_hour" class="form-label">Start Time <span class="text-danger">*</span></label>
                                    @include('partials.time-input-12h', [
                                        'name' => 'start_time',
                                        'id' => 'start_time',
                                        'fieldName' => 'start_time',
                                        'value' => old('start_time', \Carbon\Carbon::parse($event->start_time)->format('H:i')),
                                        'required' => true,
                                    ])
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="end_time_hour" class="form-label">End Time <span class="text-danger">*</span></label>
                                    @include('partials.time-input-12h', [
                                        'name' => 'end_time',
                                        'id' => 'end_time',
                                        'fieldName' => 'end_time',
                                        'value' => old('end_time', \Carbon\Carbon::parse($event->end_time)->format('H:i')),
                                        'required' => true,
                                    ])
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">
                            <i class="fas fa-boxes me-2"></i>
                            Inventory Items <small class="text-muted">(Optional - Only select if you need to borrow equipment)</small>
                        </h5>

                        <div id="inventory-items">
                            @if($inventoryItems->count() > 0)
                                @foreach($inventoryItems as $category => $items)
                                <div class="mb-4">
                                    <h6 class="text-primary">{{ ucfirst($category) }}</h6>
                                    <div class="row">
                                        @foreach($items as $item)
                                        @php
                                            $eventItem = $event->eventItems->firstWhere('inventory_item_id', $item->id);
                                            $isChecked = $eventItem !== null;
                                            $quantity = $eventItem ? $eventItem->quantity_requested : '';
                                        @endphp
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <div class="card">
                                                <div class="card-body p-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input inventory-checkbox" 
                                                               type="checkbox" 
                                                               id="item_{{ $item->id }}" 
                                                               value="{{ $item->id }}"
                                                               data-name="{{ $item->name }}"
                                                               data-available="{{ $item->quantity_available }}"
                                                               {{ $isChecked ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="item_{{ $item->id }}">
                                                            <strong>{{ $item->name }}</strong>
                                                            @if($item->description)
                                                            <br><small class="text-muted">{{ $item->description }}</small>
                                                            @endif
                                                            <br><small class="text-info">Available: {{ $item->quantity_available }}</small>
                                                        </label>
                                                    </div>
                                                    <div class="quantity-input mt-2" style="display: {{ $isChecked ? 'block' : 'none' }};">
                                                        <label class="form-label small">Quantity:</label>
                                                        <input type="number" 
                                                               class="form-control form-control-sm quantity-field" 
                                                               data-item-id="{{ $item->id }}"
                                                               name="inventory_items[{{ $item->id }}][quantity]"
                                                               value="{{ $quantity }}"
                                                               min="1" 
                                                               max="{{ $item->quantity_available }}"
                                                               placeholder="Enter quantity"
                                                               {{ $isChecked ? 'required' : '' }}>
                                                        <input type="hidden" name="inventory_items[{{ $item->id }}][id]" value="{{ $item->id }}">
                                                        <label class="form-label small mt-2">Description (Optional):</label>
                                                        <textarea class="form-control form-control-sm" 
                                                                  name="inventory_items[{{ $item->id }}][notes]"
                                                                  rows="2"
                                                                  placeholder="Describe what you need this item for...">{{ $eventItem ? $eventItem->notes : '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No inventory items available.
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('events.show', $event) }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" id="edit-event-btn" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Update Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle inventory item selection
    const checkboxes = document.querySelectorAll('.inventory-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const quantityInput = this.closest('.card-body').querySelector('.quantity-input');
            const quantityField = quantityInput.querySelector('.quantity-field');
            
            if (this.checked) {
                quantityInput.style.display = 'block';
                quantityField.required = true;
                quantityField.max = this.dataset.available;
            } else {
                quantityInput.style.display = 'none';
                quantityField.required = false;
                quantityField.value = '';
            }
        });
    });

    // Set minimum dates to today
    const today = new Date().toISOString().split('T')[0];
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    if (startDateInput) {
        startDateInput.setAttribute('min', today);
    }
    if (endDateInput) {
        endDateInput.setAttribute('min', today);
    }

    function validateDateRange() {
        if (startDateInput && endDateInput && startDateInput.value && endDateInput.value) {
            if (endDateInput.value < startDateInput.value) {
                endDateInput.setCustomValidity('End date cannot be earlier than start date');
            } else {
                endDateInput.setCustomValidity('');
            }
        }
    }
    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function () {
            if (endDateInput.value && endDateInput.value < startDateInput.value) {
                endDateInput.value = startDateInput.value;
            }
            endDateInput.setAttribute('min', startDateInput.value || today);
            validateDateRange();
        });
        endDateInput.addEventListener('change', validateDateRange);
    }

    // Validate end time is after start time (hidden fields hold 24-hour H:i for the server)
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    
    function validateTime() {
        startTimeInput.setCustomValidity('');
        endTimeInput.setCustomValidity('');

        if (startTimeInput.value && endTimeInput.value) {
            if (endTimeInput.value <= startTimeInput.value) {
                endTimeInput.setCustomValidity('End time must be after start time');
            }
        }

        if (startTimeInput.value && (startTimeInput.value < '08:00' || startTimeInput.value > '17:00')) {
            startTimeInput.setCustomValidity('Events can only be scheduled between 8:00 AM and 5:00 PM');
        }

        if (endTimeInput.value && (endTimeInput.value < '08:00' || endTimeInput.value > '17:00')) {
            endTimeInput.setCustomValidity('Events can only be scheduled between 8:00 AM and 5:00 PM');
        }
    }
    
    startTimeInput.addEventListener('change', validateTime);
    endTimeInput.addEventListener('change', validateTime);
    startTimeInput.addEventListener('input', validateTime);
    endTimeInput.addEventListener('input', validateTime);
});
</script>
@endsection

