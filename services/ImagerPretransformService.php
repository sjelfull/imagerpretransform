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
        ImagerPretransformPlugin::log('Creating task for asset #' . $asset->id, LogLevel::Info, true);
        craft()->tasks->createTask('ImagerPretransform', 'Pretransforming Asset #' . $asset->id, [ 'assetId' => $asset->id ]);
    }

    public function transformAsset (AssetFileModel $asset)
    {
        $sourceHandle      = $asset->getSource()->handle;
        $transforms        = $this->getTransforms($sourceHandle);
        $transformDefaults = null;
        $configOverrides   = null;

        ImagerPretransformPlugin::log('Transforming asset #' . $asset->id . '- ' . json_encode($transforms), LogLevel::Info, true);

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

            ImagerPretransformPlugin::log('Transforming asset #' . $asset->id . '- ' . json_encode($transforms), LogLevel::Info, true);

            craft()->imager->transformImage($asset, $transforms, $transformDefaults, $configOverrides);
        }
    }

    public function getTransforms ($sourceHandle = null)
    {
        $transforms = craft()->config->get('transforms', 'imagerpretransform');

        // Check if there is a transform set for this specific Asset source handle
        if ( !empty($transforms[ $sourceHandle ]) ) {
            return $transforms[ $sourceHandle ];
        }

        return $transforms;
    }

}