<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo e(__('messages.Ratings')); ?></h1>
    </div>

    <!-- Success Message -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                <?php echo e(__('messages.Total_Ratings')); ?>

                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($statistics['total']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-star fa-2x text-gray-300"></i>
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
                                <?php echo e(__('messages.Average_Rating')); ?>

                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($statistics['average']); ?>/5</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
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
                                <?php echo e(__('messages.Five_Star_Ratings')); ?>

                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($statistics['five_star']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-heart fa-2x text-gray-300"></i>
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
                                <?php echo e(__('messages.One_Star_Ratings')); ?>

                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($statistics['one_star']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rating Distribution Chart -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo e(__('messages.Rating_Distribution')); ?></h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php $__currentLoopData = [5,4,3,2,1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $star): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mb-3">
                        <div class="d-flex align-items-center">
                            <span class="mr-2" style="min-width: 60px;"><?php echo e($star); ?> <i class="fas fa-star text-warning"></i></span>
                            <div class="progress flex-grow-1" style="height: 25px;">
                                <?php
                                    $starCount = $statistics[$star == 5 ? 'five_star' : ($star == 4 ? 'four_star' : ($star == 3 ? 'three_star' : ($star == 2 ? 'two_star' : 'one_star')))];
                                    $percentage = $statistics['total'] > 0 ? round(($starCount / $statistics['total']) * 100) : 0;
                                ?>
                                <div class="progress-bar bg-<?php echo e($star >= 4 ? 'success' : ($star == 3 ? 'warning' : 'danger')); ?>" 
                                     role="progressbar" 
                                     style="width: <?php echo e($percentage); ?>%;" 
                                     aria-valuenow="<?php echo e($percentage); ?>" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    <?php echo e($percentage); ?>%
                                </div>
                            </div>
                            <span class="ml-2" style="min-width: 40px;"><?php echo e($starCount); ?></span>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo e(__('messages.Filters')); ?></h6>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('ratings.index')); ?>">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="rating"><?php echo e(__('messages.Rating')); ?></label>
                            <select class="form-control" id="rating" name="rating">
                                <option value=""><?php echo e(__('messages.All')); ?></option>
                                <option value="5" <?php echo e(request('rating') == '5' ? 'selected' : ''); ?>>5 <?php echo e(__('messages.Stars')); ?></option>
                                <option value="4" <?php echo e(request('rating') == '4' ? 'selected' : ''); ?>>4 <?php echo e(__('messages.Stars')); ?></option>
                                <option value="3" <?php echo e(request('rating') == '3' ? 'selected' : ''); ?>>3 <?php echo e(__('messages.Stars')); ?></option>
                                <option value="2" <?php echo e(request('rating') == '2' ? 'selected' : ''); ?>>2 <?php echo e(__('messages.Stars')); ?></option>
                                <option value="1" <?php echo e(request('rating') == '1' ? 'selected' : ''); ?>>1 <?php echo e(__('messages.Star')); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="search"><?php echo e(__('messages.Search')); ?></label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   placeholder="<?php echo e(__('messages.Search_by_user_driver_or_review')); ?>" 
                                   value="<?php echo e(request('search')); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> <?php echo e(__('messages.Filter')); ?>

                                </button>
                                <a href="<?php echo e(route('ratings.index')); ?>" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> <?php echo e(__('messages.Reset')); ?>

                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Ratings Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo e(__('messages.All_Ratings')); ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?php echo e(__('messages.ID')); ?></th>
                            <th><?php echo e(__('messages.User')); ?></th>
                            <th><?php echo e(__('messages.Driver')); ?></th>
                            <th><?php echo e(__('messages.Rating')); ?></th>
                            <th><?php echo e(__('messages.Review')); ?></th>
                            <th><?php echo e(__('messages.Date')); ?></th>
                            <th><?php echo e(__('messages.Actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $ratings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($rating->id); ?></td>
                            <td><?php echo e($rating->user ? $rating->user->name : __('messages.Not_Available')); ?></td>
                            <td><?php echo e($rating->driver ? $rating->driver->name : __('messages.Not_Available')); ?></td>
                            <td>
                                <span class="badge badge-<?php echo e($rating->rating_badge); ?>">
                                    <?php echo e($rating->rating); ?> <i class="fas fa-star"></i>
                                </span>
                                <br>
                                <small><?php echo $rating->stars; ?></small>
                            </td>
                            <td>
                                <?php if($rating->review): ?>
                                    <?php echo e(Str::limit($rating->review, 50)); ?>

                                <?php else: ?>
                                    <em class="text-muted"><?php echo e(__('messages.No_Review')); ?></em>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($rating->created_at->format('Y-m-d H:i')); ?></td>
                            <td>
                              
                                <form action="<?php echo e(route('ratings.destroy', $rating)); ?>" 
                                      method="POST" 
                                      style="display: inline-block;"
                                      onsubmit="return confirm('<?php echo e(__('messages.Are_you_sure_delete_rating')); ?>');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger" 
                                            title="<?php echo e(__('messages.Delete')); ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center"><?php echo e(__('messages.No_Ratings_Found')); ?></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-3">
                <?php echo e($ratings->appends(request()->query())->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taksi\resources\views/admin/ratings/index.blade.php ENDPATH**/ ?>