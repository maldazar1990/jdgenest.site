<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['icon', 'size' => 'md']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['icon', 'size' => 'md']); ?>
<?php foreach (array_filter((['icon', 'size' => 'md']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<button <?php echo e($attributes); ?> class="<?php echo e($size === 'sm' ? 'p-1' : 'p-2'); ?> border-2 border-transparent text-gray-600 rounded-full hover:text-gray-700 focus:outline-none focus:text-gray-700 focus:bg-gray-100 transition duration-150 ease-in-out">
  <i data-feather="<?php echo e($icon); ?>" class="<?php echo e($size === 'sm' ? 'w-5 h-5' : ''); ?>"></i>
</button><?php /**PATH C:\dev\jdgenest\resources\views/vendor/laravel-views/components/buttons/icon.blade.php ENDPATH**/ ?>