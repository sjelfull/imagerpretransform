<?php
/**
 * Imager Pretransform plugin for Craft CMS
 *
 * ImagerPretransform Service
 *
 * @author    Superbig
 * @copyright Copyright (c) 2017 Superbig
 * @link      https://superbig.co
 * @package   ImagerPretransform
 * @since     1.0.0
 */

namespace Craft;

class ImagerPretransformService extends BaseApplicationComponent
{
    public function onSaveAsset (AssetFileModel $asset)
    {
        if ($asset->kind === 'image') {
            craft()->tasks->createTask('ImagerPretransform', 'Pretransforming Asset #' . $asset->id, [ 'assetId' => $asset->id ]);
        }
    }

    public function transformAsset (AssetFileModel $asset)
    {
        if ($asset->kind !== 'image') {
            return true;
        }

        $sourceHandle      = $asset->getSource()->handle;
        $transforms        = $this->getTransforms($sourceHandle, $asset);
        $transformDefaults = null;
        $configOverrides   = null;

        if ( !empty($transforms) ) {
            // If there is any defaults/config overrides, get them
            if ( isset($transforms['defaults']) ) {
                $transformDefaults = $transforms['defaults'];
                unset($transforms['defaults']);
            }

            // If there is any defaults/config overrides, get them
            if ( isset($transforms['configOverrides']) ) {
                $configOverrides = $transforms['configOverrides'];
                unset($transforms['configOverrides']);
            }

            craft()->imager->transformImage($asset, $transforms, $transformDefaults, $configOverrides);
        }
    }

    public function getTransforms ($sourceHandle = null, AssetFileModel $asset)
    {
        $transforms = craft()->config->get('transforms', 'imagerpretransform');

        // Check if there is a transform set for this specific Asset source handle
        if ( !empty($transforms[ $sourceHandle ]) ) {
            $transforms = $transforms[ $sourceHandle ];
        }

        $transforms = array_map(function ($settings) use ($asset) {
            return array_map(function ($setting) use ($asset) {
                return is_callable($setting) ? $setting($asset) : $setting;
            }, $settings);
        }, $transforms);

        ImagerPretransformPlugin::log(json_encode($transforms), LogLevel::Info);

        return $transforms;
    }

}