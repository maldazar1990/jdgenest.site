

<div class="relative text-left mb-4">
  <label class="block">
    <?php echo e($label ?? ''); ?>

  </label>
  <input
    class="appearance-none w-full bg-white border-gray-300 hover:border-gray-500 px-3 py-2 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 focus:border-2 border"
    type="text"
    name="<?php echo e($name ?? ''); ?>"
    placeholder="<?php echo e($placeholder ?? ''); ?>"
    autocomplete="off"
    <?php if(isset($id)): ?>
      id="<?php echo e($id ?? ''); ?>"
    <?php endif; ?>
    wire:model="<?php echo e($model ?? ''); ?>"
  >
  <div class="absolute right-0 top-0 mt-2 mr-4 text-purple-lighter">
    <a wire:click.prevent="<?php echo e($onClick ?? ''); ?>" href="#" class="text-gray-400 hover:text-blue-600">
      <i data-feather="<?php echo e($icon); ?>" class="w-4"></i>
    </a>
  </div>
</div><?php /**PATH C:\dev\jdgenest\resources\views/vendor/laravel-views/components/form/input-group.blade.php ENDPATH**/ ?>