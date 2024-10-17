<?php if($ext and $filename): ?>
    <?php
        $image = $filename.".".$ext;
        $imageMedium = $filename . '_medium.' . $ext;
        $imageSmall = $filename . '_small.' . $ext;
    ?>

    <?php if($size): ?>
        <?php
            switch ($size) {
                case('small'):
                    $image = $imageSmall;
                    break;
                case('medium'):
                    $image = $imageMedium;
                    break;
                default:
                    $image = $image;
            }

            if (!file_exists(public_path($image))){
                $image = $filename.".".$ext;
            }

        ?>
        <source srcset="<?php echo e(asset($image)); ?>" type="image/<?php echo e($ext); ?>">
    <?php else: ?>
        <?php if(File::exists(public_path($image))): ?>
            <?php if( File::exists(public_path($imageMedium)) and File::exists(public_path($imageSmall))): ?>
                <source media="(min-width:769px)" srcSet="<?php echo e(asset($image)); ?>" type="image/<?php echo e($ext); ?>"/>
                <source media="(max-width:768px)" srcSet="<?php echo e(asset($imageMedium)); ?>" type="image/<?php echo e($ext); ?>"/>
                <source media="(max-width:576px)" srcSet="<?php echo e(asset($imageSmall)); ?>" type="image/<?php echo e($ext); ?>"/>
            <?php endif; ?>
            <source srcSet="<?php echo e(asset($image)); ?>" type="image/<?php echo e($ext); ?>"/>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\dev\jdgenest\resources\views/theme/blog/layout/source.blade.php ENDPATH**/ ?>