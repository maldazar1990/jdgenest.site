<header class="header text-center">
    <?php

    if(!isset($options)){
        $options = \App\options_table::all()->pluck("option_value","option_name")->toArray();
    }

    if(!isset($userInfo)){
        $userInfo = \App\Users::find(1);
    }
    ?>
    <h1 class="blog-name pt-lg-4 mb-0"><a class="no-text-decoration header-text" style="z-index:1" href="<?php echo e(route("default")); ?>"><?php echo e($options['nom']); ?></a></h1>

    <nav class="navbar navbar-expand-lg navbar-dark" >

        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar top-bar"></span>
            <span class="icon-bar middle-bar"></span>
            <span class="icon-bar bottom-bar"></span>
        </button>

        <div id="navigation" class="collapse navbar-collapse flex-column" >
            <div class="profile-section pt-3 pt-lg-0">
                <?php echo $__env->make("theme.blog.layout.image", ['image' => $userInfo->image,"class" => "profile-image mb-3 rounded-circle mx-auto img-cover","size"=>"small"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="bio mb-3"><?php echo e($options["simple_presentation"]); ?></div><!--//bio-->
                <ul class="social-list list-inline py-3 mx-auto">
                    <li class="list-inline-item"><a href="<?php echo e($options["linkedin"]); ?>"><i class="fab fa-linkedin-in fa-fw"></i></a></li>
                    <li class="list-inline-item"><a href="<?php echo e($options['gitlab']); ?>"><i class="fab fa-github-alt fa-fw"></i></a></li>
                </ul><!--//social-list-->
                <hr>
            </div><!--//profile-section-->

            <?php echo $__env->make("theme.blog.layout.nav", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </nav>
</header>
<?php /**PATH C:\dev\jdgenest\resources\views/theme/blog/layout/header.blade.php ENDPATH**/ ?>