@php
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
@endphp
<nav class="sidebar col-xs-12 col-sm-4 col-lg-3 col-xl-2 side-menu">
    <h1 class="site-title"><a href="{{route("admin")}}"><em class="fa fa-rocket"></em>&nbsp;Admin</a>
    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle" style="width:40px;"><em class="fa fa-bars"></em></a>
    <ul class="nav nav-pills flex-column sidebar-nav mt-4 nav flex-nowrap overflow-hidden" id="navgroup">
        @foreach($arrayNav as $nav)
            <li class="nav-item">
                <a class="nav-link {{$nav["collapsed"]}} text-truncate" href="#{{$nav["id"]}}" data-toggle="collapse" data-target="#{{$nav["id"]}}">
                    <em class="{{$nav["icon"]}}"></em>&nbsp;{{$nav["name"]}}
                </a>
                <div class="collapse {{$nav["isShow"]}}" id="{{$nav["id"]}}" aria-expanded="false" data-parent="#navgroup">
                    <ul class="flex-column nav pl-4 ">
                        @foreach($nav["links"] as $link)
                            <li class="nav-item">
                                <a class="nav-link" href="{{$link["link"]}}">
                                    <em class="{{$link["icon"]}}"></em>&nbsp;{{$link["name"]}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
        @endforeach
        <li>
            <a href="{{route("get-logout")}}" class="logout-button"><em class="fa fa-power-off"></em>&nbsp;Déconnection</a>
        </li>
    </ul>
</nav>
