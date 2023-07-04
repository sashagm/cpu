<?php

return [
    'cpu_url' => 0,
    'routes' => [
        [
            'name' => 'post',
            'model' => 'App\Models\Post',
            'query' => ['id', 'slug'],
        ],
        [
            'name' => 'user',
            'model' => 'App\Models\User',
            'query' => ['id', 'email'],
        ],
        // другие роуты и модели
    ],
    
];