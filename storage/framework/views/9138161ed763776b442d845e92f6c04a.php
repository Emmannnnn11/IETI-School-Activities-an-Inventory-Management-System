

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">
                    <i class="fas fa-folder me-2"></i>
                    Edit Category: <?php echo e(ucfirst($category)); ?>

                </h2>
                <a href="<?php echo e(route('inventory.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Inventory
                </a>
            </div>
        </div>
    </div>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

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
                    <form action="<?php echo e(route('inventory.category.update', ['category' => urlencode($category)])); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3">
                            <label for="current_category" class="form-label">Current Category Name</label>
                            <input type="text" 
                                   id="current_category" 
                                   class="form-control" 
                                   value="<?php echo e($category); ?>" 
                                   disabled>
                            <small class="text-muted">This category contains <?php echo e($items->count()); ?> item(s)</small>
                        </div>

                        <div class="mb-3">
                            <label for="new_category" class="form-label">New Category Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="new_category" 
                                   id="new_category" 
                                   class="form-control <?php $__errorArgs = ['new_category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('new_category', $category)); ?>" 
                                   required
                                   maxlength="255"
                                   placeholder="Enter new category name">
                            <?php $__errorArgs = ['new_category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="text-muted">All <?php echo e($items->count()); ?> item(s) in this category will be updated.</small>
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
                            <a href="<?php echo e(route('inventory.index')); ?>" class="btn btn-secondary">
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
                        Items in this category (<?php echo e($items->count()); ?>)
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <strong><?php echo e($item->name); ?></strong>
                                <?php if($item->description): ?>
                                <br><small class="text-muted"><?php echo e(Str::limit($item->description, 50)); ?></small>
                                <?php endif; ?>
                            </span>
                            <span class="badge <?php echo e($item->status_badge_class); ?>">
                                <?php echo e(ucfirst($item->status)); ?>

                            </span>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\OneDrive\Desktop\Scheduling and Inventory System\resources\views/inventory/edit-category.blade.php ENDPATH**/ ?>