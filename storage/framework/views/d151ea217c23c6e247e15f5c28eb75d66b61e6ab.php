<?php if (isset($component)) { $__componentOriginald5eb4dca035b3c477f4ee1b1bc1139e850b8c56c = $component; } ?>
<?php $component = LaravelViews\Views\Components\DynamicComponent::resolve(['view' => $view,'data' => $data] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('lv-dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(LaravelViews\Views\Components\DynamicComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald5eb4dca035b3c477f4ee1b1bc1139e850b8c56c)): ?>
<?php $component = $__componentOriginald5eb4dca035b3c477f4ee1b1bc1139e850b8c56c; ?>
<?php unset($__componentOriginald5eb4dca035b3c477f4ee1b1bc1139e850b8c56c); ?>
<?php endif; ?>
<?php /**PATH C:\dev\jdgenest\vendor\laravel-views\laravel-views\src/../resources/views/core/dynamic-component.blade.php ENDPATH**/ ?>