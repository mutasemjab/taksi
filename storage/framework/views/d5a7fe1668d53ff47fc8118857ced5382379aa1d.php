<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo e(__('messages.Complaints')); ?></h1>
        <a href="<?php echo e(route('admin.complaints.create')); ?>" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> <?php echo e(__('messages.Add_New_Complaint')); ?>

        </a>
    </div>

    <!-- Alert Messages -->
    <?php echo $__env->make('admin.common.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo e(__('messages.All_Complaints')); ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?php echo e(__('messages.ID')); ?></th>
                            <th><?php echo e(__('messages.Subject')); ?></th>
                            <th><?php echo e(__('messages.User')); ?></th>
                            <th><?php echo e(__('messages.Driver')); ?></th>
                            <th><?php echo e(__('messages.Order')); ?></th>
                            <th><?php echo e(__('messages.Status')); ?></th>
                            <th><?php echo e(__('messages.Created_At')); ?></th>
                            <th><?php echo e(__('messages.Actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $complaints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $complaint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($complaint->id); ?></td>
                            <td><?php echo e($complaint->subject); ?></td>
                            <td><?php echo e($complaint->user ? $complaint->user->name : __('messages.Not_Available')); ?></td>
                            <td><?php echo e($complaint->driver ? $complaint->driver->name : __('messages.Not_Available')); ?></td>
                            <td><?php echo e($complaint->order ? $complaint->order->id : __('messages.Not_Available')); ?></td>
                            <td>
                                <span class="badge badge-<?php echo e($complaint->status_badge); ?>">
                                    <?php echo e($complaint->status_label); ?>

                                </span>
                            </td>
                            <td><?php echo e($complaint->created_at->format('Y-m-d H:i')); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.complaints.show', $complaint)); ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('admin.complaints.edit', $complaint)); ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('admin.complaints.destroy', $complaint)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo e(__('messages.Are_You_Sure')); ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center"><?php echo e(__('messages.No_Complaints_Found')); ?></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                <?php echo e($complaints->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "ordering": false,
            "paging": false,
            "info": false,
            "searching": true,
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/admin/complaints/index.blade.php ENDPATH**/ ?>