<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\assets;

use yii\web\AssetBundle;

/**
 * This is the ajax update asset bundle.
 * @author Su Anli <anli@euqol.com>
 * @since 1.2.0
 */
class AjaxUpdateAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/anli/yii2-helper/';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/ajax-update.js',
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
