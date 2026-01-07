<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo e(__('messages.View_Complaint')); ?></h1>
        <a href="<?php echo e(route('complaints.index')); ?>" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> <?php echo e(__('messages.Back_to_List')); ?>

        </a>
    </div>

    <!-- Complaint Details -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo e(__('messages.Complaint_Details')); ?></h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold"><?php echo e(__('messages.Subject')); ?>:</label>
                        <p><?php echo e($complaint->subject); ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold"><?php echo e(__('messages.Status')); ?>:</label>
                        <p>
                            <span class="badge badge-<?php echo e($complaint->status_badge); ?>">
                                <?php echo e($complaint->status_label); ?>

                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="font-weight-bold"><?php echo e(__('messages.Description')); ?>:</label>
                        <p><?php echo e($complaint->description ?? __('messages.Not_Available')); ?></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold"><?php echo e(__('messages.User')); ?>:</label>
                        <p><?php echo e($complaint->user ? $complaint->user->name : __('messages.Not_Available')); ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold"><?php echo e(__('messages.Driver')); ?>:</label>
                        <p><?php echo e($complaint->driver ? $complaint->driver->name : __('messages.Not_Available')); ?></p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="font-weight-bold"><?php echo e(__('messages.Order_ID')); ?>:</label>
                        <p><?php echo e($complaint->order ? $complaint->order->id : __('messages.Not_Available')); ?></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold"><?php echo e(__('messages.Created_At')); ?>:</label>
                        <p><?php echo e($complaint->created_at->format('Y-m-d H:i')); ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="font-weight-bold"><?php echo e(__('messages.Updated_At')); ?>:</label>
                        <p><?php echo e($complaint->updated_at->format('Y-m-d H:i')); ?></p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <h5 class="font-weight-bold"><?php echo e(__('messages.Update_Status')); ?></h5>
                   <form action="<?php echo e(route('complaints.update-status', $complaint)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="status"><?php echo e(__('messages.Status')); ?></label>
                            <select class="form-control" id="status" name="status">
                                <option value="1" <?php echo e($complaint->status == 1 ? 'selected' : ''); ?>><?php echo e(__('messages.Pending')); ?></option>
                                <option value="2" <?php echo e($complaint->status == 2 ? 'selected' : ''); ?>><?php echo e(__('messages.In_Progress')); ?></option>
                                <option value="3" <?php echo e($complaint->status == 3 ? 'selected' : ''); ?>><?php echo e(__('messages.Done')); ?></option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary"><?php echo e(__('messages.Update_Status')); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/admin/complaints/show.blade.php ENDPATH**/ ?>