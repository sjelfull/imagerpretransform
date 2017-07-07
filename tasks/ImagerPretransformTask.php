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

class ImagerPretransformTask extends BaseTask
{
    /**
     * @access protected
     * @return array
     */

    protected function defineSettings ()
    {
        return array(
            'assetId' => AttributeType::Number,
        );
    }

    /**
     * @return string
     */
    public function getDescription ()
    {
        return 'ImagerPretransform Tasks';
    }

    /**
     * @return int
     */
    public function getTotalSteps ()
    {
        return 1;
    }

    /**
     * @param int $step
     *
     * @return bool
     */
    public function runStep ($step)
    {
        $asset = craft()->assets->getFileById($this->getSettings()->assetId);

        if ( $asset ) {
            craft()->imagerPretransform->transformAsset($asset);
        }

        return true;
    }
}
