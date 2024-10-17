<?php $__env->startSection("content"); ?>

    <?php echo $__env->make("theme.blog.layout.search", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php echo $__env->make("theme.blog.layout.post", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="alert alert-warning">
            <h3 class="text-center">Aucun article trouvé</h3>
        </div>
    <?php endif; ?>
    <?php if(Request::has("search")): ?>
        <?php echo e($posts->appends(["search"=>Request::get("search")])->links("vendor.pagination.bootstrap-5")); ?>

    <?php else: ?>
        <?php echo e($posts->links("vendor.pagination.bootstrap-5")); ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('theme.blog.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\dev\jdgenest\resources\views/theme/blog/home.blade.php ENDPATH**/ ?>