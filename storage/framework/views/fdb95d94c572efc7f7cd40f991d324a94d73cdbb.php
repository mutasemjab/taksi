<?php $__env->startSection('title', __('messages.View_Order')); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <?php echo e(__('messages.View_Order')); ?> #<?php echo e($order->id); ?>

                <?php if($order->number): ?>
                    <small class="text-muted">(<?php echo e($order->number); ?>)</small>
                <?php endif; ?>
            </h1>
            <div>
                <a href="<?php echo e(route('orders.edit', $order->id)); ?>" class="btn btn-primary">
                    <i class="fas fa-edit"></i> <?php echo e(__('messages.Edit')); ?>

                </a>
                <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> <?php echo e(__('messages.Back_to_List')); ?>

                </a>
            </div>
        </div>

        <!-- Hybrid Payment Alert -->
        <?php if($order->is_hybrid_payment): ?>
            <div class="alert alert-info">
                <h5><i class="fas fa-wallet"></i> <?php echo e(__('messages.Hybrid_Payment')); ?></h5>
                <div class="row">
                    <div class="col-md-6">
                        <strong><?php echo e(__('messages.Wallet_Amount_Used')); ?>:</strong> JD <?php echo e(number_format($order->wallet_amount_used, 2)); ?>

                    </div>
                    <div class="col-md-6">
                        <strong><?php echo e(__('messages.Cash_Amount_Due')); ?>:</strong> JD <?php echo e(number_format($order->cash_amount_due, 2)); ?>

                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Order Status Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo e(__('messages.Order_Status')); ?></h6>
                <div>
                    <?php
                        $statusValue = is_object($order->status) ? $order->status->value : $order->status;
                    ?>
                    <span
                        class="badge badge-lg px-3 py-2
                    <?php if($statusValue == 'completed'): ?> badge-success
                    <?php elseif(in_array($statusValue, ['user_cancel_order', 'driver_cancel_order', 'cancel_cron_job'])): ?> badge-danger
                    <?php elseif($statusValue == 'waiting_payment'): ?> badge-warning
                    <?php else: ?> badge-info <?php endif; ?>">
                        <?php echo e(__(ucfirst(str_replace('_', ' ', $statusValue)))); ?>

                    </span>
                </div>
            </div>
            <div class="card-body">
                <?php
                    $statusValue = is_object($order->status) ? $order->status->value : $order->status;
                    $paymentMethod = is_object($order->payment_method)
                        ? $order->payment_method->value
                        : $order->payment_method;
                    $paymentStatus = is_object($order->status_payment)
                        ? $order->status_payment->value
                        : $order->status_payment;
                ?>
                <div class="row">
                    <div class="col-md-8">
                        <!-- Status Timeline -->
                        <div class="timeline">
                            <div class="timeline-item <?php echo e($statusValue == 'pending' ? 'active' : 'completed'); ?>">
                                <i class="fas fa-clock"></i> <?php echo e(__('messages.Pending')); ?>

                            </div>
                            <div
                                class="timeline-item <?php echo e(in_array($statusValue, ['accepted', 'on_the_way', 'arrived', 'started', 'waiting_payment', 'completed']) ? 'completed' : ''); ?>">
                                <i class="fas fa-check"></i> <?php echo e(__('messages.Accepted')); ?>

                            </div>
                            <div
                                class="timeline-item <?php echo e(in_array($statusValue, ['on_the_way', 'arrived', 'started', 'waiting_payment', 'completed']) ? 'completed' : ''); ?>">
                                <i class="fas fa-car"></i> <?php echo e(__('messages.On_The_Way')); ?>

                            </div>
                            <div
                                class="timeline-item <?php echo e(in_array($statusValue, ['arrived', 'started', 'waiting_payment', 'completed']) ? 'completed' : ''); ?>">
                                <i class="fas fa-map-marker-alt"></i> <?php echo e(__('messages.Arrived')); ?>

                            </div>
                            <div
                                class="timeline-item <?php echo e(in_array($statusValue, ['started', 'waiting_payment', 'completed']) ? 'completed' : ''); ?>">
                                <i class="fas fa-play"></i> <?php echo e(__('messages.Started')); ?>

                            </div>
                            <div
                                class="timeline-item <?php echo e(in_array($statusValue, ['waiting_payment', 'completed']) ? 'completed' : ''); ?>">
                                <i class="fas fa-credit-card"></i> <?php echo e(__('messages.Waiting_Payment')); ?>

                            </div>
                            <div class="timeline-item <?php echo e($statusValue == 'completed' ? 'completed' : ''); ?>">
                                <i class="fas fa-flag-checkered"></i> <?php echo e(__('messages.Completed')); ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <!-- Update Status Form -->
                        <form action="<?php echo e(route('orders.updateStatus', $order->id)); ?>" method="POST" class="w-100">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <label for="status"><?php echo e(__('messages.Change_Status')); ?></label>
                                <select class="form-control" id="status" name="status">
                                    <option value="pending" <?php echo e($statusValue == 'pending' ? 'selected' : ''); ?>>
                                        <?php echo e(__('messages.Pending')); ?></option>
                                    <option value="accepted" <?php echo e($statusValue == 'accepted' ? 'selected' : ''); ?>>
                                        <?php echo e(__('messages.Accepted')); ?></option>
                                    <option value="on_the_way" <?php echo e($statusValue == 'on_the_way' ? 'selected' : ''); ?>>
                                        <?php echo e(__('messages.On_The_Way')); ?></option>
                                    <option value="arrived" <?php echo e($statusValue == 'arrived' ? 'selected' : ''); ?>>
                                        <?php echo e(__('messages.Arrived')); ?></option>
                                    <option value="started" <?php echo e($statusValue == 'started' ? 'selected' : ''); ?>>
                                        <?php echo e(__('messages.Started')); ?></option>
                                    <option value="waiting_payment"
                                        <?php echo e($statusValue == 'waiting_payment' ? 'selected' : ''); ?>>
                                        <?php echo e(__('messages.Waiting_Payment')); ?></option>
                                    <option value="completed" <?php echo e($statusValue == 'completed' ? 'selected' : ''); ?>>
                                        <?php echo e(__('messages.Completed')); ?></option>
                                    <option value="user_cancel_order"
                                        <?php echo e($statusValue == 'user_cancel_order' ? 'selected' : ''); ?>>
                                        <?php echo e(__('messages.User_Cancelled')); ?></option>
                                    <option value="driver_cancel_order"
                                        <?php echo e($statusValue == 'driver_cancel_order' ? 'selected' : ''); ?>>
                                        <?php echo e(__('messages.Driver_Cancelled')); ?></option>
                                    <option value="cancel_cron_job"
                                        <?php echo e($statusValue == 'cancel_cron_job' ? 'selected' : ''); ?>>
                                        <?php echo e(__('messages.Cancelled_Auto')); ?></option>
                                </select>
                            </div>
                            <div class="form-group cancel-reason-container"
                                style="display: <?php echo e(in_array($statusValue, ['user_cancel_order', 'driver_cancel_order', 'cancel_cron_job']) ? 'block' : 'none'); ?>;">
                                <label for="reason_for_cancel"><?php echo e(__('messages.Cancellation_Reason')); ?></label>
                                <textarea class="form-control" id="reason_for_cancel" name="reason_for_cancel" rows="2"><?php echo e($order->reason_for_cancel); ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save"></i> <?php echo e(__('messages.Update_Status')); ?>

                            </button>
                        </form>
                    </div>
                </div>

                <?php if(in_array($statusValue, ['user_cancel_order', 'driver_cancel_order', 'cancel_cron_job']) &&
                        $order->reason_for_cancel): ?>
                    <div class="alert alert-danger mt-3">
                        <strong><?php echo e(__('messages.Cancellation_Reason')); ?>:</strong> <?php echo e($order->reason_for_cancel); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Trip Tracking Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-route"></i> <?php echo e(__('messages.Trip_Tracking')); ?>

                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card bg-light mb-3">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-2"><?php echo e(__('messages.Estimated_Time')); ?></h6>
                                <h4 class="mb-0"><?php echo e($order->estimated_time ?? 'N/A'); ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light mb-3">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-2"><?php echo e(__('messages.Live_Distance')); ?></h6>
                                <h4 class="mb-0"><?php echo e(number_format($order->live_distance, 2)); ?> <?php echo e(__('messages.KM')); ?>

                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light mb-3">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-2"><?php echo e(__('messages.Actual_Duration')); ?></h6>
                                <h4 class="mb-0"><?php echo e($order->actual_trip_duration_minutes ?? 'N/A'); ?>

                                    <?php echo e(__('messages.Minutes')); ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light mb-3">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-2"><?php echo e(__('messages.Returned_Amount')); ?></h6>
                                <h4 class="mb-0 text-success"><?php echo e(number_format($order->returned_amount ?? 0, 2)); ?>

                                    <?php echo e(__('messages.JD')); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th width="30%"><?php echo e(__('messages.Trip_Started_At')); ?></th>
                                <td><?php echo e($order->trip_started_at ? $order->trip_started_at->format('Y-m-d H:i:s') : __('messages.Not_Started')); ?>

                                </td>
                            </tr>
                            <tr>
                                <th><?php echo e(__('messages.Trip_Completed_At')); ?></th>
                                <td><?php echo e($order->trip_completed_at ? $order->trip_completed_at->format('Y-m-d H:i:s') : __('messages.Not_Completed')); ?>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Waiting Charges Details Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fas fa-clock"></i> <?php echo e(__('messages.Waiting_Charges_Details')); ?>

                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="font-weight-bold text-primary mb-3">
                            <i class="fas fa-user-clock"></i> <?php echo e(__('messages.Pre_Trip_Waiting')); ?>

                        </h6>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="50%"><?php echo e(__('messages.Arrived_At')); ?></th>
                                        <td>
                                            <?php if($order->arrived_at): ?>
                                                <?php echo e($order->arrived_at->format('Y-m-d H:i:s')); ?>

                                            <?php else: ?>
                                                <span class="text-muted"><?php echo e(__('messages.Not_Set')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo e(__('messages.Total_Waiting_Minutes')); ?></th>
                                        <td>
                                            <span class="badge badge-info px-3 py-2">
                                                <?php echo e($order->total_waiting_minutes); ?> <?php echo e(__('messages.Minutes')); ?>

                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo e(__('messages.Waiting_Charges')); ?></th>
                                        <td>
                                            <span class="badge badge-success px-3 py-2">
                                                <?php echo e(number_format($order->waiting_charges, 2)); ?> <?php echo e(__('messages.JD')); ?>

                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6 class="font-weight-bold text-warning mb-3">
                            <i class="fas fa-traffic-light"></i> <?php echo e(__('messages.In_Trip_Waiting')); ?>

                        </h6>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="50%"><?php echo e(__('messages.In_Trip_Waiting_Minutes')); ?></th>
                                        <td>
                                            <span class="badge badge-warning px-3 py-2">
                                                <?php echo e($order->in_trip_waiting_minutes); ?> <?php echo e(__('messages.Minutes')); ?>

                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo e(__('messages.In_Trip_Waiting_Charges')); ?></th>
                                        <td>
                                            <span class="badge badge-success px-3 py-2">
                                                <?php echo e(number_format($order->in_trip_waiting_charges, 2)); ?>

                                                <?php echo e(__('messages.JD')); ?>

                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo e(__('messages.Total_Waiting_Charges')); ?></th>
                                        <td>
                                            <span class="badge badge-primary px-3 py-2">
                                                <?php echo e(number_format($order->waiting_charges + $order->in_trip_waiting_charges, 2)); ?>

                                                <?php echo e(__('messages.JD')); ?>

                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rating Card -->
        <?php if($order->rating): ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-star"></i> <?php echo e(__('messages.Rating')); ?>

                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5><?php echo e(__('messages.Rating_Score')); ?></h5>
                        <div class="mb-3">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <?php if($i <= $order->rating->rating): ?>
                                <i class="fas fa-star text-warning fa-2x"></i>
                                <?php else: ?>
                                <i class="far fa-star text-muted fa-2x"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <span class="ml-2 h4"><?php echo e($order->rating->rating); ?>/5</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5><?php echo e(__('messages.Review')); ?></h5>
                        <p class="text-muted">
                            <?php echo e($order->rating->review ?? __('messages.No_Review')); ?>

                        </p>
                        <small class="text-muted">
                            <i class="fas fa-clock"></i> <?php echo e($order->rating->created_at->format('Y-m-d H:i:s')); ?>

                        </small>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Complaints Card -->
        <?php if($order->complaints->count() > 0): ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo e(__('messages.Complaints')); ?> (<?php echo e($order->complaints->count()); ?>)
                </h6>
            </div>
            <div class="card-body">
                <?php $__currentLoopData = $order->complaints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $complaint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card mb-3 border-left-danger">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="font-weight-bold"><?php echo e($complaint->subject); ?></h5>
                                <p class="text-muted mb-2"><?php echo e($complaint->description); ?></p>
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> <?php echo e($complaint->created_at->format('Y-m-d H:i:s')); ?>

                                </small>
                            </div>
                            <div class="col-md-4 text-right">
                                <?php
                                    $statusLabels = [
                                        1 => ['label' => __('messages.Pending'), 'class' => 'warning'],
                                        2 => ['label' => __('messages.In_Progress'), 'class' => 'info'],
                                        3 => ['label' => __('messages.Resolved'), 'class' => 'success'],
                                    ];
                                    $statusInfo = $statusLabels[$complaint->status] ?? ['label' => __('messages.Unknown'), 'class' => 'secondary'];
                                ?>
                                <span class="badge badge-<?php echo e($statusInfo['class']); ?> px-3 py-2">
                                    <?php echo e($statusInfo['label']); ?>

                                </span>
                                <br><br>
                                <?php if($complaint->user_id): ?>
                                    <small class="text-muted">
                                        <?php echo e(__('messages.By_User')); ?>: <?php echo e($complaint->user->name ?? 'N/A'); ?>

                                    </small>
                                <?php elseif($complaint->driver_id): ?>
                                    <small class="text-muted">
                                        <?php echo e(__('messages.By_Driver')); ?>: <?php echo e($complaint->driver->name ?? 'N/A'); ?>

                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-8">
                <!-- Order Details Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?php echo e(__('messages.Order_Details')); ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="font-weight-bold"><?php echo e(__('messages.Pickup_Location')); ?></h5>
                                <p><?php echo e($order->pick_name); ?></p>
                                <small class="text-muted"><?php echo e(__('messages.Coordinates')); ?>: <?php echo e($order->pick_lat); ?>,
                                    <?php echo e($order->pick_lng); ?></small>
                            </div>
                            <div class="col-md-6">
                                <h5 class="font-weight-bold"><?php echo e(__('messages.Dropoff_Location')); ?></h5>
                                <p><?php echo e($order->drop_name ?? __('messages.Not_Set')); ?></p>
                                <?php if($order->drop_lat && $order->drop_lng): ?>
                                    <small class="text-muted"><?php echo e(__('messages.Coordinates')); ?>: <?php echo e($order->drop_lat); ?>,
                                        <?php echo e($order->drop_lng); ?></small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="30%"><?php echo e(__('messages.ID')); ?></th>
                                        <td><?php echo e($order->id); ?></td>
                                    </tr>
                                    <?php if($order->number): ?>
                                        <tr>
                                            <th><?php echo e(__('messages.Order_Number')); ?></th>
                                            <td><span class="badge badge-primary"><?php echo e($order->number); ?></span></td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <th><?php echo e(__('messages.Service')); ?></th>
                                        <td>
                                            <?php if($order->service): ?>
                                                <a href="<?php echo e(route('services.show', $order->service_id)); ?>">
                                                    <?php echo e($order->service->name_en); ?> (<?php echo e($order->service->name_ar); ?>)
                                                </a>
                                            <?php else: ?>
                                                <?php echo e(__('messages.Not_Available')); ?>

                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php if($order->coupon): ?>
                                        <tr>
                                            <th><?php echo e(__('messages.Coupon')); ?></th>
                                            <td>
                                                <span class="badge badge-success"><?php echo e($order->coupon->code); ?></span>
                                                (<?php echo e($order->coupon->discount); ?>% <?php echo e(__('messages.Discount')); ?>)
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <th><?php echo e(__('messages.Created_At')); ?></th>
                                        <td><?php echo e($order->created_at->format('Y-m-d H:i:s')); ?></td>
                                    </tr>
                                    <tr>
                                        <th><?php echo e(__('messages.Updated_At')); ?></th>
                                        <td><?php echo e($order->updated_at->format('Y-m-d H:i:s')); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pricing Details Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?php echo e(__('messages.Pricing_Details')); ?></h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-8">
                                                <h6 class="card-title mb-0"><?php echo e(__('messages.Original_Price')); ?></h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <h6 class="mb-0">
                                                    <?php echo e(number_format($order->total_price_before_discount, 2)); ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php if($order->discount_value > 0): ?>
                                    <div class="card mb-3 bg-light">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-8">
                                                    <h6 class="card-title mb-0 text-success">
                                                        <?php echo e(__('messages.Discount')); ?></h6>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <h6 class="mb-0 text-success">
                                                        -<?php echo e(number_format($order->discount_value, 2)); ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="card mb-3 bg-primary text-white">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-8">
                                                <h6 class="card-title mb-0"><?php echo e(__('messages.Final_Price')); ?></h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <h6 class="mb-0">
                                                    <?php echo e(number_format($order->total_price_after_discount, 2)); ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-8">
                                                <h6 class="card-title mb-0"><?php echo e(__('messages.Driver_Earning')); ?></h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <h6 class="mb-0"><?php echo e(number_format($order->net_price_for_driver, 2)); ?>

                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-8">
                                                <h6 class="card-title mb-0"><?php echo e(__('messages.Admin_Commission')); ?></h6>
                                            </div>
                                            <div class="col-4 text-right">
                                                <h6 class="mb-0"><?php echo e(number_format($order->commision_of_admin, 2)); ?>

                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong><?php echo e(__('messages.Payment_Method')); ?></strong>
                                                <div class="mt-1">
                                                    <span class="badge badge-primary px-3 py-2">
                                                        <?php echo e(__(ucfirst($paymentMethod))); ?>

                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <strong><?php echo e(__('messages.Payment_Status')); ?></strong>
                                                <div class="mt-1">
                                                    <span
                                                        class="badge px-3 py-2 <?php echo e($paymentStatus == 'paid' ? 'badge-success' : 'badge-warning'); ?>">
                                                        <?php echo e(__(ucfirst($paymentStatus))); ?>

                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <form action="<?php echo e(route('orders.updatePaymentStatus', $order->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <label for="status_payment"><?php echo e(__('messages.Update_Payment_Status')); ?></label>
                                    <select class="form-control" id="status_payment" name="status_payment">
                                        <option value="pending" <?php echo e($paymentStatus == 'pending' ? 'selected' : ''); ?>>
                                            <?php echo e(__('messages.Pending')); ?></option>
                                        <option value="paid" <?php echo e($paymentStatus == 'paid' ? 'selected' : ''); ?>>
                                            <?php echo e(__('messages.Paid')); ?></option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> <?php echo e(__('messages.Update_Payment_Status')); ?>

                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- User Information -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?php echo e(__('messages.User_Information')); ?></h6>
                    </div>
                    <div class="card-body">
                        <?php if($order->user): ?>
                            <div class="text-center mb-3">
                                <?php if($order->user->photo): ?>
                                    <img src="<?php echo e(asset('assets/admin/uploads/' . $order->user->photo)); ?>"
                                        alt="<?php echo e($order->user->name); ?>" class="img-profile rounded-circle mb-3"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                <?php else: ?>
                                    <img src="<?php echo e(asset('assets/admin/img/undraw_profile.svg')); ?>" alt="No Image"
                                        class="img-profile rounded-circle mb-3"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                <?php endif; ?>
                                <h5><?php echo e($order->user->name); ?></h5>
                            </div>

                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo e(__('messages.Phone')); ?>

                                    <span><?php echo e($order->user->phone); ?></span>
                                </li>
                                <?php if($order->user->email): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?php echo e(__('messages.Email')); ?>

                                        <span><?php echo e($order->user->email); ?></span>
                                    </li>
                                <?php endif; ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo e(__('messages.Wallet_Balance')); ?>

                                    <span
                                        class="badge badge-primary px-3 py-2"><?php echo e(number_format($order->user->balance, 2)); ?></span>
                                </li>
                            </ul>

                            <div class="d-flex justify-content-between">
                                <a href="<?php echo e(route('users.show', $order->user_id)); ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-user"></i> <?php echo e(__('messages.View_Profile')); ?>

                                </a>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <?php echo e(__('messages.User_Not_Available')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Driver Information -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><?php echo e(__('messages.Driver_Information')); ?></h6>
                    </div>
                    <div class="card-body">
                        <?php if($order->driver): ?>
                            <div class="text-center mb-3">
                                <?php if($order->driver->photo): ?>
                                    <img src="<?php echo e(asset('assets/admin/uploads/' . $order->driver->photo)); ?>"
                                        alt="<?php echo e($order->driver->name); ?>" class="img-profile rounded-circle mb-3"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                <?php else: ?>
                                    <img src="<?php echo e(asset('assets/admin/img/undraw_profile.svg')); ?>" alt="No Image"
                                        class="img-profile rounded-circle mb-3"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                <?php endif; ?>
                                <h5><?php echo e($order->driver->name); ?></h5>
                            </div>

                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo e(__('messages.Phone')); ?>

                                    <span><?php echo e($order->driver->phone); ?></span>
                                </li>
                                <?php if($order->driver->email): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?php echo e(__('messages.Email')); ?>

                                        <span><?php echo e($order->driver->email); ?></span>
                                    </li>
                                <?php endif; ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo e(__('messages.Wallet_Balance')); ?>

                                    <span
                                        class="badge badge-primary px-3 py-2"><?php echo e(number_format($order->driver->balance, 2)); ?></span>
                                </li>
                            </ul>

                            <div class="d-flex justify-content-between">
                                <a href="<?php echo e(route('drivers.show', $order->driver_id)); ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-user"></i> <?php echo e(__('messages.View_Profile')); ?>

                                </a>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <?php echo e(__('messages.No_Driver_Assigned')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        $(document).ready(function() {
            $('#status').on('change', function() {
                var status = $(this).val();
                if (['user_cancel_order', 'driver_cancel_order', 'cancel_cron_job'].includes(status)) {
                    $('.cancel-reason-container').show();
                } else {
                    $('.cancel-reason-container').hide();
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>