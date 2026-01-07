<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"><?php echo e(__('messages.Country Charges')); ?></h3>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('countryCharge-add')): ?>
                        <a href="<?php echo e(route('country-charges.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> <?php echo e(__('messages.Add Country Charge')); ?>

                        </a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th><?php echo e(__('messages.Country Name')); ?></th>
                                    <th><?php echo e(__('messages.Charge Data Count')); ?></th>
                                    <th><?php echo e(__('messages.Created At')); ?></th>
                                    <th><?php echo e(__('messages.Actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $countryCharges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $countryCharge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration + ($countryCharges->currentPage() - 1) * $countryCharges->perPage()); ?></td>
                                        <td>
                                            <strong><?php echo e($countryCharge->name); ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-info"><?php echo e($countryCharge->chargeData->count()); ?> <?php echo e(__('messages.Items')); ?></span>
                                        </td>
                                        <td><?php echo e($countryCharge->created_at->format('Y-m-d H:i')); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-secondary" 
                                                    data-toggle="modal" 
                                                    data-target="#viewModal<?php echo e($countryCharge->id); ?>">
                                                <i class="fas fa-eye"></i> <?php echo e(__('messages.View Details')); ?>

                                            </button>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('countryCharge-edit')): ?>
                                                <a href="<?php echo e(route('country-charges.edit', $countryCharge->id)); ?>" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-edit"></i> <?php echo e(__('messages.Edit')); ?>

                                                </a>
                                            <?php endif; ?>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('countryCharge-delete')): ?>
                                                <form action="<?php echo e(route('country-charges.destroy', $countryCharge->id)); ?>" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('<?php echo e(__('messages.Are you sure you want to delete this country charge?')); ?>')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i> <?php echo e(__('messages.Delete')); ?>

                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <?php echo e(__('messages.No country charges found')); ?>

                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <?php echo e($countryCharges->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals Section - Outside the table -->
<?php $__currentLoopData = $countryCharges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $countryCharge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="viewModal<?php echo e($countryCharge->id); ?>" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel<?php echo e($countryCharge->id); ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel<?php echo e($countryCharge->id); ?>"><?php echo e($countryCharge->name); ?> - <?php echo e(__('messages.Charge Data')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo e(__('messages.Name')); ?></th>
                                    <th><?php echo e(__('messages.Phone')); ?></th>
                                    <th><?php echo e(__('messages.Cliq Name')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $countryCharge->chargeData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($data->name); ?></td>
                                        <td><?php echo e($data->phone); ?></td>
                                        <td><?php echo e($data->cliq_name); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <?php echo e(__('messages.Close')); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/admin/country-charges/index.blade.php ENDPATH**/ ?>