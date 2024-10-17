<?php if($searchBy): ?>
  <?php $__env->startComponent('laravel-views::components.form.input-group', [
    'placeholder' => 'Search',
    'model' => 'search',
    'onClick' => 'clearSearch',
    'icon' => $search ? 'x-circle' : 'search',
    ]); ?>
  <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php /**PATH C:\dev\jdgenest\resources\views/vendor/laravel-views/components/toolbar/search.blade.php ENDPATH**/ ?>