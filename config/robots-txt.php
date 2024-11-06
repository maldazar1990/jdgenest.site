<?php
return [
    'environments' => [
        'Production' => [
            'paths' => [
                '*' => [
                    'disallow' => [
                        '/images',
                        '/admin',
                        "/build",
                        "/font",
                        "/vendor",

                    ],
                    'allow' => []
                ],
            ],
            'sitemaps' => [
                'sitemap.xml'
            ]
        ],
        'dev' => [
            'paths' => [
                '*' => [
                    'disallow' => [
                        '/images',
                        '/admin',
                        "/build",
                        "/font",
                        "/vendor",

                    ],
                    'allow' => []
                ],
            ],
            'sitemaps' => [
                'sitemap.xml'
            ]
        ]
    ]
];