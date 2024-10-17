
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['icon', 'class']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['icon', 'class']); ?>
<?php foreach (array_filter((['icon', 'class']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<i data-feather="<?php echo e($icon); ?>" class="<?php echo e(variants()->featherIcon($type)->class()); ?> <?php echo e($class); ?>"></i><?php /**PATH C:\dev\jdgenest\resources\views/vendor/laravel-views/components/icon.blade.php ENDPATH**/ ?>