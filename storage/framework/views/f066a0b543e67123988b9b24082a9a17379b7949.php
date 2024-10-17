<?php $__env->startSection("content"); ?>
    <div class="col-12">
        <script>
            function onSubmit(token) {
                document.querySelector("form").submit();
        }
        </script>
        <script src="https://www.google.com/recaptcha/api.js" defer></script>
        <div class="mb-4">
            <?php if(Session::has('message')): ?>
                <div class="alert alert-success">
                    <?php echo e(Session::get('message')); ?>

                </div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="flex p-1">
                <style>
                    .emailfield{
                        display:none;
                    }
                </style>
                <?php echo form_start($form); ?>

                <input name="email" type="email" value="" class="emailfield">
                <?php echo form_row($form->name); ?>

                <?php echo form_row($form->savon); ?>

                <?php echo form_row($form->text); ?>

                    <?php if(config("app.env")=="local"): ?>
                        <button  type="submit"
                             class="btn btn-primary">
                        Envoyer
                        </button>
                    <?php else: ?>
                    <button  type="submit"
                             class="btn btn-primary g-recaptcha"
                             data-sitekey="<?php echo e(config("app.recaptcha")); ?>"
                             data-callback='onSubmit'
                             data-action='submit'>
                        Envoyer
                    </button>
                    <?php endif; ?>
                <?php echo form_end($form); ?>

            </div>
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('theme.blog.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\dev\jdgenest\resources\views/theme/blog/contact.blade.php ENDPATH**/ ?>