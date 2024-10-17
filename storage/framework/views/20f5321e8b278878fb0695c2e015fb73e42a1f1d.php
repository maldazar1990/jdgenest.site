
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['type' => 'success', 'onClose' => '']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['type' => 'success', 'onClose' => '']); ?>
<?php foreach (array_filter((['type' => 'success', 'onClose' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="fixed z-50 bottom-0 left-0 w-full p-4 md:w-1/2 md:top-0 md:bottom-auto md:right-0 md:p-8 md:left-auto xl:w-1/3 h-auto rounded">
  <div class="bg-white rounded p-4 flex items-center shadow-lg h-auto border-gray-200 border">
    <div class="<?php echo e(variants("alerts.{$type}.icon")); ?> mr-4 rounded-full p-2">
      <div class="<?php echo e(variants("alerts.{$type}.base")); ?> rounded-full p-1 border-2">
        <i data-feather="<?php echo e(variants()->alert($type)->icon()); ?>" class="text-sm w-4 h-4 font-semibold"></i>
      </div>
    </div>

    <div class="flex-1">
      <b class="text-gray-900 font-semibold">
        <?php echo e(variants()->alert($type)->title()); ?>!
      </b>
      <div class="text-sm">
        <?php echo e($slot); ?>

      </div>
    </div>

    
    <button @click.prevent="<?php echo e($onClose ?? ''); ?>" class="text-gray-400 hover:text-gray-900 transition duration-300 ease-in-out cursor-pointer">
      <i data-feather="x-circle"></i>
    </button>
  </div>
</div><?php /**PATH C:\dev\jdgenest\resources\views/vendor/laravel-views/components/alert.blade.php ENDPATH**/ ?>