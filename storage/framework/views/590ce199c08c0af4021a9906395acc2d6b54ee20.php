<?php $__env->startSection('title', __('messages.Add New Role')); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"><?php echo e(__('messages.Add New Role')); ?></h3>
                    <a href="<?php echo e(route('admin.role.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> <?php echo e(__('messages.Back')); ?>

                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('admin.role.store')); ?>">
                        <?php echo csrf_field(); ?>

                        <!-- Role Name -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label"><?php echo e(__('messages.Name')); ?> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="name" name="name" value="<?php echo e(old('name')); ?>"
                                       placeholder="<?php echo e(__('messages.Enter role name')); ?>" required>
                                <?php $__errorArgs = ['name'];
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

                        <!-- Permissions Section -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0"><?php echo e(__('messages.Permissions')); ?></h4>
                            <div>
                                <button type="button" class="btn btn-sm btn-outline-success select-all-perms">
                                    <i class="fas fa-check-double"></i> <?php echo e(__('messages.Select All')); ?>

                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger unselect-all-perms ms-2">
                                    <i class="fas fa-times-circle"></i> <?php echo e(__('messages.Unselect All')); ?>

                                </button>
                            </div>
                        </div>

                        <?php $__currentLoopData = $groupedPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resource => $permissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(count($permissions) > 0): ?>
                            <div class="card mb-3">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 text-capitalize"><?php echo e(ucfirst($resource)); ?></h5>
                                        <button type="button" class="btn btn-sm btn-outline-primary check-all-btn" data-resource="<?php echo e($resource); ?>">
                                            <i class="fas fa-check-square"></i> <?php echo e(__('messages.Check All')); ?>

                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <tbody>
                                                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td width="50">
                                                        <input type="checkbox" name="perms[]"
                                                               value="<?php echo e($permission->id); ?>"
                                                               id="perm_<?php echo e($permission->id); ?>"
                                                               class="resource-<?php echo e($resource); ?>"
                                                               <?php echo e(in_array($permission->id, old('perms', [])) ? 'checked' : ''); ?>>
                                                    </td>
                                                    <td>
                                                        <label for="perm_<?php echo e($permission->id); ?>" class="mb-0">
                                                            <strong><?php echo e($permission->name); ?></strong>
                                                        </label>
                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php $__errorArgs = ['perms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="alert alert-danger"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> <?php echo e(__('messages.Save')); ?>

                                </button>
                                <a href="<?php echo e(route('admin.role.index')); ?>" class="btn btn-secondary ms-2">
                                    <i class="fas fa-times"></i> <?php echo e(__('messages.Cancel')); ?>

                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle Check All buttons per resource
    document.querySelectorAll('.check-all-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const resource = this.dataset.resource;
            const checkboxes = document.querySelectorAll(`.resource-${resource}`);
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);

            checkboxes.forEach(cb => {
                cb.checked = !allChecked;
            });

            // Update button text
            this.innerHTML = !allChecked ?
                '<i class="fas fa-square"></i> <?php echo e(__("messages.Uncheck All")); ?>' :
                '<i class="fas fa-check-square"></i> <?php echo e(__("messages.Check All")); ?>';
        });
    });

    // Handle Select All Permissions button
    document.querySelector('.select-all-perms').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelectorAll('input[name="perms[]"]').forEach(cb => {
            cb.checked = true;
        });
    });

    // Handle Unselect All Permissions button
    document.querySelector('.unselect-all-perms').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelectorAll('input[name="perms[]"]').forEach(cb => {
            cb.checked = false;
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/admin/roles/create.blade.php ENDPATH**/ ?>