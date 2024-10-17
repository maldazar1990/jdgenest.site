<header class="page-header row justify-center">
    <?php
        if (Auth::user()->image)
            $image = asset("images/".Auth::user()->image);
        else
            $image = asset("images/default.png");
    ?>
    <div class="dropdown user-dropdown col-md-12 col-lg-12 text-right text-md-right"><a class="btn btn-stripped dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="<?php echo e($image); ?>" alt="profile photo" class="circle float-left profile-photo" width="50" height="auto">
            <div class="username mt-1">
                <h4 class="mb-1"><?php echo e(Auth::user()->name); ?></h4>

                <?php $__currentLoopData = Auth::user()->roles()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <h6 class="mb-1"><?php echo e($role->name); ?></h6>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right" style="margin-right: 1.5rem;" aria-labelledby="dropdownMenuLink">
            <a class="dropdown-item" href="<?php echo e(route("admin_user")); ?>"><em class="fa fa-user-circle mr-1"></em> Profile</a>
            <a class="dropdown-item" href="<?php echo e(route("default")); ?>"><em class="fa fa-link mr-1"></em> Site Web</a>
            <a class="dropdown-item" href="<?php echo e(route("get-logout")); ?>"><em class="fa fa-power-off mr-1"></em> déconnection</a>
        </div>
    </div>
    <div class="clear"></div>
</header>
<?php /**PATH C:\dev\jdgenest\resources\views/admin/layouts/header-nav.blade.php ENDPATH**/ ?>