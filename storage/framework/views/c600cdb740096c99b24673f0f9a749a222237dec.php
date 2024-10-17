<div class="item mb-5">
    <div class="row g-3 g-xl-0 post-box">
        <div class="align-items-center col-xm-12 col-sm-5 col-md-5 col-lg-5 col-xl-4 d-flex">
            <?php echo $__env->make("theme.blog.layout.image", ['image' => $post->image,"class" => "img-fluid","size"=>"small"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <div class="col-lg-7 col-xl-8 col-md-7 col-sm-7 col-xm-12 ps-xl-2 pt-xl-2 pb-xl-2">
            <h3 class="title mb-1"><a class="text-link" href="<?php echo e(route("post",$post->slug)); ?>"><?php echo e($post->title); ?></a></h3>
            <?php echo $__env->make("theme.blog.layout.infopost", ['post' => $post], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="mb-1">
                <?php echo $__env->make("theme.blog.layout.tags", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <?php
                $smartpost = strip_tags($post->post);
                $smartpost = str_replace('&nbsp;', ' ', $smartpost);
                $smartpost =  Str::words($smartpost, 30, '....');

            ?>
            <div class="intro"><?php echo e($smartpost); ?></div>
            <a class="text-link" href="<?php echo e(route("post",$post)); ?>">Pour continuer &rarr;</a>
        </div><!--//col-->
    </div><!--//row-->
</div>
<?php /**PATH C:\dev\jdgenest\resources\views/theme/blog/layout/post.blade.php ENDPATH**/ ?>