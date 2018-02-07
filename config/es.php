<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Elasticsearch Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the Elasticsearch connections below you wish
    | to use as your default connection for all work. Of course.
    |
    */

    'default' => env('ELASTIC_CONNECTION', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Elasticsearch Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the Elasticsearch connections setup for your application.
    | Of course, examples of configuring each Elasticsearch platform.
    |
    */

    'connections' => [

        'default' => [

            'servers' => [

                [
                    "host" => env("ELASTIC_HOST", "127.0.0.1"),
                    "port" => env("ELASTIC_PORT", 9200),
                    'scheme' => env('ELASTIC_SCHEME', 'http'),
                ]

            ],

            'index' => env('ELASTIC_INDEX', 'laravel-blank')

        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Elasticsearch Indices
    |--------------------------------------------------------------------------
    |
    | Here you can define your indices, with separate settings and mappings.
    | Edit  asetting and mappingnd run 'php artisan es:index:update' to update
    | indices on elasticsearch server.
    |
    | 'my_index' is just for test. Replace it with a real index name.
    |
    */

    'indices' => [


        env('ELASTIC_INDEX', 'laravel-blank') => [

            "aliases" => [
                "goldeneagle"
            ],

            'settings' => [
                "number_of_shards" => 2,
                "number_of_replicas" => 2,
//                'index' => [
//                    'sort.field' => ['publish_date', 'date'],
//                    'sort.order' => ['desc', 'desc']
//                ]
            ],

            'mappings' => [
                'posts' => [
                    "properties" => [
                        'post_id' => [
                            'type' => 'long',
                        ],
                        'author' => [
                            'type' => 'string',
                        ],
                        'author_email' => [
                            'type' => 'string',
                        ],
                        'author_id' => [
                            'type' => 'integer',
                            #'eager_global_ordinals' => true,
                        ],
                        'title' => [
                            'type' => 'text'
                        ],
                        'permalink' => [
                            'type' => 'keyword',
                        ],
                        'keyword' => [
                            'type' => 'string',
                        ],
                        'excerpt' => [
                            'type' => 'text'
                        ],
                        'featured_image' => [
                            'type' => 'string',
                        ],
                        'body' => [
                            'type' => 'text'
                        ],
                        'publish_date' => [
                            'type' => 'date',
                            'format' => 'strict_date_optional_time||epoch_millis',
                            #'eager_global_ordinals' => true,
                        ],
                    ]
                ],
            ]
        ],


    ]

];
