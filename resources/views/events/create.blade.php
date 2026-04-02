@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">
                    <i class="fas fa-plus me-2"></i>
                    Create New Event
                </h2>
                <a href="{{ route('events.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Events
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-plus me-2"></i>
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

                    <div id="schedule-warning" class="alert alert-warning d-none" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <span id="schedule-warning-text"></span>
                    </div>

                    <form id="create-event-form" action="{{ route('events.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Event Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                    
                                    <select 
                                        id="location" 
                                        name="location" 
                                        class="form-select @error('location') is-invalid @enderror @error('new_location') is-invalid @enderror"
                                        {{ auth()->user()->isAdmin() ? '' : 'required' }}
                                    >
                                        <option value="" disabled {{ old('location') ? '' : 'selected' }}>Select a location</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location }}" {{ old('location') === $location ? 'selected' : '' }}>
                                                {{ $location }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @if(auth()->user()->isAdmin())
                                        <div class="form-text">Admins can add new locations below.</div>
                                        <div class="form-check mt-2">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                id="use_new_location"
                                                {{ old('new_location') ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label" for="use_new_location">
                                                Add a new location
                                            </label>
                                        </div>
                                        <input 
                                            type="text" 
                                            id="new_location" 
                                            name="new_location" 
                                            class="form-control mt-2 @error('new_location') is-invalid @enderror"
                                            placeholder="Enter new location name"
                                            value="{{ old('new_location') }}"
                                            style="{{ old('new_location') ? '' : 'display: none;' }}"
                                        >
                                    @endif

                                    @error('location')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    @error('new_location')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                           id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                           id="end_date" name="end_date" value="{{ old('end_date') }}" required>
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
                                        'value' => old('start_time'),
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
                                        'value' => old('end_time'),
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
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <div class="card">
                                                <div class="card-body p-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input inventory-checkbox" 
                                                               type="checkbox" 
                                                               id="item_{{ $item->id }}" 
                                                               value="{{ $item->id }}"
                                                               data-name="{{ $item->name }}"
                                                               data-available="{{ $item->quantity_available }}">
                                                        <label class="form-check-label" for="item_{{ $item->id }}">
                                                            <strong>{{ $item->name }}</strong>
                                                            @if($item->description)
                                                            <br><small class="text-muted">{{ $item->description }}</small>
                                                            @endif
                                                            <br><small class="text-info">Available: {{ $item->quantity_available }}</small>
                                                        </label>
                                                    </div>
                                                    <div class="quantity-input mt-2" style="display: none;">
                                                        <label class="form-label small">Quantity:</label>
                                                        <input type="number" 
                                                               class="form-control form-control-sm quantity-field" 
                                                               data-item-id="{{ $item->id }}"
                                                               min="1" 
                                                               max="{{ $item->quantity_available }}"
                                                               placeholder="Enter quantity">
                                                        <label class="form-label small mt-2">Description (Optional):</label>
                                                        <textarea class="form-control form-control-sm notes-field" 
                                                                  data-item-id="{{ $item->id }}"
                                                                  rows="2"
                                                                  placeholder="Describe what you need this item for..."></textarea>
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
                                    No inventory items available. Please contact the administrator to add inventory items.
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('events.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" id="create-event-btn" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Create Event
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

    const scheduleWarning = document.getElementById('schedule-warning');
    const scheduleWarningText = document.getElementById('schedule-warning-text');

    // Set minimum dates to one week from today
    const todayDate = new Date();
    const minScheduleDate = new Date(todayDate);
    minScheduleDate.setDate(minScheduleDate.getDate() + 7);
    const minDateValue = minScheduleDate.toISOString().split('T')[0];
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    if (startDateInput) {
        startDateInput.setAttribute('min', minDateValue);
    }
    if (endDateInput) {
        endDateInput.setAttribute('min', minDateValue);
    }

    function showScheduleWarning(message) {
        if (!scheduleWarning || !scheduleWarningText) {
            return;
        }
        scheduleWarningText.textContent = message;
        scheduleWarning.classList.remove('d-none');
    }

    function hideScheduleWarning() {
        if (!scheduleWarning) {
            return;
        }
        scheduleWarning.classList.add('d-none');
    }

    function validateDateRange() {
        if (startDateInput && startDateInput.value) {
            if (startDateInput.value < minDateValue) {
                startDateInput.setCustomValidity('Events must be scheduled at least one week in advance');
                showScheduleWarning('Events must be scheduled at least one week in advance.');
            } else {
                startDateInput.setCustomValidity('');
                hideScheduleWarning();
            }
        }

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
            endDateInput.setAttribute('min', startDateInput.value || minDateValue);
            validateDateRange();
        });
        endDateInput.addEventListener('change', validateDateRange);
    }

    // Validate end time is after start time
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    
    function validateTime() {
        startTimeInput.setCustomValidity('');
        endTimeInput.setCustomValidity('');
        let hasWorkingHoursError = false;

        if (startTimeInput.value && endTimeInput.value) {
            if (endTimeInput.value <= startTimeInput.value) {
                endTimeInput.setCustomValidity('End time must be after start time');
            }
        }

        if (startTimeInput.value && (startTimeInput.value < '08:00' || startTimeInput.value > '17:00')) {
            startTimeInput.setCustomValidity('Events can only be scheduled between 8:00 AM and 5:00 PM');
            hasWorkingHoursError = true;
        }

        if (endTimeInput.value && (endTimeInput.value < '08:00' || endTimeInput.value > '17:00')) {
            endTimeInput.setCustomValidity('Events can only be scheduled between 8:00 AM and 5:00 PM');
            hasWorkingHoursError = true;
        }

        if (hasWorkingHoursError) {
            showScheduleWarning('Events can only be scheduled between 8:00 AM and 5:00 PM.');
        } else if (scheduleWarningText && scheduleWarningText.textContent.includes('8:00 AM and 5:00 PM')) {
            hideScheduleWarning();
        }
    }
    
    startTimeInput.addEventListener('change', validateTime);
    endTimeInput.addEventListener('change', validateTime);
    startTimeInput.addEventListener('input', validateTime);
    endTimeInput.addEventListener('input', validateTime);

    // Admin-only: toggle new location input
    const useNewLocationCheckbox = document.getElementById('use_new_location');
    const newLocationInput = document.getElementById('new_location');
    const locationSelect = document.getElementById('location');

    if (useNewLocationCheckbox && newLocationInput && locationSelect) {
        const toggleLocationInputs = () => {
            if (useNewLocationCheckbox.checked) {
                newLocationInput.style.display = '';
                newLocationInput.required = true;
                locationSelect.required = false;
            } else {
                newLocationInput.style.display = 'none';
                newLocationInput.required = false;
                locationSelect.required = true;
            }
        };

        toggleLocationInputs();
        useNewLocationCheckbox.addEventListener('change', toggleLocationInputs);
    }

    // Form submission handler - only include checked inventory items
    const createBtn = document.getElementById('create-event-btn');
    const createForm = document.getElementById('create-event-form');

    if (createBtn && createForm) {
        // Prevent double submission
        let isSubmitting = false;
        
        createForm.addEventListener('submit', function(evt) {
            if (isSubmitting) {
                evt.preventDefault();
                return false;
            }
            
            // Validate form
            validateDateRange();
            validateTime();
            if (!createForm.checkValidity()) {
                evt.preventDefault();
                evt.stopPropagation();
                createForm.reportValidity();
                return false;
            }
            
            // Validate checked inventory items have quantities
            const checkedItems = document.querySelectorAll('.inventory-checkbox:checked');
            let hasInvalidItems = false;
            
            checkedItems.forEach(function(checkbox) {
                const quantityInput = checkbox.closest('.card-body').querySelector('.quantity-field');
                if (!quantityInput || !quantityInput.value || parseInt(quantityInput.value) < 1) {
                    hasInvalidItems = true;
                    quantityInput.style.borderColor = '#dc3545';
                    quantityInput.focus();
                } else {
                    quantityInput.style.borderColor = '';
                }
            });
            
            if (hasInvalidItems) {
                evt.preventDefault();
                alert('Please enter a quantity for all selected inventory items, or uncheck items you don\'t need.');
                return false;
            }
            
            // Only include checked inventory items with valid quantities
            checkedItems.forEach(function(checkbox) {
                const itemId = checkbox.value;
                const quantityInput = checkbox.closest('.card-body').querySelector('.quantity-field');
                const notesInput = checkbox.closest('.card-body').querySelector('.notes-field');
                
                if (quantityInput && quantityInput.value) {
                    // Create hidden inputs for checked items only
                    const idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = 'inventory_items[' + itemId + '][id]';
                    idInput.value = itemId;
                    createForm.appendChild(idInput);
                    
                    const quantityHidden = document.createElement('input');
                    quantityHidden.type = 'hidden';
                    quantityHidden.name = 'inventory_items[' + itemId + '][quantity]';
                    quantityHidden.value = quantityInput.value;
                    createForm.appendChild(quantityHidden);
                    
                    if (notesInput && notesInput.value) {
                        const notesHidden = document.createElement('input');
                        notesHidden.type = 'hidden';
                        notesHidden.name = 'inventory_items[' + itemId + '][notes]';
                        notesHidden.value = notesInput.value;
                        createForm.appendChild(notesHidden);
                    }
                }
            });
            
            // Mark as submitting
            isSubmitting = true;
            createBtn.disabled = true;
            createBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating Event...';
            
            // Allow form to submit normally
            return true;
        });
        
        // Also handle button click as backup
        createBtn.addEventListener('click', function(evt) {
            // Let the form's submit handler take care of it
            if (!createForm.checkValidity()) {
                evt.preventDefault();
                createForm.reportValidity();
            }
        });
    }
});
</script>
@endsection
