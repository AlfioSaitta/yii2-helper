<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\assets;

use yii\web\AssetBundle;

/**
 * This is the show confirm alert asset bundle.
 * @author Su Anli <anli@euqol.com>
 * @since 2.0.0
 */
class ShowConfirmAlertAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/anli/yii2-helper/';

    /**
     * @inheritdoc
     */
    public $css = [
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'js/show-confirm-alert.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'anli\helper\assets\SweetAlertAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
