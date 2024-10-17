<picture>
    <?php
        if (!isset($class))
            $class = 'img-fluid';

        if (!isset($width))
            $width = '';

        if (!isset($height))
            $height = '';

        if (!isset($css))
            $css = '';

         if (!isset($size))
            $size = '';
    ?>
    <?php if($image): ?>

        <?php if(Str::contains($image, 'http')): ?>
            <img decoding="async" loading="lazy" class="<?php echo e($class); ?>" src="<?php echo e(asset($image)); ?>" alt="image" width="<?php echo e($width); ?>" height="<?php echo e($height); ?>" style="<?php echo e($css); ?>"/>
        <?php else: ?>
            <?php
                $image = 'images/' . $image;
                $filename = explode('.', $image);


            ?>
            
            <?php echo $__env->make("theme.blog.layout.source", ['filename' => $filename[0], 'ext' => 'webp',"size"=>$size], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <img
                class="<?php echo e($class); ?>"
                src="<?php echo e(asset($image.".webp")); ?>"
                alt="image non présent"
                style="<?php echo e($css); ?>"
                width="<?php echo e($width); ?>"
                height="<?php echo e($height); ?>"
            />
        <?php endif; ?>
    <?php else: ?>
        <img
            class="<?php echo e($class); ?>" decoding="async" loading="lazy"
            src="<?php echo e(asset('images/default.jpg')); ?>" alt="bug"  width="<?php echo e($width); ?>" height="<?php echo e($height); ?>" style="<?php echo e($css); ?>"/>
    <?php endif; ?>
</picture>
<?php /**PATH C:\dev\jdgenest\resources\views/theme/blog/layout/image.blade.php ENDPATH**/ ?>