<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">
                    <i class="fas fa-boxes me-2"></i>
                    Inventory Management
                </h2>
                <div class="d-flex gap-2">
                    <?php
                        $canRefresh = in_array(Auth::user()->role, ['admin', 'Head Maintenance']);
                    ?>
                    <?php if($canRefresh): ?>
                    <a href="<?php echo e(route('inventory.index', ['refresh' => 1])); ?>" class="btn btn-secondary">
                        <i class="fas fa-sync-alt me-2"></i>
                        Refresh Borrowed Items
                    </a>
                    <?php endif; ?>
                    <?php
                        $canCreate = empty(Auth::user()->getAllowedInventoryCategories());
                    ?>
                    <?php if($canCreate): ?>
                    <a href="<?php echo e(route('inventory.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Add New Item
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

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

    <?php if($inventoryItems->count() > 0): ?>
        <?php $__currentLoopData = $inventoryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-folder me-2"></i>
                            <?php echo e(ucfirst($category)); ?> <small class="text-muted">(<?php echo e($items->count()); ?> items)</small>
                        </h5>
                        <?php
                            $canEditCategory = in_array(Auth::user()->role, ['admin', 'Head Maintenance']);
                        ?>
                        <?php if($canEditCategory): ?>
                        <a href="<?php echo e(route('inventory.category.edit', ['category' => urlencode($category)])); ?>" 
                           class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit me-1"></i> Edit Category
                        </a>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="card-title mb-0"><?php echo e($item->name); ?></h6>
                                            <span class="badge <?php echo e($item->status_badge_class); ?>">
                                                <?php echo e(ucfirst($item->status)); ?>

                                            </span>
                                        </div>
                                        
                                        <?php if($item->description): ?>
                                        <p class="card-text text-muted small mb-2"><?php echo e(Str::limit($item->description, 100)); ?></p>
                                        <?php endif; ?>

                                        <div class="mb-2">
                                            <small class="text-muted">
                                                <i class="fas fa-box me-1"></i>
                                                Available: <strong><?php echo e($item->quantity_available); ?></strong> / <?php echo e($item->quantity_total); ?>

                                            </small>
                                        </div>

                                        <?php if($item->location): ?>
                                        <div class="mb-2">
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                <?php echo e($item->location); ?>

                                            </small>
                                        </div>
                                        <?php endif; ?>

                                        <?php if($item->eventItems->count() > 0): ?>
                                        <div class="mb-2">
                                            <small class="text-info">
                                                <i class="fas fa-calendar me-1"></i>
                                                Used in <?php echo e($item->eventItems->count()); ?> event(s)
                                            </small>
                                        </div>
                                        <?php endif; ?>

                                        <div class="mt-3">
                                            <a href="<?php echo e(route('inventory.show', $item)); ?>" class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="<?php echo e(route('inventory.edit', $item)); ?>" class="btn btn-sm btn-outline-warning me-1">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <?php
                                                $canDelete = in_array(Auth::user()->role, ['admin', 'Head Maintenance']);
                                            ?>
                                            <?php if($canDelete): ?>
                                            <form action="<?php echo e(route('inventory.destroy', $item)); ?>" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Delete this inventory item? This cannot be undone.');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Inventory Items</h5>
                        <p class="text-muted">Start by adding your first inventory item.</p>
                        <a href="<?php echo e(route('inventory.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Add New Item
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\OneDrive\Desktop\Scheduling and Inventory System\resources\views/inventory/index.blade.php ENDPATH**/ ?>