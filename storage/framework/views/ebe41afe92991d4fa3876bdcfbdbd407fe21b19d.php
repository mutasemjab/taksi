<?php $__env->startSection('title', __('messages.Order_Status_History_Report')); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-chart-line"></i> <?php echo e(__('messages.Order_Status_History_Report')); ?>

        </h1>
        <a href="<?php echo e(route('reports.order-status-export', request()->query())); ?>" class="btn btn-success">
            <i class="fas fa-file-excel"></i> <?php echo e(__('messages.Export_CSV')); ?>

        </a>
    </div>

    <!-- Filters Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter"></i> <?php echo e(__('messages.Filters')); ?>

            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('reports.order-status-history')); ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_from"><?php echo e(__('messages.Date_From')); ?></label>
                            <input type="date" class="form-control" id="date_from" name="date_from" 
                                   value="<?php echo e(request('date_from')); ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_to"><?php echo e(__('messages.Date_To')); ?></label>
                            <input type="date" class="form-control" id="date_to" name="date_to" 
                                   value="<?php echo e(request('date_to')); ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status"><?php echo e(__('messages.Status')); ?></label>
                            <select class="form-control" id="status" name="status">
                                <option value=""><?php echo e(__('messages.All_Statuses')); ?></option>
                                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>
                                    <?php echo e(__('messages.Pending')); ?>

                                </option>
                                <option value="accepted" <?php echo e(request('status') == 'accepted' ? 'selected' : ''); ?>>
                                    <?php echo e(__('messages.Accepted')); ?>

                                </option>
                                <option value="on_the_way" <?php echo e(request('status') == 'on_the_way' ? 'selected' : ''); ?>>
                                    <?php echo e(__('messages.On_The_Way')); ?>

                                </option>
                                <option value="started" <?php echo e(request('status') == 'started' ? 'selected' : ''); ?>>
                                    <?php echo e(__('messages.Started')); ?>

                                </option>
                                <option value="arrived" <?php echo e(request('status') == 'arrived' ? 'selected' : ''); ?>>
                                    <?php echo e(__('messages.Arrived')); ?>

                                </option>
                                <option value="waiting_payment" <?php echo e(request('status') == 'waiting_payment' ? 'selected' : ''); ?>>
                                    <?php echo e(__('messages.Waiting_Payment')); ?>

                                </option>
                                <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>
                                    <?php echo e(__('messages.Completed')); ?>

                                </option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="driver_id"><?php echo e(__('messages.Driver')); ?></label>
                            <select class="form-control" id="driver_id" name="driver_id">
                                <option value=""><?php echo e(__('messages.All_Drivers')); ?></option>
                                <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($driver->id); ?>" <?php echo e(request('driver_id') == $driver->id ? 'selected' : ''); ?>>
                                    <?php echo e($driver->name); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="user_id"><?php echo e(__('messages.User')); ?></label>
                            <select class="form-control" id="user_id" name="user_id">
                                <option value=""><?php echo e(__('messages.All_Users')); ?></option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>" <?php echo e(request('user_id') == $user->id ? 'selected' : ''); ?>>
                                    <?php echo e($user->name); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="service_id"><?php echo e(__('messages.Service')); ?></label>
                            <select class="form-control" id="service_id" name="service_id">
                                <option value=""><?php echo e(__('messages.All_Services')); ?></option>
                                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($service->id); ?>" <?php echo e(request('service_id') == $service->id ? 'selected' : ''); ?>>
                                    <?php echo e($service->name_en); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> <?php echo e(__('messages.Apply_Filters')); ?>

                                </button>
                                <a href="<?php echo e(route('reports.order-status-history')); ?>" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> <?php echo e(__('messages.Reset')); ?>

                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <?php echo e(__('messages.Orders_List')); ?> (<?php echo e($orders->total()); ?> <?php echo e(__('messages.Orders')); ?>)
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th><?php echo e(__('messages.Order_ID')); ?></th>
                            <th><?php echo e(__('messages.User')); ?></th>
                            <th><?php echo e(__('messages.Driver')); ?></th>
                            <th><?php echo e(__('messages.Service')); ?></th>
                            <th><?php echo e(__('messages.Current_Status')); ?></th>
                            <th><?php echo e(__('messages.Created_At')); ?></th>
                            <th><?php echo e(__('messages.Total_Duration')); ?></th>
                            <th><?php echo e(__('messages.Actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            // Get status value (handle enum)
                            $statusValue = is_object($order->status) ? $order->status->value : $order->status;
                            
                            // Get status badge class
                            $badgeClass = 'badge-secondary';
                            if ($statusValue == 'completed') {
                                $badgeClass = 'badge-success';
                            } elseif (in_array($statusValue, ['user_cancel_order', 'driver_cancel_order', 'cancel_cron_job'])) {
                                $badgeClass = 'badge-danger';
                            } elseif ($statusValue == 'waiting_payment') {
                                $badgeClass = 'badge-warning';
                            } elseif (in_array($statusValue, ['accepted', 'on_the_way', 'arrived', 'started'])) {
                                $badgeClass = 'badge-info';
                            }
                            
                            // Calculate duration
                            $histories = \App\Models\OrderStatusHistory::where('order_id', $order->id)
                                ->orderBy('changed_at', 'asc')
                                ->get();
                            
                            $totalDuration = 0;
                            if ($histories->isNotEmpty()) {
                                $firstChange = $histories->first();
                                $lastChange = $histories->last();
                                
                                if (in_array($statusValue, ['completed', 'user_cancel_order', 'driver_cancel_order', 'cancel_cron_job'])) {
                                    $totalDuration = \Carbon\Carbon::parse($firstChange->changed_at)->diffInMinutes(\Carbon\Carbon::parse($lastChange->changed_at));
                                } else {
                                    $totalDuration = \Carbon\Carbon::parse($firstChange->changed_at)->diffInMinutes(now());
                                }
                            }
                            
                            // Format duration
                            if ($totalDuration < 1) {
                                $durationFormatted = '< 1 min';
                            } else {
                                $hours = floor($totalDuration / 60);
                                $mins = $totalDuration % 60;
                                
                                if ($hours > 0) {
                                    $durationFormatted = $hours . 'h ' . $mins . 'm';
                                } else {
                                    $durationFormatted = $mins . 'm';
                                }
                            }
                        ?>
                        <tr>
                            <td>
                                <a href="<?php echo e(route('reports.order-status-detail', $order->id)); ?>" class="font-weight-bold">
                                    #<?php echo e($order->id); ?>

                                </a>
                            </td>
                            <td>
                                <?php if($order->user): ?>
                                    <?php echo e($order->user->name); ?>

                                <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($order->driver): ?>
                                    <?php echo e($order->driver->name); ?>

                                <?php else: ?>
                                    <span class="text-muted"><?php echo e(__('messages.Not_Assigned')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($order->service): ?>
                                    <?php echo e($order->service->name_en); ?>

                                <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge <?php echo e($badgeClass); ?> px-3 py-2">
                                    <?php echo e(__(ucfirst(str_replace('_', ' ', $statusValue)))); ?>

                                </span>
                            </td>
                            <td><?php echo e($order->created_at->format('Y-m-d H:i')); ?></td>
                            <td>
                                <span class="badge badge-info px-3 py-2">
                                    <?php echo e($durationFormatted); ?>

                                </span>
                            </td>
                            <td>
                                <a href="<?php echo e(route('reports.order-status-detail', $order->id)); ?>" 
                                   class="btn btn-sm btn-primary" title="<?php echo e(__('messages.View_Details')); ?>">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('orders.show', $order->id)); ?>" 
                                   class="btn btn-sm btn-info" title="<?php echo e(__('messages.View_Order')); ?>">
                                    <i class="fas fa-receipt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p><?php echo e(__('messages.No_Orders_Found')); ?></p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-3">
                <?php echo e($orders->appends(request()->query())->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
.table td {
    vertical-align: middle;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/reports/order-status-history.blade.php ENDPATH**/ ?>