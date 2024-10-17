<div class="flex-wrap overflow-hidden">
    <?php
        $tagId = (isset($tagId)) ? $tagId : null;
        if(Request::is('about')){
            $tags = null;
            foreach($userInfo->infos()->get() as $info){
                foreach($info->tags()->groupBy("tags.id")->get() as $tag){
                    $tags[$tag->id] = $tag;
                }
            }
        } else {
            $tags = $post->tags()->groupBy("tags.id")->get();
        }

    ?>
    <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if( $tag->id == $tagId): ?>
            <span data-class="<?php echo e(\Illuminate\Support\Str::slug($tag->title)); ?>" data-listclass="<?php echo e(\Illuminate\Support\Str::slug($tag->title)); ?>" class="badge bg-secondary me-1 order  pointer-event"><?php echo e($tag->title); ?></span>
        <?php else: ?>
            <?php
                $href = 'href='.route("archiveByTag",$tag);
                if(Request::is('about')){
                    $href = '';
                }
            ?>
            <a data-class="<?php echo e(\Illuminate\Support\Str::slug($tag->title)); ?>" data-listclass="<?php echo e(\Illuminate\Support\Str::slug($tag->title)); ?>" class="badge badge-pill bg-primary disable-link  me-1 order  pointer-event" <?php echo e($href); ?>><?php echo e($tag->title); ?></a>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php if(Request::is('about')): ?>
        <span class="clean-tag badge badge-pill bg-danger disable-link  me-1 d-none pointer-event">Nettoyer</span>
    <?php endif; ?>
</div>
<?php /**PATH C:\dev\jdgenest\resources\views/theme/blog/layout/tags.blade.php ENDPATH**/ ?>