<?php $__env->startSection('title'); ?>
    <?php echo e(__('messages.Settings')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheaderactive'); ?>
    <?php echo e(__('messages.Show')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title card_title_center">
            <?php echo e(__('messages.Settings')); ?>

        </h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-12 table-responsive">

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting-table')): ?>
                    <?php if(isset($data) && !empty($data) && count($data) > 0): ?>
                        <table class="table" style="width:100%">
                            <thead class="custom_thead">
                                <tr>
                                    <td><?php echo e(__('messages.Key')); ?></td>
                                    <td><?php echo e(__('messages.Value')); ?></td>
                                    <td><?php echo e(__('messages.Action')); ?></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        
                                        <td><?php echo e(__('messages.' . $info->key)); ?></td>
                                        <td><?php echo e($info->value); ?></td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting-edit')): ?>
                                                <a href="<?php echo e(route('settings.edit', $info->id)); ?>"
                                                   class="btn btn-sm btn-primary">
                                                    <?php echo e(__('messages.Edit')); ?>

                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <br>
                        <?php echo e($data->links()); ?>

                    <?php else: ?>
                        <div class="alert alert-danger">
                            <?php echo e(__('messages.No_data')); ?>

                        </div>
                    <?php endif; ?>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('assets/admin/js/Settings.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>