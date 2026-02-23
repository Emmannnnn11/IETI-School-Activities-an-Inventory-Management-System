

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary">
                    <i class="fas fa-edit me-2"></i>
                    Edit Inventory Item
                </h2>

                <div>
                    
                    <?php if(isset($inventoryItem) && $inventoryItem): ?>
                        <a href="<?php echo e(route('inventory.show', $inventoryItem)); ?>" 
                           class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Item
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('inventory.index')); ?>" 
                           class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Inventory
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="<?php echo e(route('inventory.update', $inventoryItem)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3">
                            <label for="name" class="form-label">Item Name</label>
                            <input type="text" name="name" id="name" 
                                   value="<?php echo e(old('name', $inventoryItem->name)); ?>" 
                                   class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3"><?php echo e(old('description', $inventoryItem->description)); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" name="category" id="category" 
                                   value="<?php echo e(old('category', $inventoryItem->category)); ?>" 
                                   class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quantity_available" class="form-label">Quantity Available</label>
                                    <input type="number" name="quantity_available" id="quantity_available" 
                                           value="<?php echo e(old('quantity_available', $inventoryItem->quantity_available)); ?>" 
                                           class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quantity_total" class="form-label">Total Quantity</label>
                                    <input type="number" name="quantity_total" id="quantity_total" 
                                           value="<?php echo e(old('quantity_total', $inventoryItem->quantity_total)); ?>" 
                                           class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" id="location" 
                                   value="<?php echo e(old('location', $inventoryItem->location)); ?>" 
                                   class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="available" <?php echo e($inventoryItem->status == 'available' ? 'selected' : ''); ?>>Available</option>
                                <option value="maintenance" <?php echo e($inventoryItem->status == 'maintenance' ? 'selected' : ''); ?>>Maintenance</option>
                                <option value="unavailable" <?php echo e($inventoryItem->status == 'unavailable' ? 'selected' : ''); ?>>Unavailable</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3"><?php echo e(old('notes', $inventoryItem->notes)); ?></textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            
                                     <a href="<?php echo e(route('inventory.show', $inventoryItem)); ?>" 
                                         class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\OneDrive\Desktop\Scheduling and Inventory System\resources\views/inventory/edit.blade.php ENDPATH**/ ?>