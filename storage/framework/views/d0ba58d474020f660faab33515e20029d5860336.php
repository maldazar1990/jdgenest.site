<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <?php if(session('status')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                    <table>
                        <thead>
                            <tr>
                                <th>sujet</th>
                                <th>statistiques</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nombre de posts</td>
                                <td>
                                    <a href="<?php echo e(route("admin_posts")); ?>">
                                       <?php echo e(\App\post::count()); ?>

                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Nombre d'images</td>
                                <td>
                                    <a href="<?php echo e(route("admin_files")); ?>">
                                        <?php echo e(count(\App\HelperGeneral::getImages())); ?>

                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Nombre de messages</td>
                                <td>
                                    <a href="<?php echo e(route("admin_msg")); ?>">
                                        <?php echo e(\App\Contact::count()); ?>

                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Nombre d'ip ban</td>
                                <td>
                                        <?php echo e(\Illuminate\Support\Facades\DB::table("firewall_ips")->select('ip')->distinct()->get()->count()); ?>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\dev\jdgenest\resources\views/admin/home.blade.php ENDPATH**/ ?>