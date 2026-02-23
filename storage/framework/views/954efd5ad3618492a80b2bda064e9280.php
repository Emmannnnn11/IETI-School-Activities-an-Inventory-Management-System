

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">
                    <i class="fas fa-user me-2"></i>
                    User Details
                </h2>
                <div>
                    <a href="<?php echo e(route('users.index')); ?>" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to Users
                    </a>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $user)): ?>
                    <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>
                        Edit User
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
                        User Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <h6 class="text-muted">Name</h6>
                            <p class="h6"><?php echo e($user->name); ?></p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted">Email</h6>
                            <p class="h6"><?php echo e($user->email); ?></p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted">Role</h6>
                            <span class="badge bg-primary"><?php echo e(ucfirst(str_replace('_', ' ', $user->role))); ?></span>
                        </div>
                    </div>

                    <?php if($user->employee_id || $user->department): ?>
                    <hr>
                    <div class="row mb-3">
                        <?php if($user->employee_id): ?>
                        <div class="col-md-6">
                            <h6 class="text-muted">Employee ID</h6>
                            <p class="h6"><?php echo e($user->employee_id); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if($user->department): ?>
                        <div class="col-md-6">
                            <h6 class="text-muted">Department</h6>
                            <p class="h6"><?php echo e($user->department); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Created At</h6>
                            <p class="h6"><?php echo e($user->created_at->format('F d, Y g:i A')); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Last Updated</h6>
                            <p class="h6"><?php echo e($user->updated_at->format('F d, Y g:i A')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\OneDrive\Desktop\Scheduling and Inventory System\resources\views/users/show.blade.php ENDPATH**/ ?>