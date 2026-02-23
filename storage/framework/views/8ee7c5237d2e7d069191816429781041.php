

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">
                    <i class="fas fa-calendar me-2"></i>
                    Events
                </h2>
                <?php if(Auth::user()->canCreateEvents()): ?>
                <a href="<?php echo e(route('events.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Create New Event
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <?php if(Auth::user()->canApproveEvents()): ?>
        <?php
            // Filter pending events from the collection
            $pendingEvents = $events->filter(function($event) {
                return $event->status === 'pending';
            });
        ?>
        
        <?php if($pendingEvents->count() > 0): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-warning">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0 text-dark">
                            <i class="fas fa-hourglass-half me-2"></i>
                            Events Pending Approval (<?php echo e($pendingEvents->count()); ?>)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Event</th>
                                        <th>Date & Time</th>
                                        <th>Location</th>
                                        <th>Created By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $pendingEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="table-warning">
                                        <td>
                                            <div>
                                                <h6 class="mb-1"><?php echo e($event->title); ?></h6>
                                                <?php if($event->description): ?>
                                                <small class="text-muted"><?php echo e(Str::limit($event->description, 50)); ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?php echo e($event->event_date->format('M d, Y')); ?></strong><br>
                                                <small class="text-muted">
                                                    <?php echo e(\Carbon\Carbon::parse($event->start_time)->format('g:i A')); ?> - 
                                                    <?php echo e(\Carbon\Carbon::parse($event->end_time)->format('g:i A')); ?>

                                                </small>
                                            </div>
                                        </td>
                                        <td><?php echo e($event->location); ?></td>
                                        <td><?php echo e($event->creator->name); ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route('events.show', $event)); ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <form action="<?php echo e(route('events.approve', $event)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-success" 
                                                            onclick="return confirm('Are you sure you want to approve this event?')">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        data-bs-toggle="modal" data-bs-target="#rejectModal<?php echo e($event->id); ?>">
                                                    <i class="fas fa-times"></i> Reject
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal<?php echo e($event->id); ?>" tabindex="-1">
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
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        All Events
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($events->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Date & Time</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-1"><?php echo e($event->title); ?></h6>
                                            <?php if($event->description): ?>
                                            <small class="text-muted"><?php echo e(Str::limit($event->description, 50)); ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong><?php echo e($event->event_date->format('M d, Y')); ?></strong><br>
                                            <small class="text-muted">
                                                <?php echo e(\Carbon\Carbon::parse($event->start_time)->format('g:i A')); ?> - 
                                                <?php echo e(\Carbon\Carbon::parse($event->end_time)->format('g:i A')); ?>

                                            </small>
                                        </div>
                                    </td>
                                    <td><?php echo e($event->location); ?></td>
                                    <td>
                                        <span class="badge <?php echo e($event->status_badge_class); ?>">
                                            <?php echo e(ucfirst($event->status)); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($event->creator->name); ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('events.show', $event)); ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if($event->created_by === Auth::id() || Auth::user()->isAdmin()): ?>
                                            <a href="<?php echo e(route('events.edit', $event)); ?>" class="btn btn-sm btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php endif; ?>
                                            <?php if(Auth::user()->canApproveEvents() && $event->status === 'pending'): ?>
                                            <form action="<?php echo e(route('events.approve', $event)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-success" 
                                                        onclick="return confirm('Are you sure you want to approve this event?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    data-bs-toggle="modal" data-bs-target="#rejectModal<?php echo e($event->id); ?>">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <?php endif; ?>
                                            <?php if($event->status === 'rejected' && Auth::user()->isAdmin()): ?>
                                            <form action="<?php echo e(route('events.destroy', $event)); ?>" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Delete this rejected event? This action cannot be undone, but a history entry will be created.');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Reject Modal -->
                                <?php if(Auth::user()->canApproveEvents() && $event->status === 'pending'): ?>
                                <div class="modal fade" id="rejectModal<?php echo e($event->id); ?>" tabindex="-1">
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
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">No events found</h5>
                        <?php if(Auth::user()->canCreateEvents()): ?>
                        <p class="text-muted">Create your first event to get started!</p>
                        <a href="<?php echo e(route('events.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Create Event
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\OneDrive\Desktop\Scheduling and Inventory System\resources\views/events/index.blade.php ENDPATH**/ ?>