<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['variant' => 'primary', 'type' => 'button']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['variant' => 'primary', 'type' => 'button']); ?>
<?php foreach (array_filter((['variant' => 'primary', 'type' => 'button']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<button <?php echo e($attributes); ?> type="<?php echo e($type); ?>" class="px-4 py-2 text-sm border border-transparent font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 <?php echo e(variants('buttons.' . $variant)); ?>">
  <?php echo e($slot); ?>

</button><?php /**PATH C:\dev\jdgenest\resources\views/vendor/laravel-views/components/buttons/button.blade.php ENDPATH**/ ?>