<?php $__env->startSection('title', __('messages.Edit_Order')); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $statusValue = is_object($order->status) ? $order->status->value : $order->status;
        $paymentMethod = is_object($order->payment_method) ? $order->payment_method->value : $order->payment_method;
        $paymentStatus = is_object($order->status_payment) ? $order->status_payment->value : $order->status_payment;
    ?>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?php echo e(__('messages.Edit_Order')); ?> #<?php echo e($order->id); ?></h1>
            <div>
                <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn btn-info">
                    <i class="fas fa-eye"></i> <?php echo e(__('messages.View')); ?>

                </a>
                <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> <?php echo e(__('messages.Back_to_List')); ?>

                </a>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo e(__('messages.Order_Details')); ?></h6>
            </div>
            <div class="card-body">
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('orders.update', $order->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <!-- Basic Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="m-0 font-weight-bold"><?php echo e(__('messages.Basic_Information')); ?></h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="number"><?php echo e(__('messages.Order_Number')); ?></label>
                                        <input type="text" class="form-control" id="number" name="number"
                                            value="<?php echo e(old('number', $order->number)); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="user_id"><?php echo e(__('messages.User')); ?> <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" id="user_id" name="user_id" required>
                                            <option value=""><?php echo e(__('messages.Select_User')); ?></option>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($user->id); ?>"
                                                    <?php echo e(old('user_id', $order->user_id) == $user->id ? 'selected' : ''); ?>>
                                                    <?php echo e($user->name); ?> (<?php echo e($user->phone); ?>)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="driver_id"><?php echo e(__('messages.Driver')); ?></label>
                                        <select class="form-control" id="driver_id" name="driver_id">
                                            <option value=""><?php echo e(__('messages.Select_Driver')); ?></option>
                                            <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($driver->id); ?>"
                                                    <?php echo e(old('driver_id', $order->driver_id) == $driver->id ? 'selected' : ''); ?>>
                                                    <?php echo e($driver->name); ?> (<?php echo e($driver->phone); ?>)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="service_id"><?php echo e(__('messages.Service')); ?> <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" id="service_id" name="service_id" required>
                                            <option value=""><?php echo e(__('messages.Select_Service')); ?></option>
                                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($service->id); ?>"
                                                    <?php echo e(old('service_id', $order->service_id) == $service->id ? 'selected' : ''); ?>>
                                                    <?php echo e($service->name_en); ?> (<?php echo e($service->name_ar); ?>)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="coupon_id"><?php echo e(__('messages.Coupon')); ?></label>
                                        <select class="form-control" id="coupon_id" name="coupon_id">
                                            <option value=""><?php echo e(__('messages.No_Coupon')); ?></option>
                                            <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($coupon->id); ?>"
                                                    <?php echo e(old('coupon_id', $order->coupon_id) == $coupon->id ? 'selected' : ''); ?>>
                                                    <?php echo e($coupon->code); ?> (<?php echo e($coupon->discount); ?>%)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="estimated_time"><?php echo e(__('messages.Estimated_Time')); ?></label>
                                        <input type="text" class="form-control" id="estimated_time" name="estimated_time"
                                            value="<?php echo e(old('estimated_time', $order->estimated_time)); ?>"
                                            placeholder="e.g., 15 mins">
                                    </div>
                                </div>
                            </div>

                            <!-- Status & Payment -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="m-0 font-weight-bold"><?php echo e(__('messages.Status_Payment')); ?></h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="status"><?php echo e(__('messages.Status')); ?> <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="pending"
                                                <?php echo e(old('status', $statusValue) == 'pending' ? 'selected' : ''); ?>>
                                                <?php echo e(__('messages.Pending')); ?></option>
                                            <option value="accepted"
                                                <?php echo e(old('status', $statusValue) == 'accepted' ? 'selected' : ''); ?>>
                                                <?php echo e(__('messages.Accepted')); ?></option>
                                            <option value="on_the_way"
                                                <?php echo e(old('status', $statusValue) == 'on_the_way' ? 'selected' : ''); ?>>
                                                <?php echo e(__('messages.On_The_Way')); ?></option>
                                            <option value="arrived"
                                                <?php echo e(old('status', $statusValue) == 'arrived' ? 'selected' : ''); ?>>
                                                <?php echo e(__('messages.Arrived')); ?></option>
                                            <option value="started"
                                                <?php echo e(old('status', $statusValue) == 'started' ? 'selected' : ''); ?>>
                                                <?php echo e(__('messages.Started')); ?></option>
                                            <option value="waiting_payment"
                                                <?php echo e(old('status', $statusValue) == 'waiting_payment' ? 'selected' : ''); ?>>
                                                <?php echo e(__('messages.Waiting_Payment')); ?></option>
                                            <option value="completed"
                                                <?php echo e(old('status', $statusValue) == 'completed' ? 'selected' : ''); ?>>
                                                <?php echo e(__('messages.Completed')); ?></option>
                                            <option value="user_cancel_order"
                                                <?php echo e(old('status', $statusValue) == 'user_cancel_order' ? 'selected' : ''); ?>>
                                                <?php echo e(__('messages.User_Cancelled')); ?></option>
                                            <option value="driver_cancel_order"
                                                <?php echo e(old('status', $statusValue) == 'driver_cancel_order' ? 'selected' : ''); ?>>
                                                <?php echo e(__('messages.Driver_Cancelled')); ?></option>
                                            <option value="cancel_cron_job"
                                                <?php echo e(old('status', $statusValue) == 'cancel_cron_job' ? 'selected' : ''); ?>>
                                                <?php echo e(__('messages.Cancelled_Auto')); ?></option>
                                        </select>
                                    </div>

                                    <div class="form-group cancel-reason-container"
                                        style="display: <?php echo e(in_array($statusValue, ['user_cancel_order', 'driver_cancel_order', 'cancel_cron_job']) ? 'block' : 'none'); ?>;">
                                        <label for="reason_for_cancel"><?php echo e(__('messages.Cancellation_Reason')); ?></label>
                                        <textarea class="form-control" id="reason_for_cancel" name="reason_for_cancel" rows="2"><?php echo e(old('reason_for_cancel', $order->reason_for_cancel)); ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="payment_method"><?php echo e(__('messages.Payment_Method')); ?> <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" id="payment_method" name="payment_method" required>
                                            <option value="cash"
                                                <?php echo e(old('payment_method', $order->payment_method) == 'cash' ? 'selected' : ''); ?>>
                                                <?php echo e(__('messages.Cash')); ?></option>
                                            <option value="visa"
                                                <?php echo e(old('payment_method', $order->payment_method) == 'visa' ? 'selected' : ''); ?>>
                                                <?php echo e(__('messages.Visa')); ?></option>
                                            <option value="wallet"
                                                <?php echo e(old('payment_method', $order->payment_method) == 'wallet' ? 'selected' : ''); ?>>
                                                <?php echo e(__('messages.Wallet')); ?></option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="status_payment"><?php echo e(__('messages.Payment_Status')); ?> <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" id="status_payment" name="status_payment" required>
                                            <option value="pending"
                                                <?php echo e(old('status_payment', $paymentStatus) == 'pending' ? 'selected' : ''); ?>>
                                                <?php echo e(__('messages.Pending')); ?></option>
                                            <option value="paid"
                                                <?php echo e(old('status_payment', $paymentStatus) == 'paid' ? 'selected' : ''); ?>>
                                                <?php echo e(__('messages.Paid')); ?></option>
                                        </select>
                                    </div>

                                    <!-- Hybrid Payment Section -->
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="is_hybrid_payment"
                                                name="is_hybrid_payment"
                                                <?php echo e(old('is_hybrid_payment', $order->is_hybrid_payment) ? 'checked' : ''); ?>>
                                            <label class="custom-control-label" for="is_hybrid_payment">
                                                <?php echo e(__('messages.Hybrid_Payment')); ?>

                                            </label>
                                        </div>
                                    </div>

                                    <div id="hybrid-payment-fields"
                                        style="display: <?php echo e(old('is_hybrid_payment', $order->is_hybrid_payment) ? 'block' : 'none'); ?>;">
                                        <div class="form-group">
                                            <label
                                                for="wallet_amount_used"><?php echo e(__('messages.Wallet_Amount_Used')); ?></label>
                                            <input type="number" step="0.01" class="form-control"
                                                id="wallet_amount_used" name="wallet_amount_used"
                                                value="<?php echo e(old('wallet_amount_used', $order->wallet_amount_used)); ?>"
                                                min="0">
                                        </div>

                                        <div class="form-group">
                                            <label for="cash_amount_due"><?php echo e(__('messages.Cash_Amount_Due')); ?></label>
                                            <input type="number" step="0.01" class="form-control"
                                                id="cash_amount_due" name="cash_amount_due"
                                                value="<?php echo e(old('cash_amount_due', $order->cash_amount_due)); ?>"
                                                min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Trip Tracking -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="m-0 font-weight-bold text-success"><?php echo e(__('messages.Trip_Tracking')); ?></h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="trip_started_at"><?php echo e(__('messages.Trip_Started_At')); ?></label>
                                        <input type="datetime-local" class="form-control" id="trip_started_at"
                                            name="trip_started_at"
                                            value="<?php echo e(old('trip_started_at', $order->trip_started_at ? $order->trip_started_at->format('Y-m-d\TH:i') : '')); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="trip_completed_at"><?php echo e(__('messages.Trip_Completed_At')); ?></label>
                                        <input type="datetime-local" class="form-control" id="trip_completed_at"
                                            name="trip_completed_at"
                                            value="<?php echo e(old('trip_completed_at', $order->trip_completed_at ? $order->trip_completed_at->format('Y-m-d\TH:i') : '')); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="actual_trip_duration_minutes"><?php echo e(__('messages.Actual_Duration_Minutes')); ?></label>
                                        <input type="number" step="0.01" class="form-control"
                                            id="actual_trip_duration_minutes" name="actual_trip_duration_minutes"
                                            value="<?php echo e(old('actual_trip_duration_minutes', $order->actual_trip_duration_minutes)); ?>"
                                            min="0">
                                    </div>

                                    <div class="form-group">
                                        <label for="live_distance"><?php echo e(__('messages.Live_Distance_KM')); ?></label>
                                        <input type="number" step="0.01" class="form-control" id="live_distance"
                                            name="live_distance"
                                            value="<?php echo e(old('live_distance', $order->live_distance)); ?>" min="0">
                                    </div>

                                    <div class="form-group">
                                        <label for="returned_amount"><?php echo e(__('messages.Returned_Amount')); ?></label>
                                        <input type="number" step="0.01" class="form-control" id="returned_amount"
                                            name="returned_amount"
                                            value="<?php echo e(old('returned_amount', $order->returned_amount)); ?>" min="0">
                                        <small
                                            class="form-text text-muted"><?php echo e(__('messages.Returned_Amount_Info')); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Location Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="m-0 font-weight-bold"><?php echo e(__('messages.Pickup_Location')); ?></h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="pick_name"><?php echo e(__('messages.Pickup_Name')); ?> <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="pick_name" name="pick_name"
                                            value="<?php echo e(old('pick_name', $order->pick_name)); ?>" required>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pick_lat"><?php echo e(__('messages.Latitude')); ?> <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" step="any" class="form-control" id="pick_lat"
                                                    name="pick_lat" value="<?php echo e(old('pick_lat', $order->pick_lat)); ?>"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pick_lng"><?php echo e(__('messages.Longitude')); ?> <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" step="any" class="form-control" id="pick_lng"
                                                    name="pick_lng" value="<?php echo e(old('pick_lng', $order->pick_lng)); ?>"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="m-0 font-weight-bold"><?php echo e(__('messages.Dropoff_Location')); ?></h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="drop_name"><?php echo e(__('messages.Dropoff_Name')); ?></label>
                                        <input type="text" class="form-control" id="drop_name" name="drop_name"
                                            value="<?php echo e(old('drop_name', $order->drop_name)); ?>">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="drop_lat"><?php echo e(__('messages.Latitude')); ?></label>
                                                <input type="number" step="any" class="form-control" id="drop_lat"
                                                    name="drop_lat" value="<?php echo e(old('drop_lat', $order->drop_lat)); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="drop_lng"><?php echo e(__('messages.Longitude')); ?></label>
                                                <input type="number" step="any" class="form-control" id="drop_lng"
                                                    name="drop_lng" value="<?php echo e(old('drop_lng', $order->drop_lng)); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="m-0 font-weight-bold"><?php echo e(__('messages.Pricing_Details')); ?></h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label
                                                    for="total_price_before_discount"><?php echo e(__('messages.Original_Price')); ?>

                                                    <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" class="form-control"
                                                    id="total_price_before_discount" name="total_price_before_discount"
                                                    value="<?php echo e(old('total_price_before_discount', $order->total_price_before_discount)); ?>"
                                                    required min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="discount_value"><?php echo e(__('messages.Discount')); ?></label>
                                                <input type="number" step="0.01" class="form-control"
                                                    id="discount_value" name="discount_value"
                                                    value="<?php echo e(old('discount_value', $order->discount_value)); ?>"
                                                    min="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="total_price_after_discount"><?php echo e(__('messages.Final_Price')); ?>

                                                    <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" class="form-control"
                                                    id="total_price_after_discount" name="total_price_after_discount"
                                                    value="<?php echo e(old('total_price_after_discount', $order->total_price_after_discount)); ?>"
                                                    required min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="commision_of_admin"><?php echo e(__('messages.Admin_Commission')); ?>

                                                    <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" class="form-control"
                                                    id="commision_of_admin" name="commision_of_admin"
                                                    value="<?php echo e(old('commision_of_admin', $order->commision_of_admin)); ?>"
                                                    required min="0">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="net_price_for_driver"><?php echo e(__('messages.Driver_Earning')); ?> <span
                                                class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control"
                                            id="net_price_for_driver" name="net_price_for_driver"
                                            value="<?php echo e(old('net_price_for_driver', $order->net_price_for_driver)); ?>"
                                            required min="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Waiting Charges Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="m-0 font-weight-bold text-info">
                                        <i class="fas fa-clock"></i> <?php echo e(__('messages.Waiting_Charges_Details')); ?>

                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="arrived_at"><?php echo e(__('messages.Arrived_At')); ?></label>
                                                <input type="datetime-local" class="form-control" id="arrived_at"
                                                    name="arrived_at"
                                                    value="<?php echo e(old('arrived_at', $order->arrived_at ? $order->arrived_at->format('Y-m-d\TH:i') : '')); ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label
                                                    for="total_waiting_minutes"><?php echo e(__('messages.Total_Waiting_Minutes')); ?></label>
                                                <input type="number" class="form-control" id="total_waiting_minutes"
                                                    name="total_waiting_minutes"
                                                    value="<?php echo e(old('total_waiting_minutes', $order->total_waiting_minutes)); ?>"
                                                    min="0">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="waiting_charges"><?php echo e(__('messages.Waiting_Charges')); ?></label>
                                                <input type="number" step="0.01" class="form-control"
                                                    id="waiting_charges" name="waiting_charges"
                                                    value="<?php echo e(old('waiting_charges', $order->waiting_charges)); ?>"
                                                    min="0">
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="my-3">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label
                                                    for="in_trip_waiting_minutes"><?php echo e(__('messages.In_Trip_Waiting_Minutes')); ?></label>
                                                <input type="number" class="form-control" id="in_trip_waiting_minutes"
                                                    name="in_trip_waiting_minutes"
                                                    value="<?php echo e(old('in_trip_waiting_minutes', $order->in_trip_waiting_minutes)); ?>"
                                                    min="0">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label
                                                    for="in_trip_waiting_charges"><?php echo e(__('messages.In_Trip_Waiting_Charges')); ?></label>
                                                <input type="number" step="0.01" class="form-control"
                                                    id="in_trip_waiting_charges" name="in_trip_waiting_charges"
                                                    value="<?php echo e(old('in_trip_waiting_charges', $order->in_trip_waiting_charges)); ?>"
                                                    min="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="map" style="height: 200px; width: 100%; margin-bottom: 20px;"></div>
                        </div>
                    </div>

                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> <?php echo e(__('messages.Update')); ?>

                        </button>
                        <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> <?php echo e(__('messages.Cancel')); ?>

                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        $(document).ready(function() {
            // Show/hide cancellation reason field based on status
            $('#status').on('change', function() {
                var status = $(this).val();
                if (['user_cancel_order', 'driver_cancel_order', 'cancel_cron_job'].includes(status)) {
                    $('.cancel-reason-container').show();
                    $('#reason_for_cancel').prop('required', true);
                } else {
                    $('.cancel-reason-container').hide();
                    $('#reason_for_cancel').prop('required', false);
                }
            });

            // Show/hide hybrid payment fields
            $('#is_hybrid_payment').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#hybrid-payment-fields').slideDown();
                } else {
                    $('#hybrid-payment-fields').slideUp();
                    $('#wallet_amount_used').val(0);
                    $('#cash_amount_due').val(0);
                }
            });

            // Calculate final price when discount changes
            $('#discount_value').on('input', function() {
                calculatePrices();
            });

            $('#total_price_before_discount').on('input', function() {
                calculatePrices();
            });
        });

        function calculatePrices() {
            var totalBeforeDiscount = parseFloat($('#total_price_before_discount').val()) || 0;
            var discount = parseFloat($('#discount_value').val()) || 0;

            if (discount > totalBeforeDiscount) {
                alert("<?php echo e(__('messages.Discount_Too_High')); ?>");
                $('#discount_value').val(0);
                discount = 0;
            }

            var totalAfterDiscount = totalBeforeDiscount - discount;
            $('#total_price_after_discount').val(totalAfterDiscount.toFixed(2));
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/admin/orders/edit.blade.php ENDPATH**/ ?>