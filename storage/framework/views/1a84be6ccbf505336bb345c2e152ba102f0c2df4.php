<?php
$arrayNav = [
    [
        "id"=>"tagmenu",
        "name"=>"Tag",
        "icon"=>"fa fa-tags",
        "collapsed"=>(Str::contains(Route::currentRouteName(), 'tag') ? "" : "collapsed"),
        "isShow"=>(Str::contains(Route::currentRouteName(), 'tag') ? "show" : ""),
        "links"=>[
            [
                "icon"=>"fa fa-tag",
                "name"=>"Liste des tags",
                "link"=>route("admin_tags")
            ],
            [
                "icon"=>"fa fa-plus",
                "name"=>"Créer un tag",
                "link"=>route("admin_tags_create")
            ]
        ]
    ],
    [
        "id"=>"postmenu",
        "name"=>"Post",
        "icon"=>"fa fa-newspaper",
        "collapsed"=>(Str::contains(Route::currentRouteName(), 'post') ? "" : "collapsed"),
        "isShow"=>(Str::contains(Route::currentRouteName(), 'post') ? "show" : ""),
        "links"=>[
            [
                "icon"=>"fa fa-newspaper",
                "name"=>"Liste des postes",
                "link"=>route("admin_posts")
            ],
            [
                "icon"=>"fa fa-plus",
                "name"=>"Créer un poste",
                "link"=>route("admin_posts_create")
            ]
        ]
    ],/*
    [
        "id"=>"pagemenu",
        "name"=>"Pages",
        "icon"=>"fa fa-file-text",
        "collapsed"=>(Str::contains(Route::currentRouteName(), 'page') ? "" : "collapsed"),
        "isShow"=>(Str::contains(Route::currentRouteName(), 'page') ? "show" : ""),
        "links"=>[
            [
                "icon"=>"fa fa-file-text",
                "name"=>"Liste des pages",
                "link"=>route("admin_page")
            ],
            [
                "icon"=>"fa fa-plus",
                "name"=>"Créer une page",
                "link"=>route("admin_page_create")
            ]
        ]
    ],*/
    [
        "id"=>"imagemenu",
        "name"=>"Images",
        "icon"=>"fa fa-image",
        "collapsed"=>(Str::contains(Route::currentRouteName(), 'file') ? "" : "collapsed"),
        "isShow"=>(Str::contains(Route::currentRouteName(), 'file') ? "show" : ""),
        "links"=>[
            [
                "icon"=>"fa fa-image",
                "name"=>"Liste des images",
                "link"=>route("admin_files")
            ],
            [
                "icon"=>"fa fa-plus",
                "name"=>"Ajouter une image",
                "link"=>route("admin_files_create")
            ]
        ]
    ],
    [
        "id"=>"commentmenu",
        "name"=>"Commentaire",
        "icon"=>"fa fa-comment",
        "collapsed"=>(Str::contains(Route::currentRouteName(), 'comment') ? "" : "collapsed"),
        "isShow"=>(Str::contains(Route::currentRouteName(), 'comment') ? "show" : ""),
        "links"=>[
            [
                "icon"=>"fa fa-comment",
                "name"=>"Liste des commentaires",
                "link"=>route("admin_comment")
            ]
        ]
    ]
];

