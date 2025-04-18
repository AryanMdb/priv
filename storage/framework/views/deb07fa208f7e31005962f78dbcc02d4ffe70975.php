<?php if(isset($cmsPageData->title)): ?>
    <?php $__env->startSection('title', $cmsPageData->title); ?>
<?php endif; ?>
<?php $__env->startSection('contant'); ?>

<div class="container">
        <div class="cms-page">
            <?php if(isset($cmsPageData)): ?>
                <?php if(isset($cmsPageData->title)): ?>
                <h2><?php echo e($cmsPageData->title); ?></h2>
                <?php endif; ?>
                <!-- <?php if(isset($cmsPageData->icon_image)): ?>
                <div class="img-block">
                    <img src="<?php echo e(asset('pages/icon').'/'.$cmsPageData->icon_image); ?>" alt="<?php echo e($cmsPageData->title); ?>">
                </div>
                <?php endif; ?> -->

                <?php if(isset($cmsPageData->description)): ?>
                    <?php echo $cmsPageData->description; ?>
                <?php endif; ?>
            <?php else: ?>
                <h3><?php echo e('Data Not Found'); ?></h3>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cmsPage.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\The Mad Brains\messho\resources\views/cmsPage/index.blade.php ENDPATH**/ ?>