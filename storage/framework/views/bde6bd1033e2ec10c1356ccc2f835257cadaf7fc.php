<?php if(isset($post) and $post instanceof \App\post): ?>
    <div class="meta w-100 mb-2 single-col-max-width"><span class="date">
            <?php echo e($post->created_at->format("Y-m-d")); ?>&nbsp;/&nbsp;
            <?php echo e(\Illuminate\Support\Str::wordCount($post->post)); ?> mots&nbsp;/&nbsp;
            <?php echo e(\App\HelperGeneral::wordToMinute($post->post)); ?> min de lecture
    </span></div>
<?php endif; ?>
<?php /**PATH C:\dev\jdgenest\resources\views/theme/blog/layout/infopost.blade.php ENDPATH**/ ?>