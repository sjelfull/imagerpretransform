<?php
/**
 * Imager Pretransform plugin for Craft CMS
 *
 * ImagerPretransform Command
 *
 * @author    Superbig
 * @copyright Copyright (c) 2017 Superbig
 * @link      https://superbig.co
 * @package   ImagerPretransform
 * @since     1.0.0
 */

namespace Craft;

class ImagerPretransformCommand extends BaseCommand
{
    /**
     */
    public function actionIndex ($sourceHandle = null, $folderId = null)
    {
        $assets = [ ];

        if ( empty($sourceHandle) && empty($folderId) ) {
            echo "No source handle or folderId was specified";
            exit(0);
        }

        if ( !empty($sourceHandle) ) {
            $sources = craft()->assetSources->getAllSources();
            $source  = null;

            foreach ($sources as $sourceCheck) {
                if ( $sourceCheck->handle === $sourceHandle ) {
                    $source = $sourceCheck;
                    break;
                }
            }

            if ( $source ) {
                $assets = craft()->assets->getFilesBySourceId($source->id);
            }
        }

        if ( !empty($folderId) ) {
            $assets = $this->getFilesFromFolderId($folderId);
        }

        if ( empty($assets) ) {
            echo "No assets found";
            exit(0);
        }

        foreach ($assets as $asset) {
            craft()->imagerPretransform->transformAsset($asset);
        }

        echo "Done.";
        exit(0);
    }

    private function getFilesFromFolderId ($folderId = null)
    {
        $files = craft()->db->createCommand()
                            ->select('fi.*')
                            ->from('assetfiles fi')
                            ->join('assetfolders fo', 'fo.id = fi.folderId')
                            ->where('fi.folderId = :folderId', array( ':folderId' => $folderId ))
                            ->order('fi.filename')
                            ->queryAll();

        return AssetFileModel::populateModels($files, $indexBy = null);
    }
}