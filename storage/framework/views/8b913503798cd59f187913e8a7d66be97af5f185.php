<?php
 $action = route("archive");

 if( Route::getCurrentRoute()->getName() == "archiveByTag"){
     $action = route("archiveByTag",$tagId);
 }
?>
<form action="<?php echo e($action); ?>" method="get" class="mb-2 row">
    <div class="input-group">
        <input type="text" class="form-control" required minlength="3" maxlength="20" placeholder="Rechercher" name="search"
        <?php if(Request::has("search")): ?>
            value="<?php echo e(Request::get("search")); ?>"
        <?php endif; ?>
        >

        <div class="input-group-append">
            <button class="btn btn-secondary" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
</form>
<div class="mb-5 w-100 d-flex flex-wrap overflow-hidden">
    <?php
        $search = (Request::has("search")) ? "?search=".Request::get("search") : null;
    ?>
    <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if( $tag->id == $tagId): ?>
            <span class="badge bg-secondary m-1"><?php echo e($tag->title); ?></span>
        <?php else: ?>
            <a class="badge badge-pill bg-primary disable-link m-1" href="<?php echo e(route("archiveByTag",$tag).$search); ?>"><?php echo e($tag->title); ?></a>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if(Request::has("search") or \Illuminate\Support\Str::contains(url()->current(),'archive')): ?>
        <a class="badge badge-pill bg-danger disable-link m-1" href="<?php echo e(route("default")); ?>">Réinialiser la recherche</a>
    <?php endif; ?>
</div>

<?php /**PATH C:\dev\jdgenest\resources\views/theme/blog/layout/search.blade.php ENDPATH**/ ?>