if(Auth::user()->hasAnyRole(['admin'])){
    $arrayNav[] = [
        "id"=>"ipban",
        "name"=>"Adresses bannies",
        "icon"=>"fa fa-ban",
        "collapsed"=>(Str::contains(Route::currentRouteName(), 'ipban') ? "" : "collapsed"),
        "isShow"=>(Str::contains(Route::currentRouteName(), 'ipban') ? "show" : ""),
        "links"=>[
            [
                "icon"=>"fa fa-ban",
                "name"=>"Liste des bannis",
                "link"=>route("admin_ipban")
            ]
        ]
    ];
    $arrayNav[] = [
        "id"=>"infosmenu",
        "name"=>"Informations personnelles",
        "icon"=>"fa fa-info",
        "collapsed"=>(Str::contains(Route::currentRouteName(), 'info') ? "" : "collapsed"),
        "isShow"=>(Str::contains(Route::currentRouteName(), 'info') ? "show" : ""),
        "links"=>[
            [
                "icon"=>"fa fa-info",
                "name"=>"Liste des expériences",
                "link"=>route("admin_infos")
            ],
            [
                "icon"=>"fa fa-plus",
                "name"=>"Ajouter une expérience",
                "link"=>route("admin_infos_create")
            ]
        ]
    ];
    $arrayNav[] = [
        "id"=>"msgmenu",
        "name"=>"Messages",
        "icon"=>"fa fa-envelope",
        "collapsed"=>(Str::contains(Route::currentRouteName(), 'msg') ? "" : "collapsed"),
        "isShow"=>(Str::contains(Route::currentRouteName(), 'msg') ? "show" : ""),
        "links"=>[
            [
                "icon"=>"fa fa-envelope",
                "name"=>"Liste des messages",
                "link"=>route("admin_msg")
            ]
        ]
    ];
    $arrayNav[] = [
        "id"=>"rolemenu",
        "name"=>"Rôles",
        "icon"=>"fa fa-user",
        "collapsed"=>(Str::contains(Route::currentRouteName(), 'role') ? "" : "collapsed"),
        "isShow"=>(Str::contains(Route::currentRouteName(), 'role') ? "show" : ""),
        "links"=>[
            [
                "icon"=>"fa fa-user",
                "name"=>"Liste des rôles",
                "link"=>route("admin_role")
            ],
            [
                "icon"=>"fa fa-plus",
                "name"=>"Ajouter un rôle",
                "link"=>route("admin_role_create")
            ]
        ]
    ];
    $arrayNav[] = [
        "id"=>"optionmenu",
        "name"=>"Options",
        "icon"=>"fa fa-cog",
        "collapsed"=>(Str::contains(Route::currentRouteName(), 'option') ? "" : "collapsed"),
        "isShow"=>(Str::contains(Route::currentRouteName(), 'option') ? "show" : ""),
        "links"=>[
            [
                "icon"=>"fa fa-cog",
                "name"=>"Liste des options",
                "link"=>route("admin_options")
            ],
            [
                "icon"=>"fa fa-plus",
                "name"=>"Ajouter une option",
                "link"=>route("admin_options_create")
            ]
            ,/*
            [
                "icon"=>"fa fa-compass",
                "name"=>"Modifier le menu",
                "link"=>"/admin/options/modifyMenu"
            ]*/
        ]
    ];
    $arrayNav[] = [
        "id"=>"usermenu",
        "name"=>"Utilisateurs",
        "icon"=>"fa fa-user",
        "collapsed"=>(Str::contains(Route::currentRouteName(), 'user') ? "" : "collapsed"),
        "isShow"=>(Str::contains(Route::currentRouteName(), 'user') ? "show" : ""),
        "links"=>[
            [
                "icon"=>"fa fa-user",
                "name"=>"Liste des utilisateurs",
                "link"=>route("admin_user_list")
            ],
            [
                "icon"=>"fa fa-plus",
                "name"=>"Ajouter un utilisateur",
                "link"=>route("admin_user_create")
            ]
        ]
    ];

}
?>
<nav class="sidebar col-xs-12 col-sm-4 col-lg-3 col-xl-2 side-menu">
    <h1 class="site-title"><a href="<?php echo e(route("admin")); ?>"><em class="fa fa-rocket"></em>&nbsp;Admin</a>
    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle" style="width:40px;"><em class="fa fa-bars"></em></a>
    <ul class="nav nav-pills flex-column sidebar-nav mt-4 nav flex-nowrap overflow-hidden" id="navgroup">
        <?php $__currentLoopData = $arrayNav; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e($nav["collapsed"]); ?> text-truncate" href="#<?php echo e($nav["id"]); ?>" data-toggle="collapse" data-target="#<?php echo e($nav["id"]); ?>">
                    <em class="<?php echo e($nav["icon"]); ?>"></em>&nbsp;<?php echo e($nav["name"]); ?>

                </a>
                <div class="collapse <?php echo e($nav["isShow"]); ?>" id="<?php echo e($nav["id"]); ?>" aria-expanded="false" data-parent="#navgroup">
                    <ul class="flex-column nav pl-4 ">
                        <?php $__currentLoopData = $nav["links"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e($link["link"]); ?>">
                                    <em class="<?php echo e($link["icon"]); ?>"></em>&nbsp;<?php echo e($link["name"]); ?>

                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <li>
            <a href="<?php echo e(route("get-logout")); ?>" class="logout-button"><em class="fa fa-power-off"></em>&nbsp;Déconnection</a>
        </li>
    </ul>
</nav>
<?php /**PATH C:\dev\jdgenest\resources\views/admin/layouts/navbar.blade.php ENDPATH**/ ?>