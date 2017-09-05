<?php
/**
 * Imager Pretransform plugin for Craft CMS
 *
 * Pretransform any Assets on save, with Imager
 *
 * @author    Superbig
 * @copyright Copyright (c) 2017 Superbig
 * @link      https://superbig.co
 * @package   ImagerPretransform
 * @since     1.0.0
 */

namespace Craft;

class ImagerPretransformPlugin extends BasePlugin
{
    /**
     * @return mixed
     */
    public function init ()
    {
        parent::init();

        craft()->on('elements.onSaveElement', function (Event $event) {
            $element = $event->params['element'];

            if ( $element->getElementType() === 'Asset' ) {
                craft()->imagerPretransform->onSaveAsset($event->params['element']);
            }
        });
    }

    /**
     * @return mixed
     */
    public function getName ()
    {
        return Craft::t('Imager Pretransform');
    }

    /**
     * @return mixed
     */
    public function getDescription ()
    {
        return Craft::t('Pretransform any Assets on save, with Imager');
    }

    /**
     * @return string
     */
    public function getDocumentationUrl ()
    {
        return 'https://superbig.co/plugins/imager-pretransform';
    }

    /**
     * @return string
     */
    public function getReleaseFeedUrl ()
    {
        return 'https://superbig.co/plugins/imager-pretransform/feed';
    }

    /**
     * @return string
     */
    public function getVersion ()
    {
        return '1.0.3';
    }

    /**
     * @return string
     */
    public function getSchemaVersion ()
    {
        return '1.0.0';
    }

    /**
     * @return string
     */
    public function getDeveloper ()
    {
        return 'Superbig';
    }

    /**
     * @return string
     */
    public function getDeveloperUrl ()
    {
        return 'https://superbig.co';
    }

    public function addAssetActions()
    {
        $actions = [];
        $actions[] = 'ImagerPretransform_Pretransform';

        return $actions;
    }
}