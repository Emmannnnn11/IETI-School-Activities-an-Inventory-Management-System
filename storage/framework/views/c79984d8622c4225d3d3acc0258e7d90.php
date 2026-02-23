

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">
                    <i class="fas fa-calendar me-2"></i>
                    Event Details
                </h2>
                <div>
                    <a href="<?php echo e(route('events.index')); ?>" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to Events
                    </a>
                    <?php if(Auth::user()->canCreateEvents() && ($event->created_by === Auth::id() || Auth::user()->isAdmin()) && $event->status === 'pending'): ?>
                    <a href="<?php echo e(route('events.edit', $event)); ?>" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Edit Event
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Event Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Event Title</h6>
                            <p class="h5"><?php echo e($event->title); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Status</h6>
                            <span class="badge <?php echo e($event->status_badge_class); ?> fs-6">
                                <?php echo e(ucfirst($event->status)); ?>

                            </span>
                        </div>
                    </div>

                    <?php if($event->description): ?>
                    <hr>
                    <div>
                        <h6 class="text-muted">Description</h6>
                        <p><?php echo e($event->description); ?></p>
                    </div>
                    <?php endif; ?>

                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="text-muted">Event Date</h6>
                            <p class="h6"><?php echo e($event->event_date->format('F d, Y')); ?></p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted">Start Time</h6>
                            <p class="h6"><?php echo e(\Carbon\Carbon::parse($event->start_time)->format('g:i A')); ?></p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted">End Time</h6>
                            <p class="h6"><?php echo e(\Carbon\Carbon::parse($event->end_time)->format('g:i A')); ?></p>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Location</h6>
                            <p class="h6"><?php echo e($event->location); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Created By</h6>
                            <p class="h6"><?php echo e($event->creator->name); ?></p>
                        </div>
                    </div>

                    <?php if($event->approver): ?>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Approved By</h6>
                            <p class="h6"><?php echo e($event->approver->name); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Approved At</h6>
                            <p class="h6"><?php echo e($event->approved_at->format('F d, Y g:i A')); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if($event->rejection_reason): ?>
                    <hr>
                    <div>
                        <h6 class="text-muted">Rejection Reason</h6>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?php echo e($event->rejection_reason); ?>

                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-boxes me-2"></i>
                        Requested Items
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($event->eventItems->count() > 0): ?>
                        <?php $__currentLoopData = $event->eventItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eventItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-3 p-3 rounded border" 
                             style="background-color: #f8f9fa;">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="flex-grow-1">
                                    <?php
                                        $inv = $eventItem->inventoryItem;
                                    ?>
                                    <h6 class="mb-1"><?php echo e($inv->name ?? 'Item removed'); ?></h6>
                                    <small class="text-muted d-block">
                                        Requested: <strong><?php echo e($eventItem->quantity_requested); ?></strong>
                                        <?php if($eventItem->quantity_approved): ?>
                                            | Approved: <strong><?php echo e($eventItem->quantity_approved); ?></strong>
                                        <?php endif; ?>
                                    </small>
                                    <?php
                                        $availableQuantity = ($event->status === 'pending' && $inv)
                                            ? $inv->getAvailableQuantityForDate($event->event_date)
                                            : null;
                                    ?>
                                    <?php if($event->status === 'pending' && $availableQuantity !== null): ?>
                                        <small class="d-block mt-1">
                                            <span class="badge bg-info">
                                                Available on <?php echo e($event->event_date->format('M d, Y')); ?>: <?php echo e($availableQuantity); ?>

                                            </span>
                                        </small>
                                    <?php endif; ?>
                                    <?php if($eventItem->notes): ?>
                                        <div class="mt-2">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle"></i> <?php echo e($eventItem->notes); ?>

                                            </small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <span class="badge <?php echo e($eventItem->status_badge_class); ?> ms-2">
                                    <?php echo e(ucfirst($eventItem->status)); ?>

                                </span>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <p class="text-muted text-center">No items requested for this event.</p>
                    <?php endif; ?>
                </div>
            </div>

            <?php if(Auth::user()->canApproveEvents() && $event->status === 'pending'): ?>
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-gavel me-2"></i>
                        Event Approval
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('events.approve', $event)); ?>" method="POST" id="approveForm">
                        <?php echo csrf_field(); ?>
                        
                        <?php if($event->eventItems->count() > 0): ?>
                            <div class="mb-3">
                                <h6 class="mb-3">
                                    <i class="fas fa-boxes me-2"></i>
                                    Item-Level Approval
                                </h6>
                                <p class="text-muted small mb-3">
                                    You can approve the event date while rejecting specific items that are not available.
                                </p>
                                
                                <?php $__currentLoopData = $event->eventItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eventItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $availableQuantity = $eventItem->inventoryItem->getAvailableQuantityForDate($event->event_date);
                                        $canApprove = $availableQuantity > 0;
                                    ?>
                                    <div class="card mb-3 border">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1"><?php echo e($eventItem->inventoryItem->name); ?></h6>
                                                    <small class="text-muted">
                                                        Requested: <strong><?php echo e($eventItem->quantity_requested); ?></strong>
                                                    </small>
                                                    <div class="mt-2">
                                                        <span class="badge <?php echo e($canApprove ? 'bg-success' : 'bg-danger'); ?>">
                                                            Available: <?php echo e($availableQuantity); ?>

                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-3">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input item-action" 
                                                           type="radio" 
                                                           name="event_items[<?php echo e($eventItem->id); ?>][action]" 
                                                           id="approve_<?php echo e($eventItem->id); ?>" 
                                                           value="approve"
                                                           <?php echo e($canApprove ? 'checked' : 'disabled'); ?>

                                                           data-item-id="<?php echo e($eventItem->id); ?>">
                                                    <label class="form-check-label" for="approve_<?php echo e($eventItem->id); ?>">
                                                        <strong>Approve</strong>
                                                        <?php if($canApprove): ?>
                                                            <small class="text-muted">(up to <?php echo e($availableQuantity); ?> available)</small>
                                                        <?php else: ?>
                                                            <small class="text-danger">(Not available)</small>
                                                        <?php endif; ?>
                                                    </label>
                                                </div>
                                                
                                                <?php if($canApprove): ?>
                                                    <div class="ms-4 mb-2">
                                                        <label class="form-label small">Quantity to Approve:</label>
                                                        <input type="number" 
                                                               class="form-control form-control-sm quantity-approved-input" 
                                                               name="event_items[<?php echo e($eventItem->id); ?>][quantity_approved]" 
                                                               value="<?php echo e(min($eventItem->quantity_requested, $availableQuantity)); ?>"
                                                               min="1" 
                                                               max="<?php echo e(min($eventItem->quantity_requested, $availableQuantity)); ?>"
                                                               data-item-id="<?php echo e($eventItem->id); ?>">
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <div class="form-check">
                                                    <input class="form-check-input item-action" 
                                                           type="radio" 
                                                           name="event_items[<?php echo e($eventItem->id); ?>][action]" 
                                                           id="reject_<?php echo e($eventItem->id); ?>" 
                                                           value="reject"
                                                           <?php echo e(!$canApprove ? 'checked' : ''); ?>

                                                           data-item-id="<?php echo e($eventItem->id); ?>">
                                                    <label class="form-check-label" for="reject_<?php echo e($eventItem->id); ?>">
                                                        <strong>Reject</strong> <small class="text-muted">(Item not available for this date)</small>
                                                    </label>
                                                </div>
                                                
                                                <div class="ms-4 mt-2">
                                                    <label class="form-label small">Reason (optional):</label>
                                                    <textarea class="form-control form-control-sm" 
                                                              name="event_items[<?php echo e($eventItem->id); ?>][notes]" 
                                                              rows="2" 
                                                              placeholder="e.g., Item not available on this date"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success w-100" 
                                    onclick="return confirm('Are you sure you want to approve this event? Items marked as rejected will not be approved.')">
                                <i class="fas fa-check me-2"></i>
                                Approve Event
                            </button>
                            
                            <button type="button" class="btn btn-danger w-100" 
                                    data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="fas fa-times me-2"></i>
                                Reject Entire Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Reject Modal -->
            <div class="modal fade" id="rejectModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Reject Event</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="<?php echo e(route('events.reject', $event)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="rejection_reason" class="form-label">Reason for Rejection</label>
                                    <textarea class="form-control" id="rejection_reason" name="rejection_reason" 
                                              rows="3" required placeholder="Please provide a reason for rejecting this event..."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Reject Event</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle item action radio button changes
    const itemActions = document.querySelectorAll('.item-action');
    
    itemActions.forEach(radio => {
        radio.addEventListener('change', function() {
            const itemId = this.dataset.itemId;
            const quantityInput = document.querySelector(`.quantity-approved-input[data-item-id="${itemId}"]`);
            
            if (this.value === 'approve' && quantityInput) {
                quantityInput.disabled = false;
                quantityInput.required = true;
            } else if (this.value === 'reject' && quantityInput) {
                quantityInput.disabled = true;
                quantityInput.required = false;
            }
        });
    });
    
    // Initialize disabled state for rejected items
    itemActions.forEach(radio => {
        if (radio.value === 'reject' && radio.checked) {
            const itemId = radio.dataset.itemId;
            const quantityInput = document.querySelector(`.quantity-approved-input[data-item-id="${itemId}"]`);
            if (quantityInput) {
                quantityInput.disabled = true;
                quantityInput.required = false;
            }
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\OneDrive\Desktop\Scheduling and Inventory System\resources\views/events/show.blade.php ENDPATH**/ ?>