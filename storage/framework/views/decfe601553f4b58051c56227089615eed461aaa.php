<?php $__env->startSection('title', __('messages.Admins')); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"><?php echo e(__('messages.Admins')); ?></h3>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin-add')): ?>
                        <a href="<?php echo e(route('admin.admin.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> <?php echo e(__('messages.Add New Admin')); ?>

                        </a>
                    <?php endif; ?>
                </div>

                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="<?php echo e(route('admin.admin.index')); ?>" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control"
                                       placeholder="<?php echo e(__('messages.Search')); ?>"
                                       value="<?php echo e(request('search')); ?>">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-search"></i> <?php echo e(__('messages.Search')); ?>

                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="<?php echo e(route('admin.admin.index')); ?>" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> <?php echo e(__('messages.Reset')); ?>

                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Admins Table -->
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin-table')): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('messages.Name')); ?></th>
                                        <th><?php echo e(__('messages.Email')); ?></th>
                                        <th><?php echo e(__('messages.Username')); ?></th>
                                        <th><?php echo e(__('messages.Super Admin')); ?></th>
                                        <th><?php echo e(__('messages.Actions')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e(($data->currentPage() - 1) * $data->perPage() + $loop->iteration); ?></td>
                                            <td>
                                                <strong><?php echo e($admin->name); ?></strong>
                                            </td>
                                            <td><?php echo e($admin->email); ?></td>
                                            <td><?php echo e($admin->username); ?></td>
                                            <td>
                                                <?php if($admin->is_super == 1): ?>
                                                    <span class="badge bg-danger"><?php echo e(__('messages.Yes')); ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary"><?php echo e(__('messages.No')); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin-edit')): ?>
                                                        <a href="<?php echo e(route('admin.admin.edit', $admin->id)); ?>"
                                                           class="btn btn-sm btn-warning" title="<?php echo e(__('messages.Edit')); ?>">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin-delete')): ?>
                                                        <?php if($admin->id != 1): ?>
                                                            <form action="<?php echo e(route('admin.admin.destroy', $admin->id)); ?>" method="POST" style="display:inline;">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                        title="<?php echo e(__('messages.Delete')); ?>"
                                                                        onclick="return confirm('<?php echo e(__('messages.Are you sure you want to delete this admin?')); ?>')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        <?php else: ?>
                                                            <button class="btn btn-sm btn-danger disabled" disabled title="<?php echo e(__('messages.Cannot delete super admin')); ?>">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="6" class="text-center"><?php echo e(__('messages.No admins found')); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            <?php echo e($data->appends(request()->query())->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/admin/admin/index.blade.php ENDPATH**/ ?>