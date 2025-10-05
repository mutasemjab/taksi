

<?php $__env->startSection('title', __('messages.Orders')); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo e(__('messages.Orders')); ?></h1>
        <a href="<?php echo e(route('orders.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> <?php echo e(__('messages.Add_New_Order')); ?>

        </a>
    </div>


    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo e(__('messages.Filter_Orders')); ?></h6>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('orders.filter')); ?>" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="user_id"><?php echo e(__('messages.User')); ?></label>
                            <select class="form-control" id="user_id" name="user_id">
                                <option value=""><?php echo e(__('messages.All_Users')); ?></option>
                                <?php $__currentLoopData = $users ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>" <?php echo e(request('user_id') == $user->id ? 'selected' : ''); ?>>
                                    <?php echo e($user->name); ?> (<?php echo e($user->phone ?? $user->email); ?>)
                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="driver_id"><?php echo e(__('messages.Driver')); ?></label>
                            <select class="form-control" id="driver_id" name="driver_id">
                                <option value=""><?php echo e(__('messages.All_Drivers')); ?></option>
                                <?php $__currentLoopData = $drivers ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($driver->id); ?>" <?php echo e(request('driver_id') == $driver->id ? 'selected' : ''); ?>>
                                    <?php echo e($driver->name); ?> (<?php echo e($driver->phone ?? $driver->email); ?>)
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
                                <?php $__currentLoopData = $services ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($service->id); ?>" <?php echo e(request('service_id') == $service->id ? 'selected' : ''); ?>>
                                    <?php echo e($service->name_en ?? $service->name); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status"><?php echo e(__('messages.Status')); ?></label>
                            <select class="form-control" id="status" name="status">
                                <option value="" <?php echo e(request('status') == '' ? 'selected' : ''); ?>><?php echo e(__('messages.All_Statuses')); ?></option>
                                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>><?php echo e(__('messages.Pending')); ?></option>
                                <option value="driver_accepted" <?php echo e(request('status') == 'driver_accepted' ? 'selected' : ''); ?>><?php echo e(__('messages.Driver_Accepted')); ?></option>
                                <option value="driver_go_to_user" <?php echo e(request('status') == 'driver_go_to_user' ? 'selected' : ''); ?>><?php echo e(__('messages.Driver_Going_To_User')); ?></option>
                                <option value="user_with_driver" <?php echo e(request('status') == 'user_with_driver' ? 'selected' : ''); ?>><?php echo e(__('messages.User_With_Driver')); ?></option>
                                <option value="delivered" <?php echo e(request('status') == 'delivered' ? 'selected' : ''); ?>><?php echo e(__('messages.Delivered')); ?></option>
                                <option value="user_cancel_order" <?php echo e(request('status') == 'user_cancel_order' ? 'selected' : ''); ?>><?php echo e(__('messages.User_Cancelled')); ?></option>
                                <option value="driver_cancel_order" <?php echo e(request('status') == 'driver_cancel_order' ? 'selected' : ''); ?>><?php echo e(__('messages.Driver_Cancelled')); ?></option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="payment_method"><?php echo e(__('messages.Payment_Method')); ?></label>
                            <select class="form-control" id="payment_method" name="payment_method">
                                <option value="" <?php echo e(request('payment_method') == '' ? 'selected' : ''); ?>><?php echo e(__('messages.All_Methods')); ?></option>
                                <option value="cash" <?php echo e(request('payment_method') == 'cash' ? 'selected' : ''); ?>><?php echo e(__('messages.Cash')); ?></option>
                                <option value="visa" <?php echo e(request('payment_method') == 'visa' ? 'selected' : ''); ?>><?php echo e(__('messages.Visa')); ?></option>
                                <option value="wallet" <?php echo e(request('payment_method') == 'wallet' ? 'selected' : ''); ?>><?php echo e(__('messages.Wallet')); ?></option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status_payment"><?php echo e(__('messages.Payment_Status')); ?></label>
                            <select class="form-control" id="status_payment" name="status_payment">
                                <option value="" <?php echo e(request('status_payment') == '' ? 'selected' : ''); ?>><?php echo e(__('messages.All')); ?></option>
                                <option value="pending" <?php echo e(request('status_payment') == 'pending' ? 'selected' : ''); ?>><?php echo e(__('messages.Pending')); ?></option>
                                <option value="paid" <?php echo e(request('status_payment') == 'paid' ? 'selected' : ''); ?>><?php echo e(__('messages.Paid')); ?></option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_from"><?php echo e(__('messages.Date_From')); ?></label>
                            <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo e(request('date_from')); ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_to"><?php echo e(__('messages.Date_To')); ?></label>
                            <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo e(request('date_to')); ?>">
                        </div>
                    </div>
                    
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> <?php echo e(__('messages.Filter')); ?>

                        </button>
                        <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-sync"></i> <?php echo e(__('messages.Reset')); ?>

                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Summary Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                <?php echo e(__('messages.Total_Orders')); ?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($orders->count()); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                <?php echo e(__('messages.Completed_Orders')); ?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($orders->where('status', 'delivered')->count()); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                <?php echo e(__('messages.Cancelled_Orders')); ?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($orders->whereIn('status', ['user_cancel_order', 'driver_cancel_order'])->count()); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                <?php echo e(__('messages.Total_Revenue')); ?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                $<?php echo e(number_format($orders->where('status', 'delivered')->sum('total_price_after_discount'), 2)); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo e(__('messages.Orders_List')); ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?php echo e(__('messages.ID')); ?></th>
                            <th><?php echo e(__('messages.Order_Number')); ?></th>
                            <th><?php echo e(__('messages.Date')); ?></th>
                            <th><?php echo e(__('messages.User')); ?></th>
                            <th><?php echo e(__('messages.Driver')); ?></th>
                            <th><?php echo e(__('messages.Service')); ?></th>
                            <th><?php echo e(__('messages.Route')); ?></th>
                            <th><?php echo e(__('messages.Distance')); ?></th>
                            <th><?php echo e(__('messages.Price')); ?></th>
                            <th><?php echo e(__('messages.Commission')); ?></th>
                            <th><?php echo e(__('messages.Status')); ?></th>
                            <th><?php echo e(__('messages.Payment')); ?></th>
                            <th><?php echo e(__('messages.Actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($order->id); ?></td>
                            <td>
                                <span class="font-weight-bold text-primary"><?php echo e($order->number ?? 'N/A'); ?></span>
                            </td>
                            <td><?php echo e($order->created_at->format('Y-m-d H:i')); ?></td>
                            <td>
                                <?php if($order->user): ?>
                                <a href="<?php echo e(route('users.show', $order->user_id)); ?>" class="text-decoration-none">
                                    <strong><?php echo e($order->user->name); ?></strong><br>
                                    <small class="text-muted"><?php echo e($order->user->phone ?? $order->user->email); ?></small>
                                </a>
                                <?php else: ?>
                                <span class="text-muted"><?php echo e(__('messages.Not_Available')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($order->driver): ?>
                                <a href="<?php echo e(route('drivers.show', $order->driver_id)); ?>" class="text-decoration-none">
                                    <strong><?php echo e($order->driver->name); ?></strong><br>
                                    <small class="text-muted"><?php echo e($order->driver->phone ?? $order->driver->email); ?></small>
                                </a>
                                <?php else: ?>
                                <span class="text-warning"><?php echo e(__('messages.Not_Assigned')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($order->service): ?>
                                <a href="<?php echo e(route('services.show', $order->service_id)); ?>" class="text-decoration-none">
                                    <?php echo e($order->service->name_en ?? $order->service->name); ?>

                                </a>
                                <?php else: ?>
                                <span class="text-muted"><?php echo e(__('messages.Not_Available')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="route-info">
                                    <div class="text-success">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <small><?php echo e(Str::limit($order->pick_name, 20)); ?></small>
                                    </div>
                                    <div class="text-center text-muted my-1">
                                        <i class="fas fa-arrow-down"></i>
                                    </div>
                                    <div class="text-danger">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <small><?php echo e(Str::limit($order->drop_name, 20)); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-info"><?php echo e($order->getDistance()); ?> km</span>
                            </td>
                            <td>
                                <div class="price-info">
                                    <?php if($order->discount_value > 0): ?>
                                    <div class="text-muted">
                                        <small><s>$<?php echo e(number_format($order->total_price_before_discount, 2)); ?></s></small>
                                    </div>
                                    <div class="text-success font-weight-bold">
                                        $<?php echo e(number_format($order->total_price_after_discount, 2)); ?>

                                    </div>
                                    <div>
                                        <span class="badge badge-warning">
                                            -$<?php echo e(number_format($order->discount_value, 2)); ?> (<?php echo e($order->getDiscountPercentage()); ?>%)
                                        </span>
                                    </div>
                                    <?php else: ?>
                                    <div class="text-success font-weight-bold">
                                        $<?php echo e(number_format($order->total_price_after_discount, 2)); ?>

                                    </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="commission-info">
                                    <div class="text-primary">
                                        <small><?php echo e(__('messages.Driver')); ?>: $<?php echo e(number_format($order->net_price_for_driver, 2)); ?></small>
                                    </div>
                                    <div class="text-info">
                                        <small><?php echo e(__('messages.Admin')); ?>: $<?php echo e(number_format($order->commision_of_admin, 2)); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-<?php echo e($order->getStatusClass()); ?>">
                                    <?php echo e($order->getStatusText()); ?>

                                </span>
                                <?php if($order->reason_for_cancel && $order->isCancelled()): ?>
                                <div class="mt-1">
                                    <small class="text-muted" title="<?php echo e($order->reason_for_cancel); ?>">
                                        <i class="fas fa-info-circle"></i> <?php echo e(__('messages.Reason_Available')); ?>

                                    </small>
                                </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="payment-info">
                                    <div>
                                        <span class="badge badge-primary"><?php echo e($order->getPaymentMethodText()); ?></span>
                                    </div>
                                    <div class="mt-1">
                                        <span class="badge badge-<?php echo e($order->getPaymentStatusClass()); ?>">
                                            <?php echo e($order->getPaymentStatusText()); ?>

                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group-vertical">
                                    <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn btn-info btn-sm mb-1" title="<?php echo e(__('messages.View')); ?>">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('orders.edit', $order->id)); ?>" class="btn btn-primary btn-sm mb-1" title="<?php echo e(__('messages.Edit')); ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if(!$order->isCompleted() && !$order->isCancelled()): ?>
                                    <button class="btn btn-warning btn-sm mb-1" onclick="updateOrderStatus(<?php echo e($order->id); ?>)" title="<?php echo e(__('messages.Update_Status')); ?>">
                                        <i class="fas fa-sync"></i>
                                    </button>
                                    <?php endif; ?>
                                    <button class="btn btn-danger btn-sm" onclick="deleteOrder(<?php echo e($order->id); ?>)" title="<?php echo e(__('messages.Delete')); ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-<?php echo e($order->id); ?>" action="<?php echo e(route('orders.destroy', $order->id)); ?>" method="POST" style="display: none;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if(method_exists($orders, 'links')): ?>
            <div class="d-flex justify-content-center">
                <?php echo e($orders->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusUpdateModal" tabindex="-1" role="dialog" aria-labelledby="statusUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="statusUpdateModalLabel"><?php echo e(__('messages.Update_Order_Status')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="statusUpdateForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status"><?php echo e(__('messages.Status')); ?></label>
                        <select class="form-control" id="modal_status" name="status" required>
                            <option value="pending"><?php echo e(__('messages.Pending')); ?></option>
                            <option value="driver_accepted"><?php echo e(__('messages.Driver_Accepted')); ?></option>
                            <option value="driver_go_to_user"><?php echo e(__('messages.Driver_Going_To_User')); ?></option>
                            <option value="user_with_driver"><?php echo e(__('messages.User_With_Driver')); ?></option>
                            <option value="delivered"><?php echo e(__('messages.Delivered')); ?></option>
                            <option value="user_cancel_order"><?php echo e(__('messages.User_Cancelled')); ?></option>
                            <option value="driver_cancel_order"><?php echo e(__('messages.Driver_Cancelled')); ?></option>
                        </select>
                    </div>
                    <div class="form-group" id="cancelReasonGroup" style="display: none;">
                        <label for="reason_for_cancel"><?php echo e(__('messages.Cancellation_Reason')); ?></label>
                        <textarea class="form-control" id="reason_for_cancel" name="reason_for_cancel" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('messages.Close')); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('messages.Update')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "order": [[0, "desc"]],
            "pageLength": 25,
            "responsive": true,
            "columnDefs": [
                { "orderable": false, "targets": [-1] } // Disable sorting on Actions column
            ]
        });
        
        // Date validation
        $('#date_to').on('change', function() {
            var startDate = $('#date_from').val();
            var endDate = $(this).val();
            
            if (startDate && endDate && startDate > endDate) {
                alert("<?php echo e(__('messages.Date_Range_Error')); ?>");
                $(this).val('');
            }
        });

        // Status change handler for cancellation reason
        $('#modal_status').on('change', function() {
            var status = $(this).val();
            if (status === 'user_cancel_order' || status === 'driver_cancel_order') {
                $('#cancelReasonGroup').show();
                $('#reason_for_cancel').prop('required', true);
            } else {
                $('#cancelReasonGroup').hide();
                $('#reason_for_cancel').prop('required', false);
            }
        });
    });

    function updateOrderStatus(orderId) {
        $('#statusUpdateForm').attr('action', `/admin/orders/${orderId}/status`);
        $('#statusUpdateModal').modal('show');
    }

    function deleteOrder(orderId) {
        if (confirm("<?php echo e(__('messages.Delete_Confirm')); ?>")) {
            document.getElementById(`delete-form-${orderId}`).submit();
        }
    }

    // Auto-refresh for real-time updates (optional)
    setInterval(function() {
        // Only refresh if no modals are open
        if (!$('.modal').hasClass('show')) {
            // You can implement auto-refresh logic here
            // location.reload();
        }
    }, 300000); // Refresh every 5 minutes
</script>

<style>
    .route-info {
        min-width: 120px;
    }
    
    .price-info {
        min-width: 100px;
    }
    
    .commission-info {
        min-width: 120px;
    }
    
    .payment-info {
        min-width: 100px;
    }
    
    .btn-group-vertical .btn {
        border-radius: 0.25rem !important;
        margin-bottom: 2px;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .badge {
        font-size: 0.75em;
    }
    
    @media (max-width: 768px) {
        .btn-group-vertical {
            display: flex;
            flex-direction: row;
        }
        
        .btn-group-vertical .btn {
            margin-right: 2px;
            margin-bottom: 0;
        }
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>