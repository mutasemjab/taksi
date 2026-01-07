

<?php $__env->startSection('title', __('messages.POS_Financial_Report')); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-store"></i> <?php echo e(__('messages.POS_Financial_Report')); ?>

        </h1>
        <a href="<?php echo e(route('financial-reports.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> <?php echo e(__('messages.Back_to_Drivers_Report')); ?>

        </a>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-info text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-filter"></i> <?php echo e(__('messages.Select_Report_Period')); ?>

            </h6>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('financial-reports.pos-report')); ?>" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_date"><?php echo e(__('messages.Start_Date')); ?> <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" class="form-control" 
                                   value="<?php echo e(request('start_date', now()->startOfMonth()->format('Y-m-d'))); ?>" required>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end_date"><?php echo e(__('messages.End_Date')); ?> <span class="text-danger">*</span></label>
                            <input type="date" name="end_date" class="form-control" 
                                   value="<?php echo e(request('end_date', now()->format('Y-m-d'))); ?>" required>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="pos_id"><?php echo e(__('messages.POS_Point')); ?></label>
                            <select name="pos_id" class="form-control select2">
                                <option value=""><?php echo e(__('messages.All_POS')); ?></option>
                                <?php $__currentLoopData = $posPoints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($pos->id); ?>" <?php echo e(request('pos_id') == $pos->id ? 'selected' : ''); ?>>
                                        <?php echo e($pos->name); ?> - <?php echo e($pos->phone); ?>

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
            </form>
        </div>
    </div>

    <?php if(isset($report)): ?>
    <!-- Summary Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                <?php echo e(__('messages.Total_POS_Points')); ?>

                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($report['summary']['total_pos']); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-store fa-2x text-gray-300"></i>
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
                                <?php echo e(__('messages.Total_Cards_Sold')); ?>

                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($report['summary']['total_cards_sold']); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-credit-card fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                <?php echo e(__('messages.Total_Sales_Value')); ?>

                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(number_format($report['summary']['total_sales_value'], 2)); ?> <?php echo e(__('messages.JD')); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                                <?php echo e(__('messages.POS_Commission')); ?>

                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(number_format($report['summary']['total_commission_paid'], 2)); ?> <?php echo e(__('messages.JD')); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-left-primary shadow">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                <?php echo e(__('messages.Net_Revenue_To_Admin')); ?>

                            </div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">
                                <?php echo e(number_format($report['summary']['total_net_revenue'], 2)); ?> <?php echo e(__('messages.JD')); ?>

                            </div>
                            <small class="text-muted"><?php echo e(__('messages.After_POS_Commission')); ?></small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Report Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table"></i> <?php echo e(__('messages.Detailed_POS_Report')); ?>

            </h6>
            <div>
                <button onclick="window.print()" class="btn btn-sm btn-secondary">
                    <i class="fas fa-print"></i> <?php echo e(__('messages.Print')); ?>

                </button>
                <a href="<?php echo e(route('financial-reports.pos-export', request()->query())); ?>" class="btn btn-sm btn-success">
                    <i class="fas fa-file-excel"></i> <?php echo e(__('messages.Export_Excel')); ?>

                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th><?php echo e(__('messages.POS_Name')); ?></th>
                            <th><?php echo e(__('messages.Phone')); ?></th>
                            <th><?php echo e(__('messages.Cards_Sold')); ?></th>
                            <th><?php echo e(__('messages.Total_Sales')); ?></th>
                            <th><?php echo e(__('messages.Commission')); ?></th>
                            <th><?php echo e(__('messages.Net_To_Admin')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $report['pos_points']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $posReport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($index + 1); ?></td>
                            <td><strong><?php echo e($posReport['pos_name']); ?></strong></td>
                            <td><?php echo e($posReport['pos_phone']); ?></td>
                            <td><?php echo e($posReport['total_cards_sold']); ?></td>
                            <td><?php echo e(number_format($posReport['total_sales_value'], 2)); ?> <?php echo e(__('messages.JD')); ?></td>
                            <td class="text-danger"><?php echo e(number_format($posReport['total_commission'], 2)); ?> <?php echo e(__('messages.JD')); ?></td>
                            <td class="text-success font-weight-bold">
                                <?php echo e(number_format($posReport['net_due_to_admin'], 2)); ?> <?php echo e(__('messages.JD')); ?>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <?php echo e(__('messages.No_Data_Available')); ?>

                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                    <?php if(count($report['pos_points']) > 0): ?>
                    <tfoot class="bg-light font-weight-bold">
                        <tr>
                            <td colspan="3" class="text-right"><?php echo e(__('messages.Total')); ?>:</td>
                            <td><?php echo e($report['summary']['total_cards_sold']); ?></td>
                            <td><?php echo e(number_format($report['summary']['total_sales_value'], 2)); ?> <?php echo e(__('messages.JD')); ?></td>
                            <td class="text-danger"><?php echo e(number_format($report['summary']['total_commission_paid'], 2)); ?> <?php echo e(__('messages.JD')); ?></td>
                            <td class="text-success"><?php echo e(number_format($report['summary']['total_net_revenue'], 2)); ?> <?php echo e(__('messages.JD')); ?></td>
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
            <i class="fas fa-store fa-5x text-gray-300 mb-4"></i>
            <h5 class="text-gray-600"><?php echo e(__('messages.Select_Date_Range_Generate_Report')); ?></h5>
            <p class="text-muted"><?php echo e(__('messages.Choose_dates_above_view_pos_report')); ?></p>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap4'
    });
    
    $('#dataTable').DataTable({
        "language": {
            "url": "<?php echo e(app()->getLocale() == 'ar' ? '//cdn.datatables.net/plug-ins/1.10.24/i18n/Arabic.json' : ''); ?>"
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/reports/financial-reports/pos-report.blade.php ENDPATH**/ ?>