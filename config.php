<?php
return [
    'transforms' => [
        'images' => [
            [
                'width' => 1400,
            ],
            [
                'width'       => 600,
                'jpegQuality' => 65
            ],
            [
                'width'       => 380,
                'height'      => 380,
                'mode'        => 'crop',
                'position'    => 'center-center',
                'jpegQuality' => 65
            ],

            'defaults' => [

            ],

            'configOverrides' => [
                'resizeFilter'         => 'catrom',
                'instanceReuseEnabled' => true,
            ]
        ]
    ]
];