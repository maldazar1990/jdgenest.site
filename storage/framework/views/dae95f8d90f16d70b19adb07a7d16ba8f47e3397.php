<head lang="<?php echo e(config("app.locale")); ?>">
    <?php
    $titleWebsite = config("app.name");

    if (isset($title)) {
        $titleWebsite = $titleWebsite." - ".$title;
    }
    ?>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="msvalidate.01" content="F1D5E61C37FD05432D25AD5F41950533" />
    <link rel="shortcut icon" href="<?php echo e(asset("favicon.ico")); ?>">
    <link rel="preconnect" href="https://www.google.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://www.gstatic.com" crossorigin>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="preload" href="https://www.google.com/recaptcha/api.js" as="script"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php if(isset($SEOData)): ?>
        <?php echo seo($SEOData); ?>

    <?php endif; ?>
    <link id="theme-style" rel="stylesheet" href="<?php echo e(mix("front/css/app.css")); ?>?v=<?php echo e(microtime()); ?>">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-7KD2V1XCQF"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '<?php echo e(config("app.google_analytics")); ?>');
    </script>
    <link rel="preload"  load href="<?php echo e(mix("front/js/app.js")); ?>" as="script"/>
    <script src="<?php echo e(mix("front/js/app.js")); ?>" defer></script>
</head>
<?php /**PATH C:\dev\jdgenest\resources\views/theme/blog/layout/head.blade.php ENDPATH**/ ?>