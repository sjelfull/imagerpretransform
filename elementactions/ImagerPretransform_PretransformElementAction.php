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

class ImagerPretransform_PretransformElementAction extends BaseElementAction
{
    public function getName ()
    {
        return Craft::t('Pretransform');
    }

    public function isDestructive ()
    {
        return false;
    }

    public function performAction (ElementCriteriaModel $criteria)
    {
        craft()->tasks->createTask('ImagerPretransform_Set', 'Pretransforming assets', [ 'assetIds' => $criteria->ids() ]);
        $this->setMessage(Craft::t('Pretransforming assets'));

        return true;
    }
}