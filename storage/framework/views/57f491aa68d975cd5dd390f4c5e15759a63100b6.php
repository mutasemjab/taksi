

<?php $__env->startSection('title', __('messages.Drivers_Financial_Reports')); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-chart-line"></i> <?php echo e(__('messages.Drivers_Financial_Reports')); ?>

        </h1>
        <div>
            <a href="<?php echo e(route('financial-reports.pos-report')); ?>" class="btn btn-info">
                <i class="fas fa-store"></i> <?php echo e(__('messages.POS_Reports')); ?>

            </a>
            <a href="<?php echo e(route('financial-reports.overall-summary')); ?>" class="btn btn-success">
                <i class="fas fa-chart-pie"></i> <?php echo e(__('messages.Overall_Summary')); ?>

            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-filter"></i> <?php echo e(__('messages.Select_Report_Period')); ?>

            </h6>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('financial-reports.index')); ?>" method="GET" id="reportForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_date">
                                <i class="fas fa-calendar-alt"></i> <?php echo e(__('messages.Start_Date')); ?>

                                <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="start_date" id="start_date" class="form-control" 
                                   value="<?php echo e(request('start_date', now()->startOfMonth()->format('Y-m-d'))); ?>" required>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end_date">
                                <i class="fas fa-calendar-alt"></i> <?php echo e(__('messages.End_Date')); ?>

                                <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="end_date" id="end_date" class="form-control" 
                                   value="<?php echo e(request('end_date', now()->format('Y-m-d'))); ?>" required>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="driver_id">
                                <i class="fas fa-user"></i> <?php echo e(__('messages.Driver')); ?>

                            </label>
                            <select name="driver_id" id="driver_id" class="form-control select2">
                                <option value=""><?php echo e(__('messages.All_Drivers')); ?></option>
                                <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($driver->id); ?>" 
                                            <?php echo e(request('driver_id') == $driver->id ? 'selected' : ''); ?>>
                                        <?php echo e($driver->name); ?> - <?php echo e($driver->phone); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-search"></i> <?php echo e(__('messages.Generate_Report')); ?>

                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Date Filters -->
                <div class="row">
                    <div class="col-12">
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary quick-date" data-period="today">
                                <?php echo e(__('messages.Today')); ?>

                            </button>
                            <button type="button" class="btn btn-outline-secondary quick-date" data-period="yesterday">
                                <?php echo e(__('messages.Yesterday')); ?>

                            </button>
                            <button type="button" class="btn btn-outline-secondary quick-date" data-period="this_week">
                                <?php echo e(__('messages.This_Week')); ?>

                            </button>
                            <button type="button" class="btn btn-outline-secondary quick-date" data-period="last_week">
                                <?php echo e(__('messages.Last_Week')); ?>

                            </button>
                            <button type="button" class="btn btn-outline-secondary quick-date" data-period="this_month">
                                <?php echo e(__('messages.This_Month')); ?>

                            </button>
                            <button type="button" class="btn btn-outline-secondary quick-date" data-period="last_month">
                                <?php echo e(__('messages.Last_Month')); ?>

                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if(isset($report)): ?>
    <!-- Summary Cards -->
    <div class="row">
        <!-- Total Revenue -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                <?php echo e(__('messages.Total_Revenue')); ?>

                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(number_format($report['summary']['total_revenue'], 2)); ?> <?php echo e(__('messages.JD')); ?>

                            </div>
                            <small class="text-muted"><?php echo e(__('messages.Your_Total_Income')); ?></small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registration Revenue -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                <?php echo e(__('messages.Registration_Revenue')); ?>

                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(number_format($report['summary']['total_registration_revenue'], 2)); ?> <?php echo e(__('messages.JD')); ?>

                            </div>
                            <small class="text-muted"><?php echo e(__('messages.From_Driver_Registration')); ?></small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards Revenue -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                <?php echo e(__('messages.Cards_Revenue')); ?>

                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(number_format($report['summary']['total_cards_revenue'], 2)); ?> <?php echo e(__('messages.JD')); ?>

                            </div>
                            <small class="text-muted"><?php echo e(__('messages.From_Recharge_Cards')); ?></small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-credit-card fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Withdrawals -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                <?php echo e(__('messages.Total_Withdrawals')); ?>

                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(number_format($report['summary']['total_withdrawals'], 2)); ?> <?php echo e(__('messages.JD')); ?>

                            </div>
                            <small class="text-muted"><?php echo e(__('messages.Drivers_Withdrawals')); ?></small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Summary Cards -->
    <div class="row">
        <!-- Total Drivers -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                <?php echo e(__('messages.Total_Drivers')); ?>

                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($report['summary']['total_drivers']); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- POS Commission -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                <?php echo e(__('messages.POS_Commission')); ?>

                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(number_format($report['summary']['total_pos_commission'], 2)); ?> <?php echo e(__('messages.JD')); ?>

                            </div>
                            <small class="text-muted"><?php echo e(__('messages.Paid_To_POS')); ?></small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Added to Wallets -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                <?php echo e(__('messages.Added_To_Wallets')); ?>

                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(number_format($report['summary']['total_added_to_wallets'], 2)); ?> <?php echo e(__('messages.JD')); ?>

                            </div>
                            <small class="text-muted"><?php echo e(__('messages.Total_Recharged')); ?></small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Report Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table"></i> <?php echo e(__('messages.Detailed_Report')); ?>

            </h6>
            <div>
                <button onclick="printReport()" class="btn btn-sm btn-secondary">
                    <i class="fas fa-print"></i> <?php echo e(__('messages.Print')); ?>

                </button>
                <a href="<?php echo e(route('financial-reports.export', request()->query())); ?>" class="btn btn-sm btn-success">
                    <i class="fas fa-file-excel"></i> <?php echo e(__('messages.Export_Excel')); ?>

                </a>
                <a href="<?php echo e(route('financial-reports.pdf', request()->query())); ?>" class="btn btn-sm btn-danger" target="_blank">
                    <i class="fas fa-file-pdf"></i> <?php echo e(__('messages.Export_PDF')); ?>

                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th><?php echo e(__('messages.Driver_Name')); ?></th>
                            <th><?php echo e(__('messages.Phone')); ?></th>
                            <th><?php echo e(__('messages.Current_Balance')); ?></th>
                            <th><?php echo e(__('messages.Registration_Paid')); ?></th>
                            <th><?php echo e(__('messages.Registration_Kept')); ?></th>
                            <th><?php echo e(__('messages.Cards_Count')); ?></th>
                            <th><?php echo e(__('messages.Cards_Net')); ?></th>
                            <th><?php echo e(__('messages.Withdrawals')); ?></th>
                            <th><?php echo e(__('messages.Total_Revenue')); ?></th>
                            <th><?php echo e(__('messages.Actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $report['drivers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $driverReport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($index + 1); ?></td>
                            <td>
                                <strong><?php echo e($driverReport['driver_name']); ?></strong>
                            </td>
                            <td><?php echo e($driverReport['driver_phone']); ?></td>
                            <td>
                                <span class="badge badge-info">
                                    <?php echo e(number_format($driverReport['current_balance'], 2)); ?> <?php echo e(__('messages.JD')); ?>

                                </span>
                            </td>
                            <td><?php echo e(number_format($driverReport['registration']['total_paid'], 2)); ?></td>
                            <td>
                                <span class="text-success font-weight-bold">
                                    <?php echo e(number_format($driverReport['registration']['amount_kept'], 2)); ?>

                                </span>
                            </td>
                            <td><?php echo e($driverReport['cards']['total_cards_used']); ?></td>
                            <td>
                                <span class="text-success font-weight-bold">
                                    <?php echo e(number_format($driverReport['cards']['total_net_from_cards'], 2)); ?>

                                </span>
                            </td>
                            <td>
                                <span class="text-danger">
                                    <?php echo e(number_format($driverReport['wallet_transactions']['total_withdrawals'], 2)); ?>

                                </span>
                            </td>
                            <td>
                                <strong class="text-primary">
                                    <?php echo e(number_format($driverReport['total_revenue_from_driver'], 2)); ?> <?php echo e(__('messages.JD')); ?>

                                </strong>
                            </td>
                            <td>
                                <a href="<?php echo e(route('financial-reports.driver-details', $driverReport['driver_id'])); ?>?start_date=<?php echo e(request('start_date')); ?>&end_date=<?php echo e(request('end_date')); ?>" 
                                   class="btn btn-sm btn-info" title="<?php echo e(__('messages.View_Details')); ?>">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="11" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                <?php echo e(__('messages.No_Data_Available')); ?>

                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                    <?php if(count($report['drivers']) > 0): ?>
                    <tfoot class="bg-light font-weight-bold">
                        <tr>
                            <td colspan="4" class="text-right"><?php echo e(__('messages.Total')); ?>:</td>
                            <td><?php echo e(number_format($report['summary']['total_registration_revenue'], 2)); ?></td>
                            <td><?php echo e(number_format($report['summary']['total_registration_revenue'], 2)); ?></td>
                            <td>-</td>
                            <td><?php echo e(number_format($report['summary']['total_cards_revenue'], 2)); ?></td>
                            <td><?php echo e(number_format($report['summary']['total_withdrawals'], 2)); ?></td>
                            <td class="text-primary">
                                <?php echo e(number_format($report['summary']['total_revenue'], 2)); ?> <?php echo e(__('messages.JD')); ?>

                            </td>
                            <td>-</td>
                        </tr>
                    </tfoot>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
    <?php else: ?>
    <!-- Empty State -->
    <div class="card shadow mb-4">
        <div class="card-body text-center py-5">
            <i class="fas fa-chart-bar fa-5x text-gray-300 mb-4"></i>
            <h5 class="text-gray-600"><?php echo e(__('messages.Select_Date_Range_Generate_Report')); ?></h5>
            <p class="text-muted"><?php echo e(__('messages.Choose_dates_above_view_financial_report')); ?></p>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%'
    });
    
    // Initialize DataTable
    $('#dataTable').DataTable({
        "language": {
            "url": "<?php echo e(app()->getLocale() == 'ar' ? '//cdn.datatables.net/plug-ins/1.10.24/i18n/Arabic.json' : ''); ?>"
        },
        "pageLength": 25,
        "order": [[9, 'desc']] // Sort by total revenue
    });
    
    // Quick Date Filters
    $('.quick-date').click(function() {
        const period = $(this).data('period');
        const today = new Date();
        let startDate, endDate;
        
        switch(period) {
            case 'today':
                startDate = endDate = today;
                break;
            case 'yesterday':
                const yesterday = new Date(today);
                yesterday.setDate(yesterday.getDate() - 1);
                startDate = endDate = yesterday;
                break;
            case 'this_week':
                const weekStart = new Date(today);
                weekStart.setDate(today.getDate() - today.getDay());
                startDate = weekStart;
                endDate = today;
                break;
            case 'last_week':
                const lastWeekEnd = new Date(today);
                lastWeekEnd.setDate(today.getDate() - today.getDay() - 1);
                const lastWeekStart = new Date(lastWeekEnd);
                lastWeekStart.setDate(lastWeekEnd.getDate() - 6);
                startDate = lastWeekStart;
                endDate = lastWeekEnd;
                break;
            case 'this_month':
                startDate = new Date(today.getFullYear(), today.getMonth(), 1);
                endDate = today;
                break;
            case 'last_month':
                const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                startDate = lastMonth;
                endDate = new Date(today.getFullYear(), today.getMonth(), 0);
                break;
        }
        
        $('#start_date').val(formatDate(startDate));
        $('#end_date').val(formatDate(endDate));
        $('#reportForm').submit();
    });
    
    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
});

function printReport() {
    window.print();
}
</script>

<style>
@media print {
    .btn, .sidebar, .topbar, .card-header .btn-group {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/reports/financial-reports/index.blade.php ENDPATH**/ ?>