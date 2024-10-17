<?php $__env->startSection("content"); ?>
    <div class="d-flex flex-column align-items-center justify-center">

        <article class="about-section py-sm-2 py-md-3 py-lg-5">
            <div class="container pe-0 ps-0">
                
                <h4>Compétences</h4>
                <?php echo $__env->make("theme.blog.layout.tags", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="container mt-5 mb-5 ps-0 pe-0 justify-content-start align-items-start align-content-start">
                    <div class="row">
                        <div class="">
                            <h4>Études et expériences</h4>
                            <ul class="timeline">
                                <?php $__currentLoopData = $userInfo->infos()->where("type","!=","exp")->orderBy('datestart', 'desc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $tagClass = "";
                                    foreach ($info->tags()->get() as $tag){
                                        $tagClass .= " ".\Illuminate\Support\Str::slug($tag->title);
                                    }
                                    ?>
                                    <li class="d-flex flex-column about-me-general" data-listclass="<?php echo e($tagClass); ?>">
                                        <a target="_blank" class="link-secondary mb-1 " href="<?php echo e($info->link); ?>">
                                            <h5><?php echo e($info->title); ?></h5>
                                        </a>
                                        <div class="d-flex justify-content-start align-content-start">
                                            <?php echo $__env->make("theme.blog.layout.image", ['image' => $info->image,"class" => "mb-2 img-info", "css"=>"width: 200px;height: 100%;object-fit: contain;"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </div>
                                        <small>
                                            <?php if($info->dateend < \Illuminate\Support\Facades\Date::today()): ?>
                                                <span class="float-right w-100 mb-1"><?php echo e($info->datestart); ?>  à <?php echo e($info->dateend); ?></span>
                                            <?php else: ?>
                                                <span class="float-right w-100 mb-1">Depuis <?php echo e($info->datestart); ?></span>
                                            <?php endif; ?>
                                        </small>
                                        <div>
                                            <?php $__currentLoopData = $info->tags()->groupBy("tags.id")->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="badge badge-pill bg-secondary disable-link"><?php echo e($tag->title); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <a data-bs-toggle="collapse"
                                           class="nav-link collapsed"
                                           href="#<?php echo e(\Illuminate\Support\Str::slug($info->title,"_")); ?>"
                                           role="button">
                                            <small class="more-text">Pour plus de détails cliquez ici.<span class="active" >▲</span></small>
                                        </a>
                                        <div class="panel-collapse collapse in" aria-expanded="false"  id="<?php echo e(\Illuminate\Support\Str::slug($info->title,"_")); ?>">
                                            <p><?php echo trim($info->description); ?></p>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="container mt-5 mb-5 ps-0 pe-0 justify-content-start align-items-start align-content-start">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="mb-3">Projets</h4>
                            <div class="row row-cols-1 row-cols-md-2 g-4">
                                <?php $__currentLoopData = $userInfo->infos()->where("type","exp")->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        if (!\Illuminate\Support\Str::contains($info->image, 'http') and !empty($info->image)) {
                                            $image =  asset('images/' . $info->image);
                                        }else if (Str::contains($info->image, 'http')) {
                                            $image =  $info->image;
                                        } else {
                                            $image =  asset('images/default.jpg');
                                        }

                                        $tagClass = "";
                                        foreach ($info->tags()->get() as $tag){
                                            $tagClass .= " ".\Illuminate\Support\Str::slug($tag->title);
                                        }
                                        $smartpost = strip_tags($info->description);
                                        $smartpost = str_replace('&nbsp;', ' ', $smartpost);
                                        $smartpost =  Str::words($smartpost, 10, '....');
                                    ?>

                                    <div class="col" data-listclass="<?php echo e($tagClass); ?>">
                                        <div class="card">
                                            <div class="p-2">
                                                <?php echo $__env->make("theme.blog.layout.image", ['image' => $info->image,"class" => "card-img-top"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </div>
                                            <span class="ms-3">
                                                <?php $__currentLoopData = $info->tags()->groupBy("tags.id")->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="badge badge-pill bg-secondary disable-link"><?php echo e($tag->title); ?></span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </span>
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo e($info->title); ?></h5>

                                                <p class="card-text"><?php echo e($smartpost); ?></p>
                                                <small>
                                                    <?php if($info->dateend < \Illuminate\Support\Facades\Date::today()): ?>
                                                        <span class="float-right w-100 mb-1"><?php echo e($info->datestart); ?>  à <?php echo e($info->dateend); ?></span>
                                                    <?php else: ?>
                                                        <span class="float-right w-100 mb-1">Depuis <?php echo e($info->datestart); ?></span>
                                                    <?php endif; ?>
                                                </small>
                                                <br>
                                                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#<?php echo e(\Illuminate\Support\Str::slug($info->title)); ?>">
                                                    Détails
                                                </button>
                                            </div>
                                        </div>

                                        <!--modal-->
                                        <div class="modal fade" id="<?php echo e(\Illuminate\Support\Str::slug($info->title)); ?>" tabindex="-1" aria-labelledby="<?php echo e(\Illuminate\Support\Str::slug($info->title)); ?>label" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="<?php echo e(\Illuminate\Support\Str::slug($info->title)); ?>label"><?php echo e($info->title); ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php echo $info->description; ?>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        <a href="<?php echo e($info->link); ?>" target="_blank" class="btn btn-primary center-btn">Aller sur le site</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </article><!--//about-section-->


    </div><!--//main-wrapper-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('theme.blog.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\dev\jdgenest\resources\views/theme/blog/about.blade.php ENDPATH**/ ?>