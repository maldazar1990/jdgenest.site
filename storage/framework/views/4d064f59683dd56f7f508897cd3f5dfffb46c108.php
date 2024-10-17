<ul class="navbar-nav flex-column text-start">
    <li class="nav-item">
        <a class="nav-link <?php echo e((Route::currentRouteName()=="default")?"active":""); ?>" href="<?php echo e(route("default")); ?>"><i class="fas fa-home fa-fw me-2"></i>Blogue</a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link <?php echo e((str_contains(url()->current(),"about"))?"active":""); ?>" href="<?php echo e(route("about")); ?>"><i class="fas fa-user fa-fw me-2"></i>À mon sujet</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php echo e((str_contains(url()->current(),"contact"))?"active":""); ?>" href="<?php echo e(route("contact")); ?>"><i class="fas fa-address-book fa-fw me-2"></i>Contact</a>
    </li>
</ul>
<?php /**PATH C:\dev\jdgenest\resources\views/theme/blog/layout/nav.blade.php ENDPATH**/ ?>