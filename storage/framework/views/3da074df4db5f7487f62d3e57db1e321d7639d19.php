<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"><?php echo e(__('messages.Representatives')); ?></h3>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('representive-add')): ?>
                        <a href="<?php echo e(route('representives.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> <?php echo e(__('messages.Add Representative')); ?>

                        </a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                  

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th><?php echo e(__('messages.Name')); ?></th>
                                    <th><?php echo e(__('messages.Phone')); ?></th>
                                    <th><?php echo e(__('messages.Commission')); ?> (%)</th>
                                    <th><?php echo e(__('messages.Created_At')); ?></th>
                                    <th><?php echo e(__('messages.Actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $representives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $representive): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration + ($representives->currentPage() - 1) * $representives->perPage()); ?></td>
                                        <td><?php echo e($representive->name); ?></td>
                                        <td><?php echo e($representive->phone); ?></td>
                                        <td><?php echo e(number_format($representive->commission, 2)); ?>%</td>
                                        <td><?php echo e($representive->created_at->format('Y-m-d H:i')); ?></td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('representive-edit')): ?>
                                                <a href="<?php echo e(route('representives.edit', $representive->id)); ?>" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-edit"></i> <?php echo e(__('messages.Edit')); ?>

                                                </a>
                                            <?php endif; ?>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('representive-delete')): ?>
                                                <form action="<?php echo e(route('representives.destroy', $representive->id)); ?>" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('<?php echo e(__('messages.Are you sure you want to delete this representative?')); ?>')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i> <?php echo e(__('messages.Delete')); ?>

                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <?php echo e(__('messages.No representatives found')); ?>

                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <?php echo e($representives->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/admin/representives/index.blade.php ENDPATH**/ ?>