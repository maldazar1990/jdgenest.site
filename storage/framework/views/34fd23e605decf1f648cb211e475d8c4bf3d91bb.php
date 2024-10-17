<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['actions', 'model' => null]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['actions', 'model' => null]); ?>
<?php foreach (array_filter((['actions', 'model' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php $__currentLoopData = $actions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php if($action->renderIf($model, $this)): ?>
    <button
      wire:click.prevent="<?php echo e($model ? "executeAction('{$action->id}','{$model->getKey()}')" : "executeBulkAction('{$action->id}')"); ?>"
      title="<?php echo e($action->title); ?>"
      class="group flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900 w-full focus:outline-none"
    >
      <i data-feather="<?php echo e($action->icon); ?>" class="mr-3 h-4 w-4 text-gray-600 group-hover:text-gray-700"></i>
      <?php echo e($action->title); ?>

    </button>
  <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH C:\dev\jdgenest\resources\views/vendor/laravel-views/components/actions/icon-and-title.blade.php ENDPATH**/ ?>