

<?php $__env->startSection('title', __('messages.Spam_Order_Details')); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-trash-alt"></i> <?php echo e(__('messages.Spam_Order_Details')); ?> #<?php echo e($spamOrder->id); ?>

        </h1>
        <div>
            <a href="<?php echo e(route('spam-orders.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> <?php echo e(__('messages.Back_to_List')); ?>

            </a>
            <form action="<?php echo e(route('spam-orders.destroy', $spamOrder->id)); ?>" 
                  method="POST" class="d-inline" 
                  onsubmit="return confirm('<?php echo e(__('messages.Confirm_Delete')); ?>');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> <?php echo e(__('messages.Delete_Permanently')); ?>

                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Order Status & Info Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-danger text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-ban"></i> <?php echo e(__('messages.Cancellation_Information')); ?>

                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="font-weight-bold text-danger"><?php echo e($spamOrder->getCancellationTypeText()); ?></h5>
                            <p class="text-muted mb-2">
                                <i class="fas fa-clock"></i> 
                                <?php echo e(__('messages.Cancelled_At')); ?>: 
                                <?php echo e($spamOrder->cancelled_at ? $spamOrder->cancelled_at->format('Y-m-d H:i:s') : 'N/A'); ?>

                            </p>
                            <?php if(isset($timeMetrics['time_to_cancel'])): ?>
                            <p class="text-muted mb-2">
                                <i class="fas fa-hourglass-half"></i> 
                                <?php echo e(__('messages.Time_Until_Cancel')); ?>: 
                                <?php echo e($timeMetrics['time_to_cancel_formatted']); ?>

                            </p>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-danger">
                                <h6 class="font-weight-bold"><?php echo e(__('messages.Cancellation_Reason')); ?>:</h6>
                                <p class="mb-0"><?php echo e($spamOrder->reason_for_cancel ?? __('messages.No_Reason_Provided')); ?></p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%"><?php echo e(__('messages.Order_Number')); ?></th>
                                    <td><span class="badge badge-secondary"><?php echo e($spamOrder->number); ?></span></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('messages.Service')); ?></th>
                                    <td>
                                        <?php if($spamOrder->service): ?>
                                            <?php echo e($spamOrder->service->name_en); ?> (<?php echo e($spamOrder->service->name_ar); ?>)
                                        <?php else: ?>
                                            <?php echo e(__('messages.Not_Available')); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('messages.Payment_Method')); ?></th>
                                    <td><?php echo e($spamOrder->getPaymentMethodText()); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(__('messages.Payment_Status')); ?></th>
                                    <td>
                                        <span class="badge badge-<?php echo e($spamOrder->status_payment == 'paid' ? 'success' : 'warning'); ?>">
                                            <?php echo e($spamOrder->getPaymentStatusText()); ?>

                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Location Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-map-marker-alt"></i> <?php echo e(__('messages.Location_Information')); ?>

                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-success"><?php echo e(__('messages.Pickup_Location')); ?></h6>
                            <p class="mb-1"><?php echo e($spamOrder->pick_name); ?></p>
                            <small class="text-muted">
                                <?php echo e(__('messages.Coordinates')); ?>: <?php echo e($spamOrder->pick_lat); ?>, <?php echo e($spamOrder->pick_lng); ?>

                            </small>
                        </div>
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-danger"><?php echo e(__('messages.Dropoff_Location')); ?></h6>
                            <p class="mb-1"><?php echo e($spamOrder->drop_name ?? __('messages.Not_Set')); ?></p>
                            <?php if($spamOrder->drop_lat && $spamOrder->drop_lng): ?>
                                <small class="text-muted">
                                    <?php echo e(__('messages.Coordinates')); ?>: <?php echo e($spamOrder->drop_lat); ?>, <?php echo e($spamOrder->drop_lng); ?>

                                </small>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if($spamOrder->drop_lat && $spamOrder->drop_lng): ?>
                    <div class="mt-3">
                        <span class="badge badge-info">
                            <?php echo e(__('messages.Distance')); ?>: <?php echo e($spamOrder->getDistance()); ?> KM
                        </span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Pricing Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-dollar-sign"></i> <?php echo e(__('messages.Pricing_Details')); ?>

                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-light mb-3">
                                <div class="card-body text-center">
                                    <h6 class="text-muted mb-2"><?php echo e(__('messages.Original_Price')); ?></h6>
                                    <h4 class="mb-0"><?php echo e(number_format($spamOrder->total_price_before_discount, 2)); ?> JD</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light mb-3">
                                <div class="card-body text-center">
                                    <h6 class="text-muted mb-2"><?php echo e(__('messages.Final_Price')); ?></h6>
                                    <h4 class="mb-0 text-primary"><?php echo e(number_format($spamOrder->total_price_after_discount, 2)); ?> JD</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light mb-3">
                                <div class="card-body text-center">
                                    <h6 class="text-muted mb-2"><?php echo e(__('messages.Admin_Commission')); ?></h6>
                                    <h4 class="mb-0"><?php echo e(number_format($spamOrder->commision_of_admin, 2)); ?> JD</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Driver Tracking Statistics Card -->
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie"></i> <?php echo e(__('messages.Driver_Statistics')); ?>

                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <h2 class="text-primary"><?php echo e($stats['total_notified']); ?></h2>
                                <small class="text-muted"><?php echo e(__('messages.Total_Notified')); ?></small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <h2 class="text-danger"><?php echo e($stats['total_rejected']); ?></h2>
                                <small class="text-muted"><?php echo e(__('messages.Rejected')); ?></small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <h2 class="text-warning"><?php echo e($stats['no_response']); ?></h2>
                                <small class="text-muted"><?php echo e(__('messages.No_Response')); ?></small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <h2 class="text-success"><?php echo e($stats['assigned']); ?></h2>
                                <small class="text-muted"><?php echo e(__('messages.Assigned')); ?></small>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle"></i> 
                        <strong><?php echo e(__('messages.How_It_Works')); ?>:</strong>
                        <ul class="mb-0 mt-2">
                            <li><strong><?php echo e(__('messages.Total_Notified')); ?></strong>: <?php echo e(__('messages.Drivers_sent_notification')); ?></li>
                            <li><strong><?php echo e(__('messages.Rejected')); ?></strong>: <?php echo e(__('messages.Drivers_removed_from_firebase')); ?></li>
                            <li><strong><?php echo e(__('messages.No_Response')); ?></strong>: <?php echo e(__('messages.Drivers_still_in_firebase')); ?></li>
                            <li><strong><?php echo e(__('messages.Assigned')); ?></strong>: <?php echo e(__('messages.Driver_accepted_order')); ?></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- All Drivers Notified Card -->
            <?php if($driversNotified->count() > 0): ?>
            <div class="card shadow mb-4 border-left-info">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-bell"></i> <?php echo e(__('messages.All_Drivers_Notified')); ?> (<?php echo e($driversNotified->count()); ?>)
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <i class="fas fa-info-circle"></i> 
                        <?php echo e(__('messages.All_drivers_notified_about_order')); ?>

                    </p>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th><?php echo e(__('messages.Driver')); ?></th>
                                    <th><?php echo e(__('messages.Phone')); ?></th>
                                    <th><?php echo e(__('messages.Distance')); ?></th>
                                    <th><?php echo e(__('messages.Search_Radius')); ?></th>
                                    <th><?php echo e(__('messages.Notified_At')); ?></th>
                                    <th><?php echo e(__('messages.Response')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $driversNotified; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notified): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php if($notified->driver): ?>
                                            <a href="<?php echo e(route('drivers.show', $notified->driver_id)); ?>">
                                                <?php echo e($notified->driver->name); ?>

                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($notified->driver->phone ?? 'N/A'); ?></td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            <?php echo e(number_format($notified->distance_km, 2)); ?> KM
                                        </span>
                                    </td>
                                    <td><?php echo e($notified->search_radius_km); ?> KM</td>
                                    <td>
                                        <small><?php echo e($notified->notified_at->format('Y-m-d H:i:s')); ?></small>
                                    </td>
                                    <td>
                                        <?php if($notified->driver_id == $spamOrder->driver_id): ?>
                                            <span class="badge badge-success">
                                                <i class="fas fa-check"></i> <?php echo e(__('messages.Assigned')); ?>

                                            </span>
                                        <?php elseif($driversRejected->contains('driver_id', $notified->driver_id)): ?>
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times"></i> <?php echo e(__('messages.Rejected')); ?>

                                            </span>
                                        <?php elseif($driversNoResponse->contains('driver_id', $notified->driver_id)): ?>
                                            <span class="badge badge-warning">
                                                <i class="fas fa-question"></i> <?php echo e(__('messages.No_Response')); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary"><?php echo e(__('messages.Unknown')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> 
                <?php echo e(__('messages.No_Drivers_Were_Notified')); ?>

            </div>
            <?php endif; ?>

            <!-- Drivers Who Rejected -->
            <?php if($driversRejected->count() > 0): ?>
            <div class="card shadow mb-4 border-left-danger">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-user-times"></i> <?php echo e(__('messages.Drivers_Who_Rejected')); ?> (<?php echo e($driversRejected->count()); ?>)
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <i class="fas fa-info-circle"></i> 
                        <?php echo e(__('messages.These_drivers_rejected_by_removing_firebase')); ?>

                    </p>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th><?php echo e(__('messages.Driver')); ?></th>
                                    <th><?php echo e(__('messages.Phone')); ?></th>
                                    <th><?php echo e(__('messages.Distance')); ?></th>
                                    <th><?php echo e(__('messages.Notified_At')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $driversRejected; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rejected): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php if($rejected->driver): ?>
                                            <a href="<?php echo e(route('drivers.show', $rejected->driver_id)); ?>">
                                                <?php echo e($rejected->driver->name); ?>

                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($rejected->driver->phone ?? 'N/A'); ?></td>
                                    <td><?php echo e(number_format($rejected->distance_km, 2)); ?> KM</td>
                                    <td><?php echo e($rejected->notified_at->format('Y-m-d H:i:s')); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Drivers Who Didn't Respond -->
            <?php if($driversNoResponse->count() > 0): ?>
            <div class="card shadow mb-4 border-left-warning">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-question-circle"></i> <?php echo e(__('messages.Drivers_No_Response')); ?> (<?php echo e($driversNoResponse->count()); ?>)
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <i class="fas fa-info-circle"></i> 
                        <?php echo e(__('messages.These_drivers_still_in_firebase')); ?>

                    </p>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th><?php echo e(__('messages.Driver')); ?></th>
                                    <th><?php echo e(__('messages.Phone')); ?></th>
                                    <th><?php echo e(__('messages.Distance')); ?></th>
                                    <th><?php echo e(__('messages.Notified_At')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $driversNoResponse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $noResponse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php if($noResponse->driver): ?>
                                            <a href="<?php echo e(route('drivers.show', $noResponse->driver_id)); ?>">
                                                <?php echo e($noResponse->driver->name); ?>

                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($noResponse->driver->phone ?? 'N/A'); ?></td>
                                    <td><?php echo e(number_format($noResponse->distance_km, 2)); ?> KM</td>
                                    <td><?php echo e($noResponse->notified_at->format('Y-m-d H:i:s')); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- User Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user"></i> <?php echo e(__('messages.User_Information')); ?>

                    </h6>
                </div>
                <div class="card-body">
                    <?php if($spamOrder->user): ?>
                        <div class="text-center mb-3">
                            <?php if($spamOrder->user->photo): ?>
                                <img src="<?php echo e(asset('assets/admin/uploads/' . $spamOrder->user->photo)); ?>" 
                                     alt="<?php echo e($spamOrder->user->name); ?>" 
                                     class="img-profile rounded-circle mb-3" 
                                     style="width: 100px; height: 100px; object-fit: cover;">
                            <?php else: ?>
                                <img src="<?php echo e(asset('assets/admin/img/undraw_profile.svg')); ?>" 
                                     alt="No Image" 
                                     class="img-profile rounded-circle mb-3" 
                                     style="width: 100px; height: 100px; object-fit: cover;">
                            <?php endif; ?>
                            <h5><?php echo e($spamOrder->user->name); ?></h5>
                        </div>

                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo e(__('messages.Phone')); ?>

                                <span><?php echo e($spamOrder->user->phone); ?></span>
                            </li>
                            <?php if($spamOrder->user->email): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo e(__('messages.Email')); ?>

                                    <span><?php echo e($spamOrder->user->email); ?></span>
                                </li>
                            <?php endif; ?>
                        </ul>

                        <a href="<?php echo e(route('users.show', $spamOrder->user_id)); ?>" class="btn btn-info btn-block">
                            <i class="fas fa-user"></i> <?php echo e(__('messages.View_Profile')); ?>

                        </a>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <?php echo e(__('messages.User_Not_Available')); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Driver Information (if assigned) -->
            <?php if($spamOrder->driver_id): ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-car"></i> <?php echo e(__('messages.Driver_Information')); ?>

                    </h6>
                </div>
                <div class="card-body">
                    <?php if($spamOrder->driver): ?>
                        <div class="text-center mb-3">
                            <?php if($spamOrder->driver->photo): ?>
                                <img src="<?php echo e(asset('assets/admin/uploads/' . $spamOrder->driver->photo)); ?>" 
                                     alt="<?php echo e($spamOrder->driver->name); ?>" 
                                     class="img-profile rounded-circle mb-3" 
                                     style="width: 100px; height: 100px; object-fit: cover;">
                            <?php else: ?>
                                <img src="<?php echo e(asset('assets/admin/img/undraw_profile.svg')); ?>" 
                                     alt="No Image" 
                                     class="img-profile rounded-circle mb-3" 
                                     style="width: 100px; height: 100px; object-fit: cover;">
                            <?php endif; ?>
                            <h5><?php echo e($spamOrder->driver->name); ?></h5>
                        </div>

                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo e(__('messages.Phone')); ?>

                                <span><?php echo e($spamOrder->driver->phone); ?></span>
                            </li>
                        </ul>

                        <a href="<?php echo e(route('drivers.show', $spamOrder->driver_id)); ?>" class="btn btn-info btn-block">
                            <i class="fas fa-car"></i> <?php echo e(__('messages.View_Profile')); ?>

                        </a>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <?php echo e(__('messages.Driver_Not_Available')); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- User Cancellation History -->
            <?php if($userCancellationHistory->count() > 0): ?>
            <div class="card shadow mb-4 border-left-danger">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-history"></i> <?php echo e(__('messages.User_Cancellation_History')); ?>

                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <i class="fas fa-exclamation-triangle"></i> 
                        <?php echo e(__('messages.This_user_cancelled')); ?> <?php echo e($userCancellationHistory->count() + 1); ?> <?php echo e(__('messages.orders')); ?>

                    </p>
                    <div class="list-group">
                        <?php $__currentLoopData = $userCancellationHistory->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('spam-orders.show', $history->id)); ?>" 
                           class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">#<?php echo e($history->number); ?></h6>
                                <small><?php echo e($history->cancelled_at->format('Y-m-d')); ?></small>
                            </div>
                            <p class="mb-1 text-muted small">
                                <?php echo e(Str::limit($history->reason_for_cancel, 50)); ?>

                            </p>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/admin/spam-orders/show.blade.php ENDPATH**/ ?>