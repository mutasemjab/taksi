<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Activity Logs</h3>
        </div>
        
        <!-- Filter Form -->
        <div class="card-body border-bottom">
            <form method="GET" action="<?php echo e(route('activity-logs.index')); ?>" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Model Type</label>
                    <select name="log_name" class="form-control">
                        <option value="">All Models</option>
                        <option value="card" <?php echo e(request('log_name') == 'card' ? 'selected' : ''); ?>>Card</option>
                        <option value="user" <?php echo e(request('log_name') == 'user' ? 'selected' : ''); ?>>User</option>
                        <option value="pos" <?php echo e(request('log_name') == 'pos' ? 'selected' : ''); ?>>POS</option>
                        <!-- Add more model types as needed -->
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Event Type</label>
                    <select name="event" class="form-control">
                        <option value="">All Events</option>
                        <option value="created" <?php echo e(request('event') == 'created' ? 'selected' : ''); ?>>Created</option>
                        <option value="updated" <?php echo e(request('event') == 'updated' ? 'selected' : ''); ?>>Updated</option>
                        <option value="deleted" <?php echo e(request('event') == 'deleted' ? 'selected' : ''); ?>>Deleted</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Date From</label>
                    <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>">
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="<?php echo e(route('activity-logs.index')); ?>" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th width="15%">Date & Time</th>
                            <th width="10%">Model</th>
                            <th width="10%">Event</th>
                            <th width="15%">User</th>
                            <th>Changes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div><?php echo e($log->created_at->format('Y-m-d')); ?></div>
                                <small class="text-muted"><?php echo e($log->created_at->format('H:i:s')); ?></small>
                                <div><span class="badge bg-info text-white"><?php echo e($log->created_at->diffForHumans()); ?></span></div>
                            </td>
                            <td>
                                <span class="badge bg-secondary"><?php echo e(ucfirst($log->log_name)); ?></span>
                                <?php if($log->subject): ?>
                                    <div><small class="text-muted">ID: <?php echo e($log->subject_id); ?></small></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($log->event == 'created'): ?>
                                    <span class="badge bg-success">Created</span>
                                <?php elseif($log->event == 'updated'): ?>
                                    <span class="badge bg-warning text-dark">Updated</span>
                                <?php elseif($log->event == 'deleted'): ?>
                                    <span class="badge bg-danger">Deleted</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><?php echo e(ucfirst($log->event)); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($log->causer): ?>
                                    <i class="fas fa-user"></i> <?php echo e($log->causer->name); ?>

                                    <div><small class="text-muted"><?php echo e($log->causer->email ?? ''); ?></small></div>
                                <?php else: ?>
                                    <span class="text-muted">System</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($log->description): ?>
                                    <div><strong><?php echo e($log->description); ?></strong></div>
                                <?php endif; ?>
                                
                                <?php if($log->event == 'updated' && $log->properties->has('old') && $log->properties->has('attributes')): ?>
                                    <small>
                                        <?php $__currentLoopData = $log->properties['attributes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(isset($log->properties['old'][$key]) && $log->properties['old'][$key] != $value): ?>
                                                <div class="mb-1">
                                                    <strong><?php echo e(ucfirst(str_replace('_', ' ', $key))); ?>:</strong>
                                                    <span class="text-danger"><?php echo e(is_array($log->properties['old'][$key]) ? json_encode($log->properties['old'][$key]) : ($log->properties['old'][$key] ?? 'null')); ?></span>
                                                    →
                                                    <span class="text-success"><?php echo e(is_array($value) ? json_encode($value) : ($value ?? 'null')); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </small>
                                <?php elseif($log->event == 'created'): ?>
                                    <small class="text-muted">New record created</small>
                                <?php elseif($log->event == 'deleted'): ?>
                                    <small class="text-muted">Record deleted</small>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center">
                                <div class="py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No activity logs found</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <?php echo e($logs->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/admin/activity-logs/index.blade.php ENDPATH**/ ?>