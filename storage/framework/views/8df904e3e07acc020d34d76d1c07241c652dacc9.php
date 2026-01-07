

<?php $__env->startSection('title', __('messages.Driver_Financial_Details')); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-circle"></i> <?php echo e(__('messages.Driver_Financial_Details')); ?>

        </h1>
        <a href="<?php echo e(route('financial-reports.index')); ?>?start_date=<?php echo e(request('start_date')); ?>&end_date=<?php echo e(request('end_date')); ?>" 
           class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> <?php echo e(__('messages.Back_to_Report')); ?>

        </a>
    </div>

    <!-- Driver Info Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-info-circle"></i> <?php echo e(__('messages.Driver_Information')); ?>

            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <div class="text-center">
                        <?php if($driver->photo): ?>
                            <img src="<?php echo e(asset('assets/admin/uploads/' . $driver->photo)); ?>" 
                                 alt="<?php echo e($driver->name); ?>" 
                                 class="img-fluid rounded-circle mb-3" 
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                 style="width: 120px; height: 120px;">
                                <i class="fas fa-user fa-3x text-white"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-user"></i> <?php echo e(__('messages.Name')); ?>:</strong> <?php echo e($driver->name); ?></p>
                            <p><strong><i class="fas fa-phone"></i> <?php echo e(__('messages.Phone')); ?>:</strong> <?php echo e($driver->phone); ?></p>
                            <p><strong><i class="fas fa-envelope"></i> <?php echo e(__('messages.Email')); ?>:</strong> <?php echo e($driver->email ?? '-'); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-wallet"></i> <?php echo e(__('messages.Current_Balance')); ?>:</strong> 
                                <span class="badge badge-info badge-lg p-2">
                                    <?php echo e(number_format($driver->balance, 2)); ?> <?php echo e(__('messages.JD')); ?>

                                </span>
                            </p>
                            <p><strong><i class="fas fa-toggle-on"></i> <?php echo e(__('messages.Status')); ?>:</strong> 
                                <?php if($driver->activate == 1): ?>
                                    <span class="badge badge-success"><?php echo e(__('messages.Active')); ?></span>
                                <?php else: ?>
                                    <span class="badge badge-danger"><?php echo e(__('messages.Inactive')); ?></span>
                                <?php endif; ?>
                            </p>
                            <p><strong><i class="fas fa-calendar-plus"></i> <?php echo e(__('messages.Registration_Date')); ?>:</strong> 
                                <?php echo e($driver->created_at->format('Y-m-d')); ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Period Info -->
    <div class="alert alert-info">
        <i class="fas fa-calendar-alt"></i> 
        <strong><?php echo e(__('messages.Report_Period')); ?>:</strong> 
        <?php echo e(\Carbon\Carbon::parse(request('start_date'))->format('Y-m-d')); ?> 
        <?php echo e(__('messages.To')); ?> 
        <?php echo e(\Carbon\Carbon::parse(request('end_date'))->format('Y-m-d')); ?>

    </div>

    <!-- Summary Statistics -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        <?php echo e(__('messages.Registration_Revenue')); ?>

                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo e(number_format($details['registration']['amount_kept'], 2)); ?> <?php echo e(__('messages.JD')); ?>

                    </div>
                    <small class="text-muted">
                        <?php echo e(__('messages.From')); ?> <?php echo e(number_format($details['registration']['total_paid'], 2)); ?> <?php echo e(__('messages.paid')); ?>

                    </small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        <?php echo e(__('messages.Cards_Revenue')); ?>

                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo e(number_format($details['cards']['total_net_from_cards'], 2)); ?> <?php echo e(__('messages.JD')); ?>

                    </div>
                    <small class="text-muted">
                        <?php echo e($details['cards']['total_cards_used']); ?> <?php echo e(__('messages.cards_used')); ?>

                    </small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        <?php echo e(__('messages.Total_Withdrawals')); ?>

                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo e(number_format($details['wallet_transactions']['total_withdrawals'], 2)); ?> <?php echo e(__('messages.JD')); ?>

                    </div>
                    <small class="text-muted">
                        <?php echo e(__('messages.From_wallet')); ?>

                    </small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        <?php echo e(__('messages.Total_Revenue')); ?>

                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo e(number_format($details['total_revenue_from_driver'], 2)); ?> <?php echo e(__('messages.JD')); ?>

                    </div>
                    <small class="text-muted">
                        <?php echo e(__('messages.Your_profit_from_driver')); ?>

                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Payments -->
    <?php if($registrationPayments->count() > 0): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-file-invoice-dollar"></i> <?php echo e(__('messages.Registration_Payments')); ?>

                <span class="badge badge-primary ml-2"><?php echo e($registrationPayments->count()); ?></span>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th><?php echo e(__('messages.Date')); ?></th>
                            <th><?php echo e(__('messages.Total_Paid')); ?></th>
                            <th><?php echo e(__('messages.Amount_Kept')); ?></th>
                            <th><?php echo e(__('messages.Added_To_Wallet')); ?></th>
                            <th><?php echo e(__('messages.Note')); ?></th>
                            <th><?php echo e(__('messages.Admin')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $registrationPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($payment->created_at->format('Y-m-d H:i')); ?></td>
                            <td><?php echo e(number_format($payment->total_paid, 2)); ?> <?php echo e(__('messages.JD')); ?></td>
                            <td class="text-success font-weight-bold">
                                <?php echo e(number_format($payment->amount_kept, 2)); ?> <?php echo e(__('messages.JD')); ?>

                            </td>
                            <td><?php echo e(number_format($payment->amount_added_to_wallet, 2)); ?> <?php echo e(__('messages.JD')); ?></td>
                            <td><?php echo e($payment->note ?? '-'); ?></td>
                            <td><?php echo e($payment->admin->name ?? '-'); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot class="bg-light font-weight-bold">
                        <tr>
                            <td><?php echo e(__('messages.Total')); ?></td>
                            <td><?php echo e(number_format($registrationPayments->sum('total_paid'), 2)); ?> <?php echo e(__('messages.JD')); ?></td>
                            <td class="text-success"><?php echo e(number_format($registrationPayments->sum('amount_kept'), 2)); ?> <?php echo e(__('messages.JD')); ?></td>
                            <td><?php echo e(number_format($registrationPayments->sum('amount_added_to_wallet'), 2)); ?> <?php echo e(__('messages.JD')); ?></td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Card Usages -->
    <?php if($cardUsages->count() > 0): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-credit-card"></i> <?php echo e(__('messages.Recharge_Cards_History')); ?>

                <span class="badge badge-primary ml-2"><?php echo e($cardUsages->count()); ?></span>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th><?php echo e(__('messages.Date')); ?></th>
                            <th><?php echo e(__('messages.Card_Number')); ?></th>
                            <th><?php echo e(__('messages.Card_Price')); ?></th>
                            <th><?php echo e(__('messages.Recharged_Amount')); ?></th>
                            <th><?php echo e(__('messages.POS')); ?></th>
                            <th><?php echo e(__('messages.POS_Commission')); ?></th>
                            <th><?php echo e(__('messages.Net_Revenue')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $cardUsages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $card = $usage->cardNumber->card;
                            $commission = ($card->price * ($card->pos_commission_percentage ?? 0) / 100);
                            $netRevenue = $card->price - $commission;
                        ?>
                        <tr>
                            <td><?php echo e($usage->used_at->format('Y-m-d H:i')); ?></td>
                            <td><code><?php echo e($usage->cardNumber->number); ?></code></td>
                            <td><?php echo e(number_format($card->price, 2)); ?> <?php echo e(__('messages.JD')); ?></td>
                            <td class="text-info font-weight-bold">
                                <?php echo e(number_format($card->driver_recharge_amount, 2)); ?> <?php echo e(__('messages.JD')); ?>

                            </td>
                            <td><?php echo e($card->pos->name ?? '-'); ?></td>
                            <td class="text-danger"><?php echo e(number_format($commission, 2)); ?> <?php echo e(__('messages.JD')); ?></td>
                            <td class="text-success font-weight-bold"><?php echo e(number_format($netRevenue, 2)); ?> <?php echo e(__('messages.JD')); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot class="bg-light font-weight-bold">
                        <tr>
                            <td colspan="2"><?php echo e(__('messages.Total')); ?></td>
                            <td><?php echo e(number_format($details['cards']['total_purchase_value'], 2)); ?> <?php echo e(__('messages.JD')); ?></td>
                            <td class="text-info"><?php echo e(number_format($details['cards']['total_recharged_to_driver'], 2)); ?> <?php echo e(__('messages.JD')); ?></td>
                            <td>-</td>
                            <td class="text-danger"><?php echo e(number_format($details['cards']['total_pos_commission'], 2)); ?> <?php echo e(__('messages.JD')); ?></td>
                            <td class="text-success"><?php echo e(number_format($details['cards']['total_net_from_cards'], 2)); ?> <?php echo e(__('messages.JD')); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Wallet Transactions -->
    <?php if($walletTransactions->count() > 0): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-exchange-alt"></i> <?php echo e(__('messages.Wallet_Transactions')); ?>

                <span class="badge badge-primary ml-2"><?php echo e($walletTransactions->count()); ?></span>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th><?php echo e(__('messages.Date')); ?></th>
                            <th><?php echo e(__('messages.Type')); ?></th>
                            <th><?php echo e(__('messages.Amount')); ?></th>
                            <th><?php echo e(__('messages.Note')); ?></th>
                            <th><?php echo e(__('messages.Admin')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $walletTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($transaction->created_at->format('Y-m-d H:i')); ?></td>
                            <td>
                                <?php if($transaction->type_of_transaction == 1): ?>
                                    <span class="badge badge-success">
                                        <i class="fas fa-plus"></i> <?php echo e(__('messages.Deposit')); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-danger">
                                        <i class="fas fa-minus"></i> <?php echo e(__('messages.Withdrawal')); ?>

                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="<?php echo e($transaction->type_of_transaction == 1 ? 'text-success' : 'text-danger'); ?> font-weight-bold">
                                <?php echo e(number_format($transaction->amount, 2)); ?> <?php echo e(__('messages.JD')); ?>

                            </td>
                            <td><?php echo e($transaction->note ?? '-'); ?></td>
                            <td><?php echo e($transaction->admin->name ?? '-'); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Withdrawal Requests -->
    <?php if($withdrawalRequests->count() > 0): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-hand-holding-usd"></i> <?php echo e(__('messages.Withdrawal_Requests')); ?>

                <span class="badge badge-primary ml-2"><?php echo e($withdrawalRequests->count()); ?></span>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th><?php echo e(__('messages.Date')); ?></th>
                            <th><?php echo e(__('messages.Amount')); ?></th>
                            <th><?php echo e(__('messages.Status')); ?></th>
                            <th><?php echo e(__('messages.Note')); ?></th>
                            <th><?php echo e(__('messages.Processed_By')); ?></th>
                            <th><?php echo e(__('messages.Processed_At')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $withdrawalRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($request->created_at->format('Y-m-d H:i')); ?></td>
                            <td class="font-weight-bold"><?php echo e(number_format($request->amount, 2)); ?> <?php echo e(__('messages.JD')); ?></td>
                            <td>
                                <?php if($request->status == 1): ?>
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i> <?php echo e(__('messages.Pending')); ?>

                                    </span>
                                <?php elseif($request->status == 2): ?>
                                    <span class="badge badge-success">
                                        <i class="fas fa-check"></i> <?php echo e(__('messages.Approved')); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-danger">
                                        <i class="fas fa-times"></i> <?php echo e(__('messages.Rejected')); ?>

                                    </span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($request->note ?? '-'); ?></td>
                            <td><?php echo e($request->admin->name ?? '-'); ?></td>
                            <td><?php echo e($request->updated_at->format('Y-m-d H:i')); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Print and Export Buttons -->
    <div class="text-center mb-4">
        <button onclick="window.print()" class="btn btn-secondary">
            <i class="fas fa-print"></i> <?php echo e(__('messages.Print')); ?>

        </button>
        <a href="<?php echo e(route('financial-reports.index')); ?>?start_date=<?php echo e(request('start_date')); ?>&end_date=<?php echo e(request('end_date')); ?>" 
           class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> <?php echo e(__('messages.Back_to_Report')); ?>

        </a>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<style>
@media print {
    .btn, .sidebar, .topbar, .navbar {
        display: none !important;
    }
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
        page-break-inside: avoid;
    }
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/reports/financial-reports/driver-details.blade.php ENDPATH**/ ?>