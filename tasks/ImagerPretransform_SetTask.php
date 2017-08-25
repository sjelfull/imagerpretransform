<?php
/**
 * Imager Pretransform plugin for Craft CMS
 *
 * ImagerPretransform Task
 *
 * @author    Superbig
 * @copyright Copyright (c) 2017 Superbig
 * @link      https://superbig.co
 * @package   ImagerPretransform
 * @since     1.0.0
 */

namespace Craft;

class ImagerPretransform_SetTask extends BaseTask
{
    /**
     * @access protected
     * @return array
     */

    protected function defineSettings ()
    {
        return array(
            'assetIds' => AttributeType::Mixed,
        );
    }

    /**
     * @return string
     */
    public function getDescription ()
    {
        return 'Imager Pretransform';
    }

    /**
     * @return int
     */
    public function getTotalSteps ()
    {
        return count($this->getSettings()->assetIds);
    }

    /**
     * @param int $step
     *
     * @return bool
     */
    public function runStep ($step)
    {
        $asset = craft()->assets->getFileById($this->getSettings()->assetIds[ $step ]);

        if ( $asset ) {
            craft()->imagerPretransform->transformAsset($asset);
        }

        return true;
    }
}
