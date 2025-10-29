<?php

return [
    'createPost' => [
        'type' => 2,
        'description' => 'Create a post',
    ],
    'updatePost' => [
        'type' => 2,
        'description' => 'Update post',
    ],
    'viewPost' => [
        'type' => 2,
        'description' => 'view post',
    ],
    'deletePost' => [
        'type' => 2,
        'description' => 'delete post',
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'createPost',
            'updatePost',
            'viewPost',
            'deletePost',
        ],
    ],
    'author' => [
        'type' => 1,
        'children' => [
            'createPost',
            'viewPost',
        ],
    ],
];
