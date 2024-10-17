<?php $__env->startSection("content"); ?>

    <div class="col-12">
        <div class=" mb-4">
            <?php if(Session::has('message')): ?>
                <div class="alert alert-success">
                    <?php echo e(Session::get('message')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php
            $actualRoute = Route::currentRouteName();
            $deleteRoute = "";
            switch($actualRoute){
                case "admin_msg":
                    $deleteRoute = "admin_msg_delete_all";
                    break;
                case "admin_comment":
                    $deleteRoute = "admin_comment_delete_all";
                    break;
                default:
            }
            ?>
            <?php if(!isset($liveWireTable)): ?>
            <div class="card-block grid_view">
                <h3 class="card-title"><?php echo e($title); ?></h3>
                <?php echo @grid_view($gridviews); ?>

                <?php if($deleteRoute != ""): ?>
                <form method="post" class="mt-1" action="<?php echo e(route($deleteRoute)); ?>" >
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-danger">Tous supprimer</button>
                </form>
                <?php endif; ?>
            </div>
            <?php else: ?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount($liveWireTable)->html();
} elseif ($_instance->childHasBeenRendered('4rKZrWw')) {
    $componentId = $_instance->getRenderedChildComponentId('4rKZrWw');
    $componentTag = $_instance->getRenderedChildComponentTagName('4rKZrWw');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('4rKZrWw');
} else {
    $response = \Livewire\Livewire::mount($liveWireTable);
    $html = $response->html();
    $_instance->logRenderedChild('4rKZrWw', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            <?php endif; ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\dev\jdgenest\resources\views/admin/index.blade.php ENDPATH**/ ?>