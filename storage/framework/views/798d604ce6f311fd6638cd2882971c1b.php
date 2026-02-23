<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">
                    <i class="fas fa-plus me-2"></i>
                    Create New Event
                </h2>
                <a href="<?php echo e(route('events.index')); ?>" class="btn btn-secondary">
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
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form id="create-event-form" action="<?php echo e(route('events.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Event Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="title" name="title" value="<?php echo e(old('title')); ?>" required>
                                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="location" name="location" value="<?php echo e(old('location')); ?>" required>
                                    <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="description" name="description" rows="3"><?php echo e(old('description')); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="event_date" class="form-label">Event Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control <?php $__errorArgs = ['event_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="event_date" name="event_date" value="<?php echo e(old('event_date')); ?>" required>
                                    <?php $__errorArgs = ['event_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="start_time" name="start_time" value="<?php echo e(old('start_time')); ?>" required>
                                    <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="end_time" name="end_time" value="<?php echo e(old('end_time')); ?>" required>
                                    <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">
                            <i class="fas fa-boxes me-2"></i>
                            Inventory Items <small class="text-muted">(Optional - Only select if you need to borrow equipment)</small>
                        </h5>

                        <div id="inventory-items">
                            <?php if($inventoryItems->count() > 0): ?>
                                <?php $__currentLoopData = $inventoryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-4">
                                    <h6 class="text-primary"><?php echo e(ucfirst($category)); ?></h6>
                                    <div class="row">
                                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <div class="card">
                                                <div class="card-body p-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input inventory-checkbox" 
                                                               type="checkbox" 
                                                               id="item_<?php echo e($item->id); ?>" 
                                                               value="<?php echo e($item->id); ?>"
                                                               data-name="<?php echo e($item->name); ?>"
                                                               data-available="<?php echo e($item->quantity_available); ?>">
                                                        <label class="form-check-label" for="item_<?php echo e($item->id); ?>">
                                                            <strong><?php echo e($item->name); ?></strong>
                                                            <?php if($item->description): ?>
                                                            <br><small class="text-muted"><?php echo e($item->description); ?></small>
                                                            <?php endif; ?>
                                                            <br><small class="text-info">Available: <?php echo e($item->quantity_available); ?></small>
                                                        </label>
                                                    </div>
                                                    <div class="quantity-input mt-2" style="display: none;">
                                                        <label class="form-label small">Quantity:</label>
                                                        <input type="number" 
                                                               class="form-control form-control-sm quantity-field" 
                                                               data-item-id="<?php echo e($item->id); ?>"
                                                               min="1" 
                                                               max="<?php echo e($item->quantity_available); ?>"
                                                               placeholder="Enter quantity">
                                                        <label class="form-label small mt-2">Description (Optional):</label>
                                                        <textarea class="form-control form-control-sm notes-field" 
                                                                  data-item-id="<?php echo e($item->id); ?>"
                                                                  rows="2"
                                                                  placeholder="Describe what you need this item for..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No inventory items available. Please contact the administrator to add inventory items.
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="<?php echo e(route('events.index')); ?>" class="btn btn-secondary me-2">Cancel</a>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('event_date').setAttribute('min', today);

    // Validate end time is after start time
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    
    function validateTime() {
        if (startTimeInput.value && endTimeInput.value) {
            if (endTimeInput.value <= startTimeInput.value) {
                endTimeInput.setCustomValidity('End time must be after start time');
            } else {
                endTimeInput.setCustomValidity('');
            }
        }
    }
    
    startTimeInput.addEventListener('change', validateTime);
    endTimeInput.addEventListener('change', validateTime);

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\OneDrive\Desktop\Scheduling and Inventory System\resources\views/events/create.blade.php ENDPATH**/ ?>