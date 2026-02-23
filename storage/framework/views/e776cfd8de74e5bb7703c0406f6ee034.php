<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </h2>
                <div class="text-muted">
                    Welcome back, <?php echo e(Auth::user()->name); ?>!
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard View -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-calendar-check fa-3x text-success mb-3"></i>
                    <h4 class="text-success"><?php echo e($events->where('status', 'approved')->count()); ?></h4>
                    <p class="text-muted mb-0">Approved Events</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                    <h4 class="text-warning"><?php echo e($events->where('status', 'pending')->count()); ?></h4>
                    <p class="text-muted mb-0">Pending Events</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                    <h4 class="text-danger"><?php echo e($events->where('status', 'rejected')->count()); ?></h4>
                    <p class="text-muted mb-0">Rejected Events</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-boxes fa-3x text-info mb-3"></i>
                    <h4 class="text-info"><?php echo e($inventoryItems->count()); ?></h4>
                    <p class="text-muted mb-0">Inventory Items</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Event Calendar
                    </h5>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Recent Events
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($events->count() > 0): ?>
                        <?php $__currentLoopData = $events->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-flex align-items-center mb-3 p-2 rounded" style="background-color: #f8f9fa;">
                            <div class="me-3">
                                <span class="badge <?php echo e($event->status_badge_class); ?>"><?php echo e(ucfirst($event->status)); ?></span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1"><?php echo e($event->title); ?></h6>
                                <small class="text-muted">
                                    <?php echo e($event->event_date->format('M d, Y')); ?> at <?php echo e($event->start_time); ?>

                                </small>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <p class="text-muted text-center">No events found.</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-box-open me-2"></i>
                        Pending Borrowed Items
                    </h5>
                </div>
                <div class="card-body">
                    <?php if(isset($pendingBorrowedItems) && $pendingBorrowedItems->count() > 0): ?>
                        <?php $__currentLoopData = $pendingBorrowedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eventItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-flex align-items-start mb-3 p-2 rounded border" style="background-color: #f8f9fa;">
                            <div class="me-3">
                                <i class="fas fa-box fa-2x text-info"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1"><?php echo e($eventItem->inventoryItem->name); ?></h6>
                                <small class="text-muted d-block">
                                    Quantity: <strong><?php echo e($eventItem->quantity_approved); ?></strong>
                                </small>
                                <small class="text-muted d-block">
                                    Event: <?php echo e($eventItem->event->title); ?> on <?php echo e($eventItem->event->event_date->format('M d, Y')); ?>

                                </small>
                                <?php
                                    $isPastEvent = $eventItem->event->event_date < now()->toDateString() || 
                                                  ($eventItem->event->event_date == now()->toDateString() && 
                                                   $eventItem->event->end_time && 
                                                   \Carbon\Carbon::parse($eventItem->event->end_time)->format('H:i') < now()->format('H:i'));
                                ?>
                                <?php if($isPastEvent): ?>
                                    <small class="text-danger d-block mt-1">
                                        <i class="fas fa-exclamation-triangle"></i> Event finished - Item should be returned
                                    </small>
                                <?php endif; ?>
                                <?php if($eventItem->notes): ?>
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle"></i> <?php echo e(\Illuminate\Support\Str::limit($eventItem->notes, 50)); ?>

                                </small>
                                <?php endif; ?>
                                <?php
                                    $user = Auth::user();
                                    $canConfirm = $user->canConfirmReturns() || $user->isStaff() || $user->isAdmin();
                                ?>
                                <?php if($canConfirm): ?>
                                <div class="mt-2">
                                    <?php if($eventItem->isReturned()): ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i> Returned
                                        </span>
                                        <small class="text-muted d-block mt-1">
                                            Returned on: <?php echo e($eventItem->returned_at->format('M d, Y g:i A')); ?>

                                        </small>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('event-items.return', $eventItem->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-sm btn-success" 
                                                    onclick="return confirm('Are you sure you want to confirm that this item has been returned?')">
                                                <i class="fas fa-check me-1"></i> Confirm Returned
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <p class="text-muted text-center">No items currently borrowed.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listWeek'
        },
        events: '/api/events',
        eventClick: function(info) {
            // Redirect to event details
            window.location.href = '/events/' + info.event.id;
        },
        eventDidMount: function(info) {
            // Add custom styling based on status
            if (info.event.extendedProps.status === 'approved') {
                info.el.style.backgroundColor = '#a3b18a';
                info.el.style.color = 'white';
            } else if (info.event.extendedProps.status === 'pending') {
                info.el.style.backgroundColor = '#FFA500';
                info.el.style.color = 'black';
            } else if (info.event.extendedProps.status === 'rejected') {
                info.el.style.backgroundColor = '#dc3545';
                info.el.style.color = 'white';
            }
        }
    });
    calendar.render();
    
    // Refresh calendar when page loads (useful after creating events)
    window.refreshCalendar = function() {
        calendar.refetchEvents();
    };
    
    // Immediately refresh calendar if there's a success message (event was just created)
    <?php if(session('success')): ?>
        setTimeout(function() {
            calendar.refetchEvents();
        }, 500);
    <?php endif; ?>
    
    // Auto-refresh calendar every 30 seconds to show new events
    setInterval(function() {
        calendar.refetchEvents();
    }, 30000);
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\OneDrive\Desktop\Scheduling and Inventory System\resources\views/home.blade.php ENDPATH**/ ?>