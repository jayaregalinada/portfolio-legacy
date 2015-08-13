<?php

return [
    'upload' => [
        'basename' => 'uploads/'
    ],
    'images' => [
        'quality' => [
            'jpg' => 90,
            'image' => 80
        ],
        'sizes' => [
            'square' => [
                'size' => 50,
                'suffix' => 'sqr'
            ],
            'thumbnail' => [
                'size' => 500,
                'suffix' => 'thn'
            ],
            'small' => [
                'width' => 150,
                'height' => null,
                'suffix' => 'sml'
            ],
            'medium' => [
                'width' => 300,
                'height' => null,
                'suffix' => 'mdm'
            ],
            'large' => [
                'width' => 600,
                'height' => null,
                'suffix' => 'lrg'
            ],
            'original' => [
                'suffix' => 'org'
            ]
        ]
    ]
];
