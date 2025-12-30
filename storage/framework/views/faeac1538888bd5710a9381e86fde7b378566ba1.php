<?php $__env->startSection('title', __('messages.Drivers')); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"><?php echo e(__('messages.Drivers')); ?></h1>
            <a href="<?php echo e(route('drivers.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> <?php echo e(__('messages.Add_New_Driver')); ?>

            </a>
        </div>
        <!-- Search and Filter Section -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="<?php echo e(route('drivers.index')); ?>" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?php echo e(__('messages.Search')); ?></label>
                                <input type="text" name="search" class="form-control"
                                    placeholder="<?php echo e(__('messages.Search_By_Name_Phone_Email')); ?>"
                                    value="<?php echo e(request('search')); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><?php echo e(__('messages.Status')); ?></label>
                                <select name="status" class="form-control">
                                    <option value=""><?php echo e(__('messages.All')); ?></option>
                                    <option value="1" <?php echo e(request('status') == '1' ? 'selected' : ''); ?>>
                                        <?php echo e(__('messages.Active')); ?></option>
                                    <option value="2" <?php echo e(request('status') == '2' ? 'selected' : ''); ?>>
                                        <?php echo e(__('messages.Banned')); ?></option>
                                    <option value="3" <?php echo e(request('status') == '3' ? 'selected' : ''); ?>>
                                        <?php echo e(__('messages.Waiting_Approve')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><?php echo e(__('messages.Min_Balance')); ?></label>
                                <input type="number" name="min_balance" class="form-control" step="0.01"
                                    value="<?php echo e(request('min_balance')); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><?php echo e(__('messages.Max_Balance')); ?></label>
                                <input type="number" name="max_balance" class="form-control" step="0.01"
                                    value="<?php echo e(request('max_balance')); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-search"></i> <?php echo e(__('messages.Search')); ?>

                                    </button>
                                    <a href="<?php echo e(route('drivers.index')); ?>" class="btn btn-secondary btn-block mt-1">
                                        <i class="fas fa-redo"></i> <?php echo e(__('messages.Reset')); ?>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo e(__('messages.Driver_List')); ?></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th><?php echo e(__('messages.ID')); ?></th>
                                <th><?php echo e(__('messages.Photo')); ?></th>
                                <th><?php echo e(__('messages.Name')); ?></th>
                                <th><?php echo e(__('messages.Phone')); ?></th>
                                <th><?php echo e(__('messages.Car')); ?></th>
                                <th><?php echo e(__('messages.Balance')); ?></th>
                                <th><?php echo e(__('messages.Status')); ?></th>
                                <th><?php echo e(__('messages.Actions')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($driver->id); ?></td>
                                    <td>
                                        <?php if($driver->photo): ?>
                                            <img src="<?php echo e(asset('assets/admin/uploads/' . $driver->photo)); ?>"
                                                alt="<?php echo e($driver->name); ?>" width="50">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('assets/admin/img/no-image.png')); ?>"
                                                alt="<?php echo e(__('messages.No_Image')); ?>" width="50">
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo e($driver->name); ?>

                                        <?php if($driver->activate == 2 && $driver->activeBan): ?>
                                            <br>
                                            <small class="text-danger">
                                                <i class="fas fa-ban"></i>
                                                <?php echo e($driver->activeBan->is_permanent ? __('messages.Banned_Permanently') : __('messages.Banned_Until') . ' ' . $driver->activeBan->ban_until->format('Y-m-d H:i')); ?>

                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($driver->country_code); ?> <?php echo e($driver->phone); ?></td>
                                    <td>
                                        <?php echo e($driver->model ?? __('messages.N/A')); ?>

                                        <?php if($driver->color): ?>
                                            <span class="badge badge-info"><?php echo e($driver->color); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($driver->balance); ?></td>
                                    <td>
                                        <?php if($driver->activate == 1): ?>
                                            <span class="badge badge-success"><?php echo e(__('messages.Active')); ?></span>
                                        <?php elseif($driver->activate == 2): ?>
                                            <span class="badge badge-danger"><?php echo e(__('messages.Banned')); ?></span>
                                        <?php elseif($driver->activate == 3): ?>
                                            <span class="badge badge-warning"><?php echo e(__('messages.Waiting_Approve')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap">
                                            <a href="<?php echo e(route('drivers.show', $driver->id)); ?>"
                                                class="btn btn-info btn-sm mr-1 mb-1" title="<?php echo e(__('messages.View')); ?>">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('drivers.edit', $driver->id)); ?>"
                                                class="btn btn-primary btn-sm mr-1 mb-1" title="<?php echo e(__('messages.Edit')); ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-sm mr-1 mb-1"
                                                data-toggle="modal" data-target="#topUpModal<?php echo e($driver->id); ?>"
                                                title="<?php echo e(__('messages.Top_Up_Balance')); ?>">
                                                <i class="fas fa-wallet"></i>
                                            </button>
                                            <a href="<?php echo e(route('drivers.transactions', $driver->id)); ?>"
                                                class="btn btn-secondary btn-sm mr-1 mb-1"
                                                title="<?php echo e(__('messages.Transactions')); ?>">
                                                <i class="fas fa-money-bill"></i>
                                            </a>

                                            <?php if($driver->activate == 2): ?>
                                                <!-- Unban Button -->
                                                <button type="button" class="btn btn-warning btn-sm mr-1 mb-1"
                                                    data-toggle="modal" data-target="#unbanModal<?php echo e($driver->id); ?>"
                                                    title="<?php echo e(__('messages.Unban_Driver')); ?>">
                                                    <i class="fas fa-unlock"></i>
                                                </button>
                                            <?php else: ?>
                                                <!-- Ban Button -->
                                                <a href="<?php echo e(route('drivers.ban.form', $driver->id)); ?>"
                                                    class="btn btn-danger btn-sm mr-1 mb-1"
                                                    title="<?php echo e(__('messages.Ban_Driver')); ?>">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                            <?php endif; ?>

                                            <!-- Ban History Button -->
                                            <a href="<?php echo e(route('drivers.ban.history', $driver->id)); ?>"
                                                class="btn btn-dark btn-sm mr-1 mb-1"
                                                title="<?php echo e(__('messages.Ban_History')); ?>">
                                                <i class="fas fa-history"></i>
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <?php echo e(__('messages.Showing')); ?> <?php echo e($drivers->firstItem() ?? 0); ?> <?php echo e(__('messages.To')); ?>

                        <?php echo e($drivers->lastItem() ?? 0); ?> <?php echo e(__('messages.Of')); ?> <?php echo e($drivers->total()); ?>

                        <?php echo e(__('messages.Entries')); ?>

                    </div>
                    <div>
                        <?php echo e($drivers->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Up Modals -->
    <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="topUpModal<?php echo e($driver->id); ?>" tabindex="-1" role="dialog"
            aria-labelledby="topUpModalLabel<?php echo e($driver->id); ?>" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="topUpModalLabel<?php echo e($driver->id); ?>">
                            <?php echo e(__('messages.Top_Up_Balance_For')); ?>: <?php echo e($driver->name); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?php echo e(route('drivers.topUp', $driver->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <div class="text-center mb-4">
                                <?php if($driver->photo): ?>
                                    <img src="<?php echo e(asset('assets/admin/uploads/' . $driver->photo)); ?>"
                                        alt="<?php echo e($driver->name); ?>" class="img-profile rounded-circle"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                <?php else: ?>
                                    <img src="<?php echo e(asset('assets/admin/img/no-image.png')); ?>"
                                        alt="<?php echo e(__('messages.No_Image')); ?>" class="img-profile rounded-circle"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                <?php endif; ?>
                                <h5 class="mt-2"><?php echo e($driver->name); ?></h5>
                                <h6><?php echo e(__('messages.Current_Balance')); ?>: <span
                                        class="text-primary"><?php echo e($driver->balance); ?></span></h6>
                            </div>

                            <div class="form-group">
                                <label for="amount<?php echo e($driver->id); ?>"><?php echo e(__('messages.Amount')); ?> <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="amount<?php echo e($driver->id); ?>"
                                    name="amount" step="0.01" min="0.01" required>
                            </div>

                            <div class="form-group">
                                <label for="note<?php echo e($driver->id); ?>"><?php echo e(__('messages.Note')); ?></label>
                                <textarea class="form-control" id="note<?php echo e($driver->id); ?>" name="note" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal"><?php echo e(__('messages.Close')); ?></button>
                            <button type="submit" class="btn btn-primary"><?php echo e(__('messages.Add_To_Balance')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <!-- Unban Modals -->
    <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($driver->activate == 2): ?>
            <div class="modal fade" id="unbanModal<?php echo e($driver->id); ?>" tabindex="-1" role="dialog"
                aria-labelledby="unbanModalLabel<?php echo e($driver->id); ?>" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title" id="unbanModalLabel<?php echo e($driver->id); ?>">
                                <i class="fas fa-unlock"></i> <?php echo e(__('messages.Unban_Driver')); ?>: <?php echo e($driver->name); ?>

                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?php echo e(route('drivers.unban', $driver->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="modal-body">
                                <?php if($driver->activeBan): ?>
                                    <div class="alert alert-info">
                                        <strong><?php echo e(__('messages.Current_Ban_Info')); ?>:</strong><br>
                                        <strong><?php echo e(__('messages.Reason')); ?>:</strong>
                                        <?php echo e($driver->activeBan->getReasonText()); ?><br>
                                        <strong><?php echo e(__('messages.Type')); ?>:</strong>
                                        <?php echo e($driver->activeBan->is_permanent ? __('messages.Permanent') : __('messages.Temporary')); ?><br>
                                        <?php if(!$driver->activeBan->is_permanent): ?>
                                            <strong><?php echo e(__('messages.Until')); ?>:</strong>
                                            <?php echo e($driver->activeBan->ban_until->format('Y-m-d H:i')); ?><br>
                                            <strong><?php echo e(__('messages.Remaining')); ?>:</strong>
                                            <?php echo e($driver->activeBan->getRemainingTime()); ?>

                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="form-group">
                                    <label for="unban_reason<?php echo e($driver->id); ?>"><?php echo e(__('messages.Unban_Reason')); ?>

                                        (<?php echo e(__('messages.Optional')); ?>)</label>
                                    <textarea class="form-control" id="unban_reason<?php echo e($driver->id); ?>" name="unban_reason" rows="3"
                                        placeholder="<?php echo e(__('messages.Enter_Reason_For_Unbanning')); ?>"></textarea>
                                </div>

                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <?php echo e(__('messages.Unban_Confirmation_Message')); ?>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"><?php echo e(__('messages.Cancel')); ?></button>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-unlock"></i> <?php echo e(__('messages.Unban_Driver')); ?>

                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/admin/drivers/index.blade.php ENDPATH**/ ?>