<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\assets;

use yii\web\AssetBundle;

/**
 * This is the modal asset bundle.
 * @author Su Anli <anli@euqol.com>
 * @since 1.0.0
 */
class ModalAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/anli/yii2-helper/';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/modal-popup.js',
        'js/modal-submit.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'css/autocomplete.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
