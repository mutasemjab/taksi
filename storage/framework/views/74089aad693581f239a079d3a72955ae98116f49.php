<?php $__env->startSection('content'); ?>
<div class="container">
    <h2><?php echo e(__('messages.Pending_Withdrawal_Requests')); ?></h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo e(__('messages.ID')); ?></th>
                <th><?php echo e(__('messages.Type')); ?></th>
                <th><?php echo e(__('messages.Name')); ?></th>
                <th><?php echo e(__('messages.Phone')); ?></th>
                <th><?php echo e(__('messages.Amount')); ?></th>
                <th><?php echo e(__('messages.Date')); ?></th>
                <th><?php echo e(__('messages.Actions')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $pendingRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($request->id); ?></td>

                    <td>
                        <?php echo e($request->user_id ? __('messages.User') : __('messages.Driver')); ?>

                    </td>

                    <td>
                        <?php echo e($request->user_id ? $request->user->name : $request->driver->name); ?>

                    </td>

                    <td>
                        <?php echo e($request->user_id ? $request->user->phone : $request->driver->phone); ?>

                    </td>

                    <td><?php echo e($request->amount); ?></td>

                    <td><?php echo e($request->created_at->format('Y-m-d H:i')); ?></td>

                    <td>
                        
                        <a href="<?php echo e($request->user_id 
                            ? route('admin.withdrawals.history', $request->user->id)
                            : route('admin.withdrawals.history', $request->driver->id)); ?>"
                           class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>

                        
                        <form method="POST"
                              action="<?php echo e(route('admin.withdrawals.approve', $request->id)); ?>"
                              style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                    class="btn btn-success btn-sm"
                                    onclick="return confirm('<?php echo e(__('messages.Are_You_Sure_Approve')); ?>')">
                                <?php echo e(__('messages.Approve')); ?>

                            </button>
                        </form>

                        
                        <button type="button"
                                class="btn btn-danger btn-sm"
                                data-toggle="modal"
                                data-target="#rejectModal<?php echo e($request->id); ?>">
                            <?php echo e(__('messages.Reject')); ?>

                        </button>

                        <!-- Reject Modal -->
                        <div class="modal fade" id="rejectModal<?php echo e($request->id); ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST"
                                          action="<?php echo e(route('admin.withdrawals.reject', $request->id)); ?>">
                                        <?php echo csrf_field(); ?>

                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <?php echo e(__('messages.Reject_Withdrawal_Request')); ?>

                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label><?php echo e(__('messages.Reason_For_Rejection')); ?></label>
                                                <textarea name="note" class="form-control" required></textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button"
                                                    class="btn btn-secondary"
                                                    data-dismiss="modal">
                                                <?php echo e(__('messages.Cancel')); ?>

                                            </button>
                                            <button type="submit"
                                                    class="btn btn-danger">
                                                <?php echo e(__('messages.Reject')); ?>

                                            </button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <?php echo e($pendingRequests->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/admin/withdrawals/index.blade.php ENDPATH**/ ?>