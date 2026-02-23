

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">
                    <i class="fas fa-user me-2"></i>
                    My Profile
                </h2>
                <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>
                    Edit Profile
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Profile Information
                    </h5>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

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

                    <?php if($user->employee_id): ?>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Employee ID</h6>
                            <p class="h6"><?php echo e($user->employee_id); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Department</h6>
                            <p class="h6"><?php echo e($user->department ?? 'N/A'); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i>
                            Edit Profile
                        </a>
                        <a href="<?php echo e(route('profile.password')); ?>" class="btn btn-outline-warning">
                            <i class="fas fa-key me-2"></i>
                            Change Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\OneDrive\Desktop\Scheduling and Inventory System\resources\views/profile/index.blade.php ENDPATH**/ ?>