<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\helper\assets;

use yii\web\AssetBundle;

/**
 * This is the toastr asset bundle.
 * @author Su Anli <anli@euqol.com>
 * @since 2.0.0
 */
class ToastrAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@bower/toastr/';

    /**
     * @inheritdoc
     */
    public $css = [
        'toastr.min.css',
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'toastr.min.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
