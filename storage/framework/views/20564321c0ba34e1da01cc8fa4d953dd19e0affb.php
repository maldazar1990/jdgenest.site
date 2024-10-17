

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['size' => 'lg', 'dropDownWidth' => null, 'label' => '',]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['size' => 'lg', 'dropDownWidth' => null, 'label' => '',]); ?>
<?php foreach (array_filter((['size' => 'lg', 'dropDownWidth' => null, 'label' => '',]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
  $sizes = [
    'full' => 'full',
    'sm' => 'w-48',
    'lg' => 'w-64'
  ]
?>

<div
  class="relative"
  x-data="{ open: false }"
>
  <span @click="open = true" class="cursor-pointer">
    <?php if($label): ?>
      <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'laravel-views::components.buttons.select','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('lv-select-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <?php echo e(__($label)); ?>

       <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php else: ?>
      <?php if(isset($trigger)): ?>
        <?php echo e($trigger); ?>

      <?php endif; ?>
    <?php endif; ?>
  </span>

  <div
    class="bg-white shadow-lg rounded absolute top-8 right-0 border text-left z-10 <?php echo e(isset($dropDownWidth) ? "w-$dropDownWidth" : ''); ?> <?php echo e($sizes[$size]); ?>"
    x-show.transition="open"
    @click.away="open = false"
    x-cloak
  >
    <?php echo e($slot); ?>

  </div>
</div><?php /**PATH C:\dev\jdgenest\resources\views/vendor/laravel-views/components/dropdown/drop-down.blade.php ENDPATH**/ ?>