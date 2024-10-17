<div class="main-wrapper min-vh-100 d-flex flex-column justify-content-between">

    <?php if(Route::currentRouteName() != "post"): ?>
        <section class="cta-section theme-bg-light py-5">
            <div class="container text-center single-col-max-width">
            <?php if(Request::is("about")): ?>
                <h2 class="heading"><?php echo e((isset($title))?$title:""); ?></h2>
                <div class="title-intro"><?php echo (isset($message))?$message:""; ?></div>
                <a class="btn btn-primary center-btn" href="<?php echo e(route("contact")); ?>">Pour me contacter</a>
            <?php else: ?>
                <h2 class="heading"><?php echo e((isset($title))?$title:""); ?></h2>
                <div class="title-intro" id="title">
                    <?php echo e((isset($message))?$message:""); ?>

                </div>
            <?php endif; ?>
            </div><!--//container-->
        </section>
    <?php endif; ?>

    <section class="blog-list d-flex flex-column justify-content-between">
        <div class="container single-col-max-width pt-3 pb-3">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </section>

    <?php echo $__env->make("theme.blog.layout.footer", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</div><!--//main-wrapper-->
<?php /**PATH C:\dev\jdgenest\resources\views/theme/blog/layout/main.blade.php ENDPATH**/ ?>