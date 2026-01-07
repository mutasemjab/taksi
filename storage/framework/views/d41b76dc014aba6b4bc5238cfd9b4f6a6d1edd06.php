<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2><?php echo e(__('messages.driver_alerts')); ?></h2>


    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th><?php echo e(__('messages.ID')); ?></th>
                <th><?php echo e(__('messages.Driver')); ?></th>
                <th><?php echo e(__('messages.Reason')); ?></th>
                <th><?php echo e(__('messages.Latitude')); ?></th>
                <th><?php echo e(__('messages.Longitude')); ?></th>
                <th><?php echo e(__('messages.address')); ?></th>
                <th><?php echo e(__('messages.Note')); ?></th>
                <th><?php echo e(__('messages.Status')); ?></th>
                <th><?php echo e(__('messages.Created_At')); ?></th>
                <th><?php echo e(__('messages.Actions')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $alerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($alert->id); ?></td>
                <td><?php echo e($alert->driver->name ?? 'N/A'); ?></td>
                <td><?php echo e($alert->report); ?></td>
                <td><?php echo e($alert->lat); ?></td>
                <td><?php echo e($alert->lng); ?></td>
                <td><?php echo e($alert->address); ?></td>
                <td><?php echo e($alert->note); ?></td>
                <td>
                    <form action="<?php echo e(route('admin.driver_alerts.updateStatus', $alert->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="pending" <?php echo e($alert->status == 'pending' ? 'selected' : ''); ?>><?php echo e(__('messages.Pending')); ?></option>
                            <option value="done" <?php echo e($alert->status == 'done' ? 'selected' : ''); ?>><?php echo e(__('messages.Done')); ?></option>
                        </select>
                    </form>
                </td>
                <td><?php echo e($alert->created_at->format('Y-m-d H:i')); ?></td>
                <td>
                    <form action="<?php echo e(route('admin.driver_alerts.destroy', $alert->id)); ?>" method="POST" style="display:inline-block;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-danger btn-sm" onclick="return confirm('<?php echo e(__('messages.Delete_Confirm')); ?>')"><?php echo e(__('messages.Delete')); ?></button>
                    </form>

                    <form action="<?php echo e(route('admin.driver_alerts.notify', $alert->id)); ?>" method="POST" style="display:inline-block;">
                        <?php echo csrf_field(); ?>
                        <button class="btn btn-primary btn-sm"><?php echo e(__('messages.Notify_Nearby')); ?></button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/admin/driver_alerts/index.blade.php ENDPATH**/ ?>