# Imager Pretransform plugin for Craft CMS

Pretransform any Assets on save, with Imager

![Screenshot](resources/icon@2x.png)

## Installation

To install Imager Pretransform, follow these steps:

1. Download & unzip the file and place the `imagerpretransform` directory into your `craft/plugins` directory
4. Install plugin in the Craft Control Panel under Settings > Plugins
5. The plugin folder should be named `imagerpretransform` for Craft to see it.

Imager Pretransform works on Craft 2.4.x and Craft 2.5.x.

## Imager Pretransform Overview

If you have suffered from memory or execution time issues when creating many transforms on demand, you should look into pre-generating transforms per image.

This plugin, combined with a long cache duration time, will make sure transforms will only be generated once, and one at a time.

When users upload an Asset, a task will be created, which in turn will use Imager to pre-generate the transform(s).

## Configuring Imager Pretransform

You can either have a set of transforms per Asset source handle:

```
<?php
return [
    'transforms' => [
        // Images source, with handle images
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
        ],

        'anotherSourceHandle' => [
            [
                'height' => 600
            ]
        ]
    ]
];
```

Or just a set of transforms that will be applied to all Assets on upload/save:

```
<?php
return [
    'transforms' => [
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

        'defaults' => [],
        'configOverrides' => []
    ]
];
```

You should also set Imager's cache duration to a long time, say 1 year:

In imager.php:

```
'cacheDuration' => 31536000, // 1 year
```


Brought to you by [Superbig](https://superbig.co)
