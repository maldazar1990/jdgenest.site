<?php $__env->startSection("content"); ?>

    <div class="col-12">
        <div class="card mb-4">
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
            <div class="card-block">
                <h3 class="card-title"><?php echo e($title); ?></h3>
                <?php
                    echo form_start($form);

                    $fieldName = "post";
                    if ($form instanceof App\Http\Forms\infosForm)
                        $fieldName = "description";

                    echo form_until($form, $fieldName);
                    $typeImage = 2;

                    if( isset($model) ) {
                        if (Str::contains($model->image, 'http')) {
                            $image = $model->image;
                            $typeImage = 0;
                        } else {
                            $filename = explode('.', $model->image);
                            $image = asset("images/" .$filename[0]."_small.webp");

                            if($form instanceof App\Http\Forms\PostForm) {
                                $lstImage = App\HelperGeneral::getImages();

                                if ( in_array($model->image, $lstImage) ) {
                                    $typeImage = 1;
                                } else {
                                    $typeImage = 2;
                                }
                            } else {
                                $typeImage = 2;
                            }

                        }

                        echo "
                            <h5>image actuel</h5>
                            <img src='".$image."' alt='image actuel' width='200px' class='img-fluid mb-3'>
                        ";

                    }
                ?>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link <?php echo e($typeImage==2?"active":""); ?>" id="nav-image-upload" data-toggle="tab" data-target="#nav-upload" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Uploader l'image</button>
                        <?php if($form instanceof App\Http\Forms\PostForm): ?>
                        <button class="nav-link <?php echo e($typeImage==1?"active":""); ?>" id="nav-image-select" data-toggle="tab" data-target="#nav-select" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Sélectionner une image existante</button>
                        <?php endif; ?>
                        <button class="nav-link <?php echo e($typeImage==0?"active":""); ?>" id="nav-image-url" data-toggle="tab" data-target="#nav-url" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Image en ligne</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade  <?php echo e($typeImage==2?"active show":""); ?> p-1" id="nav-upload" role="tabpanel" aria-labelledby="nav-image-upload">
                        <?php echo form_widget($form->image); ?>

                    </div>
                    <?php if($form instanceof App\Http\Forms\PostForm): ?>
                    <div class="tab-pane fade p-1 <?php echo e($typeImage==1?"active show":""); ?>" id="nav-select" role="tabpanel" aria-labelledby="nav-image-select">
                        <?php echo form_widget($form->selectImage); ?>

                    </div>
                    <?php endif; ?>
                    <div class="tab-pane fade p-1 <?php echo e($typeImage==0?"active show":""); ?>" id="nav-url" role="tabpanel" aria-labelledby="nav-image-url">
                        <?php echo form_widget($form->imageUrl); ?>

                    </div>
                </div>

                <?php
                    echo form_rest($form);
                    echo form_end($form);
                ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\dev\jdgenest\resources\views/admin/editWithImage.blade.php ENDPATH**/ ?>