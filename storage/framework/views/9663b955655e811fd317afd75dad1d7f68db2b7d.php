<?php $__env->startSection('title'); ?>
    <?php echo e(__('messages.ratings')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header bg-light py-3">
            <div class="row align-items-center justify-content-between">
                <!-- Left Section: Buttons -->
                <div class="col-md-6 d-flex align-items-center">
                    <a href="<?php echo e(route('ratings.create')); ?>" class="btn btn-sm btn-primary ml-2">
                        <i class="fa fa-plus"></i> <?php echo e(__('messages.New Rating')); ?>

                    </a>
                </div>

                <!-- Right Section: Search -->
                <div class="col-md-3">
                    <form method="get" action="<?php echo e(route('ratings.index')); ?>" class="d-flex justify-content-end">
                        <input autofocus type="text" 
                               placeholder="<?php echo e(__('messages.Search')); ?>" 
                               name="search" 
                               class="form-control mr-2" 
                               value="<?php echo e(request('search')); ?>">
                        <button class="btn btn-primary btn-sm">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="clearfix"></div>

            <div id="ajax_responce_serarchDiv" class="col-md-12">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ratings-table')): ?>
                    <?php if(isset($data) && count($data) > 0): ?>
                        <table id="example2" class="table table-bordered table-hover">
                            <thead class="custom_thead">
                                <tr>
                                    <th><?php echo e(__('messages.User')); ?></th>
                                    <th><?php echo e(__('messages.Class')); ?></th>
                                    <th><?php echo e(__('messages.Day')); ?></th>
                                    <th><?php echo e(__('messages.Date')); ?></th>
                                    <th><?php echo e(__('messages.Share Rating')); ?></th>
                                    <th><?php echo e(__('messages.Homework Rating')); ?></th>
                                    <th><?php echo e(__('messages.Save Rating')); ?></th>
                                    <th><?php echo e(__('messages.Recitation Rating')); ?></th>
                                    <th><?php echo e(__('messages.Quiz Rating')); ?></th>
                                    <th><?php echo e(__('messages.Actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <!-- User and Class -->
                                        <td><?php echo e($info->user->name ?? __('messages.Not Available')); ?></td>
                                        <td><?php echo e($info->class->name ?? __('messages.Not Available')); ?></td>

                                        <!-- Day and Date -->
                                        <td><?php echo e($info->day); ?></td>
                                        <td><?php echo e($info->date_of_rating); ?></td>

                                        <!-- Ratings -->
                                        <td><?php echo e($info->rating_of_share); ?></td>
                                        <td><?php echo e($info->rating_of_homework); ?></td>
                                        <td><?php echo e($info->rating_of_save); ?></td>
                                        <td><?php echo e($info->rating_of_recitation); ?></td>
                                        <td><?php echo e($info->rating_of_quiz); ?></td>

                                        <!-- Actions -->
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ratings-edit')): ?>
                                                <a href="<?php echo e(route('ratings.edit', $info->id)); ?>" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fa fa-edit"></i> <?php echo e(__('messages.Edit')); ?>

                                                </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ratings-delete')): ?>
                                                <form action="<?php echo e(route('ratings.destroy', $info->id)); ?>" 
                                                      method="POST" style="display:inline-block;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('<?php echo e(__('messages.Are you sure?')); ?>')">
                                                        <i class="fa fa-trash"></i> <?php echo e(__('messages.Delete')); ?>

                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <br>
                        <!-- Pagination -->
                        <?php echo e($data->appends(['search' => request('search')])->links()); ?>

                    <?php else: ?>
                        <div class="alert alert-danger">
                            <?php echo e(__('messages.No_data')); ?>

                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/admin/ratings/index.blade.php ENDPATH**/ ?>